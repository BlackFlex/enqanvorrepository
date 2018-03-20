/*** BASE URL ***/
var base_url = $('meta[name=base_url]').attr('content');
var hours = 0;
var minutes = 0;
var seconds = 20;
var hoursU = hours;
var minutesU = minutes;
var secondsU = seconds;
var typingInterval = null;
var typingIntervalUser = null;
var currentSessionId = null;
var reqFirstName = null;
var userIndexGeneral = null;
var checkIfRequestExist = null;
var userStatusCheck = $('#UStatus__').val();
var UserToSendIndex = null;
var alertTime = true;
var loggedIn = null;
var timerPl = null;
var canRateChat = false;
var rateWithStars = false;
var whereToSendPayPal = 20;
var money = null;
var fee_chatExpert = $('#expertFeeChat').val()
var timerAcceptChat = null;
var sessionStarted = null;

var arrayOfUserId = [];
console.log(arrayOfUserId)
var arrayOfSessionId = [];

if ($('.preloaderPaymetHistory').length) {
    $('.preloaderPaymetHistory').delay(200).fadeOut(500);
}

$paidSessionWindow = $('#viewSessionPaymenrs');
$historyInner = $('#historyInner');
$addingHistoryPlace = $('#modal-table-singl1');

function showPaymentHistory() {
    $paidSessionWindow.css({
        'z-index': '2000',
        'display': 'block'
    });
    if ($('.preloaderPaymetHistory').length) {
        $('.preloaderPaymetHistory').delay(200).fadeIn(500);
    }
    $.ajax({
        url: base_url + '/get-payment-history',
        data: {
            "sId": currentSessionId
        },
        type: "POST",
        dataType: "json",
        success: function (res) {
            $('.preloaderPaymetHistory').delay(200).fadeOut(500);
            for (i = 0; i < res.length; i++) {
                var line = '<tr class="bg-silver1">\n' +
                    '<td>' + res[i]["created_at"] + '</td>\n' +
                    '<td class="w-40">' + res[i]["description"] + '</td>\n' +
                    '<td>' + res[i]["total"] + '</td>\n' +
                    '<td>' + res[i]["expert_balance"] + '</td>\n' +
                    '</tr>'
                $('#addingPaymentHistory').append(line)
            }
        }
    });
}


