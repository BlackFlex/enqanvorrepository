/*** BASE URL ***/
var base_url = $('meta[name=base_url]').attr('content');


var t = base_url + '/messages';
if (window.location.href == t) {

    /*** BASE DOM ELEMENTS ***/
    var appendingPlace = $('.mess-blocks-place');
    var userToSendId = $('#user_to_send')
    var sentMess = $('.sent-mess');
    var messageBoxActions = $('.mess-header-actions');
    var actionsList = $('.mess-box-actions');
    var sendMessage = $('#message_to_send');
    var isTyping = $('.user-is-typing');
    var userToFind = $('#find_user');
    var containerCust = $('.user-found-container')
    var ajaxGetUnreadMessages = null;

    /*** BASE VARIABLES ***/
    var userFirstLetter = $('#UnFLL').val()
    var checkIfLengthChange = false;
    var checkIfLengthNull = false;
    var userId = null;
    var conversationIsBlocked = null;
    var userFirstNameLetter = null;
    var updateUsersStatusInterval = null;
    var getUnreadMessagesInterval = null;
    var close = '<i class="ti-close"></i>';
    var threeDots = '<i class="ti-more-alt"></i>';

    /*** MAIN FEATURES ***/
    $(document).ready(function () {
        /*** SCROLL MESSAGE BOX TO ITS BOTTOM ***/
        scrollBox();
        /*** TOP RIGHT MENU CLOSE OPEN ***/
        messageBoxActions.html(threeDots);
        var clicked = 0;
        messageBoxActions.click(function () {
            if (clicked == 0) {
                $(this).html(close);
                clicked = 1;
            }
            else if (clicked == 1) {
                $(this).html(threeDots);
                clicked = 0;
            }
            actionsList.toggleClass('displayBlock')
        })


        /*** CHANGE TYPING STATUS ***/
        sendMessage.keyup(function () {
            if (conversationIsBlocked === false) {
                if ($(this).val().length > 0) {
                    if (checkIfLengthChange === false) {
                        $.ajax({
                            url: base_url + '/user-is-typing',
                            method: "POST"
                        });
                        checkIfLengthChange = true;
                        checkIfLengthNull = false;
                    }
                }
                else {
                    if (checkIfLengthNull === false) {
                        $.ajax({
                            url: base_url + '/user-is-not-typing',
                            method: "POST"
                        });
                        checkIfLengthChange = false;
                        checkIfLengthNull = true;
                    }
                }
            }
        })


        /*** GET IF FRIEND TYPING ***/
        containerCust.html("")
        userToFind.keyup(function () {
            var val = $(this).val();
            if (val.length > 0) {
                $.ajax({
                    url: base_url + '/get-user-from-search',
                    data: {
                        'screenName': val
                    },
                    method: "POST",
                    dataType: "json",
                    success: function (res) {
                        containerCust.html("")
                        for (var i = 0; i < res.length; i++) {
                            var firstPart = '<div onclick="createNewContact(this)" class="srch-res mess-user-line mess-active-user-conf mess-first-user">\n' +
                                '<input type="hidden" value="' + res[i]["id"] + '">\n' +
                                '                                        <div class="conf-user">\n' +
                                '                                            <div class="user-photo-container">'

                            var secondPart = '<div class="user-photo has-no-image">\n' +
                                '\n' + res[i]["screen_name"][0] + '' +
                                '                                                </div>\n' +
                                '\n <div class="alreadyHave display-none">You Already Have Conversation</div> ' +
                                '                                            </div>\n' +
                                '                                            <div class="name-and-sub"><span class="mess-user-name-found">' + res[i]["first_name"] + '</span></div>\n' +
                                '                                        </div>\n' +
                                '                                    </div>'

                            if (res[i]['is_active_now'] === 'active') {
                                var activePart = '<div class="user-active-light"></div>';
                                containerCust.append(firstPart + activePart + secondPart);
                            } else {
                                containerCust.append(firstPart + " " + secondPart);
                            }
                        }
                    }
                })
            } else {
                $('.new-contacts-names').html("")
                $('#infos').val('')
                containerCust.html("")
            }

        })


        /*** INTERVAL TO CLEAR SEARCH BOX CONTAINER ***/
        setInterval(function () {
            if (userToFind.val() === "") {
                containerCust.html("")
            }
        }, 500)


        /*** CHECK IF USER HAVE CONVERSATION TO START AJAX REQUESTS OR NOT ***/
        if ($('#hasUserConversation').val() === 'user-has-conversations') {
            updateFirstUserData();
            getUnreadMessagesAndCheckIfTyping();
            updateUsersStatus()
        }

        sendMessage.keypress(function (event) {
            if (event.which == 13) {
                sendMessageToUser($('.mess-send-btn'))
            }
        });


    });

    /*** FUNCTION TO SCROLL DOWN ***/
    function scrollBox() {
        appendingPlace.scrollTop(appendingPlace[0].scrollHeight);
    }

    /*** UPDATE FIRST USER DATA IN FRAME ***/
    function updateFirstUserData() {

        var val = $('.mess-user-line').eq(0).find('.screenName').val();
        var userId = $('.mess-user-line').eq(0).find('.userId').val();
        var val1 = $('.mess-user-line').eq(0).find('.conversationSubject').val();
        var isBlocked = $('.mess-user-line').eq(0).find('.ttHHy').val();

        userFirstNameLetter = $('.mess-user-line').eq(0).find('.has-no-image').html();
        sentMess.each(function () {
            $(this).html(userFirstNameLetter)
        })

        if (isBlocked === 'yes') {
            var app = ' <li data-toggle="collapse" data-target="#blockConversation" class="hover-action"><span>Unblock</span> <i class="ti-na"></i>\n' +
                '                                                        <div class="collapse" id="blockConversation">\n' +
                '                                                            <span onclick="unBlockUserConversation(this)" class="blockConversation" style="color: green">Yes</span>\n' +
                '                                                            <span class="delConversation" data-toggle="collapse" data-target="#delConversation" style="color: red">No</span>\n' +
                '                                                        </div>\n' +
                '                                                    </li>'
            $('.blockUnblock').html(app);
            conversationIsBlocked = true;
            $('.conversation-is-blocked').css({
                'display': 'block'
            })

            clearInterval(updateUsersStatusInterval);
            clearInterval(getUnreadMessagesInterval);

        } else {
            var app = '<li data-toggle="collapse" data-target="#blockConversation" class="hover-action"><span>Block</span> <i class="ti-na"></i>\n' +
                '                                                            <div class="collapse" id="blockConversation">\n' +
                '                                                                <span onclick="blockUserConversation(this)" class="blockConversation" style="color: red">Yes</span>\n' +
                '                                                                <span class="delConversation" data-toggle="collapse" data-target="#delConversation" style="color: green">No</span>\n' +
                '                                                            </div>\n' +
                '                                                        </li>'
            $('.blockUnblock').html(app);
            conversationIsBlocked = false;
            $('.conversation-is-blocked').css({
                'display': 'none'
            })

            getUnreadMessagesAndCheckIfTyping();
            updateUsersStatus();
        }

        if (val !== undefined)
            $('.message-box-header-right-side').find('div').eq(0).html(val[0])

        $('.message-box-header-right-side').find('div').eq(1).html(val)
        userToSendId.val(userId);
        $('.message-box-header-right-side').find('div').eq(2).find('span').html(val1)
    }

    /*** UPDATE MESSAGES WINDOW ***/
    function updateMessWindow(user) {

        var userId = $(user).find('input').eq(1).val();
        $('.mess-user-line').each(function () {
            $(this).removeClass('mess-active-user-conf');
        })


        $(user).addClass('mess-active-user-conf')

        if ($(user).find('#userav').val() === '') {
            $('.message-box-header-right-side').find('div').eq(0).html($(user).find('input').eq(0).val()[0])
        } else {
            $('.message-box-header-right-side').find('div').eq(0).html($(user).find('#user-main-photo').html())
        }


        $('.message-box-header-right-side').find('div').eq(1).html($(user).find('input').eq(0).val())
        $('.message-box-header-right-side').find('div').eq(2).find('span').html($(user).find('input').eq(2).val())

        userToSendId.val(userId);
        $('#amout-user-id').val(userId);
        appendingPlace.html('');
        $.ajax({
            url: base_url + '/get-conversation',
            data: {
                'idConv': $(user).find('.conv_II').val()
            },
            method: "POST",
            dataType: "json",
            success: function (res) {
                var len = res.length;
                for (var i = 0; i < len; i++) {
                    userFirstLetter=res[i]['screen_name'][0];
                    if(res[i]['avatar']){
                        userFirstLetter='<img style="border-radius:50%" src="'+res[i]['avatar']+'" alt="psychic profile pic" width="40px">';
                    }
                    if (res[i]['user_id'] != userId)
                    {
                        var firstPartAppendUser = '<div class="mess-block"><div class="sender-av-right has-no-image">' + userFirstLetter + '</div><div class="main-message"><span style="display: block">'
                        var secondPartUser = '</span><span class="mess-timing"><span class="mess-timing-icons"><i class="ti-calendar"></i></span>29 Jan<span class="mess-timing-icons"><i class="ti-time"></i></span>'
                        appendingPlace.append(firstPartAppendUser + res[i]['body'] + secondPartUser);
                    }
                    else
                    {
                        var firstPartAppendNotUSer = '<div class="mess-block"><div class="sent-mess sender-av-left has-no-image">' + userFirstLetter + '</div><div class="main-message-left"><span style="display: block">';
                        var secondPartNotUSer = '</span><span class="mess-timing-left"><span class="mess-timing-icons" style="margin-left: 0 !important;"><i class="ti-calendar"></i></span>29 Jan<span class="mess-timing-icons"><i class="ti-time"></i></span>09:05 AM</span></div></div>';
                        appendingPlace.append(firstPartAppendNotUSer + res[i]['body'] + secondPartNotUSer);
                    }
                }
                scrollBox();
            }
        });

        sentMess.each(function () {
            $(this).html(userFirstNameLetter)
        })
    }

    /*** SEND MESSAGE TO USER ***/
    function sendMessageToUser(btn) {

        var userId = userToSendId.val();
        var userAvatar=$('.corrent_user_avatar').val();
        var textToSend = $('#message_to_send').val();
        $(btn).prev().val('');
        $.ajax({
            url: base_url + '/user-is-not-typing',
            method: "POST"
        });
        checkIfLengthChange = false;
        checkIfLengthNull = true;

        if (textToSend.length > 0) {
            var app = '<div class="mess-block"><div class="sender-av-right has-no-image">' + userAvatar + '</div><div class="main-message"><span style="display: block">' + textToSend + '</span>\n' +
                '<span class="mess-timing"><span class="mess-timing-icons"><i class="ti-calendar"></i></span>29 Jan<span class="mess-timing-icons"><i class="ti-time"></i></span></span></div></div>'
            appendingPlace.append(app);
            scrollBox();
            $.ajax({
                url: base_url + '/send-message',
                data: {
                    'userId': userId,
                    'textToSend': textToSend
                },
                type: "POST",
                dataType: "json",
            });
        }
    }

    /*** UPDATE FRAME TO SEARCH OR TYPE MESSAGE ***/
    function updateFrame(a) {

        var dataIndex = $(a).data('index')
        $('.hd').each(function () {
            $(this).removeClass('active-mess-header')
            $(this).addClass('notactive-mess-header')
        })
        $(a).removeClass('notactive-mess-header');
        $(a).addClass('active-mess-header');
        $('.mes').each(function () {
            $(this).removeClass('display-block')
            $(this).addClass('display-none')
        })
        $('.mes').eq(dataIndex).removeClass("display-none")
        $('.mes').eq(dataIndex).addClass("display-block")
        if ($(a).data('show') === 'conversations') {
            $('.message-box-new-message').addClass("display-none")
            $('.message-box-header-right-side').removeClass('display-none')
            $('.message-box-header-right-side').addClass("display-block")
            $('.mess-block-main').removeClass('display-none')
            $('.new-contact-add-block').removeClass('display-block')
            $('.new-contact-add-block').addClass('display-none')

            getUnreadMessagesAndCheckIfTyping();
            updateUsersStatus()
        }
        if ($(a).data('show') === 'new-conversations') {
            $('.message-box-header-right-side').addClass("display-none")
            $('.message-box-new-message').removeClass("display-none")
            $('.message-box-new-message').addClass("display-block")
            $('.mess-block-main').addClass('display-none')
            $('.new-contact-add-block').removeClass('display-none')
            $('.new-contact-add-block').addClass('display-block')

            clearInterval(updateUsersStatusInterval);
            clearInterval(getUnreadMessagesInterval);
        }
    }

    /*** GET UNREAD MESSAGES ***/
    function getUnreadMessagesAndCheckIfTyping() {
        if (conversationIsBlocked === false) {
            var firstPart = '<div class="mess-block"><div class="sender-av-left has-no-image"><img style="border-radius: 50%" src="';
            var secondPart = '" alt="psychic profile pic" width="40px"></div><div class="main-message-left"><span style="display: block">';
            var thirdPart = '</span><span class="mess-timing-left"><span class="mess-timing-icons" style="margin-left: 0 !important;"><i class="ti-calendar"></i></span>29 Jan<span class="mess-timing-icons"><i class="ti-time"></i></span>09:05 AM</span></div></div>';
            getUnreadMessagesInterval = setInterval(function () {
                userId = userToSendId.val();
                ajaxGetUnreadMessages = $.ajax({
                    url: base_url + '/get-unread-messages',
                    data: {
                        'id': userId
                    },
                    method: "POST",
                    dataType: "json",
                    success: function (res) {
                        if (res === 0) {
                            isTyping.css({
                                'display': 'block'
                            })
                            return 0;
                        }
                        isTyping.css({
                            'display': 'none'
                        })

                        var length = res.length;
                        for (var i = 0; i < length; i++) {
                           appendingPlace.append(firstPart + res[i]['avatar'] + secondPart+ res[i]['message']['body'] + thirdPart);
                            scrollBox();
                        }

                    }
                });
            }, 2500)
        }
    }

    /*** GET UNREADED MESSAGES ***/
    function updateUsersConversations() {
        if (conversationIsBlocked === false) {
            var firstPart = '<div class="mess-block"><div class="sender-av-left has-no-image"><img style="border-radius: 50%" src="';
            var secondPart = '" alt="psychic profile pic" width="40px"></div><div class="main-message-left"><span style="display: block">';
            var thirdPart = '</span><span class="mess-timing-left"><span class="mess-timing-icons" style="margin-left: 0 !important;"><i class="ti-calendar"></i></span>29 Jan<span class="mess-timing-icons"><i class="ti-time"></i></span>09:05 AM</span></div></div>';
                userId = userToSendId.val();
                ajaxGetUnreadMessages = $.ajax({
                    url: base_url + '/get-unread-messages',
                    data: {
                        'id': userId
                    },
                    method: "POST",
                    dataType: "json",
                    success: function (res) {
                        if (res === 0) {
                            isTyping.css({
                                'display': 'block'
                            })
                            return 0;
                        }
                        isTyping.css({
                            'display': 'none'
                        });
                        var length = res.length;
                        for (var i = 0; i < length; i++) {
                            appendingPlace.append(firstPart + res[i]['avatar'] + secondPart+ res[i]['message']['body'] + thirdPart);
                            scrollBox();
                        }

                    }
                });
        }
    }

    /*** DELETE CONVERSATION ***/
    function removeUserConversation() {

        userId = userToSendId.val();
        $.ajax({
            url: base_url + '/delete-conversation',
            data: {
                'id': userId
            },
            method: "POST",
            dataType: "json",
            success: function (res) {
                if (res == 0) {
                    location.reload();
                }
            }
        });
    }

    /*** BLOCK CONVERSATION ***/
    function blockUserConversation(a) {

        $(a).parents('.hover-action').find('span').eq(0).html('Unblock')

        $.ajax({
            url: base_url + '/block-conversation',
            data: {
                'id': userToSendId.val()
            },
            method: "POST",
            dataType: "json",
        });


        var app = ' <li data-toggle="collapse" data-target="#blockConversation" class="hover-action"><span>Unblock</span> <i class="ti-na"></i>\n' +
            '                                                        <div class="collapse" id="blockConversation">\n' +
            '                                                            <span onclick="unBlockUserConversation(this)" class="blockConversation" style="color: green">Yes</span>\n' +
            '                                                            <span class="delConversation" data-toggle="collapse" data-target="#delConversation" style="color: red">No</span>\n' +
            '                                                        </div>\n' +
            '                                                    </li>'
        $('.blockUnblock').html(app);

    }

    /*** UNBLOCK CONVERSATION ***/
    function unBlockUserConversation(a) {


        $(a).parents('.hover-action').find('span').eq(0).html('Block')

        $.ajax({
            url: base_url + '/unblock-conversation',
            data: {
                'id': userToSendId.val()
            },
            method: "POST",
            dataType: "json",
        });

        var app = '<li data-toggle="collapse" data-target="#blockConversation" class="hover-action"><span>Block</span> <i class="ti-na"></i>\n' +
            '                                                            <div class="collapse" id="blockConversation">\n' +
            '                                                                <span onclick="blockUserConversation(this)" class="blockConversation" style="color: red">Yes</span>\n' +
            '                                                                <span class="delConversation" data-toggle="collapse" data-target="#delConversation" style="color: green">No</span>\n' +
            '                                                            </div>\n' +
            '                                                        </li>'
        $('.blockUnblock').html(app);
    }

    /*** CREATE NEW CONVERSATION ***/
    var newContactsinfo = [];

    function createNewContact(a) {


        if (!$(a).hasClass('choosen')) {
            var id = $(a).find('input').eq(0).val()

            // check-if-have-conversation
            $.ajax({
                url: base_url + '/check-if-have-conversation',
                data: {
                    'id': id
                },
                method: "POST",
                dataType: "json",
                success: function (res) {
                    if (res == 0) {
                        $(a).addClass('choosen')
                        newContactsinfo = [];
                        $('#infos').val("")
                        $('.choosen').each(function () {
                            var val = $(this).find('input').eq(0).val()
                            newContactsinfo.push(val);
                            var jsonString = JSON.stringify(newContactsinfo);
                            $('#infos').val(jsonString)
                        })
                        $('.new-contacts-names').append('<span class="choosenContact" data-user="' + $(a).find('input').eq(0).val() + '" data-name="' + $(a).find(".mess-user-name-found").html() + '">' + $(a).find('.mess-user-name-found').html() + '</span>')
                    } else {

                        $(a).find('.alreadyHave').removeClass('display-none')
                        $(a).find('.alreadyHave').addClass('display-block')
                        setTimeout(function () {
                            $(a).find('.alreadyHave').removeClass('display-block')
                            $(a).find('.alreadyHave').addClass('display-none')
                        }, 1000)
                    }
                }
            })
        } else {
            $(a).removeClass('choosen')
            newContactsinfo = [];
            $('#infos').val("")
            $('.choosen').each(function () {
                var val = $(this).find('input').eq(0).val()
                newContactsinfo.push(val);
                var jsonString = JSON.stringify(newContactsinfo);
                $('#infos').val(jsonString)
            })

            $('.choosenContact').each(function () {
                if ($(this).data('user') == $(a).find("input").eq(0).val()) {
                    $(this).remove()
                }
            })
        }
    }

    /*** UPDATE USER STATUS ***/
    var users = $('.user-active-light')

    function updateUsersStatus() {
        var idArray = [];
        users.each(function () {
            idArray.push($(this).parents('.mess-user-line').find('input').eq(1).val())
        });
        updateUsersStatusInterval = setInterval(function () {
            $.ajax({
                url: base_url + '/get-users-status',
                data: {
                    'idArray': idArray
                },
                method: "POST",
                dataType: "json",
                success: function (res) {
                    var index = 0;
                    users.each(function () {
                        if (res[index] === 'active') {
                            $(this).removeClass('display-none');
                            $(this).addClass('display-block');
                        } else {
                            $(this).removeClass('display-block');
                            $(this).addClass('display-none');
                        }
                        index++;
                    })
                }
            })
        }, 2500)
    }

    function checkInputs(a) {
        $form = $(a).parents('.new-contactsend-inner');
        $users = $form.find('input[name=users_info]');
        $subject = $form.find('input[name=conversation_subject]');
        $message = $form.find('input[name=conversation_message]');
        if ($users.val() != '' && $subject.val() != '' && $message.val() != '') {
            $(a).attr('type', 'submit')
            $(a).click();
        }


    }
}