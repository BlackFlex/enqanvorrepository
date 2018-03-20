<?php

namespace App\Http\Controllers;
use App\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller{


    public function makePayments(Request $request){
        $addAmount = 1;

        $payment = new Payments();
        $total = (int)$request->total;
        $funds = Auth::user()->funds;
        $payment->user_id = Auth::user()->id;
        $payment->payment_id = $request->res_id;
        $payment->create_time = $request->create_time;
        $payment->pay_method = $request->pay_method;
        $payment->status = $request->status;
        $payment->total = $total;
        $payment->currency = $request->currency;
        $payment->description = "Balance Refill From PayPal";
        $payment->pay_type = $addAmount;
        $payment->expert_id = -1;
        $payment->user_balance = $funds;
        $check = $payment->save();

        if($check == true){
            Auth::user()->funds = Auth::user()->funds + $total;
            Auth::user()->save();
        }
        return 0;
    }


    public function makePaymentsForChatFromPaypal(Request $request){
        $addAmount = 1;
        $chatTransaction = 2;
        $removeFromBalance = 3;

        $funds = Auth::user()->funds;
        $payment = new Payments();
        $total = (int)$request->total;
        $payment->user_id = Auth::user()->id;
        $payment->payment_id = $request->res_id;
        $payment->create_time = $request->create_time;
        $payment->pay_method = $request->pay_method;
        $payment->status = $request->status;
        $payment->total = $total;
        $payment->currency = $request->currency;
        $payment->description = "Account Balance Refill For Chat";
        $payment->pay_type = $chatTransaction;
        $payment->expert_id = -1;
        $payment->user_balance = $funds;

        $check = $payment->save();
        if($check == true){
            Auth::user()->funds = Auth::user()->funds + $total;
            Auth::user()->save();
        }
        return 0;
    }


    public function makePaymentFromUserForChat(Request $request){
        $userIndex = $request->whomToSend;

        $userName = DB::table('users')->where('id','=',$userIndex)->get()[0]->screen_name;
        $fee_chat = DB::table('users')->where('id','=',$userIndex)->get()[0]->fee_chat;


        $fund = Auth::user()->funds;

        $diff = $fund - $fee_chat;


        if( $diff  >= 0 ) {
            Auth::user()->funds = $diff;
            Auth::user()->save();

            $moneyExpert = DB::table('users')->where('id', '=', $userIndex)->get()[0]->funds;
            DB::table('users')->where('id', '=', $userIndex)->update(['funds' => $moneyExpert + ($fee_chat / 2)]);

            $money = DB::table('admin')->where('id', '=', 1)->get()[0]->totalMoney;

            DB::table('admin')->where('id', '=', 1)->update(['totalMoney' => $money + ($fee_chat / 2)]);
            DB::table('paid_session_notifications')->where('id', '=', $request->sessionID)->update(['session_status' => 2]);

            $payment = new Payments();
            $payId   = md5(uniqid('payment'.rand(), true));
            $t       = time();

            $payment->user_id = Auth::user()->id;
            $payment->payment_id = $payId;
            $payment->create_time = date("Y-m-d",$t);
            $payment->pay_method = 'paypal';
            $payment->status = 'Verified';
            $payment->total = $fee_chat;
            $payment->currency = "USD";
            $payment->description = "Chat Session With ".$userName;
            $payment->pay_type = 2;

            $payment->expert_id = $userIndex;
            $payment->expert_balance = $moneyExpert;
            $payment->session_id = $request->sessionID;
            $payment->user_balance = $fund;

            $totalSession = DB::table('histories')->where('conversation_id','=',$request->sessionID)->get()[0];
            $totalMoney__  = $totalSession->total_money;
            $totalMoney__ = $totalMoney__ + $fee_chat;
            DB::table('histories')->where('conversation_id','=',$request->sessionID)->update(['total_length'=>$request->total_len,'total_money'=>$totalMoney__]);

            $payment->save();

            return 0;
        }else{
            DB::table('paid_session_notifications')->where('id','=',$request->sessionID)->update(['session_status' => 3]);
            return 1;
        }
    }


    public function blockUser(Request $request){
        DB::table('blocked_users')->insert(['expert_id' => Auth::user()->id,'user_id'=> $request->userToBlock]);
        return 0;
    }

    public function getPaymentHistory(Request $request){
        $res = DB::table('payments')
                ->where('session_id','=',$request->sId)
            ->get();
        return $res;
    }

}