$(document).ready(function () {
    $firstPayPaypal = $('.firstPayPaypal');
    $firstPayPaypal.click(function () {
        whereToSendPayPal = $(this).val()
    })


    if (userStatusCheck == 'expert') {
        checkForRequests();
    }

    $star = $('.star');
    $star.mouseover(function () {
        var id = $(this).attr("id");
        $(".star").each(function () {
            if ($(this).attr('id') <= id) {
                $(this).css({'color': '#ae2889'});
            }
            if ($(this).attr('id') > id) {
                $(this).css({'color': '#cccccc'});
            }
        });
        $(this).addClass('numcontrol');

        var star_count = $(this).attr('id');
        $("#expert_rating").val(star_count);

    });
    $star.mouseleave(function () {

        if ($('#1') && $('.count-checker').val() == 1) {
            $(".star").css({'color': '#cccccc'});
            $('.count-checker').val('0');
        }


    });
    $star.click(function () {
        var star_count = $(this).attr('id');
        $("#expert_rating").val(star_count)
    });


    /*** BASIC PLACES OF STEPS ***/
    $basicPlaceOfSteps = $('.main-step-des')
    $basicHeader = $('.chat-start-header')

    /*** BASIC MESSAGE WINDOWS ***/
    $conversationWindow = $(".conversation-window");
    $mainConversationWindow = $(".main-conversation-windows");

    /*** BASIC DECOR LINES ***/
    $decorLine0 = $('.decor-line-first-start');
    $decorLine1 = $('.decor-line-first-step');
    $decorLine2 = $('.decor-line-second-step');
    $decorLine3 = $('.decor-line-third-step');
    /*** BASIC DECOR LINES END ***/

    /*** STEPS BUTTONS ***/
    $step1 = $('.step1')
    $step2 = $('.step2')
    $step3 = $('.step3')
    $step3Button = $('#step3')
    $step4 = $('.step4')
    /*** STEPS BUTTONS END***/

    /*** BODY TITLES ***/
    $step1BodyTytle = $('.des-body-title-step1')
    $step2BodyTytle = $('.des-body-title-step2')
    $step3BodyTytle = $('.des-body-title-step3')
    /*** BODY TITLES END ***/

    /*** BODIES ***/
    $generalBody = $('.des-body');
    $body1 = $('.body1');
    $body2 = $('.body2');
    $body3 = $('.body3');
    /*** BODIES END ***/

    /*** BODY FOOTERS ***/
    $footer1 = $('.minute-chat-body-footer1');
    $footer2 = $('.minute-chat-body-footer2');
    $footer3 = $('.minute-chat-body-footer3');
    /*** END BODY FOOTERS ***/
    $.ajax({
        url: '/delete-conversation-in-session',
        type: "GET"
    });

    /*** STEP BUTTONS CLICKS ***/
    $step2.click(function () {
        /*** DECOR LINES ***/
        $decorLine0.css({
            'display': 'none'
        })
        $decorLine1.css({
            'display': 'none'
        })
        $decorLine2.css({
            'display': 'block'
        })
        $decorLine3.css({
            'display': 'none'
        })

        /*** STEPS BACKGROUNDS ***/
        $step1.css({
            'background': 'linear-gradient(#ae2889,#db297f)',
        })
        $step2.css({
            'background': 'linear-gradient(#ae2889,#db297f)',
        })
        $step3.css({
            'background': '#c584a9',
        })
        $step4.css({
            'background': '#c584a9',
        })


        /*** BODY TITLE HEADERS ***/
        $step1BodyTytle.css({
            'display': 'none'
        })
        $step2BodyTytle.css({
            'display': 'block',
        })
        $step3BodyTytle.css({
            'display': 'none',
        })

        /*** BODIES ***/
        $body1.css({
            'display': 'none'
        })
        $body2.css({
            'display': 'block'
        })
        $body3.css({
            'display': 'none'
        })

        /*** FOOTERS ***/
        $footer1.css({
            'display': 'none'
        })
        $footer2.css({
            'display': 'block'
        })
        $footer3.css({
            'display': 'none'
        })


    })
    $step4.click(function () {

        if (loggedIn == true) {
            /*** DECOR LINES ***/
            $decorLine0.css({
                'display': 'block'
            })
            $decorLine1.css({
                'display': 'none'
            })
            $decorLine2.css({
                'display': 'none'
            })
            $decorLine3.css({
                'display': 'none'
            })

            /*** STEPS BACKGROUNDS ***/
            $step1.css({
                'background': 'linear-gradient(#ae2889,#db297f)',
            })
            $step2.css({
                'background': 'linear-gradient(#ae2889,#db297f)',
            })
            $step3.css({
                'background': 'linear-gradient(#ae2889,#db297f)',
            })
            $step4.css({
                'background': 'linear-gradient(#ae2889,#db297f)',
            })

            /*** BODY TITLE HEADERS ***/
            $step1BodyTytle.css({
                'display': 'flex'
            })
            $step2BodyTytle.css({
                'display': 'none'
            })
            $step3BodyTytle.css({
                'display': 'none'
            })

            /*** BODIES ***/
            $body1.css({
                'display': 'block'
            })
            $body2.css({
                'display': 'none'
            })
            $body3.css({
                'display': 'none'
            })

            /*** FOOTERS ***/
            $footer1.css({
                'display': 'block'
            })
            $footer2.css({
                'display': 'none'
            })
            $footer3.css({
                'display': 'none'
            })
        }
    });

    var sendMessage = $('#message_to_send');
    sendMessage.keypress(function (event) {
        if (event.which == 13) {
            sendMessageToUser($('.mess-send-btn'))
        }
    });


    $star = $('.star');

    $star.mouseover(function () {

        var id = $(this).attr("id");
        $(".star").each(function () {
            if ($(this).attr('id') <= id) {
                $(this).css({'color': '#ae2889'});
            }
            if ($(this).attr('id') > id) {
                $(this).css({'color': '#cccccc'});
            }
        });
        $(this).addClass('numcontrol');

        var star_count = $(this).attr('id');
        $("#expert_rating").val(star_count);

    });


    $star.mouseleave(function () {

        if ($('#1') && $('.count-checker').val() == 1) {
            $(".star").css({'color': '#cccccc'});
            $('.count-checker').val('0');
        }
    });

    $star.click(function () {
        var star_count = $(this).attr('id');
        $("#expert_rating").val(star_count)
    });

    $hangoutButton = $('.chatHangoutButton');
    $hangoutButton.click(function () {
        var hangOurBlock = '<div class="hangoutBlockMainShadow">\n' + '<div class="hangoutBlock">\n' + '<div class="hangoutBlockHeader">\n' + '<span onclick="removeHangoutScreen(this)"><i class="ti-close"></i></span>\n' + '</div>\n' + '<div class="hangoutBlockBody">\n' + '<div class="hangoutBlockBodyText">\n' + 'Are You Sure you would\n' + 'like to hang up?\n' + '</div>\n' + '<div class="hangoutBlockBodyButtons">\n' + '<button class="hangoutBlockBodyButtonCancel" onclick="removeHangoutScreen(this)">\n' + 'Cancel\n' + '</button>\n' + '<button class="hangoutBlockBodyHangUp chatEndButtons" onclick="hangUpFunction(this)">\n' + 'Hang Up\n' + '</button>\n' + '</div>\n' + '</div>\n' + '</div>\n' + '</div>';
        $('body').append(hangOurBlock)
    })


    /*** FIND IF USER LOGGED IN ***/
    /*** IF YES CALL LOGGED IN MODULE ***/
    /*** OR CAL NOT LOGGED IN MODULE ***/
    var log = $('#loggedInOrNOt').val();
    if (log == 'notLogin') {
        loggedIn = false;
        moduleIfNotLeggedIn();
    } else {
        loggedIn = true;
        $step2.unbind("click");
        $decorLine1.remove();
        $decorLine2.remove();
        $step2BodyTytle.remove();
        $body2.remove();
        $footer2.remove();
        moduleIfLeggedIn();
    }


    $step2LoginBlock = $('.custom-modal-for-step2-login');
    $step4NoMoney = $('.no-money');
    $step2LoginButton = $('.step2LoginButton');
    $step2LoginButtonClose = $('.step2LoginHeaderIcon');
    $step4noMoneyIcon = $('.step4noMoneyIcon');


    $step2LoginButton.click(function () {
        $step2LoginBlock.css({
            'z-index': '50'
        })
        $step2LoginBlock.animate({
            'opacity': '1'
        }, 500)
    })

    $step2LoginButtonClose.click(function () {
        $step2LoginBlock.animate({
            'opacity': '0',
            'z-index': '-5'
        }, 500)

    })

    $step4noMoneyIcon.click(function () {
        $step4NoMoney.animate({
            'opacity': '0',
            'z-index': '-5'
        }, 500)
    })

    /*****  send message ******/
    $('#textToSendUser__').keypress(function (event) {
        if (event.which == 13) {
            messageSendToUser()
        }
    });
    $('input[id^="textToSendExpert__"]').keypress(function (event) {
        if (event.which == 13) {
            messageSendToExpert()
        }
    });

})
if ($('.preloader').length) {
    $('.preloader').delay(200).fadeOut(500);
}

