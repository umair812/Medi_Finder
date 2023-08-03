@extends('layouts.main')
@push('head')
    <title>Login/Register | Baggage Factory</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('section')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow">Home</a>
                    <span></span> Login / Register
                </div>
            </div>
        </div>
        <section class="pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-lg-5">
                                <div
                                    class="login_wrap widget-taber-content p-30 background-white border-radius-10 mb-md-5 mb-lg-0 mb-sm-5">
                                    <div class="padding_eight_all bg-white">
                                        <div class="heading_s1">
                                            <h3 class="mb-30">Login</h3>
                                        </div>
                                        <form id="login_form">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" name="email"
                                                    value="{{ old('email') }}" placeholder="Username/Email" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" placeholder="Password"  required>
                                            </div>
                                            <div class="login_footer form-group">
                                                <div class="chek-form">
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                                            id="exampleCheckbox1" value="">
                                                        <label class="form-check-label"
                                                            for="exampleCheckbox1"><span>Remember me</span></label>
                                                    </div>
                                                </div>
                                                <a class="text-muted" href="#">Forgot password?</a>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-fill-out btn-block hover-up"
                                                    name="login">Log in</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1"></div>
                            <div class="col-lg-6">
                                <div class="login_wrap widget-taber-content p-30 background-white border-radius-5">
                                    <div class="padding_eight_all bg-white">
                                        <div class="heading_s1">
                                            <h3 class="mb-30">Create an Account</h3>
                                        </div>
                                        <p class="mb-50 font-sm">
                                            Your personal data will be used to support your experience throughout this
                                            website, to manage access to your account, and for other purposes described in
                                            our privacy policy
                                        </p>
                                        <form id="register_form">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" name="username" placeholder="Username"
                                                    value="{{ old('username') }}" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="f_name" placeholder="First Name"
                                                    value="{{ old('f_name') }}">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="l_name" placeholder="Last Name"
                                                    value="{{ old('f_name') }}">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="email" placeholder="Email"
                                                    value="{{ old('email') }}" required>
                                            </div>
                                            <div class="form-group">
                                                <input required="" type="password" name="password"
                                                    placeholder="Password">
                                            </div>
                                            <div class="form-group">
                                                <input required="" type="password" name="password_confirmation"
                                                    placeholder="Confirm password">
                                            </div>
                                            <div class="login_footer form-group">
                                                <div class="chek-form">
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                                            id="exampleCheckbox12" value="" required>
                                                        <label class="form-check-label" for="exampleCheckbox12"><span>I
                                                                agree to terms &amp; Policy.</span></label>
                                                    </div>
                                                </div>
                                                <a href="{{ url('/terms&conditions') }}"><i
                                                        class="fi-rs-book-alt mr-5 text-muted"></i>Lean more</a>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-fill-out btn-block hover-up"
                                                    name="login">Register</button>
                                            </div>
                                        </form>
                                        <div class="divider-text-center mt-15 mb-15">
                                            <span> or</span>
                                        </div>
                                        <!-- <ul class="btn-login list_none text-center mb-15">
                                            <li><a href="#" class="btn btn-facebook hover-up mb-lg-0 mb-sm-4">Login
                                                    With Facebook</a></li>
                                            <li><a href="#" class="btn btn-google hover-up">Login With Google</a>
                                            </li>
                                        </ul> -->
                                        <div class="text-muted text-center">Already have an account? <a
                                                href="#">Sign
                                                in now</a></div>
                                    </div>
                                </div>
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
                        window.location.href = "{{ url('/') }}";
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
        $("#register_form").submit(function(e) {
            e.preventDefault(); // prevent actual form submit
            var form = $(this);
            var url = "{{ url('/signup') }}"; //get submit url [replace url here if desired]
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
                        $("#register_form")[0].reset();
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
