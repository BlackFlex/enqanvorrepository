<?php
/**
 * Created by PhpStorm.
 * User: ооо
 * Date: 13.02.2018
 * Time: 19:05
 */

namespace App\Http\Controllers\Front;


use Auth;
use App\{
    Http\Controllers\Controller, Http\Requests\SearchRequest, Repositories\PostRepository, Models\Tag, Models\Category, Repositories\UserRepository, UserEmailSettings
};
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserInfoChangeController extends Controller
{

    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function generalSettings()
    {
        $user = Auth::user();
        if(!$user)throw new AuthenticationException();

        return view('front.user-setting-pages.settings',compact('user'));
    }



    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function personalSettings()
    {
        $user = Auth::user();
        if(!$user)throw new AuthenticationException();

        return view('front.user-setting-pages.user-personal-information',compact('user'));
    }


    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactInformationSettings()
    {
        $user = Auth::user();
        if(!$user)throw new AuthenticationException();
        $userContactInfo = DB::table('user_contacts')->where('user_id' ,'=', $user->id)->get();

        return view('front.user-setting-pages.user-contact-information',compact('user','userContactInfo'));

    }


    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailSettings(){

        $user = Auth::user();
        if(!$user)throw new AuthenticationException();
        if(Auth::user()->role == 'client')
        $settings =  DB::table('user_email_settings')->where('user_id','=',Auth::user()->id)->first();
        if(Auth::user()->role == 'expert')
        $settings =  DB::table('expert_email_settings')->where('expert_id','=',Auth::user()->id)->first();

        return view('front.user-setting-pages.user-email-settings',compact('user','settings'));
    }


    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function paymentSettings(){

        $user = Auth::user();
        if(!$user)throw new AuthenticationException();

        return view('front.user-setting-pages.user-payments-settings',compact('user'));
    }

    public function emailSettingsMain(Request $request){


        if(null == $request->message_from_adv){
            $request->message_from_adv = 0;
        }else{
            $request->message_from_adv = 1;
        }
        if(null == $request->adv_response){
            $request->adv_response = 0;
        }else{
            $request->adv_response = 1;
        }
        if(null == $request->special_offers){
            $request->special_offers = 0;
        }else{
            $request->special_offers = 1;
        }
        if(null == $request->daily_horo){
            $request->daily_horo = 0;
        }else{
            $request->daily_horo = 1;
        }
        if(null == $request->weekly_horo){
            $request->weekly_horo = 0;
        }else{
            $request->weekly_horo = 1;
        }
        if(null == $request->monthly_horo){
            $request->monthly_horo = 0;
        }else{
            $request->monthly_horo = 1;
        }
        if(null == $request->monthly_career_horo){
            $request->monthly_career_horo = 0;
        }else{
            $request->monthly_career_horo = 1;
        }
        if(null == $request->monthly_horo){
            $request->articles_news_updates = 0;
        }else{
            $request->articles_news_updates = 1;
        }


        $inf = DB::table('user_email_settings')->where('user_id','=',Auth::user()->id)->first();
        if(!empty($inf->id)){
            DB::table('user_email_settings')->where('user_id','=',Auth::user()->id)->update([
                'message_from_adv' => $request->message_from_adv,
                'adv_response' => $request->adv_response,
                'special_offers' => $request->special_offers,
                'daily_horo' => $request->daily_horo,
                'weekly_horo' => $request->weekly_horo,
                'monthly_horo' => $request->monthly_horo,
                'monthly_career_horo' => $request->monthly_career_horo,
                'articles_news_updates' => $request->articles_news_updates,
            ]);
        }
        else {
            DB::table('user_email_settings')->insert([
                'user_id' => Auth::user()->id,
                'message_from_adv' => $request->message_from_adv,
                'adv_response' => $request->adv_response,
                'special_offers' => $request->special_offers,
                'daily_horo' => $request->daily_horo,
                'weekly_horo' => $request->weekly_horo,
                'monthly_horo' => $request->monthly_horo,
                'monthly_career_horo' => $request->monthly_career_horo,
                'articles_news_updates' => $request->articles_news_updates,
            ]);
        }

        return redirect('/email-settings');
    }





    public function emailSettingsMainExper(Request $request){
        if(null == $request->send_me_a_message){
            $request->send_me_a_message = 0;
        }else{
            $request->send_me_a_message = 1;
        }
        if(null == $request->anu_for_clients){
            $request->anu_for_clients = 0;
        }else{
            $request->anu_for_clients = 1;
        }
        if(null == $request->anu_for_psychics){
            $request->anu_for_psychics = 0;
        }else{
            $request->anu_for_psychics = 1;
        }
        if(null == $request->special_offers_for_clients){
            $request->special_offers_for_clients = 0;
        }else{
            $request->special_offers_for_clients = 1;
        }
        if(null == $request->special_offers_for_psychics){
            $request->special_offers_for_psychics = 0;
        }else{
            $request->special_offers_for_psychics = 1;
        }

        $inf = DB::table('expert_email_settings')->where('expert_id','=',Auth::user()->id)->first();
        if(!empty($inf->id)){
            DB::table('expert_email_settings')->where('expert_id','=',Auth::user()->id)->update([
                'send_me_a_message' => $request->send_me_a_message,
                'anu_for_clients' => $request->anu_for_clients,
                'anu_for_psychics' => $request->anu_for_psychics,
                'special_offers_for_clients' => $request->special_offers_for_clients,
                'special_offers_for_psychics' => $request->special_offers_for_psychics,
            ]);
        }
        else {
            DB::table('expert_email_settings')->insert([
                'expert_id' => Auth::user()->id,
                'send_me_a_message' => $request->send_me_a_message,
                'anu_for_clients' => $request->anu_for_clients,
                'anu_for_psychics' => $request->anu_for_psychics,
                'special_offers_for_clients' => $request->special_offers_for_clients,
                'special_offers_for_psychics' => $request->special_offers_for_psychics,
            ]);
        }

        return redirect('/email-settings');
    }


































}