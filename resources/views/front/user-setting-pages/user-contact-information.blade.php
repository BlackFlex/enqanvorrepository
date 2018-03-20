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
                                <a href="{{ URL::to('/general-settings') }}"><li data-index = '0' class="infoChangeButton">General</li></a>
                                <a href="{{ URL::to('/personal-settings') }}"><li data-index = '1' class="infoChangeButton">Personal Information</li></a>
                                <a href="{{ URL::to('/contact-information-settings') }}"><li data-index = '2' class="infoChangeButton colorPurple"><span class="triangleRight"></span> Contact Information</li></a>
                                <a href="{{ URL::to('/email-settings') }}"><li data-index = '3' class="infoChangeButton">Email Settings</li></a>
                                <a href="{{ URL::to('/payment-settings') }}"><li data-index = '4' class="infoChangeButton">Payment Settings</li></a>
                            </ul>
                        </div>
                        <div class="drop-seting-right">
                            <ul>

                                @if( !empty($returningMessage))
                                    <div class="returningMessage">
                                        <h3>{{ $returningMessage }}</h3>
                                    </div>
                                @endif

                                <li>Contact Information</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12 infoChangeBlock displayBlock" id="generalInfo">
                    <div class="setings-input">
                        <form class="" method="post" action="{{ \Illuminate\Support\Facades\URL::to('/update-user-contact-information') }}">
                            {{ csrf_field() }}

                            <div class="rw-block">
                                <label for="city">City:</label>
                                @if(!empty($userContactInfo[0]->city))
                                    <input type="text" name="city" class="form-control" id="city" value="{{ $userContactInfo[0]->city }}">
                                @else
                                    <input type="text" name="city" class="form-control" id="city" value="">
                                @endif
                            </div>
                            <div class="rw-block">
                                <label for="street">Street:</label>
                                @if(!empty($userContactInfo[0]->street))
                                    <input type="text" name="street" class="form-control" id="street" value="{{ $userContactInfo[0]->street }}">
                                @else
                                    <input type="text" name="street" class="form-control" id="street" value="">
                                @endif
                            </div>
                            <div class="rw-block">
                                <label for="zipCode">Zip Code:</label>
                                @if(!empty($userContactInfo[0]->zip_code))
                                    <input type="text" name="zipCode" class="form-control" id="zipCode" value="{{ $userContactInfo[0]->zip_code }}">
                                @else
                                    <input type="text" name="zipCode" class="form-control" id="zipCode" value="">
                                @endif
                            </div>
                            <div class="rw-block">
                                <label for="country">Country:</label>
                                @if(!empty($userContactInfo[0]->country))
                                    <input type="text" name="country" class="form-control" id="country" value="{{ $userContactInfo[0]->country }}">
                                @else
                                    <input type="text" name="country" class="form-control" id="country" value="">
                                @endif
                            </div>
                            <div class="rw-block">
                                <button type="submit">Save Changes</button>
                            </div>
                        </form>
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
