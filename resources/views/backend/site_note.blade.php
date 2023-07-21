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
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="about_desc">{{ __('Note') }}</label>
                                                <textarea name="site_note" id="site_note" class="form-control"
                                                          rows="30">{{ $datalist['site_note'] }}</textarea>
                                            </div>
                                        </div>

                                    </div>


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



@endsection

@push('scripts')

    <script src="{{asset('backend/pages/site_note.js')}}"></script>

@endpush