/******************************************************************************************************************** */
/**************************************************  FUNCTIONS ********************************************************/

/******************************************************************************************************************** */

/******************************************************************************************************************** */

/*** CHAT ACTIONS ***/
function chatMainActions(domObj, status) {
    clearInterval(timerAcceptChat);
    $(domObj).parents('.ShangoutBlockMainShadow').remove();

    $.ajax({
        url: base_url + '/paid-session-actions',
        data: {
            "sId": currentSessionId,
            "session_status": status
        },
        type: "POST",
        dataType: "json"
    });

    if (status == 1 && domObj != "callFromFunction") {
        alert('funds added !!')
        $.ajax({
            url: base_url + '/add-funds-to-session',
            data: {
                "sId": currentSessionId
            },
            type: "POST",
            dataType: "json",
            success: function () {
                hoursU = 0;
                minutesU = 1;
                secondsU = 0;
                canRateChat = true;
                setTimerForChatUser(hoursU, minutesU, secondsU);
            }
        });
    }
    if (status == 0) {
        window.location.href = "/"
    }
}

/*** CHAT ACTIONS END***/

/******************************************************************************************************************** */


/*** WAIT EXPERT RESPONSE END***/

/******************************************************************************************************************** */


/******************************************************************************************************************** */

/*** STEP MODULES ***/
function moduleIfNotLeggedIn() {

    /*** DECOR LINE STYLES ***/
    $decorLine0.css({
        'display': 'none'
    })
    $decorLine1.css({
        'display': 'none'
    })
    $decorLine2.css({
        'display': 'block'
    })
    $decorLine3.css({
        'display': 'none'
    })
    /*** DECOR LINE STYLES END***/

    /*** STEPS BUTTONS STYLES ***/
    $step1.css({
        'background': 'linear-gradient(#ae2889,#db297f)'
    })
    $step2.css({
        'background': 'linear-gradient(#ae2889,#db297f)'
    })
    $step3.css({
        'background': 'rgb(197, 132, 169)'
    })
    $step4.css({
        'background': 'rgb(197, 132, 169)'
    })
    /*** STEPS BUTTONS STYLES END ***/

    /*** STEPS BODY TITLES STYLES ***/
    $step1BodyTytle.css({
        'display': 'none'
    })
    $step2BodyTytle.css({
        'display': 'block'
    })
    $step3BodyTytle.css({
        'display': 'none'
    })
    /*** STEPS BODY TITLES STYLES END***/

    /*** STEPS BODY STYLES ***/
    $body1.css({
        'display': 'none'
    })
    $body2.css({
        'display': 'block'
    })
    $body3.css({
        'display': 'none'
    })
    /*** STEPS BODY STYLES END***/

    /*** STEPS BODY FOOTER STYLES ***/
    $footer1.css({
        'display': 'none'
    })
    $footer2.css({
        'display': 'block'
    })
    $footer3.css({
        'display': 'none'
    })
    /*** STEPS BODY FOOTER STYLES END ***/

}

function moduleIfLeggedIn() {
    loggedIn = true;
    /*** DECOR LINE STYLES ***/
    $decorLine0.css({
        'display': 'none'
    })
    $decorLine1.css({
        'display': 'none'
    })
    $decorLine2.css({
        'display': 'none'
    })
    $decorLine3.css({
        'display': 'block'
    })
    /*** DECOR LINE STYLES END***/

    /*** STEPS BUTTONS STYLES ***/
    $step1.css({
        'background': 'linear-gradient(#ae2889,#db297f)'
    })
    $step2.css({
        'background': 'linear-gradient(#ae2889,#db297f)'
    })
    $step3.css({
        'background': 'linear-gradient(#ae2889,#db297f)'
    })
    $step4.css({
        'background': 'rgb(197, 132, 169)'
    })
    /*** STEPS BUTTONS STYLES END ***/

    /*** STEPS BODY TITLES STYLES ***/
    $step1BodyTytle.css({
        'display': 'none'
    })
    $step2BodyTytle.css({
        'display': 'none'
    })
    $step3BodyTytle.css({
        'display': 'block'
    })
    /*** STEPS BODY TITLES STYLES END***/

    /*** STEPS BODY STYLES ***/
    $body1.css({
        'display': 'none'
    })
    $body2.css({
        'display': 'none'
    })
    $body3.css({
        'display': 'block'
    })
    /*** STEPS BODY STYLES END***/

    /*** STEPS BODY FOOTER STYLES ***/
    $footer1.css({
        'display': 'none'
    })
    $footer2.css({
        'display': 'none'
    })
    $footer3.css({
        'display': 'block'
    })
    /*** STEPS BODY FOOTER STYLES END ***/
}

/*** STEP MODULES END ***/

/******************************************************************************************************************** */

/******************************************************************************************************************** */

/*** CHECK EMAIL ***/
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

/*** CHECK EMAIL END ***/

/******************************************************************************************************************** */

/*** REQUEST TO START SESSION ***/
$('.preloaderForStartSession').delay(200).fadeOut(500);


$noMoneyDash = $('#userAddFunds')
$nomoney_dashboard = $('#no-money_dashboard')
$nomoney_dashboard.css({
    'opacity': '0',
    'z-index': '-1'
}, 500)


/*** REQUEST TO START SESSION END ***/


/*** REMOVE CHAT REQUEST SCREEN ***/
function removeWantToChatScreen(a) {
    $(a).parents('.wantToChatBlockMainShadow').remove();
}

function chatActions(action, a, data) {
    clearInterval(timerAcceptChat);
    var fName = $(a).attr('data-uName');
    var lName = $(a).attr('data-lName');
    var avatar = $(a).attr('data-image');
    UserToSendIndex = $(a).attr('data-uIndex');

    $(a).parents('.wantToChatBlock').remove();
    if ($(".wantToChatBlockMainShadow > div").length == 0) {
        $(".wantToChatBlockMainShadow").remove()

    }
    if (action == 1) {
        action = "yes";
        reqFirstName = fName;
        clearInterval(checkIfRequestExist)
        $("#openMessageWindowForExpert").find('#userName__').html(fName + "" + lName);
        $("#openMessageWindowForExpert").find('#avatar__').attr('src', avatar);

        startCheckingChatStatus(data);

        $("#openMessageWindowForExpert").modal('show');
        pullDataForExpert(true);
        if (currentSessionId == null) {
            currentSessionId = data;
        }
    }

    else if (action == 2) {
        action = "pending";
        $.ajax({
            url: base_url + '/per-minute-chat-action',
            data: {
                "sessionId": data,
                "acceptOrReject": action
            },
            type: "POST",
            dataType: "json",
            success: function (res) {
                $.ajax({
                    url: base_url + '/change-user-status',
                    data: {
                        "userStatus": 'notActive'
                    },
                    type: "POST",
                    dataType: "json",
                    success: function (res) {
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000)
                    }
                });
            }
        });
    }

    else {
        action = "no"
    }

    $.ajax({
        url: base_url + '/per-minute-chat-action',
        data: {
            "sessionId": data,
            "acceptOrReject": action
        },
        type: "POST",
        dataType: "json"
    });
}


/*** REMOVE CHAT REQUEST SCREEN END***/

/******************************************************************************************************************** */


/*** REMOVE HANGOUT SCREEN ***/
function removeHangoutScreen(a) {
    $(a).parents('.hangoutBlockMainShadow').remove();
}

/*** REMOVE HANGOUT SCREEN END***/


/******************************************************************************************************************** */


/******************************************************************************************************************** */
function hangUpFunction(a) {
    $(a).attr('disabled', true)
    if (null == userIndexGeneral) {
        $.ajax({
            url: base_url + '/change-chat-status-to-hang-up-expert-side',
            data: {
                "sId": UserToSendIndex
            },
            type: "POST",
            dataType: "json",
        });
    }
    if (null == UserToSendIndex) {
        $.ajax({
            url: base_url + '/change-chat-status-to-hang-up-user-side',
            data: {
                "sId": userIndexGeneral
            },
            type: "POST",
            dataType: "json",
            success: function (res) {
                alert(res)
            }
        });
    }
}

/******************************************************************************************************************** */
/************************************************** END FUNCTIONS *****************************************************/
/******************************************************************************************************************** */


/** DONE **/
/******************************************************************************************************************** */
/** PAYPAL BUTTON RENDER **/

/******************************************************************************************************************** */
/** DONE **/

/******************************************************************************************************************** */
/*** STEPS ACTIONS ***/
function step2Login(a) {
    var email = $(a).parents('.step2Login').find('input').eq(0).val()
    var password = $(a).parents('.step2Login').find('input').eq(1).val()
    var csrf_token = $('meta[name=csrf-token]').attr('content');
    var autologin = "on";
    if (isEmail(email) && $(!(password == ''))) {
        $.ajax({
            url: base_url + '/ajax/login',
            data: {
                "_token": csrf_token,
                'email': email,
                'password': password,
                'remember': autologin

            },
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.auth == true) {
                    $step2.unbind("click");
                    $decorLine1.remove();
                    $decorLine2.remove();
                    $step2BodyTytle.remove();
                    $body2.remove();
                    $footer2.remove();
                    $('.custom-modal-for-step2-login').remove();

                    moduleIfLeggedIn();
                }
                else {
                    alert('Email or Password not matched');
                }
            },

        });
    }
    else {
        alert('Email and Password required');
    }
}

function Register() {
    var clientName = $('.ste2Usernaem').val();
    var userPassword = $('.ste2Password').val();
    var userScreenName = $('.ste2Screen').val();

    $.ajax({
        url: base_url + '/ajax/register-fast',
        data: {
            'userName': clientName,
            'password': userPassword,
            'screen_name': userScreenName
        },
        type: "POST",
        dataType: "json",
        success: function (res) {
            alert(res['error'])
            loggedIn = true;
        },
        error: function () {
            $step2.unbind("click");
            $decorLine1.remove();
            $decorLine2.remove();
            $step2BodyTytle.remove();
            $body2.remove();
            $footer2.remove();
            moduleIfLeggedIn();
        }
    });
}

/*** STEPS ACTIONS END ***/

/******************************************************************************************************************** */

/** DONE **/

/******************************************************************************************************************** */
/*** REMOVE HANGOUT SCREEN ***/
function removeHangoutScreen(a) {
    $(a).parents('.hangoutBlockMainShadow').remove();
}

/*** REMOVE HANGOUT SCREEN END***/

/** DONE **/
/******************************************************************************************************************** */

/******************************************************************************************************************** */

/*** BLOCK USER */
function blockUser() {
    $.ajax({
        url: base_url + '/block-user',
        data: {
            "userToBlock": UserToSendIndex
        },
        type: "POST",
        dataType: "json",
        success: function () {
            alert('User Is Blocked!')
            window.location.reload()
        }
    });
}


function reloadFunction(a) {
    if (userIndexGeneral == null) {
        endChatWithAlert();
    } else {
        if (rateWithStars == false) {
            endChatWithAlert();
        } else {
            $(a).parents('.hangoutBlockMainShadow').remove();
            $('#session_id').val(currentSessionId);
            $('#expert_id').val(userIndexGeneral);
            $('.user-chat-modal').remove();
            $('.session-end-modal').css({
                'display': 'block'
            })
        }
    }
}

function hangoutButton(a) {
    $.ajax({
        url: '/delete-conversation-in-session',
        type: "GET"
    });

    $(a).parents('.user-chat-modal').modal('hide')

    alert(currentSessionId)
}

function endChatWithAlert() {
    rateWithStars = false;
    if (alertTime == true) {
        alert('Chat Has Been Ended');
        alertTime = false;
    }
    window.location.href = '/';
}

/******************************************************************************************************************** */


/*** FOR FIRST EXPERT CHECKS REQUESTS FROM USERS ***/
/*** CHECK FOR REQUESTS ***/
function checkForRequests() {
    var added = false;

    checkIfRequestExist = setInterval(function () {

        if (added == false) {
            $.ajax({

                url: base_url + '/per-minute-chat-check-request',
                type: "POST",
                success: function (res) {

                    if (res.length != 0) {

                        added = true;

                        clearInterval(checkIfRequestExist)
                        var appending = '<div class="wantToChatBlockMainShadow">';

                        for (var i = 0; i < res.length; i++) {

                            arrayOfUserId.push(res[i]["user"]["id"])
                            arrayOfSessionId.push(res[i]["sessionId"])

                            console.log(arrayOfUserId)

                            appending = appending + '<div class="wantToChatBlock">\n' +
                                '                        <div class="ShangoutBlockHeader">\n' +
                                '<div id="chatAcceptingTimer____" class="wantToChatTimer" style="color: #ffffff;font-size:48px;font-weight: 100; "></div>' +
                                '                            <span class="closingButtons" style="position: absolute;top: 20px;right: 20px" data-uName = "' + res[i]["user"]["first_name"] + '"  data-lName = "' + res[i]["user"]["last_name"] + '" data-lName = "' + res[i]["user"]["id"] + '" onclick="chatActions(0,this,' + res[i]['sessionId'] + ')"><i class="ti-close"></i></span>\n' +
                                '                        </div>\n' +
                                '                        <div class="WhangoutBlockBody">\n' +
                                '                            <div class="WhangoutBlockBodyText">\n' +
                                '                                <span class="SboldText">User wants to chat with you</span>\n' +
                                '                            </div>\n' +
                                '                            <div class="WhangoutBlockBodyTextLittle">\n' +
                                '                                <div class="photoContainer">\n' +
                                '                                    <img src="' + res[i]['user']["avatar"] + '" alt="">\n' +
                                '                                </div>\n' +
                                '\n' +
                                '                                <div class="infoContainer">\n' +
                                '                                    <span class="infoName">\n' +
                                res[i]['user']["first_name"] + " " + res[i]['user']["last_name"] +
                                '                                    </span>\n' +
                                '                                    <span class="fundsCount">\n' +
                                '                                        <span>Per minute fee: <span></span>$' + fee_chatExpert + '/min </span>\n' +
                                '                                    </span>\n' +
                                '                                </div>\n' +
                                '                            </div>\n' +
                                '                            <div class="ShangoutBlockBodyButtons">\n' +
                                '                                <button class="ShangoutBlockBodyButtonCancel" data-uId = "' + res[i]["user"]["id"] + '"  data-uName = "' + res[i]["user"]["first_name"] + '" data-image = "' + res[i]["user"]["avatar"] + '" data-lName = "' + res[i]["user"]["last_name"] + '" data-uIndex = "' + res[i]["user"]["id"] + '" onclick="chatActions(1,this,' + res[i]['sessionId'] + ')">' +
                                '                                    Accept\n' +
                                '                                </button>\n' +
                                '                                <button class="ShangoutBlockBodyHangUp" data-uName = "' + res[i]["user"]["first_name"] + '"  data-lName = "' + res[i]["user"]["last_name"] + '" data-lName = "' + res[i]["user"]["id"] + '" onclick="chatActions(0,this,' + res[i]['sessionId'] + ')">' +
                                '                                    Reject\n' +
                                '                                </button>\n' +
                                '                            </div>\n' +
                                '                        </div>\n' +
                                '                    </div>'
                        }
                        appending = appending + '</div>';

                        $('body').append(appending)
                        var hours1 = "00";
                        var minutes1 = "00";
                        var seconds1 = "00";
                        document.getElementById('chatAcceptingTimer____').innerHTML = "00:00:00"
                        var h = 0;
                        var m = 0;
                        var s = 10;
                        timerAcceptChat = setInterval(function () {
                            if (s == 0) {
                                if (m > 0) {
                                    s = 59;
                                    m--;
                                }
                            }
                            if (m == 0) {
                                if (h > 0) {
                                    m = 59;
                                    s--;
                                    h--;
                                }
                            }
                            if (s < 10) {
                                seconds1 = "0" + s;
                            } else {
                                seconds1 = s;
                            }
                            if (m < 10) {
                                minutes1 = "0" + m;
                            } else {
                                minutes1 = m;
                            }
                            if (h < 10) {
                                hours1 = "0" + h;
                            } else {
                                minutes1 = h;
                            }
                            if (h == 0 && m == 0 && s == 0 || s < 0) {
                                document.getElementById('chatAcceptingTimer____').innerHTML = "00:00:00"
                                clearInterval(timerAcceptChat);
                                console.log(arrayOfSessionId)
                                $.ajax({
                                    url: base_url + '/change-status-and-save-to-call',
                                    data: {
                                        'idArray': arrayOfUserId,
                                        'idSessions': arrayOfSessionId
                                    },
                                    method: "POST",
                                    dataType: "json",
                                    success: function (res) {
                                        chatActions(2, 'n', 0);
                                    }
                                });

                            } else {
                                var line = hours1 + ":" + minutes1 + ":" + seconds1;

                                document.getElementById('chatAcceptingTimer____').innerHTML = line;
                            }
                            s--;
                        }, 1000)
                    }
                }
            });
        }
    }, 2000)
}

/*** CHECK FOR REQUESTS END***/

