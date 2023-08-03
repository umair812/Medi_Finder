@extends('layouts.main')
@push('head')
    <title>Blog | Baggage Factory</title>
    <style>
        .l2-text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* number of lines to show */
            -webkit-box-orient: vertical;
        }

        .l3-text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* number of lines to show */
            -webkit-box-orient: vertical;
        }
    </style>
@endpush
@section('section')
    @php
        $content = \App\Models\CMS::where('page', '=', 'blog')->first();
    @endphp
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow">Home</a>
                    <span></span> Blog
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container custom">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="single-header mb-50">
                            <h1 class="font-xxl text-brand">Our Blog</h1>
                        </div>
                        <div class="loop-grid loop-list pr-30">
                            @foreach ($blogs as $blog)
                                <article class="wow fadeIn animated hover-up mb-30">
                                    <div class="post-thumb"
                                        style="background-image: url({{ asset('uploads/' . $blog->media) }});">
                                        <div class="entry-meta">
                                            <a class="entry-meta meta-2">{{ $blog->blog_categories->name }}</a>
                                        </div>
                                    </div>
                                    <div class="entry-content-2">
                                        <h3 class="post-title mb-15">
                                            <a href="{{ url('/blog-detail/' . $blog->id) }}"
                                                class="l2-text">{{ $blog->title }}</a>
                                        </h3>
                                        <p class="post-exerpt mb-30 l3-text ">{{ $blog->short_description }}</p>
                                        <div class="entry-meta meta-1 font-xs color-grey mt-10 pb-10">
                                            <div>
                                                <span class="post-on"> <i class="fi-rs-clock"></i>
                                                    {{ formatted_date($blog->created_at, 'd.m.Y') }} </span>
                                                <span class="hit-count has-dot">{{ $blog->views }} Views</span>
                                            </div>
                                            <a href="{{ url('/blog-detail/' . $blog->id) }}" class="text-brand">Read more <i
                                                    class="fi-rs-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        <!--post-grid-->
                        <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-start">
                                    {{ $blogs->render() }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-3 primary-sidebar sticky-sidebar">
                        <div class="widget-area">
                            <!--Widget categories-->
                            <div class="sidebar-widget widget_categories mb-40">
                                <div class="widget-header position-relative mb-20 pb-10">
                                    <h5 class="widget-title">Categories</h5>
                                </div>
                                <div class="post-block-list post-module-1 post-module-5">
                                    <ul>
                                        @foreach ($blog_categories as $blog_category)
                                            <li class="cat-item cat-item-2"><a
                                                    href="blog-category-list.html">{{ $blog_category->name }}</a>
                                                ({{ \App\Models\Blogs::where('blog_categories_id', '=', $blog_category->id)->where('status', '=', 'Active')->count() }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!--Widget latest posts style 1-->
                            <div class="sidebar-widget widget_alitheme_lastpost mb-20">
                                <div class="widget-header position-relative mb-20 pb-10">
                                    <h5 class="widget-title">Trending Now</h5>
                                </div>
                                <div class="row">
                                    @php
                                        $blog_trending_first = \App\Models\Blogs::where('trending_priority', '=', '1')
                                            ->where('status', '=', 'Active')
                                            ->orderBy('id', 'desc')
                                            ->first();
                                    @endphp
                                    @if (!empty($blog_trending_first))
                                        <div class="col-12 sm-grid-content mb-30">
                                            <div class="post-thumb d-flex border-radius-5 img-hover-scale mb-15">
                                                <a href="blog-post-fullwidth.html">
                                                    <img src="{{ asset('uploads/' . $blog_trending_first->media) }}"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="post-content media-body">
                                                <a class="post-title mb-10 text-limit-2-row l2-text h4"
                                                    href="{{ url('/blog-detail/' . $blog_trending_first->id) }}">
                                                    {{ $blog_trending_first->title }}
                                                </a>
                                                <div class="entry-meta meta-13 font-xxs color-grey">
                                                    <span
                                                        class="post-on mr-10">{{ formatted_date($blog_trending_first->created_at, 'd.m.Y') }}</span>
                                                    <span class="hit-count has-dot ">{{ $blog_trending_first->views }}
                                                        Views</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @php
                                        $blog_trending = \App\Models\Blogs::where('trending_priority', '=', '2')
                                            ->where('status', '=', 'Active')
                                            ->orderBy('trending_priority', 'desc')
                                            ->get();
                                    @endphp
                                    @foreach ($blog_trending as $item)
                                        <div class="col-md-6 col-sm-6 sm-grid-content mb-30">
                                            <div class="post-thumb d-flex border-radius-5 img-hover-scale mb-15">
                                                <a href="blog-post-fullwidth.html">
                                                    <img src="{{ asset('uploads/' . $item->media) }}" alt="">
                                                </a>
                                            </div>
                                            <div class="post-content media-body">
                                                <a class="post-title mb-10 text-limit-2-row l2-text h6"
                                                    href="{{ url('/blog-detail/' . $item->id) }}">
                                                    {{ $item->title }}</a>
                                                <div class="entry-meta meta-13 font-xxs color-grey">
                                                    <span
                                                        class="post-on mr-10">{{ formatted_date($item->created_at, 'd.m.Y') }}</span>
                                                    <span class="hit-count has-dot ">{{ $item->views }} Views</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!--Widget ads-->
                            @if ($content->ad_status == 'Show')
                                <div class="banner-img banner-1 wow fadeIn animated mb-10">
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
            </div>
        </section>
    </main>
@endsection
