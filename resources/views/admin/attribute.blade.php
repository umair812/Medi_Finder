@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Attributes | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Attribute </h2>
                    <p>Add or delete a attribute</p>
                </div>
                <div>
                    <input type="text" placeholder="Search Categories" class="form-control bg-white">
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{ url('/admin/add-attribute') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="name" name="name" required/>
                                    <small class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <label for="widget" class="form-label">Widget</label>
                                    <select class="form-select" id="widget" name="widget" required>
                                        <option readonly hidden>Select Widget</option>
                                        <option value="radio">Radio</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="select">Dropdown</option>
                                    </select>
                                    <small class="text-danger">
                                        @error('widget')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary">Create Attribute</button>
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
                                            <th>Widget</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attributes as $attribute)
                                            <tr>
                                                <td>{{ $attribute->id }}</td>
                                                <td><b>{{ $attribute->name }}</b></td>
                                                <td>{{ $attribute->widget }}</td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a data-bs-toggle="dropdown"
                                                            class="btn btn-light rounded btn-sm font-sm"> <i
                                                                class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item text-danger"
                                                                onclick="delete_attribute({{ $attribute->id }})">Delete</a>
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
            function delete_attribute(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/delete-attribute') }}",
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
