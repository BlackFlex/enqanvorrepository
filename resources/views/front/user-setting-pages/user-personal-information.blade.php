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
                                <a href="{{ URL::to('/personal-settings') }}"><li data-index = '1' class="infoChangeButton colorPurple"><span class="triangleRight"></span>Personal Information</li></a>
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

                                <li>Personal Information</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12" id="personalInfo">
                    <div class="setings-input">
                        <form class="" method="post" action="{{ \Illuminate\Support\Facades\URL::to('/edit-user-personal-information') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="userRole" value="{{ $user->role }}">

                            <div class="rw-block">
                                <label for="newUserAvatar">Avatar:</label>
                                <div class="panel panel-body">
                                    <div class="span4 cropme ogImage" @if($user->avatar)style="background: url('{{$user->avatar}}')"@endif></div>
                                </div>
                                <input type="file" class="form-control" id="newUserAvatar" value="{{ $user->avatar }}">
                                <input type="hidden" name="newUserAvatar" id="form_propertyOgImage">
                            </div>
                            <div class="rw-block">
                                <label for="newScreenName">First Name:</label>
                                <input type="text" name="newFirstName" class="form-control" id="newFirstName" value="{{ $user->first_name }}">
                            </div>

                            <div class="rw-block">
                                <label for="newScreenName">Last Name:</label>
                                <input type="text" name="newLastName" class="form-control" id="newLastName" value="{{ $user->last_name }}">
                            </div>

                            <div class="rw-block">
                                <label for="newScreenName">Screen Name:</label>
                                <input type="text" name="newScreenName" class="form-control" id="newScreenName" value="{{ $user->screen_name }}">
                            </div>


                            @if(\Illuminate\Support\Facades\Auth::user()->role == "expert")
                                <div class="rw-block">
                                    <label for="newTitle">Title:</label>
                                    <input type="text" name="newTitle" class="form-control" id="newTitle" value="{{ $user->user_title }}">
                                </div>

                                <div class="rw-block">
                                    <label for="newSpecIn">Specializing in:</label>
                                    <input type="text" name="newSpecIn" class="form-control" id="newSpecIn" value="{{ $user->spec_in }}">
                                </div>

                                <div class="rw-block">
                                    <label for="newFeeMin">Fee/chat:</label>
                                    <input type="number" step="0.01" name="newFeeMin" min="1" class="form-control" id="newFeeMin" value="{{ $user->fee_chat }}">
                                </div>

                                <div class="rw-block">
                                    <label for="newFeeEmail">Fee/email:</label>
                                    <input type="number" step="0.01" name="newFeeEmail" min="1" class="form-control" id="newFeeEmail" value="{{ $user->fee_email }}">
                                </div>
                            @endif


                            <div class="rw-block">
                                <label for="newGender">Gender:</label>

                                    <div class="user-info">

                                        <div class="gender-select">
                                            <input type="radio" name="newGender" @if($user->user_gender == 'female') checked @endif class="gender-select1" id="newGender1" value="female">
                                            <label style="width: 60px" for="newGender1">female</label>

                                            <input type="radio" name="newGender" @if($user->user_gender == 'male') checked @endif class="gender-select1" id="newGender2" value="male">
                                            <label style="width: 60px" for="newGender2">male</label>
                                        </div>
                                    </div>
                            </div>

                            <div class="rw-block">
                                <label for="newBirth">Date Of Birth:</label>
                                <input type="date" name="newBirth" class="form-control" id="newBirth" value="{{ $user->date_of_birth }}">
                            </div>




                            <div class="rw-block">
                                <label for="newHoroSign">Horo Sign:</label>

                                <input type="hidden" class="horosignselect" value="{{ $user->horo_sign }}">
                                <select id="newHoroSign" lkm="Horoscope Sign" name="newHoroSign"
                                        required="required"
                                        style="
                                            width: 60%;
                                            border: 1px solid #ccc;
                                            padding: 7px;
                                            border-radius: 4px;
                                            background: whitesmoke;
                                        ">
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
                            </div>

                            @if($user->role == 'expert')
                                <div class="rw-block">
                                    <label for="newBriefIntro">Brief Intro:</label>
                                    <textarea type="text" name="newBriefIntro" class="form-control width60perBg" id="newBriefIntro">{{ $user->brief_intro }}</textarea>
                                </div>

                                <div class="rw-block">
                                    <label for="newMyServices">My Services:</label>
                                    <textarea type="text" name="newMyServices" class="form-control width60perBg" id="newMyServices">{{ $user->my_service }}</textarea>
                                </div>

                                <div class="rw-block">
                                    <label for="newDegree">Degree:</label>
                                    <textarea type="text" name="newDegree" class="form-control width60perBg" id="newDegree">{{ $user->degree }}</textarea>
                                </div>

                                <div class="rw-block">
                                    <label for="newExperience">Experience:</label>
                                    <textarea type="text" name="newExperience" class="form-control width60perBg" id="newExperience">{{ $user->exp }}</textarea>
                                </div>

                                <div class="rw-block">
                                    <label for="newLanguage">Language:</label>
                                    <input type="hidden" class="lang" value="{{ $user->language }}">
                                    <select id="newLanguage" lkm="Language" name="newLanguage"
                                            required="required"
                                            style="
                                                width: 60%;
                                                border: 1px solid #ccc;
                                                padding: 7px;
                                                border-radius: 4px;
                                                background: whitesmoke;
                                            ">
                                        <option value="en">English</option>
                                        <option value="hi">hindi</option>
                                    </select>
                                </div>

                            @endif


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
