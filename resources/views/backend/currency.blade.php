@extends('layouts.backend')

@section('title', __('Currency'))
{{--
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
					<div class="card-header">
						<div class="row">
							<div class="col-lg-6">
								<span>{{ __('Currency') }}</span>
							</div>
							<div class="col-lg-6"></div>
						</div>
					</div>

					<!--Data Entry Form-->
					<div class="card-body">
						<form novalidate="" data-validate="parsley" id="DataEntry_formId">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="currency_name">{{ __('Currency Name') }}<span class="red">*</span></label>
										<input value="{{ $datalist['currency_name'] }}" type="text" name="currency_name" id="currency_name" class="form-control parsley-validated" data-required="true" placeholder="USD">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="currency_icon">{{ __('Currency Icon') }}<span class="red">*</span></label>
										<input value="{{ $datalist['currency_icon'] }}" type="text" name="currency_icon" id="currency_icon" class="form-control parsley-validated" data-required="true" placeholder="$">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="currency_position">{{ __('Currency Position') }}<span class="red">*</span></label>
										<select name="currency_position" id="currency_position" class="chosen-select form-control">
											<option {{ 'left' == $datalist['currency_position'] ? "selected=selected" : '' }} value="left">Left</option>
											<option {{ 'right' == $datalist['currency_position'] ? "selected=selected" : '' }} value="right">Right</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row tabs-footer mt-15">
								<div class="col-lg-12">
									<a id="submit-form" href="javascript:void(0);" class="btn blue-btn mr-10">{{ __('Save') }}</a>
								</div>
							</div>
						</form>
					</div>
					<!--/Data Entry Form/-->
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
<script src="{{asset('backend/pages/currency.js')}}"></script>
@endpush

--}}
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
                                    <!--Data Entry Form-->
                                    <form novalidate="" data-validate="parsley" id="DataEntry_formId">
                                        <input value="{{ $datalist['id'] }}" type="text" name="site_id" id="site_id" class="dnone">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="currency_name">{{ __('Currency Name') }}<span class="red">*</span></label>
                                                    <input value="{{ $datalist['currency_name'] }}" type="text" name="currency_name" id="currency_name" class="form-control parsley-validated" data-required="true" placeholder="USD">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="currency_icon">{{ __('Currency Icon') }}<span class="red">*</span></label>
                                                    <input value="{{ $datalist['currency_icon'] }}" type="text" name="currency_icon" id="currency_icon" class="form-control parsley-validated" data-required="true" placeholder="$">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="currency_position">{{ __('Currency Position') }}<span class="red">*</span></label>
                                                    <select name="currency_position" id="currency_position" class="chosen-select form-control">
                                                        <option {{ 'left' == $datalist['currency_position'] ? "selected=selected" : '' }} value="left">Left</option>
                                                        <option {{ 'right' == $datalist['currency_position'] ? "selected=selected" : '' }} value="right">Right</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="thousands_separator">{{ __('Thousands Separator') }}<span class="red">*</span></label>
                                                    <select name="thousands_separator" id="thousands_separator" class="chosen-select form-control">
                                                        <option {{ ',' == $datalist['thousands_separator'] ? "selected=selected" : '' }} value=",">Comma (,)</option>
                                                        <option {{ '.' == $datalist['thousands_separator'] ? "selected=selected" : '' }} value=".">Point (.)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="decimal_separator">{{ __('Decimal Separator') }}<span class="red">*</span></label>
                                                    <select name="decimal_separator" id="decimal_separator" class="chosen-select form-control">
                                                        <option {{ '.' == $datalist['decimal_separator'] ? "selected=selected" : '' }} value=".">Point (.)</option>
                                                        <option {{ ',' == $datalist['decimal_separator'] ? "selected=selected" : '' }} value=",">Comma (,)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="decimal_digit">{{ __('Decimal Digit') }}<span class="red">*</span></label>
                                                    <select name="decimal_digit" id="currency_position" class="chosen-select form-control">
                                                        @for($i= 0; $i <=3; $i++)
                                                            <option {{ $i == $datalist['decimal_digit'] ? "selected=selected" : '' }} value="{{$i}}">Digit ({{$i}})</option>
                                                        @endfor
{{--                                                        <option {{ 'right' == $datalist['decimal_digit'] ? "selected=selected" : '' }} value="right">Right</option>--}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row tabs-footer mt-15">
                                            <div class="col-lg-12">
                                                <a id="submit-form" href="javascript:void(0);" class="btn blue-btn mr-10">{{ __('Save') }}</a>
                                            </div>
                                        </div>
                                    </form>
                                    <!--/Data Entry Form/-->
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
    <script src="{{asset('backend/pages/currency.js')}}"></script>
@endpush
