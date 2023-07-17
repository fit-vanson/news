@extends('layouts.backend')

@section('title', __('News'))

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
                                <!--Data grid-->
                                <div id="list-panel">
                                    <div class="row">


                                        <div class="col-lg-3">
                                            <div class="form-group search-box">
                                                <input type="text" name="site_id" id="site_id" class="dnone"
                                                       value="{{$datalist['id']}}">
                                                <input id="search" name="search" type="text" class="form-control"
                                                       placeholder="{{ __('Search') }}...">
                                                <button type="submit" onClick="onSearch()"
                                                        class="btn search-btn">{{ __('Search') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tp_datalist">
                                        @include('backend.partials.track_news_table')
                                    </div>
                                </div>
                                <!--/Data grid/-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /main Section -->


@endsection

@push('scripts')
    <script src="{{asset('backend/pages/track_news.js')}}"></script>



@endpush
