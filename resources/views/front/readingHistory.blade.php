@extends('front.layout')
@section('content')
    <div class="container">
        <div class="reding-block">
            <h3>Reading History</h3>
            <div class="reading-buttons">
                <a href="{{route('reading-history', ['slug' => 'all'])}}" {{(request()->route()->parameter('slug')=='all')?'class=active':''}}>All</a>
                <a href="{{route('reading-history', ['slug' => 'chat'])}}" {{(request()->route()->parameter('slug')=='chat')?'class=active':''}}>Chats</a>
                <a href="{{route('reading-history', ['slug' => 'paid'])}}" {{(request()->route()->parameter('slug')=='paid')?'class=active':''}}>Calls</a>
                <a href="{{route('reading-history', ['slug' => 'private'])}}" {{(request()->route()->parameter('slug')=='private')?'class=active':''}}>Private
                    Message</a>
            </div>

            <div class="reading-content">
                <div class="modal-content-payments">
                    <div class="modal-body-payments">
                        <div class="modal-credit-payments">
                            <p>Show activity from</p>
                            <select class="all-payments-payments">
                                <option>All</option>
                            </select>
                            <p class="sess-from-payments">Session From</p>
                            <select class="day-payments">
                                <option value="">1 Januare,2018</option>
                            </select>
                            <span>To</span>
                            <select class="day-1-payments">
                                <option value="">20 February,2018</option>
                            </select>
                            <a href="#">Update</a>
                        </div>

                        <table class="rating-payments">
                            <thead>
                            <tr>
                                <th class="w-25-payments">DATE & TIME</th>
                                <th class="w-25-payments">CLIENT NAME</th>
                                <th class="w-25-payments">SUBJECT</th>
                                <th class="w-25-payments">RATING</th>
                            </tr>
                            </thead>
                        </table>
                        <div class="modal-table-payments">
                            <div class="modal-table-singl-payments">
                                <table>
                                    @php ($index = 0)
                                    @foreach($histories as $history)
                                        <tr>
                                            <td>{{$history->created_at}}</td>
                                            <td class="w-25-payments">{{$history->first_name}} {{$history->last_name}}
                                                @if($history->avatar ==  "storage/avatars///default_image.jpg")
                                                    <img src="/{{$history->avatar}}" width="20px" alt="">
                                                @else
                                                    <img src="{{$history->avatar}}" width="20px" alt="">
                                                @endif
                                            </td>
                                            <td class="text-pink-payments">@if($history->type == 1) ONLINE CHAT
                                                SESSION @endif
                                            </td>
                                            @if($history->status == -2)
                                                <td class="text-silver-payments">
                                                    Missed Call (<a href=""><span style="color: #da297f"><b>send 3 free minutes</b></span></a>)
                                                </td>
                                            @elseif(!empty($ratesArray))
                                                <td class="text-silver-payments">
                                                    @if($ratesArray[$index] == 0)
                                                        Not Rated
                                                    @else
                                                        @for($i = 0 ; $i < $ratesArray[$index];$i++)
                                                            <i class="fas fa-star" style="color:#da29a4"></i>
                                                        @endfor
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                        @php ($index++)
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
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
@endsection
