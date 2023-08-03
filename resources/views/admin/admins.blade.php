@php
use Illuminate\Support\Str;
@endphp
@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Admins | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <h2 class="content-title">Admins</h2>
                <div>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#onloadModal" class="btn btn-primary"><i
                            class="material-icons md-plus"></i> Add admin</button>
                </div>
            </div>
            <div class="card mb-4">
                <header class="card-header">
                    <div class="row gx-3">
                        <div class="col-lg-4 col-md-6 me-auto">
                            <input type="text" placeholder="Search..." class="form-control">
                        </div>
                        <div class="col-lg-2 col-md-3 col-6">
                            <select class="form-select">
                                <option readonly hidden>Select Role</option>
                                <option value="Super Admin">Super Admin</option>
                                <option value="Website Manager">Website Manager</option>
                                <option value="Account Manager">Account Manager</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3 col-6">
                            <select class="form-select">
                                <option>Show 20</option>
                                <option>Show 30</option>
                                <option>Show 40</option>
                            </select>
                        </div>
                    </div>
                </header> <!-- card-header end// -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Admin</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Registered</th>
                                    <th class="text-end"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr>
                                        <td>
                                            <a href="javascript:void(0)" class="itemside">
                                                <div class="info pl-3">
                                                    <h6 class="mb-0 title">{{ $admin->name }}</h6>
                                                    <small class="text-muted">Username: {{ $admin->username }}</small>
                                                </div>
                                            </a>
                                        </td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->role }}</td>
                                        <td>{{ Str::words($admin->created_at, 10, '') }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-danger rounded font-sm mt-15"
                                                id="dlt_btn_{{ $admin->id }}"
                                                onclick="delete_admin({{ $admin->id }})">Delete</a>
                                            <a class="bbtn btn-sm btn-danger rounded font-sm mt-15" type="button"
                                                id="loading_btn_{{ $admin->id }}" hidden>
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> <!-- table-responsive.// -->
                    </div>
                </div> <!-- card-body end// -->
            </div> <!-- card end// -->
            <div class="pagination-area mt-15 mb-50">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        <li class="page-item active"><a class="page-link" href="#">01</a></li>
                        <li class="page-item"><a class="page-link" href="#">02</a></li>
                        <li class="page-item"><a class="page-link" href="#">03</a></li>
                        <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="#">16</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i
                                    class="material-icons md-chevron_right"></i></a></li>
                    </ul>
                </nav>
            </div>
            <div class="modal fade custom-modal" id="onloadModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('/admin/add-admin') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input class="form-control" placeholder="Full Name" name="name" type="text"
                                        required>
                                </div> <!-- form-group// -->
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input class="form-control" placeholder="Username" name="username" type="text"
                                        required>
                                </div> <!-- form-group// -->
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input class="form-control" placeholder="Email" name="email" type="email" required>
                                </div> <!-- form-group// -->
                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select class="form-select" name="role" required>
                                        <option readonly hidden>Select Role</option>
                                        <option value="Super Admin">Super Admin</option>
                                        <option value="Website Manager">Website Manager</option>
                                        <option value="Account Manager">Account Manager</option>
                                    </select>
                                </div> <!-- form-group// -->
                                <div class="mb-3">
                                    <label class="form-label">Create password</label>
                                    <input class="form-control" placeholder="Password" name="paasword" type="password"
                                        required>
                                </div> <!-- form-group// -->
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary w-100"> Add Admin </button>
                                </div> <!-- form-group// -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
    @push('footer')
        <script>
            function delete_admin(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/delete-admin') }}",
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
