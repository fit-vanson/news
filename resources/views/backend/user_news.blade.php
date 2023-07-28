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
                                    <span>{{ __('User') }}</span>
                                </div>
                            </div>
                        </div>

                        <!--Data grid-->
                        <div id="list-panel" class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="filter-form-group">
                                        <input name="start_date" id="start_date" type="text" class="form-control" placeholder="yyyy-mm-dd">
                                        <input name="end_date" id="end_date" type="text" class="form-control" placeholder="yyyy-mm-dd">
                                        <button type="submit" onClick="onFilterAction()" class="btn btn-theme">{{ __('Filter') }}</button>
                                    </div>
                                </div>

                                <div class="col-lg-6  ">
                                    <div class="filter-form-group pull-right">
                                        <button type="button" onClick="onExcelExport()" class="btn btn-theme mb0 btn-padding"><i class="fa fa-download"></i> {{ __('Excel') }}</button>

                                    </div>
                                </div>
                            </div>
                            <div id="tp_datalist">
                                @include('backend.partials.user_news_table')
                            </div>
                        </div>
                        <!--/Data grid/-->
                        <input type="text" id="RecordId" name="RecordId" class="dnone" value="{{$user->id}}"/>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main Section -->
@endsection

@push('scripts')
    <link rel="stylesheet" href="{{asset('backend/bootstrap-datetimepicker/bootstrap-fonticon.css')}}">
    <link rel="stylesheet" href="{{asset('backend/bootstrap-datetimepicker/bootstrap-datetimepicker.css')}}">
    <script src="{{asset('backend/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- css/js -->
    <script type="text/javascript">


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
    <script src="{{asset('backend/pages/user_news.js')}}"></script>

@endpush
