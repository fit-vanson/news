@php
    $siteInfo = getSiteInfo();
@endphp
@extends('frontend.master')
@section('meta_content')

    <meta name="keywords" content="{{ $siteInfo['og_keywords'] }}" />
    <meta name="description" content="{{ $siteInfo['og_description'] }}" />
    <meta property="og:title" content="{{ $siteInfo['og_title'] }}" />
    <meta property="og:site_name" content="{{ $siteInfo['site_name'] }}" />
    <meta property="og:description" content="{{ $siteInfo['og_description'] }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('media/'.$siteInfo['og_image']) }}" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="315" />

@endsection
@section('main_content')
    <!-- Maan Top News Start -->
    <section class="maan-top-news-section">
        <div class="container">
            <div class="row">
                @foreach($newsLatest as $item)
                    <div class="@if($loop->first) col-lg-6 topnews-big-card  @else col-lg-3 @endif">
                        <div class="card maan-card-img">
                            @if($item->thumbnail)
                                <a class="topnews-thumb" href="
                                    @if($item->categories->slug)
                                        @if(Route::has(strtolower($item->categories->slug)))
                                        {{ route( strtolower($item->categories->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }}
                                        @endif
                                        @endif
                                            ">
                                    <img src="/media/{{ $item->thumbnail }}"/>


                                </a>

                            @endif
                            <span class="maan-tag-@if($loop->iteration==1)parpul @elseif($loop->iteration==2)green @elseif($loop->iteration==3)blue @elseif($loop->iteration==4)red  @endif">{{ rawurldecode($item->categories->name) }}</span>
                            <div class="card-body maan-card-body">
                                <div class="maan-text">
                                    <h4>
                                        <a href="
                                    @if($item->categories->slug)
                                    @if(Route::has(strtolower($item->categories->slug)))
                                    {{ route( strtolower($item->categories->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }}
                                    @endif
                                    @endif
                                        ">
                                            {{ rawurldecode($item->title) }}

                                        </a>
                                    </h4>
                                    <ul>
                                        @if($loop->first)
                                            <li class="author">
                                            <span class="maan-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14.485" height="16.182" viewBox="0 0 14.485 16.182">
                                                <g  transform="translate(-24.165)">
                                                    <g   data-name="Group 466" transform="translate(27.207)">
                                                    <g   data-name="Group 465" transform="translate(0)">
                                                        <path   data-name="Path 845" d="M114.993,0a4.2,4.2,0,1,0,4.2,4.2A4.213,4.213,0,0,0,114.993,0Z" transform="translate(-110.791)" fill="#fff"/>
                                                    </g>
                                                    </g>
                                                    <g    data-name="Group 468" transform="translate(24.165 8.704)">
                                                    <g   data-name="Group 467" transform="translate(0)">
                                                        <path   data-name="Path 846" d="M38.619,250.9a3.918,3.918,0,0,0-.422-.771,5.222,5.222,0,0,0-3.614-2.275.773.773,0,0,0-.532.128,4.478,4.478,0,0,1-5.284,0,.688.688,0,0,0-.532-.128,5.185,5.185,0,0,0-3.614,2.275,4.516,4.516,0,0,0-.422.771.39.39,0,0,0,.018.349,7.318,7.318,0,0,0,.5.734,6.97,6.97,0,0,0,.844.954,11,11,0,0,0,.844.734,8.367,8.367,0,0,0,9.981,0,8.065,8.065,0,0,0,.844-.734,8.47,8.47,0,0,0,.844-.954,6.429,6.429,0,0,0,.5-.734A.313.313,0,0,0,38.619,250.9Z" transform="translate(-24.165 -247.841)" fill="#fff"/>
                                                    </g>
                                                    </g>
                                                </g>
                                                </svg>
                                            </span>
                                                <span class="maan-item-text"><a href="#">{{ $item->user->name }}</a></span>
                                            </li>
                                        @endif
                                        <li class="author-date">
                                            <span class="maan-icon"><svg viewBox="0 0 512 512"><path d="M347.216,301.211l-71.387-53.54V138.609c0-10.966-8.864-19.83-19.83-19.83c-10.966,0-19.83,8.864-19.83,19.83v118.978 c0,6.246,2.935,12.136,7.932,15.864l79.318,59.489c3.569,2.677,7.734,3.966,11.878,3.966c6.048,0,11.997-2.717,15.884-7.952 C357.766,320.208,355.981,307.775,347.216,301.211z"/><path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M256,472.341 c-119.275,0-216.341-97.066-216.341-216.341S136.725,39.659,256,39.659c119.295,0,216.341,97.066,216.341,216.341 S375.275,472.341,256,472.341z"/></svg></span>
                                            <span class="maan-item-text">{{ (new \Illuminate\Support\Carbon($item->date))->format('d M, Y') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </section>
    <!-- Maan Top News End -->
    <!-- Maan Top Categories Start -->
    <section class="maan-top-categories-section maan-slide">
        <div class="container">
            <div class="maan-title-border-none">
                <div class="maan-title-text">
                    <h2>{{ __('Top Categories') }}</h2>
                </div>
            </div>
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="card maan-card-img">
                            <a class="topcategories-thumb" href="  @if(Route::has(strtolower($category->slug))){{ route(strtolower($category->slug),$category->name) }}@endif">

                                @if($category->thumbnail)
                                    <img src="/media/{{ $category->thumbnail }}" />
                                @else
                                    <img src="/backend/images/album_icon.png" />
                                @endif


                            </a>
                            <div class="card-body maan-card-body">
                                <a href="  @if(Route::has(strtolower($category->slug))){{ route(strtolower($category->slug),$category->name) }}@endif">

                                    <span>{{ rawurldecode($category->name) }}</span>
                                    <span>{{ count($category->news) }} {{ __('Post') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                @endforeach

            </div>
        </div>
    </section>
    <!-- Maan Top Categories End -->
    <!-- Maan Most Popular Start -->
    <section class="maan-most-popular-section maan-slide-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="maan-title">
                        <div class="maan-title-text">
                            <h2>{{ __('Most Popular') }}</h2>
                        </div>
                    </div>
                    <div class="maan-slide">
                        @foreach($newsRandom as $item)
                            <div class="card maan-big-post">
                                <div class="maan-post-img">
                                    <a href="@if($item->categories->slug){{ route( strtolower($item->categories->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }} @endif">
                                        @if($item->thumbnail)
                                            <img src="/media/{{ $item->thumbnail }}" />
                                        @else
                                            <img src="/backend/images/album_icon.png" />
                                        @endif
                                    </a>

                                    <span class="maan-tag-@if($loop->iteration==1)parpul @elseif($loop->iteration==2)green @elseif($loop->iteration==3)blue @elseif($loop->iteration==4)red  @endif">{{rawurldecode($item->categories->name) }}</span>
                                </div>
                                <div class="card-body maan-card-body pb-0">
                                    <div class="maan-text">
                                        <h4>
                                            <a href="@if($item->categories->slug){{ route( strtolower($item->categories->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }} @endif">{{ rawurldecode($item->title) }}</a></h4>
                                        <ul>
                                            <li class="author">
                                            <span class="maan-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12.007" height="13.414" viewBox="0 0 12.007 13.414">
                                            <g  transform="translate(-24.165)">
                                                <g   data-name="Group 466" transform="translate(26.687)">
                                                <g   data-name="Group 465" transform="translate(0)">
                                                    <path   data-name="Path 845" d="M114.274,0a3.483,3.483,0,1,0,3.483,3.483A3.492,3.492,0,0,0,114.274,0Z" transform="translate(-110.791)" fill="#888"/>
                                                </g>
                                                </g>
                                                <g    data-name="Group 468" transform="translate(24.165 7.215)">
                                                <g   data-name="Group 467" transform="translate(0)">
                                                    <path   data-name="Path 846" d="M36.147,250.375a3.247,3.247,0,0,0-.35-.639,4.329,4.329,0,0,0-3-1.886.641.641,0,0,0-.441.106,3.712,3.712,0,0,1-4.38,0,.571.571,0,0,0-.441-.106,4.3,4.3,0,0,0-3,1.886,3.743,3.743,0,0,0-.35.639.323.323,0,0,0,.015.289,6.067,6.067,0,0,0,.411.608,5.778,5.778,0,0,0,.7.791,9.112,9.112,0,0,0,.7.608,6.936,6.936,0,0,0,8.274,0,6.685,6.685,0,0,0,.7-.608,7.021,7.021,0,0,0,.7-.791,5.329,5.329,0,0,0,.411-.608A.26.26,0,0,0,36.147,250.375Z" transform="translate(-24.165 -247.841)" fill="#888"/>
                                                </g>
                                                </g>
                                            </g>
                                            </svg>

                                            </span>
                                                <span class="maan-item-text"><a href="#">{{ $item->user->name }}</a></span>
                                            </li>
                                            <li class=author-date>
                                                <span class="maan-icon"><svg viewBox="0 0 512 512"><path d="M347.216,301.211l-71.387-53.54V138.609c0-10.966-8.864-19.83-19.83-19.83c-10.966,0-19.83,8.864-19.83,19.83v118.978 c0,6.246,2.935,12.136,7.932,15.864l79.318,59.489c3.569,2.677,7.734,3.966,11.878,3.966c6.048,0,11.997-2.717,15.884-7.952 C357.766,320.208,355.981,307.775,347.216,301.211z"></path><path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M256,472.341 c-119.275,0-216.341-97.066-216.341-216.341S136.725,39.659,256,39.659c119.295,0,216.341,97.066,216.341,216.341 S375.275,472.341,256,472.341z"></path></svg></span>
                                                <span class="maan-item-text">{{ (new \Illuminate\Support\Carbon($item->date))->format('d M, Y') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="news-tab">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-news-tab" data-bs-toggle="pill" data-bs-target="#all-news" type="button">{{ __('All') }}</button>
                            </li>
                            @foreach($categories as $category)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="{{rawurldecode($category->slug)}}-tab" data-bs-toggle="pill" data-bs-target="#{{rawurldecode($category->slug)}}" type="button" >{{rawurldecode($category->name)}}</button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="all-news">
                                <div class="maan-news-list">
                                    <ul>
                                        @foreach($newsRandom as $item)
                                            @if($loop->iteration<=3)
                                                <li>
                                                    <div class="maan-list-img">
                                                        <a href="@if($item->categories->slug){{ route(strtolower($item->categories->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }}@endif">
                                                            @if($item->thumbnail)
                                                                <img src="/media/{{ $item->thumbnail }}" />
                                                            @else
                                                                <img src="/backend/images/album_icon.png" />
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="maan-list-text">
                                                        <span class="maan-tag-@if($loop->iteration==1)green @elseif($loop->iteration==2)red @elseif($loop->iteration==3)blue @elseif($loop->iteration==4)parpul  @endif">{{ rawurldecode($item->categories->name) }}</span>
                                                        <h4><a href="@if($item->categories->slug){{ route(strtolower($item->categories->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }}@endif">{{ rawurldecode($item->title) }}</a></h4>
                                                        <ul>
                                                            <li class="author">
                                                        <span class="maan-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12.007" height="13.414" viewBox="0 0 12.007 13.414">
                                                            <g  transform="translate(-24.165)">
                                                                <g   data-name="Group 466" transform="translate(26.687)">
                                                                <g   data-name="Group 465" transform="translate(0)">
                                                                    <path   data-name="Path 845" d="M114.274,0a3.483,3.483,0,1,0,3.483,3.483A3.492,3.492,0,0,0,114.274,0Z" transform="translate(-110.791)" fill="#888"/>
                                                                </g>
                                                                </g>
                                                                <g    data-name="Group 468" transform="translate(24.165 7.215)">
                                                                <g   data-name="Group 467" transform="translate(0)">
                                                                    <path   data-name="Path 846" d="M36.147,250.375a3.247,3.247,0,0,0-.35-.639,4.329,4.329,0,0,0-3-1.886.641.641,0,0,0-.441.106,3.712,3.712,0,0,1-4.38,0,.571.571,0,0,0-.441-.106,4.3,4.3,0,0,0-3,1.886,3.743,3.743,0,0,0-.35.639.323.323,0,0,0,.015.289,6.067,6.067,0,0,0,.411.608,5.778,5.778,0,0,0,.7.791,9.112,9.112,0,0,0,.7.608,6.936,6.936,0,0,0,8.274,0,6.685,6.685,0,0,0,.7-.608,7.021,7.021,0,0,0,.7-.791,5.329,5.329,0,0,0,.411-.608A.26.26,0,0,0,36.147,250.375Z" transform="translate(-24.165 -247.841)" fill="#888"/>
                                                                </g>
                                                                </g>
                                                            </g>
                                                            </svg>

                                                        </span>
                                                                <span class="maan-item-text"><a href="#">{{ $item->user->name }}</a></span>
                                                            </li>
                                                            <li class="author-date">
                                                                <span class="maan-icon"><svg viewBox="0 0 512 512"><path d="M347.216,301.211l-71.387-53.54V138.609c0-10.966-8.864-19.83-19.83-19.83c-10.966,0-19.83,8.864-19.83,19.83v118.978 c0,6.246,2.935,12.136,7.932,15.864l79.318,59.489c3.569,2.677,7.734,3.966,11.878,3.966c6.048,0,11.997-2.717,15.884-7.952 C357.766,320.208,355.981,307.775,347.216,301.211z"></path><path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M256,472.341 c-119.275,0-216.341-97.066-216.341-216.341S136.725,39.659,256,39.659c119.295,0,216.341,97.066,216.341,216.341 S375.275,472.341,256,472.341z"></path></svg></span>
                                                                <span class="maan-item-text">{{ (new \Illuminate\Support\Carbon($item->date))->format('d M, Y') }}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            @foreach($categories as $category)
                                <div class="tab-pane fade" id="{{rawurldecode($category->slug)}}" >
                                    <div class="maan-news-list">
                                        <ul>
                                            @foreach($category->news()->limit(3)->get() as $category_news)

                                                <li>
                                                    <div class="maan-list-img">

                                                        <a href="@if($category_news->categories->slug){{ route(strtolower($category_news->categories->slug).'.details',['id'=>$category_news->id,'slug'=>$category_news->slug]) }}@endif">
                                                            @if($category_news->thumbnail)
                                                                <img src="/media/{{ $category_news->thumbnail }}" />
                                                            @else
                                                                <img src="/backend/images/album_icon.png" />
                                                            @endif
                                                        </a>


                                                    </div>
                                                    <div class="maan-list-text">
                                                        <span
                                                            class="maan-tag-@if($loop->iteration==1)green @elseif($loop->iteration==2)red @elseif($loop->iteration==3)blue @elseif($loop->iteration==4)parpul  @endif">{{ rawurldecode($category_news->categories->name) }}</span>
                                                        <h4>
                                                            <a href="@if($category_news->categories->slug){{ route(strtolower($category_news->categories->slug).'.details',['id'=>$category_news->id,'slug'=>$category_news->slug]) }}@endif">{{ rawurldecode($category_news->title) }}</a>
                                                        </h4>
                                                        <ul>
                                                            <li class="author">
                                                        <span class="maan-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12.007"
                                                             height="13.414" viewBox="0 0 12.007 13.414">
                                                            <g transform="translate(-24.165)">
                                                                <g data-name="Group 466" transform="translate(26.687)">
                                                                <g data-name="Group 465" transform="translate(0)">
                                                                    <path data-name="Path 845"
                                                                          d="M114.274,0a3.483,3.483,0,1,0,3.483,3.483A3.492,3.492,0,0,0,114.274,0Z"
                                                                          transform="translate(-110.791)" fill="#888"/>
                                                                </g>
                                                                </g>
                                                                <g data-name="Group 468"
                                                                   transform="translate(24.165 7.215)">
                                                                <g data-name="Group 467" transform="translate(0)">
                                                                    <path data-name="Path 846"
                                                                          d="M36.147,250.375a3.247,3.247,0,0,0-.35-.639,4.329,4.329,0,0,0-3-1.886.641.641,0,0,0-.441.106,3.712,3.712,0,0,1-4.38,0,.571.571,0,0,0-.441-.106,4.3,4.3,0,0,0-3,1.886,3.743,3.743,0,0,0-.35.639.323.323,0,0,0,.015.289,6.067,6.067,0,0,0,.411.608,5.778,5.778,0,0,0,.7.791,9.112,9.112,0,0,0,.7.608,6.936,6.936,0,0,0,8.274,0,6.685,6.685,0,0,0,.7-.608,7.021,7.021,0,0,0,.7-.791,5.329,5.329,0,0,0,.411-.608A.26.26,0,0,0,36.147,250.375Z"
                                                                          transform="translate(-24.165 -247.841)"
                                                                          fill="#888"/>
                                                                </g>
                                                                </g>
                                                            </g>
                                                            </svg>


                                                        </span>
                                                                <span class="maan-item-text"><a
                                                                        href="#">{{ $category_news->user->name }}</a></span>
                                                            </li>
                                                            <li class="author-date">
                                                                <span class="maan-icon"><svg viewBox="0 0 512 512"><path
                                                                            d="M347.216,301.211l-71.387-53.54V138.609c0-10.966-8.864-19.83-19.83-19.83c-10.966,0-19.83,8.864-19.83,19.83v118.978 c0,6.246,2.935,12.136,7.932,15.864l79.318,59.489c3.569,2.677,7.734,3.966,11.878,3.966c6.048,0,11.997-2.717,15.884-7.952 C357.766,320.208,355.981,307.775,347.216,301.211z"></path><path
                                                                            d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M256,472.341 c-119.275,0-216.341-97.066-216.341-216.341S136.725,39.659,256,39.659c119.295,0,216.341,97.066,216.341,216.341 S375.275,472.341,256,472.341z"></path></svg></span>
                                                                <span
                                                                    class="maan-item-text">{{ (new \Illuminate\Support\Carbon($category_news->created_at))->format('d M, Y') }}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>

                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Maan Most Popular End -->


    @if(isset($categories[0]))
    <!-- Maan Politics News Start -->
    <section class="maan-technology-news-section maan-politics-section">
        <div class="container">
            <div class="maan-title justify-content-center">
                <div class="maan-title-text">
                    <h2>{{ rawurldecode($categories[0]->name)}}</h2>
                </div>
            </div>
            <div class="row">
                @foreach($categories[0]->news()->limit(5)->get() as $item)
                    <div class="@if($loop->iteration <=2) col-lg-6 politics-news-big-items @else col-lg-4 col-md-6 technologysmall-card-wrp @endif ">
                        <div class="card maan-default-post">
                            <div class="maan-post-img">


                                <a href="@if($categories[0]->slug){{ route(strtolower($categories[0]->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }}@endif">
                                    @if($item->thumbnail)
                                        <img src="/media/{{ $item->thumbnail }}" />
                                    @else
                                        <img src="/backend/images/album_icon.png" />
                                    @endif
                                </a>

                            </div>
                            <div class="card-body maan-card-body">
                                <div class="maan-text">
                                    <h4><a href="@if($categories[0]->slug) {{ route(strtolower($categories[0]->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }} @endif">{{ rawurldecode($item->title) }}</a></h4>
                                    <ul>
                                        <li>
                                            <span class="maan-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14.485" height="16.182" viewBox="0 0 14.485 16.182">
                                            <g  transform="translate(-24.165)">
                                                <g   data-name="Group 466" transform="translate(27.207)">
                                                <g   data-name="Group 465" transform="translate(0)">
                                                    <path   data-name="Path 845" d="M114.993,0a4.2,4.2,0,1,0,4.2,4.2A4.213,4.213,0,0,0,114.993,0Z" transform="translate(-110.791)" fill="#888"/>
                                                </g>
                                                </g>
                                                <g    data-name="Group 468" transform="translate(24.165 8.704)">
                                                <g   data-name="Group 467" transform="translate(0)">
                                                    <path   data-name="Path 846" d="M38.619,250.9a3.918,3.918,0,0,0-.422-.771,5.222,5.222,0,0,0-3.614-2.275.773.773,0,0,0-.532.128,4.478,4.478,0,0,1-5.284,0,.688.688,0,0,0-.532-.128,5.185,5.185,0,0,0-3.614,2.275,4.516,4.516,0,0,0-.422.771.39.39,0,0,0,.018.349,7.318,7.318,0,0,0,.5.734,6.97,6.97,0,0,0,.844.954,11,11,0,0,0,.844.734,8.367,8.367,0,0,0,9.981,0,8.065,8.065,0,0,0,.844-.734,8.47,8.47,0,0,0,.844-.954,6.429,6.429,0,0,0,.5-.734A.313.313,0,0,0,38.619,250.9Z" transform="translate(-24.165 -247.841)" fill="#888"/>
                                                </g>
                                                </g>
                                            </g>
                                            </svg>

                                            </span>
                                            <span class="maan-item-text"><a href="#">{{ $item->user->name }}</a></span>
                                        </li>
                                        <li>
                                            <span class="maan-icon"><svg viewBox="0 0 512 512"><path d="M347.216,301.211l-71.387-53.54V138.609c0-10.966-8.864-19.83-19.83-19.83c-10.966,0-19.83,8.864-19.83,19.83v118.978 c0,6.246,2.935,12.136,7.932,15.864l79.318,59.489c3.569,2.677,7.734,3.966,11.878,3.966c6.048,0,11.997-2.717,15.884-7.952 C357.766,320.208,355.981,307.775,347.216,301.211z"></path><path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M256,472.341 c-119.275,0-216.341-97.066-216.341-216.341S136.725,39.659,256,39.659c119.295,0,216.341,97.066,216.341,216.341 S375.275,472.341,256,472.341z"></path></svg></span>
                                            <span class="maan-item-text">{{ (new \Illuminate\Support\Carbon($item->created_at))->format('d M, Y') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- Maan Politics News End -->
    @endif

    @if(isset($categories[1]))
    <!-- Maan Entertainment News Start -->
    <section class="maan-entertainment-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="maan-title">
                        <div class="maan-title-text">
                            <h2>{{ rawurldecode($categories[1]->name)}}</h2>
                        </div>
                    </div>

                    <div class="maan-left-content">
                        <div class="row">
                            <div class="maan-entertainmentslide">
                                @foreach($categories[1]->news()->limit(4)->get() as $item)
                                    <div class="col-lg-6">
                                        <div class="card maan-default-post">
                                            <div class="maan-post-img">
                                                <a href="@if($categories[1]->slug){{ route(strtolower($categories[1]->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }}@endif">
                                                    @if($item->thumbnail)
                                                        <img src="/media/{{ $item->thumbnail }}" />
                                                    @else
                                                        <img src="/backend/images/album_icon.png" />
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="card-body maan-card-body">
                                                <div class="maan-text">
                                                    <h4><a href="@if($categories[1]->slug) {{ route(strtolower($categories[1]->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }} @endif">{{ rawurldecode($item->title) }}</a></h4>
                                                    <ul>
                                                        <li>
                                                        <span class="maan-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12.007" height="13.414" viewBox="0 0 12.007 13.414">
                                                            <g   transform="translate(-24.165)">
                                                                <g   data-name="Group 466" transform="translate(26.687)">
                                                                <g   data-name="Group 465" transform="translate(0)">
                                                                    <path   data-name="Path 845" d="M114.274,0a3.483,3.483,0,1,0,3.483,3.483A3.492,3.492,0,0,0,114.274,0Z" transform="translate(-110.791)" fill="#888"/>
                                                                </g>
                                                                </g>
                                                                <g    data-name="Group 468" transform="translate(24.165 7.215)">
                                                                <g   data-name="Group 467" transform="translate(0)">
                                                                    <path   data-name="Path 846" d="M36.147,250.375a3.247,3.247,0,0,0-.35-.639,4.329,4.329,0,0,0-3-1.886.641.641,0,0,0-.441.106,3.712,3.712,0,0,1-4.38,0,.571.571,0,0,0-.441-.106,4.3,4.3,0,0,0-3,1.886,3.743,3.743,0,0,0-.35.639.323.323,0,0,0,.015.289,6.067,6.067,0,0,0,.411.608,5.778,5.778,0,0,0,.7.791,9.112,9.112,0,0,0,.7.608,6.936,6.936,0,0,0,8.274,0,6.685,6.685,0,0,0,.7-.608,7.021,7.021,0,0,0,.7-.791,5.329,5.329,0,0,0,.411-.608A.26.26,0,0,0,36.147,250.375Z" transform="translate(-24.165 -247.841)" fill="#888"/>
                                                                </g>
                                                                </g>
                                                            </g>
                                                            </svg>
                                                        </span>
                                                            <span class="maan-item-text"><a href="#">{{ $item->user->name }}</a></span>
                                                        </li>
                                                        <li>
                                                            <span class="maan-icon"><svg viewBox="0 0 512 512"><path d="M347.216,301.211l-71.387-53.54V138.609c0-10.966-8.864-19.83-19.83-19.83c-10.966,0-19.83,8.864-19.83,19.83v118.978 c0,6.246,2.935,12.136,7.932,15.864l79.318,59.489c3.569,2.677,7.734,3.966,11.878,3.966c6.048,0,11.997-2.717,15.884-7.952 C357.766,320.208,355.981,307.775,347.216,301.211z"></path><path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M256,472.341 c-119.275,0-216.341-97.066-216.341-216.341S136.725,39.659,256,39.659c119.295,0,216.341,97.066,216.341,216.341 S375.275,472.341,256,472.341z"></path></svg></span>
                                                            <span class="maan-item-text">{{ (new \Illuminate\Support\Carbon($item->created_at))->format('d M, Y') }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @foreach($categories[1]->news()->limit(4)->get() as $item)
                                <div class="col-lg-6">
                                    <div class="maan-news-list">
                                        <ul>
                                            <li>
                                                <div class="maan-list-img">
                                                    <a href="@if($categories[1]->slug) {{ route(strtolower($categories[1]->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }} @endif">
                                                        @if($item->thumbnail)
                                                            <img src="/media/{{ $item->thumbnail }}" />
                                                        @else
                                                            <img src="/backend/images/album_icon.png" />
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="maan-list-text">
                                                    <h4><a href="@if($categories[1]->slug) {{ route(strtolower($categories[1]->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }} @endif">{{ rawurldecode($item->title) }}</a></h4>
                                                    <ul>
                                                        <li>
                                                            <span class="maan-icon"><svg viewBox="0 0 512 512"><path d="M347.216,301.211l-71.387-53.54V138.609c0-10.966-8.864-19.83-19.83-19.83c-10.966,0-19.83,8.864-19.83,19.83v118.978 c0,6.246,2.935,12.136,7.932,15.864l79.318,59.489c3.569,2.677,7.734,3.966,11.878,3.966c6.048,0,11.997-2.717,15.884-7.952 C357.766,320.208,355.981,307.775,347.216,301.211z"></path><path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M256,472.341 c-119.275,0-216.341-97.066-216.341-216.341S136.725,39.659,256,39.659c119.295,0,216.341,97.066,216.341,216.341 S375.275,472.341,256,472.341z"></path></svg></span>
                                                            <span class="maan-item-text">{{ (new \Illuminate\Support\Carbon($item->created_at))->format('d M, Y') }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>


                </div>
                <div class="col-lg-4">
                    <div class="maan-title">
                        <div class="maan-title-text">
                            <h2>{{ __('Stay Connected') }}</h2>
                        </div>
                    </div>
                    <div class="maan-stay-connected maan-slide-section">
                        @if($siteInfo['social_media'] != null)
                            <div class="row maan-s-follower">
                                @foreach($siteInfo['social_media'] as $key=>$social)
                                    @if($social['is_publish'] == 1)
                                        <div class="col-sm-6">
                                            <div class="follower-btn maan-{{$key}}">
                                                <a href="{{$social['url']}}" target="_blank">
                                                    <div class="maan-icon">
                                                        <i class="fab fa-{{$key}}"></i>
                                                    </div>
                                                    <div class="maan-text">
                                                        <div class="maan-f-text">{{ __('Follower') }}</div>
                                                        <div class="maan-f-numbber"><span class="counter">{{$social['followers']}}</span>{{ __('K') }}</div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        <div class="maan-news-side-add">
{{--                            @if (advertisement())--}}
{{--                                {!! advertisement()->sidebar_ads !!}--}}
{{--                            @else--}}
                                <a class=side-add-thumb href="">
                                    <img src="https://towhid.maantheme.com/frontend/img/video-news/big-img-1.jpg" alt="add">
                                </a>
                                <div class="add-text">
                                    <span class="add-title">{{__('Awesome News & Blog Theme For Your Next Project')}}</span>
                                    <a href="" class="add-btn">{{__('Buy Now')}}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9.036" height="13.233" viewBox="0 0 9.036 13.233">
                                            <path id="Path_4286" data-name="Path 4286" d="M3097.58-672l5.818,5.606-5.818,5.453" transform="translate(-3096.539 673.08)" fill="none" stroke="#fff" stroke-width="3"/>
                                        </svg>
                                    </a>
                                </div>
{{--                            @endif--}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Maan Entertainment News End -->
    @endif

    @if(isset($categories[2]))
    <!-- Maan Technology News Start -->
    <section class="maan-technology-news-section">
        <div class="container">
            <div class="maan-title-center v2">
                <div class="maan-title-icon"></div>
                <div class="maan-title-text">
                    <h2>{{ rawurldecode($categories[2]->name)}}</h2>
                </div>
                <div class="maan-title-icon"></div>
            </div>
            <div class="row">
                @foreach($categories[2]->news()->limit(6)->get() as $item)
                    <div class="@if($loop->iteration <=2) col-lg-6 @else col-lg-3 col-md-6 technologysmall-card-wrp @endif ">
                        <div class="card maan-default-post">
                            <div class="maan-post-img">
                                <a href="@if($categories[2]->slug) {{ route(strtolower($categories[2]->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }} @endif">
                                    @if($item->thumbnail)
                                        <img src="/media/{{ $item->thumbnail }}" />
                                    @else
                                        <img src="/backend/images/album_icon.png" />
                                    @endif
                                </a>
                            </div>
                            <div class="card-body maan-card-body">
                                <div class="maan-text">
                                    <h4><a href="@if($categories[2]->slug) {{ route(strtolower($categories[2]->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }} @endif">{{ rawurldecode($item->title) }}</a></h4>
                                    <ul>
                                        <li>
                                        <span class="maan-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12.007" height="13.414" viewBox="0 0 12.007 13.414">
                                            <g  transform="translate(-24.165)">
                                                <g   data-name="Group 466" transform="translate(26.687)">
                                                <g   data-name="Group 465" transform="translate(0)">
                                                    <path   data-name="Path 845" d="M114.274,0a3.483,3.483,0,1,0,3.483,3.483A3.492,3.492,0,0,0,114.274,0Z" transform="translate(-110.791)" fill="#888"/>
                                                </g>
                                                </g>
                                                <g    data-name="Group 468" transform="translate(24.165 7.215)">
                                                <g   data-name="Group 467" transform="translate(0)">
                                                    <path   data-name="Path 846" d="M36.147,250.375a3.247,3.247,0,0,0-.35-.639,4.329,4.329,0,0,0-3-1.886.641.641,0,0,0-.441.106,3.712,3.712,0,0,1-4.38,0,.571.571,0,0,0-.441-.106,4.3,4.3,0,0,0-3,1.886,3.743,3.743,0,0,0-.35.639.323.323,0,0,0,.015.289,6.067,6.067,0,0,0,.411.608,5.778,5.778,0,0,0,.7.791,9.112,9.112,0,0,0,.7.608,6.936,6.936,0,0,0,8.274,0,6.685,6.685,0,0,0,.7-.608,7.021,7.021,0,0,0,.7-.791,5.329,5.329,0,0,0,.411-.608A.26.26,0,0,0,36.147,250.375Z" transform="translate(-24.165 -247.841)" fill="#888"/>
                                                </g>
                                                </g>
                                            </g>
                                            </svg>

                                        </span>
                                            <span class="maan-item-text"><a href="#">{{ $item->user->name }}</a></span>
                                        </li>
                                        <li>
                                            <span class="maan-icon"><svg viewBox="0 0 512 512"><path d="M347.216,301.211l-71.387-53.54V138.609c0-10.966-8.864-19.83-19.83-19.83c-10.966,0-19.83,8.864-19.83,19.83v118.978 c0,6.246,2.935,12.136,7.932,15.864l79.318,59.489c3.569,2.677,7.734,3.966,11.878,3.966c6.048,0,11.997-2.717,15.884-7.952 C357.766,320.208,355.981,307.775,347.216,301.211z"></path><path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M256,472.341 c-119.275,0-216.341-97.066-216.341-216.341S136.725,39.659,256,39.659c119.295,0,216.341,97.066,216.341,216.341 S375.275,472.341,256,472.341z"></path></svg></span>
                                            <span class="maan-item-text">{{ (new \Illuminate\Support\Carbon($item->created_at))->format('d M, Y') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- Maan Technology News End -->
    @endif

    @if(isset($categories[3]))
    <!-- Maan Lifestyle News Start -->
    <section class="maan-lifestyle-news">
        <div class="container">
            <div class="maan-title">
                <div class="maan-title-text">
                    <h2>{{ rawurldecode($categories[3]->name)}}</h2>
                </div>
            </div>
            <div class="row maan-post-groop">
                @foreach($categories[3]->news()->limit(4)->get() as $item)
                    <div class="col-lg-3">
                        <div class="card maan-default-post">
                            <div class="maan-post-img">
                                @if($lastnewslifestyle->image)
                                    <a href="@if($categories[3]->slug) {{ route(strtolower($categories[3]->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }} @endif">
                                        @if($item->thumbnail)
                                            <img src="/media/{{ $item->thumbnail }}" />
                                        @else
                                            <img src="/backend/images/album_icon.png" />
                                        @endif
                                    </a>
                                @endif
                            </div>
                            <div class="card-body maan-card-body">
                                <div class="maan-text">
                                    <h4><a href="@if($categories[3]->slug) {{ route(strtolower($categories[3]->slug).'.details',['id'=>$item->id,'slug'=>$item->slug]) }} @endif">{{ rawurldecode($item->title) }}</a></h4>
                                    <ul>
                                        <li>
                                        <span class="maan-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12.007" height="13.414" viewBox="0 0 12.007 13.414">
                                        <g  transform="translate(-24.165)">
                                            <g   data-name="Group 466" transform="translate(26.687)">
                                            <g   data-name="Group 465" transform="translate(0)">
                                                <path   data-name="Path 845" d="M114.274,0a3.483,3.483,0,1,0,3.483,3.483A3.492,3.492,0,0,0,114.274,0Z" transform="translate(-110.791)" fill="#888"/>
                                            </g>
                                            </g>
                                            <g    data-name="Group 468" transform="translate(24.165 7.215)">
                                            <g   data-name="Group 467" transform="translate(0)">
                                                <path   data-name="Path 846" d="M36.147,250.375a3.247,3.247,0,0,0-.35-.639,4.329,4.329,0,0,0-3-1.886.641.641,0,0,0-.441.106,3.712,3.712,0,0,1-4.38,0,.571.571,0,0,0-.441-.106,4.3,4.3,0,0,0-3,1.886,3.743,3.743,0,0,0-.35.639.323.323,0,0,0,.015.289,6.067,6.067,0,0,0,.411.608,5.778,5.778,0,0,0,.7.791,9.112,9.112,0,0,0,.7.608,6.936,6.936,0,0,0,8.274,0,6.685,6.685,0,0,0,.7-.608,7.021,7.021,0,0,0,.7-.791,5.329,5.329,0,0,0,.411-.608A.26.26,0,0,0,36.147,250.375Z" transform="translate(-24.165 -247.841)" fill="#888"/>
                                            </g>
                                            </g>
                                        </g>
                                        </svg>

                                        </span>
                                            <span class="maan-item-text"><a href="#">{{ $item->user->name }}</a></span>
                                        </li>
                                        <li>
                                            <span class="maan-icon"><svg viewBox="0 0 512 512"><path d="M347.216,301.211l-71.387-53.54V138.609c0-10.966-8.864-19.83-19.83-19.83c-10.966,0-19.83,8.864-19.83,19.83v118.978 c0,6.246,2.935,12.136,7.932,15.864l79.318,59.489c3.569,2.677,7.734,3.966,11.878,3.966c6.048,0,11.997-2.717,15.884-7.952 C357.766,320.208,355.981,307.775,347.216,301.211z"></path><path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M256,472.341 c-119.275,0-216.341-97.066-216.341-216.341S136.725,39.659,256,39.659c119.295,0,216.341,97.066,216.341,216.341 S375.275,472.341,256,472.341z"></path></svg></span>
                                            <span class="maan-item-text">{{ (new \Illuminate\Support\Carbon($item->created_at))->format('d M, Y') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Maan Lifestyle News End -->--}}
    @endif

@endsection
