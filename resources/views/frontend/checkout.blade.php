@extends('layouts.frontend')

@section('title', __('Checkout'))
@php
$gtext = gtext();
$gtax = getTax();
$tax_rate = $gtax['percentage'];
config(['cart.tax' => $tax_rate]);
@endphp

@section('meta-content')
	<meta name="keywords" content="{{ $gtext['og_keywords'] }}" />
	<meta name="description" content="{{ $gtext['og_description'] }}" />
	<meta property="og:title" content="{{ $gtext['og_title'] }}" />
	<meta property="og:site_name" content="{{ $gtext['site_name'] }}" />
	<meta property="og:description" content="{{ $gtext['og_description'] }}" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="{{ url()->current() }}" />
	<meta property="og:image" content="{{ asset('media/'.$gtext['og_image']) }}" />
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
	<meta name="twitter:title" content="{{ $gtext['og_title'] }}">
	<meta name="twitter:description" content="{{ $gtext['og_description'] }}">
	<meta name="twitter:image" content="{{ asset('media/'.$gtext['og_image']) }}">

    <style type="text/css">
        #checkout_card_number {
            background-image: url({{ asset('frontend/images/cards.png') }});
            background-position: 3px 3px;
            background-size: 40px 252px; /* 89 x 560 */
            background-repeat: no-repeat;
            padding-left: 48px;
        }
    </style>





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
				<div class="col-lg-6">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
							<li class="breadcrumb-item active" aria-current="page">{{ __('Checkout') }}</li>
						</ol>
					</nav>
				</div>
				<div class="col-lg-6">
					<div class="page-title">
						<h1>{{ __('Checkout') }}</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Page Breadcrumb/ -->

	<!-- Inner Section -->
	<section class="inner-section inner-section-bg my_card">
		<div class="container">
			<form novalidate="" data-validate="parsley" id="checkout_formid">
				@csrf
				<div class="row">
					<div class="col-lg-7">
						<h5>{{ __('Shipping Information') }}</h5>
						<p>{{ __('Already have an account?') }} <strong><a href="{{ route('frontend.login') }}">{{ __('login') }}</a></strong></p>
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<input id="name" name="name" type="text" placeholder="{{ __('Name') }}" value="@if(isset(Auth::user()->name)) {{ Auth::user()->name }} @endif" class="form-control parsley-validated" data-required="true">
									<span class="text-danger error-text name_error"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<input id="email" name="email" type="email" placeholder="{{ __('Email Address') }}" value="@if(isset(Auth::user()->email)) {{ Auth::user()->email }} @endif" class="form-control parsley-validated" data-required="true">
									<span class="text-danger error-text email_error"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<input id="phone" name="phone" type="number" placeholder="{{ __('Phone') }}" value="@if(isset(Auth::user()->phone)) {{ Auth::user()->phone }} @endif" class="form-control parsley-validated" data-required="true">
									<span class="text-danger error-text phone_error"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<select id="country" name="country" class="form-control parsley-validated" data-required="true">
									<option value="">{{ __('Country') }}</option>
									@foreach($country_list as $row)
									<option value="{{ $row->iso }}">
										{{ $row->country_name }}
									</option>
									@endforeach
									</select>
									<span class="text-danger error-text country_error"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<input id="state" name="state" type="text" placeholder="{{ __('State') }}" class="form-control parsley-validated" data-required="true">
									<span class="text-danger error-text state_error"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<input id="zip_code" name="zip_code" type="number" placeholder="{{ __('Zip Code') }}" class="form-control parsley-validated" data-required="true">
									<span class="text-danger error-text zip_code_error"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<input id="city" name="city" type="text" placeholder="{{ __('City') }}" class="form-control parsley-validated" data-required="true">
									<span class="text-danger error-text city_error"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3">
									<textarea id="address" name="address" placeholder="{{ __('Address') }}" rows="2" class="form-control parsley-validated" data-required="true">@if(isset(Auth::user()->address)) {{ Auth::user()->address }} @endif</textarea>
									<span class="text-danger error-text address_error"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="checkboxlist">
									<label class="checkbox-title">
										<input id="new_account" name="new_account" type="checkbox">{{ __('Register an account with above information?') }}
									</label>
								</div>
								@if ($errors->has('password'))
								<span class="text-danger">{{ $errors->first('password') }}</span>
								@endif
							</div>
						</div>

						<div class="row hideclass" id="new_account_pass">
							<div class="col-md-6">
								<div class="mb-3">
									<input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}">
									<span class="text-danger error-text password_error"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirm password') }}">
								</div>
							</div>
						</div>

						<h5 class="mt10">{{ __('Payment Method') }}</h5>
						<div class="row">
							<div class="col-md-12">
								<span class="text-danger error-text payment_method_error"></span>
								@if($gtext['stripe_isenable'] == 1)
								<div class="payment_card">
									<div class="checkboxlist">
										<label class="checkbox-title">
											<input id="payment_method_stripe" name="payment_method" type="radio" value="3"><img src="{{ asset('frontend/images/stripe.png') }}" alt="Stripe" />
										</label>
									</div>
									<div id="pay_stripe" class="row hideclass">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-12">
													<div class="mb-3">
{{--														<div class="form-control" id="card-number" ></div>--}}
{{--														<div class="form-control" id="card-expiry" ></div>--}}
{{--														<div class="form-control" id="card-cvc" ></div>--}}

