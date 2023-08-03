@php
$views = \App\Models\Blogs::where('id', '=', $blog->id)
    ->where('status', '=', 'Active')
    ->first()->views;
$views++;
\App\Models\Blogs::where('id', '=', $blog->id)
    ->where('status', '=', 'Active')
    ->update(['views' => $views]);
@endphp
@extends('layouts.main')
@push('head')
    <title>{{ $blog->title }} | Baggage Factory</title>
    <style>
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
    @php
        $content = \App\Models\CMS::where('page', '=', 'blog_detail')->first();
    @endphp
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow">Home</a>
                    <span></span> <a href="{{ url('/blog') }}" rel="nofollow">Blog</a>
                    <span></span> {{ $blog->blog_categories->name }}
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container custom">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="single-page pl-30">
                            <div class="single-header style-2">
                                <h1 class="mb-30 l2-text" title="{{ $blog->title }}">{{ $blog->title }}</h1>
                                <div class="single-header-meta">
                                    <div class="entry-meta meta-1 font-xs mt-15 mb-15">
                                        <span class="post-on">{{ formatted_date($blog->created_at, 'd.m.Y') }}</span>
                                        <span class="hit-count  has-dot">{{ $blog->views }} Views</span>
                                    </div>
                                    <div class="social-icons single-share">
                                        <ul class="text-grey-5 d-inline-block">
                                            <li><strong class="mr-10">Share this:</strong></li>
                                            <li class="social-facebook"><a href="#"><img
                                                        src="{{ asset('assets/imgs/theme/icons/icon-facebook.svg') }}"
                                                        alt=""></a>
                                            </li>
                                            <li class="social-twitter"> <a href="#"><img
                                                        src="{{ asset('assets/imgs/theme/icons/icon-twitter.svg') }}"
                                                        alt=""></a>
                                            </li>
                                            <li class="social-instagram"><a href="#"><img
                                                        src="{{ asset('assets/imgs/theme/icons/icon-instagram.svg') }}"
                                                        alt=""></a>
                                            </li>
                                            <li class="social-linkedin"><a href="#"><img
                                                        src="{{ asset('assets/imgs/theme/icons/icon-pinterest.svg') }}"
                                                        alt=""></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <figure class="single-thumbnail">
                                <img src="{{ asset('uploads/' . $blog->media) }}" alt="">
                            </figure>
                            <div class="single-content">
                                {!! $blog->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if ($content->ad_status == 'Show')
            <section class="mt-50 mb-50">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
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
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection
