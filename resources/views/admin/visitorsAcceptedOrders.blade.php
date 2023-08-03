@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Visitors Orders | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Visitors Orders List </h2>
                </div>
            </div>
            @if (count($orders) > 0)
                <div class="card mb-4">
                    <header class="card-header">
                        <div class="row gx-3">
                            <div class="col-lg-4 col-md-4 me-auto">
                                <form class="searchform" method="POST" action="{{ route('Admin.get-v-order') }}">
                                    @csrf
                                    <div class="input-group">
                                        <input list="search_terms" type="text" name="id" class="form-control"
                                            placeholder="Search term">
                                        <button class="btn btn-light bg" type="submit"> <i
                                                class="material-icons md-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-8 col-8 col-md-8 d-flex justify-content-end">
                                <form method="POST" action="{{ route('Admin.get-v-orders') }}" class="row">
                                    @csrf
                                    <div class="col-lg-7 col-7 col-md-7">
                                        <select class="form-select" name="status" onchange="this.form.submit()">
                                            <option value="All" @selected($status == 'All')>All</option>
                                            <option value="Accepted" @selected($status == 'Accepted')>Accepted</option>
                                            <option value="Dispatched" @selected($status == 'Dispatched')>Dispatched</option>
                                            <option value="Completed" @selected($status == 'Completed')>Completed</option>
                                            <option value="Cancel" @selected($status == 'Cancel')>Cancel</option>
                                            <option value="Return" @selected($status == 'Return')>Return</option>
                                            <option value="New Order" @selected($status == 'New Order')>New Order</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-5 col-5 col-md-5">
                                        <select class="form-select" name="record" onchange="this.form.submit()">
                                            <option value="20" @selected($record_perpage == '20')>20</option>
                                            <option value="30" @selected($record_perpage == '30')>30</option>
                                            <option value="40" @selected($record_perpage == '40')>40</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </header> <!-- card-header end// -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col" class="text-end"> Action </th>
                                    </tr>
                                </thead>
                                <tbody id="ruo-result">
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>SDVO#{{ $order->id }}</td>
                                            <td>
                                                <b>
                                                    {{ $order->first_name }} {{ $order->last_name }}
                                                </b>
                                            </td>
                                            <td>{{ $order->email }}</td>
                                            <td>${{ $order->bill }}</td>
                                            <td>
                                                @if ($order->status == 'Accepted')
                                                    <span class="badge rounded-pill alert-primary">Accepted</span>
                                                @elseif ($order->status == 'Dispatched')
                                                    <span class="badge rounded-pill alert-info">Dispatched</span>
                                                @elseif ($order->status == 'Completed')
                                                    <span class="badge rounded-pill alert-success">Completed</span>
                                                @elseif ($order->status == 'Cancel')
                                                    <span class="badge rounded-pill alert-danger">Cancel</span>
                                                @else
                                                    <span class="badge rounded-pill alert-secondary">New Order</span>
                                                @endif
                                            </td>
                                            <td>{!! date('d-M-y', strtotime($order->created_at)) !!}</td>
                                            <td class="text-end">
                                                <a href="{{ url('/admin/visitor-order-detail/' . $order->id) }}"
                                                    class="btn btn-md rounded font-sm">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- table-responsive //end -->
                    </div> <!-- card-body end// -->
                </div> <!-- card end// -->
                <div class="pagination-area mt-30 mb-50">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            {{ $orders->render() }}
                        </ul>
                    </nav>
                </div>
            @else
                <div class="d-flex justify-content-center align-items-center">
                    <h3>No Order Accepted Yet.</h3>
                </div>
            @endif
        </section> <!-- content-main end// -->
    @endsection
    @push('footer')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    @endpush
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
