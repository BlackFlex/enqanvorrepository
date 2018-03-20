@if(!empty(\Illuminate\Support\Facades\Auth::user()))
    @if(\Illuminate\Support\Facades\Auth::user()->role == "expert")

        <div class="modal fade user-chat-modal" id="openMessageWindowForExpert" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog user-chat-modal chat-start-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-inner">
                            <div class="mod-inner">
                                {{--CHATING WINDOW--}}
                                <div class="main-conversation-windows">
                                    <div class="left-section" style="text-align: center">
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
                                        <span class="chat-timer" id="chatTimer__">

                                            </span>

                                        <div class="person-image-place">
                                            <div class="person-avatar-container">
                                                <img src="" alt="" id="avatar__">
                                            </div>
                                        </div>

                                        <div class="person-username" id="userName__">

                                        </div>
                                        <div class="howMuchText">
                                            Fee/minute
                                        </div>
                                        <div class="howMuchNum">
                                            ${{ \Illuminate\Support\Facades\Auth::user()->fee_chat }}
                                        </div>
                                    </div>
                                    <div class="right-section">
                                        <div class="right-section-top-header">


                                            <div class="viewSessionDetails expertuserstbuttons"
                                                 onclick="showPaymentHistory()" title="Payment History"
                                                 style="display: inline-block">
                                                <img class="expertButtons" src="{{ asset("images/icons/eye.png") }}"
                                                     alt="">
                                            </div>
                                            <div class="blockUserBlock expertuserstbuttons" onclick="blockUser()"
                                                 title="Block User" style="display: inline-block">
                                                <img class="expertButtons" src="{{ asset("images/icons/person.png") }}"
                                                     alt="">
                                            </div>


                                            <span>HANGOUT</span>
                                            <span class="chatHangoutButton closingButtons">
                                                    <i class="ti-close"></i>
                                                </span>
                                        </div>
                                        <div class="main-messages-place" id="expertWaitFunds__">

                                            {{-- MESSIGING INFO WINDOW --}}
                                            <div class="mess-info">
                                                <div class="infoLeft">
                                                    User Funds Ended!
                                                </div>

                                                <div class="infoRight">
                                                    is about to run out of funds 1 minute and will require a top
                                                    up in order to continue the reading Per minute fee: 1.99$/min
                                                </div>
                                            </div>


                                        </div>

                                        <div class="messages-send-place">
                                            <div class="userLogo">
                                                <img src="{{ \Illuminate\Support\Facades\Auth::user()->avatar }}"
                                                     alt="">
                                                <div class="isTypingUser"></div>
                                            </div>

                                            <input type="text" class="psychic-send" id="textToSendUser__"
                                                   placeholder="Type message here">

                                            <button class="snd-mess" onclick="messageSendToUser(this)">Send</button>
                                            <div class="add-file-per-minute">

                                                <input type="file" id="hiddenFile">
                                                <label for="hiddenFile">
                                                    <i class="ti-clip"></i>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="mod-background"></div>
                            <img src="{{ asset("images/bg.png") }}" alt="" class="start-conversation">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif


