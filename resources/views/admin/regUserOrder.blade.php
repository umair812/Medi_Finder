@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Register Users New Orders | Baggage Factory</title>
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Register Users New Orders List </h2>
                </div>
            </div>
            @if (count($orders) > 0)
                <div class="card mb-4">
                    <header class="card-header">
                        <div class="row gx-3">
                            <div class="col-lg-9 col-md-9 me-auto">
                                <form class="searchform" method="POST" action="{{ route('Admin.get-ru-new-order') }}">
                                    @csrf
                                    <div class="input-group">
                                        <input list="search_terms" type="text" name="id" class="form-control"
                                            placeholder="Search term">
                                        <button class="btn btn-light bg" type="submit"> <i
                                                class="material-icons md-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-3 col-3 col-md-3 d-flex justify-content-end">
                                <div class="col-lg-4 col-4 col-md-3">
                                    <form action="{{ route('Admin.get-ru-new-orders') }}" method="POST">
                                        @csrf
                                        <select class="form-select" name="record" onchange="this.form.submit()">
                                            <option value="20" @selected($record_perpage == 20)>20</option>
                                            <option value="30" @selected($record_perpage == 30)>30</option>
                                            <option value="40" @selected($record_perpage == 40)>40</option>
                                        </select>
                                    </form>
                                </div>
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
                                            <td>SDRO#{{ $order->id }}</td>
                                            <td>
                                                <b>
                                                    {{ $order->customers->first_name }} {{ $order->customers->last_name }}
                                                </b>
                                            </td>
                                            <td>{{ $order->customers->email_addr }}</td>
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
                                                <a href="{{ url('/admin/register-user-order-detail/' . $order->id) }}"
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
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