/*** FOR FIRST EXPERT CHECKS REQUESTS FROM USERS ***/


/*** CHECK STATUS ***/
function startCheckingChatStatus(sId) {
    clearInterval(checkIfRequestExist)
    $expertWaitFund = $('#expertWaitFunds__');
    var funds = 0;
    var afterFundsAddContinue = 0;
    var afterPay = 0;
    setInterval(function () {
        $.ajax({
            url: base_url + '/check-if-session-ended',
            data: {
                "sId": sId
            },
            type: "POST",
            dataType: "json",
            success: function (res) {
                console.log(res)
                if (res == 6) {
                    alert('Chat is hanged up by user');
                    window.location.reload();
                }
                if (res == 1) {

                    if (funds == 0) {
                        console.log('user adding funds')
                        var wait = '<div class="mess-info reqRemovable">\n' +
                            '<div class="infoLeft">\n' +
                            'Please Be Patient!' +
                            '</div><div class="infoRight" style="font-size: 16px">' + reqFirstName + 'is adding funds to continue session with you please be patient...</div></div>';

                        $('#textToSendUser__').attr('disabled', true);
                        $expertWaitFund.append(wait)
                        $messWindow.scrollTop($messWindow[0].scrollHeight);
                        funds++;
                        afterFundsAddContinue = 1;
                    }
                }
                else if (res == 2) {
                    if (afterFundsAddContinue == 1) {
                        console.log('user adding funds')
                        $('#textToSendUser__').attr('disabled', false);
                        afterFundsAddContinue = 0;
                        funds = 0;
                        if (afterPay == 1) {
                            console.log('user paying')
                            var currentdate = new Date();

                            if (currentdate.getMinutes() < 10)
                                var datetime = currentdate.getHours() + ":0" + currentdate.getMinutes();
                            else
                                var datetime = currentdate.getHours() + ":" + currentdate.getMinutes();

                            var paidSessionStart = '<div style="text-align: center" class="line-session-start">\n' +
                                '<span class="session-start-info">\n' +
                                '<div class="desl"></div>\n' +
                                '<div class="desr"></div>\n' +
                                '<span style="margin-right: 10px">' + datetime + '</span>PAID SESSION STARTED\n' +
                                '</span>\n' +
                                '<hr style="height: 1px;">\n' +
                                '</div>'

                            $expertWaitFund.append(paidSessionStart);

                            afterPay = 0;
                        }
                        console.log('payment done')
                        $('.reqRemovable').remove();
                        setTimerForChat(0, 1, 0);
                        pullDataForExpert(true);
                        $messWindow.scrollTop($messWindow[0].scrollHeight);
                    }
                }
                else if (res == 3) {
                    if (funds == 1) {
                        $('.reqRemovable').remove();

                        var sessionEndLine = '<div class="line-session-start" style="text-align: center">\n' +
                            '<span class="session-start-info">\n' +
                            '<div class="desl"></div>\n' +
                            '<div class="desr"></div>\n' +
                            'End Session Due to Less Funds</span>\n' +
                            '<hr style="height: 1px"></div>';

                        var wait = '<div class="mess-info reqRemovable">\n' +
                            '<div class="infoLeft">\n' +
                            'Please Be Patient!' +
                            '</div><div class="infoRight" style="font-size: 16px">' + reqFirstName + 'is adding funds to continue session with you please be patient...</div></div>';

                        $('#textToSendUser__').attr('disabled', true);
                        $expertWaitFund.append(sessionEndLine)
                        $expertWaitFund.append(wait)
                        $messWindow.scrollTop($messWindow[0].scrollHeight);
                        funds++;
                        afterFundsAddContinue = 1;
                        afterPay = 1;
                    }
                }
                else if (res == 0) {
                    alert('User Is Quited Chat !');
                    window.location.reload()
                }
            },
        })
    }, 1500);
}

/*** CHECK STATUS ***/

/*** CHECK BALANCE BEFORE START ***/
function sessionStart(a, userIndex) {
    userIndexGeneral = userIndex;
    $('#hhYTT__').val(userIndex)
    if (a) {
        $(a).attr('disabled', true)
    }
    $('.preloaderForStartSession').delay(200).fadeIn(500);
    $.ajax({
        url: base_url + '/check-user-balance-before-chat',
        data: {
            "userId": userIndex
        },
        type: "POST",
        dataType: "json",
        success: function (res) {
            if (res == 0) {

                $.ajax({
                    url: base_url + '/send-request-to-start-session',
                    data: {
                        "userId": userIndex
                    },
                    type: "POST",
                    dataType: "json",
                    success: function (res) {
                        if (res == 1) {
                            sessionStarted = false;
                            alert("You already sent chat request Please be patient and wait !")
                        } else if (res == 2) {
                            sessionStarted = false;
                            alert("Expert is busy, Try later !")
                        } else if (res == 3) {
                            sessionStarted = false;
                            alert("Expert Is Blocked You!")
                            window.location.href = "/";
                        }
                        else if (res == 5) {
                            alert("Expert Is Don't answering try later!")
                            window.location.href = "/";
                        }
                        else {
                            sessionStarted = true;
                            $('.preloaderForStartSession').delay(200).fadeOut(500);
                            $basicPlaceOfSteps.css({
                                'display': 'none'
                            })
                            $basicHeader.css({
                                'display': 'none'
                            })
                            $conversationWindow.css({
                                'display': 'block'
                            })
                            $('.preloaderForStartSession').delay(200).fadeOut(500);
                            waitExpertResponse(userIndex, true);
                        }
                    }
                });
            }
            else {
                alert("You Do not have enough funds for session");
                $nomoney_dashboard.css({
                    'z-index': '5000',
                    'position': 'fixed'
                }, 500)
                $nomoney_dashboard.focus()
                $nomoney_dashboard.animate({
                    'opacity': '1'
                }, 500)
            }
        }
    });


}

