@extends('layouts.main')
@push('head')
    <title>Privacy Policy | Baggage Factory</title>
@endpush
@section('section')
    @php
        $content = \App\Models\CMS::where('page', '=', 'policy')->first();
    @endphp
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow">Home</a>
                    <span></span> Privacy policy
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="single-page pr-30">
                            <div class="single-header style-2">
                                <h2>Privacy Policy Baggage Factory</h2>
                            </div>
                            <div class="single-content">
                                {!! $content->content !!}
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
