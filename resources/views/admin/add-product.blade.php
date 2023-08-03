@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Add Product | Baggage Deals</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel='stylesheet' href='https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'>
        <script src="https://cdn.tiny.cloud/1/6mwwhw1qnclmda4v5y7vmobvi2ieeyszxm98vjsqbacuc198/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <style type="text/css">
            .bootstrap-tagsinput .tag {
                margin-right: 2px;
                color: white !important;
                background-color: #088178;
                padding: .2em .6em .3em;
                font-size: 100%;
                vertical-align: baseline;
                border-radius: .25em;
            }
        </style>
    @endpush
    @section('section')
        @php
            $admin = session()->get('admin');
        @endphp
        <section class="content-main">
            <form action="{{ url('/admin/add-product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="content-header">
                            <h2 class="content-title">Add New Product</h2>
                            <div>
                                <input type="submit" class="btn btn-md rounded font-sm hover-up" value="Add Product" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Basic</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="name" class="form-label">Product title</label>
                                    <input type="text" placeholder="Type here" class="form-control"
                                        value="{{ old('name') }}" id="name" name="name" required>
                                    <small class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Brand</label>
                                    <select class="form-select" id="brand" name="brand">
                                        <option value="" readonly hidden> Select Brand </option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="content" class="form-label">SKU</label>
                                    <input type="text" placeholder="Type here" class="form-control"
                                        value="{{ old('sku') }}" id="sku" name="sku">
                                </div>
                                <div class="mb-4">
                                    <label for="content" class="form-label">Short description</label>
                                    <input type="text" placeholder="Type here" class="form-control"
                                        value="{{ old('content') }}" id="content" name="content">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Full description</label>
                                    <textarea placeholder="Type here" class="form-control" rows="4" id="description" name="description"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="quantity" class="form-label">Product quantity</label>
                                    <input type="number" placeholder="Type here" class="form-control"
                                        value="{{ old('quantity') }}" id="quantity" name="quantity" required>
                                    <small class="text-danger">
                                        @error('quantity')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>
                        </div> <!-- card end// -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Organization</h4>
                            </div>
                            <div class="card-body">
                                <div class="row gx-2">
                                    <div class="col-sm-6 mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="form-select" id="category" name="category"
                                            onchange="show_sub_category()" required>
                                            <option value="" readonly hidden> Select Category </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label class="form-label">Sub-category</label>
                                        <select class="form-select" id="sub_category" name="sub_category" required>
                                            <option value="" readonly hidden>Select Sub Category</option>
                                        </select>
                                    </div>
                                    <div class="formmb-4">
                                        <label for="tags" class="form-label">Tags</label>
                                        <input type="text" class="form-control" value="{{ old('tags') }}"
                                            id="tags" name="tags" data-role="tagsinput">
                                    </div>
                                </div> <!-- row.// -->
                            </div>
                        </div> <!-- card end// -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Product Extra Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <label class="form-label">Allow checkout when out of stock <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <label class="mb-2 form-check">
                                            <input class="form-check-input" name="allow_checkout" value="Yes"
                                                type="radio" required>
                                            <span class="form-check-label"> Yes </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 form-check">
                                            <input class="form-check-input" name="allow_checkout" value="No"
                                                type="radio">
                                            <span class="form-check-label"> No </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="quantity" class="form-label">Wanna feature <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <label class="mb-2 form-check">
                                            <input class="form-check-input" name="feature" value="Featured"
                                                type="radio" required>
                                            <span class="form-check-label"> Yes </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 form-check">
                                            <input class="form-check-input" name="feature" value="Not Featured"
                                                type="radio">
                                            <span class="form-check-label"> No </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="quantity" class="form-label">Wanna added to "New Added" <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <label class="mb-2 form-check">
                                            <input class="form-check-input" name="new_added" value="Yes"
                                                type="radio" required>
                                            <span class="form-check-label"> Yes </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 form-check">
                                            <input class="form-check-input" name="new_added" value="No"
                                                type="radio">
                                            <span class="form-check-label"> No </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- card end// -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Shipping</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="width" class="form-label">Width</label>
                                            <input type="text" placeholder="inch" class="form-control"
                                                value="{{ old('width') }}" id="width" name="width">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="height" class="form-label">Height</label>
                                            <input type="text" placeholder="inch" class="form-control"
                                                value="{{ old('height') }}" id="height" name="height">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="weight" class="form-label">Weight</label>
                                            <input type="text" placeholder="1.5" class="form-control"
                                                value="{{ old('weight') }}" id="weight" name="weight">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="weight_unit" class="form-label">Weight Unit</label>
                                            <input type="text" placeholder="kg" class="form-control"
                                                value="{{ old('weight_unit') }}" id="weight_unit" name="weight_unit">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="shipping_fee" class="form-label">Shipping fee</label>
                                        <input type="number" placeholder="£" class="form-control"
                                            value="{{ old('shipping_fee') }}" id="shipping_fee" name="shipping_fee">
                                    </div>
                                </div>
                            </div>
                        </div> <!-- card end// -->
                    </div>
                    <div class="col-lg-5">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Media</h4>
                            </div>
                            <div class="card-body">
                                <div class="input-upload">
                                    <label for="main_img" class="form-label">Main Image</label>
                                    <input class="form-control" type="file" id="main_media" name="main_media"
                                        required>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-upload">
                                    <label for="media" class="form-label text-start">Supporting Images</label>
                                    <input class="form-control" type="file" id="media" name="media[]" multiple>
                                </div>
                            </div>
                        </div> <!-- card end// -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Badges</h4>
                            </div>
                            <div class="card-body">
                                <label class="mb-2 form-check">
                                    <input class="form-check-input" name="badges[]" value="Hot" type="checkbox">
                                    <span class="form-check-label"> Hot </span>
                                </label>
                                <label class="mb-2 form-check">
                                    <input class="form-check-input" name="badges[]" value="New" type="checkbox">
                                    <span class="form-check-label"> New </span>
                                </label>
                                <label class="mb-2 form-check">
                                    <input class="form-check-input" name="badges[]" value="Best Sell" type="checkbox">
                                    <span class="form-check-label"> Best Sell </span>
                                </label>
                                <label class="mb-2 form-check">
                                    <input class="form-check-input" name="badges[]" value="Featured" type="checkbox">
                                    <span class="form-check-label"> Featured </span>
                                </label>
                                <label class="mb-2 form-check">
                                    <input class="form-check-input" name="badges[]" value="Sale" type="checkbox">
                                    <span class="form-check-label"> Sale </span>
                                </label>
                            </div>
                        </div> <!-- card end// -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Account Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row gx-2">
                                    <div class=" mb-3">
                                        <label class="form-label">Taxable</label>
                                        <select class="form-select" id="taxable" name="taxable">
                                            <option value="" readonly hidden> Select Option </option>
                                            <option value="Yes"> Yes </option>
                                            <option value="No"> No </option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="tax_rate" class="form-label">Tax rate</label>
                                        <input type="text" class="form-control" value="{{ old('tax_rate') }}"
                                            id="tax_rate" name="tax_rate">
                                    </div>
                                    <div class="mb-4">
                                        <label for="cost_price" class="form-label">Cost Price</label>
                                        <input type="text" class="form-control" value="{{ old('cost_price') }}"
                                            id="cost_price" name="cost_price">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-4">
                                                <label class="form-label">Regular price</label>
                                                <div class="row gx-2">
                                                    <input placeholder="£" type="text" class="form-control"
                                                        value="{{ old('price') }}" id="price" name="price"
                                                        required>
                                                    <small class="text-danger">
                                                        @error('price')
                                                            {{ $message }}
                                                        @enderror
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-4">
                                                <label class="form-label">Sale price</label>
                                                <input placeholder="£" type="text" class="form-control"
                                                    value="{{ old('sale_price') }}" id="sale_price" name="sale_price">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="form-label">Currency</label>
                                            <select class="form-select" readonly>
                                                <option> £ GBP </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="discount" class="form-label">Discount in %age </label>
                                        <input type="number" placeholder="%" class="form-control"
                                            value="{{ old('discount') }}" id="discount" name="discount">
                                    </div>
                                </div> <!-- row.// -->
                            </div>
                        </div> <!-- card end// -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Attributes</h4>
                                <p><small class="text-warning">For Adding Attribute: Please select attribute value.
                                        Attribute Value is required.</small></p>
                            </div>
                            <div class="card-body">
                                @foreach ($attributes as $attribute)
                                    <ul>
                                        <li>
                                            <label class="mb-2 form-check">
                                                <input class="form-check-input" name="attributes[]"
                                                    id="attribute_{{ $attribute->id }}" value="{{ $attribute->id }}"
                                                    type="checkbox"
                                                    onclick="show_attribute_values({{ $attribute->id }})">
                                                <span class="form-check-label">{{ $attribute->name }}</span>
                                            </label>
                                            @if (count($attribute->attributeValues) > 0)
                                                <ul style="margin-left: 5%" id="attribute_value_{{ $attribute->id }}"
                                                    hidden>
                                                    @foreach ($attribute->attributeValues as $attributeValue)
                                                        <label class="mb-2 form-check">
                                                            <input class="form-check-input"
                                                                name="attribute_values_{{ $attribute->id }}[]"
                                                                value="{{ $attributeValue->id }}" type="checkbox">
                                                            <span
                                                                class="form-check-label">{{ $attributeValue->value }}</span>
                                                        </label>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    </ul>
                                @endforeach
                            </div>
                        </div> <!-- card end// -->
                    </div>
                </div>
            </form>
        </section>
    @endsection
    @push('footer')
        <script src='https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'></script>
        <script>
            tinymce.init({
                selector: 'textarea',
                plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
                toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
                toolbar_mode: 'floating',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
            });
        </script>
        <script>
            $(function() {
                $('#tags').on('change', function(event) {

                    var $element = $(event.target);
                    var $container = $element.closest('.example');

                    if (!$element.data('tagsinput'))
                        return;

                    var val = $element.val();
                    if (val === null)
                        val = "null";
                    var items = $element.tagsinput('items');

                    $('code', $('pre.val', $container)).html(($.isArray(val) ? JSON.stringify(val) : "\"" + val
                        .replace('"', '\\"') + "\""));
                    $('code', $('pre.items', $container)).html(JSON.stringify($element.tagsinput('items')));


                }).trigger('change');
            });
        </script>
        <script>
            function show_sub_category() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/get-sub-categories') }}",
                    data: {
                        'id': $('#category option:selected').val()
                    },
                    type: 'POST',
                    beforeSend: function() {
                        $('#sub_category').empty();
                        $('#sub_category').append($('<option>', {
                            text: 'Loading...'
                        }));
                    },
                    success: function(data) {
                        if (data.success) {
                            data = data.data;
                            $('#sub_category').empty();
                            if (data.length !== 0) {
                                $('#sub_category').append($('<option>', {
                                    value: '',
                                    text: 'Select Sub Category',
                                }));
                                data.forEach(e => {
                                    $('#sub_category').append($('<option>', {
                                        value: e.id,
                                        text: e.sub_category_title
                                    }));
                                });
                            } else {
                                $('#sub_category').append($('<option>', {
                                    value: '',
                                    text: 'No Sub Category',
                                }));
                            }
                        } else {
                            iziToast.error({
                                position: 'topRight',
                                message: data.message,
                            });
                        }
                    }
                });
            }

            function show_attribute_values(id) {
                if ($('#attribute_' + id).is(":checked")) {
                    $("#attribute_value_" + id).removeAttr('hidden');
                } else {
                    $("#attribute_value_" + id).attr('hidden', 'true');
                }
            }
        </script>
    @endpush
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
