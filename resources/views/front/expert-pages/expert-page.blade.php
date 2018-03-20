@extends('front.layout')
@section('content')
    <div class="container">
        <div class="mt-30"></div>
        <div class="expert-header-wrap grey-grad">
            <div class="row">
                <div class="circle-block">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="expert-img-wrap">
                            <div class="expert-img-container">
                                <img src="{{ asset($user->avatar) }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-5">
                    <div class="expert-info-wrap">
                        <h4>{{ $user->screen_name }} <sup class="sp-sup">2</sup></h4>
                        <p>Specializing in: {{ $user->spec_in }}</p>
                        <p class="start-wrap">
                            @for($i=0;$i<count($rates);$i++)
                                <i class="ti-star"></i>
                            @endfor

                        </p>
                        <div class="expert-info-button">
                            @if($user->is_active_now == 'active' && $user->is_active_now == 0)
                                <button class="green-grad"><i class="fa fa-comment"></i>
                                    <span data-toggle="modal" data-target="#chatStartModal{{ $user->id }}" href="">Chat</span>
                                </button>
                            @endif
                            @if(!empty(Auth::user()))
                                @if(Auth::user()->role == 'client')

                                    @if(!empty($ifFav->id))
                                        <button class="purp-grad" style="width:225px">
                                            <a style="color:#ffffff;" href="/delete-favorite-psychic/{{$user->id}}">
                                                Your Favorite One
                                                <span>(remove)</span>
                                            </a>
                                        </button>
                                    @else
                                        <button class="purp-grad">
                                            <a style="color:#ffffff;" href="/add-favorite-psychic/{{$user->id}}">
                                                Add to Favorite
                                            </a>
                                        </button>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-5">
                    <div class="expert-price-wrap">

                        @if($user->is_active_now == "active")
                            <p><i class="fa fa-circle"></i>
                                Available
                            </p>
                        @endif

                        @if($user->is_active_now == "notActive")
                            <p style="color: red!important;"><i class="fa fa-circle"></i>
                                Not Active
                            </p>
                        @endif

                        @if($user->expert_status == 2)
                            <p><i class="fa fa-circle"></i>
                                Expert Is Busy
                            </p>
                        @endif

                    </div>
                    <div class="expert-time-wrap text-right">
                        <p class="expert-time">3 Minutes<img src="{{ asset("images/icons/free.png") }}" alt=""></p>
                    </div>
                    <div class="expert-money-time-wrap text-right">
                        <p class="expert-price-value">${{ $user->fee_chat }}/min </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 offset-3">
                    <div class="text-grey">
                        <p class="expert-info-p">
                            {{ $user->brief_intro }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr-green">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="description-wrap">
                    <p class="expert-collapse-toggle grey-grad" data-toggle="collapse" data-target="#col-1">
                        Description<span class="expert-minimize fa fa-minus-square"></span></p>
                    <hr class="hr-pink">
                    <div id="col-1" class="collapse show">
                        <p class="expert-description-text">
                            {{ $user->my_service }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="description-wrap">
                    <p class="expert-collapse-toggle grey-grad" data-toggle="collapse" data-target="#col-2">Degree and
                        Qualifications<span class="expert-minimize fa fa-minus-square"></span></p>
                    <hr class="hr-pink">
                    <div id="col-2" class="collapse show">
                        <p class="expert-description-text">
                            {{ $user->degree }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="description-wrap">
                    <p class="expert-collapse-toggle grey-grad" data-toggle="collapse" data-target="#col-3">
                        Experience<span class="expert-minimize fa fa-minus-square"></span></p>
                    <hr class="hr-pink">
                    <div id="col-3" class="collapse show">
                        <p class="expert-description-text">
                            {{ $user->exp }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="description-wrap">
                    <p class="expert-collapse-toggle grey-grad">Reviews</p>
                    <hr class="hr-pink">
                </div>
            </div>
        </div>
        <div class="row" id="revAppenndPlace">
        @foreach($rates as $rate)
                <div class="col-md-6">
                    <div class="expert-rev-wrap">
                        <h5>{{$rate->screen_name}}</h5>
                        <p class="expert-rev-desc">{{$rate->text}}</p>
                        <div class="expert-rev-date-wrap">
                            <div class="gold-star">
                                @for ($i = 0; $i < $rate->rate; $i++)
                                    <i class="fa fa-star"></i>
                                @endfor
                            </div>
                            <div class="text-right date-wrap">
                                <p>{{ Carbon\Carbon::parse($rate->created_at)->format('d-m-Y H:i') }}</p>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
        @endforeach
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="mt-3 viewMorePsy" style="text-align: center;font-size: 20px;font-weight: bold"><span>
                        <input type="hidden" value="{{ $user->screen_name }}" id="userScreenName">
                        <span id="viewMoreReveiew">View more
                    </span>
                    </span></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <div class="mb-3"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="expert-all-specs-head">
                    <h3>All Specialities</h3>
                </div>
                <div class="mt-5"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="expert-all-specs">
                    <p>Numerology</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="expert-all-specs">
                    <p>Numerology</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="expert-all-specs">
                    <p>Numerology</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="expert-all-specs">
                    <p>Numerology</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="expert-all-specs">
                    <p>Numerology</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="expert-all-specs">
                    <p>Numerology</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="expert-all-specs">
                    <p>Numerology</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="expert-all-specs">
                    <p>Numerology</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="expert-all-specs">
                    <p>Numerology</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="expert-all-specs">
                    <p>Numerology</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="expert-all-specs">
                    <p>Numerology</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="expert-all-specs">
                    <p>Numerology</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="expert-all-specs">
                    <p>Soulmates</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <hr>
            </div>
        </div>

        <!-- why choose section ends -->
        <section class="join-psychic">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="join-psychic_process">
                            <h3>
                                Affiliate program
                            </h3>
                            <p>Online Marketer? Blogger? Webmaster? Promote our Psychic Advice Platform and earn up to
                                $150 per New Paying Client. </p>
                            <a href="#">Become an affiliate</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="join-psychic_process">
                            <h3>Are you a Psychic?</h3>
                            <p>Join with Psychics Voice today to engage with thousands of new clients via online chat,
                                phone or email.</p>
                            <a href="#">Join as a Psychics Voice</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    @if(!empty($currentUser))
        @if($currentUser->role == 'client')
            <div class="modal fade user-chat-modal" id="chatStartModal{{ $user->id }}"
                 tabindex="-1"
                 role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog chat-start-dialog" role="document">

                    <div class="modal-content">
                        <div class="preloaderForStartSession"></div>

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
                                                    <span style="font-weight: 200;width: 100%">You are using your funds(currently ${{ \Illuminate\Support\Facades\Auth::user()->funds }}
                                                        )</span>
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
                                                        <span id="expertUserName">{{ $user->first_name }} {{ $user->last_name }}</span>
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
                                                           class="step2-inputs ste2Usernaem">
                                                    <input type="password"
                                                           placeholder="Password"
                                                           class="step2-inputs ste2Password">
                                                    <input type="text"
                                                           name="screen_name"
                                                           placeholder="Screen Name"
                                                           class="step2-inputs ste2Screen">
                                                </div>
                                                <div class="adwBanenr">
                                                    <img src="{{ asset("images/online/how-much-free.png") }}"
                                                         alt="">
                                                </div>
                                                <div class="psychic-ram">
                                                    <div class="container-ps">
                                                        <p>You are contacting</p>
                                                        <span id="expertUserName">{{ $user->first_name }} {{ $user->last_name }}</span>
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
                                                        <span id="expertUserName">{{ $user->first_name }} {{ $user->last_name }}</span>
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
                                                <input type="hidden"
                                                       value="{{ $user->id }}">
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

                                        <div class="end-conversation chatEndButtons"
                                             onclick="hangoutButton(this)"><span
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
                                                                                    <span class="fee-minute-money">${{ $user->fee_chat }}</span>
                                                                                </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="person-image-place">
                                            {{--loading screen av--}}
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
                                         style="display:none;position: relative;">
                                        <div class="preloaderForStartSession"></div>
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
                                            <input type="hidden"
                                                   class="userConversationId"
                                                   value="{{ $user->id }}">
                                            <span class="chat-timer"
                                                  id="chatTimerOfUser__{{ $user->id }}">

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
                                            <div class="preloader"></div>





                                            {{--<div class="ShangoutBlockMainShadow"--}}
                                            {{--style="display: none;">--}}
                                            {{--<div class="ShangoutBlock">--}}
                                            {{--<div class="ShangoutBlockHeader">--}}
                                            {{--<span class="closingButtons"--}}
                                            {{--onclick="chatMainActions(this,0)"><i--}}
                                            {{--class="ti-close"></i></span>--}}
                                            {{--</div>--}}
                                            {{--<div class="ShangoutBlockBody">--}}
                                            {{--<div class="ShangoutBlockBodyText">--}}
                                            {{--<span class="SboldText">The session has ended</span>--}}
                                            {{--</div>--}}
                                            {{--<div class="ShangoutBlockBodyTextLittle">--}}
                                            {{--<span class="regularText">Your session ended due to lack of funds in your account.</span>--}}
                                            {{--</div>--}}
                                            {{--<div class="ShangoutBlockBodyButtons">--}}

                                            {{--<div id="paypal-button-container"></div>--}}

                                            {{--<button class="chatEndButtons ShangoutBlockBodyHangUp"--}}
                                            {{--onclick="hangUpFunction(this)">--}}
                                            {{--Quit--}}
                                            {{--</button>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}





                                            <div class="right-section-top-header">
                                                <span class="chatEndButtons">HANGOUT</span>
                                                <span class="chatHangoutButton closingButtons"><i
                                                            class="ti-close"></i></span>
                                            </div>


                                            <div class="main-messages-place"
                                                 id="userMessagesPlace__{{ $user->id }}">

                                                <div class="mess-info">
                                                    <div class="infoLeft">
                                                        Keep Your Session Safe!
                                                    </div>
                                                    <div class="infoRight">
                                                        Please do not exchange contact
                                                        information.by keeping all
                                                        communication
                                                        on kasamba,you enjoy a safe and
                                                        secure environment and
                                                        assistance with
                                                        dissatisfaction or billing
                                                        disputes.
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

                                                <input type="text" class="psychic-send"
                                                       placeholder="Type message here"
                                                       id="textToSendExpert__{{ $user->id }}">
                                                <button class="snd-mess"
                                                        onclick="messageSendToExpert(this)">
                                                    Send
                                                </button>
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
        <div class="modal fade " id="chatStartModal{{ $user->id }}" tabindex="-1"
             role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog chat-start-dialog" role="document">
                <input type="hidden" value="{{ $user->fee_chat }}" id="userfeechat">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-inner">
                            {{--MODAL STEP 2 LOGIN MODAL--}}
                            <div class="custom-modal-for-step2-login">
                                <div class="modal-content custom-modal-for-login">
                                    <div class="modal-body">
                                        <div class="step2LoginHeader">
                                                                            <span class="closingButtons step2LoginHeaderIcon">
                                                                                <i class="ti-close"></i></span>
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
                                                <input type="text"
                                                       name="username"
                                                       placeholder="Username"
                                                       class="step2-inputs ste2Usernaem">
                                                <input type="password"
                                                       name="password"
                                                       placeholder="Password"
                                                       class="step2-inputs ste2Password">
                                                <input type="text"
                                                       name="screen_name"
                                                       placeholder="Screen Name"
                                                       class="step2-inputs ste2Screen">
                                            </div>
                                            <div class="adwBanenr">
                                                <img src="{{ asset("images/online/how-much-free.png") }}"
                                                     alt="">
                                            </div>
                                            <div class="psychic-ram">
                                                <div class="container-ps">
                                                    <p>You are contacting</p>
                                                    <span id="expertUserName">{{ $user->first_name }} {{ $user->last_name }}</span>
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
                                                    <span id="expertUserName">{{ $user->first_name }} {{ $user->last_name }}</span>
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
                                    <div class="end-conversation chatEndButtons"><span
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
                                        <span class="chat-timer"
                                              id="chatTimerOfUser__{{ $user->id }}">
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
                                            <span class="chatEndButtons">HANGOUT</span>
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
                            <img src="{{ asset("images/bg.png") }}" alt=""
                                 class="start-conversation">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection
