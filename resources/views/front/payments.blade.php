@extends('front.layout')
@section('content')

    <div class="container">
        <div class="row">

                <div class="col-md-12 modal-content1"  id="historyInner">
                    <!-- Modal Header -->
                    <div class="modal-header1">
                        <h4 class="modal-title1"><span>Payment</span> History</h4>

                    </div>
                    <!-- Modal body -->
                    <div class="modal-body1">
                        <div class="modal-credit1">
                            <p>Show activity from</p>
                            <select>
                                <option value="">1 Januare,2018</option>
                            </select>
                            <span>To</span>
                            <select>
                                <option value="">20 February,2018</option>
                            </select>
                            <a href="#">Update</a>
                            <div class="print1">
                                <a href="#"><i class="fas fa-print"></i>Print</a>
                                <a href="#"><i class="fas fa-download"></i>Download</a>
                            </div>
                        </div>
                        <table>
                            <tr>
                                <td>DATA & TIME</td>
                                <td class="w-401">TYPE</td>
                                <td>AMOUNT</td>
                                <td>BALANCE</td>
                            </tr>
                        </table>
                        <div class="modal-table1">
                            <div class="modal-table-singl1" id="modal-table-singl1" style="max-height: 500px">
                                <table class="addingPaymentHistory">

                                    @if(\Illuminate\Support\Facades\Auth::user()->role == 'expert')
                                        @php ($key = 0)
                                        @foreach($payments as $payment)
                                            <tr @if($key%2 == 0)class="bg-silver1"@else class="bg-silver1-light" @endif >
                                                <td>{{ $payment->create_time }}</td>
                                                <td class="w-40">{{ $payment->description }}</td>
                                                <td>${{ $payment->total }}</td>
                                                <td>${{ $payment->expert_balance }}</td>
                                            </tr>
                                            @php ($key ++)
                                        @endforeach
                                    @endif

                                    @if(\Illuminate\Support\Facades\Auth::user()->role == 'client')
                                        @php ($key = 0)
                                        @foreach($payments as $payment)
                                            <tr @if($key%2 == 0)class="bg-silver1"@else class="bg-silver1-light" @endif >
                                                <td>{{ $payment->create_time }}</td>
                                                <td class="w-40">{{ $payment->description }}</td>
                                                <td>${{ $payment->total }}</td>
                                                <td>${{ $payment->user_balance }}</td>
                                            </tr>
                                            @php ($key ++)
                                        @endforeach
                                    @endif

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>

    <div class="container">


        <div class="payments-block">
            <div class="col-lg-12 col-xs-12">
                <div class="row no-gutters">
                    {{--<h3> Payment Settings</h3>--}}


                   <div class="col-md-7 col-xs-12">
                       <div class="payments-content">

                           @if(\Illuminate\Support\Facades\Auth::user()->role == 'expert')
                                <p>Your earnings <span>{{ \Illuminate\Support\Facades\Auth::user()->funds }}$</span></p>
                           @endif
                           @if(\Illuminate\Support\Facades\Auth::user()->role == 'client')
                               <p>Your Funds <span>{{ \Illuminate\Support\Facades\Auth::user()->funds }}$</span></p>
                           @endif


                           @if($haveTransactions == 'not')
                               <p>You don’t have any previous transactions yet.</p>
                           @endif

                           @if( \Illuminate\Support\Facades\Auth::user()->role == 'client' )
                               <span style="
                                        display:  block;
                                        float:  left;
                                        margin-right: 14px;
                                    " id="addFunds_">I want to deposit</span>

                                   <input placeholder="Type Custom " min="1" type="number" id="customAmount" style="display: none;border: none;border-bottom: 1px solid black" >

                                   <select type="text" id="transaction_size" style="
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
                                   <span style="
                                        display:  block;
                                        float:  left;
                                        margin-right: 14px;">to my account. Using</span>

                                   <select type="text" id="transaction_type" style="
                                            display: block;
                                            margin: 5px 30px;
                                            border-radius: 3px;
                                            border: none;
                                            border-bottom: 1px solid;
                                            float: left;
                                    ">
                                       <option value="paypal">paypal</option>
                                   </select>
                               <div id="paypal">
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
                                                       dataType: "json"
                                                   })
                                               });
                                           },
                                       }, '#paypal-button-container');
                                   </script>
                           @endif
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
