@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Customers | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Customers</h2>
                </div>
            </div>
            <div class="card mb-4">
                <header class="card-header">
                    <div class="row gx-3">
                        <div class="col-lg-5 col-md-5 me-auto">
                            <form class="searchform" method="POST" action="{{ route('Admin.used-coupons-term') }}">
                                @csrf
                                <div class="input-group">
                                    <input list="search_terms" type="text" name="term" class="form-control"
                                        placeholder="Search by term">
                                    <button class="btn btn-light bg" type="submit"> <i
                                            class="material-icons md-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <form class="col-lg-6 col-6 col-md-3 d-flex justify-content-end"
                            action="{{ route('Admin.used-coupons-post') }}" method="POST">
                            @csrf
                            <div class="col-lg-2 col-2 col-md-4">
                                <select class="form-select" name="record" onchange="this.form.submit()">
                                    <option value="20" @selected($record_perpage == 20)>20</option>
                                    <option value="30" @selected($record_perpage == 30)>30</option>
                                    <option value="40" @selected($record_perpage == 40)>40</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </header>
                <!-- card-header end// -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>
                                            <a href="javascript:void(0)" class="itemside">
                                                <div class="info pl-3">
                                                    <h6 class="mb-0 title">{{ $customer->first_name }} {{ $customer->last_name }}</h6>
                                                </div>
                                            </a>
                                        </td>
                                        <td>{{ $customer->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> <!-- table-responsive.// -->
                    </div>
                </div> 
                <!-- card-body end// -->
            </div>
            <div class="pagination-area mt-30 mb-50">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        @if (!empty($coupons))
                            {{ $customers->render() }}
                        @endif

                    </ul>
                </nav>
            </div>
        </section>
    @endsection
    @push('footer')
        <script>
            function delete_customer(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('Admin.delete-customer') }}",
                    data: {
                        'id': id
                    },
                    type: 'POST',
                    beforeSend: function() {
                        $("#loading_btn_" + id).removeAttr('hidden');
                        $("#dlt_btn_" + id).hide();
                    },
                    success: function(data) {
                        if (data.success) {
                            iziToast.success({
                                position: 'topRight',
                                message: data.message,
                            });
                            window.location.reload();
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
