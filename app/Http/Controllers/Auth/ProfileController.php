<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Bestmomo\LaravelEmailConfirmation\Traits\RegistersUsers;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
       // $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
           
            'email' => 'required|email|max:255|unique:users',
            'screen_name' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function edit($screen_name)
    {
		$user=Auth::user();
		var_dump($user->screen_name);
        
		
    }
	
	protected function create(array $data)
    {
        $ck= User::create([
            'screen_name' => $data['screen_name'],
            'email' => $data['email'],
			'horo_sign' => $data['horo_sign'],
			'newsletter' => $data['newsletter'],
			'brief_intro' => $data['brief_intro'],
			'my_service' => $data['my_service'],
			'degree' => $data['degree'],
			'exp' => $data['exp'],
			'language' => $data['language'],
			'fee_chat' => $data['fee_chat'],
			'fee_email' => $data['fee_email'],
			'role' => 'client',		
            'password' => bcrypt($data['password']),
        ]);
    }
}
