<!DOCTYPE html>
<html class="no-js" lang="en">


<!-- Mirrored from wp.alithemes.com/html/evara/evara-frontend/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 01 Aug 2021 15:20:36 GMT -->

<head>
    <meta charset="utf-8">
    @stack('head')
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/website/Logo.png') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .logo.logo-width-1 a img {
            width: 95px;
            height: 95px;
            margin-top: -8%;
            margin-bottom: -8%;
        }
    </style>
</head>

<body>
    <header class="header-area header-style-1 header-height-2">
        <div class="header-top header-top-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info">
                            <ul>
                                <li><i class="fas fa-car"></i><a href="mailto:m.arslan77733@gmail.com"
                                        style="font-size:14px; color: white;">FREE SHIPPING ON ALL ORDERS</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4">
                        <div class="text-center">
                            <div id="news-flash" class="d-inline-block">
                            <ul>
                            <li style="color: white;">Baggage Factory offers Best Deals</li>
                            <li style="color: white;">Sale and discounts for loyal customers</li>
                            <li style="color: white;">Bags at your door step <a href="{{ url('/shop') }}">Order Now</a></li>
                            <li style="color: white;">Latest bags for your better experience</li>
                        </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div  class="header-info header-info-right">
                            <ul >
                                <li>
                                    <a class="language-dropdown-active" href="#"> <i class="fi-rs-money"></i>
                                        @if (session()->has('currency_symbol'))
                                            {{ session('currency_symbol') }}
                                            {{ \Illuminate\Support\Str::upper(session('currency_code')) }}
                                        @else
                                            {{ \App\Models\Currencies::where('status', '=', 'Active')->first()->symbol }}
                                            {{ \Illuminate\Support\Str::upper(\App\Models\Currencies::where('status', '=', 'Active')->first()->code) }}
                                        @endif
                                        <i class="fi-rs-angle-small-down"></i>
                                    </a>
                                    <ul  style="color: white;" class="language-dropdown">
                                        @foreach (\App\Models\Currencies::where('status', '=', 'Active')->get() as $currency)
                                            <li>
                                                <a href="javascript:void(0)"
                                                    onclick="currency_change('{{ $currency->code }}')" >{{ $currency->symbol }}
                                                    {{ \Illuminate\Support\Str::upper($currency->code) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @if (session()->has('customer'))
                                    <li><i class="fi-rs-user"></i><a
                                            href="{{ url('/my-account') }}">{{ session()->get('customer.f_name') }}
                                            {{ session()->get('customer.l_name') }}</a></li>
                                @else
                                    <li><i class="fi-rs-user"></i><a href="{{ url('/loginPage') }}" style="color: white;">Log In / Sign
                                            Up</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="{{ url('/') }}"><img src="{{ asset('uploads/website/Logo.png') }}"
                                alt="logo" height="30px" width="30px"></a>
                    </div>
                    <div class="header-right">
                        <div class="search-style-2">
                            <form action="#">
                                <select class="select-active">
                                    <option value="0">Browse</option>
                                    @foreach ($categories as $category)
                                        <option>{{ $category->category_title }}</option>
                                    @endforeach
                                </select>
                                <input type="text" placeholder="Search for items...">
                            </form>
                        </div>
                        <div class="header-action-right">
                            <div class="header-action-2">
                                <div class="header-action-icon-2">
                                    <a href="{{ url('/wishlist') }}">
                                        <img class="svgInject" alt="Evara"
                                            src="{{ asset('assets/imgs/theme/icons/icon-heart.svg') }}">
                                        <span class="pro-count blue" id="wishlistheading">
                                            {{ $wishlist }}
                                        </span>
                                    </a>
                                </div>
                                <div class="header-action-icon-2">
                                    <a class="mini-cart-icon" href="{{ url('/cart') }}">
                                        <img alt="Evara" src="{{ asset('assets/imgs/theme/icons/icon-cart.svg') }}">
                                        <span class="pro-count blue" id="cartheading">
                                            {{ $cart }}
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="{{ url('/') }}"><img src="{{ asset('uploads/website/Logo.png') }}"
                                alt="logo" height="30px" width="10px"></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                        <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categori-button-active" href="#">
                                <span class="fi-rs-apps"></span> Browse Categories
                            </a>
                            <div class="categori-dropdown-wrap categori-dropdown-active-large">
                                <ul>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($categories as $category)
                                        @if ($i <= 2)
                                            @if (count($sub_categories[$category->id]) > 0)
                                                <li class="has-children">
                                                    <a
                                                        href="{{ url('/shop/' . $category->category_slug) }}">{{ $category->category_title }}</a>
                                                    <div class="dropdown-menu">
                                                        <ul>
                                                            @foreach ($sub_categories[$category->id] as $item)
                                                                <li><a class="dropdown-item nav-link"
                                                                        href="{{ url('/shop/' . $category->category_slug . '/' . $item->sub_category_slug) }}">
                                                                        {{ $item->sub_category_title }}
                                                                    </a></li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </li>
                                            @else
                                                <li><a href="{{ url('/shop') }}">{{ $category->category_title }}</a>
                                                </li>
                                            @endif
                                        @else
                                            <ul class="more_slide_open" style="display: none;">
                                                @if (count($sub_categories[$category->id]) > 0)
                                                    <li class="has-children">
                                                        <a
                                                            href="{{ url('/shop/' . $category->category_slug) }}">{{ $category->category_title }}</a>
                                                        <div class="dropdown-menu">
                                                            <ul>
                                                                @foreach ($sub_categories[$category->id] as $item)
                                                                    <li><a class="dropdown-item nav-link"
                                                                            href="{{ url('/shop/' . $category->category_slug . '/' . $item->sub_category_slug) }}">
                                                                            {{ $item->sub_category_title }}
                                                                        </a></li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li><a
                                                            href="{{ url('/shop/' . $category->category_slug) }}">{{ $category->category_title }}</a>
                                                    </li>
                                                @endif
                                            </ul>
                                            <div class="more_categories">Show more...</div>
                                        @endif
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                            <nav>
                                <ul>
                                    <li><a class="@if ($active == 'home') active @endif"
                                            href="{{ url('/') }}">Home</a>
                                    </li>
                                    <li>
                                        <a class="@if ($active == 'about') active @endif"
                                            href="{{ url('/about') }}">About</a>
                                    </li>
                                    <li class="position-static "><a
                                            class="@if ($active == 'shop') active @endif"
                                            href="{{ url('/shop') }}">Shop <i class="fi-rs-angle-down"></i></a>
                                        <ul class="mega-menu">
                                            @foreach ($categories as $category)
                                                <li class="sub-mega-menu sub-mega-menu-width-22">
                                                    <a class="menu-title"
                                                        href="{{ url('/shop/' . $category->category_slug) }}">{{ $category->category_title }}</a>
                                                    <ul>
                                                        @foreach ($sub_categories[$category->id] as $item)
                                                            @if (count($sub_categories[$category->id]) > 0)
                                                                <li><a
                                                                        href="{{ url('/shop/' . $category->category_slug . '/' . $item->sub_category_slug) }}">{{ $item->sub_category_title }}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <!-- <li><a class="@if ($active == 'blog') active @endif"
                                            href="{{ url('/blog') }}">Blog</a>
                                    </li> -->
                                    {{-- <li><a href="#">Pages <i class="fi-rs-angle-down"></i></a>
                                        <ul class="sub-menu">
                                            <li><a href="page-about.html">About Us</a></li>
                                            <li><a href="page-contact.html">Contact</a></li>
                                            <li><a href="page-account.html">My Account</a></li>
                                            <li><a href="page-login-register.html">login/register</a></li>
                                            <li><a href="page-purchase-guide.html">Purchase Guide</a></li>
                                            <li><a href="page-privacy-policy.html">Privacy Policy</a></li>
                                            <li><a href="page-terms.html">Terms of Service</a></li>
                                            <li><a href="page-404.html">404 Page</a></li>
                                        </ul>
                                    </li> --}}
                                    <li>
                                        <a class="@if ($active == 'contact') active @endif"
                                            href="{{ url('/contact') }}">Contact</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- <a href="{{ url('/shop/accessories') }}">
                        <span>Lunch Offer flat 30% off: <strong class="hotline" id="demo"></strong></span>
                    </a> -->
                    <div class="hotline d-none d-lg-block">
                        <p><i class="fi-rs-envelope"></i><span>Mail</span> <a
                                href="mailto:m.arslan77733@gmail.com">sales@baggagefactory.co.uk</a> </p>
                    </div>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="{{ url('/wishlist') }}">
                                    <img alt="Evara" src="{{ asset('assets/imgs/theme/icons/icon-heart.svg') }}">
                                    <span class="pro-count white">{{ $wishlist }}</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{ url('/cart') }}">
                                    <img alt="Evara" src="{{ asset('assets/imgs/theme/icons/icon-cart.svg') }}">
                                    <span class="pro-count white">{{ $cart }}</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2 d-block d-lg-none">
                                <div class="burger-icon burger-icon-white">
                                    <span class="burger-icon-top"></span>
                                    <span class="burger-icon-mid"></span>
                                    <span class="burger-icon-bottom"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('uploads/website/Logo.png') }}"
                            alt="logo"></a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="#">
                        <input type="text" placeholder="Search for items…">
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <div class="main-categori-wrap mobile-header-border">
                        <a class="categori-button-active-2" href="#">
                            <span class="fi-rs-apps"></span> Browse Categories
                        </a>
                        <div class="categori-dropdown-wrap categori-dropdown-active-small">
                            <ul>
                                @foreach ($categories as $category)
                                    <li><a
                                            href="{{ url('/shop/' . $category->category_slug) }}">{{ $category->category_title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- mobile menu start -->
                    <nav>
                        <ul class="mobile-menu">
                            <li class="menu-item-has-children"><a href="{{ url('/') }}">Home</a></li>
                            <li class="menu-item-has-children"><a href="{{ url('/about') }}">About</a></li>
                            <li class="menu-item-has-children"><a href="{{ url('/shop') }}">shop</a>
                                <ul class="dropdown">
                                    @foreach ($categories as $category)
                                        <li><a
                                                href="{{ url('/shop/' . $category->category_slug) }}">{{ $category->category_title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="menu-item-has-children"></span><a href="{{ url('/blog') }}">Blog</a></li>
                            <li class="menu-item-has-children"><span class="menu-expand"></span><a
                                    href="{{ url('/contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                    <!-- mobile menu end -->
                </div>
                <div class="mobile-header-info-wrap mobile-header-border">
                    <div class="single-mobile-header-info">
                        @if (session()->has('customer'))
                            <a href="{{ url('/my-account') }}">
                                {{ session()->get('customer.f_name') }} {{ session()->get('customer.l_name') }}
                            </a>
                        @else
                            <a href="{{ url('/loginPage') }}">Log In / Sign Up </a>
                        @endif
                    </div>
                </div>
                <div class="mobile-social-icon">
                    <h5 class="mb-15 text-grey-4">Follow Us</h5>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-facebook.svg') }}"
                            alt=""></a>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-twitter.svg') }}"
                            alt=""></a>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-instagram.svg') }}"
                            alt=""></a>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-pinterest.svg') }}"
                            alt=""></a>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-youtube.svg') }}"
                            alt=""></a>
                </div>
            </div>
        </div>
    </div>
