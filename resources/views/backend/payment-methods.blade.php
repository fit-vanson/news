@extends('layouts.backend')

@section('title', __('Media Setting'))

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
                            <div class="card-header">{{ __('Settings') }}</div>
                            <div class="card-body tabs-area p-0">
                                @include('backend.partials.settings_tabs_nav')
                                <div class="tabs-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="float-right">
                                                <a onClick="onListPanel()" href="javascript:void(0);" class="btn warning-btn btn-list float-right dnone"><i class="fa fa-reply"></i> {{ __('Back to List') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <!--/Data grid-->
                                            <div id="list-panel">
                                                <div class="row">
                                                    <div class="col-lg-7"></div>
                                                    <div class="col-lg-5">
                                                        <div class="form-group search-box">
                                                            <input id="search" name="search" type="text" class="form-control" placeholder="{{ __('Search') }}...">
                                                            <button type="submit" onClick="onSearch()" class="btn search-btn">{{ __('Search') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div id="media_settings_datalist">
                                                            @include('backend.partials.payment_methods_table')
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--/Data grid-->

                                            <!--/Data Entry Form-->
                                            <div id="form-panel" class="dnone">
                                                <form novalidate="" data-validate="parsley" id="DataEntry_formId">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h4><strong id="media_type"></strong></h4>
                                                            <p>The sizes listed below determine the maximum dimensions in pixels to use when adding an image to the Media.</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="media_width">{{ __('Width') }}<span class="red">*</span></label>
                                                                <input type="number" name="media_width" id="media_width" class="form-control parsley-validated" data-required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="media_height">{{ __('Height') }}<span class="red">*</span></label>
                                                                <input type="number" name="media_height" id="media_height" class="form-control parsley-validated" data-required="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="RecordId" id="RecordId" class="dnone">

                                                    <div class="row tabs-footer mt-15">
                                                        <div class="col-lg-12">
                                                            <a id="submit-form" href="javascript:void(0);" class="btn blue-btn mr-10">{{ __('Save') }}</a>
                                                            <a onClick="onListPanel()" href="javascript:void(0);" class="btn danger-btn">{{ __('Cancel') }}</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!--/Data Entry Form-->

                                            <!--/Stripe Form-->
                                            <div id="form-panel-1" class="dnone">
                                                <form novalidate="" data-validate="parsley" id="stripe_formId">
                                                    <div class="row mb-10">
                                                        <div class="col-lg-8">
                                                            <h5>{{ __('Stripe Method') }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <div class="tw_checkbox checkbox_group">
                                                                <input id="isenable" name="isenable" type="checkbox" {{ $stripe_data_list['isenable'] == 1 ? 'checked' : '' }}>
                                                                <label for="isenable">{{ __('Active/Inactive') }}</label>
                                                                <span></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="stripe_key">{{ __('Publishable Key') }}<span class="red">*</span></label>
                                                                <input type="text" name="stripe_key" id="stripe_key" class="form-control parsley-validated" data-required="true" value="{{ $stripe_data_list['stripe_key'] }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="stripe_secret">{{ __('Stripe Secret') }}<span class="red">*</span></label>
                                                                <input type="text" name="stripe_secret" id="stripe_secret" class="form-control parsley-validated" data-required="true" value="{{ $stripe_data_list['stripe_secret'] }}">
                                                                <small class="form-text text-muted"><a target="_blank" href="https://stripe.com/">Create an Account Stripe</a></small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="currency">{{ __('Currency') }}<span class="red">*</span></label>
                                                                <input type="text" name="currency" id="currency" class="form-control parsley-validated" data-required="true" value="{{ $stripe_data_list['currency'] }}">
                                                                <small class="form-text text-muted"><a target="_blank" href="https://stripe.com/docs/currencies">Currencies</a></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4"></div>
                                                    </div>
                                                    <div class="row tabs-footer mt-15">
                                                        <div class="col-lg-12">
                                                            <a id="submit-form-stripe" href="javascript:void(0);" class="btn blue-btn mr-10">{{ __('Save') }}</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!--/Stripe Form-->

                                            <!--/Paypal Form-->
                                            <div id="form-panel-4" class="dnone">
                                                <form novalidate="" data-validate="parsley" id="paypal_formId">
                                                    <div class="row mb-10">
                                                        <div class="col-lg-8">
                                                            <h5>{{ __('Paypal Method') }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <div class="tw_checkbox checkbox_group">
                                                                <input id="isenable_paypal" name="isenable_paypal" type="checkbox" {{ $paypal_data_list['isenable_paypal'] == 1 ? 'checked' : '' }}>
                                                                <label for="isenable_paypal">{{ __('Active/Inactive') }}</label>
                                                                <span></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="paypal_client_id">{{ __('Client ID') }}<span class="red">*</span></label>
                                                                <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control parsley-validated" data-required="true" value="{{ $paypal_data_list['paypal_client_id'] }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="paypal_secret">{{ __('Secret') }}<span class="red">*</span></label>
                                                                <input type="text" name="paypal_secret" id="paypal_secret" class="form-control parsley-validated" data-required="true" value="{{ $paypal_data_list['paypal_secret'] }}">
                                                                <small class="form-text text-muted"><a target="_blank" href="https://www.paypal.com/">Create an Account Paypal</a></small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="paypal_currency">{{ __('Currency') }}<span class="red">*</span></label>
                                                                <input type="text" name="paypal_currency" id="paypal_currency" class="form-control parsley-validated" data-required="true" value="{{ $paypal_data_list['paypal_currency'] }}">
                                                                <small class="form-text text-muted"><a target="_blank" href="https://developer.paypal.com/docs/reports/reference/paypal-supported-currencies/">Currencies</a></small>
                                                            </div>
                                                            <div class="tw_checkbox checkbox_group">
                                                                <input id="ismode_paypal" name="ismode_paypal" type="checkbox" {{ $paypal_data_list['ismode_paypal'] == 1 ? 'checked' : '' }}>
                                                                <label for="ismode_paypal">{{ __('Sandbox mode') }}</label>
                                                                <span></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4"></div>
                                                    </div>
                                                    <div class="row tabs-footer mt-15">
                                                        <div class="col-lg-12">
                                                            <a id="submit-form-paypal" href="javascript:void(0);" class="btn blue-btn mr-10">{{ __('Save') }}</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!--/Paypal Form-->

                                            <!--/Razorpay Form-->
                                            <div id="form-panel-5" class="dnone">
                                                <form novalidate="" data-validate="parsley" id="razorpay_formId">
                                                    <div class="row mb-10">
                                                        <div class="col-lg-8">
                                                            <h5>{{ __('Razorpay Method') }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <div class="tw_checkbox checkbox_group">
                                                                <input id="isenable_razorpay" name="isenable_razorpay" type="checkbox" {{ $razorpay_data_list['isenable_razorpay'] == 1 ? 'checked' : '' }}>
                                                                <label for="isenable_razorpay">{{ __('Active/Inactive') }}</label>
                                                                <span></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="razorpay_key_id">{{ __('Key Id') }}<span class="red">*</span></label>
                                                                <input type="text" name="razorpay_key_id" id="razorpay_key_id" class="form-control parsley-validated" data-required="true" value="{{ $razorpay_data_list['razorpay_key_id'] }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="razorpay_key_secret">{{ __('Key Secret') }}<span class="red">*</span></label>
                                                                <input type="text" name="razorpay_key_secret" id="razorpay_key_secret" class="form-control parsley-validated" data-required="true" value="{{ $razorpay_data_list['razorpay_key_secret'] }}">
                                                                <small class="form-text text-muted"><a target="_blank" href="https://razorpay.com/">Create an Account Razorpay</a></small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="razorpay_currency">{{ __('Currency') }}<span class="red">*</span></label>
                                                                <input type="text" name="razorpay_currency" id="razorpay_currency" class="form-control parsley-validated" data-required="true" value="{{ $razorpay_data_list['razorpay_currency'] }}">
                                                            </div>
                                                            <div class="tw_checkbox checkbox_group">
                                                                <input id="ismode_razorpay" name="ismode_razorpay" type="checkbox" {{ $razorpay_data_list['ismode_razorpay'] == 1 ? 'checked' : '' }}>
                                                                <label for="ismode_razorpay">{{ __('Test Mode') }}</label>
                                                                <span></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4"></div>
                                                    </div>
                                                    <div class="row tabs-footer mt-15">
                                                        <div class="col-lg-12">
                                                            <a id="submit-form-razorpay" href="javascript:void(0);" class="btn blue-btn mr-10">{{ __('Save') }}</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!--/Razorpay Form-->

                                            <!--/Mollie Form-->
                                            <div id="form-panel-6" class="dnone">
                                                <form novalidate="" data-validate="parsley" id="mollie_formId">
                                                    <div class="row mb-10">
                                                        <div class="col-lg-8">
                                                            <h5>{{ __('Mollie Method') }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <div class="tw_checkbox checkbox_group">
                                                                <input id="isenable_mollie" name="isenable_mollie" type="checkbox" {{ $mollie_data_list['isenable_mollie'] == 1 ? 'checked' : '' }}>
                                                                <label for="isenable_mollie">{{ __('Active/Inactive') }}</label>
                                                                <span></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="mollie_api_key">{{ __('API Key') }}<span class="red">*</span></label>
                                                                <input type="text" name="mollie_api_key" id="mollie_api_key" class="form-control parsley-validated" data-required="true" value="{{ $mollie_data_list['mollie_api_key'] }}">
                                                                <small class="form-text text-muted"><a target="_blank" href="https://www.mollie.com/">Create an Account Mollie</a></small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="mollie_currency">{{ __('Currency') }}<span class="red">*</span></label>
                                                                <input type="text" name="mollie_currency" id="mollie_currency" class="form-control parsley-validated" data-required="true" value="{{ $mollie_data_list['mollie_currency'] }}">
                                                                <small class="form-text text-muted"><a target="_blank" href="https://docs.mollie.com/payments/multicurrency">Currencies</a></small>
                                                            </div>
                                                            <div class="tw_checkbox checkbox_group">
                                                                <input id="ismode_mollie" name="ismode_mollie" type="checkbox" {{ $mollie_data_list['ismode_mollie'] == 1 ? 'checked' : '' }}>
                                                                <label for="ismode_mollie">{{ __('Sandbox mode') }}</label>
                                                                <span></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4"></div>
                                                    </div>
                                                    <div class="row tabs-footer mt-15">
                                                        <div class="col-lg-12">
                                                            <a id="submit-form-mollie" href="javascript:void(0);" class="btn blue-btn mr-10">{{ __('Save') }}</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!--/Mollie Form-->

                                            <!--/Cash on Delivery (COD) Form-->
                                            <div id="form-panel-2" class="dnone">
                                                <form novalidate="" data-validate="parsley" id="cod_formId">
                                                    <div class="row mb-10">
                                                        <div class="col-lg-8">
                                                            <h5>{{ __('Cash on Delivery (COD)') }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <div class="tw_checkbox checkbox_group">
                                                                <input id="isenable_cod" name="isenable_cod" type="checkbox" {{ $cod_data_list['isenable'] == 1 ? 'checked' : '' }}>
                                                                <label for="isenable_cod">{{ __('Active/Inactive') }}</label>
                                                                <span></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="description">{{ __('Description') }}</label>
                                                                <textarea name="description" class="form-control" rows="3">{{ $cod_data_list['description'] }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4"></div>
                                                    </div>
                                                    <div class="row tabs-footer mt-15">
                                                        <div class="col-lg-12">
                                                            <a id="submit-form-cod" href="javascript:void(0);" class="btn blue-btn mr-10">{{ __('Save') }}</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!--/Cash on Delivery (COD) Form-->

                                            <!--/Bank Transfer Form-->
                                            <div id="form-panel-3" class="dnone">
                                                <form novalidate="" data-validate="parsley" id="bank_formId">
                                                    <div class="row mb-10">
                                                        <div class="col-lg-8">
                                                            <h5>{{ __('Bank Transfer') }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <div class="tw_checkbox checkbox_group">
                                                                <input id="isenable_bank" name="isenable_bank" type="checkbox" {{ $bank_data_list['isenable'] == 1 ? 'checked' : '' }}>
                                                                <label for="isenable_bank">{{ __('Active/Inactive') }}</label>
                                                                <span></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="description">{{ __('Description') }}</label>
                                                                <textarea name="description" class="form-control" rows="3">{{ $bank_data_list['description'] }}</textarea>
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
                                            </div>
                                            <!--/Bank Transfer Form-->

                                        </div>
                                    </div>
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
    <script type="text/javascript">
        var TEXT = [];
        TEXT['Do you really want to edit this record'] = "{{ __('Do you really want to edit this record') }}";
    </script>
    <script src="{{asset('backend/pages/payment-gateway.js')}}"></script>

@endpush