/*** CHECK BALANCE BEFORE START ***/

/*** WAIT EXPERT RESPONSE ***/
var interval = null;

function waitExpertResponse(a, reqStatus) {
    $messWindowTimerUser = $('#chatTimerOfUser__' + userIndexGeneral);
    $messWindowTimerUser.html("00:00:00")
    if (reqStatus == true) {

        interval = setInterval(function () {
            $.ajax({
                url: base_url + '/waitExpertResponse',
                data: {
                    "userToWait": a
                },
                type: "POST",
                dataType: "json",
                success: function (res) {
                    if (res[0]['accept'] == 1) {
                        $conversationWindow.css({
                            'display': 'none'
                        })
                        $mainConversationWindow.css({
                            'display': 'block'
                        })
                        currentSessionId = res[0]['id'];
                        clearInterval(interval);
                        clearInterval(checkIfRequestExist);
                        checkIfChatEndedOnUserSide();
                    }

                    if (res[0]['session_status'] == 5) {
                        alert('Expert Is Not Answering!')
                        window.location.reload()
                    }

                    if (res[0]['accept'] == 0) {
                        alert('Chat Request Rejected Redirecting To Main Page!')
                        window.location.href = "/";
                    }
                }
            });
        }, 3000)
    } else {
        clearInterval(interval);
    }
}

function checkIfChatEndedOnUserSide() {

    var intervalForExpert = setInterval(function () {
        $.ajax({
            url: base_url + '/check-if-session-ended',
            data: {
                "sId": currentSessionId
            },
            type: "POST",
            dataType: "json",
            success: function (res) {
                if (res == 6) {
                    alert('Chat Is Hanged Up !')

                    if (canRateChat == true) {
                        $('#session_id').val(currentSessionId);
                        $('#expert_id').val(userIndexGeneral);
                        $('.user-chat-modal').remove();

                        $('.session-end-modal').css({
                            'display': 'block'
                        })
                        clearInterval(intervalForExpert);
                    } else {
                        window.location.reload();
                        clearInterval(intervalForExpert);
                    }
                }
            }
        })
    }, 2000)
}


/*** MAIN MESSAGING ***/
$messWindow = $('#expertWaitFunds__');
$textInput = $('#textToSendUser__');
var firstSendForUser = true;

function messageSendToUser() {
    var textToSend = $textInput.val();
    if (textToSend.length > 0) {
        var mess = '<div class="message_ user_s">\n' +
            '<div class="message_box">\n' +
            '<div class="decor-user_s"></div>' + textToSend + '</div>\n' +
            '</div>';
        $messWindow.append(mess);
        $messWindow.scrollTop($messWindow[0].scrollHeight);
        $textInput.val('');
        $.ajax({
            url: base_url + '/send-message-to-paid-session',
            data: {
                "textToSend": textToSend,
                "userId": UserToSendIndex
            },
            type: "POST",
            dataType: "json"

        });
    }
}

function messageSendToExpert() {
    $messWindow = $('#userMessagesPlace__' + userIndexGeneral);
    var textToSend = $('#textToSendExpert__' + userIndexGeneral).val();
    if (textToSend.length > 0) {


        var mess = '<div class="message_ user_s">\n' +
            '<div class="message_box">\n' +
            '<div class="decor-user_s"></div>' + textToSend + '</div>\n' +
            '</div>\n';
        $messWindow.append(mess);
        $messWindow.scrollTop($messWindow[0].scrollHeight);
        $('#textToSendExpert__' + userIndexGeneral).val('')

        $.ajax({
            url: base_url + '/send-message-to-paid-session',
            data: {
                "textToSend": textToSend,
                "userId": userIndexGeneral
            },
            type: "POST",
            dataType: "json"

        });
        if (firstSendForUser == true) {
            setTimerForChatUser(hoursU, minutesU, secondsU);
            pullDataForUser(true);
            firstSendForUser = false;
        }
    }
}

/*** MAIN MESSAGING END***/

/*** PULL MESSAGES FROM DB ***/
var getUnreadMessagesInterval = null;
var firstTimeMessage = true;
var getUnreadMessagesIntervalForUser = null;

function pullDataForExpert(reqStatus) {
    if (firstTimeMessage == true) {
        document.getElementById('chatTimer__').innerHTML = "00:00:00"
    }

    if (reqStatus == true) {


        getUnreadMessagesInterval = setInterval(function () {
            ajaxGetUnreadMessages = $.ajax({
                url: base_url + '/get-unread-messages-for-per-minute-chat',
                data: {
                    'id': UserToSendIndex
                },
                method: "POST",
                dataType: "json",
                success: function (res) {

                    var length = res.length;
                    for (var i = 0; i < length; i++) {
                        var messFromUser = '<div class="message_ psychic_s">\n' +
                            '<div class="message_box">\n' +
                            '<div class="decor-psychic_s"></div>' + res[i]['body'] + '</div>\n' +
                            '</div>';
                        if (firstTimeMessage == true) {
                            setTimerForChat(hours, minutes, seconds);
                            firstTimeMessage = false
                        }

                        $messWindow.append(messFromUser);
                        $messWindow.scrollTop($messWindow[0].scrollHeight);
                    }


                },

            });
        }, 1000)
    } else {
        clearInterval(getUnreadMessagesInterval)
    }
}

