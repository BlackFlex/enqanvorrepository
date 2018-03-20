@extends('front.layout')
@section('content')

    <div class="container">
        <div class="dash-wrap">
            <h3 class="dash-head">My Dashboard
                <span class="user-page-status">Your status:
                    @if($user->is_active_now == 'active')
                        Online
                    @elseif($user->is_active_now == 'notActive')
                        <span style="color: red">Offline</span>
                    @endif
                </span>

                <select name="" id="change-user-st" class="bg-gray-select dash-buttons-wrap change-user-status"
                        style="padding-left: 10px">
                    <option value="notSelected">Change Status</option>
                    <option value="active" @if($user->is_active_now == 'active') selected @endif>Online</option>
                    <option value="notActive" @if($user->is_active_now == 'notActive') selected @endif>Offline</option>
                </select>

                <button class="green-grad dash-buttons-wrap change-user-status">Test Sound</button>
            </h3>
            <hr>
        </div>

        <div class="dash-form-wrap">

            <div class="row">
                <div class="col-md-3">
                    <div class="dash-form-line">
                        <div class="dash-item-wrap green-grad">
                            <i class="fa fa-phone" style="margin:6px"></i>
                        </div>
                        <p>Add Your Phone</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dash-input-wrap">
                        <form action="/dashboard" method="get" id="userPhone">
                            {{csrf_field()}}
                            <input class="" name="userPhone" type="text">
                        </form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dash-select-wrap">
                        <div class="country-selector">
                            <span>Select Country</span>
                            <input type="hidden" value="{{ $countries }}" id="flags">
                            <div class="flags-box displayNoneFlags" id="flags-box">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="dash-buttons-wrap">
                        <button class="green-grad" id="addUSerPhone">Edit</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">

                    <div class="dash-form-line">
                        <div class="dash-item-wrap green-grad">
                            <i class="fa fa-credit-card"></i>
                        </div>
                        <p>$ {{ \Illuminate\Support\Facades\Auth::user()->funds }}</p><span> (3 free minutes)</span>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="dash-input-wrap">
                        <input class="" type="text" min="0" value=""
                               placeholder="${{ \Illuminate\Support\Facades\Auth::user()->fee_chat }}" name="expertFee">
                    </div>

                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <div class="dash-buttons-wrap">
                        <button class="green-grad" id="expertEarnings">My Earnings</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="dash-form-line">
                        <div class="dash-item-wrap green-grad">
                            <i class="fa fa-check"></i>
                        </div>
                        <p style="font-size: 15px">Auto withdraw every month:
                            @if(Auth::user()->auto_withdraw == 0)
                                Off
                            @endif
                            @if(Auth::user()->auto_withdraw == 1)
                                On
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dash-input-wrap">
                        <input class="" type="text">
                    </div>

                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <div class="dash-buttons-wrap">
                        @if(Auth::user()->auto_withdraw == 0)
                            <button class="green-grad">
                                <a href="/auto_withdraw-on" style="color: white">On</a>
                            </button>
                        @endif
                        @if(Auth::user()->auto_withdraw == 1)
                            <button class="green-grad">
                                <a href="/auto_withdraw-off" style="color: white">Off</a>
                            </button>
                        @endif


                    </div>
                </div>
            </div>

        </div>


        <div class="dash-wrap">
            <h3 class="dash-head">Last feedbacks</h3>
            <hr>
            @if(!empty($rates))
                @if(count($rates) == 0)
                    <p>You don't have any feedback yet</p>
                @endif
            @endif
            @if(!empty($rates))
                <div class="row">
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
            @endif
            <div class="mt-100"></div>
            <hr>
        </div>


    </div>


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
                        <a href="#">Join as a Psychics Voice</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- join affiliate ends -->
@endsection
