<?php
/**
 * Created by PhpStorm.
 * User: ооо
 * Date: 10.02.2018
 * Time: 19:22
 */

namespace App\Http\Controllers\Front;

use App\Models\Post;
use App\Models\UserPhones;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUserDashboard(Request $request){
        $user = Auth::user();
        if(!$user) return redirect('/');

        $path = public_path('images/flag-icons');
        $countries = scandir($path);
        $countries = json_encode($countries,1);


        $params  = $request->all();

        if(!empty($params['_token'])){

            if(!empty($params['expertFee'])) {
                Auth::user()->fee_chat = $params['expertFee'];
                Auth::user()->save();
            }

            if(!empty($params['userPhone'])) {
                $userId = $user->id;
                $userPhone = $params['userPhone'];
                $userPhoneItem = new UserPhones;
                $userPhoneItem->user_id = $userId;
                $userPhoneItem->user_phone = $userPhone;
                $userPhoneItem->save();
            }
            return redirect('/dashboard',array('countries'=>$countries));
        }

        $userPhones = DB::table('user_phones')->where('user_id' ,'=', $user->id)->get();


            $phonesArray = array();

            foreach ($userPhones as $p){
                array_push($phonesArray,$p->user_phone);
            }

            if($user->role == 'client') {
                return view('front.components.user-dashboard',array('user'=>$user,'userPhones'=>$phonesArray,'countries'=>$countries));
            }

            else if($user->role == 'expert'){
                $rates= DB::table('paid_session_ratings')
                    ->join('users', 'paid_session_ratings.user_id', '=', 'users.id')
                    ->select('paid_session_ratings.*','users.screen_name')
                    ->where('expert_id','=',$user->id)
                    ->orderBy('created_at','DESC')->limit(3)
                    ->get();

                return view('front.components.expert-dashboard' ,array('user'=>$user,'userPhones'=>$phonesArray,'rates'=>$rates,'countries'=>$countries));
            }

            else if($user->role == 'admin'){
                return view('front.components.user-dashboard');
            }

    }


    public function showPsychic($screen_name,$rateCount){

        $user = DB::table('users')->where('screen_name' ,'=',$screen_name)->get()[0];

            $rates = DB::table('paid_session_ratings')
                ->join('users', 'paid_session_ratings.user_id', '=', 'users.id')
                ->select('paid_session_ratings.*', 'users.screen_name')
                ->where('expert_id', '=', $user->id)
                ->orderBy('created_at', 'DESC')
                ->limit($rateCount)
                ->get();
            $rateCount = $rateCount + 4;

            if(\Illuminate\Support\Facades\Auth::user()) {
                $ifFav = DB::table('users_favorite_experts')->where('user_id', '=', \Illuminate\Support\Facades\Auth::user()->id)->first();
            }
        return view('front.expert-pages.expert-page', compact('user', 'rates', 'ifFav','rateCount'));

    }

    public function addFavPsychic($id){
        $r = DB::table('users_favorite_experts')->where('user_id' , '=',Auth::user()->id)
            ->where('expert_id' , '=',$id)->first();

        if(empty($r)) {
            DB::table('users_favorite_experts')->insert(['user_id' => Auth::user()->id, 'expert_id' => $id]);
        }
        return back();
    }

    public function deleteFavPsychic($id){
        DB::table('users_favorite_experts')->where('user_id' ,'=',Auth::user()->id)->where('expert_id' ,'=', $id)->delete();
        return back();
    }


    public function getPsychicReviews(Request $request,$rateCount){

        $user = DB::table('users')->where('screen_name' ,'=',$request->screen_name)->get()[0];

        $rates = DB::table('paid_session_ratings')
            ->join('users', 'paid_session_ratings.user_id', '=', 'users.id')
            ->select('paid_session_ratings.*', 'users.screen_name')
            ->where('expert_id', '=', $user->id)
            ->orderBy('created_at', 'DESC')
            ->limit($rateCount)
            ->get();

        return $rates;
    }
}