function pullDataForUser(reqStatus) {
    $messWindow = $('#userMessagesPlace__' + userIndexGeneral);
    if (undefined != $messWindow) {
        $messWindow.scrollTop($messWindow[0].scrollHeight);
    }
    if (reqStatus == true) {
        getUnreadMessagesIntervalForUser = setInterval(function () {

            ajaxGetUnreadMessages = $.ajax({
                url: base_url + '/get-unread-messages-for-per-minute-chat',
                data: {
                    'id': userIndexGeneral
                },
                method: "POST",
                dataType: "json",
                success: function (res) {
                    var length = res.length;
                    for (var i = 0; i < length; i++) {
                        var messFromExpert = '<div class="message_ psychic_s">\n' +
                            '<div class="message_box">\n' +
                            '<div class="decor-psychic_s"></div>' + res[i]['body'] + '</div>\n' +
                            '</div>';
                        $messWindow.append(messFromExpert);

                        $messWindow.scrollTop($messWindow[0].scrollHeight);
                    }
                },

            });
        }, 1000)
    } else {
        clearInterval(getUnreadMessagesIntervalForUser)
    }
}

/*** PULL MESSAGES FROM DB END***/


/*** TIMER FOR CHAT ***/
var timer = null;
var timerUser = null;

function setTimerForChat(h, m, s) {
    clearInterval(checkIfRequestExist);
    var hours = "00";
    var minutes = "00";
    var seconds = "00";
    console.log('restart timer')
    $messWindowTimer = $('#chatTimer__');
    $messWindowTimer.html(hours + ":" + minutes + ":" + seconds)

    timer = setInterval(function () {
        if (s == 0) {
            if (m > 0) {
                s = 59;
                m--;
            }
        }
        if (m == 0) {
            if (h > 0) {
                m = 59;
                s--;
                h--;
            }
        }
        if (s < 10) {
            seconds = "0" + s;
        } else {
            seconds = s;
        }
        if (m < 10) {
            minutes = "0" + m;
        } else {
            minutes = m;
        }
        if (h < 10) {
            hours = "0" + h;
        } else {
            minutes = h;
        }

        if (h == 0 && m == 0 && s == 0 || s < 0) {
            $messWindowTimer.html("00:00:00")
            clearInterval(timer);
            hours = 0;
            minutes = 0;
            seconds = 0;
            rateWithStars = true;
            pullDataForExpert(false);
            $('#textToSendUser__').attr('disabled', true);
        } else {
            clearInterval(typingInterval);
            $('#textToSendUser__').attr('disabled', false);
            $messWindowTimer.html(hours + ":" + minutes + ":" + seconds)
        }
        s--;
    }, 1000)
}

var totalTime = 3;

function setTimerForChatUser(h, m, s) {

    clearInterval(checkIfRequestExist);
    clearInterval(typingIntervalUser);

    $('#textToSendExpert__' + userIndexGeneral).attr('disabled', false);
    var hours = "00";
    var minutes = "00";
    var seconds = "00";
    $messWindowTimerUser = $('#chatTimerOfUser__' + userIndexGeneral);
    $messWindowTimerUser.html(hours + ":" + minutes + ":" + seconds)  //ste
    timerUser = setInterval(function () {
        if (s == 0) {
            if (m > 0) {
                s = 59;
                m--;
            }
        }
        if (m == 0) {
            if (h > 0) {
                m = 59;
                s--;
                h--;
            }
        }
        if (s < 10) {
            seconds = "0" + s;
        } else {
            seconds = s;
        }
        if (m < 10) {
            minutes = "0" + m;
        } else {
            minutes = m;
        }
        if (h < 10) {
            hours = "0" + h;
        } else {
            minutes = h;
        }
        if (h == 0 && m == 0 && s == 0 || s < 0) {
            $messWindowTimerUser.html("00:00:00")
            clearInterval(timerUser);
            clearInterval(timerUser);
            clearInterval(timerUser);
            clearInterval(timerUser);
            rateWithStars = true;
            $('#textToSendExpert__' + userIndexGeneral).attr('disabled', true);
            chatMainActions('callFromFunction', 1);

            if ($('.preloader').length) {
                $('.preloader').delay(200).fadeIn(500);
            }
            pullDataForUser(false);

            $.ajax({
                url: base_url + '/paid-session-actions',
                data: {
                    "sId": currentSessionId,
                    "session_status": 1
                },
                type: "POST",
                dataType: "json",
                success: function () {
                    setTimeout(function () {

                        $.ajax({
                            url: base_url + '/make-payment-from-user-for-chat',
                            data: {
                                "whomToSend": userIndexGeneral,
                                "sessionID": currentSessionId,
                                "total_len": totalTime
                            },
                            type: "POST",
                            dataType: "json",

                            success: function (res) {

                                if (res == 0) {
                                    totalTime++;
                                    clearInterval(timerUser);
                                    hoursU = 0;
                                    minutesU = 1;
                                    secondsU = 0;
                                    canRateChat = true;
                                    setTimerForChatUser(hoursU, minutesU, secondsU);
                                    pullDataForUser(true);
                                    if ($('.preloader').length) {
                                        $('.preloader').delay(200).fadeOut(500);
                                    }
                                    $nomoney_dashboard.css({
                                        'z-index': '-580',
                                        'position': 'fixed'
                                    }, 500)
                                    $nomoney_dashboard.focus()
                                    $nomoney_dashboard.animate({
                                        'opacity': '0'
                                    }, 500)
                                } else {
                                    clearInterval(timerUser);
                                    hours = 0;
                                    minutes = 0;
                                    seconds = 0;

                                    $nomoney_dashboard.css({
                                        'z-index': '5000',
                                        'position': 'fixed'
                                    }, 500)
                                    $nomoney_dashboard.focus()
                                    $nomoney_dashboard.animate({
                                        'opacity': '1'
                                    }, 500)
                                }

                            }
                        });
                    }, 3000)
                }
            });
        } else {
            $messWindowTimerUser.html(hours + ":" + minutes + ":" + seconds)
        }
        s--;
    }, 1000)
}

/*** TIMER FOR CHAT END ***/






