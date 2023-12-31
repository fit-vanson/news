@extends('layouts.backend')

@section('title', 'Page Not Found')

@section('content')
    <!-- main Section -->
    <div class="main-body">
        <div class="container-fluid">
            <div class="row mt-15">
                <div class="col-lg-12">
                    <div class="alert alert-danger" role="alert">
                        {{ __('You do not have permission to access this page') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main Section -->
@endsection

@push('scripts')
@endpush
