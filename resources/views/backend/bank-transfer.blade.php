@extends('layouts.backend')

@section('title', __('Header'))

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
                                    <form novalidate="" data-validate="parsley" id="bank_formId">
                                        <input value="{{ $datalist['id'] }}" type="text" name="site_id" id="site_id" class="dnone">
                                        <div class="row mb-10">
                                            <div class="col-lg-8">
                                                <h5>{{ __('Bank Transfer') }}</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="tw_checkbox checkbox_group">
                                                    <input id="isenable_bank" name="isenable_bank" type="checkbox" {{ $datalist['isenable'] == 1 ? 'checked' : '' }}>
                                                    <label for="isenable_bank">{{ __('Active/Inactive') }}</label>
                                                    <span></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">{{ __('Description') }}</label>
                                                    <textarea name="description_bank"  class="form-control" rows="3">{{ $datalist['description'] }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-4"></div>
                                        </div>
                                        <div class="row tabs-footer mt-15">
                                            <div class="col-lg-12">
                                                <a id="submit-form-bank" href="javascript:void(0);" class="btn blue-btn mr-10">{{ __('Save') }}</a>
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
    <script src="{{asset('backend/pages/theme_option_bank_transfer.js')}}"></script>
@endpush
