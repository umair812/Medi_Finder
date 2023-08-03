<!DOCTYPE html>
<html class="no-js" lang="en">

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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />
    <!-- IZI Toast -->
    <link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/admin/imgs/theme/favicon.svg') }}">
    <!-- Template CSS -->
    <link href="{{ asset('assets/admin/css/main.css') }}" rel="stylesheet" type="text/css" />

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <div class="screen-overlay"></div>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="{{ url('/admin') }}" class="brand-wrap">
                <h4>Baggage Factory</h4>
            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize"> <i class="text-muted material-icons md-menu_open"></i>
                </button>
            </div>
        </div>
        <nav>
            <ul class="menu-aside">
                <li class="menu-item @if ($active == 'dashboard') active @endif">
                    <a class="menu-link" href="{{ url('/admin') }}"> <i class="icon material-icons md-home"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item @if ($active == 'product') active @endif">
                    <a class="menu-link" href="{{ url('/admin/products') }}"> <i
                            class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Products</span>
                    </a>
                </li>
                <li class="menu-item has-submenu @if ($active == 'order') active @endif">
                    <a class="menu-link"> <i class="icon material-icons md-shopping_cart"></i>
                        <span class="text">Orders</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('Admin.Reg-users-new-orders') }}">Register Users New Orders</a>
                        <a href="{{ route('Admin.Visitors-new-orders') }}">Visitors New Orders</a>
                        <a href="{{ route('Admin.Reg-users-orders') }}">Register Users Orders</a>
                        <a href="{{ route('Admin.Visitors-orders') }}">Visitors Orders</a>
                    </div>
                </li>
                <li class="menu-item has-submenu @if ($active == 'category') active @endif">
                    <a class="menu-link"> <i class="icon material-icons md-stars"></i>
                        <span class="text">Categories</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ url('/admin/categories') }}">Category</a>
                        <a href="{{ url('/admin/sub-categories') }}">Sub Category</a>
                        <a href="{{ url('/admin/brands') }}">Brands</a>
                        <a href="{{ url('/admin/attribute') }}">Attribute</a>
                        <a href="{{ url('/admin/attribute-value') }}">Attribute Value</a>
                        <a href="{{ url('/admin/blog-categories') }}">Blog Category</a>
                    </div>
                </li>
                <li class="menu-item @if ($active == 'currency') active @endif">
                    <a class="menu-link" href="{{ url('/admin/currencies') }}"> <i
                            class="icon material-icons md-monetization_on"></i>
                        <span class="text">Currencies</span>
                    </a>
                </li>
                <li class="menu-item @if ($active == 'admin') active @endif">
                    <a class="menu-link" href="{{ url('/admin/admins') }}"> <i
                            class="icon material-icons md-person"></i>
                        <span class="text">Admins</span>
                    </a>
                </li>
                <li class="menu-item has-submenu @if ($active == 'mail') active @endif">
                    <a class="menu-link"> <i class="icon bx bx-envelope"></i>
                        <span class="text">Mails</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('Admin.sent-mails') }}">Sent Mails</a>
                        <a href="{{ route('Admin.contact-us') }}">Contact Us</a>
                        <a href="{{ route('Admin.order-confirmation') }}">Order Confirmation Template</a>
                        <a href="{{ route('Admin.order-acceptence') }}">Order Acceptance Template</a>
                        <a href="{{ route('Admin.order-dispatching') }}">Order Dispatching Template</a>
                        <a href="{{ route('Admin.order-cancelation') }}">Order Cancelation Template</a>
                        <a href="{{ route('Admin.order-returning') }}">Order Returning Template</a>
                        <a href="{{ route('Admin.order-completion') }}">Order Completion Template</a>
                        <a href="{{ route('Admin.marketing') }}">Marketing Template</a>
                    </div>
                </li>
                <li class="menu-item @if ($active == 'review') active @endif">
                    <a class="menu-link" href="{{ route('Admin.reviews') }}"> <i
                            class="icon material-icons md-comment"></i>
                        <span class="text">Reviews</span>
                    </a>
                </li>
                <li class="menu-item @if ($active == 'blog') active @endif">
                    <a class="menu-link" href="{{ route('Admin.blogs') }}"> <i
                            class="icon material-icons md-stars"></i>
                        <span class="text">Blogs</span> </a>
                </li>
                <li class="menu-item @if ($active == 'shipping') active @endif">
                    <a class="menu-link" href="{{ route('Admin.shipping-companies') }}"> <i class="icon bx bxs-truck"></i>
                        <span class="text">Shipping Companies</span>
                    </a>
                </li>
                <li class="menu-item has-submenu @if ($active == 'coupon') active @endif">
                    <a class="menu-link"> <i class="icon bx bxs-coupon"></i>
                        <span class="text">Coupons</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('Admin.coupons') }}">Coupons</a>
                        <a href="{{ route('Admin.used-coupons') }}">Used Coupons</a>
                    </div>
                </li>
                <li class="menu-item has-submenu @if ($active == 'cms') active @endif">
                    <a class="menu-link"> <i class="icon bx bxs-notepad"></i>
                        <span class="text">CMS</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('Admin.sent-mails') }}">Home</a>
                        <a href="{{ route('Admin.cms-about') }}">About</a>
                        <a href="{{ route('Admin.cms-shop') }}">Shop</a>
                        <a href="{{ route('Admin.cms-blog') }}">Blog</a>
                        <a href="{{ route('Admin.cms-privacy-policy') }}">Privacy Policy</a>
                        <a href="{{ route('Admin.cms-terms-conditions') }}">Terms & Conditions</a>
                        <a href="{{ route('Admin.cms-blog-detail') }}">Single Blog</a>
                        <a href="{{ route('Admin.cms-product-detail') }}">Single Product</a>
                    </div>
                </li>
                <li class="menu-item has-submenu @if ($active == 'customer') active @endif">
                    <a class="menu-link"> <i class="icon material-icons md-person"></i>
                        <span class="text">Customers</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('Admin.customers') }}">Customers</a>
                        <a href="{{ route('Admin.visitors') }}">Visitors</a>
                        <a href="{{ route('Admin.subscribers') }}">Subscribers</a>
                    </div>
                </li>
            </ul>
            <br>
            <br>
        </nav>
    </aside>
    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search"></div>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"> <i
                        class="material-icons md-apps"></i> </button>
                <ul class="nav">
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount"
                            aria-expanded="false"> <img class="img-xs rounded-circle"
                                src="{{ asset('uploads/' . session()->get('admin.admin_media')) }}" alt="User"
                                onerror="this.src='{{ asset('assets/admin/imgs/people/avatar2.jpg') }}'"></a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                            <a class="dropdown-item" href="{{ route('Admin.edit-profile') }}"><i
                                    class="material-icons md-settings"></i>Account
                                Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ url('/admin/logout') }}"><i
                                    class="material-icons md-exit_to_app"></i>Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </header>