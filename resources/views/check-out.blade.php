@if (!empty($carts))
    @extends('layouts.main')
    @push('head')
        <title>Check Out | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @php
        $total_cart_price = 0;
        $per_item_price = 0;
    @endphp

    @section('section')
        <main class="main">
            <div class="page-header breadcrumb-wrap">
                <div class="container">
                    <div class="breadcrumb">
                        <a href="{{ url('/cart') }}" rel="nofollow">Cart</a>
                        <span></span> Checkout
                    </div>
                </div>
            </div>
            <section class="mt-50 mb-50">
                <div class="container">
                    <div class="row">
                        @if (!session()->has('customer'))
                            <div class="col-lg-6 mb-sm-15">
                                <div class="toggle_info">
                                    <span><i class="fi-rs-user mr-10"></i><span class="text-muted">Already have an
                                            account?</span>
                                        <a href="#loginform" data-bs-toggle="collapse" class="collapsed"
                                            aria-expanded="false">Click
                                            here to login</a></span>
                                </div>
                                <div class="panel-collapse collapse login_form" id="loginform">
                                    <div class="panel-body">
                                        <p class="mb-30 font-sm">If you have shopped with us before, please enter your
                                            details
                                            below. If you are a new customer, please proceed to the Billing &amp; Shipping
                                            section.
                                        </p>
                                        <form id="login_form">
                                            <div class="form-group">
                                                <input type="text" name="email" required
                                                    placeholder="Username Or Email">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" required placeholder="Password">
                                            </div>
                                            <div class="login_footer form-group">
                                                <div class="chek-form">
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                                            id="remember" value="">
                                                        <label class="form-check-label" for="remember"><span>Remember
                                                                me</span></label>
                                                    </div>
                                                </div>
                                                <a href="#">Forgot password?</a>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-md" name="login">Log in</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="toggle_info">
                                <span><i class="fi-rs-label mr-10"></i><span class="text-muted">Have a coupon?</span> <a
                                        href="#coupon" data-bs-toggle="collapse" class="collapsed"
                                        aria-expanded="false">Click
                                        here to enter your code</a></span>
                            </div>
                            <div class="panel-collapse collapse coupon_form " id="coupon">
                                <div class="panel-body">
                                    <p class="mb-30 font-sm">If you have a coupon code, please apply it below.</p>
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter Coupon Code..." id="coupon_up">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-md" onclick="apply_coupon()">Apply Coupon</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="divider mt-50 mb-50"></div>
                        </div>
                    </div>
                    <form action="{{ route('customer.order') }}" method="POST">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="coupon" id="coupon-down" value="" />
                            @if (session()->has('customer'))
                                <div class="col-md-6">
                                    <div class="mb-25">
                                        <h4>Billing Details</h4>
                                    </div>
                                    @foreach ($customer as $item)
                                        <div class="form-group">
                                            <input type="text" required="" value="{{ $item->first_name }}"
                                                name="fname" placeholder="First name *" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" required="" value="{{ $item->last_name }}"
                                                name="lname" placeholder="Last name *" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="billing_address" value="{{ $item->address1 }}"
                                                required="" placeholder="Address *" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="billing_address2" value="{{ $item->address2 }}"
                                                placeholder="Address line2" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="text" name="city"
                                                value="{{ $item->city }}" placeholder="City / Town *" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="text" name="state"
                                                value="{{ $item->state }}" placeholder="State / County *" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="text" name="zipcode"
                                                value="{{ $item->postal_code }}" placeholder="Postcode / ZIP *" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="text" name="phone"
                                                value="{{ $item->contact_number }}" placeholder="Phone *" readonly>
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="text" name="email" id="email"
                                                value="{{ $item->email_addr }}" placeholder="Email address *" readonly>
                                        </div>
                                    @endforeach
                                    <div class="ship_detail">
                                        <div class="form-group">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="other"
                                                        value="on" id="differentaddress">
                                                    <label class="form-check-label label_info" data-bs-toggle="collapse"
                                                        data-target="#collapseAddress" href="#collapseAddress"
                                                        aria-controls="collapseAddress" for="differentaddress"><span>Ship
                                                            to a
                                                            different address?</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapseAddress" class="different_address collapse in">
                                            <div class="form-group">
                                                <input type="text" name="o_billing_address" placeholder="Address *">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="o_billing_address2"
                                                    placeholder="Address line2">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="o_city" placeholder="City / Town *">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="o_state" placeholder="State / County *">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="o_zipcode" placeholder="Postcode / ZIP *">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-20">
                                        <h5>Additional information</h5>
                                    </div>
                                    <div class="form-group mb-30">
                                        <textarea rows="5" placeholder="Order notes" name="note"></textarea>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <div class="mb-25">
                                        <h4>Billing Details</h4>
                                    </div>
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" required="" name="fname"
                                                placeholder="First name *">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" required="" name="lname"
                                                placeholder="Last name *">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="billing_address" required=""
                                                placeholder="Address *">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="billing_address2" placeholder="Address line2">
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="text" name="city"
                                                placeholder="City / Town *">
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
                                            <input required="" type="email" name="email" id="email"
                                                placeholder="Email address *">
                                        </div>
                                        <div class="mb-20">
                                            <h5>Additional information</h5>
                                        </div>
                                        <div class="form-group mb-30">
                                            <textarea rows="5" placeholder="Order notes"></textarea>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <div class="order_review">
                                    <div class="mb-20">
                                        <h4>Your Order</h4>
                                    </div>
                                    <div class="table-responsive order_table text-center">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Product</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $total_cart_price = 0;
                                                $per_item_price = 0;
                                            @endphp
                                            <script>
                                                let updateCart = [];
                                            </script>
                                            <tbody>
                                                @foreach ($carts as $item)
                                                    @foreach ($products as $product)
                                                        @if ($product->id == $item['products_id'])
                                                            <tr>
                                                                <td class="image product-thumbnail"><img
                                                                        src="{{ asset('uploads/' . $product->main_media) }}"
                                                                        alt="{{ $product->title }}"></td>
                                                                <td>
                                                                    <h5><a
                                                                            href="javascript:void(0)">{{ $product->title }}</a>
                                                                    </h5> <span class="product_qty">x
                                                                        {{ $item['qty'] }}</span>
                                                                </td>
                                                                <td>{{ currency_converter($item['price']) }}</td>
                                                            </tr>
                                                            @php
                                                                $per_item_price = $item['price'];
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    @php
                                                        $total_cart_price = $total_cart_price + $per_item_price;
                                                    @endphp
                                                @endforeach
                                                <tr>
                                                    <th>SubTotal</th>
                                                    <td class="product-subtotal" colspan="2">
                                                        {{ currency_converter($total_cart_price) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Shipping</th>
                                                    <td colspan="2"><em>Free Shipping</em></td>
                                                </tr>
                                                <tr>
                                                    <th>Total</th>
                                                    <td colspan="2" class="product-subtotal"><span
                                                            class="font-xl text-brand fw-900"
                                                            id="total_bill">{{ currency_converter($total_cart_price) }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                    <div class="payment_method">
                                        <div class="mb-25">
                                            <h5>Payment</h5>
                                        </div>
                                        <div class="payment_option">
                                            <div class="custome-radio">
                                                <input class="form-check-input" required="" type="radio"
                                                    name="payment_option" value="Paypal" id="paypal" required>
                                                <label class="form-check-label" for="paypal"><img
                                                        src={{ asset('uploads/website/paypal.png') }}
                                                        height="20px"></label>
                                            </div>
                                            <div class="custome-radio">
                                                <input class="form-check-input" required="" type="radio"
                                                    name="payment_option" value="Stripe" id="stripe">
                                                <label class="form-check-label" for="stripe"><img
                                                        src={{ asset('uploads/website/stripe.png') }}
                                                        height="20px"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-fill-out btn-block mt-30" value="Place Order">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    @endsection
    @push('footer')
        <!-- (Optional) Use CSS or JS implementation -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"
            integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#login_form").submit(function(e) {
                e.preventDefault(); // prevent actual form submit
                var form = $(this);
                var url = "{{ url('/login') }}"; //get submit url [replace url here if desired]

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

            function apply_coupon() {
                var coupon = $('#coupon_up').val();
                var email = $('#email').val();
                if (email !== "") {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('apply-coupon') }}",
                        data: {
                            'coupon': coupon,
                            'email': email,
                            'bill': {{ $total_cart_price }}
                        }, // serializes form input
                        success: function(response) {
                            if (response.success == 'info') {
                                iziToast.info({
                                    position: 'topRight',
                                    message: response.message
                                });
                            } else if (response.success) {
                                $('#total_bill').html(response.data);
                                $('#coupon_down').val(coupon)
                            } else {
                                iziToast.error({
                                    position: 'topRight',
                                    message: response.message
                                });
                            }
                        },
                    });
                } else {
                    iziToast.warning({
                        position: 'topRight',
                        message: 'Please Enter Your Email.'
                    });
                }
            }
        </script>
    @endpush
@else
    <script>
        window.location.url = {{ url('/') }};
    </script>
@endif
