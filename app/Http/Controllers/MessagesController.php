<?php

namespace App\Http\Controllers;

use App\{
    Models\User, Payments
};
use Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;



class MessagesController extends Controller
{

    private $chat;
    private $tableMessages;
    private $tableUsers;
    private $tableMessageNotofications;
    private $tableConversations;
    private $tableConversationUser;
    private $tableSubjects;
    private $history;


    public function __construct()
    {
        $this->history = DB::table('histories');
        $this->chat = App::make('chat');
        $this->tableMessages = DB::table('mc_messages');
        $this->tableUsers = DB::table('users');
        $this->tableMessageNotofications = DB::table('mc_message_notification');
        $this->tableConversations = DB::table('mc_conversations');
        $this->tableSubjects = DB::table('conversation_subjects');
        $this->tableConversationUser = DB::table('mc_conversation_user');
    }

    public function showMessagesPage()
    {

        if (!Auth::user()) throw new AuthenticationException();
        Auth::user()->is_typing = 'notTyping';
        Auth::user()->save();
        /*** CREATE CONVERSATION ***/
        $users = User::all()->except(Auth::id());
        $usersHaveConversation = array();
        $conversationSubjects = array();
        $unseeMessages = array();
        $blockedOrNot = array();
        $conversationIds = array();
        $messagesInConversation = null;
        $first = true;
        $invoiceCount=0;

        if(Auth::user()->role=='expert'){
            $invoiceAmount=DB::table('invoices')
                ->where('invoices.expert_id','=',Auth::id())
                ->get();
        }
        else{
            $invoiceAmount=DB::table('invoices')
                ->where('invoices.user_id','=',Auth::id())
                ->get();
        }



        foreach ($users as $u) {
            $conversation = $this->chat->getConversationBetween(Auth::user()->id, $u->id);
            if (!empty($conversation)) {
                array_push($usersHaveConversation, $u);
                array_push($blockedOrNot, $conversation->is_blocked);
                array_push($conversationIds, $conversation->id);
                $subject = DB::table('conversation_subjects')
                    ->where('conversation_id', '=', $conversation->id)
                    ->get();
                array_push($conversationSubjects, $subject[0]->subject_name);
                $notificationsCount = $this->tableMessageNotofications
                    ->where('conversation_id', '=', $conversation->id)
                    ->where('user_id', '=', Auth::user()->id)
                    ->where('is_seen', '=', 0)
                    ->get();
                array_push($unseeMessages, count($notificationsCount));
                if ($first == true) {
                    $messages = DB::table('mc_messages')
                        ->join('users','mc_messages.user_id','=','users.id')
                        ->where('conversation_id', '=', $conversation->id)
                        ->where('user_id', '=', Auth::user()->id)
                        ->orWhere('user_id', '=', $u->id)
                        ->get();
                    $messagesInConversation = $messages;
                    $first = false;
                }
            }
        }
        $user = Auth::user();
        return view('front.message', compact('usersHaveConversation','invoiceAmount', 'messagesInConversation', 'user', 'conversationSubjects', 'unseeMessages', 'blockedOrNot', 'conversationIds'));
    }


    public function addInvoice(Request $request){
        if($request->amount){
            DB::table('invoices')->insert([
                'expert_id'=>Auth::id(),
                'user_id'=>$request->user_id,
                'amount'=>$request->amount,
            ]);
            return redirect('/messages');
        }
    }