{{--                                                        <div class="form-control" id="card-element" ></div>--}}
{{--                                                        <span class="card-errors" id="card-errors"></span>--}}

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <input id="card_name" name="card_name" type="text" placeholder="{{ __('Name') }}" value="@if(isset(Auth::user()->name)) {{ Auth::user()->name }} @endif" class="form-control parsley-validated" data-required="true">
                                                                    <span class="text-danger error-text name_error"></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="mb-3">
{{--                                                                    <input id="card_number" name="card_number" type="text" placeholder="{{ __('Card Number') }}" minlength="16" maxlength="16"   class="form-control parsley-validated" data-required="true">--}}
                                                                    <input id="checkout_card_number" name="checkout_card_number" class="input-text form-control" type="text" size="19" maxlength="19" data-stripe="number" placeholder="1234 5678 9012 3456" style="background-position: 3px 3px;">
                                                                    <span class="text-danger error-text card_error"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <input id="checkout_card_expdate" name="checkout_card_expdate" type="text" placeholder="MM/YY" minlength="5" maxlength="5" class="form-control parsley-validated" data-required="true">
                                                                    <span class="text-danger error-text email_error"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <input id="checkout_card_cvv" name="checkout_card_cvv" type="text" placeholder="CVC" minlength="3" maxlength="5" class="form-control parsley-validated" data-required="true">
                                                                    <span class="text-danger error-text phone_error"></span>
                                                                </div>
                                                            </div>
                                                        </div>

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								@endif

								@if($gtext['isenable_paypal'] == 1)
								<div class="payment_card">
									<div class="checkboxlist">
										<label class="checkbox-title">
											<input id="payment_method_paypal" name="payment_method" type="radio" value="4"><img src="{{ asset('frontend/images/paypal.png') }}" alt="Paypal" />
										</label>
									</div>
									<p id="pay_paypal" class="hideclass">{{ __('Pay online via Paypal') }}</p>
								</div>
								@endif

								@if($gtext['isenable_razorpay'] == 1)
								<div class="payment_card">
									<div class="checkboxlist">
										<label class="checkbox-title">
											<input id="payment_method_razorpay" name="payment_method" type="radio" value="5"><img src="{{ asset('frontend/images/razorpay.png') }}" alt="Razorpay" />
										</label>
									</div>
									<p id="pay_razorpay" class="hideclass">{{ __('Pay online via Razorpay') }}</p>
								</div>
								@endif

								@if($gtext['isenable_mollie'] == 1)
								<div class="payment_card">
									<div class="checkboxlist">
										<label class="checkbox-title">
											<input id="payment_method_mollie" name="payment_method" type="radio" value="6"><img src="{{ asset('frontend/images/mollie.png') }}" alt="Mollie" />
										</label>
									</div>
									<p id="pay_mollie" class="hideclass">{{ __('Pay online via Mollie') }}</p>
								</div>
								@endif

								@if($gtext['cod_isenable'] == 1)
								<div class="payment_card">
									<div class="checkboxlist">
										<label class="checkbox-title">
											<input id="payment_method_cod" name="payment_method" type="radio" value="1"><img src="{{ asset('frontend/images/cash_on_delivery.png') }}" alt="Cash on Delivery" />
										</label>
									</div>
									<p id="pay_cod" class="hideclass">{{ $gtext['cod_description'] }}</p>
								</div>
								@endif

								@if($gtext['bank_isenable'] == 1)
								<div class="payment_card">
									<div class="checkboxlist">
										<label class="checkbox-title">
											<input id="payment_method_bank" name="payment_method" type="radio" value="2"><img src="{{ asset('frontend/images/bank_transfer.png') }}" alt="Bank Transfer" />
										</label>
									</div>
									<p id="pay_bank" class="hideclass">{{ $gtext['bank_description'] }}</p>
								</div>
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3 mt10">
									<textarea name="comments" class="form-control" placeholder="Note" rows="2"></textarea>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-5">
						<div class="carttotals-card">
							<div class="carttotals-head">{{ __('Order Summary') }}</div>
							<div class="carttotals-body">
								<table class="table">
									<tbody>
										@php
										$CartDataList = Cart::instance('shopping')->content();
										$CartDataArr = array();
										@endphp

										@foreach($CartDataList as $row)
											@php
											$row->setTaxRate($tax_rate);
											Cart::instance('shopping')->update($row->rowId, $row->qty);

											$data = array(
												'rowId' => $row->rowId,
												'id' => $row->id,
												'qty' => $row->qty,
												'name' => $row->name,
												'price' => $row->price,
												'weight' => $row->weight,
												'thumbnail' => $row->options->thumbnail,
												'unit' => $row->options->unit,
												'seller_id' => $row->options->seller_id,
												'seller_name' => $row->options->seller_name,
												'store_name' => $row->options->store_name,
												'store_logo' => $row->options->store_logo,
												'store_url' => $row->options->store_url,
												'seller_email' => $row->options->seller_email,
												'seller_phone' => $row->options->seller_phone,
												'seller_address' => $row->options->seller_address
											);

											$CartDataArr[$row->options->seller_id][] = $data;
											@endphp
										@endforeach

										@php $CartData_Arr = array(); @endphp
										@foreach($CartDataArr as $aRows)
											@foreach($aRows as $row)
												@php $CartData_Arr[] = $row; @endphp
											@endforeach
										@endforeach

										@php
										$tempSellerId = '';
										$SellerCount = 0;
										@endphp

										@foreach($CartData_Arr as $row)
											@php

											if($row['unit'] == '0'){
												$unit = '';
											}else{
												$unit = '<strong>'.$row['qty'].' '.$row['unit'].'</strong>';
											}

											@endphp

