@extends('layouts.main')
@push('head')
    <title>Track My Order | Baggage Factory</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');

        .track {
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 60px;
            margin-top: 50px
        }

        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative
        }

        .track .step.active:before {
            background: #088178
        }

        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px
        }

        .track .step.active .icon {
            background: #088178;
            color: #fff
        }

        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd
        }

        .track .step.active .text {
            font-weight: 400;
            color: #000
        }

        .track .text {
            display: block;
            margin-top: 7px
        }

        .itemside {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 100%
        }

        .itemside .aside {
            position: relative;
            -ms-flex-negative: 0;
            flex-shrink: 0
        }

        .img-sm {
            width: 80px;
            height: 80px;
            padding: 7px
        }

        ul.row,
        ul.row-sm {
            list-style: none;
            padding: 0
        }

        .itemside .info {
            padding-left: 15px;
            padding-right: 7px
        }

        .itemside .title {
            display: block;
            margin-bottom: 5px;
            color: #212529
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem
        }

        .btn-warning {
            color: #ffffff;
            background-color: #088178;
            border-color: #088178;
            border-radius: 1px
        }

        .btn-warning:hover {
            color: #ffffff;
            background-color: #088178;
            border-color: #088178;
            border-radius: 1px
        }
    </style>
@endpush
@section('section')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow">Home</a>
                    <span></span> Track My Order
                </div>
            </div>
        </div>
        <section class="pt-100 pb-100">
            <div class="container d-flex justify-content-center align-items-center">
                <div class="card col-lg-8">
                    <div class="card-header">
                        <h5 class="mb-0">Orders tracking</h5>
                    </div>
                    <div class="card-body">
                        <p>To track your order please enter your OrderID in the box below and
                            press "Track" button. This was given to you on your receipt and in
                            the confirmation email you should have received.</p>
                        <form class="contact-form-style mt-30 mb-10" id="track_order">
                            <div class="input-style mb-20">
                                <label>Order Number</label>
                                <input name="id" placeholder="Found in your order confirmation email" type="text"
                                    class="square" required>
                            </div>
                            <button class="submit submit-auto-width" type="submit">Track</button>
                        </form>
                    </div>
                    <div class="card col-lg-12 border-0" id="result" hidden>
                        <div class="card-body">
                            <h6 id="orderid"></h6><br>
                            <div class="row border">
                                <div class="col"> <strong>Estimated Delivery Time:</strong> <br><span
                                        id="order_ed"></span> </div>
                                <div class="col"> <strong>Shipping By:</strong> <br> <span id="order_c"></span> </div>
                                <div class="col"> <strong>Status:</strong> <br> <span id="order_status"></span> </div>
                                <div class="col"> <strong>Tracking #:</strong> <br> <span id="order_td"></span> </div>
                            </div>
                            <div class="track" id="track">
                                <div class="step" id="step1"> <span class="icon"> <i class="fa fa-user"></i> </span>
                                    <span class="text">Pending</span> </div>
                                <div class="step" id="step2"> <span class="icon"> <i class="fa fa-check"></i>
                                    </span> <span class="text">Order confirmed</span> </div>
                                <div class="step" id="step3"> <span class="icon"> <i class="fa fa-truck"></i>
                                    </span> <span class="text"> Picked by courier</span> </div>
                                <div class="step" id="step4"> <span class="icon"> <i class="fa fa-box"></i> </span>
                                    <span class="text">Completed</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('footer')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#track_order").submit(function(e) {
            e.preventDefault(); // prevent actual form submit
            var form = $(this);
            var url = "{{ route('track.order') }}"; //get submit url [replace url here if desired]
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes form input
                success: function(response) {
                    if (response.success) {
                        $('#result').removeAttr('hidden');
                        $("#track_order")[0].reset();
                        $('#orderid').html('Order ID: ' + response.message.id);
                        $('#orderid').html('Order ID: ' + response.message.id);
                        $('#orderid').html('Order ID: ' + response.message.id);
                        if (response.message.status == 'New Order' || response.message.status ==
                            'Accepted' ||
                            response.message.status == 'Dispatched' || response.message.status ==
                            'Completed') {
                            $('#track').attr('hidden', false);
                            if (response.message.status == 'New Order') {
                                $('#step1').addClass('active');
                                $('#step2').removeClass('active');
                                $('#step3').removeClass('active');
                                $('#step4').removeClass('active');
                                $('#order_status').html('Pending');
                            }
                            if (response.message.status == 'Accepted') {
                                $('#step1').addClass('active');
                                $('#step2').addClass('active');
                                $('#step3').removeClass('active');
                                $('#step4').removeClass('active');
                                $('#order_status').html('Order confirmed');
                            }
                            if (response.message.status == 'Dispatched') {
                                $('#step1').addClass('active');
                                $('#step2').addClass('active');
                                $('#step3').addClass('active');
                                $('#step4').removeClass('active');
                                $('#order_status').html('Picked by courier');
                            }
                            if (response.message.status == 'Completed') {
                                $('#step1').addClass('active');
                                $('#step2').addClass('active');
                                $('#step3').addClass('active');
                                $('#step4').addClass('active');
                                $('#order_status').html(response.message);
                            }
                        } else {
                            $('#order_status').html(response.message.status);
                            $('#track').attr('hidden', true);
                        }
                    } else {
                        iziToast.error({
                            position: 'topRight',
                            message: response.message
                        });
                    }
                },
                error: function(response) {
                    iziToast.error({
                        position: 'topRight',
                        message: response.responseJSON.errors
                    });
                }
            });
        });
    </script>
@endpush
