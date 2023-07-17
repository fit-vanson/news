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
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-12">
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
                        <div class="card-body tabs-area p-0">
                            @include('backend.partials.theme_options_tabs_nav')
                            <div class="tabs-body">
                                <!--Data grid-->
                                <div id="list-panel">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group bulk-box">
                                                <select id="bulk-action" class="form-control">
                                                    <option value="">{{ __('Select Action') }}</option>
                                                    <option value="publish">{{ __('Publish') }}</option>
                                                    <option value="draft">{{ __('Draft') }}</option>
                                                    <option value="delete">{{ __('Delete Permanently') }}</option>
                                                </select>
                                                <button type="submit" onClick="onBulkAction()"
                                                        class="btn bulk-btn">{{ __('Apply') }}</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select name="category_id" id="category_id"
                                                        class="chosen-select form-control">
                                                    <option value="0"
                                                            selected="selected">{{ __('All Category') }}</option>
                                                    @foreach($categorylist as $row)

                                                        <option value="{{ $row->id }}">
                                                            {{ rawurldecode($row->name) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group search-box">
                                                <input id="search" name="search" type="text" class="form-control"
                                                       placeholder="{{ __('Search') }}...">
                                                <button type="submit" onClick="onSearch()"
                                                        class="btn search-btn">{{ __('Search') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tp_datalist">
                                        @include('backend.partials.news_table')
                                    </div>
                                </div>
                                <!--/Data grid/-->
                                <!--Data Entry Form-->
                                <div id="form-panel" class="card-body dnone">
                                    <form novalidate="" data-validate="parsley" id="DataEntry_formId">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="title">{{ __('Title') }}<span
                                                            class="red">*</span></label>
                                                    <input type="text" name="news_title" id="news_title"
                                                           class="form-control parsley-validated" data-required="true">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="slug">{{ __('Slug') }}<span class="red">*</span></label>
                                                    <input type="text" name="slug" id="slug"
                                                           class="form-control parsley-validated" data-required="true">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="slug">{{ __('Summary') }}<span
                                                            class="red">*</span></label>
                                                    <input type="text" name="summary" id="summary"
                                                           class="form-control parsley-validated" data-required="true">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group tpeditor">
                                                    <label for="content">{{ __('Description') }}<span
                                                            class="red">*</span></label>
                                                    <textarea name="content" id="content"
                                                              class="form-control parsley-validated"
                                                              data-required="true" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="slug">{{ __('Original Url') }}</label>
                                                    <input type="text" name="original_url" id="original_url"
                                                           class="form-control parsley-validated">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="is_publish">{{ __('Status') }}<span class="red">*</span></label>
                                                    <select name="is_publish" id="is_publish"
                                                            class="chosen-select form-control">
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
                                                    <label for="is_publish">{{ __('Breaking News') }}</label>
                                                    <select name="breaking_news" id="breaking_news"
                                                            class="chosen-select form-control">
                                                        @foreach($statuslist as $row)
                                                            <option value="{{ $row->id }}">
                                                                {{ $row->status }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="cate_id">{{ __('Category') }}<span class="red">*</span></label>
                                                    <select name="cate_id" id="cate_id"
                                                            class="chosen-select form-control">
                                                        <option value="">{{ __('Select Category') }}</option>
                                                        @foreach($categorylist as $row)
                                                            <option value="{{ $row->id }}">
                                                                {{ rawurldecode($row->name) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="news_thumbnail">{{ __('Image') }}</label>
                                                    <div class="tp-upload-field">
                                                        <input type="text" name="thumbnail" id="news_thumbnail"
                                                               class="form-control" readonly>
                                                        <a id="on_thumbnail" href="javascript:void(0);"
                                                           class="tp-upload-btn"><i
                                                                class="fa fa-window-restore"></i>{{ __('Browse') }}</a>
                                                    </div>
                                                    <em>Recommended image size width: 400px and height: 400px.</em>
                                                    <div id="remove_news_thumbnail" class="select-image">
                                                        <div class="inner-image" id="view_news_thumbnail"></div>
                                                        <a onClick="onMediaImageRemove('news_thumbnail')"
                                                           class="media-image-remove" href="javascript:void(0);"><i
                                                                class="fa fa-remove"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="divider_heading">{{ __('SEO') }}</div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="og_title">{{ __('SEO Title') }}</label>
                                                    <input type="text" name="og_title" id="og_title"
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="og_keywords">{{ __('SEO Keywords') }}</label>
                                                    <input type="text" name="og_keywords" id="og_keywords"
                                                           class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="og_description">{{ __('SEO Description') }}</label>
                                                    <textarea name="og_description" id="og_description"
                                                              class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="og_image">{{ __('Open Graph Image') }}</label>
                                                    <div class="tp-upload-field">
                                                        <input type="text" name="og_image" id="og_image"
                                                               class="form-control" readonly>
                                                        <a id="on_og_image" href="javascript:void(0);"
                                                           class="tp-upload-btn"><i
                                                                class="fa fa-window-restore"></i>{{ __('Browse') }}</a>
                                                    </div>
                                                    <em>e.g. Facebook share image. Recommended image size width: 600px
                                                        and height: 315px.</em>
                                                    <div id="remove_og_image" class="select-image">
                                                        <div class="inner-image" id="view_og_image"></div>
                                                        <a onClick="onMediaImageRemove('og_image')"
                                                           class="media-image-remove" href="javascript:void(0);"><i
                                                                class="fa fa-remove"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6"></div>
                                        </div>

                                        <input type="text" name="RecordId" id="RecordId" class="dnone">
                                        <input type="text" name="site_id" id="site_id" class="dnone"
                                               value="{{$datalist['id']}}">

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
    @include('backend.partials.global_media')
    <!--/Global Media/-->

@endsection

@push('scripts')
    <!-- css/js -->
    <script type="text/javascript">
        var media_type = 'Thumbnail';
        var TEXT = [];
        TEXT['Do you really want to edit this record'] = "{{ __('Do you really want to edit this record') }}";
        TEXT['Do you really want to delete this record'] = "{{ __('Do you really want to delete this record') }}";
        TEXT['Do you really want to publish this records'] = "{{ __('Do you really want to publish this records') }}";
        TEXT['Do you really want to draft this records'] = "{{ __('Do you really want to draft this records') }}";
        TEXT['Do you really want to delete this records'] = "{{ __('Do you really want to delete this records') }}";
        TEXT['Please select action'] = "{{ __('Please select action') }}";
        TEXT['Please select record'] = "{{ __('Please select record') }}";
    </script>
    <link href="{{asset('backend/editor/summernote-lite.min.css')}}" rel="stylesheet">
    <script src="{{asset('backend/editor/summernote-lite.min.js')}}"></script>
    <script src="{{asset('backend/pages/news.js')}}"></script>
    <script src="{{asset('backend/pages/global-media.js')}}"></script>
@endpush
