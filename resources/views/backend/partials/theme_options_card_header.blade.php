<div class="card-header">
    <div class="row">
        <div class="col-lg-4">
            {{ __($datalist['title_row']) }}
        </div>
        <div class="col-lg-4">
            {{ $datalist['name'] .' ('.$datalist['web'].')' }}
        </div>
        <div class="col-lg-4">
            <div class="float-right">
                <a href="{{ route('backend.MultipleSites') }}" class="btn warning-btn"><i class="fa fa-reply"></i> {{ __('Back to List') }}</a>
            </div>
        </div>
    </div>
</div>
