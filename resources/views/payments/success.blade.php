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
                        <h5 class="mb-0">Payment Successfull</h5>
                    </div>
                    <div class="card-body">
                        <p>Mail has been sent to your mail. Thanks for choosing Us.</p>
                        @php
                            if (str_contains(session()->get('order_id'), "SDRO")) {
                                $id = str_replace("SDRO", "", session()->get('order_id'));
                                \App\Models\Orders::where('id','=',$id)->update(['payment_status'=>'Paid']);
                                if(!empty(session()->get('payment_id'))){
                                    \App\Models\Orders::where('id','=',$id)->update(['transection_id'=>session()->get('payment_id')]);
                                }
                            }else{
                                $id = str_replace("SDVO", "", session()->get('order_id'));
                                \App\Models\VistorOrders::where('id','=',$id)->update(['payment_status'=>'Paid']);
                                if(!empty(session()->get('payment_id'))){
                                    \App\Models\Orders::where('id','=',$id)->update(['transection_id'=>session()->get('payment_id')]);
                                }
                            }
                            session()->forget('order_id');
                            session()->forget('payment_id');
                        @endphp
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
