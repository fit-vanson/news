@extends('layouts.backend')

@section('title', $datalist['title_row'])

@section('content')
<!-- main Section -->
<div class="main-body">
	<div class="container-fluid">

		<div class="row mt-25">
			<div class="col-lg-12">
				<div class="card">
                    @include('backend.partials.theme_options_card_header')

					<div class="card-body tabs-area p-0">
						@include('backend.partials.theme_options_tabs_nav')
						<div class="tabs-body">
							<!--Data Entry Form-->
							<form novalidate="" data-validate="parsley" id="DataEntry_formId">
                                <input value="{{ $datalist['id'] }}" type="text" name="site_id" id="site_id" class="dnone">






								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="about_desc">{{ __('Header Code') }}</label>
                                            <textarea name="header_code" id="header_code" class="form-control" rows="8">{{ $datalist['header_code'] }}</textarea>
										</div>
									</div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="about_desc">{{ __('Header Ads') }}</label>
                                            <textarea name="header_ads" id="header_ads" class="form-control" rows="8">{{ $datalist['header_ads'] }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="about_desc">{{ __('Sidebar Ads') }}</label>
                                            <textarea name="sidebar_ads" id="sidebar_ads" class="form-control" rows="8">{{ $datalist['sidebar_ads'] }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="about_desc">{{ __('Before Ads') }}</label>
                                            <textarea name="before_ads" id="before_ads" class="form-control" rows="8">{{ $datalist['before_ads'] }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="about_desc">{{ __('After Ads') }}</label>
                                            <textarea name="after_ads" id="after_ads" class="form-control" rows="8">{{ $datalist['after_ads'] }}</textarea>
                                        </div>
                                    </div>



								</div>



								<div class="row tabs-footer mt-15">
									<div class="col-lg-12">
										<a id="submit-form" href="javascript:void(0);" class="btn blue-btn">{{ __('Save') }}</a>
									</div>
								</div>
							</form>
							<!--/Data Entry Form/-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /main Section -->

<!--Global Media-->
{{--@include('backend.partials.global_media')--}}
<!--/Global Media/-->

@endsection

@push('scripts')


<script src="{{asset('backend/pages/theme_option_ads_manage.js')}}"></script>

@endpush
