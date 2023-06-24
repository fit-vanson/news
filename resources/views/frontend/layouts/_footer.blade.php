<footer>
    <section class="maan-info-footer maan-data-background" data-background="{{ asset('frontend/img/footer/footer.jpg') }}">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="logo">
                        <a href="{{ URL('/') }}">
                            <img src="{{ asset('media/'.$siteInfo['about_logo_footer']) }}" alt="footer-logo" />
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="maan-text">
                        @if($siteInfo['is_publish_about'] == 1)
                            <h6> {{ $siteInfo['about_desc_footer'] }}</h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row maan-link-footer">
                <div class="col-lg-4 col-md-6">
                    <div class="maan-title">
                        <div class="maan-title-text">
                            <h2>{{ __('Most Viewed Posts') }}</h2>
                        </div>
                    </div>
                    <div class="maan-news-list">
                        <ul>


                            @foreach( $newsViewers as $item)
                                <li>
                                    <div class="maan-list-img">
                                        @if($item->thumbnail)
                                            <img src="/media/{{ $item->thumbnail }}" />
                                        @else
                                            <img src="/backend/images/album_icon.png" />
                                        @endif

                                    </div>
                                    <div class="maan-list-text">
                                        <h4><a href="">{{ rawurldecode($item->title) }}</a></h4>
                                        <ul>
                                            <li>
                                                <span class="maan-icon"><svg viewBox="0 0 512 512"><path d="M347.216,301.211l-71.387-53.54V138.609c0-10.966-8.864-19.83-19.83-19.83c-10.966,0-19.83,8.864-19.83,19.83v118.978 c0,6.246,2.935,12.136,7.932,15.864l79.318,59.489c3.569,2.677,7.734,3.966,11.878,3.966c6.048,0,11.997-2.717,15.884-7.952 C357.766,320.208,355.981,307.775,347.216,301.211z"></path><path d="M256,0C114.833,0,0,114.833,0,256s114.833,256,256,256s256-114.833,256-256S397.167,0,256,0z M256,472.341 c-119.275,0-216.341-97.066-216.341-216.341S136.725,39.659,256,39.659c119.295,0,216.341,97.066,216.341,216.341 S375.275,472.341,256,472.341z"></path></svg></span>
                                                <span class="maan-item-text">{{ (new \Illuminate\Support\Carbon($item->created_at))->format('d M, Y') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="maan-title">
                        <div class="maan-title-text">
                            <h2>{{ __("News Tag's") }}</h2>
                        </div>
                    </div>
                    <div class="maan-news-tags">
                        <ul>
                             @foreach($categories as $category)
                                <li><a href="">{{ rawurldecode($category->name) }}</a></li>
                            @endforeach


                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="maan-title">
                        <div class="maan-title-text">
                            <h2>{{ __("Contact Us") }}</h2>
                        </div>
                    </div>

                    <div class="maan-email">
                        <h4>Subscribe to Our Newsletter!</h4>

                    </div>
                </div>
            </div>
            <div class="maan-main-footer">
                @if($siteInfo['is_publish_copyright'] == 1)
                    <h6>{{ $siteInfo['copyright'] }}</h6>
                @endif
            </div>
        </div>
    </section>
</footer>


