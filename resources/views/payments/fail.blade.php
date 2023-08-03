@extends('layouts.main')
@push('head')
    <title>Order Confirm | Baggage Factory</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('section')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow">Home</a>
                    <span></span> Order Confirm
                </div>
            </div>
        </div>
        <section class="pt-100 pb-100">
            <div class="container d-flex justify-content-center align-items-center">
                <div class="card col-lg-6">
                    <div class="card-header">
                        <h5 class="mb-0">Payment Not Successfull</h5>
                    </div>
                    <div class="card-body">
                        <p>Mail has been sent to your mail. Please contact Admin for further detail.Thanks for choosing Us.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('footer')
    <script>
    </script>
@endpush
