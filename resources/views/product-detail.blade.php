@extends('layouts.main')
@section('section')
    @php
        $product = $product->toArray();
        $categories2 = $categories->toArray();
        $sub_categories2 = $sub_categories_for_bread->toArray();
        $price = 0;
        $images = explode(',', $product[0]['suppornting_media']);
        if (empty($images[count($images) - 1])) {
            unset($images[count($images) - 1]);
        }
        $sum_of_rating = \App\Models\Reviews::selectRaw('SUM(rating) as sum')
            ->where('products_id', '=', $product[0]['id'])
            ->where('status', '=', 'Approved')
            ->first()->sum;
        $avg_of_rating = \App\Models\Reviews::selectRaw('SUM(rating)/COUNT(products_id) as avg')
            ->where('products_id', '=', $product[0]['id'])
            ->where('status', '=', 'Approved')
            ->first()->avg;
        $star_rating = \App\Models\Reviews::select(DB::raw('COUNT(rating) as rating'), 'rating as star')
            ->where('products_id', '=', $product[0]['id'])
            ->where('status', '=', 'Approved')
            ->groupBy('rating')
            ->orderBy('rating')
            ->get();
    @endphp
    @push('head')
        <title>{{ $product[0]['title'] }} | Baggage Factory</title>
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

            .star-rating {
                line-height: 32px;
                font-size: 1.25em;
            }
        </style>
    @endpush
    @php
        $content = \App\Models\CMS::where('page', '=', 'product_detail')->first();
    @endphp
    <main class="main">
        @foreach ($categories2 as $category)
            @if ($category['id'] == $product[0]['cat_id'])
                @foreach ($sub_categories2 as $sub_category)
                    @if ($sub_category['id'] == $product[0]['sub_cat_id'])
                        <div class="page-header breadcrumb-wrap">
                            <div class="container">
                                <div class="breadcrumb">
                                    <a href="{{ url('/shop/' . $category['category_slug']) }}"
                                        rel="nofollow">{{ $category['category_title'] }}</a>
                                    <span></span> <a
                                        href="{{ url('/shop/' . $category['category_slug'] . '/' . $sub_category['sub_category_slug']) }}"
                                        rel="nofollow">{{ $sub_category['sub_category_title'] }}</a>
                                    <span></span> {{ $product[0]['title'] }}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        @endforeach
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-detail accordion-detail">
                            <div class="row mb-50">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="detail-gallery">
                                        <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                        <!-- MAIN SLIDES -->
                                        <div class="product-image-slider">
                                            <figure class="border-radius-10">
                                                <img src="{{ asset('uploads/' . $product[0]['main_media']) }}"
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
                                            <div><img src="{{ asset('uploads/' . $product[0]['main_media']) }}"
                                                    alt="product image"></div>
                                            @foreach ($images as $image)
                                                <div><img src="{{ asset('uploads/' . $image) }}" alt="product image"></div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- End Gallery -->
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="detail-info">
                                        <h2 class="title-detail">{{ $product[0]['title'] }}</h2>
                                        <div class="product-detail-rating">
                                            <div class="pro-details-brand">
                                                <span> Category: <a href="shop-grid-right.html">
                                                        @foreach ($categories2 as $category)
                                                            @if ($category['id'] == $product[0]['cat_id'])
                                                                {{ $category['category_title'] }}
                                                            @endif
                                                        @endforeach
                                                    </a></span>
                                            </div>
                                            <div class="product-rate-cover text-end">
                                                @if (count($reviews) > 0)
                                                    <div class="d-inline-block">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            @if ($i < $avg_of_rating)
                                                                <span class="fa fa-star text-warning"></span>
                                                            @else
                                                                <span class="fa fa-star"></span>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span class="font-small ml-5 text-muted"> ({{ count($reviews) }}
                                                        reviews)</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="clearfix product-price-cover">
                                            <div class="product-price primary-color float-left">
                                                @if (!empty($product[0]['sale_price']))
                                                    @php
                                                        $price = $product[0]['sale_price'];
                                                    @endphp
                                                    <ins><span class="text-brand"
                                                            id="p_price">{{ currency_converter($product[0]['sale_price']) }}</span></ins>
                                                    <ins><span
                                                            class="old-price font-md ml-15">{{ currency_converter($product[0]['price']) }}</span></ins>
                                                    <input id="pro_price_{{ $product[0]['id'] }}" type="hidden"
                                                        value="{{ $product[0]['sale_price'] }}" />
                                                @else
                                                    @php
                                                        $price = $product[0]['price'];
                                                    @endphp
                                                    <ins><span class="text-brand"
                                                            id="p_price">{{ currency_converter($product[0]['price']) }}</span></ins>
                                                    <input id="pro_price_{{ $product[0]['id'] }}" type="hidden"
                                                        value="{{ $product[0]['price'] }}" />
                                                @endif
                                                @if (!empty($product[0]['sale_in_percentage']))
                                                    <span
                                                        class="save-price  font-md color3 ml-15">{{ $product[0]['sale_in_percentage'] }}%
                                                        Off</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                        <div class="short-desc mb-30">
                                            <p>{{ $product[0]['content'] }}</p>
                                        </div>
                                        <div class="product_sort_info font-xs mb-30">
                                            <ul>
                                                <li class="mb-10"><i class="fi-rs-refresh mr-5"></i> 30 Day Return Policy
                                                </li>
                                                <li><i class="fi-rs-credit-card mr-5"></i> Cash on Delivery available</li>
                                            </ul>
                                        </div>
                                        @foreach ($attributes as $attribute)
                                            @if (in_array($attribute->id, $attribute_array))
                                                <div class="attr-detail attr-color mb-15">
                                                    <strong class="mr-10">{{ $attribute->name }}</strong>
                                                    <ul class="list-filter size-filter font-small">
                                                        @foreach ($attribute->attributeValues as $attributeValue)
                                                            @if (in_array($attributeValue->id, $attribute_value_array))
                                                                <li><label class="form-check">
                                                                        <input class="form-check-input"
                                                                            id="attribute_{{ $attributeValue->id }}"
                                                                            name="{{ $attribute->name }}"
                                                                            value="{{ $attributeValue->value }}"
                                                                            type="{{ $attribute->widget }}"
                                                                            onclick="change_price({{ $price }},{{ $attribute_price[$attributeValue->id] }})">
                                                                        <span class="form-check-label">
                                                                            {{ $attributeValue->value }} </span>
                                                                    </label></li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                        <div class="detail-extralink">
                                            <div class="detail-qty border radius" style="padding: 0px">
                                                <input type="number" class="border-0" id="qty_val_{{ $product[0]['id'] }}"
                                                    min="1" max="{{ $product[0]['quantity'] }}" value="1" />
                                            </div>
                                            <div class="product-extra-link2">
                                                <button type="submit" class="button button-add-to-cart"
                                                    onclick="addToCart({{ $product[0]['id'] }})">Add to
                                                    cart</button>
                                                <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                    href="javascript:void(0)"
                                                    onclick="addToWishlist({{ $product[0]['id'] }})"><i
                                                        class="fi-rs-heart"></i></a>
                                            </div>
                                        </div>
                                        <ul class="product-meta font-xs color-grey mt-50">
                                            {{-- <li class="mb-5">SKU: <a href="#">{{ $product[0]['sku'] }}</a></li> --}}
                                            @php
                                                $tags = explode(',', $product[0]['tags']);
                                                if (empty($tags[count($tags) - 1])) {
                                                    unset($tags[count($tags) - 1]);
                                                }
                                                $last_tag = count($tags) - 1;
                                                $i_t = 0;
                                            @endphp
                                            <li class="mb-5">Tags:
                                                @foreach ($tags as $tag)
                                                    @if ($tag[$i_t] != $tag[$last_tag])
                                                        <a href="javascript:void(0)"
                                                            rel="tag">{{ $tag }}</a>,
                                                    @else
                                                        <a href="javascript:void(0)" rel="tag">{{ $tag }}</a>
                                                    @endif
                                                    @php
                                                        $i_t++;
                                                    @endphp
                                                @endforeach
                                            <li>Availability:<span
                                                    class="in-stock text-success ml-5">{{ $product[0]['quantity'] }}
                                                    Items In
                                                    Stock</span></li>
                                        </ul>
                                    </div>
                                    <!-- Detail Info -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10 m-auto entry-main-content">
                                    <h2 class="section-title style-1 mb-30">Description</h2>
                                    <div class="description mb-50">{!! $product[0]['description'] !!}</div>
                                    <div class="social-icons single-share">
                                        <ul class="text-grey-5 d-inline-block">
                                            <li><strong class="mr-10">Share this:</strong></li>
                                            <li class="social-facebook"><a href="#"><img
                                                        src="{{ asset('assets/imgs/theme/icons/icon-facebook.svg') }}"
                                                        alt=""></a></li>
                                            <li class="social-twitter"> <a href="#"><img
                                                        src="{{ asset('assets/imgs/theme/icons/icon-twitter.svg') }}"
                                                        alt=""></a></li>
                                            <li class="social-instagram"><a href="#"><img
                                                        src="{{ asset('assets/imgs/theme/icons/icon-instagram.svg') }}"
                                                        alt=""></a></li>
                                            <li class="social-linkedin"><a href="#"><img
                                                        src="{{ asset('assets/imgs/theme/icons/icon-pinterest.svg') }}"
                                                        alt=""></a></li>
                                        </ul>
                                    </div>
                                    @if (count($reviews) > 0)
                                        <h3 class="section-title style-1 mb-30 mt-30">Reviews ({{ count($reviews) }})</h3>
                                        <!--Comments-->
                                        <div class="comments-area style-2">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="comment-list">
                                                        @foreach ($reviews as $review)
                                                            <div class="single-comment justify-content-between d-flex">
                                                                <div class="user justify-content-between d-flex">
                                                                    <div class="thumb text-center">
                                                                        <h6><a
                                                                                href="javascript:void(0)">{{ $review->name }}</a>
                                                                        </h6>
                                                                    </div>
                                                                    <div class="desc">
                                                                        @for ($i = 0; $i < 5; $i++)
                                                                            @if ($i < floatval($review->rating))
                                                                                <span
                                                                                    class="fa fa-star text-warning"></span>
                                                                            @else
                                                                                <span class="fa fa-star"></span>
                                                                            @endif
                                                                        @endfor
                                                                        <p>{{ $review->comment }}
                                                                        </p>
                                                                        <div class="d-flex justify-content-between">
                                                                            <div class="d-flex align-items-center">
                                                                                <p class="font-xs mr-30">
                                                                                    {{ formatted_date($review->created_at, 'Y-d-m') }}
                                                                                    at
                                                                                    {{ formatted_date($review->created_at, 'h:m a') }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <h4 class="mb-30">Customer reviews</h4>
                                                    <div class="d-flex mb-30">
                                                        <div class="d-inline-block mr-15">
                                                            @for ($i = 0; $i < 5; $i++)
                                                                @if ($i < floatval($avg_of_rating))
                                                                    <span class="fa fa-star text-warning"></span>
                                                                @else
                                                                    <span class="fa fa-star"></span>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <h6 class="mt-2">{{ floatval($avg_of_rating) }} out of 5</h6>
                                                    </div>
                                                    @foreach ($star_rating as $item)
                                                        <div class="progress">
                                                            <span>{{ $item->star }} star</span>
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ intval(($item->rating / $sum_of_rating) * 100) }}%;"
                                                                aria-valuenow="{{ intval(($item->rating / $sum_of_rating) * 100) }}"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                {{ intval(($item->rating / $sum_of_rating) * 100) }}%
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <!--comment form-->
                                    <div class="comment-form">
                                        <h4 class="mb-15">Add a review</h4>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-12">
                                                <form class="form-contact comment_form" action="{{ route('rating') }}"
                                                    id="commentForm" method="POST">
                                                    @csrf
                                                    <div class="star-rating">
                                                        <span class="fa fa-star" data-rating="1"></span>
                                                        <span class="fa fa-star" data-rating="2"></span>
                                                        <span class="fa fa-star" data-rating="3"></span>
                                                        <span class="fa fa-star" data-rating="4"></span>
                                                        <span class="fa fa-star" data-rating="5"></span>
                                                        <input type="hidden" name="product_rating" class="rating-value"
                                                            value="1" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                                                                    placeholder="Write Comment" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="name" id="name"
                                                                    type="text" placeholder="Name" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="email" id="email"
                                                                    type="email" placeholder="Email" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="hidden" value="{{ $product[0]['id'] }}"
                                                            name="id" />
                                                        <button type="submit" class="button button-contactForm">Submit
                                                            Review</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-60">
                                <div class="col-12">
                                    <h3 class="section-title style-1 mb-30">Related products</h3>
                                </div>
                                <div class="col-12">
                                    <div class="row related-products">
                                        <div class="carausel-4-columns-cover position-relative">
                                            <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow"
                                                id="carausel-4-columns-1-arrows">
                                            </div>
                                            <div class="carausel-4-columns carausel-arrow-center"
                                                id="carausel-4-columns-1">
                                                @foreach ($related_products as $related_product)
                                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6 m-2">
                                                        <div class="product-cart-wrap mb-30">
                                                            <div class="product-img-action-wrap">
                                                                <div class="product-img product-img-zoom">
                                                                    <a
                                                                        href="{{ url('/product-detail/' . $related_product->id) }}">
                                                                        @php
                                                                            $image = explode(',', $related_product->suppornting_media);
                                                                        @endphp
                                                                        <img class="default-img"
                                                                            src="{{ asset('uploads/' . $related_product->main_media) }}"
                                                                            alt="">
                                                                        <img class="hover-img"
                                                                            src="{{ asset('uploads/' . $image[0]) }}"
                                                                            alt="">
                                                                    </a>
                                                                </div>
                                                                <div class="product-action-1">
                                                                    <a aria-label="Quick view" class="action-btn hover-up"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#Modal{{ $related_product->id }}">
                                                                        <i class="fi-rs-eye"></i></a>
                                                                    <a aria-label="Add To Wishlist"
                                                                        class="action-btn hover-up"
                                                                        href="javascript:void(0)"
                                                                        onclick="addToWishlist({{ $related_product->id }})"><i
                                                                            class="fi-rs-heart"></i></a>
                                                                </div>
                                                                @php
                                                                    $badges = explode(',', $related_product->badges);
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
                                                                        $space = $space + 9;
                                                                    @endphp
                                                                @endforeach
                                                            </div>
                                                            <div class="product-content-wrap">
                                                                <div class="product-category">
                                                                    <a href="{{ url('/shop') }}">
                                                                        @foreach ($categories as $category)
                                                                            @if ($category->id == $related_product->cat_id)
                                                                                {{ $category->category_title }}
                                                                            @endif
                                                                        @endforeach
                                                                    </a>
                                                                </div>
                                                                <h2 class="c-text" title="{{ $related_product->title }}">
                                                                    <a
                                                                        href="{{ url('/product-detail/' . $related_product->id) }}">{{ $related_product->title }}</a>
                                                                </h2>
                                                                <div class="rating-result" title="90%">
                                                                    <span>
                                                                        <span>90%</span>
                                                                    </span>
                                                                </div>
                                                                <div class="product-price">
                                                                    @php
                                                                        $price = 0;
                                                                    @endphp
                                                                    @if ($related_product->sale_price > 0)
                                                                        <span>
                                                                            {{ currency_converter($related_product->sale_price) }}</span>
                                                                        <span
                                                                            class="old-price">{{ currency_converter($related_product->price) }}</span>
                                                                        @php
                                                                            $price = $related_product->sale_price;
                                                                        @endphp
                                                                    @else
                                                                        <span>
                                                                            {{ currency_converter($related_product->price) }}</span>
                                                                        @php
                                                                            $price = $related_product->price;
                                                                        @endphp
                                                                    @endif
                                                                </div>
                                                                <div class="product-action-1 show">
                                                                    <a aria-label="Add To Cart"
                                                                        class="action-btn hover-up"
                                                                        href="javascript:void(0)"
                                                                        onclick="addToCart({{ $related_product->id }},{{ $price }},1)"><i
                                                                            class="fi-rs-shopping-bag-add"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($content->ad_status == 'Show')
                            <div class="container">
                                <div class="banner-img banner-big wow fadeIn animated f-none">
                                    <img src="{{ asset('/uploads/' . $content->ad) }}" alt="">
                                    <div class="banner-text d-md-block d-none" style="margin-left: -2%;margin-top: 9.1%;">
                                        <a href="@if (empty($content->category_slug) && empty($content->sub_category_slug)) {{ url('/shop') }}
                                            @elseif (!empty($content->category_slug) && empty($content->sub_category_slug))
                                                {{ url('/shop/' . $content->category_slug) }}
                                            @elseif (!empty($content->category_slug) && !empty($content->sub_category_slug))
                                                {{ url('/shop/' . $content->category_slug . '/' . $content->sub_category_slug) }} @endif"
                                            class="btn ">Learn More <i class="fi-rs-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </section>
        <section>
            @foreach ($related_products as $product)
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
                                                            @if ($i < floatval($avg_of_rating))
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
                                                                class="old-price font-md ml-15">{{ currency_converter($product->price) }}</span></ins>
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
        var $star_rating = $('.star-rating .fa');

        var SetRatingStar = function() {
            return $star_rating.each(function() {
                if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data(
                        'rating'))) {
                    return $(this).removeClass('fa-star').addClass('fa-star text-warning');
                } else {
                    return $(this).removeClass('fa-star text-warning').addClass('fa-star');
                }
            });
        };

        $star_rating.on('click', function() {
            $star_rating.siblings('input.rating-value').val($(this).data('rating'));
            return SetRatingStar();
        });

        SetRatingStar();
        $(document).ready(function() {

        });
    </script>
    <script>
        function change_price(product_price, price) {
            var new_price = product_price + price;
            $("#p_price").text('$' + new_price);
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function addToCart(id, price = 0, qty = 1) {
            if (price == 0 && qty == 1) {
                price = $('#pro_price_' + id).val();
                qty = $('#qty_val_' + id).val()
            }
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
