<main class="main {{ $PageVariation['home_variation'] }}">
	<!-- Home Slider -->
	@if($section1->is_publish == 1)
	<section class="slider-section">
		<div class="home-slider owl-carousel">
			<!-- Slider Item -->
			@foreach ($slider as $row)
			@php $aRow = json_decode($row->desc); @endphp
			<div class="single-slider">
				<div class="slider-screen h1-height" style="background-image: url({{ asset('media/'.$row->image) }});">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-5">
								<div class="slider-content">
									<h1>{{ $row->title }}</h1>
									@if($aRow->sub_title != '')
									<p class="relative">{{ $aRow->sub_title }}</p>
									@endif

									@if($aRow->button_text != '')
									<a href="{{ $row->url }}" class="btn theme-btn" {{ $aRow->target =='' ? '' : "target=".$aRow->target }}>{{ $aRow->button_text }}</a>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			<!-- /Slider Item/ -->
		</div>
	</section>
	@endif
	<!-- /Home Slider/ -->

	<!-- Offer Section -->
	@if($section4->is_publish == 1)
	@if(count($offer_ad_position1)>0)
    @if($section4->pivot)
    <section class="section offer-section" style="background-image: url({{ $section4->pivot->image ? asset('media/'.$section4->pivot->image) : '' }});">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-heading">
						@if($section4->pivot->desc !='')
						<h5>{{ $section4->pivot->desc }}</h5>
						@endif

						@if($section4->pivot->title !='')
						<h2>{{ $section4->pivot->title }}</h2>
						@endif
					</div>
				</div>
			</div>
    @else
    <section class="section offer-section" style="background-image: url({{ $section4->image ? asset('media/'.$section4->image) : '' }});">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        @if($section4->desc !='')
                            <h5>{{ $section4->desc }}</h5>
                        @endif

                        @if($section4->title !='')
                            <h2>{{ $section4->title }}</h2>
                        @endif
                    </div>
                </div>
            </div>
    @endif
        <div class="row owl-carousel caro-common offer-carousel">
            @foreach ($offer_ad_position1 as $row)
            @php $aRow = json_decode($row->desc); @endphp
            <div class="col-lg-4" style="width: 200%">
                <div class="offer-card" style="background:{{ $aRow->bg_color == '' ? '#daeac5' : $aRow->bg_color }};">
                    @if($aRow->text_1 != '')
                    <div class="offer-heading">
                        <h2>{{ $aRow->text_1 }}</h2>
                    </div>
                    @endif
                    @if($aRow->text_1 != '')
                    <div class="offer-body">
                        <p>{{ $aRow->text_2 }}</p>
                    </div>
                    @endif
                    <div class="offer-footer">
                        @if($aRow->button_text != '')
                        <a href="{{ $row->url }}" class="btn theme-btn" {{ $aRow->target =='' ? '' : "target=".$aRow->target }}>{{ $aRow->button_text }}</a>
                        @endif
                        <div class="offer-image">
                            <img src="{{ asset('media/'.$row->image) }}" alt="{{ $aRow->text_1 }}" />
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
		</div>
	</section>
	@endif
	@endif
	<!-- /Offer Section/ -->

	<!-- Featured Categories -->
	@if($section2->is_publish == 1)
        @if($section2->pivot)
        <section class="section" style="background-image: url({{ $section2->pivot->image ? asset('media/'.$section2->pivot->image) : '' }});">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading">
                            @if($section2->pivot->desc !='')
                            <h5>{{ $section2->pivot->desc }}</h5>
                            @endif

                            @if($section2->pivot->title !='')
                            <h2>{{ $section2->pivot->title }}</h2>
                            @endif
                        </div>
                    </div>
                </div>
        @else
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-heading">
                                @if($section2->desc !='')
                                    <h5>{{ $section2->desc }}</h5>
                                @endif

                                @if($section2->title !='')
                                    <h2>{{ $section2->title }}</h2>
                                @endif
                            </div>
                        </div>
                    </div>
        @endif
			<div class="row owl-carousel caro-common featured-categories">
				@foreach ($pro_category as $row)
				<div class="col-lg-12">
					<div class="featured-card">
						<div class="featured-image">
							<a href="{{ route('frontend.product-category', [$row->id, $row->slug]) }}">
								<img src="{{ asset('media/'.$row->thumbnail) }}" alt="{{ $row->name }}" />
							</a>
						</div>
						<div class="featured-title">
							<a href="{{ route('frontend.product-category', [$row->id, $row->slug]) }}">{{ $row->name }}</a>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	@endif
	<!-- /Featured Categories/ -->

	<!-- Deals Section -->
	@if($section6->is_publish == 1)
	<section class="section deals-section">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section-heading">
                        @if($section6->pivot)
                            @if($section6->pivot->desc !='')
                            <h5>{{ $section6->pivot->desc }}</h5>
                            @endif

                            @if($section6->pivot->title !='')
                            <h2>{{ $section6->pivot->title }}</h2>
                            @endif
                        @else
                            @if($section6->desc !='')
                                <h5>{{ $section6->desc }}</h5>
                            @endif

                            @if($section6->title !='')
                                <h2>{{ $section6->title }}</h2>
                            @endif
                        @endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="row owl-carousel caro-common deals-carousel-box">
						@foreach ($deals_products as $row)
						<div class="col-lg-12">
							<div class="item-card">
								<div class="item-image">
									@if(($row->is_discount == 1) && ($row->old_price !=''))
										@php
											$discount = number_format((($row->old_price - $row->sale_price)*100)/$row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']);
										@endphp
									<span class="item-label">{{ $discount }}% {{ __('Off') }}</span>
									@endif
									<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">
										<img src="{{ asset('media/'.$row->f_thumbnail) }}" alt="{{ $row->title }}" />
									</a>
									@if(($row->is_discount == 1) && ($row->end_date !=''))
									<div class="deals-countdown-card">
										<div data-countdown="{{ date('Y/m/d', strtotime($row->end_date)) }}" class="deals-countdown"></div>
									</div>
									@endif
								</div>
								<div class="item-title">
									<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">{{ str_limit($row->title) }}</a>
								</div>
								<div class="rating-wrap">
									<div class="stars-outer">
										<div class="stars-inner" style="width:{{ $row->ReviewPercentage }}%;"></div>
									</div>
									<span class="rating-count">({{ $row->TotalReview }})</span>
								</div>
{{--								<div class="item-sold">--}}
{{--									{{ __('Sold By') }} <a href="{{ route('frontend.stores', [$row->seller_id, str_slug($row->shop_url)]) }}">{{ str_limit($row->shop_name) }}</a>--}}
{{--								</div>--}}
								<div class="item-pric-card">
									@if($row->sale_price != '')
										@if($gtext['currency_position'] == 'left')
										<div class="new-price">{{ $gtext['currency_icon'] }}{{ number_format($row->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
										@else
										<div class="new-price">{{ number_format($row->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
										@endif
									@endif
									@if(($row->is_discount == 1) && ($row->old_price !=''))
										@if($gtext['currency_position'] == 'left')
										<div class="old-price">{{ $gtext['currency_icon'] }}{{ number_format($row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
										@else
										<div class="old-price">{{ number_format($row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
										@endif
									@endif
								</div>
								<div class="item-card-bottom">
									<a data-id="{{ $row->id }}" href="javascript:void(0);" class="btn add-to-cart addtocart">{{ __('Add To Cart') }}</a>
									<ul class="item-cart-list">
										<li><a class="addtowishlist" data-id="{{ $row->id }}" href="javascript:void(0);"><i class="bi bi-heart"></i></a></li>
										<li><a href="{{ route('frontend.product', [$row->id, $row->slug]) }}"><i class="bi bi-eye"></i></a></li>
									</ul>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>
	@endif
	<!-- /Deals Section/ -->

	<!-- Popular Products -->
	@if($section3->is_publish == 1)
	<section class="section product-section">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section-heading">
                        @if(isset($section2->pivot))
                            @if($section3->pivot->desc !='')
                                <h5>{{ $section3->pivot->desc }}</h5>
                            @endif

                            @if($section3->pivot->title !='')
                                <h2>{{ $section3->pivot->title }}</h2>
                            @endif
                        @else
                            @if($section3->desc !='')
                                <h5>{{ $section3->desc }}</h5>
                            @endif

                            @if($section3->title !='')
                                <h2>{{ $section3->pivot->title }}</h2>
                            @endif
                        @endif
					</div>
				</div>
			</div>
			<div class="row owl-carousel caro-common category-carousel">
				@foreach ($popular_products as $row)
				<div class="col-lg-12">
					<div class="item-card">
						<div class="item-image">
							@if(($row->is_discount == 1) && ($row->old_price !=''))
								@php
									$discount = number_format((($row->old_price - $row->sale_price)*100)/$row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']);
								@endphp
							<span class="item-label">{{ $discount }}% {{ __('Off') }}</span>
							@endif
							<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">
								<img src="{{ asset('media/'.$row->f_thumbnail) }}" alt="{{ $row->title }}" />
							</a>
						</div>
						<div class="item-title">
							<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">{{ str_limit($row->title) }}</a>
						</div>
						<div class="rating-wrap">
							<div class="stars-outer">
								<div class="stars-inner" style="width:{{ $row->ReviewPercentage }}%;"></div>
							</div>
							<span class="rating-count">({{ $row->TotalReview }})</span>
						</div>
{{--						<div class="item-sold">--}}
{{--							{{ __('Sold By') }} <a href="{{ route('frontend.stores', [$row->seller_id, str_slug($row->shop_url)]) }}">{{ str_limit($row->shop_name) }}</a>--}}
{{--						</div>--}}
						<div class="item-pric-card">
							@if($row->sale_price != '')
								@if($gtext['currency_position'] == 'left')
								<div class="new-price">{{ $gtext['currency_icon'] }}{{ number_format($row->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
								@else
								<div class="new-price">{{ number_format($row->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
							@if(($row->is_discount == 1) && ($row->old_price !=''))
								@if($gtext['currency_position'] == 'left')
								<div class="old-price">{{ $gtext['currency_icon'] }}{{ number_format($row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
								@else
								<div class="old-price">{{ number_format($row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
						</div>
						<div class="item-card-bottom">
							<a data-id="{{ $row->id }}" href="javascript:void(0);" class="btn add-to-cart addtocart">{{ __('Add To Cart') }}</a>
							<ul class="item-cart-list">
								<li><a class="addtowishlist" data-id="{{ $row->id }}" href="javascript:void(0);"><i class="bi bi-heart"></i></a></li>
								<li><a href="{{ route('frontend.product', [$row->id, $row->slug]) }}"><i class="bi bi-eye"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	@endif
	<!-- /Popular Products/ -->

	<!-- New Products -->
	@if($section8->is_publish == 1)
	<section class="section product-section">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section-heading">
                        @if($section8->pivot)
                            @if($section8->pivot->desc !='')
                            <h5>{{ $section8->pivot->desc }}</h5>
                            @endif

                            @if($section8->pivot->title !='')
                            <h2>{{ $section8->pivot->title }}</h2>
                            @endif
                        @else
                            @if($section8->desc !='')
                                <h5>{{ $section8->desc }}</h5>
                            @endif

                            @if($section8->title !='')
                                <h2>{{ $section8->title }}</h2>
                            @endif
                        @endif
					</div>
				</div>
			</div>
			<div class="row owl-carousel caro-common category-carousel">
				@foreach ($new_products as $row)
				<div class="col-lg-12">
					<div class="item-card">
						<div class="item-image">
							@if(($row->is_discount == 1) && ($row->old_price !=''))
								@php
									$discount = number_format((($row->old_price - $row->sale_price)*100)/$row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']);
								@endphp
							<span class="item-label">{{ $discount }}% {{ __('Off') }}</span>
							@endif
							<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">
								<img src="{{ asset('media/'.$row->f_thumbnail) }}" alt="{{ $row->title }}" />
							</a>
						</div>
						<div class="item-title">
							<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">{{ str_limit($row->title) }}</a>
						</div>
						<div class="rating-wrap">
							<div class="stars-outer">
								<div class="stars-inner" style="width:{{ $row->ReviewPercentage }}%;"></div>
							</div>
							<span class="rating-count">({{ $row->TotalReview }})</span>
						</div>
{{--						<div class="item-sold">--}}
{{--							{{ __('Sold By') }} <a href="{{ route('frontend.stores', [$row->seller_id, str_slug($row->shop_url)]) }}">{{ str_limit($row->shop_name) }}</a>--}}
{{--						</div>--}}
						<div class="item-pric-card">
							@if($row->sale_price != '')
								@if($gtext['currency_position'] == 'left')
								<div class="new-price">{{ $gtext['currency_icon'] }}{{ number_format($row->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
								@else
								<div class="new-price">{{ number_format($row->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
							@if(($row->is_discount == 1) && ($row->old_price !=''))
								@if($gtext['currency_position'] == 'left')
								<div class="old-price">{{ $gtext['currency_icon'] }}{{ number_format($row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
								@else
								<div class="old-price">{{ number_format($row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
						</div>
						<div class="item-card-bottom">
							<a data-id="{{ $row->id }}" href="javascript:void(0);" class="btn add-to-cart addtocart">{{ __('Add To Cart') }}</a>
							<ul class="item-cart-list">
								<li><a class="addtowishlist" data-id="{{ $row->id }}" href="javascript:void(0);"><i class="bi bi-heart"></i></a></li>
								<li><a href="{{ route('frontend.product', [$row->id, $row->slug]) }}"><i class="bi bi-eye"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	@endif
	<!-- /New Products/ -->

	<!-- Top Selling Products -->
	@if($section9->is_publish == 1)
	<section class="section product-section">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section-heading">
                        @if($section9->pivot)
                            @if($section9->pivot->desc !='')
                            <h5>{{ $section9->pivot>desc }}</h5>
                            @endif

                            @if($section9->pivot->title !='')
                            <h2>{{ $section9->pivot->title }}</h2>
                            @endif
                        @else
                            @if($section9->desc !='')
                                <h5>{{ $section9->desc }}</h5>
                            @endif

                            @if($section9->title !='')
                                <h2>{{ $section9->title }}</h2>
                            @endif
                        @endif
					</div>
				</div>
			</div>
			<div class="row owl-carousel caro-common category-carousel">
				@foreach ($top_selling as $row)
				<div class="col-lg-12">
					<div class="item-card">
						<div class="item-image">
							@if(($row->is_discount == 1) && ($row->old_price !=''))
								@php
									$discount = number_format((($row->old_price - $row->sale_price)*100)/$row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']);
								@endphp
							<span class="item-label">{{ $discount }}% {{ __('Off') }}</span>
							@endif
							<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">
								<img src="{{ asset('media/'.$row->f_thumbnail) }}" alt="{{ $row->title }}" />
							</a>
						</div>
						<div class="item-title">
							<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">{{ str_limit($row->title) }}</a>
						</div>
						<div class="rating-wrap">
							<div class="stars-outer">
								<div class="stars-inner" style="width:{{ $row->ReviewPercentage }}%;"></div>
							</div>
							<span class="rating-count">({{ $row->TotalReview }})</span>
						</div>
{{--						<div class="item-sold">--}}
{{--							{{ __('Sold By') }} <a href="{{ route('frontend.stores', [$row->seller_id, str_slug($row->shop_url)]) }}">{{ str_limit($row->shop_name) }}</a>--}}
{{--						</div>--}}
						<div class="item-pric-card">
							@if($row->sale_price != '')
								@if($gtext['currency_position'] == 'left')
								<div class="new-price">{{ $gtext['currency_icon'] }}{{ number_format($row->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
								@else
								<div class="new-price">{{ number_format($row->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
							@if(($row->is_discount == 1) && ($row->old_price !=''))
								@if($gtext['currency_position'] == 'left')
								<div class="old-price">{{ $gtext['currency_icon'] }}{{ number_format($row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
								@else
								<div class="old-price">{{ number_format($row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
						</div>
						<div class="item-card-bottom">
							<a data-id="{{ $row->id }}" href="javascript:void(0);" class="btn add-to-cart addtocart">{{ __('Add To Cart') }}</a>
							<ul class="item-cart-list">
								<li><a class="addtowishlist" data-id="{{ $row->id }}" href="javascript:void(0);"><i class="bi bi-heart"></i></a></li>
								<li><a href="{{ route('frontend.product', [$row->id, $row->slug]) }}"><i class="bi bi-eye"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	@endif
	<!-- /Top Selling Products/ -->

	<!-- Trending Products -->
	@if($section10->is_publish == 1)
	<section class="section product-section">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section-heading">
                        @if($section10->pivot)
                            @if($section10->pivot->desc !='')
                            <h5>{{ $section10->pivot->desc }}</h5>
                            @endif

                            @if($section10->pivot->title !='')
                            <h2>{{ $section10->pivot->title }}</h2>
                            @endif
                        @else
                            @if($section10->desc !='')
                                <h5>{{ $section10->desc }}</h5>
                            @endif

                            @if($section10->title !='')
                                <h2>{{ $section10->title }}</h2>
                            @endif
                        @endif
					</div>
				</div>
			</div>
			<div class="row owl-carousel caro-common category-carousel">
				@foreach ($trending_products as $row)
				<div class="col-lg-12">
					<div class="item-card">
						<div class="item-image">
							@if(($row->is_discount == 1) && ($row->old_price !=''))
								@php
									$discount = number_format((($row->old_price - $row->sale_price)*100)/$row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']);
								@endphp
							<span class="item-label">{{ $discount }}% {{ __('Off') }}</span>
							@endif
							<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">
								<img src="{{ asset('media/'.$row->f_thumbnail) }}" alt="{{ $row->title }}" />
							</a>
						</div>
						<div class="item-title">
							<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">{{ str_limit($row->title) }}</a>
						</div>
						<div class="rating-wrap">
							<div class="stars-outer">
								<div class="stars-inner" style="width:{{ $row->ReviewPercentage }}%;"></div>
							</div>
							<span class="rating-count">({{ $row->TotalReview }})</span>
						</div>
{{--						<div class="item-sold">--}}
{{--							{{ __('Sold By') }} <a href="{{ route('frontend.stores', [$row->seller_id, str_slug($row->shop_url)]) }}">{{ str_limit($row->shop_name) }}</a>--}}
{{--						</div>--}}
						<div class="item-pric-card">
							@if($row->sale_price != '')
								@if($gtext['currency_position'] == 'left')
								<div class="new-price">{{ $gtext['currency_icon'] }}{{ number_format($row->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
								@else
								<div class="new-price">{{ number_format($row->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
							@if(($row->is_discount == 1) && ($row->old_price !=''))
								@if($gtext['currency_position'] == 'left')
								<div class="old-price">{{ $gtext['currency_icon'] }}{{ number_format($row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
								@else
								<div class="old-price">{{ number_format($row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
						</div>
						<div class="item-card-bottom">
							<a data-id="{{ $row->id }}" href="javascript:void(0);" class="btn add-to-cart addtocart">{{ __('Add To Cart') }}</a>
							<ul class="item-cart-list">
								<li><a class="addtowishlist" data-id="{{ $row->id }}" href="javascript:void(0);"><i class="bi bi-heart"></i></a></li>
								<li><a href="{{ route('frontend.product', [$row->id, $row->slug]) }}"><i class="bi bi-eye"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	@endif
	<!-- /Trending Products/ -->

	<!-- Video Section -->
	@if($home_video['is_publish'] == 1)
	<section class="section video-section" style="background-image: url({{ asset('media/'.$home_video['image']) }});">
		<div class="container">
			<div class="row justify-content-start">
				<div class="col-xl-7 text-center">
					<div class="video-card">
						<a href="{{ $home_video['video_url'] }}" class="play-icon popup-video">
							<i class="bi bi-play-fill"></i>
						</a>
					</div>
				</div>
				<div class="col-xl-5">
					<div class="video-desc">
						<h1>{{ $home_video['title'] }}</h1>
						@if($home_video['short_desc'] !='')
						<p>{{ $home_video['short_desc'] }}</p>
						@endif
						<a href="{{ $home_video['url'] }}" {{ $home_video['target'] =='' ? '' : "target=".$home_video['target'] }} class="btn theme-btn">{{ $home_video['button_text'] }}</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	@endif
	<!-- /Video Section/ -->

	<!-- Top Rated Products -->
	@if($section11->is_publish == 1)
	<section class="section product-section">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section-heading">

                        @if($section11->pivot)
                            @if($section11->pivot->desc !='')
                                <h5>{{ $section11->pivot->desc }}</h5>
                            @endif

                            @if($section11->pivot->title !='')
                                <h2>{{ $section11->pivot->title }}</h2>
                            @endif
                        @else
                            @if($section11->desc !='')
                                <h5>{{ $section11->desc }}</h5>
                            @endif

                            @if($section11->title !='')
                                <h2>{{ $section10->title }}</h2>
                            @endif
                        @endif
					</div>
				</div>
			</div>
			<div class="row owl-carousel caro-common category-carousel">
				@foreach ($top_rated as $row)
				<div class="col-lg-12">
					<div class="item-card">
						<div class="item-image">
							@if(($row->is_discount == 1) && ($row->old_price !=''))
								@php
									$discount = number_format((($row->old_price - $row->sale_price)*100)/$row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']);
								@endphp
							<span class="item-label">{{ $discount }}% {{ __('Off') }}</span>
							@endif
							<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">
								<img src="{{ asset('media/'.$row->f_thumbnail) }}" alt="{{ $row->title }}" />
							</a>
						</div>
						<div class="item-title">
							<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}">{{ str_limit($row->title) }}</a>
						</div>
						<div class="rating-wrap">
							<div class="stars-outer">
								<div class="stars-inner" style="width:{{ $row->ReviewPercentage }}%;"></div>
							</div>
							<span class="rating-count">({{ $row->TotalReview }})</span>
						</div>
{{--						<div class="item-sold">--}}
{{--							{{ __('Sold By') }} <a href="{{ route('frontend.stores', [$row->seller_id, str_slug($row->shop_url)]) }}">{{ str_limit($row->shop_name) }}</a>--}}
{{--						</div>--}}
						<div class="item-pric-card">
							@if($row->sale_price != '')
								@if($gtext['currency_position'] == 'left')
								<div class="new-price">{{ $gtext['currency_icon'] }}{{ number_format($row->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
								@else
								<div class="new-price">{{ number_format($row->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
							@if(($row->is_discount == 1) && ($row->old_price !=''))
								@if($gtext['currency_position'] == 'left')
								<div class="old-price">{{ $gtext['currency_icon'] }}{{ number_format($row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
								@else
								<div class="old-price">{{ number_format($row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
						</div>
						<div class="item-card-bottom">
							<a data-id="{{ $row->id }}" href="javascript:void(0);" class="btn add-to-cart addtocart">{{ __('Add To Cart') }}</a>
							<ul class="item-cart-list">
								<li><a class="addtowishlist" data-id="{{ $row->id }}" href="javascript:void(0);"><i class="bi bi-heart"></i></a></li>
								<li><a href="{{ route('frontend.product', [$row->id, $row->slug]) }}"><i class="bi bi-eye"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
	@endif
	<!-- /Top Rated Products/ -->
</main>
