<?php

namespace App\Http\Controllers\Ajax;


use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Bestmomo\LaravelEmailConfirmation\Traits\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    public function registerFast(Request $request){

        $Arequest = $request->all();


        $validator = Validator::make($Arequest, [
            'screen_name' => 'required|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'status' => false,
                'error' => $error
            ]);
        }

        $email = md5(uniqid("fastRegister", true))."@fastRegister.fastRegister";

        $userCreate = User::create([
            'screen_name' => $Arequest['screen_name'],
            'first_name' => $Arequest['userName'],
            'email' => $email,
            'horo_sign' => "fastRegister",
            'newsletter' => "fastRegister",
            'brief_intro' => "fastRegister",
            'my_service' => "fastRegister",
            'degree' => "fastRegister",
            'exp' => "fastRegister",
            'language' => "fastRegister",
            'fee_chat' => 0,
            'fee_email' => 0,
            'spec_in' => "fastRegister",
            'role' => "client",
            'is_active_now' => "active",
            'password' => bcrypt($Arequest['password']),
        ]);

        Auth::loginUsingId($userCreate->id);
        return response("Registered");
    }


    public function create(Request $request)
    {


        parse_str($_REQUEST['data'], $Arequest);

        $validator = Validator::make($Arequest, [
            'screen_name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);


        if ($validator->fails()) {
            $error = $validator->errors()->first();
            // return $error;
            return response()->json([
                'status' => false,
                'error' => $error
            ]);
        }



        if (null == $Arequest['brief_intro'])
            if ($Arequest['role'] == 'expert')
                $Arequest['brief_intro'] = 'expert';
            else
                $Arequest['brief_intro'] = 'client-account';

        if (null == $Arequest['my_service'])
            if ($Arequest['role'] == 'expert')
                $Arequest['my_service'] = 'expert';
            else
            $Arequest['my_service'] = 'client-account';

        if (null == $Arequest['degree'])
            if ($Arequest['role'] == 'expert')
                $Arequest['degree'] = 'expert';
            else
                $Arequest['degree'] = 'client-account';

        if (null == $Arequest['exp'])
            if ($Arequest['role'] == 'expert')
                $Arequest['exp'] = 'expert';
        else
            $Arequest['exp'] = 'client-account';

        if (null == $Arequest['fee_chat'])
            if ($Arequest['role'] == 'expert')
                $Arequest['fee_chat'] = 'expert';
        else
            $Arequest['fee_chat'] = '0';

        if (null == $Arequest['fee_email'])
            $Arequest['fee_email'] = '0';

        if (null == $Arequest['spec_in'])
            $Arequest['spec_in'] = 'client-account';

        if (null == $Arequest['active'] || empty($Arequest['active']))
            $Arequest['active'] = 'active';

        $ret = User::create([
            'screen_name' => $Arequest['screen_name'],
            'email' => $Arequest['email'],
            'horo_sign' => $Arequest['horo_sign'] ? $Arequest['horo_sign'] : null,
            'newsletter' => array_key_exists("newsletter", $Arequest) ? $Arequest['newsletter'] : false,
            'brief_intro' => $Arequest['brief_intro'] ? $Arequest['brief_intro'] : null,
            'my_service' => $Arequest['my_service'] ? $Arequest['my_service'] : null,
            'degree' => $Arequest['degree'] ? $Arequest['degree'] : null,
            'exp' => $Arequest['exp'] ? $Arequest['exp'] : null,
            'language' => $Arequest['language'],
            'fee_chat' => $Arequest['fee_chat'],
            'fee_email' => $Arequest['fee_email'],
            'spec_in' => $Arequest['spec_in'],
            'role' => $Arequest['role'],
            'is_active_now' => $Arequest['active'],
            'password' => bcrypt($Arequest['password']),
        ]);

        if (array_key_exists("autologin", $Arequest) && $ret) {
            $auth = false;
            $credentials = array('email' => $Arequest['email'], 'password' => $Arequest['password']);
            $Attempt_login = Auth::attempt($credentials);
            if ($Attempt_login) {
                $auth = true; // Success
            }

            if ($request->ajax()) {
                return response()->json([
                    'status' => $auth,
                    'redirect' => true
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'data' => $ret
        ]);
    }


    /* ajax login function */

    public function Login(Request $request)
    {
        $auth = false;
        $credentials = $request->only('email', 'password');
        $Attempt_login = Auth::attempt($credentials, $request->has('remember'));


        if ($Attempt_login) {
            $auth = true; // Success
        } else {
            return response()->json([
                'auth' => false,
                'data' => $Attempt_login
            ]);
        }

        if ($request->ajax()) {

            $user = Auth::user();
            $user->is_active_now = 'active';
            $user->save();

            return response()->json([
                'auth' => $auth,
                'intended' => ''
            ]);
        }

    }



}
