@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Attribute Values | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Attribute Values </h2>
                    <p>Add or delete a attribute value</p>
                </div>
                <div>
                    <input type="text" placeholder="Search Categories" class="form-control bg-white">
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{ url('/admin/add-attribute-value') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="value" class="form-label">Value</label>
                                    <input type="text" placeholder="Type here" class="form-control" id="value" name="value" required/>
                                    <small class="text-danger">
                                        @error('value')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <label for="attribute" class="form-label">Attribute</label>
                                    <select class="form-select" id="attribute" name="attribute" required>
                                        <option readonly hidden>Select Attribute</option>
                                        @foreach ($attributes as $attribute)
                                            <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">
                                        @error('value')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary">Add Attribute Value</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Value</th>
                                            <th>Attribute</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attribute_values as $attribute_value)
                                            <tr>
                                                <td>{{ $attribute_value->id }}</td>
                                                <td><b>{{ $attribute_value->value }}</b></td>
                                                <td>
                                                    @foreach ($attributes as $attribute)
                                                        @if ($attribute->id == $attribute_value->attribute_id)
                                                            {{ $attribute->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a data-bs-toggle="dropdown"
                                                            class="btn btn-light rounded btn-sm font-sm"> <i
                                                                class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item text-danger"
                                                                onclick="delete_attribute_value({{ $attribute_value->id }})">Delete</a>
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
            function delete_attribute_value(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/delete-attribute-value') }}",
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
