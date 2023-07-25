@extends('layouts.backend')

@section('title', __('Users'))

@section('content')
    <!-- main Section -->
    <div class="main-body">
        <div class="container-fluid">
            <div class="row mt-25">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-6">
                                    <span>{{ __('Users') }}</span>
                                </div>
                                <div class="col-lg-6">
                                    <div class="float-right">
                                        <a onClick="onFormPanel()" href="javascript:void(0);"
                                           class="btn blue-btn btn-form float-right"><i
                                                class="fa fa-plus"></i> {{ __('Add New') }}</a>
                                        <a onClick="onListPanel()" href="javascript:void(0);"
                                           class="btn warning-btn btn-list float-right dnone"><i
                                                class="fa fa-reply"></i> {{ __('Back to List') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Data grid-->
                        <div id="list-panel" class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group bulk-box">
                                        <select id="bulk-action" class="form-control">
                                            <option value="">{{ __('Select Action') }}</option>
                                            <option value="active">{{ __('Active') }}</option>
                                            <option value="inactive">{{ __('Inactive') }}</option>
                                            <option value="delete">{{ __('Delete Permanently') }}</option>
                                        </select>
                                        <button type="submit" onClick="onBulkAction()"
                                                class="btn bulk-btn">{{ __('Apply') }}</button>
                                    </div>
                                </div>
                                <div class="col-lg-3"></div>
                                <div class="col-lg-5">
                                    <div class="form-group search-box">
                                        <input id="search" name="search" type="text" class="form-control"
                                               placeholder="{{ __('Search') }}...">
                                        <button type="submit" onClick="onSearch()"
                                                class="btn search-btn">{{ __('Search') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div id="tp_datalist">
                                @include('backend.partials.users_table')
                            </div>
                        </div>
                        <!--/Data grid/-->

                        <!--/Data Entry Form-->
                        <div id="form-panel" class="card-body dnone">
                            <form novalidate="" data-validate="parsley" id="DataEntry_formId">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('Name') }}<span class="red">*</span></label>
                                            <input type="text" name="name" id="name"
                                                   class="form-control parsley-validated" data-required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">{{ __('Email Address') }}<span
                                                    class="red">*</span></label>
                                            <input type="email" name="email" id="email"
                                                   class="form-control parsley-validated" data-required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group relative">
                                            <label for="password">{{ __('Password') }}<span class="red">*</span></label>
                                            <span toggle="#password"
                                                  class="fa fa-eye field-icon toggle-password"></span>
                                            <input type="password" name="password" id="password"
                                                   class="form-control parsley-validated" data-required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">{{ __('Phone') }}</label>
                                            <input type="text" name="phone" id="phone" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">{{ __('Address') }}</label>
                                            <textarea name="address" id="address" class="form-control"
                                                      rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status_id">{{ __('Active/Inactive') }}<span class="red">*</span></label>
                                            <select name="status_id" id="status_id" class="chosen-select form-control">
                                                @foreach($statuslist as $row)
                                                    <option value="{{ $row->id }}">
                                                        {{ $row->status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role_id">{{ __('Role') }}<span class="red">*</span></label>
                                            <select name="role_id" id="role_id" class="chosen-select form-control">
                                                @foreach($roleslist as $row)
                                                    <option value="{{ $row->id }}">
                                                        {{ $row->role }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="photo_thumbnail">{{ __('Profile Photo') }}</label>
                                            <div class="tp-upload-field">
                                                <input type="text" name="photo" id="photo_thumbnail"
                                                       class="form-control" readonly>
                                                <a id="on_thumbnail" href="javascript:void(0);" class="tp-upload-btn"><i
                                                        class="fa fa-window-restore"></i>{{ __('Browse') }}</a>
                                            </div>
                                            <em>Recommended image size width: 200px and height: 200px.</em>
                                            <div id="remove_photo_thumbnail" class="select-image">
                                                <div class="inner-image" id="view_photo_thumbnail"></div>
                                                <a onClick="onMediaImageRemove('photo_thumbnail')"
                                                   class="media-image-remove" href="javascript:void(0);"><i
                                                        class="fa fa-remove"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>

                                <input type="text" id="RecordId" name="RecordId" class="dnone"/>

                                <div class="row tabs-footer mt-15">
                                    <div class="col-lg-12">
                                        <a id="submit-form" href="javascript:void(0);"
                                           class="btn blue-btn mr-10">{{ __('Save') }}</a>
                                        <a onClick="onListPanel()" href="javascript:void(0);"
                                           class="btn danger-btn">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--/Data Entry Form-->
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-6">
                                    <span>{{ __('Orders') }}</span>
                                </div>
                            </div>
                        </div>
                        <!--Data grid-->
                        <div class="card-body">
                            <div class="row mb-12">
                                <div class="filter-form-group pull-right">
                                    <input name="start_date" id="start_date" type="text" class="form-control" placeholder="yyyy-mm-dd">
                                    <input name="end_date" id="end_date" type="text" class="form-control" placeholder="yyyy-mm-dd">
                                    <button type="submit" onClick="onFilterAction()" class="btn btn-theme">{{ __('Filter') }}</button>
                                </div>
                            </div>
                                <div id="yearly_overview-container" class="pt-2">
                                    <canvas id="yearly_chart_canvas" height="200" width="905"></canvas>
                                </div>
{{--                                @include('backend.partials.orders_table')--}}
                            </div>
                        </div>
                        <!--/Data grid/-->
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
    <link rel="stylesheet" href="{{asset('backend/bootstrap-datetimepicker/bootstrap-fonticon.css')}}">
    <link rel="stylesheet" href="{{asset('backend/bootstrap-datetimepicker/bootstrap-datetimepicker.css')}}">
    <script src="{{asset('backend/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <!-- css/js -->
    <script type="text/javascript">
        var media_type = 'Thumbnail';
        var TEXT = [];
        TEXT['Do you really want to edit this record'] = "{{ __('Do you really want to edit this record') }}";
        TEXT['Do you really want to delete this record'] = "{{ __('Do you really want to delete this record') }}";
        TEXT['Do you really want to active this records'] = "{{ __('Do you really want to active this records') }}";
        TEXT['Do you really want to inactive this records'] = "{{ __('Do you really want to inactive this records') }}";
        TEXT['Do you really want to delete this records'] = "{{ __('Do you really want to delete this records') }}";
        TEXT['Please select action'] = "{{ __('Please select action') }}";
        TEXT['Please select record'] = "{{ __('Please select record') }}";

        $(function () {
            "use strict";
            $("#start_date").datetimepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayBtn: true,
                minView: 2
            });

            $("#end_date").datetimepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayBtn: true,
                minView: 2
            });
        });
    </script>
    <script src="{{asset('backend/pages/users.js')}}"></script>
    <script src="{{asset('backend/pages/global-media.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
@endpush
