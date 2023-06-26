@extends('layouts.backend')

@section('title', __('Site Options'))

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

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="product_name">{{ __('Site Web') }}<span class="red">*</span></label>
                                        <input value="{{ $datalist['web']}}" type="text" name="site_web" id="site_web" class="form-control parsley-validated" data-required="true">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="site_name">{{ __('Site Name') }}<span class="red">*</span></label>
                                        <input type="text" name="site_name" id="site_name" class="form-control parsley-validated" data-required="true" value="{{ @$datalist['name'] }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="site_title">{{ __('Site Title') }}<span class="red">*</span></label>
                                        <input type="text" name="site_title" id="site_title" class="form-control parsley-validated" data-required="true" value="{{ $datalist['site_title'] }}">
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="is_publish">{{ __('Status') }}<span class="red">*</span></label>
                                        <select name="is_publish" id="is_publish" class="chosen-select form-control">
                                            @foreach($statuslist as $row)
                                                <option {{ $row->id == $datalist['is_publish'] ? "selected=selected" : '' }} value="{{ $row->id }}">
                                                    {{ $row->status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-9"></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="divider_heading">{{ __('Information') }}</div>

                                    <div class="form-group">
                                        <label for="company">{{ __('Company') }}<span class="red">*</span></label>
                                        <input type="text" name="company" id="company" class="form-control parsley-validated" data-required="true" value="{{ $datalist['company'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">{{ __('Email') }}<span class="red">*</span></label>
                                        <input type="text" name="email" id="email" class="form-control parsley-validated" data-required="true" value="{{ $datalist['email'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">{{ __('Phone') }}<span class="red">*</span></label>
                                        <input type="text" name="phone" id="phone" class="form-control parsley-validated" data-required="true" value="{{ $datalist['phone'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">{{ __('Address') }}<span class="red">*</span></label>
                                        <textarea name="address" id="address" class="form-control parsley-validated" data-required="true" rows="2">{{ $datalist['address'] }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="timezone">{{ __('Time Zone') }}<span class="red">*</span></label>
                                        <select name="timezone" id="timezone" class="chosen-select form-control parsley-validated" data-required="true">
                                            @foreach($timezonelist as $row)
                                                <option {{ $row->timezone == $datalist['timezone'] ? "selected=selected" : '' }} value="{{ $row->timezone }}">
                                                    {{ $row->timezone_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4"></div>
                            </div>


                            <input value="{{ $datalist['id'] }}" type="text" name="RecordId" id="RecordId" class="dnone">
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
@include('backend.partials.global_media')
<!--/Global Media/-->

@endsection

@push('scripts')
<!-- css/js -->
<script src="{{asset('backend/pages/multiple_sites.js')}}"></script>

@endpush
