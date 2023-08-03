@extends('layouts.main')
@push('head')
    <title>Home | Baggage Factory</title>
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

        .banner-img.banner-2 .banner-text {
            left: -10px;
            top: 55px;
        }
        .l2-text {
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
    <main class="main">
        <section class="home-slider position-relative">
            <div class="hero-slider-1 dot-style-1 dot-style-1-position-1">
                <div class="single-hero-slider single-animation-wrap">
                    <div class="container">
                        <div class="row align-items-center slider-animated-1">
                            <div class="col-lg-5 col-md-6">
                                <div class="hero-slider-content-2">
                                    <h4 class="animated">Elegant Designs</h4>
                                    <h2 class="animated fw-900">Bags Collection</h2>
                                    <h1 class="animated fw-900 text-brand">Now available at Baggage Factory</h1>
                                    <a class="animated btn btn-brush btn-brush-3" href="{{ url('/shop') }}"> Shop
                                        Now </a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6">
                                <div class="single-slider-img single-slider-img-1">
                                    <a href="{{ url('/shop') }}">
                                        <img class="animated slider-1-1 mt-n4"
                                            src="{{ asset('uploads/website/Main Slider 3.png') }}" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-hero-slider single-animation-wrap">
                    <div class="container">
                        <div class="row align-items-center slider-animated-1">
                            <div class="col-lg-5 col-md-6">
                                <div class="hero-slider-content-2">
                                    <h4 class="animated">Bags like never before..</h4>
                                    <h1 class="animated fw-900 text-7">Baggage Factory offer Best Deals..</h1>
                                    <a class="animated btn btn-brush btn-brush-2" href="{{ url('/shop') }}">
                                        Discover Now </a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6">
                                <div class="single-slider-img single-slider-img-1">
                                    <a href="{{ url('/shop') }}">
                                        <img class="animated slider-1-2 mt-n4"
                                            src="{{ asset('uploads/website/Slider 2 Version 2.png') }}" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-hero-slider single-animation-wrap">
                    <div class="container">
                        <div class="row align-items-center slider-animated-1">
                            <div class="col-lg-5 col-md-6">
                                <div class="hero-slider-content-2">
                                    <h4 class="animated">Convert your bags into an experience</h4>
                                    <h1 class="animated fw-900 text-8">Baggage Factory knows your choice..</h1>
                                    <a class="animated btn btn-brush btn-brush-1" href="{{ url('/shop') }}"> Shop
                                        Now </a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-6">
                                <div class="single-slider-img single-slider-img-1">
                                    <a href="{{ url('/shop') }}">
                                        <img class="animated slider-1-3 mt-n4"
                                            src="{{ asset('uploads/website/Slider 3 Version 2.png') }}" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider-arrow hero-slider-1-arrow"></div>
        </section>
        {{-- <section class="featured section-padding position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                        <div class="banner-features wow fadeIn animated hover-up">
                            <img src="{{ asset('assets/imgs/theme/icons/feature-1.png') }}" alt="">
                            <h4 class="bg-1">Free Shipping</h4>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                        <div class="banner-features wow fadeIn animated hover-up">
                            <img src="{{ asset('assets/imgs/theme/icons/feature-2.png') }}" alt="">
                            <h4 class="bg-3">Online Order</h4>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                        <div class="banner-features wow fadeIn animated hover-up">
                            <img src="{{ asset('assets/imgs/theme/icons/feature-3.png') }}" alt="">
                            <h4 class="bg-2">Save Money</h4>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                        <div class="banner-features wow fadeIn animated hover-up">
                            <img src="{{ asset('assets/imgs/theme/icons/feature-4.png') }}" alt="">
                            <h4 class="bg-4">Promotions</h4>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                        <div class="banner-features wow fadeIn animated hover-up">
                            <img src="{{ asset('assets/imgs/theme/icons/feature-5.png') }}" alt="">
                            <h4 class="bg-5">Happy Sell</h4>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                        <div class="banner-features wow fadeIn animated hover-up">
                            <img src="{{ asset('assets/imgs/theme/icons/feature-6.png') }}" alt="">
                            <h4 class="bg-6">24/7 Support</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <section class="product-tabs section-padding position-relative wow fadeIn animated">
            <div class="bg-square"></div>
            <div class="container">
                <div class="tab-header">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one"
                                type="button" role="tab" aria-controls="tab-one" aria-selected="true">Featured</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nav-tab-two" data-bs-toggle="tab" data-bs-target="#tab-two"
                                type="button" role="tab" aria-controls="tab-two" aria-selected="false">Popular</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nav-tab-three" data-bs-toggle="tab" data-bs-target="#tab-three"
                                type="button" role="tab" aria-controls="tab-three" aria-selected="false">New
                                added</button>
                        </li>
                    </ul>
                    <a href="{{ url('/shop') }}" class="view-more d-none d-md-flex">View More<i
                            class="fi-rs-angle-double-small-right"></i></a>
                </div>
                <!--End nav-tabs-->
                <div class="tab-content wow fadeIn animated" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                        <div class="carausel-4-columns-cover position-relative">
                            <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow"
                                id="carausel-4-columns-1-arrows">
                            </div>
                            <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns-1">
                                @foreach ($products as $product)
                                    @if ($product->is_feature == 'Featured')
                                        <div class="col-lg-3 col-md-4 col-12 col-sm-6 m-2">
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
                                                            <img class="hover-img"
                                                                src="{{ asset('uploads/' . $image[0]) }}" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="product-action-1">
                                                        <a aria-label="Quick view" class="action-btn hover-up"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#Modal{{ $product->id }}">
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
                                                            $space = $space + 9;
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
                                                    <h2 class="c-text" title="{{ $product->title }}"><a
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
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <!--End product-grid-4-->
                    </div>
                    <!--En tab one (Featured)-->
                    <div class="tab-pane fade" id="tab-two" role="tabpanel" aria-labelledby="tab-two">
                        <div class="carausel-4-columns-cover position-relative">
                            <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow"
                                id="carausel-3-columns-1-arrows">
                            </div>
                            <div class="carausel-4-columns carausel-arrow-center" id="carausel-3-columns-1">
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
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#Modal{{ $product->id }}">
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
                                                        $space = $space + 9;
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
                        </div>
                        <!--End product-grid-4-->
                    </div>
                    <!--En tab two (Popular)-->
                    <div class="tab-pane fade" id="tab-three" role="tabpanel" aria-labelledby="tab-three">
                        <div class="carausel-4-columns-cover position-relative">
                            <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow"
                                id="carausel-2-columns-1-arrows">
                            </div>
                            <div class="carausel-4-columns carausel-arrow-center" id="carausel-2-columns-1">
                                @foreach ($products as $product)
                                    @if ($product->new_added == 'Yes')
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
                                                            <img class="hover-img"
                                                                src="{{ asset('uploads/' . $image[0]) }}" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="product-action-1">
                                                        <a aria-label="Quick view" class="action-btn hover-up"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#Modal{{ $product->id }}">
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
                                                            $space = $space + 9;
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
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <!--End product-grid-4-->
                    </div>
                    <!--En tab three (New added)-->
                </div>
                <!--End tab-content-->
            </div>
        </section>
        <section class="banner-2 section-padding pb-0">
            <div class="container">
                <div class="banner-img banner-big wow fadeIn animated f-none">
                    <img src="{{ asset('uploads/website/category-slider.png') }}" alt="">
                    <div class="banner-text d-md-block d-none" style="margin-left: -2%;margin-top: 9.1%;">
                        <a href="{{ url('/shop') }}" class="btn ">Learn More <i class="fi-rs-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <section class="deals section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 deal-co">
                        <div class="deal wow fadeIn animated mb-md-4 mb-sm-4 mb-lg-0"
                            style="background-image: url('{{ asset('uploads/website/Square banner 1.png') }}');">
                            <div class="deal-top">
                                <h2 class="text-white">Deal of the Day</h2>
                                <h5 class="text-white">Limited Quantities</h5>
                            </div>
                            <div class="deal-content">
                                <h6 class="product-title"><a href="javascript:void(0)" class="text-white">Luggage
                                        </a></h6>
                                <div class="product-price"><span
                                        class="new-price">{{ currency_converter(118.15) }}</span><span
                                        class="old-price">{{ currency_converter(136.84) }}</span></div>
                            </div>
                            <div class="deal-bottom">
                                <p>Hurry Up! Offer End In:</p>
                                <div class="deals-countdown" data-countdown="2025/03/25 00:00:00"></div>
                                <a href="{{ url('/shop/accessories/wirelessairphone') }}"
                                    class="btn hover-up"><strong>Shop Now</strong> <i class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 deal-co">
                        <div class="deal wow fadeIn animated"
                            style="background-image: url('{{ asset('uploads/website/Square banner 2.png') }}');">
                            <div class="deal-top">
                                <h2 class="text-white">Luggage</h2>
                                <h5 class="text-white">Collection</h5>
                            </div>
                            <div class="deal-content">
                                <h6 class="product-title"><a href="javascript:void(0)" class="text-white">Try something
                                        new on
                                        vacation</a></h6>
                                <div class="product-price"><span
                                        class="new-price">{{ currency_converter(151.3) }}</span><span
                                        class="old-price">{{ currency_converter(218.44) }}</span></div>
                            </div>
                            <div class="deal-bottom">
                                <p>Hurry Up! Offer End In:</p>
                                <div class="deals-countdown" data-countdown="2026/03/25 00:00:00"></div>
                                <a href="{{ url('/shop/accessories/wirelessairphone') }}"
                                    class="btn hover-up"><strong>Shop Now</strong><i class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="popular-categories section-padding mt-15 mb-25">
            <div class="container wow fadeIn animated">
                <h3 class="section-title mb-20"><span>Popular</span> Categories</h3>
                <div class="carausel-6-columns-cover position-relative">
                    <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-arrows">
                    </div>
                    <div class="carausel-6-columns" id="carausel-6-columns">
                        @foreach ($categories as $category)
                            <div class="card-1">
                                <h5><a href="{{ url('/shop') }}">{{ $category->category_title }}</a></h5>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <section class="banners mb-15">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="banner-img wow fadeIn animated">
                            <img src="{{ asset('uploads/website/Somedeal small banners 1.png') }}" alt="">
                            <div class="banner-text">
                                <span>Smart Offer</span>
                                <h4>Save Upto 20%<br>On ABS</h4>
                                <a href="{{ url('/shop/accessories/chargers') }}">Shop Now <i
                                        class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="banner-img wow fadeIn animated">
                            <img src="{{ asset('uploads/website/Somedeal small banners 2.png') }}" alt="">
                            <div class="banner-text">
                                <span>View Collection</span>
                                <h4>Cross <br>Body</h4>
                                <a href="{{ url('/shop/accessories/phone-holder') }}">Shop Now <i
                                        class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-md-none d-lg-flex">
                        <div class="banner-img wow fadeIn animated  mb-sm-0">
                            <img src="{{ asset('uploads/website/Somedeal small banners 3.png') }}" alt="">
                            <div class="banner-text">
                                <span>New Arrivals</span>
                                <h4>For Best Sound<br>Experience</h4>
                                <a href="{{ url('/shop/accessories/wirelessairphone') }}">Shop Now <i
                                        class="fi-rs-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-padding">
            <div class="container wow fadeIn animated">
                <h3 class="section-title mb-20"><span>New</span> Arrivals</h3>
                <div class="carausel-6-columns-cover position-relative">
                    <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-2-arrows">
                    </div>
                    <div class="carausel-6-columns carausel-arrow-center" id="carausel-6-columns-2">
                        @foreach ($products as $product)
                            @if ($product->new_added == 'Yes')
                                <div class="product-cart-wrap small hover-up">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="{{ url('/product-detail/' . $product->id) }}">
                                                <img class="default-img"
                                                    src="{{ asset('uploads/' . $product->main_media) }}" alt="">
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Quick view" class="action-btn hover-up" data-bs-toggle="modal"
                                                data-bs-target="#Modal{{ $product->id }}">
                                                <i class="fi-rs-eye"></i></a>
                                            <a aria-label="Add To Wishlist" class="action-btn small hover-up"
                                                href="javascript:void(0)" tabindex="0"
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
                                                $space = $space + 9;
                                            @endphp
                                        @endforeach
                                    </div>
                                    <div class="product-content-wrap">
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
                                            @if ($product->sale_price > 0)
                                                <span> {{ currency_converter($product->sale_price) }}</span>
                                                <span class="old-price">{{ currency_converter($product->price) }}</span>
                                            @else
                                                <span> {{ currency_converter($product->price) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        {{-- <section class="section-padding">
            <div class="container">
                <h3 class="section-title mb-20 wow fadeIn animated"><span>Featured</span> Brands</h3>
                <div class="carausel-6-columns-cover position-relative wow fadeIn animated">
                    <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-3-arrows">
                    </div>
                    <div class="carausel-6-columns text-center" id="carausel-6-columns-3">
                        <div class="brand-logo">
                            <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-1.png') }}"
                                alt="">
                        </div>
                        <div class="brand-logo">
                            <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-2.png') }}"
                                alt="">
                        </div>
                        <div class="brand-logo">
                            <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-3.png') }}"
                                alt="">
                        </div>
                        <div class="brand-logo">
                            <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-4.png') }}"
                                alt="">
                        </div>
                        <div class="brand-logo">
                            <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-5.png') }}"
                                alt="">
                        </div>
                        <div class="brand-logo">
                            <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-6.png') }}"
                                alt="">
                        </div>
                        <div class="brand-logo">
                            <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-3.png') }}"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <section class="section-padding">
            <div class="container pt-25 pb-20">
                <div class="row">
                    <div class="col-lg-6">
                        <h3 class="section-title mb-20"><span>From</span> blog</h3>
                        <div class="post-list mb-4 mb-lg-0">
                            @foreach ($blogs as $blog)
                                <article class="wow fadeIn animated">
                                    <div class="d-md-flex d-block">
                                        <div class="post-thumb d-flex mr-15">
                                            <a class="color-white" href="{{ url('/blog-detail/' . $blog->id) }}">
                                                <img src="{{ asset('uploads/'.$blog->media) }}" alt="">
                                            </a>
                                        </div>
                                        <div class="post-content">
                                            <div class="entry-meta mb-10 mt-10">
                                                <a class="entry-meta meta-2" href="javascript:void(0)"><span
                                                        class="post-in font-x-small">{{ $blog->blog_categories->name }}</span></a>
                                            </div>
                                            <h4 class="post-title mb-25 text-limit-2-row l2-text">
                                                <a href="{{ url('/blog-detail/' . $blog->id) }}">
                                                    {{ $blog->title }}
                                                </a>
                                            </h4>
                                            <div class="entry-meta meta-1 font-xs color-grey mt-10 pb-10">
                                                <div>
                                                    <span class="post-on">{{ formatted_date($blog->created_at, 'd.m.Y') }}</span>
                                                    <span class="hit-count has-dot">{{ $blog->views }} Views</span>
                                                </div>
                                                <a href="{{ url('/blog-detail/' . $blog->id) }}">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="banner-img banner-1 wow fadeIn animated">
                                    <img src="{{ asset('uploads/website/3 type banner v1.png') }}" alt="">
                                    <div class="banner-text" style="margin-top:-10%">
                                        <span>Bags</span>
                                        <h4>Baggage Factory offers <br>Best Sound</h4>
                                        <a href="{{ url('/shop/accessories/wirelessairphone') }}">Shop Now <i
                                                class="fi-rs-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="banner-img mb-15 wow fadeIn animated">
                                    <img src="{{ asset('uploads/website/3 type banner v2.png') }}" alt="">
                                    <div class="banner-text">
                                        <span>Big Offer</span>
                                        <h4>On Bag <br>Cases</h4>
                                        <a href="{{ url('/shop/accessories') }}">Shop Now <i
                                                class="fi-rs-arrow-right"></i></a>
                                    </div>
                                </div>
                                <div class="banner-img banner-2 wow fadeIn animated">
                                    <img src="{{ asset('uploads/website/3 type banner v3.png') }}" alt="">
                                    <div class="banner-text">
                                        <span>Choose Baggage Factory</span>
                                        <h4>For Better Bags <br>Experience</h4>
                                        <a href="{{ url('/shop/accessories') }}">Shop Now <i
                                                class="fi-rs-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="banner-bg wow fadeIn animated"
                            style="background-image: url('{{ asset('assets/imgs/banner/banner-8.jpg') }}')">
                            <div class="banner-content">
                                <h5 class="text-grey-4 mb-15">Shop Today’s Deals</h5>
                                <h2 class="fw-600">Happy <span class="text-brand">Mother's Day</span>. Big Sale Up to
                                    40%</h2>
                            </div>
                        </div>
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
                                                    <div><img src="{{ asset('uploads/' . $image) }}"
                                                            alt="product image"></div>
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
                                                <li class="mb-5">Tags: <a href="#" rel="tag">Bags</a>, <a
                                                        href="#" rel="tag">Luggage</a>, <a href="#"
                                                        rel="tag">Trolly</a> </li>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function addToCart(id, price, qty) {
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
