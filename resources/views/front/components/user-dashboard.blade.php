@extends('front.layout')
@section('content')

    <div class="container">
        <div class="dash-wrap">
            <h3 class="dash-head">My Dashboard</h3>
            <hr>
        </div>

        <div class="dash-form-wrap">
            <div class="row">
                <div class="col-md-3">
                    <div class="dash-form-line">
                        <div class="dash-item-wrap green-grad">
                            <i class="fas fa-phone"></i>
                        </div>
                        <p>Add Your Phone</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dash-input-wrap">
                        <form action="/dashboard" method="get" id="userPhone">
                            {{csrf_field()}}
                            <input class="" name="userPhone" type="text">
                        </form>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="dash-select-wrap">
                        <div class="country-selector">
                            <span>Select Country</span>
                            <input type="hidden" value="{{ $countries }}" id="flags">
                            <div class="flags-box displayNoneFlags" id="flags-box">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="dash-buttons-wrap">
                        <button class="green-grad" id="addUSerPhone">Edit</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">

                    <div class="dash-form-line">
                        <div class="dash-item-wrap green-grad">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <p>$ {{ \Illuminate\Support\Facades\Auth::user()->funds }}</p><span> (3 free minutes)</span>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="dash-input-wrap">
                        <input class="" type="text">
                    </div>

                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <div class="dash-buttons-wrap">
                        <button class="green-grad" id="userAddFunds">Add Funds</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="dash-form-line">
                        <div class="dash-item-wrap green-grad">
                            <i class="fas fa-check"></i>
                        </div>
                        <p>Auto Recharge:
                            @if(Auth::user()->auto_recharge == 0)
                                Off
                            @endif
                            @if(Auth::user()->auto_recharge == 1)
                                On
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dash-input-wrap">
                        <input class="" type="text">
                    </div>

                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <div class="dash-buttons-wrap">
                        @if(Auth::user()->auto_recharge == 0)
                            <button class="green-grad">
                                <a href="/auto_recharge-on" style="color: white">On</a>
                            </button>
                        @endif
                        @if(Auth::user()->auto_recharge == 1)
                            <button class="green-grad">
                                <a href="/auto_recharge-off" style="color: white">Off</a>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </div>


        <div class="dash-wrap">
            <h3 class="dash-head">Last Readings</h3>
            <hr>
            <button class="btn-240 green-grad">
                <a href="/psychics" style="color: #ffffff">Start your reading now</a>
            </button>
        </div>
    </div>


    <section>
        <div class="container">

        </div>
    </section>


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

    <div class="no-money" id="no-money_dashboard">
        <div class="modal-content custom-modal-for-login">
            <div class="modal-body">
                <div class="step2LoginHeader">
                                                                                <span class="closingButtons step4noMoneyIcon"><i
                                                                                            class="ti-close"></i></span>
                </div>
                <div class="step2Login">
                    <div style="display: flex;">
                                                                                    <span style="
                                            display:  block;
                                            float:  left;
                                            margin-right: 14px;
                                        " id="addFunds_">I want to deposit</span>

                        <input placeholder="Type Custom " min="1" type="number" id="customAmount" style="display: none;border: none;border-bottom: 1px solid black" >
                        <select type="text"
                                id="transaction_size"
                                class="firstPayPaypal"
                                style="
                                                display: block;
                                                margin: 5px 30px;
                                                border-radius: 3px;
                                                border: none;
                                                border-bottom: 1px solid;
                                                float: left;
                                        ">
                            <option value="20">$1</option>
                            <option value="20">$10</option>
                            <option value="20">$20</option>
                            <option value="50">$50</option>
                            <option value="100">$100</option>
                            <option value="200">$200</option>
                            <option value="500">$500</option>
                            <option value="Other" class="otherValToPay">Other</option>
                        </select>
                    </div>
                    <div style="display: flex">
                        <span style="
                                            display:  block;
                                            float:  left;
                                            margin-right: 14px;">to my account. Using</span>

                        <select type="text"
                                id="transaction_type"
                                style="
                                                display: block;
                                                margin: 5px 30px;
                                                border-radius: 3px;
                                                border: none;
                                                border-bottom: 1px solid;
                                                float: left;
                                        ">
                            <option value="paypal">paypal
                            </option>
                        </select>
                    </div>

                    <div id="paypalForBalanceRefill">
                        <div id="paypal-button-container"></div>
                    </div>
                    <script>
                        paypal.Button.render({
                            env: 'sandbox', // sandbox | production
                            // PayPal Client IDs - replace with your own
                            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
                            client: {
                                sandbox: 'AZDxjDScFpQtjWTOUtWKbyN_bDt4OgqaF4eYXlewfBP4-8aqX3PiV8e1GWU6liB2CUXlkA59kJXE7M6R',
                                production: 'AZZjkDDK15x_af6-lW3tpX5fZlv_HBK2I3SH3EXFr0C26FeJc3uUatAtF1vA2CU8H-RV303bbQ2YA2sz'
                            },

                            // Show the buyer a 'Pay Now' button in the checkout flow
                            commit: true,

                            // payment() is called when the button is clicked
                            payment: function (data, actions) {

                                // Make a call to the REST api to create the payment
                                return actions.payment.create({
                                    payment: {
                                        transactions: [
                                            {
                                                amount: {total: $('#transaction_size').val(), currency: "USD"},
                                            }
                                        ],

                                    },

                                });
                            },
                            // onAuthorize() is called when the buyer approves the payment
                            onAuthorize: function (data, actions) {

                                // Make a call to the REST api to execute the payment
                                return actions.payment.execute().then(function (res) {
                                    $.ajax({
                                        url: base_url + '/make-payment',
                                        data: {
                                            'res_id': res['id'],
                                            'create_time': res['create_time'],
                                            'pay_method': res['payer']['payment_method'],
                                            'status': res['payer']['status'],
                                            'total': res['transactions'][0]['amount']['total'],
                                            'currency': res['transactions'][0]['amount']['currency']
                                        },
                                        type: "POST",
                                        dataType: "json",
                                        success: function (res) {
                                            var t1 = base_url + '/dashboard';
                                            if (window.location.href != t1) {
                                                sessionStart('n', userIndexGeneral);
                                            } else {
                                                alert('Transaction Completed')
                                            }
                                            $step4NoMoney.animate({
                                                'opacity': '0',
                                                'z-index': '-5'
                                            }, 500)
                                        }
                                    })
                                });
                            },
                        }, '#paypal-button-container');
                    </script>

                </div>
            </div>
        </div>
    </div>

    <!-- join affiliate ends -->
@endsection
