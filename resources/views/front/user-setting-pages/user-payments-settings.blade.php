@extends('front.layout')
@section('content')



    <div class="container">
        <div class="pshics-block">
            <h3>Settings</h3>
            <div class="row no-gutters">
                <div class="col-md-6 col-sm-6 col-xs-12 ">
                    <div class="setings-block">
                        <div class="drop-seting">
                            <ul>
                                <a href="{{ URL::to('/general-settings') }}">
                                    <li data-index='0' class="infoChangeButton">General</li>
                                </a>
                                <a href="{{ URL::to('/personal-settings') }}">
                                    <li data-index='1' class="infoChangeButton">Personal Information</li>
                                </a>
                                <a href="{{ URL::to('/contact-information-settings') }}">
                                    <li data-index='2' class="infoChangeButton">Contact Information</li>
                                </a>
                                <a href="{{ URL::to('/email-settings') }}">
                                    <li data-index='3' class="infoChangeButton">Email Settings</li>
                                </a>
                                <a href="{{ URL::to('/payment-settings') }}">
                                    <li data-index='4' class="infoChangeButton colorPurple"><span
                                                class="triangleRight"></span>Payment Settings
                                    </li>
                                </a>
                            </ul>
                        </div>
                        <div class="drop-seting-right">
                            <ul>

                                @if( ! empty($returningMessage))
                                    <div class="returningMessage">
                                        <h3>{{ $returningMessage }}</h3>
                                    </div>
                                @endif

                                <li>Payment Settings</li>
                                <p style="    position: absolute;
    top: 30px;
    width: 500px;padding-left: 15px;z-index: 80000">Emails are currently being send to: <b>{{ \Illuminate\Support\Facades\Auth::user()->email }}</b> (<a
                                            href="/general-settings"><span style="color: #d12881"><b>change</b></span></a>)</p>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12" id="personalInfo">
                    <div class="setings-input">

                    </div>
                </div>
            </div>
        </div>
        <!-- why choose section ends -->
        <section class="join-psychic">
            <div class="container">
                <div class="row ">
                    <div class="col-md-6 col-sm-6 col-xs-12 ">
                        <div class="join-psychic_process">
                            <h3>
                                Affiliate program
                            </h3>
                            <p>Online Marketer? Blogger? Webmaster? Promote our Psychic Advice Platform and earn up to
                                $150 per New Paying Client. </p>
                            <a href="#">Become an affiliate</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 ">
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
@endsection
