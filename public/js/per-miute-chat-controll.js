/*** BASE URL ***/
var base_url = $('meta[name=base_url]').attr('content');
var timer = 3;
var userStatusCheck = $('#UStatus__').val();

$(document).ready(function () {


    if(userStatusCheck == 'expert') {
        var checkIfRequestExist = setInterval(function () {
            $.ajax({
                url: base_url + '/per-minute-chat-check-request',
                type: "POST",
                success:function (res) {

                    if(res.length != 0){
                        var appending = '<div class="wantToChatBlockMainShadow">';
                        for (var  i = 0 ; i < res.length ;i++) {

                             appending = appending + '<div class="wantToChatBlock">\n' +
                                '                        <div class="ShangoutBlockHeader">\n' +
                                '                            <span class="wantToChatTimer" style="color: #ffffff;font-size:48px;font-weight: 100; ">\n' +
                                '                                  00:03:00\n' +
                                '                            </span>\n' +
                                '                            <span class="closingButtons" onclick="removeWantToChatScreen(this)"><i class="ti-close"></i></span>\n' +
                                '                        </div>\n' +
                                '                        <div class="WhangoutBlockBody">\n' +
                                '                            <div class="WhangoutBlockBodyText">\n' +
                                '                                <span class="SboldText">User wants to chat with you</span>\n' +
                                '                            </div>\n' +
                                '                            <div class="WhangoutBlockBodyTextLittle">\n' +
                                '                                <div class="photoContainer">\n' +
                                '                                    <img src="'+res[i]['user']["avatar"]+'" alt="">\n' +
                                '                                </div>\n' +
                                '\n' +
                                '                                <div class="infoContainer">\n' +
                                '                                    <span class="infoName">\n' +
                                                                        res[i]['user']["first_name"]+" "+res[i]['user']["last_name"]+
                                '                                    </span>\n' +
                                '                                    <span class="fundsCount">\n' +
                                '                                        <span>Per minute fee: <span></span>$/min </span>\n' +
                                '                                    </span>\n' +
                                '                                </div>\n' +
                                '                            </div>\n' +
                                '                            <div class="ShangoutBlockBodyButtons">\n' +
                                '                                <button class="ShangoutBlockBodyButtonCancel" data-uName = "'+res[i]["user"]["first_name"]+'" data-image = "'+res[i]["user"]["avatar"]+'" data-lName = "'+res[i]["user"]["last_name"]+'" data-uIndex = "'+res[i]["user"]["id"]+'" onclick="chatActions(1,this,'+res[i]['sessionId']+')">' +
                                '                                    Accept\n' +
                                '                                </button>\n' +
                                '                                <button class="ShangoutBlockBodyHangUp" data-uName = "'+res[i]["user"]["first_name"]+'"  data-lName = "'+res[i]["user"]["last_name"]+'" data-lName = "'+res[i]["user"]["id"]+'" onclick="chatActions(0,this,'+res[i]['sessionId']+')">' +
                                '                                    Reject\n' +
                                '                                </button>\n' +
                                '                            </div>\n' +
                                '                        </div>\n' +
                                '                    </div>'
                        }
                        appending = appending+'</div>';
                        $('body').append(appending)
                        clearInterval(checkIfRequestExist)
                    }
                }
            });
        },3000)
    }

})