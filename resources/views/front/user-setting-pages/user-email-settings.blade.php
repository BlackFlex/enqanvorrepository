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
                                    <li data-index='3' class="infoChangeButton colorPurple"><span
                                                class="triangleRight"></span>Email Settings
                                    </li>
                                </a>
                                <a href="{{ URL::to('/payment-settings') }}">
                                    <li data-index='4' class="infoChangeButton">Payment Settings</li>
                                </a>
                            </ul>
                        </div>

                        <div class="drop-seting-right">

                            @if( ! empty($returningMessage))
                                <div class="returningMessage">
                                    <h3>{{ $returningMessage }}</h3>
                                </div>
                            @endif

                            <h5><b>Email Settings</b></h5>

                            @if(Auth::user()->role == 'client')
                                <form action="/email-settings-main" method="post">
                                    <div class="settings-block" style="width: 348px;padding-left: 20px;">


                                        @if(!empty($settings->message_from_adv))
                                            <p><input type="checkbox" name="message_from_adv" checked> Message from
                                                advisors
                                            </p>
                                        @else
                                            <p><input type="checkbox" name="message_from_adv"> Message from advisors</p>
                                        @endif

                                        @if(!empty($settings->adv_response))
                                            <p><input type="checkbox" name="adv_response" checked> Advisors' responses
                                                to my
                                                questions</p>
                                        @else
                                            <p><input type="checkbox" name="adv_response"> Advisors' responses to my
                                                questions</p>
                                        @endif

                                        @if(!empty($settings->special_offers))
                                            <p><input type="checkbox" name="special_offers" checked> Special offers and
                                                promotions</p>
                                        @else
                                            <p><input type="checkbox" name="special_offers"> Special offers and
                                                promotions
                                            </p>
                                        @endif

                                        @if(!empty($settings->daily_horo))
                                            <p><input type="checkbox" name="daily_horo" checked> Daily horoscopes</p>
                                        @else
                                            <p><input type="checkbox" name="daily_horo"> Special offers and promotions
                                            </p>
                                        @endif

                                        @if(!empty($settings->weekly_horo))
                                            <p><input type="checkbox" name="weekly_horo" checked> Weekly horoscopes</p>
                                        @else
                                            <p><input type="checkbox" name="weekly_horo"> Weekly horoscopes</p>
                                        @endif

                                        @if(!empty($settings->monthly_horo))
                                            <p><input type="checkbox" name="monthly_horo" checked> Monthly Love
                                                horoscopes
                                            </p>
                                        @else
                                            <p><input type="checkbox" name="monthly_horo"> Monthly Love horoscopes</p>
                                        @endif

                                        @if(!empty($settings->monthly_career_horo))
                                            <p><input type="checkbox" name="monthly_career_horo" checked> Monthly Career
                                                horoscopes</p>
                                        @else
                                            <p><input type="checkbox" name="monthly_career_horo"> Monthly Career
                                                horoscopes
                                            </p>
                                        @endif

                                        @if(!empty($settings->monthly_career_horo))

                                            <p><input type="checkbox" name="articles_news_updates" checked>
                                                Articles,News &
                                                Updates</p>
                                        @else
                                            <p><input type="checkbox" name="articles_news_updates"> Articles,News &
                                                Updates
                                            </p>
                                        @endif
                                    </div>
                                    <div class="rw-block">
                                        <button type="submit">Save Changes</button>
                                    </div>

                                </form>
                            @endif


                            @if(Auth::user()->role == 'expert')
                                <form action="/email-settings-main-expert" method="post">

                                    @if(!empty($settings->send_me_a_message))
                                        <p><input type="checkbox" name="send_me_a_message" checked>Send me a message </p>
                                    @else
                                        <p><input type="checkbox" name="send_me_a_message" >Send me a message </p>
                                    @endif
                                        @if(!empty($settings->anu_for_clients))
                                            <p><input type="checkbox" name="anu_for_clients" checked>Articles News & Updates for clients</p>
                                        @else
                                            <p><input type="checkbox" name="anu_for_clients" >Articles News & Updates for clients</p>
                                        @endif

                                        @if(!empty($settings->anu_for_psychics))
                                            <p><input type="checkbox" name="anu_for_psychics" checked>Articles News & Updates for psychics</p>
                                        @else
                                            <p><input type="checkbox" name="anu_for_psychics" >Articles News & Updates for psychics</p>
                                        @endif

                                        @if(!empty($settings->special_offers_for_clients))
                                            <p><input type="checkbox" name="special_offers_for_clients" checked>Special offers and promotions for clients</p>
                                        @else
                                            <p><input type="checkbox" name="special_offers_for_clients" >Special offers and promotions for clients</p>
                                        @endif

                                        @if(!empty($settings->special_offers_for_psychics))
                                            <p><input type="checkbox" name="special_offers_for_psychics" checked>Special offers and promotions for psychics</p>
                                        @else
                                            <p><input type="checkbox" name="special_offers_for_psychics">Special offers and promotions for psychics</p>
                                        @endif
                                    <div class="rw-block">
                                        <button type="submit">Save Changes</button>
                                    </div>
                                </form>
                            @endif
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
