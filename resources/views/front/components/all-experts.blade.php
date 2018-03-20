@extends('front.layout')
@section('content')	

    <div class="container-fluid sortby">
        <div class="container">
            <div class="row">


                {{--offset-md-9--}}

                <div class="col-md-6">
                    @if($activeExperts != 0)
                        <span class="intro-welcome">{{ $activeExperts }} Psychics available now. <span class="intro-welcome-decor">Choose yours!</span></span>
                    @else
                        <span class="intro-welcome">No Psychics available now</span>
                    @endif

                </div>


                <div class="col-md-3">
                    <form class="form-inline" method="get" action="/psychics" id="allPsychicsSrch">
                        <div class="form-group row">
                            <div class="main-page-search-block">
                                <input type="text" class="main-page-search"  name="searchedExpert" >
                                <div class="main-page-search-loop">
                                    <i class="ti-search search-loop"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 ">
                    <label for="inputSortby" class="col-md-4 col-form-label" style="padding: 0"><strong>Sort by:</strong></label>
                    <form action="/psychics" method="get" id="sortbyForm" style="float: right">
                        <select id="inputSortby" class="form-control" name="sortby">
                            <option class="LD" selected value="popularity">Popularity</option>
                            <option class="LD" value="new">New psychics</option>
                            <option class="LD" value="lprice">Lowest price</option>
                            <option class="LD" value="hprice">Highest price</option>
                        </select>
                    </form>
                </div>



            </div>
        </div>
    </div>
    <!-- sort by ends -->

    <section class="psychics-available">
        <div class="container">
            <hr>

            <div class="row available-psychics">

                @if(!empty($experts))
                    @foreach ($experts as $user)
                        <div class="col-md-6 online-psychic1">
                            <div class="online-psychic-inner-bg1">
                                <img src="{{asset('online/online-bg.png')}}" alt="" style="width: 100%;height: 100%;">
                            </div>
                            <div class="online-psychic_details1">
                                <div class="online-left-image1">
                                    <img src="{{ $user->avatar }}" alt="{{ $user->first_name }}">
                                </div>
                                <div class="online-name-text1">
                                    <span class="online-name1">{{$user->spec_in}} <a href="/psychic/{{$user->screen_name}}/4" style="color: #c42884;">{{$user->first_name}}</a> </span>
                                            @if($user->expert_status == 2)
                                                <span class="is-available1">
                                                    Busy
                                                </span>
                                            @else
                                                <span class="is-available1">
                                                    {{$user->is_active_now }}
                                                 </span>
                                            @endif

                                            <span style="    float: left;padding-top: 16px;margin-right: 0px;">{{$user->user_title}}</span>
                                        <span>

                                        <img src="{{asset('online/3min.png')}}" alt="">
                                    </span>

                                    <span>
                                        @for($i=0;$i<$user->rate;$i++)
                                            <i class="ti-star"></i>
                                        @endfor
                                    </span>

                                    <p style="min-height: 144px">
                                        {{$user->brief_intro}}
                                    </p>
                                    <div class="block-online-chat1">

                                        @if(!empty($currentUser))
                                            <a @if($currentUser->role == 'client') style="color: #0c0c0c" data-toggle="modal" data-target="#chatStartModal{{ $user->id }}" @endif href="" class="button-chat">
                                                <span><i class="ti-comment"></i></span>Chat
                                            </a>
                                        @else
                                            <a data-toggle="modal" data-target="#chatStartModal{{ $user->id }}" href=""
                                               class="button-chat1" ><span><i class="ti-comment"></i></span>Chat
                                            </a>
                                        @endif

                                        <div class="button-chat">
                                            <span>
                                            {{$user->fee_chat}} $
                                            </span>
                                        </div>
                                        <div class="button-text-message">
                                        <span><i class="ti-menu"></i></span>
                                            Text Message
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @if(!empty($currentUser))
                            @if($currentUser->role == 'client')
                                <div class="modal fade user-chat-modal chat-start-dialog" id="chatStartModal{{ $user->id }}" tabindex="-1"
                                     role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="modal-inner">
                                                    {{--MODAL STEP 2 LOGIN MODAL--}}
                                                    <div class="custom-modal-for-step2-login">
                                                        <div class="modal-content custom-modal-for-login">
                                                            <div class="modal-body">
                                                                <div class="step2LoginHeader">
                                                                                    <span class="closingButtons step2LoginHeaderIcon"><i
                                                                                                class="ti-close"></i></span>
                                                                </div>
                                                                <div class="step2Login">
                                                                    <div class="step2InputBlock">
                                                                        <label for="step2Login">Email</label>
                                                                        <input type="email" name="username"
                                                                               style="padding-top: 0"
                                                                               class="step2-login-inputs">
                                                                    </div>
                                                                    <div class="step2InputBlock">
                                                                        <label for="step2Login">Password</label>
                                                                        <input type="password"
                                                                               name="username"
                                                                               style="padding-top: 0"
                                                                               class="step2-login-inputs">
                                                                    </div>
                                                                    <button class="start-session-des"
                                                                            onclick="step2Login(this)">
                                                                        Sign In
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--END MODAL STEP 2 LOGIN MODAL--}}


                                                    <div class="mod-inner">
                                                        {{--HEADERS--}}
                                                        <div class="chat-start-header">
                                                            <div class="decorative-titles">
                                                                <i class="header-decor-first-part">Sign
                                                                    Up</i>
                                                                <i><span class="header-decor-little-part">to Psychics Voice</span></i>
                                                            </div>
                                                            <div class="decorative-titles-right">
                                                                <span class="step-description">Select a Psychics</span>
                                                                <span class="step-description">Sign Up</span>
                                                                <span class="step-description">Payment Info</span>
                                                                <span class="step-description">Start Session</span>
                                                            </div>
                                                            <div class="step-description-nums">
                                                                <div class="decor-line-first-start"></div>

                                                                <div class="decor-line-first-step">
                                                                    <div class="arrowsBlock">
                                                                        <img src="{{ asset('images/icons/arrow.png') }}"
                                                                             alt="">
                                                                    </div>
                                                                </div>

                                                                <div class="decor-line-second-step">
                                                                    <div class="arrowsBlock">
                                                                        <img src="{{ asset('images/icons/arrow.png') }}"
                                                                             alt="">
                                                                    </div>
                                                                </div>

                                                                <div class="decor-line-third-step">
                                                                    <div class="arrowsBlock">
                                                                        <img src="{{ asset('images/icons/arrow.png') }}"
                                                                             alt="">
                                                                    </div>
                                                                </div>


                                                                <span class="step-description-num step1">1</span>
                                                                <span class="step-description-num step2">2</span>
                                                                <span class="step-description-num step3">3</span>
                                                                <span class="step-description-num step4">4</span>

                                                            </div>
                                                        </div>


                                                        <div class="main-step-des">

                                                            <div class="des-body-title des-body-title-step1">
                                                                You Are One Click Away
                                                            </div>
                                                            <div class="des-body-title des-body-title-step2">
                                                                <div class="step2-inner">
                                                                    <div class="fc-connect">
                                                                        <a href="/login/facebook"
                                                                           style="color: white;">
                                                                            <i class="fab fa-facebook-square"></i>
                                                                            <span style="padding-left: 26px;letter-spacing: 1px;">Facebook Connect</span>
                                                                        </a>
                                                                    </div>
                                                                    <span class="step2-texts">
                                                                                    <span>Facebook is here for your convenience only</span>
                                                                                    <span>Your privacy and anonimity is inportant to us</span>
                                                                                </span>
                                                                </div>

                                                                <div class="step2-or">
                                                                    OR
                                                                </div>
                                                            </div>

                                                            <div class="des-body-title des-body-title-step3">
                                                                <div class="step3-title-container">
                                                                    Get your 3 free minutes by entering your
                                                                    billing information.
                                                                    The card will be used only after the
                                                                    3free minutes are over.
                                                                </div>
                                                                <div class="credit-card-info-text">
                                                                    Credit Card Information
                                                                </div>
                                                            </div>

                                                            <div class="des-body">
                                                                <div class="right-white-decor"></div>

                                                                {{--STEP 4--}}
                                                                <div class="body1">
                                                                    <div class="body1-inner">
                                                                        <span style="width: 100%">You are about to start a session with {{ $user->first_name }} {{ $user->last_name }}</span>
                                                                        <span style="font-weight: 200;width: 100%">You are using your funds(currently $13.04)</span>
                                                                        <span class="button-like-des"
                                                                              style="width: 100%">Tip:Add more funds to keep your session alive</span>
                                                                    </div>
                                                                    <div class="adwBanenr custBanner">
                                                                        <img src="{{ asset("images/online/how-much-free.png") }}"
                                                                             alt="">
                                                                    </div>
                                                                    <div class="psychic-ram">
                                                                        <div class="container-ps">
                                                                            <p>You are contacting</p>
                                                                            <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                                                                            <div class="image-ps-container">
                                                                                <img src="{{ $user->avatar }}"
                                                                                     alt="">
                                                                            </div>
                                                                            <p class="ps-cost-text">
                                                                                Fee/minute</p>
                                                                            <span style="font-weight: bold">${{ $user->fee_chat }}</span>
                                                                        </div>
                                                                        <img src="{{ asset("images/online/ram.png") }}"
                                                                             alt="" class="psy-ram">
                                                                        <p class="ps-waiting">The psychic is
                                                                            waiting for you</p>
                                                                    </div>
                                                                </div>

                                                                {{--STEP 2--}}
                                                                <div class="body2">
                                                                    <div class="body2-inner">
                                                                        <input type="text" name="username"
                                                                               placeholder="Username"
                                                                               class="step2-inputs">
                                                                        <input type="password"
                                                                               name="password"
                                                                               placeholder="Password"
                                                                               class="step2-inputs">
                                                                        <input type="text"
                                                                               name="screen_name"
                                                                               placeholder="Screen Name"
                                                                               class="step2-inputs">
                                                                    </div>
                                                                    <div class="adwBanenr">
                                                                        <img src="{{ asset("images/online/how-much-free.png") }}"
                                                                             alt="">
                                                                    </div>
                                                                    <div class="psychic-ram">
                                                                        <div class="container-ps">
                                                                            <p>You are contacting</p>
                                                                            <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                                                                            <div class="image-ps-container">
                                                                                <img src="{{ $user->avatar }}"
                                                                                     alt="">
                                                                            </div>

                                                                            <p class="ps-cost-text">
                                                                                Fee/minute</p>
                                                                            <span style="font-weight: bold">${{ $user->fee_chat }}</span>
                                                                        </div>
                                                                        <img src="{{ asset("images/online/ram.png") }}"
                                                                             alt="" class="psy-ram">
                                                                        <p class="ps-waiting">The psychic is
                                                                            waiting for you</p>
                                                                    </div>
                                                                </div>

                                                                {{--STEP 3--}}
                                                                <div class="body3">
                                                                    <div class="body3-inner">
                                                                        <input type="text" name="username"
                                                                               placeholder="Credit Card Number"
                                                                               style="padding-top: 0"
                                                                               class="step3-inputs">
                                                                        <div class="expiration">
                                                                            <span class="payment-expiration-text">Expiration</span>
                                                                            <select name="" id=""
                                                                                    class="expirationDropDown">
                                                                                <option value="">1</option>
                                                                                <option value="">2</option>
                                                                                <option value="">3</option>
                                                                            </select>

                                                                            <select name="" id=""
                                                                                    class="expirationDropDown">
                                                                                <option value="">2018
                                                                                </option>
                                                                                <option value="">2019
                                                                                </option>
                                                                                <option value="">2020
                                                                                </option>
                                                                            </select>
                                                                            <input type="text"
                                                                                   placeholder="CVC"
                                                                                   class="step3-inputs-cvc">
                                                                            <span class="get-hints">?</span>
                                                                        </div>
                                                                        <span class="billing-info">Billing Information</span>
                                                                        <input type="text" name="username"
                                                                               placeholder="Card holder Name"
                                                                               class="step3-inputs"
                                                                               style="margin-top: -8px">
                                                                        <select name="" id=""
                                                                                class="step3-inputs cust-select">
                                                                            <option value="">Select
                                                                                Country
                                                                            </option>
                                                                        </select>
                                                                        <input type="text" name="username"
                                                                               placeholder="Address 1"
                                                                               class="step3-inputs">
                                                                        <input type="text" name="username"
                                                                               placeholder="Address 2"
                                                                               class="step3-inputs">
                                                                        <div class="inputsLine">
                                                                            <input type="text"
                                                                                   name="username"
                                                                                   placeholder="Phone"
                                                                                   class="step3-inputs step3-inputsPhone">
                                                                            <input type="text"
                                                                                   name="username"
                                                                                   placeholder="Zip"
                                                                                   class="step3-inputs step3-inputsZip">
                                                                        </div>
                                                                    </div>
                                                                    <div class="imagesContainer">
                                                                        <div class="payPalInfo">
                                                                            <img src="{{ asset("images/logo/paypal.png") }}"
                                                                                 alt="">
                                                                        </div>
                                                                        <div class="adwBanenr"
                                                                             style="margin-left: 140px">
                                                                            <img src="{{ asset("images/online/how-much-free.png") }}"
                                                                                 alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="psychic-ram"
                                                                         style="margin-top: 89px !important;">
                                                                        <div class="container-ps">
                                                                            <p>You are contacting</p>
                                                                            <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                                                                            <div class="image-ps-container">
                                                                                <img src="{{ $user->avatar }}"
                                                                                     alt="">
                                                                            </div>

                                                                            <p class="ps-cost-text">
                                                                                Fee/minute</p>
                                                                            <span style="font-weight: bold">${{ $user->fee_chat }}</span>
                                                                        </div>
                                                                        <img src="{{ asset("images/online/ram.png") }}"
                                                                             alt="" class="psy-ram">
                                                                        <p class="ps-waiting">The psychic is
                                                                            waiting for you</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="start-section">

                                                                <div class="minute-chat-body-footer1">
                                                                    <input type="hidden" value="{{ $user->id }}">
                                                                    <button class="start-session-des"
                                                                            onclick="sessionStart(this,{{ $user->id }})">
                                                                        Start Session
                                                                    </button>
                                                                    <p class="couponHave">Have a Coupon
                                                                        code? Enter it <span>here</span></p>
                                                                </div>

                                                                <div class="minute-chat-body-footer2">
                                                                    <div class="block-terms-and-conditions">
                                                                                    <span class="termscond">
                                                                                        <input type="checkbox" name=""
                                                                                               class="checkhide inp-disp"
                                                                                               id="receiveEmail"/>
                                                                                        <label class="cust-lab step2-label"
                                                                                               for="receiveEmail">
                                                                                            <span>I Want to receive special offers,coupons and tips via email</span>
                                                                                        </label>
                                                                                    </span>


                                                                        <span class="termscond">
                                                                                        <input type="checkbox" name=""
                                                                                               class="checkhide inp-disp"
                                                                                               id="mainTerms"/>
                                                                                        <label class="cust-lab step2-label"
                                                                                               for="mainTerms">
                                                                                             <span>I have read and agree to the psychic voice member <a
                                                                                                         href=""
                                                                                                         style="color: #db297f">terms and conditions</a></span>
                                                                                        </label>
                                                                                        <span class="step2-info-notify">Your information will be kept completly confidential</span>
                                                                                    </span>
                                                                    </div>
                                                                    <button class="start-session-des"
                                                                            onclick="Register()">
                                                                        Sign Up
                                                                    </button>
                                                                    <p class="couponHave">Already have an
                                                                        account?<span
                                                                                class="step2LoginButton">Sign In</span>
                                                                    </p>

                                                                </div>

                                                                <div class="minute-chat-body-footer3">
                                                                    <button class="start-session-des">
                                                                        Next
                                                                    </button>
                                                                </div>

                                                            </div>

                                                        </div>

                                                        {{--CONNECTION LOADING--}}
                                                        <div class="conversation-window"
                                                             style="display:none">
                                                            <div class="end-conversation" onclick="hangoutButton(this)"><span
                                                                        class="hangoutText" >HANGOUT</span>
                                                                <span class="closingButtons"><i
                                                                            class="ti-close"></i></span>
                                                            </div>

                                                            <div class="conversation-person-info">
                                                                <div class="conversation-person-inner">
                                                                    <div class="conversation-person-left-side">
                                                                                    <span>
                                                                                        <span class="peson-name">{{ $user->first_name }}</span>
                                                                                        <span class="peson-last-name">{{ $user->last_name }}</span>
                                                                                    </span>
                                                                        <div class="decor-seperator"></div>
                                                                    </div>

                                                                    <div class="conversation-person-right-side">
                                                                                    <span>
                                                                                        <span class="fee-minute-text">Fee/minute</span>
                                                                                        <span class="fee-minute-money">${{ $user->fee_chat }}</span>
                                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="person-image-place">
                                                                <div class="person-avatar-container">
                                                                    <img src="{{ $user->avatar }}"
                                                                         alt="">
                                                                </div>
                                                            </div>

                                                            <div class="connection-sector">
                                                                <div class="connection-sector-inner">
                                                                    <div class="left-decor-side">
                                                                        <div class="des-circle"></div>
                                                                        <div class="des-line"></div>
                                                                        <div class="circle-half"></div>
                                                                    </div>
                                                                    <span class="connection-done">
                                                                                    <i class="fas fa-check"></i>
                                                                                </span>

                                                                    <div class="right-decor-side">
                                                                        <div class="des-circle"></div>
                                                                        <div class="des-line"></div>
                                                                        <div class="circle-half"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="texts">
                                                                <span>Connection</span>
                                                                <text>This might take a few moments</text>
                                                            </div>
                                                        </div>
                                                        {{--CHATING WINDOW--}}
                                                        <div class="main-conversation-windows" style="display:none;">
                                                            <div class="left-section">
                                                                <p class="chat-frame-status">Connected</p>
                                                                <div class="connection-sector-little">
                                                                    <div class="connection-sector-inner-little">
                                                                        <div class="left-decor-side-little">
                                                                            <div class="des-circle-little"></div>
                                                                            <div class="des-line-little"></div>
                                                                            <div class="circle-half-little"></div>
                                                                        </div>

                                                                        <span class="connection-done-little">
                                                                                        <i class="fas fa-check"></i>
                                                                                    </span>

                                                                        <div class="right-decor-side-little">
                                                                            <div class="des-circle-little borderedCircle"></div>
                                                                            <div class="des-line-little"></div>
                                                                            <div class="circle-half-little"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <p class="chat-frame-timer">Timer</p>
                                                                <input type="hidden" class="userConversationId" value="{{ $user->id }}">
                                                                <span class="chat-timer" id="chatTimerOfUser__{{ $user->id }}">

                                                                                </span>

                                                                <div class="person-image-place">
                                                                    <div class="person-avatar-container">
                                                                        <img src="{{ asset($user->avatar) }}"
                                                                             alt="">
                                                                    </div>
                                                                </div>

                                                                <div class="person-username">
                                                                    {{ $user->first_name }}
                                                                    {{ $user->last_name }}
                                                                </div>
                                                                <div class="howMuchText">
                                                                    Fee/minute
                                                                </div>
                                                                <div class="howMuchNum">
                                                                    ${{ $user->fee_chat }}
                                                                </div>

                                                                <button class="add-credit">
                                                                    Add Credit
                                                                </button>
                                                            </div>
                                                            <div class="right-section">
                                                                <div class="right-section-top-header">
                                                                    <span>HANGOUT</span>
                                                                    <span class="chatHangoutButton closingButtons"><i class="ti-close"></i></span>
                                                                </div>


                                                                <div class="main-messages-place" id="userMessagesPlace__{{ $user->id }}">

                                                                    <div class="mess-info">
                                                                        <div class="infoLeft">
                                                                            Keep Your Session Safe!
                                                                        </div>
                                                                        <div class="infoRight">
                                                                            Please do not exchange contact information.by keeping all communication
                                                                            on kasamba,you enjoy a safe and secure environment and assistance with
                                                                            dissatisfaction or billing disputes.
                                                                        </div>
                                                                    </div>


                                                                </div>

                                                                <div class="messages-send-place">
                                                                    <div class="userLogo">
                                                                        @if(!empty(\Illuminate\Support\Facades\Auth::user()))
                                                                            <img src="{{ \Illuminate\Support\Facades\Auth::user()->avatar }}"
                                                                                 alt="">
                                                                        @endif

                                                                        <div class="isTypingUser"></div>
                                                                    </div>

                                                                    <input type="text" class="psychic-send" placeholder="Type message here" id="textToSendExpert__{{ $user->id }}">
                                                                    <button class="snd-mess" onclick="messageSendToExpert(this)">Send</button>
                                                                    <div class="add-file-per-minute">
                                                                        <input type="file" id="hiddenFile">
                                                                        <label for="hiddenFile"><i
                                                                                    class="ti-clip"></i></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mod-background"></div>
                                                    <img src="{{ asset("images/bg.png") }}" alt=""
                                                         class="start-conversation">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="modal fade" id="chatStartModal{{ $user->id }}" tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="modal-inner">
                                                {{--MODAL STEP 2 LOGIN MODAL--}}
                                                <div class="custom-modal-for-step2-login">
                                                    <div class="modal-content custom-modal-for-login">
                                                        <div class="modal-body">
                                                            <div class="step2LoginHeader">
                                                                                <span class="closingButtons step2LoginHeaderIcon"><i
                                                                                            class="ti-close"></i></span>
                                                            </div>
                                                            <div class="step2Login">
                                                                <div class="step2InputBlock">
                                                                    <label for="step2Login">Email</label>
                                                                    <input type="email" name="username"
                                                                           style="padding-top: 0"
                                                                           class="step2-login-inputs">
                                                                </div>
                                                                <div class="step2InputBlock">
                                                                    <label for="step2Login">Password</label>
                                                                    <input type="password" name="username"
                                                                           style="padding-top: 0"
                                                                           class="step2-login-inputs">
                                                                </div>
                                                                <button class="start-session-des"
                                                                        onclick="step2Login(this)">
                                                                    Sign In
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--END MODAL STEP 2 LOGIN MODAL--}}


                                                <div class="mod-inner">
                                                    {{--HEADERS--}}
                                                    <div class="chat-start-header">
                                                        <div class="decorative-titles">
                                                            <i class="header-decor-first-part">Sign Up</i>
                                                            <i><span class="header-decor-little-part">to Psychics Voice</span></i>
                                                        </div>
                                                        <div class="decorative-titles-right">
                                                            <span class="step-description">Select a Psychics</span>
                                                            <span class="step-description">Sign Up</span>
                                                            <span class="step-description">Payment Info</span>
                                                            <span class="step-description">Start Session</span>
                                                        </div>
                                                        <div class="step-description-nums">
                                                            <div class="decor-line-first-start"></div>

                                                            <div class="decor-line-first-step">
                                                                <div class="arrowsBlock">
                                                                    <img src="{{ asset("images/icons/arrow.png") }}"
                                                                         alt="">
                                                                </div>
                                                            </div>

                                                            <div class="decor-line-second-step">
                                                                <div class="arrowsBlock">
                                                                    <img src="{{ asset("images/icons/arrow.png") }}"
                                                                         alt="">
                                                                </div>
                                                            </div>

                                                            <div class="decor-line-third-step">
                                                                <div class="arrowsBlock">
                                                                    <img src="{{ asset("images/icons/arrow.png") }}"
                                                                         alt="">
                                                                </div>
                                                            </div>


                                                            <span class="step-description-num step1">1</span>
                                                            <span class="step-description-num step2">2</span>
                                                            <span class="step-description-num step3">3</span>
                                                            <span class="step-description-num step4">4</span>

                                                        </div>
                                                    </div>


                                                    <div class="main-step-des">

                                                        <div class="des-body-title des-body-title-step1">You
                                                            Are One Click Away
                                                        </div>
                                                        <div class="des-body-title des-body-title-step2">
                                                            <div class="step2-inner">
                                                                <div class="fc-connect">
                                                                    <a href="/login/facebook"
                                                                       style="color: white;">
                                                                        <i class="fab fa-facebook-square"></i>
                                                                        <span style="padding-left: 26px;letter-spacing: 1px;">Facebook Connect</span>
                                                                    </a>
                                                                </div>
                                                                <span class="step2-texts">
                                                                                    <span>Facebook is here for your convenience only</span>
                                                                                    <span>Your privacy and anonimity is inportant to us</span>
                                                                                </span>
                                                            </div>

                                                            <div class="step2-or">
                                                                OR
                                                            </div>
                                                        </div>

                                                        <div class="des-body-title des-body-title-step3">
                                                            <div class="step3-title-container">
                                                                Get your 3 free minutes by entering your
                                                                billing information.
                                                                The card will be used only after the 3free
                                                                minutes are over.
                                                            </div>
                                                            <div class="credit-card-info-text">
                                                                Credit Card Information
                                                            </div>
                                                        </div>

                                                        <div class="des-body">
                                                            <div class="right-white-decor"></div>

                                                            {{--STEP 4--}}
                                                            <div class="body1">
                                                                <div class="body1-inner">
                                                                    <span style="width: 100%">You are about to start a session with {{ $user->first_name }} {{ $user->last_name }}</span>
                                                                    <span style="font-weight: 200;width: 100%">You are using your funds(currently $13.04)</span>
                                                                    <span class="button-like-des"
                                                                          style="width: 100%">Tip:Add more funds to keep your session alive</span>
                                                                </div>
                                                                <div class="adwBanenr custBanner">
                                                                    <img src="{{ asset("images/online/how-much-free.png") }}"
                                                                         alt="">
                                                                </div>
                                                                <div class="psychic-ram">
                                                                    <div class="container-ps">
                                                                        <p>You are contacting</p>
                                                                        <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                                                                        <div class="image-ps-container">
                                                                            <img src="{{ $user->avatar }}"
                                                                                 alt="">
                                                                        </div>
                                                                        <p class="ps-cost-text">
                                                                            Fee/minute</p>
                                                                        <span style="font-weight: bold">${{ $user->fee_chat }}</span>
                                                                    </div>
                                                                    <img src="{{ asset("images/online/ram.png") }}"
                                                                         alt="" class="psy-ram">
                                                                    <p class="ps-waiting">The psychic is
                                                                        waiting for you</p>
                                                                </div>
                                                            </div>

                                                            {{--STEP 2--}}
                                                            <div class="body2">
                                                                <div class="body2-inner">
                                                                    <input type="text" name="username"
                                                                           placeholder="Username"
                                                                           class="step2-inputs">
                                                                    <input type="password" name="password"
                                                                           placeholder="Password"
                                                                           class="step2-inputs">
                                                                    <input type="text" name="screen_name"
                                                                           placeholder="Screen Name"
                                                                           class="step2-inputs">
                                                                </div>
                                                                <div class="adwBanenr">
                                                                    <img src="{{ asset("images/online/how-much-free.png") }}"
                                                                         alt="">
                                                                </div>
                                                                <div class="psychic-ram">
                                                                    <div class="container-ps">
                                                                        <p>You are contacting</p>
                                                                        <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                                                                        <div class="image-ps-container">
                                                                            <img src="{{ $user->avatar }}"
                                                                                 alt="">
                                                                        </div>

                                                                        <p class="ps-cost-text">
                                                                            Fee/minute</p>
                                                                        <span style="font-weight: bold">${{ $user->fee_chat }}</span>
                                                                    </div>
                                                                    <img src="{{ asset("images/online/ram.png") }}"
                                                                         alt="" class="psy-ram">
                                                                    <p class="ps-waiting">The psychic is
                                                                        waiting for you</p>
                                                                </div>
                                                            </div>

                                                            {{--STEP 3--}}
                                                            <div class="body3">
                                                                <div class="body3-inner">
                                                                    <input type="text" name="username"
                                                                           placeholder="Credit Card Number"
                                                                           style="padding-top: 0"
                                                                           class="step3-inputs">
                                                                    <div class="expiration">
                                                                        <span class="payment-expiration-text">Expiration</span>
                                                                        <select name="" id=""
                                                                                class="expirationDropDown">
                                                                            <option value="">1</option>
                                                                            <option value="">2</option>
                                                                            <option value="">3</option>
                                                                        </select>

                                                                        <select name="" id=""
                                                                                class="expirationDropDown">
                                                                            <option value="">2018</option>
                                                                            <option value="">2019</option>
                                                                            <option value="">2020</option>
                                                                        </select>
                                                                        <input type="text" placeholder="CVC"
                                                                               class="step3-inputs-cvc">
                                                                        <span class="get-hints">?</span>
                                                                    </div>
                                                                    <span class="billing-info">Billing Information</span>
                                                                    <input type="text" name="username"
                                                                           placeholder="Card holder Name"
                                                                           class="step3-inputs"
                                                                           style="margin-top: -8px">
                                                                    <select name="" id=""
                                                                            class="step3-inputs cust-select">
                                                                        <option value="">Select Country
                                                                        </option>
                                                                    </select>
                                                                    <input type="text" name="username"
                                                                           placeholder="Address 1"
                                                                           class="step3-inputs">
                                                                    <input type="text" name="username"
                                                                           placeholder="Address 2"
                                                                           class="step3-inputs">
                                                                    <div class="inputsLine">
                                                                        <input type="text" name="username"
                                                                               placeholder="Phone"
                                                                               class="step3-inputs step3-inputsPhone">
                                                                        <input type="text" name="username"
                                                                               placeholder="Zip"
                                                                               class="step3-inputs step3-inputsZip">
                                                                    </div>
                                                                </div>
                                                                <div class="imagesContainer">
                                                                    <div class="payPalInfo">
                                                                        <img src="{{ asset("images/logo/paypal.png") }}"
                                                                             alt="">
                                                                    </div>
                                                                    <div class="adwBanenr"
                                                                         style="margin-left: 140px">
                                                                        <img src="{{ asset("images/online/how-much-free.png") }}"
                                                                             alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="psychic-ram"
                                                                     style="margin-top: 89px !important;">
                                                                    <div class="container-ps">
                                                                        <p>You are contacting</p>
                                                                        <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                                                                        <div class="image-ps-container">
                                                                            <img src="{{ $user->avatar }}"
                                                                                 alt="">
                                                                        </div>

                                                                        <p class="ps-cost-text">
                                                                            Fee/minute</p>
                                                                        <span style="font-weight: bold">${{ $user->fee_chat }}</span>
                                                                    </div>
                                                                    <img src="{{ asset("images/online/ram.png") }}"
                                                                         alt="" class="psy-ram">
                                                                    <p class="ps-waiting">The psychic is
                                                                        waiting for you</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="start-section">

                                                            <div class="minute-chat-body-footer1">
                                                                <button class="start-session-des"
                                                                        onclick="sessionStart(this,{{ $user->id }})">
                                                                    Start Session
                                                                </button>
                                                                <p class="couponHave">Have a Coupon code?
                                                                    Enter it <span>here</span></p>
                                                            </div>

                                                            <div class="minute-chat-body-footer2">
                                                                <div class="block-terms-and-conditions">
                                                                                    <span class="termscond">
                                                                                        <input type="checkbox" name=""
                                                                                               class="checkhide inp-disp"
                                                                                               id="receiveEmail"/>
                                                                                        <label class="cust-lab step2-label"
                                                                                               for="receiveEmail">
                                                                                            <span>I Want to receive special offers,coupons and tips via email</span>
                                                                                        </label>
                                                                                    </span>


                                                                    <span class="termscond">
                                                                                        <input type="checkbox" name=""
                                                                                               class="checkhide inp-disp"
                                                                                               id="mainTerms"/>
                                                                                        <label class="cust-lab step2-label"
                                                                                               for="mainTerms">
                                                                                             <span>I have read and agree to the psychic voice member <a
                                                                                                         href=""
                                                                                                         style="color: #db297f">terms and conditions</a></span>
                                                                                        </label>
                                                                                        <span class="step2-info-notify">Your information will be kept completly confidential</span>
                                                                                    </span>
                                                                </div>
                                                                <button class="start-session-des"
                                                                        onclick="Register()">
                                                                    Sign Up
                                                                </button>
                                                                <p class="couponHave">Already have an
                                                                    account?<span class="step2LoginButton">Sign In</span>
                                                                </p>

                                                            </div>

                                                            <div class="minute-chat-body-footer3">
                                                                <button class="start-session-des">
                                                                    Next
                                                                </button>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    {{--CONNECTION LOADING--}}
                                                    <div class="conversation-window" style="display:none">
                                                        <div class="end-conversation"><span
                                                                    class="hangoutText">HANGOUT</span>
                                                            <span class="closingButtons"><i
                                                                        class="ti-close"></i></span>
                                                        </div>

                                                        <div class="conversation-person-info">
                                                            <div class="conversation-person-inner">
                                                                <div class="conversation-person-left-side">
                                                                                    <span>
                                                                                        <span class="peson-name">{{ $user->first_name }}</span>
                                                                                        <span class="peson-last-name">{{ $user->last_name }}</span>
                                                                                    </span>
                                                                    <div class="decor-seperator"></div>
                                                                </div>

                                                                <div class="conversation-person-right-side">
                                                                                    <span>
                                                                                        <span class="fee-minute-text">Fee/minute</span>
                                                                                        <span class="fee-minute-money">{{ $user->fee_chat }}</span>
                                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="person-image-place">
                                                            <div class="person-avatar-container">
                                                                <img src="{{ $user->avatar }}"
                                                                     alt="">
                                                            </div>
                                                        </div>

                                                        <div class="connection-sector">
                                                            <div class="connection-sector-inner">
                                                                <div class="left-decor-side">
                                                                    <div class="des-circle"></div>
                                                                    <div class="des-line"></div>
                                                                    <div class="circle-half"></div>
                                                                </div>
                                                                <span class="connection-done">
                                                                                    <i class="fas fa-check"></i>
                                                                                </span>

                                                                <div class="right-decor-side">
                                                                    <div class="des-circle"></div>
                                                                    <div class="des-line"></div>
                                                                    <div class="circle-half"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="texts">
                                                            <span>Connection</span>
                                                            <text>This might take a few moments</text>
                                                        </div>
                                                    </div>
                                                    {{--CHATING WINDOW--}}
                                                    <div class="main-conversation-windows"
                                                         style="display:none;">


                                                        <div class="left-section">
                                                            <p class="chat-frame-status">Connected</p>
                                                            <div class="connection-sector-little">
                                                                <div class="connection-sector-inner-little">
                                                                    <div class="left-decor-side-little">
                                                                        <div class="des-circle-little"></div>
                                                                        <div class="des-line-little"></div>
                                                                        <div class="circle-half-little"></div>
                                                                    </div>

                                                                    <span class="connection-done-little">
                                                                                        <i class="fas fa-check"></i>
                                                                                    </span>

                                                                    <div class="right-decor-side-little">
                                                                        <div class="des-circle-little borderedCircle"></div>
                                                                        <div class="des-line-little"></div>
                                                                        <div class="circle-half-little"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <p class="chat-frame-timer">Timer</p>
                                                            <span class="chat-timer" id="chatTimerOfUser__{{ $user->id }}">
                                                                            </span>


                                                            <div class="person-image-place">
                                                                <div class="person-avatar-container">
                                                                    <img src="{{ $user->avatar }}"
                                                                         alt="">
                                                                </div>
                                                            </div>

                                                            <div class="person-username">
                                                                {{ $user->first_name }} {{ $user->last_name }}
                                                            </div>
                                                            <div class="howMuchText">
                                                                Fee/minute
                                                            </div>
                                                            <div class="howMuchNum">
                                                                {{ $user->fee_chat }}
                                                            </div>

                                                            <button class="add-credit">
                                                                Add Credit
                                                            </button>
                                                        </div>

                                                        <div class="right-section">
                                                            <div class="right-section-top-header">
                                                                <span>HANGOUT</span>
                                                                <span class="chatHangoutButton closingButtons"><i
                                                                            class="ti-close"></i></span>
                                                            </div>



                                                            <div class="main-messages-place">

                                                                <div class="mess-info">
                                                                    <div class="infoLeft">
                                                                        Keep Your Session Safe!
                                                                    </div>
                                                                    <div class="infoRight">
                                                                        Lorem ipsum dolor
                                                                        sit amet, consectetur adipisicing
                                                                        elit. Ad alias asperiores
                                                                        consequatur culpa dignissimos
                                                                        , ea hic illo natus nobis nulla
                                                                        obcaecati porro quia quibusdam quos
                                                                        rerum temporibus tenetur veri
                                                                        tatis voluptatibus.
                                                                    </div>
                                                                </div>


                                                                <div class="line-session-start">
                                                                                    <span class="session-start-info">
                                                                                        <div class="desl"></div>
                                                                                        <div class="desr"></div>
                                                                                        <span></span>PAID SESSION STARTED
                                                                                    </span>
                                                                    <hr>
                                                                </div>
                                                            </div>

                                                            <div class="messages-send-place">
                                                                <div class="userLogo">
                                                                    @if(!empty(\Illuminate\Support\Facades\Auth::user()))
                                                                        <img src="{{ \Illuminate\Support\Facades\Auth::user()->avatar }}"
                                                                             alt="">
                                                                    @endif

                                                                    <div class="isTypingUser"></div>
                                                                </div>

                                                                <input type="text" class="psychic-send"
                                                                       placeholder="Type message here">
                                                                <button class="snd-mess">Send</button>
                                                                <div class="add-file-per-minute">
                                                                    <input type="file" id="hiddenFile">
                                                                    <label for="hiddenFile"><i
                                                                                class="ti-clip"></i></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mod-background"></div>
                                                <img src="{{ asset("images/bg.png") }}" alt="" class="start-conversation">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{--session end modal--}}
                        @if(!empty($currentUser))
                            @if($currentUser->role == 'client')
                                <div class="session-end-modal">
                                    <div class="sessia-backdrop"></div>
                                    <div class="sessia">
                                        <div class="sessia-head">
                                            <div class="sessia-close"><i class="fas fa-times"></i></div>
                                            <p>How was your session?</p>
                                        </div>
                                        <div class="sessia-body">
                                            <form action="/paid-session-rate" method="post">
                                                <div class="sessia-singl">
                                                    <p class="sessia-rating-1">Rating your session</p>
                                                    <div class="sessia-rate">
                                                        <hr class="sessia-hr-1">
                                                        <input class="count-checker" type="hidden" name="rates" id="expert_rating" >
                                                        <i class="fas fa-star star" id="1"></i>
                                                        <i class="fas fa-star star" id="2"></i>
                                                        <i class="fas fa-star star" id="3"></i>
                                                        <i class="fas fa-star star" id="4"></i>
                                                        <i class="fas fa-star star" id="5"></i>
                                                        <hr class="sessia-hr-2">
                                                    </div>
                                                    <p class="sessia-rating-2">Thanks you for rating this session</p>
                                                </div>
                                                <div class="sessia-share">
                                                    <p>Share your experience</p>
                                                    <textarea class="form-control" rows="3" placeholder="Type here" name="text"></textarea>
                                                </div>
                                                <div class="sessia-send">
                                                    <div class="sessia-send-1">
                                                        <button name="status" value="1">Send</button>
                                                    </div>
                                                    <div class="sessia-send-2">
                                                        <button name="status" value="0">Later</button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="session_id" id='session_id' value="">
                                                <input type="hidden" name="expert_id" id='expert_id' value="">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        @endif
                    @endif

                    @endforeach
                @endif
            </div>
            <button class="view-more-ps">View More Psychics</button>
            <hr>
        </div>
    </section>

    <section>
        <div class="container">

        </div>
    </section>


    <!-- why choose section ends -->
    <section class="join-psychic">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="join-psychic_process">
                        <h3>
                            Affiliate program
                        </h3>
                        <p>Online Marketer? Blogger? Webmaster? Promote our Psychic Advice Platform and earn up to $150 per New Paying Client. </p>
                        <a href="#">Become an affiliate</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="join-psychic_process">
                        <h3>Are you a Psychic?</h3>
                        <p>Join with Psychics Voice today to engage with thousands of new clients via online chat, phone or email.</p>
                        <a href="#">Join as a Psychics Voice</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- join affiliate ends -->
@endsection
  