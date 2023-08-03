@if (session()->has('admin'))
    @extends('admin.layout.main')
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            @push('head')
                <title>SDVO{{ $order->id }} | Baggage Factory</title>
                <meta name="csrf-token" content="{{ csrf_token() }}">
            @endpush
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Order detail</h2>
                    <p>Details for Order ID: SDVO{{ $order->id }}</p>
                </div>
            </div>
            <div class="card">
                <header class="card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 mb-lg-0 mb-15">
                            <span>
                                <i class="material-icons md-calendar_today"></i> <b>{!! date('d-M-y', strtotime($order->created_at)) !!}</b>
                            </span> <br>
                            <small class="text-muted">Order ID: SDVO{{ $order->id }}</small>
                        </div>
                        <div class="col-lg-6 col-md-6 ms-auto text-md-end d-flex justify-content-between">
                            <span class="">Current Status: <b>{{ $order->status }}</b></span>
                            @if ($order->status == 'New Order')
                                <button id="accept_btn" class="btn btn-md rounded font-sm"
                                    onclick="change_status('{{ $order->email }}',{{ $order->id }},'Accepted')">Accept</button>
                                <button id="loader_accept" class="btn btn-md rounded font-sm" style="display: none">
                                    <span class="spinner-border spinner-border-sm text-white m-2" role="status"
                                        aria-hidden="true"></span>
                                </button>
                                <button id="cancel_btn" class="btn btn-md rounded font-sm bg-danger"
                                    onclick="change_status('{{ $order->email }}',{{ $order->id }},'Cancel')">Cancel</button>
                                <button id="loader_cancel" class="btn btn-md rounded font-sm bg-danger"
                                    style="display: none">
                                    <span class="spinner-border spinner-border-sm text-white m-2" role="status"
                                        aria-hidden="true"></span>
                                </button>
                            @elseif ($order->status == 'Accepted')
                                <button id="dispatch_btn" class="btn btn-md rounded font-sm" data-bs-toggle="modal"
                                    data-bs-target="#shippingModal">Dispatch</button>
                                <button id="loader_dispatch" class="btn btn-md rounded font-sm" style="display: none">
                                    <span class="spinner-border spinner-border-sm text-white m-2" role="status"
                                        aria-hidden="true"></span>
                                </button>
                                <button id="cancel_btn" class="btn btn-md rounded font-sm bg-danger" data-bs-toggle="modal"
                                    data-bs-target="#cancelModal">Cancel</button>
                                <button id="loader_cancel" class="btn btn-md rounded font-sm bg-danger"
                                    style="display: none">
                                    <span class="spinner-border spinner-border-sm text-white m-2" role="status"
                                        aria-hidden="true"></span>
                                </button>
                            @elseif ($order->status == 'Dispatched')
                                <button id="complete_btn" class="btn btn-md rounded font-sm"
                                    onclick="change_status('{{ $order->email }}',{{ $order->id }},'Completed')">Completed</button>
                                <button id="loader_complete" class="btn btn-md rounded font-sm" style="display: none">
                                    <span class="spinner-border spinner-border-sm text-white m-2" role="status"
                                        aria-hidden="true"></span>
                                </button>
                                <button id="return_btn" class="btn btn-md rounded font-sm bg-danger" data-bs-toggle="modal"
                                    data-bs-target="#returnModal">Return</button>
                                <button id="loader_return" class="btn btn-md rounded font-sm bg-danger"
                                    style="display: none">
                                    <span class="spinner-border spinner-border-sm text-white m-2" role="status"
                                        aria-hidden="true"></span>
                                </button>
                            @endif
                        </div>
                    </div>
                </header> <!-- card-header end// -->
                <div class="card-body">
                    <div class="row mb-50 mt-20 order-info-wrap">
                        <div class="col-md-4">
                            <article class="icontext align-items-start">
                                <span class="icon icon-sm rounded-circle bg-primary-light">
                                    <i class="text-primary material-icons md-person"></i>
                                </span>
                                <div class="text">
                                    <h6 class="mb-1">Customer</h6>
                                    <p class="mb-1">
                                        {{ $order->first_name }} {{ $order->last_name }}<br>
                                        {{ $order->email }} <br> {{ $order->contact_number }}
                                    </p>
                                </div>
                            </article>
                        </div> <!-- col// -->
                        @if (!empty($order->order_shipping))
                            <div class="col-md-4">
                                <article class="icontext align-items-start">
                                    <span class="icon icon-sm rounded-circle bg-primary-light">
                                        <i class="text-primary material-icons md-local_shipping"></i>
                                    </span>
                                    <div class="text">
                                        <h6 class="mb-1">Shipping info</h6>
                                        <p class="mb-1">
                                            Shipping: Free <br> Shipping:
                                            {{ $order->order_shipping->shipping_companies->name }} <br> Tracking No:
                                            {{ $order->order_shipping->tracking_id }}
                                        </p>
                                    </div>
                                </article>
                            </div> <!-- col// -->
                        @endif
                        <div class="col-md-4">
                            <article class="icontext align-items-start">
                                <span class="icon icon-sm rounded-circle bg-primary-light">
                                    <i class="text-primary material-icons md-place"></i>
                                </span>
                                <div class="text">
                                    <h6 class="mb-1">Deliver to</h6>
                                    <p class="mb-1">
                                        {{ $order->city }} <br>{{ $order->address1 }} <br>
                                        {{ $order->postal_code }}
                                    </p>
                                </div>
                            </article>
                        </div> <!-- col// -->
                    </div> <!-- row // -->
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="40%">Product</th>
                                            <th width="20%">Unit Price</th>
                                            <th width="20%">Quantity</th>
                                            <th width="20%" class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->vistor_order_details as $item)
                                            <tr>
                                                <td>
                                                    <a class="itemside" href="#">
                                                        <div class="left">
                                                            <img src="{{ asset('uploads/' . $item->products->main_media) }}"
                                                                width="40" height="40" class="img-xs"
                                                                alt="Item">
                                                        </div>
                                                        <div class="info"> {{ $item->products->title }} </div>
                                                    </a>
                                                </td>
                                                <td> £{{ $item->sub_bill }} </td>
                                                <td> {{ $item->qty }} </td>
                                                <td class="text-end"> ${{ $item->sub_bill }} </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="4">
                                                <article class="float-end">
                                                    <dl class="dlist">
                                                        <dt>Subtotal:</dt>
                                                        <dd>£{{ $order->bill }}</dd>
                                                    </dl>
                                                    <dl class="dlist">
                                                        <dt>Shipping cost:</dt>
                                                        <dd>Free</dd>
                                                    </dl>
                                                    <dl class="dlist">
                                                        <dt>Grand total:</dt>
                                                        <dd> <b class="h5">£{{ $order->bill }}</b> </dd>
                                                    </dl>
                                                    <dl class="dlist">
                                                        <dt class="text-muted">Status:</dt>
                                                        <dd>
                                                            <span
                                                                class="badge rounded-pill alert-success text-warning">{{ $order->payment_status }}</span>
                                                        </dd>
                                                    </dl>
                                                </article>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> <!-- table-responsive// -->
                        </div> <!-- col// -->
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4">
                            <div class="box shadow-sm bg-light">
                                <h6 class="mb-15">Payment info</h6>
                                <p>
                                    {{ $order->payment_method }}
                                </p>
                            </div>
                            @if (!empty($order->cancel_reason))
                                <div class="box shadow-sm bg-light">
                                    <h6 class="mb-15">Cancel Reason</h6>
                                    <p>
                                        {{ $order->cancel_reason }}
                                    </p>
                                </div>
                            @endif
                            @if (!empty($order->return_reason))
                                <div class="box shadow-sm bg-light">
                                    <h6 class="mb-15">Return Reason</h6>
                                    <p>
                                        {{ $order->return_reason }}
                                    </p>
                                </div>
                            @endif
                            @if (!empty($order->note))
                                <div class="h-25 pt-4">
                                    <div class="mb-3">
                                        <label>Notes</label>
                                        <textarea class="form-control" name="notes" id="notes" placeholder="Type some note" readonly>{{ $order->note }}</textarea>
                                    </div>
                                </div>
                            @endif
                        </div> <!-- col// -->
                    </div>
                </div> <!-- card-body end// -->
            </div>
        </section> <!-- content-main end// -->
        <section>
            <div class="modal fade custom-modal" id="shippingModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Shipping Detail</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="shipping_form">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{ $order->id }}">
                                    <input type="hidden" name="email" value="{{ $order->email }}">
                                    <input type="hidden" name="status" value="Dispatched">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tracking No</label>
                                    <input type="text" class="form-control" name="tracking_id"
                                        placeholder="Tracking No." required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Expected Days</label>
                                    <input class="form-control" type="text" name="days" placeholder="Enter Days"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Shipping Company</label>
                                    <select class="form-select" name="shipping_companies_id" required>
                                        @foreach ($shipping_companies as $shipping_company)
                                            <option value="{{ $shipping_company->id }}">{{ $shipping_company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class="btn btn-primary w-100" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade custom-modal" id="returnModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Returning Reason</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="return_form">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{ $order->id }}">
                                    <input type="hidden" name="email" value="{{ $order->email }}">
                                    <input type="hidden" name="status" value="Return">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Returning Reason</label>
                                    <input type="text" class="form-control" name="return_reason"
                                        placeholder="Returning reason" required>
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class="btn btn-primary w-100" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade custom-modal" id="cancelModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Canceling Reason</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="cancel_form">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{ $order->id }}">
                                    <input type="hidden" name="email" value="{{ $order->email }}">
                                    <input type="hidden" name="status" value="Cancel">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Canceling Reason</label>
                                    <input type="text" class="form-control" name="Cancel_reason"
                                        placeholder="Canceling reason" required>
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class="btn btn-primary w-100" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
    @push('footer')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function change_status(email, id, status) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('Admin.v-change-order-status') }}",
                    data: {
                        'status': status,
                        'id': id,
                        'email': email
                    },
                    beforeSend: function() {
                        if (status == 'Accepted') {
                            document.getElementById("accept_btn").style.display = "none";
                            document.getElementById("loader_accept").style.display = "block";
                        } else if (status == 'Cancel') {
                            document.getElementById("cancel_btn").style.display = "none";
                            document.getElementById("loader_cancel").style.display = "block";
                        } else if (status == 'Dispatched') {
                            document.getElementById("dispatch_btn").style.display = "none";
                            document.getElementById("loader_dispatch").style.display = "block";
                        } else if (status == 'Completed') {
                            document.getElementById("complete_btn").style.display = "none";
                            document.getElementById("loader_complete").style.display = "block";
                        } else if (status == 'Return') {
                            document.getElementById("return_btn").style.display = "none";
                            document.getElementById("loader_return").style.display = "block";
                        }
                    },
                    success: function(response) {
                        if (response.success) {
                            iziToast.success({
                                position: 'topRight',
                                message: response.message,
                            });
                            window.location.reload();
                        } else {
                            iziToast.error({
                                position: 'topRight',
                                message: response.message,
                            });
                        }
                    }
                });
            }
            $("#shipping_form").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = "{{ route('Admin.v-change-order-status-dispatched') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
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
            $("#return_form").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = "{{ route('Admin.v-change-order-status-return') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
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
            $("#cancel_form").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = "{{ route('Admin.v-change-order-status-cancel') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
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
        </script>
    @endpush
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
