@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Brands | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Brands </h2>
                    <p>Add or delete a brands</p>
                </div>
                <div>
                    <input type="text" placeholder="Search Categories" class="form-control bg-white">
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{ url('/admin/add-brand') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="slug" name="slug" required/>
                                    <small class="text-danger">
                                        @error('slug')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <input class="form-control" type="file" id="media" name="media" required>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary">Add Brand</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Media</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brands as $brand)
                                            <tr>
                                                <td>{{ $brand->id }}</td>
                                                <td><b>{{ $brand->name }}</b></td>
                                                <td>/{{ $brand->slug }}</td>
                                                <td><img class="img-xs" src="{{ asset('uploads/'. $brand->media) }}"
                                                    alt="{{ $brand->name }}"></td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a data-bs-toggle="dropdown"
                                                            class="btn btn-light rounded btn-sm font-sm"> <i
                                                                class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item text-danger"
                                                                onclick="delete_brand({{ $brand->id }})">Delete</a>
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
            function delete_brand(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/delete-brand') }}",
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
