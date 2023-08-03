@extends('layouts.main')
@push('head')
    <title>Make Payment | Baggage factory</title>
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
                        <h5 class="mb-0">Make Payment</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('stripe.payment') }}" method="POST">
                            @csrf
                            <script
                              src="https://checkout.stripe.com/checkout.js"
                              class="stripe-button"
                              data-key="pk_test_51Laj1vHkcyJzI4kmHMUwLAnv4lJZUu7nfYTFz894Ff8JtaOebPJGHDktlWaBtX4tuAMHJ1CfeZIHxNUwuyVr640I00Vjg0x4qb"
                              data-name="Baggage Factory"
                              data-description="{{ session()->get('order_id') }}"
                              data-amount="{{ session()->get('order_bill') * 100 }}"
                              data-label="Make Payment"
                              data-image="{{ asset('uploads/website/Logo.png') }}"
                              data-currency="GBP">
                            </script>
                          </form>
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
