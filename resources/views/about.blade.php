@extends('layouts.main')
@push('head')
    <title>About | Baggage Factory</title>
@endpush
@section('section')
    @php
        $content = \App\Models\CMS::where('page', '=', 'about')->first();
    @endphp
    <main class="main single-page">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow">Home</a>
                    <span></span> About us
                </div>
            </div>
        </div>
        <section class="section-padding">
            <div class="container pt-25">
                <div class="row">
                    <div class="align-self-center mb-lg-0 mb-4">
                        <h6 class="mt-0 mb-15 text-uppercase font-sm text-brand wow fadeIn animated">Our Company</h6>
                        {!! $content->content !!}
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
