@extends('layouts.backend')

@section('title', $datalist['title_row'])

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
                                    <input value="{{ $datalist['id'] }}" type="text" name="site_id" id="site_id"
                                           class="dnone">


                                    @foreach($datalist['socials_media'] as $key=>$social_media)

                                        <div class="divider_heading">{{ strtoupper($key) }}</div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="about_desc">{{ __('URL') }}</label>
                                                    <input value="{{ @$social_media['url'] }}" type="text"
                                                           name="socials_media[{{$key}}][url]" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="about_desc">{{ __('Followers') }}</label>
                                                    <input value="{{ @$social_media['followers'] }}" type="number"
                                                           name="socials_media[{{$key}}][followers]"
                                                           class="form-control">
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="is_publish_about">{{ __('Status') }}</label>
                                                    <select name="socials_media[{{$key}}][is_publish]"
                                                            class="chosen-select form-control">
                                                        @foreach($statuslist as $row)
                                                            <option
                                                                {{ $row->id == @$social_media['is_publish'] ? "selected=selected" : '' }} value="{{ $row->id }}">
                                                                {{ $row->status }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach


                                    <div class="row tabs-footer mt-15">
                                        <div class="col-lg-12">
                                            <a id="submit-form" href="javascript:void(0);"
                                               class="btn blue-btn">{{ __('Save') }}</a>
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
    {{--@include('backend.partials.global_media')--}}
    <!--/Global Media/-->

@endsection

@push('scripts')

    <script src="{{asset('backend/pages/theme_option_social_media.js')}}"></script>

@endpush
