<?php

namespace App\Http\Controllers;

use App\{
    Models\User
};
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PaidSessionController extends Controller
{

    private $chat;
    public function __construct()
    {
        $this->chat = App::make('chat');
    }

    /*** PER MINUTE CHAT ACTIONS ***/
    public function actionsPerMinuteChat(Request $request){
        if ($request->acceptOrReject == 'no') {
            DB::table('paid_session_notifications')
                ->where('id', '=', $request->sessionId)
                ->update(['accept' => 0, 'is_seen' => 1]);
        }
        if ($request->acceptOrReject == 'yes') {
            DB::table('paid_session_notifications')
                    ->where('id', '=', $request->sessionId)
                ->update(['accept' => 1, 'is_seen' => 1,'session_status' => 2]);
            DB::table('users')
                    ->where('id', '=', Auth::user()->id)
                ->update(['expert_status' => 1]);

            $req = DB::table('paid_session_notifications')
                ->where('id', '=', $request->sessionId)->get();

            $conversation = $this->chat->createConversation([Auth::user()->id, $req[0]->user_id]);
            $request->session()->push('client_id', Auth::user()->id);
            $request->session()->push('expert_id', $req[0]->user_id);
            return $conversation->id;
        }
        if ($request->acceptOrReject == 'pending') {
            DB::table('paid_session_notifications')
                ->where('id', '=', $request->sessionId)
                ->update(['accept' => 0, 'is_seen' => 1,'session_status' => 5]);
            return 0;
        }
    }

    public function checkRequests(){

        $notifications = DB::table('paid_session_notifications')->where('expert_id','=',Auth::user()->id)->where('is_seen','=',0)->get();
        DB::table('paid_session_notifications')->where('expert_id','=',Auth::user()->id)->update(['is_seen'=>1]);
        $usersWantToChat = array();
        $index = 0;
        foreach ($notifications as $sessionInfo){
            $usersWantToChat[$index]['user'] = DB::table('users')->where('id','=',$sessionInfo->user_id)->get()[0];
            $usersWantToChat[$index]['sessionId'] = $sessionInfo->id;
            $index++;
        }
        return $usersWantToChat;
    }

    public function waitExpertResponse(Request $request){
        $expertResponse = DB::table('paid_session_notifications')
                ->where('user_id','=',Auth::user()->id)
                ->where('expert_id','=',$request->userToWait)
            ->get();
        if($expertResponse[0]->accept == 1){
            DB::table('users')
                ->where('id', '=',$request->userToWait)
                ->update(['expert_status' => 1]);
        }

        return $expertResponse;
    }


    /**
     * @param Request $request
     *
     *  session status
     *  -1 def
     *  0 quit
     *  1 user adding funds
     *  2 going on
     */
    public function endConversation(Request $request){
        $expert_id = $request->expert_id;
        DB::table('users')
            ->where('id', '=',$expert_id )
            ->update(['expert_status' => 0]);
        DB::table('paid_session_notifications')
            ->where('id', '=', $request->session_id)
            ->update(['session_status' => 0]);
        DB::table('main_session_infos')->insert(['expert_id'=>$expert_id,'user_id'=>Auth::user()->id,'session_length'=>'test','session_spend_money'=>'test']);
    }

    public function sendRequest(Request $request)
    {

        $checkIfBlocked = DB::table('blocked_users')->where('user_id','=',Auth::user()->id)->first();
        if(!empty($checkIfBlocked))return 3;


        $notBusyExpert = DB::table('users')
                ->where('id', '=', $request->userId)
                ->where('expert_status', '=', 0)
            ->get();


        if (!empty($notBusyExpert[0])) {

            $notification = DB::table('paid_session_notifications')
                    ->where('expert_id', '=', $request->userId)
                    ->where('user_id', '=', Auth::user()->id)
                ->get();



            if (empty($notification[0])) {
                $notificationId = DB::table('paid_session_notifications')->insertGetId(
                    ['expert_id' => $request->userId, 'user_id' => Auth::user()->id]
                );


                DB::table('histories')->insert(
                    [  'expert_id' => $request->userId, 'user_id' => Auth::user()->id,'type' =>1,'conversation_id' => $notificationId]
                );

                $request->session()->push('client_id', Auth::user()->id);
                $request->session()->push('expert_id', $request->userId);
                return 0;
            }
            return 1;
        } else {

            return 2;
        }
    }

    public function checkIfSessionEnded(Request $request)
    {
        $status = DB::table('paid_session_notifications')
                ->where('id', '=', $request->sId)
            ->get();
        if ($status[0]->session_status == 0 || $status[0]->session_status ==null) {
            return 0;
        } else if ($status[0]->session_status == 1) {
            return 1;
        } else if ($status[0]->session_status == 2) {
            return 2;
        }
        else if ($status[0]->session_status == 3) {
            return 3;
        }
        else if ($status[0]->session_status == 5) {
            return 5;
        }
        else if ($status[0]->session_status == 6) {
            return 6;
        }
        else {
            return -1;
        }
    }

    public function sessionActions(Request $request)
    {
        $session_id = $request->sId;
        $session_status = $request->session_status;


        DB::table('paid_session_notifications')
            ->where('id', '=', $session_id)
            ->update([
                'session_status' => $session_status
            ]);
        return 0;
    }

    public function addFundsToSession(Request $request){
        DB::table('paid_session_notifications')->where('id','=',$request->sId)->update([
            'session_status' => 2
        ]);
        return 0;
    }


    public function sendMessageToUserPaidSession(Request $request){
        $userId = Auth::user()->id;
        $requestUserId = $request->userId;
        $text = $request->textToSend;
        $conv = $this->chat->getConversationBetween($userId, $requestUserId);

        $this->chat->message($text)->from($userId)->to($conv)->send();
        $message = DB::table('mc_messages')
                ->where('conversation_id', '=', $conv->id)
                ->where('user_id', '=', $userId)
                ->orderBy('id', 'desc')
                ->limit(1)
            ->get();

        DB::table('mc_message_notification')->insert(
            ['message_id' => $message[0]->id, 'conversation_id' => $conv->id, 'user_id' => $requestUserId, 'is_seen' => '0', 'is_sender' => 0]
        );
    }


    public function rateSession(Request $request){
        $mytime = Carbon::now();
        ////status 0- later
        /// status 1- now
        $session_id = $request->session_id;
        $rate=$request->rates;
        $status=$request->status;
        $text=$request->text;
        $user_id=Auth::id();
        $expert_id=$request->expert_id;
        DB::table('paid_session_notifications')
            ->where('id', '=', $session_id)
            ->delete();


        DB::table('paid_session_ratings')
            ->insert([
                'user_id' => $user_id,
                'session_notification_id' => $session_id,
                'rate' => $rate,
                'expert_id'=>$expert_id,
                'text' => $text,
                'status'=>$status,
                'created_at' => $mytime->toDateTimeString()
            ]);

        try {
            $id = $this->chat->getConversationBetween(Auth::user(), $expert_id)->id;
            if ($id) {
                DB::table('mc_messages')->where('conversation_id', '=', $id)->delete();
                DB::table('mc_conversations')->where('id', '=', $id)->delete();
                DB::table('conversation_subjects')->where('conversation_id', '=', $id)->delete();
                DB::table('mc_conversation_user')->where('conversation_id', '=', $id)->delete();
            }
        } catch (\Exception $e) {
            echo 'c';
        }
        return back();
    }

    public function conversationDelete(Request $request){
        $client_id=$request->client_id;
        $session_id = $request->session_id;
        $id = $this->chat->getConversationBetween(Auth::user(), $client_id)->id;
        DB::table('paid_session_notifications')
            ->where('id', '=', $session_id)
            ->delete();
        DB::table('mc_messages')->where('conversation_id', '=', $id)->delete();
        DB::table('mc_conversations')->where('id', '=', $id)->delete();
        DB::table('conversation_subjects')->where('conversation_id', '=', $id)->delete();
        DB::table('mc_conversation_user')->where('conversation_id', '=', $id)->delete();
    }



    ///////////////////////////// refresh notes after refresh ///////////////////////////////////////

    public function conversationPaidDelete(Request $request)
    {
        $expert_id = $request->session()->get('expert_id')[0];
        $client_id = $request->session()->get('client_id')[0];

        $user=Auth::user();
        //////////user checking ////////////
        if(isset($user)){
            if($user->role=='client'){
                DB::table('paid_session_notifications')
                    ->where('user_id','=',$user->id)
                    ->orWhere('session_status','=','-1')
                    ->delete();
            }else if($user->role=='expert'){
                DB::table('paid_session_notifications')
                    ->where('expert_id','=',$user->id)
                    ->orWhere('session_status','=','-1')
                    ->delete();
            }
        }
        else{
            DB::table('paid_session_notifications')
                ->where('session_status','=','-1')
                ->delete();
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////
        if ($client_id != null && $expert_id != null) {
            try {
                $id = $this->chat->getConversationBetween($client_id, $expert_id)->id;
                if ($id) {
                    DB::table('mc_messages')->where('conversation_id', '=', $id)->delete();
                    DB::table('mc_conversations')->where('id', '=', $id)->delete();
                    DB::table('conversation_subjects')->where('conversation_id', '=', $id)->delete();
                    DB::table('mc_conversation_user')->where('conversation_id', '=', $id)->delete();
                }
            } catch (\Exception $e) {
                echo 'c';
            }
            $request->session()->forget('expert_id');
            $request->session()->forget('client_id');
            $request->session()->flush();
        }
    }


    public function checkUserBalanceBeforeChat(Request $request){
        $userFunds = Auth::user()->funds;
        $reqUserFunds = DB::table('users')->where('id','=',$request->userId)->first()->fee_chat;
        if($reqUserFunds > $userFunds){
            return 1;
        }
        return 0;
    }




    public function changeStatusAndSaveToCall(Request $request){
        $date = Carbon::now()->toArray();

        $isArray = $request->idArray;
        $idSessions = $request->idSessions;


        foreach ($isArray as $id){
            DB::table('histories')->insert(
                [  'expert_id' => Auth::user()->id, 'user_id' => $id, 'type' => 1 , 'created_at' => $date['formatted'], 'type' =>1,'conversation_id' => 0 , 'status' => -2]
            );
        }
        foreach ($idSessions as $id) {
            DB::table('paid_session_notifications')->where('id', '=',$id)->update(['session_status' => 5]);
        }

        return 0;
    }




    public function changeChatStatusToHangUpUserSide(Request $request){
        DB::table('paid_session_notifications')->where('expert_id','=',$request->sId)->where('user_id','=',Auth::id())->update(['session_status'=>6]);

    }
    public function changeChatStatusToHangUpExpertSide(Request $request){
        DB::table('paid_session_notifications')->where('user_id','=',$request->sId)->where('expert_id','=',Auth::id())->update(['session_status'=>6]);

    }


}
