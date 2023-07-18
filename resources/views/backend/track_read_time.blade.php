@extends('layouts.backend')

@section('title', __('Track Read Time'))

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
                                    <span>{{ __('Track Read Time') }}</span>
                                </div>
                            </div>
                        </div>
                        <!--Data grid-->
                        <div id="list-panel" class="card-body">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group search-box">
                                        <input id="search" name="search" type="text" class="form-control"
                                               placeholder="{{ __('Search') }}...">
                                        <button type="submit" onClick="onSearch()"
                                                class="btn search-btn">{{ __('Search') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div id="tp_datalist">
                                @include('backend.partials.track_read_time_table')
                            </div>
                        </div>
                        <!--/Data grid/-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main Section -->
@endsection

@push('scripts')
    <script src="{{asset('backend/pages/track_read_time.js')}}"></script>
@endpush
