<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class SocialLogin extends Controller
{
    /**
     * Redirect the user to the facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request)
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $userFromFc = Socialite::driver('facebook')->user();
        $found = DB::table('users')->where('facebook_id','=',$userFromFc->getId())->get();

        if(empty($found[0])) {
            $user = new User();
            $name = explode(' ',$userFromFc->getName());
            $email = $userFromFc->getEmail();
            if($email === null) {
                $email = "YourEmail" . md5(uniqid("YourScreenName", true));
                $user->email = $email;
            }
            else {
                $user->email = $email;
            }
            $user->screen_name = "YourScreenName" . md5(uniqid("YourScreenName", true));
            $user->password = bcrypt("hopar456852357951hopar8248261597853hopar");
            $user->role = 'client';
            $user->confirmed = 1;
            $user->valid = 1;
            $user->horo_sign = 'fastAccount';
            $user->is_active_now = 'active';
            $user->is_typing = 'notTyping';
            $user->first_name = $name[0];
            $user->last_name = $name[1];
            $user->facebook_id = $userFromFc->getId();
            $user->save();
            Auth::login($user);
                return redirect('/');
        }else{
            Auth::loginUsingId($found[0]->id);
                return redirect('/');
        }



    }
}