    public function payInvoice(Request $request){

        if($request->amount){

            $fund = Auth::user()->funds;
            $diff = $fund - $request->amount;
            if($diff<0 && $request->status!=0)
                $request->status=3;
            DB::table('invoices')
                ->where('id', '=', $request->invoice_id)
                ->update(['status'=>$request->status]);
            /////////accepted/////////////
            if($request->status==1){
                if( $diff  >= 0 ) {
                    Auth::user()->funds = $diff;
                    Auth::user()->save();
                    $moneyExpert = DB::table('users')->where('id', '=', $request->expert_id)->get()[0]->funds;
                    DB::table('users')->where('id', '=', $request->expert_id)->update(['funds' => $moneyExpert + ($request->amount / 2)]);
                    $money = DB::table('admin')->where('id', '=', 1)->get()[0]->totalMoney;
                    DB::table('admin')->where('id', '=', 1)->update(['totalMoney' => $money + ($request->amount / 2)]);
                    DB::table('paid_session_notifications')->where('id', '=', $request->sessionID)->update(['session_status' => 2]);
                    $payment = new Payments();
                    $payId = md5(uniqid('payment'.rand(), true));
                    $t=time();
                    $payment->user_id = Auth::user()->id;
                    $payment->payment_id = $payId;
                    $payment->create_time = date("Y-m-d",$t);
                    $payment->pay_method = 'paypal';
                    $payment->status = 'Verified';
                    $payment->total = $request->amount;
                    $payment->currency = "USD";
                    $payment->description = "Payment For Invoice In Chat";
                    $payment->pay_type = 2;
                    $payment->expert_id = $request->expert_id;
                    $payment->expert_balance = $moneyExpert;
                    $payment->session_id =0;
                    $payment->user_balance = $fund;
                    $payment->save();
                }
            }
        }
        /////////rejected/////////////
        return redirect('/messages');

    }



    public function sendMessageToUser(Request $request){
        if ($this->chat->getConversationBetween(Auth::user()->id, $request->userId)->is_blocked == 'yes') return 0;

        $this->chat->message($request->textToSend)->from(Auth::user())->to($this->chat->getConversationBetween(Auth::user()->id, $request->userId))->send();
        $message = $this->tableMessages
            ->where('conversation_id', '=', $this->chat->getConversationBetween(Auth::user()->id, $request->userId)->id)
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get();
        $this->tableMessageNotofications->insert(
            ['message_id' => $message[0]->id, 'conversation_id' => $this->chat->getConversationBetween(Auth::user()->id, $request->userId)->id, 'user_id' => $request->userId, 'is_seen' => '0', 'is_sender' => 0]
        );

        return 1;
    }

    public function getConversationBetweenTwoUsers(Request $request)
    {
        $messages = DB::table('mc_messages')
            ->join('users','mc_messages.user_id','=','users.id')
            ->where('conversation_id', '=', $request->idConv)
            ->get();
        return $messages;
    }

    public function userIsTyping()
    {
        Auth::user()->is_typing = 'typing';
        Auth::user()->save();
    }

    public function userIsNotTyping()
    {
        Auth::user()->is_typing = 'notTyping';
        Auth::user()->save();
    }

    public function getUnreadMessages(Request $request)
    {
        if ($this->tableUsers->where('id', '=', $request->id)->get()[0]->is_typing == 'typing') return 0;
        $unreadMessages = $this->tableMessageNotofications
            ->where('conversation_id', '=', $this->chat->getConversationBetween(Auth::user()->id, $request->id)->id)
            ->where('user_id', '=', Auth::user()->id)
            ->where('is_seen', '=', 0)
            ->get();
        $secondUser=$this->tableUsers->where('id', '=', $request->id)->first();
        $secondUserAv=$secondUser->screen_name;
        if(!empty($secondUser->avatar))
            $secondUserAv=$secondUser->avatar;
        if (!empty($unreadMessages)) {
            $messages = array();
            $index=0;
            foreach ($unreadMessages as $um) {
                $messages[$index]['message']=$this->chat->messageById($um->message_id);
                $messages[$index]['avatar']=$secondUserAv;
                $index++;
                $this->tableMessageNotofications
                    ->where('id', $um->id)
                    ->delete();
            }
            return $messages;
        }
    }


    public function getUnreadMessagesForPerMinuteChat(Request $request)
    {
        if ($this->tableUsers->where('id', '=', $request->id)->get()[0]->is_typing == 'typing') return 0;

        $unreadMessages = $this->tableMessageNotofications
            ->where('conversation_id', '=', $this->chat->getConversationBetween(Auth::user()->id, $request->id)->id)
            ->where('user_id', '=', Auth::user()->id)
            ->where('is_seen', '=', 0)
            ->get();

        if (!empty($unreadMessages)) {
            $messages = array();

            foreach ($unreadMessages as $um) {
                array_push($messages, $this->chat->messageById($um->message_id));

                $this->tableMessageNotofications
                    ->where('id', $um->id)
                    ->delete();
            }
            return $messages;
        }
    }

