@if (session()->has('admin'))
    @extends('admin.layout.main')
    @push('head')
        <title>Products | Baggage Factory</title>
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
            $cat_id = 0;
            $sub_cat_id = 0;
        @endphp
        <section class="content-main">
            <div class="row">
                <div class="col-12">
                    <div class="content-header">
                        <h2 class="content-title">Edit Product</h2>
                    </div>
                </div>
                @foreach ($product as $item)
                    @push('head')
                        <title>{{ $item->title }} | Baggage Factory</title>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <link rel='stylesheet'
                            href='https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'>
                        <script src="https://cdn.tiny.cloud/1/8oeks8k7g5tttl2iblee9nuom6rbatrupkj5fs1c23k9gn11/tinymce/6/tinymce.min.js"
                            referrerpolicy="origin"></script>
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
                    <div class="col-lg-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Basic</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="name" class="form-label">Product title</label>
                                    <input type="text" placeholder="Type here" class="form-control"
                                        value="{{ $item->title }}" id="name" name="name" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Brand</label>
                                    <select class="form-select" id="brand" name="brand">
                                        <option value="0" readonly hidden> Select Brand </option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" @selected($item->brand_id == $brand->id)>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="content" class="form-label">SKU</label>
                                    <input type="text" placeholder="Type here" class="form-control"
                                        value="{{ $item->sku }}" id="sku" name="sku">
                                </div>
                                <div class="mb-4">
                                    <label for="content" class="form-label">Short description</label>
                                    <input type="text" placeholder="Type here" class="form-control"
                                        value="{{ $item->content }}" id="content" name="content">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Full description</label>
                                    <textarea placeholder="Type here" class="form-control" rows="4" id="description" name="description">{!! $item->description !!}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label class="form-label">Regular price</label>
                                            <div class="row gx-2">
                                                <input placeholder="£" type="text" class="form-control"
                                                    value="{{ $item->price }}" id="price" name="price" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label class="form-label">Promotional price</label>
                                            <input placeholder="£" type="text" class="form-control"
                                                value="{{ $item->sale_price }}" id="sale_price" name="sale_price">
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
                                        value="{{ $item->sale_in_percentage }}" id="discount" name="discount">
                                </div>
                                <div class="mb-4">
                                    <label for="quantity" class="form-label">Product quantity</label>
                                    <input type="number" placeholder="Type here" class="form-control"
                                        value="{{ $item->quantity }}" id="quantity" name="quantity" required>
                                </div>
                                <div class="mb-4 d-flex justify-content-center">
                                    <input type="button" class="btn btn-md rounded font-sm hover-up"
                                        value="Update basic detail" onclick="update_basic_detail({{ $item->id }})" />
                                </div>
                            </div>
                        </div> <!-- card end// -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Product Extra Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <label class="form-label">Stock availability <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <label class="mb-2 form-check">
                                            <input class="form-check-input" name="stock" value="In Stock"
                                                type="radio" @if ($item->stock_availability == 'In Stock') checked @endif required>
                                            <span class="form-check-label"> In Stock </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 form-check">
                                            <input class="form-check-input" name="stock" value="Out Of Stock"
                                                type="radio" @if ($item->stock_availability == 'Out Of Stock') checked @endif>
                                            <span class="form-check-label"> Out Of Stock </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="form-label">Allow checkout when out of stock <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <label class="mb-2 form-check">
                                            <input class="form-check-input" name="allow_checkout" value="Yes"
                                                type="radio" @if ($item->allow_checkout == 'Yes') checked @endif required>
                                            <span class="form-check-label"> Yes </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 form-check">
                                            <input class="form-check-input" name="allow_checkout" value="No"
                                                type="radio" @if ($item->allow_checkout == 'No') checked @endif>
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
                                                type="radio" @if ($item->is_feature == 'Featured') checked @endif required>
                                            <span class="form-check-label"> Yes </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 form-check">
                                            <input class="form-check-input" name="feature" value="Not Featured"
                                                type="radio" @if ($item->is_feature == 'Not Featured') checked @endif>
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
                                                type="radio" @if ($item->new_added == 'Yes') checked @endif required>
                                            <span class="form-check-label"> Yes </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="mb-2 form-check">
                                            <input class="form-check-input" name="new_added" value="No"
                                                type="radio" @if ($item->new_added == 'No') checked @endif>
                                            <span class="form-check-label"> No </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-4 d-flex justify-content-center">
                                    <input type="button" class="btn btn-md rounded font-sm hover-up"
                                        value="Update extra detail" onclick="update_extra_detail({{ $item->id }})" />
                                </div>
                            </div>
                        </div> <!-- card end// -->
                        @foreach ($shipping_detail as $detail)
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
                                                    value="{{ $detail->width }}" id="width" name="width">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-4">
                                                <label for="height" class="form-label">Height</label>
                                                <input type="text" placeholder="inch" class="form-control"
                                                    value="{{ $detail->height }}" id="height" name="height">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-4">
                                                <label for="weight" class="form-label">Weight</label>
                                                <input type="text" placeholder="1.5" class="form-control"
                                                    value="{{ $detail->weight }}" id="weight" name="weight">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-4">
                                                <label for="weight_unit" class="form-label">Weight Unit</label>
                                                <input type="text" placeholder="kg" class="form-control"
                                                    value="{{ $detail->weight_unit }}" id="weight_unit"
                                                    name="weight_unit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="shipping_fee" class="form-label">Shipping fee</label>
                                        <input type="number" placeholder="£" class="form-control"
                                            value="{{ $detail->fee }}" id="shipping_fee" name="shipping_fee">
                                    </div>
                                    <div class="mb-4 d-flex justify-content-center">
                                        <input type="button" class="btn btn-md rounded font-sm hover-up"
                                            value="Update shipping detail"
                                            onclick="update_shipping_detail({{ $item->id }})" />
                                    </div>
                                </div>
                            </div> <!-- card end// -->
                        @endforeach
                    </div>
                    <div class="col-lg-5">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Media</h4>
                            </div>
                            <div class="card-body">
                                <div class="input-upload">
                                    <div id="main_img_div">
                                        <img id="main_img" src="{{ asset('uploads/' . $item->main_media) }}"
                                            alt="">
                                    </div>
                                    <form name="data-form" id="main_img_form" enctype="multipart/form-data">
                                        <input type="hidden" name="main_image_id" value="{{ $item->id }}" />
                                        <input class="form-control" type="file" id="main_media" name="main_media"
                                            required>
                                        <button type="submit"
                                            class="btn btn-md rounded font-sm hover-up mt-1">Upload</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-upload">
                                    @php
                                        $images = explode(',', $item->suppornting_media);
                                        array_pop($images);
                                    @endphp
                                    <div id="supporting_image">
                                        @foreach ($images as $image)
                                            <img class="shadow rounded" src="{{ asset('uploads/' . $image) }}"
                                                alt="">
                                        @endforeach
                                    </div>
                                    <form name="data-form" id="supporting_img_form" enctype="multipart/form-data">
                                        <input type="hidden" name="supporting_image_id" value="{{ $item->id }}" />
                                        <input class="form-control" type="file" id="media" name="media[]"
                                            multiple>
                                        <button type="submit"
                                            class="btn btn-md rounded font-sm hover-up mt-1">Upload</button>
                                    </form>
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
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if ($category->id == $item->cat_id) selected @endif>
                                                    {{ $category->category_title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label class="form-label">Sub-category</label>
                                        <select class="form-select" id="sub_category" name="sub_category" required>
                                            <option>Select Sub Category</option>
                                        </select>
                                    </div>
                                    <div class="form mb-4">
                                        <label for="tags" class="form-label">Tags</label>
                                        <input type="text" class="form-control" value="{{ $item->tags }}"
                                            id="tags" name="tags" data-role="tagsinput">
                                    </div>
                                    <div class="mb-4 d-flex justify-content-center">
                                        <input type="button" class="btn btn-md rounded font-sm hover-up" value="Update"
                                            onclick="update_tags_detail({{ $item->id }})" />
                                    </div>
                                </div> <!-- row.// -->
                            </div>
                        </div> <!-- card end// -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Badges</h4>
                            </div>
                            @php
                                $cat_id = $item->cat_id;
                                $sub_cat_id = $item->sub_cat_id;
                                $badges = explode(',', $item->badges);
                            @endphp
                            <div class="card-body">
                                <label class="mb-2 form-check">
                                    <input class="form-check-input" name="badges[]" value="Hot" type="checkbox"
                                        @if (in_array('Hot', $badges)) checked @endif>
                                    <span class="form-check-label"> Hot </span>
                                </label>
                                <label class="mb-2 form-check">
                                    <input class="form-check-input" name="badges[]" value="New" type="checkbox"
                                        @if (in_array('New', $badges)) checked @endif>
                                    <span class="form-check-label"> New </span>
                                </label>
                                <label class="mb-2 form-check">
                                    <input class="form-check-input" name="badges[]" value="Best Sell" type="checkbox"
                                        @if (in_array('Best Sell', $badges)) checked @endif>
                                    <span class="form-check-label"> Best Sell </span>
                                </label>
                                <label class="mb-2 form-check">
                                    <input class="form-check-input" name="badges[]" value="Featured" type="checkbox"
                                        @if (in_array('Featured', $badges)) checked @endif>
                                    <span class="form-check-label"> Featured </span>
                                </label>
                                <label class="mb-2 form-check">
                                    <input class="form-check-input" name="badges[]" value="Sale" type="checkbox"
                                        @if (in_array('Sale', $badges)) checked @endif>
                                    <span class="form-check-label"> Sale </span>
                                </label>
                                <div class="mb-4 d-flex justify-content-center">
                                    <input type="button" class="btn btn-md rounded font-sm hover-up"
                                        value="Update Badges" onclick="update_badges_detail({{ $item->id }})" />
                                </div>
                            </div>
                        </div> <!-- card end// -->
                        @foreach ($account_detail as $account)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4>Account Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row gx-2">
                                        <div class=" mb-3">
                                            <label class="form-label">Taxable</label>
                                            <select class="form-select" id="taxable" name="taxable">
                                                <option value="Yes" @if ($account->taxable == 'Yes') selected @endif>
                                                    Yes </option>
                                                <option value="No" @if ($account->taxable == 'No') selected @endif>
                                                    No </option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="tax_rate" class="form-label">Tax rate</label>
                                            <input type="text" class="form-control" value="{{ $account->tax_rate }}"
                                                id="tax_rate" name="tax_rate">
                                        </div>
                                        <div class="mb-4">
                                            <label for="cost_price" class="form-label">Cost Price</label>
                                            <input type="text" class="form-control"
                                                value="{{ $account->cost_price }}" id="cost_price" name="cost_price">
                                        </div>
                                        <div class="mb-4 d-flex justify-content-center">
                                            <input type="button" class="btn btn-md rounded font-sm hover-up"
                                                value="Update account detail"
                                                onclick="update_account_detail({{ $item->id }})" />
                                        </div>
                                    </div> <!-- row.// -->
                                </div>
                            </div> <!-- card end// -->
                        @endforeach
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Attributes</h4>
                                <p><small class="text-warning">For Adding New Attribute: Please select attribute value.
                                        Attribute Value is required.</small></p>
                            </div>
                            <div class="card-body">
                                <form name="data-form" id="attribute_form" enctype="multipart/form-data">
                                    @foreach ($attributes as $attribute)
                                        <ul>
                                            <li>
                                                <label class="mb-2 form-check">
                                                    <input class="form-check-input" name="attributes[]"
                                                        id="attribute_{{ $attribute->id }}" value="{{ $attribute->id }}"
                                                        type="checkbox" @if (in_array($attribute->id, $attribute_array)) checked @endif
                                                        onclick="remove_attribute({{ $item->id }},{{ $attribute->id }})">
                                                    <span class="form-check-label">{{ $attribute->name }}</span>
                                                </label>
                                                @if (count($attribute->attributeValues) > 0)
                                                    <ul style="margin-left: 5%"
                                                        id="attribute_value_{{ $attribute->id }}">
                                                        @foreach ($attribute->attributeValues as $attributeValue)
                                                            <label class="mb-2 form-check">
                                                                <input class="form-check-input"
                                                                    id="attribute_values_{{ $attribute->id . '_' . $attributeValue->id }}"
                                                                    name="attribute_values_{{ $attribute->id }}[]"
                                                                    value="{{ $attributeValue->id }}" type="checkbox"
                                                                    @if (in_array($attributeValue->id, $attribute_value_array)) checked @endif
                                                                    onclick="remove_attribute_value({{ $item->id }},{{ $attribute->id }},{{ $attributeValue->id }})">
                                                                <span
                                                                    class="form-check-label">{{ $attributeValue->value }}</span>
                                                                @if (in_array($attributeValue->id, $attribute_value_array))
                                                                    <input class="form-input"
                                                                        value="{{ $attribute_price[$attributeValue->id] }}"
                                                                        id="attribute_values_price_{{ $attributeValue->value }}"
                                                                        type="text" />
                                                                    <input type="button"
                                                                        class="btn btn-md rounded font-sm hover-up"
                                                                        value="Add"
                                                                        onclick="update_attribute_value_price({{ $item->id }},{{ $attribute->id }},{{ $attributeValue->id }},'{{ $attributeValue->value }}')" />
                                                                @endif
                                                            </label>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        </ul>
                                    @endforeach
                                    <input type="hidden" value="{{ $item->id }}" name="att_pro_id" />
                                    <div class="mb-4 d-flex justify-content-center">
                                        <input type="submit" class="btn btn-md rounded font-sm hover-up"
                                            value="Update attribute" />
                                    </div>
                                </form>
                            </div>
                        </div> <!-- card end// -->
                    </div>
                @endforeach
            </div>
        </section>
    @endsection
    @push('footer')
        <script src='https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'></script>
        <script>
            tinymce.init({
                selector: '#description',
                plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
                toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
                toolbar_mode: 'floating',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
                codesample_languages: [{
                    text: 'HTML/XML',
                    value: 'markup'
                }, ]
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {
                $.ajax({
                    url: "{{ url('/admin/get-sub-categories') }}",
                    data: {
                        'id': {{ $cat_id }}
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success) {
                            data = data.data;
                            $('#sub_category').empty();
                            if (data.length !== 0) {
                                $('#sub_category').append($('<option>', {
                                    text: 'Select Sub Category',
                                    selected: true
                                }));
                                data.forEach(e => {
                                    if (e.id == {{ $sub_cat_id }}) {
                                        $('#sub_category').append($('<option>', {
                                            value: e.id,
                                            text: e.sub_category_title,
                                            selected: true
                                        }));
                                    } else {
                                        $('#sub_category').append($('<option>', {
                                            value: e.id,
                                            text: e.sub_category_title
                                        }));
                                    }
                                });
                            } else {
                                $('#sub_category').append($('<option>', {
                                    text: 'No Sub Category',
                                    selected: true
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
            });

            function show_sub_category() {
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

            function update_basic_detail(id) {
                var ed = tinyMCE.get('description');
                $.ajax({
                    url: "{{ url('/admin/update-basic') }}",
                    data: {
                        'id': id,
                        'name': $('#name').val(),
                        'sku': $('#sku').val(),
                        'brand': $('#brand option:selected').val(),
                        'content': $('#content').val(),
                        'description': ed.getContent(),
                        'price': $('#price').val(),
                        'sale_price': $('#sale_price').val(),
                        'discount': $('#discount').val(),
                        'quantity': $('#quantity').val()
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

            function update_extra_detail(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/update-extra') }}",
                    data: {
                        'id': id,
                        'stock': $('input[name="stock"]:checked').val(),
                        'allow_checkout': $('input[name="allow_checkout"]:checked').val(),
                        'feature': $('input[name="feature"]:checked').val(),
                        'new_added': $('input[name="new_added"]:checked').val()
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

            function update_shipping_detail(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/update-shipping') }}",
                    data: {
                        'id': id,
                        'width': $('#width').val(),
                        'height': $('#height').val(),
                        'weight': $('#weight').val(),
                        'weight_unit': $('#weight_unit').val(),
                        'shipping_fee': $('#shipping_fee').val()
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

            function update_tags_detail(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/admin/update-tags') }}",
                    data: {
                        'id': id,
                        'cat_id': $('#category option:selected').val(),
                        'sub_cat_id': $('#sub_category option:selected').val(),
                        'tags': $('#tags').val()
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

            function update_badges_detail(id) {
                var badges = "";
                $('[name="badges[]"]:checked').each(function() {
                    badges = badges + $(this).val() + ",";
                });
                $.ajax({
                    url: "{{ url('/admin/update-badges') }}",
                    data: {
                        'id': id,
                        'badges': badges
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

            function update_main_img(id) {
                var badges = "";
                $('[name="badges[]"]:checked').each(function() {
                    badges = badges + $(this).val() + ",";
                });
                $.ajax({
                    url: "{{ url('/admin/update-badges') }}",
                    data: {
                        'id': id,
                        'badges': badges
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

            function update_account_detail(id) {
                $.ajax({
                    url: "{{ url('/admin/update-account') }}",
                    data: {
                        'id': id,
                        'taxable': $('#taxable option:selected').val(),
                        'cost_price': $('#cost_price').val(),
                        'tax_rate': $('#tax_rate').val()
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

            $('#main_img_form').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: "{{ url('/admin/update-main-image') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        if (data.success) {
                            iziToast.success({
                                position: 'topRight',
                                message: data.message,
                            });
                            $('#main_img_div').html('<img id="main_img" src="' + data.img + '" alt="">');
                            this.reset();
                        } else {
                            iziToast.error({
                                position: 'topRight',
                                message: data.message,
                            });
                        }
                    },
                    error: function(data) {
                        iziToast.error({
                            position: 'topRight',
                            message: data.message,
                        });
                    }
                });
            });

            $('#supporting_img_form').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: "{{ url('/admin/update-supporting-image') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        if (data.success) {
                            iziToast.success({
                                position: 'topRight',
                                message: data.message,
                            });
                            var imgs = data.img;
                            var html = '';
                            $.each(imgs, function(index, value) {
                                html += '<img class="shadow rounded" src="' + value + '" alt="">';
                            });
                            $('#supporting_image').html(html);
                            this.reset();
                        } else {
                            iziToast.error({
                                position: 'topRight',
                                message: data.message,
                            });
                        }
                    },
                    error: function(data) {
                        iziToast.error({
                            position: 'topRight',
                            message: data.message,
                        });
                    }
                });
            });

            function update_attribute_value_price(p_id, a_id, a_v_id, value) {
                $.ajax({
                    url: "{{ url('/admin/update-attribute-value-price') }}",
                    data: {
                        'pro_id': p_id,
                        'att_id': a_id,
                        'att_val_id': a_v_id,
                        'price': $('#attribute_values_price_' + value).val()
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

            $('#attribute_form').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: "{{ url('/admin/update-attribute') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (data) => {
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
                    },
                    error: function(data) {
                        iziToast.error({
                            position: 'topRight',
                            message: data.message,
                        });
                    }
                });
            });

            function remove_attribute_value(p_id, a_id, a_v_id) {
                if ($('#attribute_values_' + a_id + '_' + a_v_id).is(":checked")) {

                } else {
                    $.ajax({
                        url: "{{ url('/admin/remove-attribute-value') }}",
                        data: {
                            'pro_id': p_id,
                            'att_id': a_id,
                            'att_val_id': a_v_id
                        },
                        type: 'POST',
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
            }

            function remove_attribute(p_id, a_id) {
                if ($('#attribute_' + a_id).is(":checked")) {

                } else {
                    $.ajax({
                        url: "{{ url('/admin/remove-attribute') }}",
                        data: {
                            'pro_id': p_id,
                            'att_id': a_id
                        },
                        type: 'POST',
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
            }
        </script>
    @endpush
@else
    <script>
        window.location.href = "{{ url('/admin/login') }}";
    </script>
@endif
