@extends('layouts.frontend')

@section('title', $data->title)
@php
    $gtext = gtext();
    $title_short = str_limit($data->title);
@endphp

@section('meta-content')
	<meta name="keywords" content="{{ $data->og_keywords }}" />
	<meta name="description" content="{{ $data->og_description ? $data->og_description : $data->short_desc }}" />
	<meta property="og:title" content="{{ $data->og_title ? $data->og_title : $data->title }}" />
	<meta property="og:site_name" content="{{ $gtext['site_name'] }}" />
	<meta property="og:description" content="{{ $data->og_description ? $data->og_description : $data->short_desc }}" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="{{ url()->current() }}" />
	<meta property="og:image" content="{{ $data->og_image ? asset('media/'.$data->og_image) : asset('media/'.$data->f_thumbnail) }}" />
	<meta property="og:image:width" content="600" />
	<meta property="og:image:height" content="315" />
	@if($gtext['fb_publish'] == 1)
	<meta name="fb:app_id" property="fb:app_id" content="{{ $gtext['fb_app_id'] }}" />
	@endif
	<meta name="twitter:card" content="summary_large_image">
	@if($gtext['twitter_publish'] == 1)
	<meta name="twitter:site" content="{{ $gtext['twitter_id'] }}">
	<meta name="twitter:creator" content="{{ $gtext['twitter_id'] }}">
	@endif
	<meta name="twitter:url" content="{{ url()->current() }}">
	<meta name="twitter:title" content="{{ $data->og_title ? $data->og_title : $data->title }}">
	<meta name="twitter:description" content="{{ $data->og_description ? $data->og_description : $data->short_desc }}">
	<meta name="twitter:image" content="{{ $data->og_image ? asset('media/'.$data->og_image) : asset('media/'.$data->f_thumbnail) }}">
@endsection

@section('header')
@include('frontend.partials.header')
@endsection

@section('content')

