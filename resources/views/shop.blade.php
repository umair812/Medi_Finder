@extends('layouts.main')
@push('head')
    <title>Shop | Baggage Factory</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .c-text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            /* number of lines to show */
            -webkit-box-orient: vertical;
        }

        .c-text-2 {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* number of lines to show */
            -webkit-box-orient: vertical;
        }
    </style>
@endpush
@section('section')
    @php
        $content = \App\Models\CMS::where('page', '=', 'shop')->first();
    @endphp
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    @if (!empty($cat))
                        @if (!empty($sub_cat))
                            <a href="{{ url('/') }}" rel="nofollow">Home</a>
                            <span></span> <a href="{{ url('/shop') }}" rel="nofollow">Shop</a>
                            <span></span> <a href="{{ url('/shop/' . $cat) }}" rel="nofollow">{{ $cat }}</a>
                            <span></span> {{ $sub_cat }}
                        @else
                            <a href="{{ url('/') }}" rel="nofollow">Home</a>
                            <span></span> <a href="{{ url('/shop') }}" rel="nofollow">Shop</a>
                            <span></span>{{ $cat }}
                        @endif
                    @else
                        <a href="{{ url('/') }}" rel="nofollow">Home</a>
                        <span></span> Shop
                    @endif
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row flex-row-reverse">
                    <div class="col-lg-9">
                        <div class="shop-product-fillter">
                            <div class="totall-product">
                                <p> We found <strong class="text-brand">{{ count($products) }}</strong> items for you!</p>
                            </div>
                        </div>
                        <div class="row product-grid-3">
                            @foreach ($products as $product)
                                <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ url('/product-detail/' . $product->id) }}">
                                                    @php
                                                        $image = explode(',', $product->suppornting_media);
                                                    @endphp
                                                    <img class="default-img"
                                                        src="{{ asset('uploads/' . $product->main_media) }}"
                                                        alt="">
                                                    <img class="hover-img" src="{{ asset('uploads/' . $image[0]) }}"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn hover-up"
                                                    data-bs-toggle="modal" data-bs-target="#Modal{{ $product->id }}">
                                                    <i class="fi-rs-eye"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                    href="javascript:void(0)"
                                                    onclick="addToWishlist({{ $product->id }})"><i
                                                        class="fi-rs-heart"></i></a>
                                            </div>
                                            @php
                                                $badges = explode(',', $product->badges);
                                                $space = 0;
                                            @endphp
                                            @foreach ($badges as $badge)
                                                @if ($badge == 'Hot')
                                                    <div class="product-badges product-badges-position product-badges-mrg"
                                                        style="margin-top: {{ $space }}%;">
                                                        <span class="hot">Hot</span>
                                                    </div>
                                                @elseif ($badge == 'New')
                                                    <div class="product-badges product-badges-position product-badges-mrg"
                                                        style="margin-top: {{ $space }}%;">
                                                        <span class="new">New</span>
                                                    </div>
                                                @elseif ($badge == 'Best Sell')
                                                    <div class="product-badges product-badges-position product-badges-mrg"
                                                        style="margin-top: {{ $space }}%;">
                                                        <span class="best">Best Sell</span>
                                                    </div>
                                                @elseif ($badge == 'Featured')
                                                    <div class="product-badges product-badges-position product-badges-mrg"
                                                        style="margin-top: {{ $space }}%;">
                                                        <span class="hot">Featured</span>
                                                    </div>
                                                @elseif ($badge == 'Sale')
                                                    <div class="product-badges product-badges-position product-badges-mrg"
                                                        style="margin-top: {{ $space }}%;">
                                                        <span class="sale">Sale</span>
                                                    </div>
                                                @endif
                                                @php
                                                    $space = $space + 13;
                                                @endphp
                                            @endforeach
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="{{ url('/shop') }}">
                                                    @foreach ($categories as $category)
                                                        @if ($category->id == $product->cat_id)
                                                            {{ $category->category_title }}
                                                        @endif
                                                    @endforeach
                                                </a>
                                            </div>
                                            <h2 class="c-text" title="{{ $product->title }}">
                                                <a
                                                    href="{{ url('/product-detail/' . $product->id) }}">{{ $product->title }}</a>
                                            </h2>
                                            @php
                                                $sum_of_rating = \App\Models\Reviews::selectRaw('SUM(rating) as sum')
                                                    ->where('products_id', '=', $product->id)
                                                    ->where('status', '=', 'Approved')
                                                    ->first()->sum;
                                            @endphp
                                            <div class="rating-result" title="{{ $sum_of_rating / 100 }}%">
                                                <span>
                                                    <span>{{ $sum_of_rating / 100 }}%</span>
                                                </span>
                                            </div>
                                            <div class="product-price">
                                                @php
                                                    $price = 0;
                                                @endphp
                                                @if ($product->sale_price > 0)
                                                    <span> {{ currency_converter($product->sale_price) }}</span>
                                                    <span
                                                        class="old-price">{{ currency_converter($product->price) }}</span>
                                                    @php
                                                        $price = $product->sale_price;
                                                    @endphp
                                                @else
                                                    <span> {{ currency_converter($product->price) }}</span>
                                                    @php
                                                        $price = $product->price;
                                                    @endphp
                                                @endif
                                            </div>
                                            <div class="product-action-1 show">
                                                <a aria-label="Add To Cart" class="action-btn hover-up"
                                                    href="javascript:void(0)"
                                                    onclick="addToCart({{ $product->id }},{{ $price }},1)"><i
                                                        class="fi-rs-shopping-bag-add"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--pagination-->
                        <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                            <nav aria-label="Page navigation example">
                                {{ $products->render() }}
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-3 primary-sidebar sticky-sidebar">
                        <div class="widget-category mb-30">
                            <h5 class="section-title style-1 mb-30 wow fadeIn animated">Category</h5>
                            <ul class="categories">
                                @foreach ($categories as $category)
                                    <li><a
                                            href="{{ url('/shop/' . $category->category_slug) }}">{{ $category->category_title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Fillter By Price -->
                        <div class="sidebar-widget price_range range mb-30">
                            <div class="widget-header position-relative mb-20 pb-10">
                                <h5 class="widget-title mb-10">Fill by price</h5>
                                <div class="bt-1 border-color-1"></div>
                            </div>
                            <div class="price-filter">
                                <div class="price-filter-inner">
                                    <div id="slider-range"></div>
                                    <div class="price_slider_amount">
                                        <div class="label-input">
                                            <span>Range:</span><input type="text" id="amount" name="price"
                                                placeholder="Add Your Price" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="list-group">
                                <div class="list-group-item mb-10 mt-10">
                                    <label class="fw-900">Color</label>
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                            id="exampleCheckbox1" value="">
                                        <label class="form-check-label" for="exampleCheckbox1"><span>Red
                                                (56)</span></label>
                                        <br>
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                            id="exampleCheckbox2" value="">
                                        <label class="form-check-label" for="exampleCheckbox2"><span>Green
                                                (78)</span></label>
                                        <br>
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                            id="exampleCheckbox3" value="">
                                        <label class="form-check-label" for="exampleCheckbox3"><span>Blue
                                                (54)</span></label>
                                    </div>
                                    <label class="fw-900 mt-15">Item Condition</label>
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                            id="exampleCheckbox11" value="">
                                        <label class="form-check-label" for="exampleCheckbox11"><span>New
                                                (1506)</span></label>
                                        <br>
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                            id="exampleCheckbox21" value="">
                                        <label class="form-check-label" for="exampleCheckbox21"><span>Refurbished
                                                (27)</span></label>
                                        <br>
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                            id="exampleCheckbox31" value="">
                                        <label class="form-check-label" for="exampleCheckbox31"><span>Used
                                                (45)</span></label>
                                    </div>
                                </div>
                            </div> --}}
                            <a href="{{ url('/shop') }}" class="btn btn-sm btn-default"><i
                                    class="fi-rs-filter mr-5"></i>
                                Fillter</a>
                        </div>
                        <!-- Product sidebar Widget -->
                        <div class="sidebar-widget product-sidebar  mb-30 p-30 bg-grey border-radius-10">
                            <div class="widget-header position-relative mb-20 pb-10">
                                <h5 class="widget-title mb-10">New products</h5>
                                <div class="bt-1 border-color-1"></div>
                            </div>
                            @php
                                $pro = 1;
                            @endphp
                            @foreach ($products as $product)
                                @if ($pro <= 3)
                                    <div class="single-post clearfix">
                                        <div class="image">
                                            <a href="{{ url('/product-detail/' . $product->id) }}">
                                                <img src="{{ asset('uploads/' . $product->main_media) }}" alt="#">
                                            </a>
                                        </div>
                                        <div class="content pt-10">
                                            <h5>
                                                <a class="c-text-2" title="{{ $product->title }}"
                                                    href="{{ url('/product-detail/' . $product->id) }}">{{ $product->title }}</a>
                                            </h5>
                                            <p class="price mb-0 mt-5">
                                                @if ($product->sale_price > 0)
                                                    {{ currency_converter($product->sale_price) }}
                                                @else
                                                    {{ currency_converter($product->price) }}
                                                @endif
                                            </p>
                                            @php
                                                $sum_of_rating = \App\Models\Reviews::selectRaw('SUM(rating) as sum')
                                                    ->where('products_id', '=', $product->id)
                                                    ->where('status', '=', 'Approved')
                                                    ->first()->sum;
                                            @endphp
                                            <div class="product-rate">
                                                <div class="product-rating" style="width:{{ $sum_of_rating / 100 }}%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @php
                                    $pro++;
                                @endphp
                            @endforeach
                        </div>
                        @if ($content->ad_status == 'Show')
                            <div class="banner-img banner-1 wow fadeIn animated">
                                <img src="{{ asset('uploads/' . $content->ad) }}" alt="">
                                <div class="banner-text" style="margin-top:-10%">
                                    <span>{{ format_cat($content->category_slug) }}</span>
                                    <h4>{{ $content->content }}</h4>
                                    <a
                                        href="@if (empty($content->category_slug) && empty($content->sub_category_slug)) {{ url('/shop') }}
                                        @elseif (!empty($content->category_slug) && empty($content->sub_category_slug))
                                            {{ url('/shop/' . $content->category_slug) }}
                                        @elseif (!empty($content->category_slug) && !empty($content->sub_category_slug))
                                            {{ url('/shop/' . $content->category_slug . '/' . $content->sub_category_slug) }} @endif">Shop
                                        Now <i class="fi-rs-arrow-right"></i></a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <section>
            @foreach ($products as $product)
                @php
                    $images = explode(',', $product->suppornting_media);
                    if (empty($images[count($images) - 1])) {
                        unset($images[count($images) - 1]);
                    }
                @endphp
                <div class="modal fade custom-modal" id="Modal{{ $product->id }}" tabindex="-1"
                    aria-labelledby="quickViewModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="detail-gallery">
                                            <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                            <!-- MAIN SLIDES -->
                                            <div class="product-image-slider">
                                                <figure class="border-radius-10">
                                                    <img src="{{ asset('uploads/' . $product->main_media) }}"
                                                        alt="product image">
                                                </figure>
                                                @foreach ($images as $image)
                                                    <figure class="border-radius-10">
                                                        <img src="{{ asset('uploads/' . $image) }}" alt="product image">
                                                    </figure>
                                                @endforeach
                                            </div>
                                            <!-- THUMBNAILS -->
                                            <div class="slider-nav-thumbnails pl-15 pr-15">
                                                <div><img src="{{ asset('uploads/' . $product->main_media) }}"
                                                        alt="product image"></div>
                                                @foreach ($images as $image)
                                                    <div><img src="{{ asset('uploads/' . $image) }}" alt="product image">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- End Gallery -->
                                        <div class="social-icons single-share">
                                            <ul class="text-grey-5 d-inline-block">
                                                <li><strong class="mr-10">Share this:</strong></li>
                                                <li class="social-facebook"><a href="#"><img
                                                            src="assets/imgs/theme/icons/icon-facebook.svg"
                                                            alt=""></a></li>
                                                <li class="social-twitter"> <a href="#"><img
                                                            src="assets/imgs/theme/icons/icon-twitter.svg"
                                                            alt=""></a></li>
                                                <li class="social-instagram"><a href="#"><img
                                                            src="assets/imgs/theme/icons/icon-instagram.svg"
                                                            alt=""></a></li>
                                                <li class="social-linkedin"><a href="#"><img
                                                            src="assets/imgs/theme/icons/icon-pinterest.svg"
                                                            alt=""></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="detail-info">
                                            <h3 class="title-detail mt-30">{{ $product->title }}</h3>
                                            <div class="product-detail-rating">
                                                @if (!empty($product->brand_id))
                                                    <div class="pro-details-brand">
                                                        <span> Brands: <a
                                                                href="shop-grid-right.html">{{ $product->brand->name }}</a></span>
                                                    </div>
                                                @endif
                                                @php
                                                    $count_of_rating = \App\Models\Reviews::selectRaw('Count(products_id) as count')
                                                        ->where('products_id', '=', $product->id)
                                                        ->where('status', '=', 'Approved')
                                                        ->first()->count;
                                                    $avg_of_rating = \App\Models\Reviews::selectRaw('SUM(rating)/COUNT(products_id) as avg')
                                                        ->where('products_id', '=', $product->id)
                                                        ->where('status', '=', 'Approved')
                                                        ->first()->avg;
                                                @endphp
                                                <div class="product-rate-cover text-end">
                                                    <div class="d-inline-block">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            @if ($i < $avg_of_rating)
                                                                <span class="fa fa-star text-warning"></span>
                                                            @else
                                                                <span class="fa fa-star"></span>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span class="font-small ml-5 text-muted"> ({{ $count_of_rating }}
                                                        reviews)</span>
                                                </div>
                                            </div>
                                            <div class="clearfix product-price-cover">
                                                <div class="product-price primary-color float-left">
                                                    @if (!empty($product->sale_price))
                                                        @php
                                                            $price = $product->sale_price;
                                                        @endphp
                                                        <ins><span class="text-brand"
                                                                id="p_price">{{ currency_converter($product->sale_price) }}</span></ins>
                                                        <ins><span
                                                                class="old-price font-md ml-15">${{ $product->price }}</span></ins>
                                                    @else
                                                        @php
                                                            $price = $product->price;
                                                        @endphp
                                                        <ins><span class="text-brand"
                                                                id="p_price">{{ currency_converter($product->price) }}</span></ins>
                                                    @endif
                                                    @if (!empty($product->sale_in_percentage))
                                                        <span
                                                            class="save-price  font-md color3 ml-15">{{ $product->sale_in_percentage }}%
                                                            Off</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if (!empty($product->content))
                                                <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                                <div class="short-desc mb-30">
                                                    <p class="font-sm">{{ $product->content }}</p>
                                                </div>
                                                <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                            @endif
                                            <ul class="product-meta font-xs color-grey mt-50">
                                                <li class="mb-5">SKU: <a href="#">{{ $product->sku }}</a></li>
                                                <li class="mb-5">Tags: <a href="#" rel="tag">Cloth</a>, <a
                                                        href="#" rel="tag">Women</a>, <a href="#"
                                                        rel="tag">Dress</a> </li>
                                                <li>Availability:<span
                                                        class="in-stock text-success ml-5">{{ $product->quantity }} Items
                                                        In Stock</span></li>
                                            </ul>
                                        </div>
                                        <!-- Detail Info -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    </main>
@endsection
@push('footer')
    <script>
        function addToCart(id, price, qty) {
            price = price * qty;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "post",
                url: "{{ url('/AddToCart') }}",
                data: {
                    "product_id": id,
                    "product_price": price,
                    "product_qty": qty
                },
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            position: 'topRight',
                            message: response.message
                        });
                        $('#cartheading').html(response.qty);
                    } else {
                        iziToast.warning({
                            position: 'topRight',
                            message: response.message
                        });
                    }
                }
            });
        }

        function addToWishlist(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "post",
                url: "{{ url('/AddToWishlist') }}",
                data: {
                    "product_id": id,
                },
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            position: 'topRight',
                            message: response.message
                        });
                        $('#wishlistheading').html(response.qty)
                    } else {
                        iziToast.warning({
                            position: 'topRight',
                            message: response.message
                        });
                    }
                }
            });
        }
    </script>
@endpush