    public function getUnreadMessagesPerMinuteChat(Request $request)
    {
        $userId = Auth::user()->id;
        $unreadMessages = $this->tableMessageNotofications
            ->where('conversation_id', '=', $this->chat->getConversationBetween($userId, $request->id)->id)
            ->where('user_id', '=', $userId)
            ->where('is_seen', '=', 0)
            ->get();

        if (!empty($unreadMessages)) {
            $messages = array();

            foreach ($unreadMessages as $um) {
                array_push($messages, $this->chat->messageById($um->message_id));

                $this->tableMessageNotofications
                    ->where('id', $um->id)
                    ->delete();
            }
            return $messages;
        }
    }








    public function findUser(Request $request)
    {
        return $this->tableUsers
            ->where('id', '!=', Auth::user()->id)
            ->where('screen_name', 'like', "%" . $request->screenName . "%")
            ->get();
    }

    public function removeConversation(Request $request)
    {
        $id = $this->chat->getConversationBetween(Auth::user(), $request->id)->id;

        $this->tableMessages->where('conversation_id', '=', $id)->delete();

        $this->tableConversations->where('id', '=', $id)->delete();

        $this->tableSubjects->where('conversation_id', '=', $id)->delete();

        $this->tableConversationUser->where('conversation_id', '=', $id)->delete();

        return 0;
    }

    public function blockConversation(Request $request)
    {
        $this->tableConversations->where('id', '=', $this->chat->getConversationBetween(Auth::user(), $request->id)->id)->update(['is_blocked' => 'yes']);
    }

    public function unblockConversation(Request $request)
    {
        $this->tableConversations->where('id', '=', $this->chat->getConversationBetween(Auth::user(), $request->id)->id)->update(['is_blocked' => 'not']);
    }

    public function startNewConversation(Request $request)
    {

        $usersId = json_decode($request->users_info);

        foreach ($usersId as $id) {
            $conversation = $this->chat->createConversation([Auth::user()->id, $id]);
            $this->tableSubjects->insert(['conversation_id' => $conversation->id, 'subject_name' => $request->conversation_subject]);
            $this->chat->message($request->conversation_message)->from(Auth::user())->to($conversation)->send();
            $message = $this->tableMessages
                ->where('conversation_id', '=', $this->chat->getConversationBetween(Auth::user()->id, $id)->id)
                ->where('user_id', '=', Auth::user()->id)
                ->orderBy('id', 'desc')
                ->limit(1)
                ->get();

            foreach ($message as $m) {
                $this->tableMessageNotofications->insert(
                    ['message_id' => $m->id, 'conversation_id' => $conversation->id, 'user_id' => $id, 'is_seen' => '0', 'is_sender' => 0]
                );
                $this->history->insert(
                    [  'user_id' => $id, 'expert_id' => Auth::id(), 'time' => 0, 'type' =>0, 'cost' => 0 ,'conversation_id' => $conversation->id]
                );
            }
        }

        return redirect('/messages');
    }

    public function getUsersStatus(Request $request)
    {
        $array = $request->idArray;
        $act = array();
        foreach ($array as $id) {
            $user = DB::table('users')->where('id', '=', $id)->get();
            if ($user[0]->is_active_now == 'active') {
                array_push($act, 'active');
            } else {
                array_push($act, 'notActive');
            }
        }
        return $act;
    }

    public function checkIfHaveConversation(Request $request)
    {
        $conversation = $this->chat->getConversationBetween(Auth::user()->id, $request->id);
        if (null === $conversation)
            return 0;
        else
            return 1;
    }
    public function changeUserStatus(Request $request){
        Auth::user()->is_active_now = $request->userStatus;
        Auth::user()->save();
        return 0;
    }

}