<nav class="navbar-expand-lg navbar tp-header">
	<span class="menu-toggler" id="menu-toggle">
		<span class="line"></span>
	</span>


    <div class="dropdown ml-auto mt-0 mt-lg-0">
        <a href="javascript:void(0);" class="my-profile-info" data-toggle="dropdown">
            <div class="avatar">
                <img
                    src="{{ Auth::user()->photo ? asset('media/'.Auth::user()->photo) : asset('backend/images/avatar.png') }}">
            </div>
            <div class="my-profile">
                <span>{{ Auth::user()->name }}</span>
                <span>{{ Auth::user()->email }}</span>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right my-profile-nav">

            <a class="dropdown-item" href="{{ route('backend.profile') }}">{{ __('Profile') }}</a>


            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
				document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</nav>
