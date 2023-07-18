<div class="sidebar-wrapper">
    <div class="logo">
        <a href="{{ route('backend.dashboard')}}">
            <img
                src="{{ $gtext['back_logo'] ? asset('media/'.$gtext['back_logo']) : asset('backend/images/backend-logo.png') }}"
                alt="logo">
        </a>
    </div>
    <ul class="left-navbar">
        <li><a href="{{ route('backend.dashboard') }}"><i class="fa fa-tachometer"></i>{{ __('Dashboard') }}</a></li>

        @if (Auth::user()->role_id == 1)
            <li><a href="{{ route('backend.media') }}"><i class="fa fa-picture-o"></i>{{ __('Media') }}</a></li>
            <li><a href="{{ route('backend.MultipleSites') }}" id="select_MultipleSites"><i
                        class="fa fa-globe"></i>{{ __('Multiple Sites') }}</a></li>
            <li><a href="{{ route('backend.users') }}"><i class="fa fa-user-plus"></i>{{ __('Users') }}</a></li>
            <li><a href="{{ route('backend.track_read_time') }}"><i class="fa fa-line-chart"></i>{{ __('Track Read Time') }}</a></li>
        @elseif (Auth::user()->role_id == 3)
            <li><a href="{{ route('backend.MultipleSites') }}" id="select_MultipleSites"><i
                        class="fa fa-globe"></i>{{ __('Sites') }}</a></li>

        @endif
    </ul>
</div>
