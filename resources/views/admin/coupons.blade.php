@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Coupons | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Coupons </h2>
                    <p>Add or delete a coupon</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{ route('Admin.add-coupon') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="product_name" class="form-label">Name</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="name" name="name" required/>
                                    <small class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <label for="discount_amount" class="form-label">Discount Amount</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="discount_amount" name="discount_amount" />
                                </div>
                                <div class="mb-4">
                                    <label for="discount_percentage" class="form-label">Discount Percentage</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="discount_percentage" name="discount_percentage" />
                                </div>
                                <div class="mb-4">
                                    <label for="usage" class="form-label">Usage</label>
                                    <input type="number" placeholder="Type here" class="form-control" id="usage" name="usage" required/>
                                    <small class="text-danger">
                                        @error('usage')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary">Create Coupon</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Coupon</th>
                                            <th>Discount Amount</th>
                                            <th>Discount Percentage</th>
                                            <th>Usage</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coupons as $coupon)
                                            <tr>
                                                <td>{{ $coupon->id }}</td>
                                                <td><b>{{ $coupon->coupon }}</b></td>
                                                <td>{{ $coupon->discount_amount }}</td>
                                                <td>{{ $coupon->discount_percentage }}</td>
                                                <td>{{ $coupon->usage }}</td>
                                                <td>
                                                    <div class="mb-1">
                                                        <select class="form-select" id="show_select_{{ $coupon->id }}"
                                                            onchange="change_coupon_status({{ $coupon->id }})">
                                                            <option value="Active"
                                                                @if ($coupon->status == 'Active') Selected @endif>Active
                                                            </option>
                                                            <option value="Expire"
                                                                @if ($coupon->status == 'Expire') Selected @endif>Expire
                                                            </option>
                                                            <option value="Deleted"
                                                                @if ($coupon->status == 'Deleted') Selected @endif>Deleted
                                                            </option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- .col// -->
                    </div> <!-- .row // -->
                </div> <!-- card body .// -->
            </div> <!-- card .// -->
        </section>
    @endsection
    @push('footer')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            function change_coupon_status(id) {
                $.ajax({
                    url: "{{ route('Admin.change-coupon-status') }}",
                    data: {
                        'id': id,
                        'status': $('#show_select_' + id + ' option:selected').val()
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success) {
                            iziToast.success({
                                position: 'topRight',
                                message: data.message,
                            });
                        } else {
                            iziToast.error({
                                position: 'topRight',
                                message: data.message,
                            });
                        }
                    }
                });
            }
        </script>
    @endpush
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
