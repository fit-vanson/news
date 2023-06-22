@extends('layouts.backend')

@section('title', __('Whatsapp'))

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
									<div class="col-lg-6">
										<div class="form-group">
											<label for="whatsapp_id">Telegram</label>
											<input value="{{ $datalist['telegram_id'] }}" type="text" name="telegram_id" id="telegram_id" class="form-control" placeholder="@zxcv89">
										</div>
									</div>
									<div class="col-lg-6"></div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="position">Position</label>
											<select name="position" id="position" class="chosen-select form-control">
												<option {{ 'left' == $datalist['position'] ? "selected=selected" : '' }} value="left">Left</option>
												<option {{ 'right' == $datalist['position'] ? "selected=selected" : '' }} value="right">Right</option>
											</select>
										</div>
									</div>
									<div class="col-md-8"></div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="is_publish">{{ __('Status') }}</label>
											<select name="is_publish" id="is_publish" class="chosen-select form-control">
											@foreach($statuslist as $row)
												<option {{ $row->id == $datalist['is_publish'] ? "selected=selected" : '' }} value="{{ $row->id }}">
													{{ $row->status }}
												</option>
											@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-8"></div>
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
		@endif
	</div>
</div>
<!-- /main Section -->

@endsection

@push('scripts')
<!-- css/js -->
<script src="{{asset('backend/pages/theme_option_telegram.js')}}"></script>
@endpush
