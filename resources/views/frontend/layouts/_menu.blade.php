<div class="maan-manu-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-5 d-lg-none">
                <div class="maan-logo">
                    <a href="{{ URL('/') }}">
                        <img src="{{ asset('media/'.$siteInfo['front_logo']) }}" alt="logo"/>

                    </a>
                </div>
            </div>
            <div class="col-7 order-lg-2 col-lg-2">
                <ul class="maan-right-btns">
                    <li>
                        <button class="maan-search-btn" data-bs-toggle="modal" data-bs-target="#popupSearch">
                            <span class="icon"><svg viewBox="0 0 511.999 511.999"><path
                                        d="M508.874,478.708L360.142,329.976c28.21-34.827,45.191-79.103,45.191-127.309c0-111.75-90.917-202.667-202.667-202.667 S0,90.917,0,202.667s90.917,202.667,202.667,202.667c48.206,0,92.482-16.982,127.309-45.191l148.732,148.732 c4.167,4.165,10.919,4.165,15.086,0l15.081-15.082C513.04,489.627,513.04,482.873,508.874,478.708z M202.667,362.667 c-88.229,0-160-71.771-160-160s71.771-160,160-160s160,71.771,160,160S290.896,362.667,202.667,362.667z"></path></svg></span>
                        </button>
                        <div class="modal fade" id="popupSearch" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('frontend.search') }}" method="GET">
                                        @csrf
                                        <input type="search" name="search" placeholder="Search...">
                                        <button type="submit">{{ __('Search') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="d-lg-none">
                        <button type="button" class="manu-btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="col-12 order-lg-1 col-lg-10">
                <nav class="maan-main-manu">
                    <button class="close-btn d-lg-none">
                        <span></span>
                        <span></span>
                    </button>
                    <ul>
                        <li>
                            <a href="{{route('frontend.home')}}">Home</a>
                        </li>
                        @foreach( getCategoriesSite() as $category )
                            @if($category->is_publish == 1)
                                <li>
                                    <a href="@if(Route::has(strtolower($category->slug))){{ route(strtolower($category->slug),$category->name) }}@endif">{{ rawurldecode($category->name)  }} </a>
                                </li>
                            @endif
                        @endforeach

                    </ul>

                </nav>
            </div>
        </div>
    </div>

</div>







