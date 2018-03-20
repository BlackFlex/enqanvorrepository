$(document).ready(function () {
    $sortPsychics = $('#inputSortby');
    $sortbyForm = $('#sortbyForm');
    $sortPsychics.change(function () {
        $sortbyForm.submit()
    })

    $noMoneyDash = $('#userAddFunds')
    $nomoney_dashboard = $('#no-money_dashboard')
    $nomoney_dashboard.css({
        'opacity': '0',
        'z-index': '-1'
    }, 500)


    $noMoneyDash.click(function () {
        $nomoney_dashboard.css({
            'z-index': '80'
        }, 500)

        $nomoney_dashboard.animate({
            'opacity': '1'
        }, 500)
    })

    $('[data-toggle="tooltip"]').tooltip();
    /* login popup */
    $popUp = $('#myModalLogin');


    // Get the button that opens the popup
    $btnOpenLogin = $('#login');

    // Get the <span> element that closes the popup
    $closeLoginModal = $("#close");

    // When the user clicks the button, open the popup
    $btnOpenLogin.click(function () {
        $popUp.css({
            'display': 'block'
        })
    })

    // When the user clicks on <span> (x), close the popup
    $closeLoginModal.click(function () {
        $popUp.css({
            'display': 'none'
        })
    })

    // When the user clicks anywhere outside of the popup, close it
    // $(window).click(function (event) {
    //    if (event.target != $popUp) {
    //        $popUp.css({
    //            'display':'none'
    //        })
    //    }
    // })


    /* ===================================================================================== */

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    /* ===================================================================================== */
    /* login function  */
    $('#signin').click(function (event) {
        event.preventDefault();
        var base_url = $('meta[name=base_url]').attr('content');
        var csrf_token = $('meta[name=csrf-token]').attr('content');
        var email = $('input[name=email]').val();
        var password = $('input[name=password]').val();
        var autologin = $('input[name=autologin]').val();

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
                        window.location.href = base_url + "/dashboard";
                    }
                    else {
                        alert('Email or Password not matched');
                    }
                },
                error: function (res) {
                    console.log(res);
                }

            });
        }
        else {
            alert('Email and Password required');
        }
    });

    /* ===================================================================================== */

    // Get the popup
    $popUpSignUp = $('#myModalsignup');

    // Get the button that opens the popup
    $btnSignUp = $("#signup");

    // Get the <span> element that closes the popup
    $closeSignUp = $("#close1");


    // When the user clicks the button, open the popup
    $btnSignUp.click(function () {
        $popUpSignUp.css({
            'display': 'block'
        })
    })


    // When the user clicks on <span> (x), close the popup
    $closeSignUp.click(function () {
        $popUpSignUp.css({
            'display': 'none'
        })
    })


    // When the user clicks anywhere outside of the popup, close it
    // window.onclick = function(event) {
    // 	if (event.target == popup) {
    // 		popup.style.display = "none";
    // 	}
    // }
    //


    $('.register_type').click(function () {
        if ($(this).val() == 'client') {
            $('.expert_level').hide();
        }
        else {
            $('.expert_level').show();
        }
    });

    /* register function  */

    $('#signupformsubmit').click(function (event) {
        event.preventDefault();
        var base_url = $('meta[name=base_url]').attr('content');
        var csrf_token = $('meta[name=csrf-token]').attr('content');


        var err = false;

        jQuery("form#register_form :input").each(function () {

            if (jQuery(this).val() === "") {
                if (jQuery(this).is(':visible') && ($(this).attr("required") == 'required')) {
                    alert("Empty Fields  " + jQuery(this).attr('lkm'));
                    err = true;
                    jQuery(this).addClass('alert-danger');
                    return false;
                }
            }

            else {
                jQuery(this).removeClass('alert-danger');
            }

        });


        if (err == false) {
            $.ajax({
                url: base_url + '/ajax/register',
                data: {
                    "_token": csrf_token,
                    'data': $('#register_form').serialize()
                },
                type: "POST",
                dataType: "json",
                success: function (response) {
                    if (response.status == true) {
                        window.location.href = base_url;
                    }
                    else {
                        alert(response.error);
                    }
                },
                error: function (res) {
                    console.log(res);
                }

            });


        }
    });

    /*** CHANGE USER INFO BLOCKS IN SETTING PAGE ***/
    // $userInfoChangeButton = $('.infoChangeButton');
    // $infoBlock = $('.infoChangeBlock');
    //
    // $userInfoChangeButton.click(function () {
    // var index = $(this).data('index');
    //     $infoBlock.each(function () {
    // 	if( $(this).hasClass('displayBlock') ){
    //             $(this).removeClass('displayBlock')
    //             $(this).addClass('displayNone')
    // 	}
    //     })
    //
    //     $infoBlock.eq(index).removeClass('displayNone');
    //     $infoBlock.eq(index).addClass('displayBlock');
    //
    //     $userInfoChangeButton.each(function () {
    // 	if($(this).hasClass('colorPurple')){
    //             $(this).removeClass('colorPurple')
    // 	}
    //     })
    //     $(this).addClass('colorPurple')
    // })

    $showHiddenPassword = $('.showUserPassword');

    $showHiddenPassword.hover(function () {
        $(this).prev().attr('type', 'text')
    })
    $showHiddenPassword.mouseleave(function () {
        $(this).prev().attr('type', 'password')
    })

    $horoSign = $('.horosignselect');
    var valn = $horoSign.val();
    $horoSign.next().find('option').each(function () {
        if ($(this).val() == valn) {
            $(this).attr('selected', true)
        }
    })


    $lang = $('.lang');
    var valnn = $lang.val();
    $lang.next().find('option').each(function () {
        if ($(this).val() == valnn) {
            $(this).attr('selected', true)
        }
    })


    $('#horo_sign').selecter();
    $('#language').selecter();

    $('#client').change(function () {
        if ($(this).prop('checked', true)) {
            $("#expert").prop("checked", false)
        }
    });
    $('#expert').change(function () {
        if ($(this).prop('checked', true)) {
            $("#client").prop("checked", false)
        }
    })


    $changeUserStatus = $('#change-user-st');
    $changeUserStatus.change(function () {
        if($(this).val() != 'notSelected') {
            $.ajax({
                url: base_url + '/change-user-status',
                data: {
                    "userStatus": $(this).val(),
                },
                type: "POST",
                dataType: "json",
                success: function () {
                    window, location.reload()
                }

            });
        }
    })

    $userPhone = $('#addUSerPhone')
    $userPhone.click(function () {
        $('#userPhone').submit()
    })

    $expertEarnings = $('#expertEarnings')
    $expertEarnings.click(function () {
        window.location.href = base_url+"/payments";
    })






    $countrySelector = $('.country-selector')
    $countrySelector.click(function () {
        if($flagsBox.hasClass('displayNoneFlags')){
            $flagsBox.removeClass('displayNoneFlags')
            $flagsBox.addClass('displayBlockFlags')
        }else{
            $flagsBox.addClass('displayNoneFlags')
            $flagsBox.removeClass('displayBlockFlags')
        }
    })


    $flagsBox = $('#flags-box')
    var flags = $('#flags').val();
    if(undefined != flags) {
        flags = JSON.parse(flags);
        $('#flags').val(flags);

        for (i = 2; i < flags.length; i++) {

            var countryName = flags[i].split("-");
            var countryName1 = countryName[1].split(".");


            var appeding = ' <div onclick="changeSelectedCountry(this)" class="flag-inner">\n' +
                '                                    <img src="/images/flag-icons/' + flags[i] + '" style="width: 20px" alt="">\n' +
                '                                    <span style="text-transform:capitalize ">' + countryName1[0] + '</span>\n' +
                '                                </div>';
            $flagsBox.append(appeding)
        }

    }

    $('#expert_level').css({
        'display':'none'
    })
    $('.popup_bottom').find('.white_btn').click(function () {
        $closeLoginModal.click()
        $btnSignUp.click()
        $('#expert_level').css({
            'display':'none'
        })
        $('#userRole').val('client');

    })

    $('#alreadyHaveAccount').click(function () {
        $('#close1').click()
        $('#login').click()
    })

    $('#joinPsychicAsExpert').click(function () {
        $closeLoginModal.click()
        $btnSignUp.click()
        $('#expert_level').css({
            'display':'block'
        })
        $('#userRole').val('expert');
    })

    $('.getStarted').click(function () {
        $closeLoginModal.click()
        $btnSignUp.click()
        $('#expert_level').css({
            'display':'none'
        })
        $('#userRole').val('client');
    })
    $('.main-page-search-loop').click(function () {
        $('#allPsychicsSrch').submit()
    })
    $('#transaction_size').change(function () {
        if( $(this).val() == 'Other' ){
            $('#customAmount').css({
                'display':'block'
            })
        }else{
            $('#customAmount').css({
                'display':'none'
            })
        }
    })

    $('#customAmount').change(function () {
        $('#transaction_size').find('option').last().val($(this).val())
    })

    var revCount = 8;
    $('#viewMoreReveiew').click(function () {
        $.ajax({
            url: '/psychic-get-reviews/'+revCount,
            data: {
                'screen_name': $('#userScreenName').val()
            },
            type: "POST",
            dataType: "json",
            success:function (res) {
                $('#revAppenndPlace').html('')

                console.log(res)
                console.log(res)
                for(i = 0 ; i < res.length ; i++ ){
                    if(res[i]["text"] == null){
                        res[i]["text"] = ""
                    }

                    var appendingF = ' <div class="col-md-6">\n' +
                        '                    <div class="expert-rev-wrap">\n' +
                        '                        <h5>'+res[i]["screen_name"]+'</h5>\n' +
                        '                        <p class="expert-rev-desc">'+res[i]["text"]+'</p>\n' +
                        '                        <div class="expert-rev-date-wrap">\n' +
                        '                            <div class="gold-star">';

                    var stars = '';
                    for(j = 0 ; j < res[i]['rate'] ; j++){
                        stars+= '<i class="fa fa-star"></i>'
                    }

                    var appendingS =

                        '                            </div>\n' +
                        '                            <div class="text-right date-wrap">\n' +
                        '                                <p>'+res[i]["created_at"]+'</p>\n' +
                        '                            </div>\n' +
                        '                        </div>\n' +
                        '                        <hr>\n' +
                        '                    </div>\n' +
                        '                </div>';

                    $('#revAppenndPlace').append(appendingF+stars+appendingS)
                }
            }
        });
        revCount += 4;
    })

});
function changeSelectedCountry(a) {
    $countrySelector.find('span').eq(0).html($(a).html())
}

