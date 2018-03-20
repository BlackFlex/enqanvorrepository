<?php

namespace App\Http\Controllers;

use App\Models\User;
use Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Bestmomo\LaravelEmailConfirmation\Traits\RegistersUsers;

class ProfileController extends Controller
{
    
    public function show($screen_name)
    {
		$user=Auth::user();
		
        return view('front.publicprofile', compact('user'));
		
    }
	
	
}
