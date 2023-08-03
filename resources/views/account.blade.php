@extends('layouts.main')
@push('head')
    <title>My Account | Baggage Factory</title>
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
@if (session()->has('customer'))
    @section('section')
        <main class="main">
            <div class="page-header breadcrumb-wrap">
                <div class="container">
                    <div class="breadcrumb">
                        <a href="{{ url('/') }}" rel="nofollow">Home</a>
                        <span></span> My Account
                    </div>
                </div>
            </div>
            <section class="pt-150 pb-150">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 m-auto">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="dashboard-menu">
                                        <ul class="nav flex-column" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab"
                                                    href="#dashboard" role="tab" aria-controls="dashboard"
                                                    aria-selected="false"><i
                                                        class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders"
                                                    role="tab" aria-controls="orders" aria-selected="false"><i
                                                        class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab"
                                                    href="#track-orders" role="tab" aria-controls="track-orders"
                                                    aria-selected="false"><i
                                                        class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address"
                                                    role="tab" aria-controls="address" aria-selected="true"><i
                                                        class="fi-rs-marker mr-10"></i>My Address</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab"
                                                    href="#account-detail" role="tab" aria-controls="account-detail"
                                                    aria-selected="true"><i class="fi-rs-user mr-10"></i>Account details</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ url('/logout') }}"><i
                                                        class="fi-rs-sign-out mr-10"></i>Logout</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="tab-content dashboard-content">
                                        <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                            aria-labelledby="dashboard-tab">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-0">Hello {{ session()->get('customer.user_name') }}!
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <p>From your account dashboard. you can easily check &amp; view your <a
                                                            href="#orders">recent orders</a>, manage your <a
                                                            href="#address">shipping and billing addresses</a> and <a
                                                            href="#account-detail">edit your password and account
                                                            details.</a></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="orders" role="tabpanel"
                                            aria-labelledby="orders-tab">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-0">Your Orders</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        @if (count($orders) > 0)
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Order</th>
                                                                        <th>Date</th>
                                                                        <th>Status</th>
                                                                        <th>Total</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($orders as $order)
                                                                        <tr>
                                                                            <td>SDRO{{ $order->id }}</td>
                                                                            <td>{!! date('d-M-y', strtotime($order->created_at)) !!}</td>
                                                                            <td>
                                                                                @if ($order->status == 'New Order')
                                                                                    Pending
                                                                                @elseif ($order->status == 'Accepted')
                                                                                    Order confirmed
                                                                                @elseif ($order->status == 'Dispatced')
                                                                                    Picked by courier
                                                                                @else
                                                                                    {{ $order->status }}
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ currency_converter($order->bill) }} for
                                                                                {{ $order->item }} item</td>
                                                                            <td><a aria-label="View" class="btn-small"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#orderModal{{ $order->id }}">View</a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                No Orders Yet.
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="track-orders" role="tabpanel"
                                            aria-labelledby="track-orders-tab">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-0">Orders tracking</h5>
                                                </div>
                                                <div class="card-body contact-from-area">
                                                    <p>To track your order please enter your OrderID in the box below and
                                                        press "Track" button. This was given to you on your receipt and in
                                                        the confirmation email you should have received.</p>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <form class="contact-form-style mt-30 mb-50" id="track_order">
                                                                <div class="input-style mb-20">
                                                                    <label>Order Number</label>
                                                                    <input name="id"
                                                                        placeholder="Found in your order confirmation email"
                                                                        type="text" class="square" required>
                                                                </div>
                                                                <button class="submit submit-auto-width"
                                                                    type="submit">Track</button>
                                                            </form>
                                                        </div>
                                                        <div class="card col-lg-12 border-0" id="result" hidden>
                                                            <div class="card-body">
                                                                <h6 id="orderid"></h6><br>
                                                                <div class="row border">
                                                                    <div class="col"> <strong>Estimated Delivery
                                                                            Time:</strong> <br><span id="order_ed"></span>
                                                                    </div>
                                                                    <div class="col"> <strong>Shipping By:</strong> <br>
                                                                        <span id="order_c"></span> </div>
                                                                    <div class="col"> <strong>Status:</strong> <br>
                                                                        <span id="order_status"></span> </div>
                                                                    <div class="col"> <strong>Tracking #:</strong> <br>
                                                                        <span id="order_td"></span> </div>
                                                                </div>
                                                                <div class="track" id="track">
                                                                    <div class="step" id="step1"> <span
                                                                            class="icon"> <i class="fa fa-user"></i>
                                                                        </span> <span class="text">Pending</span> </div>
                                                                    <div class="step" id="step2"> <span
                                                                            class="icon"> <i class="fa fa-check"></i>
                                                                        </span> <span class="text">Order confirmed</span>
                                                                    </div>
                                                                    <div class="step" id="step3"> <span
                                                                            class="icon"> <i class="fa fa-truck"></i>
                                                                        </span> <span class="text"> Picked by
                                                                            courier</span> </div>
                                                                    <div class="step" id="step4"> <span
                                                                            class="icon"> <i class="fa fa-box"></i>
                                                                        </span> <span class="text">Completed</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="address" role="tabpanel"
                                            aria-labelledby="address-tab">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="card mb-3 mb-lg-0">
                                                        <div class="card-header">
                                                            <h5 class="mb-0">Shipping Address</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            @foreach ($customer as $item)
                                                                <address>
                                                                    @if (!empty($item->address1))
                                                                        {{ $item->address1 }},<br>
                                                                    @endif
                                                                    @if (!empty($item->address2))
                                                                        {{ $item->address1 }},<br>
                                                                    @endif
                                                                    @if (!empty($item->city))
                                                                        {{ $item->city }},<br>
                                                                    @endif
                                                                    @if (!empty($item->postal_code))
                                                                        {{ $item->postal_code }},<br>
                                                                    @endif
                                                                    @if (!empty($item->contact_number))
                                                                        Phone: {{ $item->contact_number }}
                                                                    @endif
                                                                </address>
                                                                @if (!empty($item->state))
                                                                    <p>{{ $item->state }}</p>
                                                                @endif
                                                            @endforeach
                                                            <a aria-label="Billing Address" class="btn-small"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#billingModal">Edit</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="account-detail" role="tabpanel"
                                            aria-labelledby="account-detail-tab">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Account Details</h5>
                                                </div>
                                                <div class="card-body">
                                                    <form id="update_form">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label>First Name <span class="required">*</span></label>
                                                                <input required="" class="form-control square"
                                                                    name="first_name" type="text"
                                                                    value="{{ session()->get('customer.f_name') }}">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Last Name <span class="required">*</span></label>
                                                                <input required="" class="form-control square"
                                                                    name="last_name"
                                                                    value="{{ session()->get('customer.l_name') }}">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Username <span class="required">*</span></label>
                                                                <input required="" class="form-control square"
                                                                    name="dname" type="text"
                                                                    value="{{ session()->get('customer.user_name') }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Email Address <span
                                                                        class="required">*</span></label>
                                                                <input required="" class="form-control square"
                                                                    name="email" type="email"
                                                                    value="{{ session()->get('customer.email') }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Current Password <span
                                                                        class="required">*</span></label>
                                                                <input required="" class="form-control square"
                                                                    name="cpassword" type="password">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>New Password <span class="required">*</span></label>
                                                                <input required="" class="form-control square"
                                                                    name="password" type="password">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Confirm Password <span
                                                                        class="required">*</span></label>
                                                                <input required="" class="form-control square"
                                                                    name="password_confirmation" type="password">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <button type="submit" class="btn btn-fill-out submit"
                                                                    name="submit" value="Submit">Save</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <div class="modal fade custom-modal" id="billingModal" tabindex="-1" aria-labelledby="billingModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body ">
                        <div class="row" style="margin-top:40px ">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <form id="billing_form">
                                    <div class="form-group">
                                        <input type="text" name="billing_address" required=""
                                            placeholder="Address *">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="billing_address2" placeholder="Address line2">
                                    </div>
                                    <div class="form-group">
                                        <input required="" type="text" name="city" placeholder="City / Town *">
                                    </div>
                                    <div class="form-group">
                                        <input required="" type="text" name="state"
                                            placeholder="State / County *">
                                    </div>
                                    <div class="form-group">
                                        <input required="" type="text" name="zipcode"
                                            placeholder="Postcode / ZIP *">
                                    </div>
                                    <div class="form-group">
                                        <input required="" type="text" name="phone" placeholder="Phone *">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn" value="Update">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($orders as $order)
            <div class="modal fade custom-modal" id="orderModal{{ $order->id }}" tabindex="-1"
                aria-labelledby="billingModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body ">
                            <div class="row" style="margin-top:40px ">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row mb-10">
                                        <div class="col"> <strong>Estimated Delivery Time:</strong> <br> </div>
                                        <div class="col"> <strong>Shipping By:</strong> <br> </div>
                                        <div class="col"> <strong>Status:</strong> <br>
                                            @if ($order->status == 'New Order')
                                                Pending
                                            @elseif ($order->status == 'Accepted')
                                                Order confirmed
                                            @elseif ($order->status == 'Dispatced')
                                                Picked by courier
                                            @else
                                                {{ $order->status }}
                                            @endif
                                        </div>
                                        <div class="col"> <strong>Tracking #:</strong> <br> </div>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Sub Bill</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $bill = 0;
                                            @endphp
                                            @foreach ($order->order_details as $order_detail)
                                                <tr>
                                                    <td>{{ $order_detail->products->title }}</td>
                                                    <td>{{ $order_detail->qty }}</td>
                                                    <td>{{ currency_converter($order_detail->sub_bill) }}</td>
                                                </tr>
                                                @php
                                                    $bill = $bill + $order_detail->sub_bill;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-9"></div>
                                <div class="col-md-3 col-sm-3 col-xs-3 text-center">
                                    <b>Total Bill : </b>{{ currency_converter($bill) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endsection
    @push('footer')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#update_form").submit(function(e) {
                e.preventDefault(); // prevent actual form submit
                var form = $(this);
                var url = "{{ url('/update') }}"; //get submit url [replace url here if desired]
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes form input
                    success: function(response) {
                        if (response.success) {
                            iziToast.success({
                                position: 'topRight',
                                message: response.message
                            });
                            window.location.href = "{{ url('/logout') }}";
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
            $("#billing_form").submit(function(e) {
                e.preventDefault(); // prevent actual form submit
                var form = $(this);
                var url = "{{ route('billing.form') }}"; //get submit url [replace url here if desired]
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes form input
                    success: function(response) {
                        if (response.success) {
                            iziToast.success({
                                position: 'topRight',
                                message: response.message
                            });
                            window.location.reload();
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
@else
    <script>
        window.location.href = "{{ url('/') }}";
    </script>
@endif
