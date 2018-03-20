<?php
/**
 * Created by PhpStorm.
 * User: ооо
 * Date: 13.02.2018
 * Time: 15:23
 */

namespace App\Http\Controllers\Ajax;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\userContacts;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Bestmomo\LaravelEmailConfirmation\Traits\RegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;

class UserActions extends Controller{

    /**
     * Update the specified resource in storage.
     */
    public function updateUserGeneralInformation(Request $request){
        $user = Auth::user();

        if(!$user)throw new AuthenticationException();
        $data = $request->all();
        if(!$data['_token'])throw new AuthenticationException();

        if(empty($data['newUsername']) && empty($data['newEmail']) && empty($data['newPassword']) && empty($data['confirmedNewPassword']) ) {
            $returningMessage = "Fill something before save changes";
            return view('front.user-setting-pages.settings',compact('returningMessage','user'));
        }

        if(!empty($data['newUsername'])) {
            $user->screen_name = $data['newUsername'];
        }

        if(!empty($data['newEmail'])) {
            $user->email = $data['newEmail'];
        }

        if(!empty($data['newPassword'])) {
            if ($data['newPassword'] === $data['confirmedNewPassword'] && (!empty($data['newPassword']) || !empty($data['confirmedNewPassword']))) {
                $encryptNewPassword = bcrypt($data['newPassword']);
                $user->password = $encryptNewPassword;
                $user->save();
                $returningMessage = "Account Edited Successfully";
                return view('front.user-setting-pages.settings',compact('returningMessage','user'));
            } else {
                $returningMessage = "Passwords mismatch or they are empty";
                return view('front.user-setting-pages.settings',compact('returningMessage','user'));
            }
        }else{
            $user->save();
            $returningMessage = "Account Edited Successfully";
            return view('front.user-setting-pages.settings',compact('returningMessage','user'));
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function updateUserPersonalInformation(Request $request){
        $user = Auth::user();
        if(!$user)throw new AuthenticationException();
        $data = $request->all();
        if(!$data['_token'])throw new AuthenticationException();
        if(!empty($data['newUserAvatar'])) {

            $file = $data['newUserAvatar'];
            $fileName = md5(uniqid()) . time() . '.jpg';
            $file_ = $file;
            $rawImage = file_get_contents($file_);
            $st = Storage::disk('images')->put('/avatars/'.$fileName,$rawImage);
            $correctPath = '/images/avatars/'.$fileName;
            $user->avatar = $correctPath;
        }
        if(!empty($data['newScreenName']))
            $user->screen_name       = $data['newScreenName'];

        if(!empty($data['newHoroSign']))
            $user->horo_sign         = $data['newHoroSign'];

        if(!empty($data['newFirstName']))
            $user->first_name        = $data['newFirstName'];

        if(!empty($data['newLastName']))
            $user->last_name         = $data['newLastName'];

        if(!empty($data['newTitle']))
            $user->user_title        = $data['newTitle'];

        if(!empty($data['newGender']))
            $user->user_gender       = $data['newGender'];

        if(!empty($data['newBirth']))
            $user->date_of_birth = $data['newBirth'];


        if($data['userRole'] == 'expert'){

            if(!empty($data['newSpecIn']))
                $user->spec_in   = $data['newSpecIn'];

            if(!empty($data['newFeeMin']))
                $user->fee_chat  = $data['newFeeMin'];

            if(!empty($data['newFeeEmail']))
                $user->fee_email = $data['newFeeEmail'];

            if(!empty($data['newBriefIntro']))
                $user->brief_intro   = $data['newBriefIntro'];

            if(!empty($data['newMyServices']))
                $user->my_service    = $data['newMyServices'];

            if(!empty($data['newLanguage']))
                $user->language      = $data['newLanguage'];

            if(!empty($data['newDegree']))
                $user->degree        = $data['newDegree'];

            if(!empty($data['newExperience']))
                $user->exp           = $data['newExperience'];

        }

        $user->save();
        $returningMessage = "Personal Information Changed";
        return view('front.user-setting-pages.user-personal-information',compact('returningMessage','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUserContactInformation(Request $request){
        $user = Auth::user();
        if(!$user)throw new AuthenticationException();
        $data = $request->all();
        if(!$data['_token'])throw new AuthenticationException();
        $userContactInfo = DB::table('user_contacts')->where('user_id' ,'=', $user->id)->get();

        if(count($userContactInfo) == 0){
            $userContact = new userContacts;
            $userContact->user_id =  $user->id;
            $userContact->city    =  $data['city'];
            $userContact->street  =  $data['street'];
            $userContact->zip_code = $data['zipCode'];
            $userContact->country =  $data['country'];
            $userContact->save();
        }else{
            DB::table('user_contacts')
                ->where('user_id', '=',$user->id)
                ->update(['city' => $data['city'],'street'=>$data['street'],'zip_code'=>$data['zipCode'],'country'=> $data['country']]);
        }

        $returningMessage = "Contact Information Changed";
        return redirect('/contact-information-settings');
    }



    public function showExpertMore(Request $request){

    }

    public function autoWithdrawOn(){
        Auth::user()->auto_withdraw = 1;
        Auth::user()->save();
        return redirect('dashboard');
    }
    public function autoWithdrawOff(){
        Auth::user()->auto_withdraw = 0;
        Auth::user()->save();
        return redirect('dashboard');
    }


    public function autoRechargeOn(){
        Auth::user()->auto_recharge = 1;
        Auth::user()->save();
        return redirect('dashboard');
    }
    public function autoRechargeOff(){
        Auth::user()->auto_recharge = 0;
        Auth::user()->save();
        return redirect('dashboard');
    }


}

