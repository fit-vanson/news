<div class="maan-mid-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-3 col-lg-2">
                <div class="maan-logo">
                    <a href="{{ URL('/') }}">
                        <img src="{{ asset('media/'.$siteInfo['front_logo']) }}" alt="logo" />
                    </a>
                </div>
            </div>
            <div class="col-sm-8 offset-sm-1 offset-lg-2">
                <div class="maan-header-adds">
{{--                    @if (advertisement())--}}
{{--                        {!! advertisement()->header_ads !!}--}}
{{--                    @else--}}
                        <a href="  https://www.google.com/ " target="_blank">
                            <img src=" {{ asset('frontend/img/header-adds/adds.jpg') }} " alt="{{ asset('frontend/img/header-adds/adds.jpg') }}">
                        </a>
{{--                    @endif--}}


                </div>
            </div>
        </div>
    </div>
</div>
