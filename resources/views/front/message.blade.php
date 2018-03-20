@extends('front.layout')
@section('content')
    <div class="container">
        <div class="pshics-block" style="border-bottom: none!important;">

            <div class="row">
                <div class="col-12">
                    <h3 style="border-bottom: none!important;">All messages</h3>
                </div>



                {{--IN CASE IF THERE IS NO ANY MESSAGE--}}
                {{--<p>You don't have any new messages.</p>--}}
                {{--<button href="">Start your reading now</button>--}}


                <div class="message-box col-12">
                    <div class="row custom-light-border-all">
                        <div class="custom-headers col-lg-4 col-md-4 col-sm-12" style="padding: 0">

                            {{--HEADERS IN LEFT SIDE--}}
                            <div class="row" style="padding: 0px 15px;">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="message-box-header hd active-mess-header" data-index="0" onclick="updateFrame(this)" data-show="conversations">
                                            Inbox
                                        </div>

                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="row">
                                        <div class="message-box-header hd notactive-mess-header" data-index="1" onclick="updateFrame(this)" data-show="new-conversations">
                                            New
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @if(Auth::user()->avatar)
                                <input type="hidden" class='corrent_user_avatar' value='<img style="border-radius: 50%" src="{{ Auth::user()->avatar }}" alt="psychic profile pic" width="40px">'>
                            @else
                                <input type="hidden" class='corrent_user_avatar' value="{{ Auth::user()->screen_name[0] }}">
                            @endif


                            {{--USER WITH WHOM YOU HAVE CONVERSATIO--}}
                            <div class="usersconversations mes display-block">
                                @if(count($usersHaveConversation) > 0)
                                    @foreach($usersHaveConversation as $key => $userToDisplay)
                                        <div class="row mess-user-line @if ($key === 0) mess-active-user-conf mess-first-user @endif  @if ($key === (count($usersHaveConversation)-1)) mess-last-user @endif"
                                             onclick="updateMessWindow(this)">
                                            <input type="hidden" value="{{ $userToDisplay->screen_name }}" class="screenName">
                                            <input type="hidden" value="{{ $userToDisplay->id }}" class="userId">
                                            <input type="hidden" value="{{ $conversationSubjects[$key] }}" class="conversationSubject">
                                            <input type="hidden" value="{{ $blockedOrNot[$key] }}" class="ttHHy">
                                            <input type="hidden" value="{{ $conversationIds[$key] }}" class="conv_II">
                                            <input type="hidden" value="{{ $userToDisplay->avatar }}" class="userAv">
                                            <div class="conf-user">
                                                <div class="user-photo-container">
                                                    <div class="user-active-light  @if($userToDisplay->is_active_now == 'active') display-block @else display-none @endif"></div>
                                                        @if($userToDisplay->avatar)
                                                            <div class="user-photo" id="user-main-photo">
                                                                <img src="{{ $userToDisplay->avatar }}" alt="psychic profile pic" width="100%">
                                                            </div>
                                                        @else
                                                            <div class="user-photo has-no-image">
                                                                {{ $userToDisplay->screen_name[0] }}
                                                            </div>
                                                        @endif
                                                </div>
                                                <div class="name-and-sub">
                                                    <span class="mess-user-name">{{ $userToDisplay->screen_name }}
                                                        <span class="mess-user-last-seen">8:45 AM</span>
                                                    </span>
                                                    <span class="mess-subject">{{ \Illuminate\Support\Str::limit($conversationSubjects[$key] , 30) }}
                                                        <span class="mess-user-unread-messages">{{ $unseeMessages[$key] }}</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif


                            </div>



                            {{--NEW USERS ADD BLOCK --}}
                            <div class="new-users-add-place mes display-none">

                                {{--USER FOUND CONTAINER--}}
                                <div class="user-found-container">
                                    <div class="mess-user-line mess-active-user-conf mess-first-user"></div>
                                </div>

                                {{--FOR SEARCH--}}
                                <div class="contact-search-box">
                                    <input type="text" id="find_user" class="user-contact-srch" placeholder="Search Contacts">
                                    <span class="srch-contact-loop">
                                        <i class="ti-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-8 col-md-8 col-sm-12 massages-box-inner" style="border-left: 1px solid #dddfe3;">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="message-box-header-right-side display-block">
                                            <div class="mess-user-right-side  mess-user-av-only-tex-little"></div>
                                            <div class="mess-user-right-side-name"></div>
                                            <div class="mess-block-right-side-top-subject">Subject:<span class="mess-subject-description"></span></div>
                                            <div class="mess-header-actions"></div>
                                            <div class="mess-box-actions">
                                                <ul class="mess-actions-list">
                                                    <li onclick="updateUsersConversations()" class="hover-action"><span>Refresh <i class="ti-reload"></i></span></li>
                                                    <li data-toggle="collapse" data-target="#delConversation" class="hover-action">Remove <i class="ti-trash"></i>
                                                        <div class="collapse" id="delConversation">
                                                            <span onclick="removeUserConversation()" class="delConversation" style="color: red">Yes</span>
                                                            <span class="delConversation" data-toggle="collapse" data-target="#delConversation" style="color: green">No</span>
                                                        </div>
                                                    </li>
                                                    <div class="blockUnblock">
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="message-box-new-message display-none">
                                            <div class="mess-block-right-side-top-subject"><span class="mess-subject-description">New Message</span></div>
                                            <div class="mess-header-actions"></div>
                                            <div class="mess-box-actions">
                                                <ul class="mess-actions-list">
                                                    <li><span>Refresh <i class="ti-reload"></i></span></li>
                                                    <li>Remove <i class="ti-trash"></i></li>
                                                    <li>Block <i class="ti-na"></i></li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row mess-block-main display-block">
                                <div class="mess-blocks-place">
                                    <input type="hidden" value="{{ $user->screen_name[0] }}" id="UnFLL">
                                    @if(count($usersHaveConversation) > 0)
                                        @foreach($messagesInConversation as $message)
                                            @if($message->user_id == $user->id)
                                                <div class="mess-block">
                                                    <div class="sender-av-right has-no-image">
                                                        @if($user->avatar)
                                                            <img style="border-radius: 50%" src="{{ $user->avatar }}" alt="psychic profile pic" width="40px">
                                                            {{--<img style="border-radius: 50%" src="images/psychic/profile-pic-01.jpg" alt="psychic profile pic" width="40px">--}}
                                                        @else
                                                            {{ $user->screen_name[0] }}
                                                        @endif
                                                    </div>
                                                    <div class="main-message">
                                                        <span style="display: block">
                                                            {{ $message->body }}
                                                        </span>
                                                        <span class="mess-timing">
                                                            <span class="mess-timing-icons">
                                                                <i class="ti-calendar"></i>
                                                            </span>29 Jan
                                                            <span class="mess-timing-icons">
                                                                <i class="ti-time"></i>
                                                            </span>
                                                            {{ $message->created_at }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="mess-block">
                                                    <div class="sent-mess sender-av-left has-no-image">
                                                        @if($message->avatar)
                                                            <img style="border-radius: 50%" src="{{ $message->avatar }}" alt="psychic profile pic" width="40px">
                                                        @else
                                                            {{ $message->screen_name[0] }}
                                                        @endif
                                                    </div>
                                                    <div class="main-message-left">
                                                        <span style="display: block">
                                                            {{ $message->body }}
                                                        </span>
                                                        <span class="mess-timing-left">
                                                            <span class="mess-timing-icons" style="margin-left: 0 !important;">
                                                                <i class="ti-calendar"></i>
                                                            </span>29 Jan
                                                            <span class="mess-timing-icons">
                                                                <i class="ti-time"></i>
                                                            </span>09:05 AM
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        {{--/////////////////////invoices////////////////////////////--}}
                                            @foreach($invoiceAmount as $invoice)
                                                @if($message->user_id == $user->id)
                                                    <div class="mess-block">
                                                        <div class="sent-mess sender-av-left has-no-image">
                                                            @if($message->avatar)
                                                                <img style="border-radius: 50%" src="{{ $message->avatar }}" alt="psychic profile pic" width="40px">
                                                            @else
                                                                {{ $message->screen_name[0] }}
                                                            @endif
                                                        </div>
                                                        <div class="main-message-left">
                                                        <span style="display: block">
                                                           Your Invoice Amout is {{$invoice->amount}} $ <br>
                                                            @if($invoice->status==3)
                                                                <span style="color: #ff0000">You Dont Have Enough Money</span>
                                                            @endif
                                                            <br>
                                                            @if($invoice->status>1)
                                                                <form action="/pay-invoice" method="post">
                                                                 <input type="hidden" value="{{$invoice->id}}" name="invoice_id">
                                                                  <input type="hidden" value="{{$invoice->amount}}" name="amount">
                                                                  <input type="hidden" value="{{$invoice->expert_id}}" name="expert_id">
                                                                <button name="status" value="1">Pay</button>
                                                                <button name="status" value="0">Discart</button>
                                                            </form>
                                                            @elseif($invoice->status==1)
                                                                <span style="color: green">Accepted</span>
                                                            @elseif($invoice->status==0)
                                                                <span style="color: red">Rejected</span>
                                                            @endif
                                                        </span>
                                                            <span class="mess-timing-left">
                                                            <span class="mess-timing-icons" style="margin-left: 0 !important;">
                                                                <i class="ti-calendar"></i>
                                                            </span>29 Jan
                                                            <span class="mess-timing-icons">
                                                                <i class="ti-time"></i>
                                                            </span>09:05 AM
                                                        </span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="mess-block">
                                                        <div class="sender-av-right has-no-image">
                                                            @if($user->avatar)
                                                                <img style="border-radius: 50%" src="{{ $user->avatar }}" alt="psychic profile pic" width="40px">
                                                            @else
                                                                {{ $user->screen_name[0] }}
                                                            @endif
                                                        </div>
                                                        <div class="main-message">
                                                        <span style="display: block">
                                                           Your Invoice Amout is {{$invoice->amount}} $
                                                            <br>
                                                            @if($invoice->status>1)
                                                                <span style="color: #00bfff">In Proccess</span>
                                                            @elseif($invoice->status==1)
                                                                <span style="color: #008000">Accepted</span>
                                                            @elseif($invoice->status==0)
                                                                <span style="color: #ff0000">Rejected</span>
                                                            @endif
                                                        </span>
                                                            <span class="mess-timing">
                                                            <span class="mess-timing-icons">
                                                                <i class="ti-calendar"></i>
                                                            </span>29 Jan
                                                            <span class="mess-timing-icons">
                                                                <i class="ti-time"></i>
                                                            </span>
                                                                {{ $message->created_at }}
                                                        </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                            <input type="hidden" id="hasUserConversation" value="user-has-conversations">
                                        @else
                                        <input type="hidden" id="hasUserConversation" value="user-has-not-conversations">
                                    @endif
                                </div>
                                <div class="mess-send">
                                    <span class="user-is-typing">Typing ...</span>
                                    <span class="conversation-is-blocked">Conversation Is Blocked , You Can NOT Write Messages</span>
                                        <div class="add-file">
                                            <input type="file" id="hiddenFile" name="file">
                                            <label for="hiddenFile"><i class="ti-clip"></i></label>
                                        </div>
                                        <input type="hidden" value="" name="user_to_send" id="user_to_send">

                                        <input type="text" class="mess-textarea" name="text" id="message_to_send" placeholder="Type here...">
                                        <button type="button" class="mess-send-btn" onclick="sendMessageToUser(this)"><i class="fas fa-paper-plane"></i> Send
                                        </button>
                                </div>
                            </div>
                            <div class="row new-contact-add-block display-none">
                                {{ Form::open(array('url' => 'new-conversation-add')) }}
                                  <div class="new-contactsend-inner">
                                      <div class="new-contact">
                                          <span class="contact-description">Consignee:</span>
                                          <span class="new-contacts-names"></span>
                                          <input type="text" disabled required>
                                          <input type="hidden" value="" name="users_info" id="infos">
                                      </div>
                                      <div class="new-contact">
                                          <span class="contact-description">Subject:</span>
                                          <input type="text" value="" name="conversation_subject" required>
                                      </div>
                                      <div class="new-contact">
                                          <span class="contact-description">Message:</span>
                                          <input type="text" value="" name="conversation_message" required>
                                      </div>
                                      <div class="new-contact_send">
                                        <button type="button" class="send-new-request-for-conversation" onclick="checkInputs(this)">
                                            <i class="fas fa-paper-plane" id="new-conversation-request-sender"></i> Send
                                        </button>
                                      </div>
                                  </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- why choose section ends -->
    </div>
    <div class="container" style="padding: 0!important;">
        <div class="row custom-row" style="margin-top: 20px;margin-bottom: 20px;">

            @if($user->role == 'client')
                <div class="col-lg-4 col-md-12">
                    <div class="blockinner">
                        <div class="section-title">
                            Pay The Invoice
                        </div>
                        <div class="section-description">Your current balance is</div>
                        <div class="user-balance">{{$user->funds}} $</div>
                    </div>
                </div>
               <div class="col-lg-4 col-md-12">
                    <div class="blockinner-second">

                        <div class="section-description" style="padding-top: 30px">Pending invoice:</div>
                        {{--<div class="user-balance">Total : {{$invoiceCount}} $</div>--}}
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="blockinner-third">
                        <span class="infoblock"><i class="ti-info-alt"></i></span>
                        <p style="font-size: 14px">You won't be paying for this message. Expert will send an invoice when
                            he/she wants.</p>
                        <span></span>
                        <p style="font-size: 14px;color: red">Decline if an advisor offers you to pay outside the
                            PsychicsVoice website. The offer may be fraudulent in result the swift account Suspension</p>
                    </div>
                </div>
            @else
                <div class="col-md-4">
                    <div class="blockinner">
                        <form action="/add-invoice" method="post">
                            <div class="section-title" style="margin-top: 0">
                                Payment Amount:
                            </div>
                            <div class="section-description"><input type="number" name="amount" id="" min="1" class="expert-payments" placeholder="$1500" required>
                                @if(!empty($usersHaveConversation[0]))
                                    <input type="hidden" value="{{ $usersHaveConversation[0]['id'] }}" id='amout-user-id' name="user_id">
                                @else
                                    <input type="hidden" value="" id='amout-user-id' name="user_id">
                                @endif
                            </div>
                            <div class="user-balance">
                                <button class="expert-send-payment">
                                    SEND
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="blockinner-third">
                            <span class="infoblock1" style="color:red"><i class="fas fa-info"></i></span>
                        <p style="font-size: 14px;color: red">Decline if an advisor offers you to pay outside the
                            PsychicsVoice website. The offer may be fraudulent in result the swift account Suspension</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
