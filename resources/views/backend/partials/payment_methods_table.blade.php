<!--/Data grid-->

<div class="table-responsive">
    <table class="table table-borderless table-theme" style="width:100%;">
        <tbody>
        <tr>
            <td class="text-left" width="70%">{{ __('Stripe') }}</td>
            <td class="text-left" width="25%">
                @if($stripe_data_list['isenable'] == 1)
                    <span class="enable_btn">{{ __('Active') }}</span>
                @else
                    <span class="disable_btn">{{ __('Inactive') }}</span>
                @endif
            </td>
            <td class="text-center" width="5%">
                <div class="btn-group action-group">
                    <a class="action-btn" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a onclick="onEdit(1)" class="dropdown-item" href="javascript:void(0);">{{ __('Edit') }}</a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="text-left" width="70%">{{ __('Paypal') }}</td>
            <td class="text-left" width="25%">
                @if($paypal_data_list['isenable_paypal'] == 1)
                    <span class="enable_btn">{{ __('Active') }}</span>
                @else
                    <span class="disable_btn">{{ __('Inactive') }}</span>
                @endif
            </td>
            <td class="text-center" width="5%">
                <div class="btn-group action-group">
                    <a class="action-btn" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a onclick="onEdit(4)" class="dropdown-item" href="javascript:void(0);">{{ __('Edit') }}</a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="text-left" width="70%">{{ __('Razorpay') }}</td>
            <td class="text-left" width="25%">
                @if($razorpay_data_list['isenable_razorpay'] == 1)
                    <span class="enable_btn">{{ __('Active') }}</span>
                @else
                    <span class="disable_btn">{{ __('Inactive') }}</span>
                @endif
            </td>
            <td class="text-center" width="5%">
                <div class="btn-group action-group">
                    <a class="action-btn" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a onclick="onEdit(5)" class="dropdown-item" href="javascript:void(0);">{{ __('Edit') }}</a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="text-left" width="70%">{{ __('Mollie') }}</td>
            <td class="text-left" width="25%">
                @if($mollie_data_list['isenable_mollie'] == 1)
                    <span class="enable_btn">{{ __('Active') }}</span>
                @else
                    <span class="disable_btn">{{ __('Inactive') }}</span>
                @endif
            </td>
            <td class="text-center" width="5%">
                <div class="btn-group action-group">
                    <a class="action-btn" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a onclick="onEdit(6)" class="dropdown-item" href="javascript:void(0);">{{ __('Edit') }}</a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="text-left" width="70%">{{ __('Cash on Delivery (COD)') }}</td>
            <td class="text-left" width="25%">
                @if($cod_data_list['isenable'] == 1)
                    <span class="enable_btn">{{ __('Active') }}</span>
                @else
                    <span class="disable_btn">{{ __('Inactive') }}</span>
                @endif
            </td>
            <td class="text-center" width="5%">
                <div class="btn-group action-group">
                    <a class="action-btn" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a onclick="onEdit(2)" class="dropdown-item" href="javascript:void(0);">{{ __('Edit') }}</a>
                    </div>
                </div>
            </td>
        </tr>
{{--        <tr>--}}
{{--            <td class="text-left" width="70%">{{ __('Bank Transfer') }}</td>--}}
{{--            <td class="text-left" width="25%">--}}
{{--                @if($bank_data_list['isenable'] == 1)--}}
{{--                    <span class="enable_btn">{{ __('Active') }}</span>--}}
{{--                @else--}}
{{--                    <span class="disable_btn">{{ __('Inactive') }}</span>--}}
{{--                @endif--}}
{{--            </td>--}}
{{--            <td class="text-center" width="5%">--}}
{{--                <div class="btn-group action-group">--}}
{{--                    <a class="action-btn" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>--}}
{{--                    <div class="dropdown-menu dropdown-menu-right">--}}
{{--                        <a onclick="onEdit(3)" class="dropdown-item" href="javascript:void(0);">{{ __('Edit') }}</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </td>--}}
{{--        </tr>--}}
        </tbody>
    </table>
</div>

<!--/Data grid-->