<main class="main">
	<!-- Page Breadcrumb -->
	<div class="breadcrumb-section">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-3">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
							<li class="breadcrumb-item active" aria-current="page" title="{{ $data->title }}">{{ $title_short}}</li>
						</ol>
					</nav>
				</div>
				<div class="col-lg-9">
					<div class="page-title">
						<h1>{{ $data->title }}</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Page Breadcrumb/ -->

	<!-- Inner Section -->
	<section class="inner-section inner-section-bg">
		<div class="container">
			<div class="row">
				<div class="col-xl-5">
					<div class="product-details-slider pd-slider-for">
                        <div class="item">
                            <img src="{{ asset('media/'.$data->f_thumbnail) }}" alt="{{ $data->title }}" />
                        </div>
						@if(count($pro_images)>0)
                            @foreach ($pro_images as $key => $row)
                            <div class="item">
                                <img src="{{ asset('media/'.$row->large_image) }}" alt="{{ $key }}" />
                            </div>
                            @endforeach

						@endif
					</div>
					<div class="thumbnail-card pd-slider-nav">
                        <img src="{{ asset('media/'.$data->f_thumbnail) }}" alt="{{ $data->title }}" />
						@if(count($pro_images)>0)
                            @foreach ($pro_images as $key => $row)
                            <img src="{{ asset('media/'.$row->thumbnail) }}" alt="{{ $key }}" />
                            @endforeach
						@endif
					</div>
				</div>
				<div class="col-xl-7">
					<div class="pr_details">
						<h4 class="product_title">{{ $data->title }}</h4>
						@if($data->short_desc != '')
						<p>{!!   $data->short_desc !!}</p>
						@endif
						<div class="product_price">
							@if($data->sale_price != '')
								@if($gtext['currency_position'] == 'left')
								<div class="item-price">{{ $gtext['currency_icon'] }}{{ number_format($data->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div>
								@else
								<div class="item-price">{{ number_format($data->sale_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div>
								@endif
							@endif
							@if(($data->is_discount == 1) && ($data->old_price !=''))
								@php
									$discount = number_format((($data->old_price - $data->sale_price)*100)/$data->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']);
								@endphp

								@if($gtext['currency_position'] == 'left')
								<div class="old-item-price">{{ $gtext['currency_icon'] }}{{ number_format($data->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}</div><span class="discount">-{{ $discount }}%</span>
								@else
								<div class="old-item-price">{{ number_format($data->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']) }}{{ $gtext['currency_icon'] }}</div><span class="discount">-{{ $discount }}%</span>
								@endif
							@endif
						</div>
						@if($data->variation_size != '')
						<div class="pr_widget">
							<label class="widget-title">{{ __('Unit') }}</label>
							<ul class="widget-size">
								<li class="unit active">{{ $data->variation_size }}</li>
							</ul>
						</div>
						@endif
						<div class="pr_quantity">
							<label for="quantity">{{ __('Quantity') }}</label>
							<input name="quantity" id="quantity" type="number" min="1" max="{{ $data->is_stock == 1 ? $data->stock_qty : 999 }}" value="1">
						</div>
						<div class="pr_buy_cart">
							<a class="btn theme-btn cart product_addtocart" data-id="{{ $data->id }}" data-stockqty="{{ $data->is_stock == 1 ? $data->stock_qty : 999 }}" href="javascript:void(0);">{{ __('Add To Cart') }}</a>
							<a class="btn theme-btn cart product_buy_now" data-id="{{ $data->id }}" data-stockqty="{{ $data->is_stock == 1 ? $data->stock_qty : 999 }}" href="javascript:void(0);">{{ __('Buy Now') }}</a>
							<a class="btn theme-btn cart wishlist addtowishlist" data-id="{{ $data->id }}" href="javascript:void(0);"><i class="bi bi-heart-fill"></i></a>
						</div>

						@if($data->is_stock == 1)
							@if($data->stock_status_id == 1)
							<div class="pr_extra"><strong>{{ __('Availability') }}:</strong><span class="instock">{{ $data->stock_qty }} {{ __('In Stock') }}</span></div>
							@else
							<div class="pr_extra"><strong>{{ __('Availability') }}:</strong><span class="stockout">{{ __('Out Of Stock') }}</span></div>
							@endif
						@endif
						@if($data->is_stock == 1)
							@if($data->sku != '')
							<div class="pr_extra"><strong>{{ __('SKU') }}:</strong>  {{ $data->sku }}</div>
							@endif
						@endif
						<div class="pr_extra"><strong>{{ __('Category') }}: </strong> <a href="{{ route('frontend.product-category', [$data->cat_id, $data->cat_slug]) }}">{{ $data->cat_name }}</a></div>

						<div class="pr_widget">
							<label class="widget-title">{{ __('Share this') }}</label>
							<div class="social-media">
								<a href="https://www.facebook.com/sharer/sharer.php?u={{ route('frontend.product', [$data->id, $data->slug]) }}" target="_blank"><i class="bi bi-facebook"></i></a>
								<a href="https://twitter.com/intent/tweet?text={{ $data->title }}&url={{ route('frontend.product', [$data->id, $data->slug]) }}" target="_blank"><i class="bi bi-twitter"></i></a>
								<a href="http://www.linkedin.com/shareArticle?mini=true&url={{ route('frontend.product', [$data->id, $data->slug]) }}&title={{ $data->title }}&summary={{ $data->short_desc }}" target="_blank"><i class="bi bi-linkedin"></i></a>
								<a href="https://wa.me/?text={{ route('frontend.product', [$data->id, $data->slug]) }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Product Description Review and Vendor -->
			<div class="row">
				<div class="col-lg-12">
					@if(Session::has('success'))
					<div class="alert alert-success">
						{{Session::get('success')}}
					</div>
					@endif

					@if(Session::has('fail'))
					<div class="alert alert-danger">
						{{Session::get('fail')}}
					</div>
					@endif

					@if($errors->any())
						<ul class="errors-list">
						@foreach($errors->all() as $error)
							<li>{{$error}}</li>
						@endforeach
						</ul>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="pr-description-review">
						<div class="desc-review-nav nav">
							<a class="active" href="#des_description" data-bs-toggle="tab">{{ __('Description') }}</a>
							<a href="#des_reviews" data-bs-toggle="tab">{{ __('Reviews') }} ({{ $data->TotalReview }})</a>
						</div>
						<div class="tab-content">
							<!-- Description -->
							<div id="des_description" class="tab-pane active">
								<div class="entry">
									{!! $data->description !!}
								</div>
							</div>
							<!-- /Description/ -->

							<!-- Review -->
							<div id="des_reviews" class="tab-pane">
								<div class="review-content">
									<!-- Review Form-->
									<div class="row">
										<div class="col-lg-6">
											<div class="review-form">
												<h4>{{ __('Submit your review') }}</h4>
												<p>Please <a href="{{ route('frontend.login') }}"><strong>login</strong></a> to write review!</p>
												<div class="form-product-review">
													<form class="form" method="POST" action="{{ route('frontend.saveReviews') }}">
														@csrf
														@if(isset(Auth::user()->name))
														<div class="mb-3">
															<textarea name="comments" placeholder="{{ __('Write comment') }}" class="form-control" rows="3"></textarea>
														</div>
														<div class="mb-3">
															<label for="rating" class="form-label">{{ __('Your rating of this product') }}</label>
															<select id="rating" name="rating" class="form-select form-select-sm">
																<option value="5">5 Star</option>
																<option value="4">4 Star</option>
																<option value="3">3 Star</option>
																<option value="2">2 Star</option>
																<option value="1">1 Star</option>
															</select>
														</div>
														<input name="item_id" type="hidden" value="{{ $data->id }}" />
														<button type="submit" class="btn theme-btn" >{{ __('Submit Review') }}</button>
														@else
														<div class="mb-3">
															<textarea name="comments" placeholder="{{ __('Write comment') }}" class="form-control" rows="3" disabled></textarea>
														</div>
														<a class="btn theme-btn" href="{{ route('frontend.login') }}"><i class="bi bi-box-arrow-in-right"></i> {{ __('Please Login') }}</a>
														@endif
													</form>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
										</div>
									</div>
									<!-- /Review Form/-->

									<!-- Product Review -->
									@if(count($pro_reviews)>0)
									<div class="row">
										<div class="col-lg-12">
											<div class="review-heading">
												<h4>{{ $data->TotalReview }} {{ __('reviews for') }} - {{ $data->title }}</h4>
											</div>
											<div id="tp_datalist">
												@include('frontend.partials.products-reviews-grid')
											</div>
										</div>
									</div>
									@endif
									<!-- /Product Review/ -->
								</div>
							</div>
							<!-- /Review/ -->
						</div>
					</div>
				</div>
			</div>
			<!-- /Product Description Review and Vendor/ -->
		</div>
	</section>
	<!-- /Inner Section/ -->

	<!-- Popular Products -->
	<section class="section product-section">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section-heading">
						<h2>{{ __('Related Products') }}</h2>
					</div>
				</div>
			</div>
			<div class="row owl-carousel caro-common category-carousel">
				@if(count($related_products)>0)
					@foreach ($related_products as $row)
					@php
						if(($row->is_discount == 1) && ($row->old_price !='')){
							$discount = number_format((($row->old_price - $row->sale_price)*100)/$row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']);
						}
					@endphp
					<div class="col-lg-12">
						<div class="item-card">
							<div class="item-image">
								@if(($row->is_discount == 1) && ($row->old_price !=''))
								<span class="item-label">{{ $discount }}% {{ __('Off') }}</span>
								@endif
								<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}"><img src="{{ asset('media/'.$row->f_thumbnail) }}" alt="{{ $row->title }}" /></a>
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
								<a class="btn add-to-cart addtocart" data-id="{{ $row->id }}" href="javascript:void(0);">{{ __('Add To Cart') }}</a>
								<ul class="item-cart-list">
									<li><a class="addtowishlist" data-id="{{ $row->id }}" href="javascript:void(0);"><i class="bi bi-heart"></i></a></li>
									<li><a href="{{ route('frontend.product', [$row->id, $row->slug]) }}"><i class="bi bi-eye"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
					@endforeach
				@else
					@foreach ($category_products as $row)
					@php
						if(($row->is_discount == 1) && ($row->old_price !='')){
							$discount = number_format((($row->old_price - $row->sale_price)*100)/$row->old_price,$gtext['decimal_digit'],$gtext['decimal_separator'],$gtext['thousands_separator']);
						}
					@endphp
					<div class="col-lg-12">
						<div class="item-card">
							<div class="item-image">
								@if(($row->is_discount == 1) && ($row->old_price !=''))
								<span class="item-label">{{ $discount }}% {{ __('Off') }}</span>
								@endif
								<a href="{{ route('frontend.product', [$row->id, $row->slug]) }}"><img src="{{ asset('media/'.$row->f_thumbnail) }}" alt="{{ $row->title }}" /></a>
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
								<a class="btn add-to-cart addtocart" data-id="{{ $row->id }}" href="javascript:void(0);">{{ __('Add To Cart') }}</a>
								<ul class="item-cart-list">
									<li><a class="addtowishlist" data-id="{{ $row->id }}" href="javascript:void(0);"><i class="bi bi-heart"></i></a></li>
									<li><a href="{{ route('frontend.product', [$row->id, $row->slug]) }}"><i class="bi bi-eye"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
					@endforeach
				@endif
			</div>
		</div>
	</section>
	<!-- /Popular Products/ -->
</main>

@endsection

@push('scripts')
<script type="text/javascript">
 	var item_id = "{{ $data->id }}";
	var is_stock = "{{ $data->is_stock }}";
	var is_stock_status = "{{ $data->stock_status_id }}";

var TEXT = [];
	TEXT['Please enter quantity.'] = "{{ __('Please enter quantity.') }}";
	TEXT['The value must be less than or equal to'] = "{{ __('The value must be less than or equal to') }} {{ $data->is_stock == 1 ? $data->stock_qty : '' }}";
	TEXT['This product out of stock.'] = "{{ __('This product out of stock.') }}";
</script>
<script src="{{asset('frontend/pages/product.js')}}"></script>
@endpush
