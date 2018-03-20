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
                                <a href="{{ URL::to('/general-settings') }}"><li data-index = '0' class="infoChangeButton colorPurple"><span class="triangleRight"></span> General</li></a>
                                <a href="{{ URL::to('/personal-settings') }}"><li data-index = '1' class="infoChangeButton">Personal Information</li></a>
                                <a href="{{ URL::to('/contact-information-settings') }}"><li data-index = '2' class="infoChangeButton">Contact Information</li></a>
                                <a href="{{ URL::to('/email-settings') }}"><li data-index = '3' class="infoChangeButton">Email Settings</li></a>
                                <a href="{{ URL::to('/payment-settings') }}"><li data-index = '4' class="infoChangeButton">Payment Settings</li></a>
                            </ul>
                        </div>
                        <div class="drop-seting-right">
                            <ul>

                                @if( ! empty($returningMessage))
                                    <div class="returningMessage">
                                        <h3>{{ $returningMessage }}</h3>
                                    </div>
                                @endif

                                <li>General Settings</li>
                            </ul>
                        </div>
                    </div>
                </div>



                <div class="col-md-6 col-sm-6 col-xs-12 infoChangeBlock displayBlock" id="generalInfo">
                    <div class="setings-input">
                        <form class="" method="post" action="{{ \Illuminate\Support\Facades\URL::to('/edit-user-general-information') }}">
                            {{ csrf_field() }}
                           <div class="rw-block">
                               <label for="newEmail">Email:</label>
                               <input type="email" name="newEmail" class="form-control" id="newEmail" value="{{ $user->email }}">
                           </div>
                           <div class="rw-block">
                               <label for="newUsername">User Name:</label>
                               <input type="text" name="newUsername" class="form-control" id="newUsername" value="{{ $user->screen_name }}">
                           </div>
                            <div class="rw-block">
                                <label for="newPassword">New Password:</label>
                                <input type="password" name="newPassword" class="form-control" id="newPassword" value="">
                                <span class="showUserPassword"><i class="ti-eye"></i></span>
                            </div>
                            <div class="rw-block">
                                <label for="confirmNewPassword">Confirm New Password:</label>
                                <input type="password" name="confirmedNewPassword" class="form-control" id="confirmNewPassword">
                                <span class="showUserPassword"><i class="ti-eye"></i></span>
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
