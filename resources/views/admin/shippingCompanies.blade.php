@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Shipping Companies | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Shipping Companies </h2>
                    <p>Add or delete a shipping company</p>
                </div>
                <div>
                    <input type="text" placeholder="Search Categories" class="form-control bg-white">
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{ route('Admin.add-shipping-company') }}" method="POST">
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
                                    <label for="slug" class="form-label">Tracking URL</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="tracking_url" name="tracking_url" required/>
                                    <small class="text-danger">
                                        @error('tracking_url')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <label for="show" class="form-label">Enable/Disable</label>
                                    <select class="form-select" id="show" name="show" required>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    <small class="text-danger">
                                        @error('show')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit">Add Shipping Company</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Tracking URL</th>
                                            <th>Is Enable</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($companies as $company)
                                            <tr>
                                                <td><b>{{ $company->name }}</b></td>
                                                <td>{{ $company->tracking_url }}</td>
                                                <td>
                                                    <div class="mb-1">
                                                        <select class="form-select" id="show_select_{{ $company->id }}"
                                                            onchange="show_company({{ $company->id }})">
                                                            <option value="Yes"
                                                                @if ($company->is_enable == 'Yes') Selected @endif>Yes
                                                            </option>
                                                            <option value="No"
                                                                @if ($company->is_enable == 'No') Selected @endif>No
                                                            </option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a data-bs-toggle="dropdown"
                                                            class="btn btn-light rounded btn-sm font-sm"> <i
                                                                class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item text-danger"
                                                                onclick="delete_company({{ $company->id }})">Delete</a>
                                                        </div>
                                                    </div> <!-- dropdown //end -->
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
            function show_company(id) {
                $.ajax({
                    url: "{{ route('Admin.show-shipping-company') }}",
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
            function delete_company(id) {                
                $.ajax({
                    url: "{{ route('Admin.delete-shipping-company') }}",
                    data: {
                        'id': id
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success) {
                            iziToast.success({
                                position: 'topRight',
                                message: data.message,
                            });
                            location.reload();
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
