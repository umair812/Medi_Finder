@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Products | Baggage Factory</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Products</h2>
                </div>
                <div>
                    <a href="{{ url('/admin/add-product') }}" class="btn btn-primary btn-sm rounded">Add New Product</a>
                </div>
            </div>
            <div class="card mb-4">
                <header class="card-header">
                    <div class="row gx-3">
                        <div class="col-lg-5 col-md-5 me-auto">
                            <form class="searchform" method="POST" action="{{ route('Admin.product-by-id') }}">
                                @csrf
                                <div class="input-group">
                                    <input list="search_terms" type="text" name="id" class="form-control"
                                        placeholder="Search by ID">
                                    <button class="btn btn-light bg" type="submit"> <i
                                            class="material-icons md-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <form class="col-lg-7 col-7 col-md-3 d-flex justify-content-end" action="{{ route('Admin.product-filter') }}" method="POST">
                            @csrf
                                <div class="col-lg-3 col-3 col-md-3 mx-1">
                                    <select class="form-select" name="cat" onchange="this.form.submit()">
                                        <option value="All" @selected($cat == 'All')>All category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected($cat == $category->id)>{{ $category->category_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-3 col-md-3">
                                    <select class="form-select" name="filter" onchange="this.form.submit()">
                                        <option value="Latest added" @selected($filter == 'Latest added')>Latest added</option>
                                        <option value="Published" @selected($filter == 'Published')>Published</option>
                                        <option value="Not Published" @selected($filter == 'Not Published')>Not Published</option>
                                    </select>
                                </div>                                
                        </form>
                    </div>
                </header>
                <div class="card-body">
                    <div class="row gx-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-5">
                        @foreach ($products as $product)
                            <div class="col">
                                <div class="card card-product-grid">
                                    <a href="javascript:void(0)" class="img-wrap"> <img
                                            src="{{ asset('uploads/' . $product->main_media) }}" alt="Product"> </a>
                                    <div class="form-check form-switch ms-4">
                                        <label class="form-check-label" for="toggle_{{ $product->id }}">Publish</label>
                                        <input class="form-check-input" type="checkbox" id="toggle_{{ $product->id }}"
                                            @if ($product->is_publish == 'Publish') checked @endif
                                            onclick="product_publish({{ $product->id }})">
                                    </div>
                                    <div class="info-wrap">
                                        <a class="title text-truncate">{{ $product->title }}</a>
                                        <div class="price mb-2">£{{ $product->price }}</div> <!-- price.// -->
                                        <a class="title text-truncate">SD{{ $product->id }}</a>
                                        <a href="{{ url('/admin/edit-product/' . $product->id) }}"
                                            class="btn btn-sm font-sm rounded btn-brand">
                                            <i class="material-icons md-edit"></i> Edit
                                        </a>
                                        <a href="{{ url('/admin/delete-product/' . $product->id) }}"
                                            class="btn btn-sm font-sm btn-light rounded">
                                            <i class="material-icons md-delete_forever"></i> Delete
                                        </a>
                                    </div>
                                </div> <!-- card-product  end// -->
                            </div>
                        @endforeach
                    </div> <!-- row.// -->
                </div> <!-- card-body end// -->
            </div> <!-- card end// -->
            <div class="pagination-area mt-30 mb-50">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        {{ $products->render() }}
                    </ul>
                </nav>
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

            function product_publish(id) {
                var toggle_check = $('#toggle_' + id).is(':checked');
                var value = '';
                if (toggle_check) {
                    value = 'Publish';
                } else {
                    value = 'Draft';
                }
                $.ajax({
                    url: "{{ url('/admin/product-publish') }}",
                    data: {
                        'id': id,
                        'value': value
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
