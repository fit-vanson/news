<ul class="tabs-nav">
    <li><a href="{{ route('backend.site', [@$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Site') }}</a></li>
    <li><a href="{{ route('backend.theme-options', ['site_id' => @$datalist['id']] )}}"><i class="fa fa-cog"></i>{{ __('Logo') }}</a></li>
    <li><a href="{{ route('backend.categories', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Categories') }}</a></li>
    <li><a id= "tabs_nav_site_news" href="{{ route('backend.news', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('News') }}</a></li>
    <li><a href="{{ route('backend.theme-options-seo', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('SEO') }}</a></li>
    <li><a href="{{ route('backend.theme-options-footer', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Footer') }}</a></li>
    <li><a href="{{ route('backend.theme-options-social-media', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('Social Media') }}</a></li>
    <li><a href="{{ route('backend.theme-options-ads-manage', ['site_id' => @$datalist['id']]) }}"><i class="fa fa-cog"></i>{{ __('ADS Manage') }}</a></li>
</ul>
