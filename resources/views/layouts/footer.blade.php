<footer class="main">
    <section class="newsletter p-30 text-white wow fadeIn animated">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-md-3 mb-lg-0">
                    <div class="row align-items-center">
                        <div class="col flex-horizontal-center">
                            <img class="icon-email" src="{{ asset('assets/imgs/theme/icons/icon-email.svg') }}"
                                alt="">
                            <h4 class="font-size-20 mb-0 ml-3">Sign up to Newsletter</h4>
                        </div>
                        <!-- <div class="col my-4 my-md-0 des">
                            <h5 class="font-size-15 ml-4 mb-0">...and receive <strong>{{ currency_converter(21.25) }}
                                    coupon for first
                                    shopping.</strong></h5>
                        </div> -->
                    </div>
                </div>
                <div class="col-lg-5">
                    <!-- Subscribe Form -->
                    <div class="form-subcriber d-flex wow fadeIn animated">
                        @csrf
                        <input type="email" name="subscriber_email" id="subscribeemail"
                            class="form-control bg-white font-small" placeholder="Enter your email" required>
                        <button class="btn bg-dark text-white" type="submit" onclick="subscribe()">Subscribe</button>
                    </div>
                    <!-- End Subscribe Form -->
                </div>
            </div>
        </div>
    </section>
    <section class="section-padding footer-mid">
        <div class="container pt-15 pb-20">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="widget-about font-md mb-md-5 mb-lg-0">
                        <div class="logo logo-width-1 wow fadeIn animated">
                            <a href="index.html"><img src="{{ asset('uploads/website/Logo.png') }}" alt="logo"></a>
                        </div>
                        <h5 class="mt-20 mb-10 fw-600 text-grey-4 wow fadeIn animated">Contact</h5>
                        <p class="wow fadeIn animated">
                            <strong>Mail: </strong><a href="mailto:m.arslan77733@gmail.com">sales@baggagefactory.co.uk</a>
                        </p>
                        <p class="wow fadeIn animated">
                            <strong>Opening Hours: </strong>9:00 AM - 5:00 PM,
                        </p>
                        <h5 class="mb-10 mt-30 fw-600 text-grey-4 wow fadeIn animated">Follow Us</h5>
                        <div class="mobile-social-icon wow fadeIn animated mb-sm-5 mb-md-0">
                            <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-facebook.svg') }}"
                                    alt=""></a>
                            <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-twitter.svg') }}"
                                    alt=""></a>
                            <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-instagram.svg') }}"
                                    alt=""></a>
                            <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-pinterest.svg') }}"
                                    alt=""></a>
                            <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-youtube.svg') }}"
                                    alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <h5 class="widget-title wow fadeIn animated">About</h5>
                    <ul class="footer-list wow fadeIn animated mb-sm-5 mb-md-0">
                        <li><a href="{{ url('/about') }}">About Us</a></li>                        
                        <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ url('/terms&conditions') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-3">
                    <h5 class="widget-title wow fadeIn animated">My Account</h5>
                    <ul class="footer-list wow fadeIn animated">
                        @if (!session()->has('customer'))
                            <li><a href="{{ url('/loginPage') }}">Sign In</a></li>
                        @endif
                        <li><a href="{{ url('/cart') }}">View Cart</a></li>
                        <li><a href="{{ url('/wishlist') }}">My Wishlist</a></li>
                        <li><a href="{{ url('/order-tracking') }}">Track My Order</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="widget-title wow fadeIn animated">Secured Payment Gateways</h5>
                    <img class="wow fadeIn animated" src="{{ asset('assets/imgs/theme/payment-method.png') }}"
                        alt="">
                </div>
            </div>
        </div>
    </section>
    <div class="container pb-20 wow fadeIn animated">
        <div class="row">
            <div class="col-12 mb-20">
                <div class="footer-bottom"></div>
            </div>
            <div class="col-lg-6">
                <p class="float-md-left font-sm text-muted mb-0">&copy; 2023, <strong class="text-brand">Baggage
                    Factory</strong></p>
            </div>
            <div class="col-lg-6">
                <p class="text-lg-end text-start font-sm text-muted mb-0">
                    Powered by <a href="" target="_blank">Arslan</a>. All rights
                    reserved
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- Preloader Start -->
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="text-center">
                <h5 class="mb-10">Now Loading</h5>
                <div class="loader">
                    <div class="bar bar1"></div>
                    <div class="bar bar2"></div>
                    <div class="bar bar3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vendor JS-->
<script src="{{ asset('assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/slick.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.syotimer.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/wow.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/js/plugins/magnific-popup.js') }}"></script>
<script src="{{ asset('assets/js/plugins/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/waypoints.js') }}"></script>
<script src="{{ asset('assets/js/plugins/counterup.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/images-loaded.js') }}"></script>
<script src="{{ asset('assets/js/plugins/isotope.js') }}"></script>
<script src="{{ asset('assets/js/plugins/scrollup.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.vticker-min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.theia.sticky.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.elevatezoom.js') }}"></script>
<!-- Template  JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/shop.js') }}"></script>
<script src="{{ asset('js/iziToast.js') }}"></script>
@include('vendor.lara-izitoast.toast')


</body>
<script>
    // Set the date we're counting down to
    var countDownDate = new Date("sep 10, 2022").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

        // Output the result in an element with id="demo"
        document.getElementById("demo").innerHTML = days + "d " + hours + "h ";

        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>
@stack('footer')
<script>
    function subscribe() {
        var email = $('#subscriber_email').val();
        $.ajax({
            method: "post",
            url: "{{ url('/subscribe') }}",
            data: {
                "subscribeemail": email,
                "_token": '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    iziToast.success({
                        position: 'topRight',
                        message: response.message
                    });
                } else {
                    iziToast.warning({
                        position: 'topRight',
                        message: response.message
                    });
                }
            },
            error: function(response) {
                iziToast.error({
                    position: 'topRight',
                    message: response.responseJSON.errors.subscriber_email[0]
                });
            }
        });
    }

    function currency_change(currency_code) {
        $.ajax({
            type: "POST",
            url: "{{ route('currency-load') }}",
            data: {
                'currency_code': currency_code,
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                } else {
                    iziToast.error({
                        position: 'topRight',
                        message: response.message
                    });
                }
            }
        });
    }
</script>

</html>