{{--											@if($tempSellerId != $row['seller_id'])--}}
{{--											<tr>--}}
{{--												<td colspan="2" class="tp_group">--}}
{{--													<div class="store_logo">--}}
{{--														<a href="{{ route('frontend.stores', [$row['seller_id'], str_slug($row['store_name'])]) }}">--}}
{{--															<img src="{{ asset('media/'.$row['store_logo']) }}" alt="{{ $row['store_name'] }}" />--}}
{{--														</a>--}}
{{--													</div>--}}
{{--													<div class="store_name">--}}
{{--														<p><strong>{{ __('Sold By') }}</strong></p>--}}
{{--														<p><a href="{{ route('frontend.stores', [$row['seller_id'], str_slug($row['store_url'])]) }}">{{ $row['store_name'] }}</a></p>--}}
{{--													</div>--}}
{{--												</td>--}}
{{--											</tr>--}}

{{--											@php--}}
{{--											$tempSellerId=$row['seller_id'];--}}
{{--											$SellerCount++;--}}
{{--											@endphp--}}

{{--											@endif--}}

											@if($gtext['currency_position'] == 'left')
											<tr>
												<td>

													<p class="title"><a href="{{ route('frontend.product', [$row['id'], str_slug($row['name'])]) }}">{{ $row['name'] }}</a></p>
													<p class="sub-title">@php echo $unit; @endphp</p>
												</td>
												<td>
													<p class="price">{{ $gtext['currency_icon'] }}{{ number_format($row['price']*$row['qty'],2) }}</p>
													<p class="sub-price">{{ $gtext['currency_icon'] }}{{ $row['price'] }} x {{ $row['qty'] }}</p>
												</td>
											</tr>
											@else
											<tr>

                                                <td style="width: 20%">
                                                    <img src="{{ asset('media/'.$row['thumbnail']) }}" alt="{{ $row['name'] }}" width="50px" />
                                                </td>
												<td>
                                                    <p class="title"><a href="{{ route('frontend.product', [$row['id'], str_slug($row['name'])]) }}">{{ $row['name'] }}</a></p>
													<p class="sub-title">@php echo $unit; @endphp</p>
												</td>
												<td>
													<p class="price">{{ number_format($row['price']*$row['qty'],2) }}{{ $gtext['currency_icon'] }}</p>
													<p class="sub-price">{{ $row['price'] }}{{ $gtext['currency_icon'] }} x {{ $row['qty'] }}</p>
												</td>
											</tr>
											@endif
										@endforeach

										@php
											if($gtext['currency_position'] == 'left'){
												$ShippingFee = $gtext['currency_icon'].'<span class="shipping_fee">0</span>';
												$tax = $gtext['currency_icon'].Cart::instance('shopping')->tax();
												$total = $gtext['currency_icon'].'<span class="total_amount">'.Cart::instance('shopping')->total().'</span>';
											}else{
												$ShippingFee = '<span class="shipping_fee">0</span>'.$gtext['currency_icon'];
												$tax = Cart::instance('shopping')->tax().$gtext['currency_icon'];
												$total = '<span class="total_amount">'.Cart::instance('shopping')->total().'</span>'.$gtext['currency_icon'];
											}
										@endphp

										<tr><td colspan="3"><span class="title">{{ __('Shipping Fee') }} </span><span class="price">@php echo $ShippingFee; @endphp</span></td></tr>
										<tr><td colspan="3"><span class="title">{{ __('Tax') }}</span><span class="price">{{ $tax }}</span></td></tr>
										<tr><td colspan="3"><span class="total">{{ __('Total') }}</span><span class="total-price">@php echo $total; @endphp</span></td></tr>
									</tbody>
								</table>
								@if(count($shipping_list)>0)
								<h5>{{ __('Shipping Method') }}</h5>
								<div class="row">
									<div class="col-md-12">
										<span class="text-danger error-text shipping_method_error"></span>
										@foreach($shipping_list as $row)
											@php
												if($gtext['currency_position'] == 'left'){
													$shipping_fee = $gtext['currency_icon'].$row->shipping_fee;
												}else{
													$shipping_fee = $row->shipping_fee.$gtext['currency_icon'];
												}
											@endphp
											<div class="checkboxlist">
												<label class="checkbox-title">
													<input data-seller_count="{{ $SellerCount }}" data-shippingfee="{{ $row->shipping_fee }}" data-total="{{ Cart::instance('shopping')->total() }}" class="shipping_method" name="shipping_method" type="radio" value="{{ $row->id }}">{{ $row->title }} : {{ $shipping_fee }}
												</label>
											</div>
										@endforeach
									</div>
								</div>
								@endif
								<input name="customer_id" type="hidden" value="@if(isset(Auth::user()->id)) {{ Auth::user()->id }} @endif" />
								<input name="razorpay_payment_id" id="razorpay_payment_id" type="hidden" />
								<a id="checkout_submit_form" href="javascript:void(0);" class="btn theme-btn mt10 checkout_btn">{{ __('Checkout') }}</a>

								@if(Session::has('pt_payment_error'))
								<div class="alert alert-danger">
									{{Session::get('pt_payment_error')}}
								</div>
								@endif

							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
	<!-- /Inner Section/ -->
