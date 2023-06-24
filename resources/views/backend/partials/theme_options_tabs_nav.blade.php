<ul class="tabs-nav">
    <li><a href="{{ route('backend.site', [@$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Site') }}</a></li>
    <li><a href="{{ route('backend.theme-options', ['site_id' => @$datalist['id']] )}}"><i class="fa fa-cog"></i>{{ __('Logo') }}</a></li>
    <li><a href="{{ route('backend.categories', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Categories') }}</a></li>
    <li><a href="{{ route('backend.news', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('News') }}</a></li>
    <li><a href="{{ route('backend.theme-options-seo', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('SEO') }}</a></li>
    <li><a href="{{ route('backend.theme-options-footer', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Footer') }}</a></li>

    <li><a href="{{ route('backend.theme-options-social-media', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Social Media') }}</a></li>

    <li><a href="{{ route('backend.theme-options-ads-manage', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('ADS Manage') }}</a></li>


    <li><a href="{{ route('backend.offer-ads', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Offer & Ads') }}</a></li>



    {{--    <li><a href="{{ route('backend.slider', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Home Slider') }}</a></li>
        <li><a href="{{ route('backend.offer-ads', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Offer & Ads') }}</a></li>
        <li><a href="{{ route('backend.home-video', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Home Video Section') }}</a></li>


        <li><a href="{{ route('backend.theme-options-header', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Header') }}</a></li>
        <li><a href="{{ route('backend.theme-options-footer', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Footer') }}</a></li>

        <li><a href="{{ route('backend.subscribe-settings',['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Subscribe Settings') }}</a></li>


        <li><a href="{{ route('backend.language-switcher', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Language Switcher') }}</a></li>
        <li><a href="{{ route('backend.theme-options-color', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Color') }}</a></li>
        <li><a href="{{ route('backend.social-media', [@$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Social Media') }}</a></li>
        <li><a href="{{ route('backend.theme-options-seo', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('SEO') }}</a></li>
        <li><a href="{{ route('backend.theme-options-facebook', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Facebook APP ID') }}</a></li>
        <li><a href="{{ route('backend.theme-options-facebook-pixel', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Facebook Pixel') }}</a></li>
        <li><a href="{{ route('backend.theme-options-twitter', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Twitter') }}</a></li>
        <li><a href="{{ route('backend.google-analytics', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Google Analytics') }}</a></li>
        <li><a href="{{ route('backend.google-tag-manager', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Google Tag Manager') }}</a></li>
        <li><a href="{{ route('backend.theme-options-whatsapp', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Whatsapp') }}</a></li>
        <li><a href="{{ route('backend.theme-options-telegram', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Telegram') }}</a></li>
        <li><a href="{{ route('backend.custom-css', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Custom CSS') }}</a></li>
        <li><a href="{{ route('backend.custom-js', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Custom JS') }}</a></li>
        <li><a href="{{ route('backend.bank-transfer', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Bank Transfer') }}</a></li>
        <li><a href="{{ route('backend.currency', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Currency') }}</a></li>
        <li><a href="{{ route('backend.currency') }}">{{ __('Currency') }}</a></li>--}}

</ul>
