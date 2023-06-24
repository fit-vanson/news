@php
    $siteInfo = getSiteInfo();
@endphp
@extends('frontend.master')
@section('meta_content')

    <meta name="keywords" content="{{ $siteInfo['og_keywords'] }}"/>
    <meta name="title" content="{{ $siteInfo['og_title'] }}">
    <meta name="description" content="{{ $siteInfo['og_description'] }}"/>
    <meta property="og:title" content="{{ $siteInfo['og_title'] }}"/>
    <meta property="og:site_name" content="{{ $siteInfo['site_name'] }}"/>
    <meta property="og:description" content="{{ $siteInfo['og_description'] }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:image" content="{{ asset('media/'.$siteInfo['og_image']) }}"/>
    <meta property="og:image:width" content="600"/>
    <meta property="og:image:height" content="315"/>

@endsection
@section('main_content')
    <main class="main">
        <!-- Page Breadcrumb -->
        <div class="breadcrumb-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('404 - Not Found') }}</li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
        <!-- /Page Breadcrumb/ -->

        <!-- Inner Section -->
        <section class="inner-section inner-section-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="error_card">
                            <div class="error_img">
                                <img src="{{ asset('frontend/img/404.png') }}" />
                            </div>
                            <p>{{ __('This page you are looking for could not be found!') }}</p>
                            <a class="btn theme-btn" href="{{ url('/') }}">{{ __('Back to Home Page') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Inner Section/ -->
    </main>

@endsection