</main>

@endsection

@push('scripts')
<script src="{{asset('frontend/js/parsley.min.js')}}"></script>
<script type="text/javascript">
var theme_color = "{{ $gtext['theme_color'] }}";
var site_name = "{{ $gtext['site_name'] }}";
var validCardNumer = 0;
var TEXT = [];
	TEXT['Please type valid card number'] = "{{ __('Please type valid card number') }}";
</script>
@if($gtext['stripe_isenable'] == 1)
    <script src="http://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
    <script>
        (function() {
            var $,
                __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

            $ = jQuery;

            $.fn.validateCreditCard = function(callback, options) {
                var card, card_type, card_types, get_card_type, is_valid_length, is_valid_luhn, normalize, validate, validate_number, _i, _len, _ref, _ref1;
                card_types = [
                    {
                        name: 'amex',
                        pattern: /^3[47]/,
                        valid_length: [15]
                    }, {
                        name: 'diners_club_carte_blanche',
                        pattern: /^30[0-5]/,
                        valid_length: [14]
                    }, {
                        name: 'diners_club_international',
                        pattern: /^36/,
                        valid_length: [14]
                    }, {
                        name: 'jcb',
                        pattern: /^35(2[89]|[3-8][0-9])/,
                        valid_length: [16]
                    }, {
                        name: 'laser',
                        pattern: /^(6304|670[69]|6771)/,
                        valid_length: [16, 17, 18, 19]
                    }, {
                        name: 'visa_electron',
                        pattern: /^(4026|417500|4508|4844|491(3|7))/,
                        valid_length: [16]
                    }, {
                        name: 'visa',
                        pattern: /^4/,
                        valid_length: [16]
                    }, {
                        name: 'mastercard',
                        pattern: /^5[1-5]/,
                        valid_length: [16]
                    }, {
                        name: 'maestro',
                        pattern: /^(5018|5020|5038|6304|6759|676[1-3])/,
                        valid_length: [12, 13, 14, 15, 16, 17, 18, 19]
                    }, {
                        name: 'discover',
                        pattern: /^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)/,
                        valid_length: [16]
                    }
                ];
                if (options == null) {
                    options = {};
                }
                if ((_ref = options.accept) == null) {
                    options.accept = (function() {
                        var _i, _len, _results;
                        _results = [];
                        for (_i = 0, _len = card_types.length; _i < _len; _i++) {
                            card = card_types[_i];
                            _results.push(card.name);
                        }
                        return _results;
                    })();
                }
                _ref1 = options.accept;
                for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
                    card_type = _ref1[_i];
                    if (__indexOf.call((function() {
                        var _j, _len1, _results;
                        _results = [];
                        for (_j = 0, _len1 = card_types.length; _j < _len1; _j++) {
                            card = card_types[_j];
                            _results.push(card.name);
                        }
                        return _results;
                    })(), card_type) < 0) {
                        throw "Credit card type '" + card_type + "' is not supported";
                    }
                }
                get_card_type = function(number) {
                    var _j, _len1, _ref2;
                    _ref2 = (function() {
                        var _k, _len1, _ref2, _results;
                        _results = [];
                        for (_k = 0, _len1 = card_types.length; _k < _len1; _k++) {
                            card = card_types[_k];
                            if (_ref2 = card.name, __indexOf.call(options.accept, _ref2) >= 0) {
                                _results.push(card);
                            }
                        }
                        return _results;
                    })();
                    for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
                        card_type = _ref2[_j];
                        if (number.match(card_type.pattern)) {
                            return card_type;
                        }
                    }
                    return null;
                };
                is_valid_luhn = function(number) {
                    var digit, n, sum, _j, _len1, _ref2;
                    sum = 0;
                    _ref2 = number.split('').reverse();
                    for (n = _j = 0, _len1 = _ref2.length; _j < _len1; n = ++_j) {
                        digit = _ref2[n];
                        digit = +digit;
                        if (n % 2) {
                            digit *= 2;
                            if (digit < 10) {
                                sum += digit;
                            } else {
                                sum += digit - 9;
                            }
                        } else {
                            sum += digit;
                        }
                    }
                    return sum % 10 === 0;
                };
                is_valid_length = function(number, card_type) {
                    var _ref2;
                    return _ref2 = number.length, __indexOf.call(card_type.valid_length, _ref2) >= 0;
                };
                validate_number = function(number) {
                    var length_valid, luhn_valid;
                    card_type = get_card_type(number);
                    luhn_valid = false;
                    length_valid = false;
                    if (card_type != null) {
                        luhn_valid = is_valid_luhn(number);
                        length_valid = is_valid_length(number, card_type);
                    }
                    return callback({
                        card_type: card_type,
                        luhn_valid: luhn_valid,
                        length_valid: length_valid
                    });
                };
                validate = function() {
                    var number;
                    number = normalize($(this).val());
                    return validate_number(number);
                };
                normalize = function(number) {
                    return number.replace(/[ -]/g, '');
                };
                this.bind('input', function() {
                    $(this).unbind('keyup');
                    return validate.call(this);
                });
                this.bind('keyup', function() {
                    return validate.call(this);
                });
                if (this.length !== 0) {
                    validate.call(this);
                }
                return this;
            };

        }).call(this);
    </script>

    <script type="text/javascript">
        $('#checkout_card_number').mask('0000 0000 0000 0000');
        $('#checkout_card_expdate').mask('00/00');
        var $cardinput = $('#checkout_card_number');
        $('#checkout_card_number').validateCreditCard(function(result)
        {
            if (result.card_type != null)
            {
                switch (result.card_type.name)
                {
                    case "visa":
                        $cardinput.css('background-position', '3px -34px');
                        $cardinput.addClass('card_visa');
                        break;

                    case "visa_electron":
                        $cardinput.css('background-position', '3px -72px');
                        $cardinput.addClass('card_visa_electron');
                        break;

                    case "mastercard":
                        $cardinput.css('background-position', '3px -110px');
                        $cardinput.addClass('card_mastercard');
                        break;

                    case "maestro":
                        $cardinput.css('background-position', '3px -148px');
                        $cardinput.addClass('card_maestro');
                        break;

                    case "discover":
                        $cardinput.css('background-position', '3px -186px');
                        $cardinput.addClass('card_discover');
                        break;

                    case "amex":
                        $cardinput.css('background-position', '3px -223px');
                        $cardinput.addClass('card_amex');
                        break;

                    default:
                        $cardinput.css('background-position', '3px 3px');
                        break;
                }
            } else {
                $cardinput.css('background-position', '3px 3px');
            }

            // Check for valid card numbere - only show validation checks for invalid Luhn when length is correct so as not to confuse user as they type.
            if (result.length_valid || $cardinput.val().length > 16)
            {
                if (result.luhn_valid) {
                    $('.card_error').hide()
                    validCardNumer = 1;
                    // $cardinput.parent().removeClass('has-error').addClass('has-success');
                } else {
                    $('.card_error').show()
                    $('.card_error').text('Your card number is invalid.')
                    // $cardinput.parent().removeClass('has-success').addClass('has-error');
                }
            } else {
                $('.card_error').show()
                $('.card_error').text('Your card number is invalid.')
                // $cardinput.parent().removeClass('has-success').removeClass('has-error');
            }
        });

    </script>

{{--    <script src="https://js.stripe.com/v3/"></script>--}}
    <script type="text/javascript">
        var isenable_stripe = "{{ $gtext['stripe_isenable'] }}";
        var stripe_key = "{{ $gtext['stripe_key'] }}";
    </script>

{{--<script src="{{asset('frontend/pages/payment_method.js')}}"></script>--}}
@endif

@if($gtext['isenable_razorpay'] == 1)
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">
	var isenable_razorpay = "{{ $gtext['isenable_razorpay'] }}";
	var razorpay_key_id = "{{ $gtext['razorpay_key_id'] }}";
	var razorpay_currency = "{{ $gtext['razorpay_currency'] }}";
</script>
@endif
<script src="{{asset('frontend/pages/checkout.js')}}"></script>
@endpush
