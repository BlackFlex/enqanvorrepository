@extends('front.layout')
@section('content')
    <div class="container">
        <div class="pshics-block" style="min-height: 10px !important;border-bottom: none">
            <h3>My Favorite Clients</h3>
            <div class="pschtext-block" style="min-height: 10px !important;">
                @if(count($users) == 0)
                    <p>You don't have any favorite Client yet</p>
                @endif

            </div>
        </div>

        <div class="row">
            <div class="expert-contacts-names">
                @foreach($users as $user)
                    <span class="choosenContact">{{ $user->first_name }} {{ $user->last_name }}</span>
                @endforeach
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
    </div>
@endsection
