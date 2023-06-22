@extends('layouts.backend')

@section('title', __('Page Variation'))

@section('content')
<!-- main Section -->
<div class="main-body">
	<div class="container-fluid">
		@php $vipc = vipc(); @endphp
		@if($vipc['bkey'] == 0)
		@include('backend.partials.vipc')
		@else
		<div class="row mt-25">
			<div class="col-lg-12">
				<div class="card">
                    @include('backend.partials.theme_options_card_header')

                    <div class="card-body tabs-area p-0">
						@include('backend.partials.theme_options_tabs_nav')
						<div class="tabs-body">
							<div class="divider_heading">{{ __('Homepage Variation') }}</div>
							<div class="row">
								<div class="col-lg-3 mb-30">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/home-1.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">Home Page 1</div>
											<a id="home_variation_home_1" onclick="onHomepageVariations('home_1', 'home')" href="javascript:void(0);" class="active-btn home_variation {{ $datalist['home_variation'] =='home_1' ? 'active' : '' }}">{{ $datalist['home_variation'] =='home_1' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>
								<div class="col-lg-3 mb-30">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/home-2.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">Home Page 2</div>
											<a id="home_variation_home_2" onclick="onHomepageVariations('home_2', 'home')" href="javascript:void(0);" class="active-btn home_variation {{ $datalist['home_variation'] =='home_2' ? 'active' : '' }}">{{ $datalist['home_variation'] =='home_2' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>

								<div class="col-lg-3 mb-30">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/home-3.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">Home Page 3</div>
											<a id="home_variation_home_3" onclick="onHomepageVariations('home_3', 'home')" href="javascript:void(0);" class="active-btn home_variation {{ $datalist['home_variation'] =='home_3' ? 'active' : '' }}">{{ $datalist['home_variation'] =='home_3' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>
								<div class="col-lg-3 mb-30">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/home-4.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">Home Page 4</div>
											<a id="home_variation_home_4" onclick="onHomepageVariations('home_4', 'home')" href="javascript:void(0);" class="active-btn home_variation {{ $datalist['home_variation'] =='home_4' ? 'active' : '' }}">{{ $datalist['home_variation'] =='home_4' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>
							</div>

							<div class="divider_heading">{{ __('Category Page Variation') }}</div>
							<div class="row mb-30">
								<div class="col-lg-2">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/full_width.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">{{ __('Full width without sidebar') }}</div>
											<a id="category_page_full_width" onclick="onCategoryPageVariation('full_width', 'category')" href="javascript:void(0);" class="active-btn category_page {{ $datalist['category_variation'] =='full_width' ? 'active' : '' }}">{{ $datalist['category_variation'] =='full_width' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/left_sidebar.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">{{ __('Left Sidebar') }}</div>
											<a id="category_page_left_sidebar" onclick="onCategoryPageVariation('left_sidebar', 'category')" href="javascript:void(0);" class="active-btn category_page {{ $datalist['category_variation'] =='left_sidebar' ? 'active' : '' }}">{{ $datalist['category_variation'] =='left_sidebar' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/right_sidebar.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">{{ __('Right Sidebar') }}</div>
											<a id="category_page_right_sidebar" onclick="onCategoryPageVariation('right_sidebar', 'category')" href="javascript:void(0);" class="active-btn category_page {{ $datalist['category_variation'] =='right_sidebar' ? 'active' : '' }}">{{ $datalist['category_variation'] =='right_sidebar' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>
								<div class="col-lg-6"></div>
							</div>

							<div class="divider_heading">{{ __('Brand Page Variation') }}</div>
							<div class="row mb-30">
								<div class="col-lg-2">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/full_width.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">{{ __('Full width without sidebar') }}</div>
											<a id="brand_page_full_width" onclick="onBrandPageVariation('full_width', 'brand')" href="javascript:void(0);" class="active-btn brand_page {{ $datalist['brand_variation'] =='full_width' ? 'active' : '' }}">{{ $datalist['brand_variation'] =='full_width' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/left_sidebar.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">{{ __('Left Sidebar') }}</div>
											<a id="brand_page_left_sidebar" onclick="onBrandPageVariation('left_sidebar', 'brand')" href="javascript:void(0);" class="active-btn brand_page {{ $datalist['brand_variation'] =='left_sidebar' ? 'active' : '' }}">{{ $datalist['brand_variation'] =='left_sidebar' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/right_sidebar.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">{{ __('Right Sidebar') }}</div>
											<a id="brand_page_right_sidebar" onclick="onBrandPageVariation('right_sidebar', 'brand')" href="javascript:void(0);" class="active-btn brand_page {{ $datalist['brand_variation'] =='right_sidebar' ? 'active' : '' }}">{{ $datalist['brand_variation'] =='right_sidebar' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>
								<div class="col-lg-6"></div>
							</div>

							<div class="divider_heading">{{ __('Seller Page Variation') }}</div>
							<div class="row">
								<div class="col-lg-2">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/full_width.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">{{ __('Full width without sidebar') }}</div>
											<a id="seller_page_full_width" onclick="onSellerPageVariation('full_width', 'seller')" href="javascript:void(0);" class="active-btn seller_page {{ $datalist['seller_variation'] =='full_width' ? 'active' : '' }}">{{ $datalist['seller_variation'] =='full_width' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/left_sidebar.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">{{ __('Left Sidebar') }}</div>
											<a id="seller_page_left_sidebar" onclick="onSellerPageVariation('left_sidebar', 'seller')" href="javascript:void(0);" class="active-btn seller_page {{ $datalist['seller_variation'] =='left_sidebar' ? 'active' : '' }}">{{ $datalist['seller_variation'] =='left_sidebar' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="theme-view-card">
										<div class="theme-image">
											<img src="{{asset('backend/images/right_sidebar.jpg')}}" />
										</div>
										<div class="theme-footer">
											<div class="theme-title">{{ __('Right Sidebar') }}</div>
											<a id="seller_page_right_sidebar" onclick="onSellerPageVariation('right_sidebar', 'seller')" href="javascript:void(0);" class="active-btn seller_page {{ $datalist['seller_variation'] =='right_sidebar' ? 'active' : '' }}">{{ $datalist['seller_variation'] =='right_sidebar' ? __('Activated') : __('Activate') }}</a>
										</div>
									</div>
								</div>
								<div class="col-lg-6"></div>
							</div>


							<input id="home_page_variation" type="hidden" class="dnone" value="{{ $datalist['home_variation'] }}" />
							<input id="site_id" type="hidden" class="dnone" value="{{ $datalist['id'] }}" />
							<input id="category_page_variation" type="hidden" class="dnone" value="{{ $datalist['category_variation'] }}" />
							<input id="brand_page_variation" type="hidden" class="dnone" value="{{ $datalist['brand_variation'] }}" />
							<input id="seller_page_variation" type="hidden" class="dnone" value="{{ $datalist['seller_variation'] }}" />

						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
<!-- /main Section -->

@endsection

@push('scripts')
<!-- css/js -->
<script type="text/javascript">
var Activated = "{{ __('Activated') }}";
var Activate = "{{ __('Activate') }}";
</script>
<script src="{{asset('backend/pages/page_variation.js')}}"></script>
@endpush
