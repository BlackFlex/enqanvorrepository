<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">

    <meta name="description"
          content="{{ isset($post) && $post->meta_description ? $post->meta_description : __('description') }}">
    <meta name="author" content="@lang(lcfirst ('Author'))">
    @if(isset($post) && $post->meta_keywords)
        <meta name="keywords" content="{{ $post->meta_keywords }}">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ url('') }}">

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#da297f">
    <meta name="description" content="">
    <meta name="keywords" content="Psychics Voice">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fs.selecter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cropper/jquery.Jcrop.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cropper/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cropper/style-example.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset("images/favicon/favicon.ico") }}">
    <!-- google fonts -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i|Lora:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
</head>

<body>

@if(!empty(\Illuminate\Support\Facades\Auth::user()))
    <input type="hidden" value="{{ \Illuminate\Support\Facades\Auth::user()->role }}" id="UStatus__">
@endif
<input type="hidden" value="notLogged" id="UStatus__">

<div class="container-fluid top-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="text-align: right">
                @guest
                    <a id="login" class="normal-btn">Sign In</a>
                    <!-- The Modal -->
                    <div id="myModalLogin" class="popup">
                        <div class="popup-content">
                            <div class="popup-upper">
                                <span class="close" id="close">&times;</span>
                                <h2>SIGN IN TO Psychics Voice</h2>
                                <p class="small-text">TO GET 3 FREE MINUTES AND 60% OFF</p>
                                <hr>
                                <form id="login_form">
                                    <div class="popup_input">
                                        <label>Email</label>
                                        <input required name="email" type="email" value="">
                                    </div>
                                    <div class="popup_input">
                                        <label>Password</label>
                                        <input required name="password" type="password" value="">
                                    </div>
                                    <a href="#" class="forgetPasswortd">Forgot Password?</a>
                                    <div class="btn_section">
                                        <div class="popu_left">
                                            <div class="pretty p-icon p-rotate">
                                                <div class="state p-success">
                                                    <input type="checkbox" name="autologin" class="checkhide inp-disp" id="frst-ch" />
                                                    <label class="cust-lab" for="frst-ch">Auto Login</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="popu_right">
                                            <input type="submit" value="Sign In" id="signin" class="color_btn">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="popup_bottom">
                                <h4 class="text-left">Not Registred yet?</h4>
                                <button class="white_btn">Sign Up</button>
                            </div>
                        </div>
                    </div>


                    <a id="signup"  class="normal-btn">Sign Up</a>
                    <div id="myModalsignup" class="popup">

                        <!-- Modal content -->
                        <div class="popup-content">
                            <div class="popup-upper">

                                <span class="close" id="close1">&times;</span>
                                <h2>SIGN UP TO Psychics Voice</h2>
                                <p class="small-text">TO GET 3 FREE MINUTES AND 60% OFF</p>
                                <hr>
                                <form id="register_form">
                                    <div class="popup_input">
                                        <label>Email</label>
                                        <input lkm="Email" id="email" placeholder="@lang('Email')" type="email"
                                               class="full-width" name="email" value="{{ old('email') }}"
                                               required="required">
                                    </div>
                                    <div class="popup_input">
                                        <label>Password</label>
                                        <input lkm="Password" id="password" placeholder="@lang('Password')"
                                               type="password" class="full-width" name="password" required="required">
                                    </div>
                                    <div class="popup_input">
                                        <label>Screen Name <span class="text-right">(Optional)</span></label>
                                        <input lkm="Screen Name" id="screen_name" placeholder="@lang('screen name')"
                                               type="text" class="full-width" name="screen_name"
                                               value="{{ old('screen_name') }}" required="required" autofocus>
                                    </div>
                                    <div class="popup_input">
                                        <label>Horoscope Sign <span class="text-right">(Optional)</span></label>
                                        <select id="horo_sign" lkm="Horoscope Sign" name="horo_sign"
                                                required="required">
                                            <option value="WithoutSign">Without Sign</option>
                                            <option value="Aries">Aries</option>
                                            <option value="Leo">Leo</option>
                                            <option value="Sagittarius">Sagittarius</option>
                                            <option value="Taurus">Taurus</option>
                                            <option value="Virgo">Virgo</option>
                                            <option value="Capricorn">Capricorn</option>
                                            <option value="Gemini">Gemini</option>
                                            <option value="Libra">Libra</option>
                                            <option value="Aquarius">Aquarius</option>
                                            <option value="Cancer">Cancer</option>
                                            <option value="Scorpio">Scorpio</option>
                                            <option value="Pisces">Pisces</option>
                                        </select>
                                        <input type="hidden" value="active" name="active">
                                    </div>

                                    <input type="hidden" class="checkhide inp-disp register_type" value="client" name="role" id="userRole"/>

                                    {{--<div class="popup_input">--}}
                                        {{--You are:--}}

                                        {{--<div class="pretty p-icon p-rotate" >--}}
                                            {{--<div class="pretty p-icon p-rotate">--}}
                                                {{--<div class="state p-success">--}}
                                                    {{--<input type="checkbox" class="checkhide inp-disp register_type" value="client" name="role" id="client userSignUp__"/>--}}
                                                    {{--<label class="cust-lab" for="client">Client</label>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="pretty p-icon p-rotate" >--}}
                                            {{--<div class="pretty p-icon p-rotate">--}}
                                                {{--<div class="state p-success">--}}
                                                    {{--<input type="checkbox" class="checkhide inp-disp register_type"  value="expert" name="role" id="expert expertSignUp__"/>--}}
                                                    {{--<label class="cust-lab" for="expert">Psychics</label>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}


                                    <div class="expert_level" id="expert_level" style="display:none;">
                                        {{--<input type="hidden" class="checkhide inp-disp register_type"  value="expert" name="role" id="expert expertSignUp__"/>--}}
                                        <div class="popup_input">
                                            <label>Brief Description <span class="text-right m-text-right">(Max 175 characters. No HTML! No All Caps!)</span></label>
                                            <textarea lkm="Brief Description" id="brief_intro" placeholder=""
                                                      class="full-width width100" name="brief_intro"
                                                      value="{{ old('brief_intro') }}" autofocus></textarea>
                                        </div>
                                        <div class="popup_input">
                                            <label>About My Services</label>
                                            <textarea lkm="About My Services" id="my_service" placeholder=""
                                                      class="full-width width100" name="my_service"
                                                      value="{{ old('my_service') }}" autofocus></textarea>
                                        </div>
                                        <div class="popup_input">
                                            <label>Degrees</label>
                                            <textarea lkm="Degrees" id="degree" placeholder="" class="full-width width100"
                                                      name="degree" value="{{ old('degree') }}" autofocus></textarea>
                                        </div>
                                        <div class="popup_input">
                                            <label>Experience & Qualifications</label>
                                            <textarea lkm="Experience & Qualifications" id="exp" placeholder=""
                                                      class="full-width width100" name="exp" value="{{ old('exp') }}"
                                                      autofocus></textarea>
                                        </div>
                                        <div class="popup_input">
                                            <label>Specialized In</label>
                                            <textarea lkm="Specialized In" id="spec_in" placeholder="" class="full-width width100" name="spec_in" value="{{ old('spec_in') }}" autofocus></textarea>
                                        </div>
                                        <div class="popup_input">
                                            <label>Language</label>
                                            <select lkm="Language" id="language" placeholder="@lang('language')"
                                                    class="full-width width100" name="language" value="{{ old('language') }}"
                                                    required autofocus>
                                                <option value="en">English</option>
                                                <option value="hi">hindi</option>
                                            </select>
                                        </div>
                                        <div class="popup_input">
                                            <label>Fees</label>
                                            <small>How much will you charge for a minut of LIVE session (chat) ?</small>
                                            <div class="fee_option">
                                                <small>U.S $</small>
                                                <input lkm="Fee on Chat" id="fee_chat"
                                                       placeholder="@lang('Fee on chat')" type="text" class="full-width min-full-width"
                                                       name="fee_chat" value="{{ old('fee_chat') }}" required="required"
                                                       autofocus>
                                                <small>per minut (299.4 per hour)</small>
                                            </div>
                                            <small>How much will you charge for service rendered by email ?</small>
                                            <input id="fee_email" lkm="Fee on Email" placeholder="@lang('Fee on Email')"
                                                   type="text" class="full-width " name="fee_email"
                                                   value="{{ old('fee_email') }}" required="required" autofocus>
                                        </div>
                                    </div>


                                    <div class="popup_input">
                                        <div class="outer-radio">
                                            <div class="pretty p-icon p-rotate">
                                                <div class="pretty p-icon p-rotate">
                                                    <div class="state p-success">
                                                        <input type="checkbox" class="checkhide inp-disp"  lkm="Newsletter" id="newsletter"
                                                               placeholder="@lang('screen name')" value="true" name="newsletter" autofocus/>
                                                        <label class="cust-lab" for="newsletter">I want to receive special offers, horoscopes and coupons by
                                                            email.</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="outer-radio">
                                            <div class="outer-radio">
                                                <div class="pretty p-icon p-rotate">
                                                    <div class="state p-success">
                                                        <input type="checkbox" class="checkhide inp-disp" lkm="Terms & Condition" id="terms"
                                                               placeholder="@lang('screen name')"  name="terms" required="required" autofocus />
                                                        <label class="cust-lab" for="terms">I have read and agree to the Zodiac Psychics terms and
                                                            conditions.<br>
                                                            Your information will be kept completely confidential *</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn_section">
                                        <div class="pretty p-icon p-rotate">
                                            <div class="state d-success">
                                                <input type="checkbox" class="checkhide inp-disp" value="" name="autologin" id="autologin" />
                                                <label class="cust-lab" for="autologin" class="cust-lab">Auto login</label>
                                            </div>
                                        </div>
                                        <div class="popu_right">
                                            <input id="signupformsubmit" type="submit" class="color_btn"
                                                   value="Sign up">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="popup_bottom">
                                <h4 class="text-left">Already have an account?</h4>
                                <button class="white_btn" id="alreadyHaveAccount">Sign In</button>
                            </div>
                        </div>
                    </div>

                @else
                    <style>
                        .top-header{
                            margin-bottom: 0rem!important;
                            padding: 0px!important;
                        }
                    </style>

                    <div class="topnav" id="myTopnav">
                        <a class="@if (\Route::current()->getName() == null) normal-btn @endif admin-dasah-button" href="{{ URL::to('/dashboard')  }}"> <i class="fa fa-th"></i> Dashboard</a>
                        <a class="@if (\Route::current()->getName() == 'reading-history') normal-btn @endif admin-dasah-button" href="{{ URL::to('/reading-history/all')  }}"> <i class="fa fa-envelope"></i> Reading History</a>

                        @if(\Illuminate\Support\Facades\Auth::user()->role == "client")
                            <a  class="@if (\Route::current()->getName() == 'my-psychics') normal-btn @endif admin-dasah-button" href="{{ URL::to("/my-psychics") }}"> <i class="fa fa-star"></i>My Psychics</a>
                        @else
                            <a class="@if (\Route::current()->getName() == 'my-clients') normal-btn @endif admin-dasah-button" href="{{ URL::to("/my-clients") }}"> <i class="fa fa-star"></i>My Clients</a>
                        @endif

                        <a class="@if (\Route::current()->getName() == 'payments') normal-btn @endif admin-dasah-button" href="{{ URL::to("/payments") }}"> <i class="fa fa-credit-card"></i> Payments</a>
                        <a class="@if (\Route::current()->getName() == 'general-settings' || \Route::current()->getName() == 'personal-settings' || \Route::current()->getName() == 'contact-information-settings' || \Route::current()->getName() == 'email-settings' || \Route::current()->getName() == 'payment-settings' ) normal-btn @endif admin-dasah-button" href="{{ URL::to("/general-settings") }}"> <i class="fa fa-cog"></i> Settings</a>
                        <a class="@if (\Route::current()->getName() == 'messages') normal-btn @endif admin-dasah-button" href="{{route('messages',['expert'=>'all']) }}"> <i class="fa fa-comments"></i> Messages</a>
                        <a class="@if (\Route::current()->getName() == 'logout') normal-btn @endif admin-dasah-button" href="{{ URL::to('/logout') }}"> <img src="{{ asset("images/icons/block.png") }}" alt=""> Sign Out</a>
                        <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
                    </div>

                    <script>
                        function myFunction() {
                            var x = document.getElementById("myTopnav");
                            if (x.className === "topnav") {
                                x.className += " responsive";
                            } else {
                                x.className = "topnav";
                            }
                        }
                    </script>
                @endguest
            </div>
        </div>
    </div>
</div>
<!-- sing in / sign up top ends -->
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <a href="{{ url('') }}">
                <img src="{{ asset("images/logo/logo.png") }}" alt="{{ config('app.name', 'Laravel') }}" class="img-fluid">
            </a>
        </div>
        <div class="col-md-8">
            <div class="top-nav-block">
                <div class="topnav-bottom" id="mytopnav">
                    <a class="topnav-bottom-avtive" href="#">Home</a>
                    <a class="nav-link" href="#">Articles</a>
                    <a class="nav-link" href="#">Horoscopes</a>
                    <a class="nav-link" href="#">How It Works</a>
                    <a class="nav-link" href="#">Need Help?</a>
                    <a class="nav-link" href="#">Questions&Answers</a>
                    <a href="javascript:void(0);" style="font-size:15px;" class="icon-bottom" onclick="xxl()">&#9776;</a>
                    <script>
                        function xxl() {
                            var x = document.getElementById("mytopnav");
                            if (x.className === "topnav-bottom") {
                                x.className += " responsive-bottom";
                            } else {
                                x.className = "topnav-bottom";
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- logo nav ends -->

<nav class="navbar navbar-expand-lg navbar-light bg-light main-nav">
    <div class="container">
        <!-- <a class="navbar-brand" href="#"><img src="images/logo/logo.png" alt="Psychics Voice Logo" class="img-fluid"></a> -->

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <!-- <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Astrology and Horoscope
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Western astrology</a>
                        <a class="dropdown-item" href="#">Indian astrology</a>
                        <a class="dropdown-item" href="#">Chinese astrology</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Career Advice</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Clairvoyance
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Clairsentience</a>
                        <a class="dropdown-item" href="#">Clairaudien</a>
                        <a class="dropdown-item" href="#">Claircognizance</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Dream Analysis </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Love & Relationships
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Relationship development</a>
                        <a class="dropdown-item" href="#">Romance and intimacy</a>
                        <a class="dropdown-item" href="#">Soulmates</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Psychic Reading</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Tarot Readers
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Angel Card</a>
                        <a class="dropdown-item" href="#">Crowley Card</a>
                        <a class="dropdown-item" href="#">Cartomancy</a>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</nav>


<!--header end-->
<!--page body-->
@yield('content')
<!--end page body-->
<!--<start page footer-->
<section class="footer">
    <div class="container-fluid footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h4>About Psychics Voice </h4>
                    <ul>
                        <li><a href="#"> About Us</a></li>
                        <li><a href="#">Top Rated Psychics</a></li>
                        <li><a href="#">Customer Support</a></li>
                        <li><a href="#">Secured and Confidential Payment</a></li>
                        <li><a href="#">Site Map</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4>How It Works</h4>
                    <ul>
                        <li><a href="#">Getting Started</a></li>
                        <li><a href="#">What To Expect</a></li>
                        <li><a href="#">Prices</a></li>
                        <li><a href="#">Psychics Voice. Advice On-The-Go</a></li>
                        <li><a href="#">Articles</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4>How We Can Help</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Find a Psychic</a></li>
                        <li><a href="#">Become an Affiliate</a></li>
                        <li><a href="#">Become a Psychics Voice</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4>Follow Us</h4>
                    <div class="footer-social">
                        <a href="#" title="Facebook"><img src="{{ asset("images/footer/ic-facebook.png") }}" alt="Facebook logo icon"></a>
                        <a href="" title="Twitter"><img src="{{ asset("images/footer/ic-twitter.png") }}" alt="Twitter logo icon"></a>
                        <a href="" title="Google plus"><img src="{{ asset("images/footer/ic-google-plus.png") }}"
                                                            alt="Google plus logo icon"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer top ends -->
    <div class="container-fluid footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a href="#">Terms of Use</a>
                    <a href="">Privacy Policy</a>
                    <a href="">Disclaimer</a>
                </div>
                <div class="offset-md-4"></div>
                <div class="col-md-4">
                    <p>© 2016 Psychics Voice | All rights reserved. </p>
                </div>
            </div>
        </div>
    </div>
</section>
@include('front.components.expert-chat-window')

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/lkm.js') }}"></script>
<script src="{{ asset('js/jquery.fs.selecter.min.js') }}"></script>
<script src="{{ asset('js/modernizr.js') }}"></script>
<script src="{{ asset('adminlte/js/app.js') }}"></script>
<script src="{{ asset('js/messages-control.js') }}"></script>
<script src="{{ asset('js/cropper/jquery.Jcrop.js') }}"></script>
<script src="{{ asset('js/cropper/jquery.SimpleCropper.js') }}"></script>
<script src="{{ asset('js/psychic-chat-control.js') }}"></script>
<script src="{{ asset('js/per-miute-chat-controll.js') }}"></script>
<script src="{{ asset('js/crop.js') }}"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>

</body>

</html>

	