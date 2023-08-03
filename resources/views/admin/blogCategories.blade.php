@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Blog Categories | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Blog Categories </h2>
                    <p>Add or delete a category</p>
                </div>
                <div>
                    <input type="text" placeholder="Search Categories" class="form-control bg-white">
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{ url('/admin/add-blog-category') }}" method="POST">
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
                                <div class="d-grid">
                                    <button class="btn btn-primary">Create Category</button>
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
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($blog_categories as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td><strong>{{ $category->name }}</strong></td>
                                                <td>/{{ $category->slug }}</td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a data-bs-toggle="dropdown"
                                                            class="btn btn-light rounded btn-sm font-sm"> <i
                                                                class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item text-danger"
                                                                onclick="delete_category({{ $category->id }})">Delete</a>
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
            function delete_category(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/delete-blog-category') }}",
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