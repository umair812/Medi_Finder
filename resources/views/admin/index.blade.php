@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Admin Dashboard | Baggage Factory</title>
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Dashboard </h2>
                    <p>Whole data about your business here</p>
                </div>
                <!-- <div>
                    <a href="#" class="btn btn-primary"><i class="text-muted material-icons md-post_add"></i>Create
                        report</a>
                </div> -->
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-body mb-4">
                        <article class="icontext">
                            <span class="icon icon-sm rounded-circle bg-primary-light"><i
                                    class="text-primary material-icons md-monetization_on"></i></span>
                            <div class="text">
                                <h6 class="mb-1 card-title">Revenue</h6>
                                <span>£{{ $sum }}</span>
                                <span class="text-sm">
                                    Shipping fees are not included
                                </span>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-body mb-4">
                        <article class="icontext">
                            <span class="icon icon-sm rounded-circle bg-success-light"><i
                                    class="text-success material-icons md-local_shipping"></i></span>
                            <div class="text">
                                <h6 class="mb-1 card-title">Orders</h6> <span>{{ $order_count }}</span>
                                <span class="text-sm">
                                    Excluding orders in transit
                                </span>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-body mb-4">
                        <article class="icontext">
                            <span class="icon icon-sm rounded-circle bg-warning-light"><i
                                    class="text-warning material-icons md-qr_code"></i></span>
                            <div class="text">
                                <h6 class="mb-1 card-title">Products</h6> <span>{{ count($products) }}</span>
                                <span class="text-sm">
                                    In {{ count($categories) }} Categories
                                </span>
                            </div>
                        </article>
                    </div>
                </div>
                <!-- <div class="col-lg-3">
                    <div class="card card-body mb-4">
                        <article class="icontext">
                            <span class="icon icon-sm rounded-circle bg-info-light"><i
                                    class="text-info material-icons md-shopping_basket"></i></span>
                            <div class="text">
                                <h6 class="mb-1 card-title">Monthly Earning</h6> <span>£0</span>
                                <span class="text-sm">
                                    Based in your local time.
                                </span>
                            </div>
                        </article>
                    </div>
                </div> -->
            </div>
            <div class="card mb-4">
                <header class="card-header">
                    <h4 class="card-title">Register User Latest Orders</h4>
                    <div class="row align-items-center">
                        <div class="col-md-2 col-6">
                            <input type="date" value="02.05.2021" class="form-control">
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle" scope="col">Order ID</th>
                                        <th class="align-middle" scope="col">Billing Name</th>
                                        <th class="align-middle" scope="col">Date</th>
                                        <th class="align-middle" scope="col">Total</th>
                                        <th class="align-middle" scope="col">Payment Method</th>
                                        <th class="align-middle" scope="col">View Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td><a href="javascript:void(0)" class="fw-bold">SDRO#{{ $order->id }}</a>
                                            </td>
                                            <td>{{ $order->customers->first_name }} {{ $order->customers->last_name }}</td>
                                            <td>
                                                {!! date('d-M-y', strtotime($order->created_at)) !!}
                                            </td>
                                            <td>
                                                £{{ $order->bill }}
                                            </td>
                                            <td>
                                                <i class="material-icons md-payment font-xxl text-muted mr-5"></i>
                                                {{ $order->payment_method }}
                                            </td>
                                            <td>
                                                <a href="{{ url('/admin/register-user-order-detail/' . $order->id) }}"
                                                    class="btn btn-xs"> View details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- table-responsive end// -->
                </div>
            </div>
            <div class="card mb-4">
                <header class="card-header">
                    <h4 class="card-title">Visitors latest Orders</h4>
                    <div class="row align-items-center">
                        <div class="col-md-2 col-6">
                            <input type="date" value="02.05.2021" class="form-control">
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle" scope="col">Order ID</th>
                                        <th class="align-middle" scope="col">Billing Name</th>
                                        <th class="align-middle" scope="col">Date</th>
                                        <th class="align-middle" scope="col">Total</th>
                                        <th class="align-middle" scope="col">Payment Method</th>
                                        <th class="align-middle" scope="col">View Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vistors_orders as $vistors_order)
                                        <tr>
                                            <td><a href="javascript:void(0)"
                                                    class="fw-bold">SDVO#{{ $vistors_order->id }}</a> </td>
                                            <td>{{ $vistors_order->first_name }} {{ $vistors_order->last_name }}</td>
                                            <td>
                                                {!! date('d-M-y', strtotime($vistors_order->created_at)) !!}
                                            </td>
                                            <td>
                                                £{{ $vistors_order->bill }}
                                            </td>
                                            <td>
                                                <i class="material-icons md-payment font-xxl text-muted mr-5"></i>
                                                {{ $vistors_order->payment_method }}
                                            </td>
                                            <td>
                                                <a href="{{ url('/admin/visitor-order-detail/' . $vistors_order->id) }}"
                                                    class="btn btn-xs"> View details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- table-responsive end// -->
                </div>
            </div>
        </section>
    @endsection
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
