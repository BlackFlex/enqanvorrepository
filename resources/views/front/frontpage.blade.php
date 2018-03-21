@extends('front.layout')
@section('content')

    <div class="no-money" id="no-money_dashboard" style="position:absolute;left: 0;top:0;">
        <div class="modal-content custom-modal-for-login">
            <div class="modal-body">
                <div class="step2LoginHeader">
                                                                                <span class="closingButtons step4noMoneyIcon"><i
                                                                                            class="ti-close"></i></span>
                </div>
                <div class="step2Login">
                    <div style="display: flex;">
                                                                                    <span style="
                                            display:  block;
                                            float:  left;
                                            margin-right: 14px;
                                        " id="addFunds_">I want to deposit</span>

                        <input type="number" id="customAmount" style="display: none;border: none;border-bottom: 1px solid black" >

                        <select type="text" id="transaction_size" style="
                                            display: block;
                                            margin: 5px 30px;
                                            border-radius: 3px;
                                            border: none;
                                            border-bottom: 1px solid;
                                            float: left;
                                    ">
                            <option value="20">$1</option>
                            <option value="20">$10</option>
                            <option value="20">$20</option>
                            <option value="50">$50</option>
                            <option value="100">$100</option>
                            <option value="200">$200</option>
                            <option value="500">$500</option>
                            <option value="Other" class="otherValToPay">Other</option>
                        </select>
                    </div>
                    <div style="display: flex">
                        <span style="
                                            display:  block;
                                            float:  left;
                                            margin-right: 14px;">to my account. Using</span>

                        <select type="text"
                                id="transaction_type"
                                style="
                                                display: block;
                                                margin: 5px 30px;
                                                border-radius: 3px;
                                                border: none;
                                                border-bottom: 1px solid;
                                                float: left;
                                        ">
                            <option value="paypal">paypal
                            </option>
                        </select>
                    </div>
                    <div id="paypalForBalanceRefill">
                        <input type="hidden" id="hhYTT__" value="">
                        <div id="paypal-button-container"></div>
                    </div>

                    <script>
                        paypal.Button.render({
                            env: 'sandbox', // sandbox | production
                            // PayPal Client IDs - replace with your own
                            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
                            client: {
                                sandbox: 'AZDxjDScFpQtjWTOUtWKbyN_bDt4OgqaF4eYXlewfBP4-8aqX3PiV8e1GWU6liB2CUXlkA59kJXE7M6R',
                                production: 'AZZjkDDK15x_af6-lW3tpX5fZlv_HBK2I3SH3EXFr0C26FeJc3uUatAtF1vA2CU8H-RV303bbQ2YA2sz'
                            },

                            // Show the buyer a 'Pay Now' button in the checkout flow
                            commit: true,

                            // payment() is called when the button is clicked
                            payment: function (data, actions) {

                                // Make a call to the REST api to create the payment
                                return actions.payment.create({
                                    payment: {
                                        transactions: [
                                            {
                                                amount: {
                                                    total: document.getElementById('transaction_size').value,
                                                    currency: "USD"
                                                },
                                            }
                                        ],
                                    },
                                });
                            },
                            // onAuthorize() is called when the buyer approves the payment
                            onAuthorize: function (data, actions) {

                                // Make a call to the REST api to execute the payment
                                return actions.payment.execute().then(function (res) {
                                    $.ajax({
                                        url: base_url + '/make-payment',
                                        data: {
                                            'res_id': res['id'],
                                            'create_time': res['create_time'],
                                            'pay_method': res['payer']['payment_method'],
                                            'status': res['payer']['status'],
                                            'total': res['transactions'][0]['amount']['total'],
                                            'currency': res['transactions'][0]['amount']['currency']
                                        },
                                        type: "POST",
                                        dataType: "json",
                                        success: function (res) {
                                            if (sessionStarted == true) {
                                                $.ajax({
                                                    url: base_url + '/make-payment-from-user-for-chat',
                                                    data: {
                                                        "whomToSend": userIndexGeneral,
                                                        "sessionID": currentSessionId
                                                    },
                                                    type: "POST",
                                                    dataType: "json",
                                                    success: function (res) {
                                                        if (res == 0) {
                                                            clearInterval(timerUser);
                                                            setTimerForChatUser(0, 1, 0);
                                                            pullDataForUser(true);
                                                            if ($('.preloader').length) {
                                                                $('.preloader').delay(200).fadeOut(500);
                                                            }
                                                            $step4NoMoney.animate({
                                                                'opacity': '0',
                                                                'z-index': '-5'
                                                            }, 500)
                                                        } else {
                                                            clearInterval(timerUser);
                                                            hours = 0;
                                                            minutes = 0;
                                                            seconds = 0;
                                                            $('.right-section').find('.ShangoutBlockMainShadow').css({
                                                                'display': 'block'
                                                            })
                                                        }
                                                    }
                                                });
                                            } else {

                                                var userToSend = document.getElementById('hhYTT__').value;
                                                $step4NoMoney.animate({
                                                    'opacity': '0',
                                                    'z-index': '-5'
                                                }, 500)
                                                sessionStart(this, userToSend)
                                            }
                                        }
                                    })
                                });
                            },
                        }, '#paypal-button-container');
                    </script>

                </div>
            </div>
        </div>
    </div>

    <div id="carouselExampleIndicators" class="carousel slide main-slider" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="images/slider/slider-img-01.jpg" alt="First slide image">
                <div class="carousel-caption d-none d-md-block">
                    <div class="row">
                        <div class="col-md-6 slider-left">
                            <h2>IS THIS A NEW BEGINNING <br>FOR ME?</h2>
                            <ul>
                                <li>Choose an Advisor</li>
                                <li>Click "Chat" or "Call"</li>
                                <li>Click "Chat" or "Call"</li>
                                <li>Complete Registration</li>
                                <li>Enjoy conversation</li>
                            </ul>
                            <span class="getStarted large-btn">Get Started</span>
                        </div>
                        <div class="col-md-6 slider-right">
                            <div class="search-option">
                                <form class="form-inline" method="get" action="/psychics">
                                    <input class="form-control col-sm-8" type="search" name="searchedExpert"
                                           aria-label="Search">
                                    <button class="search-btn btn btn-outline-success my-2 my-sm-0 col-md-4"
                                            type="submit">Search
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/slider/slider-img-01.jpg" alt="Second slide image">
                <div class="carousel-caption d-none d-md-block">
                    <div class="row">
                        <div class="col-md-6 slider-left">
                            <h2>IS THIS A NEW BEGINNING <br>FOR ME?</h2>
                            <ul>
                                <li>Choose an Advisor</li>
                                <li>Click "Chat" or "Call"</li>
                                <li>Click "Chat" or "Call"</li>
                                <li>Complete Registration</li>
                                <li>Enjoy conversation</li>
                            </ul>
                            <a href="#" class="large-btn"> Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/slider/slider-img-01.jpg" alt="Third slide image">
                <div class="carousel-caption d-none d-md-block">
                    <div class="row">
                        <div class="col-md-6 slider-left">
                            <h2>IS THIS A NEW BEGINNING <br>FOR ME?</h2>
                            <ul>
                                <li>Choose an Advisor</li>
                                <li>Click "Chat" or "Call"</li>
                                <li>Click "Chat" or "Call"</li>
                                <li>Complete Registration</li>
                                <li>Enjoy conversation</li>
                            </ul>
                            <a href="#" class="large-btn"> Get Started</a>
                        </div>
                        <!-- <div class="col-md-6 slider-right">
                                <div class="search-option">
                                    <form class="form-inline">
                                        <input class="form-control col-sm-8" type="search" aria-label="Search">
                                        <button class="search-btn btn btn-outline-success my-2 my-sm-0 col-md-4" type="submit">Search</button>
                                    </form>
                                </div>
                            </div> -->
                    </div>

                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- slider ends -->
    <div class="container offers">
        <div class="row">
            <div class="col-md-6 special-offer">
                <div class="card bg-dark text-white">
                    <img src="images/offers/image-01.jpg" alt="Special offer image">
                    <div class="card-img-overlay">
                        <!-- <h5 class="card-title">Card title</h5> -->
                        <p class="card-text">
                            GET 3 free minutes<br> and 60% OFF first reading
                        </p>
                        <!-- <p class="card-text">Last updated 3 mins ago</p> -->
                        <a href="#" class="large-btn">Special Offer</a>
                    </div>
                </div>

            </div>
            <div class="col-md-6 special-offer free-horoscope">
                <div class="card bg-dark text-white">
                    <img src="images/offers/image-02.jpg" alt="Special offer image">
                    <div class="card-img-overlay">
                        <p class="card-text">Free Horoscopes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- special offers end -->
    <div class="container-fluid sortby">
        <div class="container">
            <div class="row">
                <div class="col-md-3 offset-md-9">
                    <div class="form-group row">
                        <label for="inputSortby" class="col-md-4 col-form-label"><strong>Sort by:</strong></label>
                        <div class="col-md-8">
                            <form action="/psychics" method="get" id="sortbyForm">
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
        </div>
    </div>
    <!-- sort by ends -->


    <section class="psychics-available" style="background: #d3c6e0;padding-bottom: 25px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    @if(count($users) > 0)
                        <h2><span>{{ $countUser }}</span> Psychics available now. Choose yours! </h2>
                    @else
                        <h2><span>0 </span> Psychics available now </h2>
                    @endif
                </div>
            </div>
            <!-- heading ends -->
            <div class="row available-psychics">
                @if(!empty($currentUser))
                    <input type="hidden" id="loggedInOrNOt" value="{{ $currentUser->screen_name }}">
                @else
                    <input type="hidden" id="loggedInOrNOt" value="notLogin">
                @endif

                @if(count($users) > 0)
                    @php($index = 0)
                    @foreach($users as $user)
                        <div class="col-md-3 online-psychic">
                            <div class="online-psychic_details">
                                @if($user->expert_status == 1)
                                    <h3>Busy</h3>
                                @elseif($user->is_active_now == 'active')
                                    <h3>Online</h3>
                                @else
                                    <h3>Offline</h3>
                                @endif

                                <div class="row profile-details">
                                    <div class="col-md-6 col-6 profile-image">
                                        <img src="{{ $user->avatar }}" alt="psychic profile pic">
                                    </div>
                                    <div class="col-md-6 col-6 profile-name">
                                        <p>
                                            <a href="/psychic/{{$user->screen_name}}/4">
                                                <strong>{{ \Illuminate\Support\Str::limit($user->screen_name, 15) }}</strong>
                                            </a>

                                        </p>
                                        <span style="overflow:hidden">{{ \Illuminate\Support\Str::limit($user->spec_in, 13) }}</span>
                                    </div>
                                </div>
                                <p style="overflow:hidden;min-height: 85px">
                                    {{ \Illuminate\Support\Str::limit($user->brief_intro, 150) }}
                                </p>
                                <div class="row profile-info">
                                    <div class="col-md-4 text-center profile-info__time">
                                        <p>Free Min </p>
                                        <p><strong>3</strong></p>
                                    </div>
                                    <div class="col-md-4 text-center profile-info__rating">
                                        <p><a href="/psychic/{{$user->screen_name}}/4" style="color:black!important;">Rating</a>
                                        </p>
                                        <p>
                                            @if(!empty($avgArray))
                                                @for($i = 0 ; $i < $avgArray[$index] ;$i ++)
                                                    <i class="ti-star" style="color:#db297f"></i>
                                                @endfor
                                            @endif

                                        </p>
                                    </div>
                                    <div class="col-md-4 text-center profile-info__reviews">
                                        <p><a href="/psychic/{{$user->screen_name}}/4" style="color:black!important;">Reviews</a>
                                        </p>
                                        @if(!empty($revievArray))
                                            <p><strong>{{ $revievArray[$index] }}</strong></p>
                                        @endif
                                    </div>
                                </div>
                                @php($index++)
                                <div class="profile-charge">
                                    <p class="text-center"><img src="{{ asset("images/small-icons/ic-msg-color.png") }}"
                                                                alt="message icon">
                                        ${{$user->fee_chat}}
                                    {{--<span>$2/min</span></p>--}}
                                </div>
                                <div class="online-buttons text-center">

                                        @if($user->is_active_now == 'active' && $user->expert_status == 0)
                                            <a data-toggle="modal" data-target="#chatStartModal{{ $user->id }}" href="" class="normal-btn">Chat
                                                <img src="{{ asset("images/small-icons/ic-msg-white.png") }}" alt="message icon">
                                            </a>
                                        @endif

                                    @if(!empty(\Illuminate\Support\Facades\Auth::user()))
                                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'client')
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
                                         <div id="startWithout2points{{ $user->id }}" class="modal fade start-without-2" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content" style="background: transparent;border: none;">
                                                            <div class="modal-body">
                                                                <div class="modal-inner">
                                                                    {{--MODAL STEP 2 LOGIN MODAL--}}
                                                                    <div class="without_2_points">
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
                                                                                            onclick="withoutstepslogin(this,{{ $user->id }})">
                                                                                        Sign In
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{--END MODAL STEP 2 LOGIN MODAL--}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                    @endif
                                            @if(!empty(Auth::user()))
                                                @if(Auth::user()->role == 'client')
                                        <a href="{{route('messages',['expert'=>$user->id]) }}" class="normal-btn">Mail <img src="{{ asset("images/small-icons/ic-mail.png") }}" alt="mail icon"></a>
                                               @endif
                                           @else
                                                <a data-toggle="modal" data-target="#startWithout2points{{ $user->id }}" href="" class="normal-btn">Mail <img src="{{ asset("images/small-icons/ic-mail.png") }}" alt="mail icon"></a>
                                            @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>&nbsp;</h2>
                </div>
            </div>
        </div>

        @if(!empty($currentUser))
            @if($currentUser->role == 'client')
                <div class="session-end-modal" style="display: none">
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
                                        <input class="count-checker" type="hidden" name="rates" id="expert_rating"
                                               value="">
                                        <i class="ti-star star" id="1"></i>
                                        <i class="ti-star star" id="2"></i>
                                        <i class="ti-star star" id="3"></i>
                                        <i class="ti-star star" id="4"></i>
                                        <i class="ti-star star" id="5"></i>
                                        <hr class="sessia-hr-2">
                                    </div>
                                    <p class="sessia-rating-2">Thanks you for rating this session</p>
                                </div>
                                <div class="sessia-share">
                                    <p>Share your experience</p>
                                    <textarea class="form-control" rows="3" placeholder="Type here"
                                              name="text"></textarea>
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

    </section>

    <!-- view more starts now -->
    <div class="container-fluid view-more-psychics">
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="/psychics"> View More Psychics </a>
            </div>
        </div>
    </div>
    <!-- Psychic available section ends -->

    <section class="choose-psychic">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Why Choose <span>Psychics Voice</span></h2>
                </div>
            </div>
        </div>
        <!-- heading ends -->
        <div class="container-fluid choose-psychic-cat">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="main-cat">
                            <img src="{{ asset("images/why-choose/img-choose-01.png") }}" alt="psychics expert icon"
                                 class="img-fluid rounded">
                        </div>
                        <p> P sychics Experts Hand Picked<br>From Across the <br>Country
                        </p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="main-cat">
                            <img src="{{ asset("images/why-choose/img-choose-02.png") }}" alt="satisfied and loved icon"
                                 class="img-fluid rounded">
                        </div>
                        <p>Thousands of Stistied & <br>loyal Customers
                        </p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="main-cat">
                            <img src="{{ asset("images/why-choose/img-choose-03.png") }}" alt="private icon"
                                 class="img-fluid rounded">
                        </div>
                        <p> All Readings are Private <br>& Confidential
                        </p>
                    </div>
                </div>
            </div>
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
                        <p>Online Marketer? Blogger? Webmaster? Promote our Psychic Advice Platform and earn up to $150
                            per New Paying Client. </p>
                        <a href="#">Become an affiliate</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="join-psychic_process">
                        <h3>Are you a Psychic?</h3>
                        <p>Join with Psychics Voice today to engage with thousands of new clients via online chat, phone
                            or email.</p>
                        <span id="joinPsychicAsExpert">Join as a Psychics Voice</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if(!empty(\Illuminate\Support\Facades\Auth::user()))
        <input type="hidden" id="userBalance" value="{{ \Illuminate\Support\Facades\Auth::user()->funds }}">
    @endif
    @if(!empty(\Illuminate\Support\Facades\Auth::user()))
        @if(\Illuminate\Support\Facades\Auth::user()->role == "expert")
            <input type="hidden" id="expertFeeChat" value="{{ \Illuminate\Support\Facades\Auth::user()->fee_chat }}">
        @endif
    @endif


@endsection




