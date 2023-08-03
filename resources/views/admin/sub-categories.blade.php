@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Sub Categories | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Categories </h2>
                    <p>Add or Delete Sub category</p>
                </div>
                <div>
                    <input type="text" placeholder="Search Categories" class="form-control bg-white" id="categorySearch">
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{ url('/admin/add-sub-category') }}" method="POST">
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
                                    <label class="form-label">Description</label>
                                    <textarea placeholder="Type here" class="form-control" id="description" name="description" required></textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Parent</label>
                                    <select class="form-select" id="parent" name="parent" required>
                                        <option readyonly hidden> Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_title }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">
                                        @error('parent')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <label for="show" class="form-label">Enable/Disable</label>
                                    <select class="form-select" id="show" name="show" required>
                                        <option readonly hidden>Wanna Show?</option>
                                        <option value="Enable">Enable</option>
                                        <option value="Disable">Disable</option>
                                    </select>
                                    <small class="text-danger">
                                        @error('show')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary">Create</button>
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
                                            <th>Description</th>
                                            <th>Slug</th>
                                            <th>Category</th>
                                            <th>Order</th>
                                            <th>Is Enable</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sub_categories as $sub_category)
                                            <tr>
                                                <td>{{ $sub_category->id }}</td>
                                                <td><b>{{ $sub_category->sub_category_title }}</b></td>
                                                <td>{{ $sub_category->sub_category_description }}</td>
                                                <td>{{ $sub_category->sub_category_slug }}</td>
                                                <td>{{ $sub_category->category_title }}</td>
                                                <td>{{ $sub_category->sub_category_order }}</td>
                                                <td>
                                                    <div class="mb-1">
                                                        <select class="form-select" id="show_select_{{ $sub_category->id }}"
                                                            onchange="show_sub_category({{ $sub_category->id }})">
                                                            <option value="Enable"
                                                                @if ($sub_category->sub_category_action == 'Enable') Selected @endif>Enable
                                                            </option>
                                                            <option value="Disable"
                                                                @if ($sub_category->sub_category_action == 'Disable') Selected @endif>Disable
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
                                                                onclick="delete_sub_category({{ $sub_category->id }})">Delete</a>
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
            function show_sub_category(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/show-sub-category') }}",
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
            function delete_sub_category(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/delete-sub-category') }}",
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
    // Function to perform the search
    function performSearch() {
        var searchText = $('#categorySearch').val().toLowerCase();

        // Loop through each row in the table
        $('.table tbody tr').each(function () {
            var rowText = $(this).text().toLowerCase();

            // Show/hide the row based on the search input
            if (rowText.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Attach event listener to the search input
    $('#categorySearch').on('input', function () {
        performSearch();
    });
    </script>
    @endpush
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
