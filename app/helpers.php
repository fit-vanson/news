<?php

use App\Models\Brand;
use App\Models\Language;
use App\Models\Media_option;
use App\Models\Site_option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Tp_option;
use App\Models\Media_setting;
use App\Models\Menu;
use App\Models\Menu_parent;
use App\Models\Mega_menu;
use App\Models\Menu_child;
use App\Models\Pro_category;
use App\Models\Attribute;
use App\Models\Tax;
use App\Models\Order_master;
use App\Models\Social_media;
use App\Models\Section_manage;
use Illuminate\Support\Facades\Auth;


function get_ip(){
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else if (isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
        $ipaddress= $_SERVER["HTTP_CF_CONNECTING_IP"];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function getSite(){
    $server = \request()->getHost();
    $site = \App\Models\MultipleSites::where('site_web',$server)->where('is_publish',1)->first();
    return $site;
}





//Get data for Language locale
function glan(){
	$lan = app()->getLocale();

	return $lan;
}










//Get data for Language
function language(){

	$locale_language = glan();

	$data = Language::where('status', 1)->orderBy('language_name', 'ASC')->get();

	$base_url = url('/');

	$language = '';
	$selected_language = '';
	foreach ($data as $row){
		if($locale_language == $row['language_code']){
			$selected_language = $row['language_name'];
		}

		$language .= '<li><a class="dropdown-item" href="'.$base_url.'/lang/'.$row['language_code'].'">'.$row['language_name'].'</a></li>';
	}

	$languageList = '<div class="btn-group language-menu">
					<a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bi bi-translate"></i>'.$selected_language.'
					</a>
					<ul class="dropdown-menu dropdown-menu-end">
						'.$language.'
					</ul>
				</div>';

	return $languageList;
}

function thumbnail($type){


	$datalist = array('width' => '', 'height' => '');
	$data = Media_setting::where('media_type', $type)->first();
	$datalist = array(
		'width' => $data['media_width'],
		'height' => $data['media_height']
	);

	return $datalist;
}

function str_slug($str) {

	$str_slug = Str::slug($str, "-");

	return $str_slug;
}


function esc($string){
	$string = (string) $string;

	if ( 0 === strlen($string) ) {
		return '';
	}

	$string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');

	return $string;
}

function htmlDecode($string)
{
    $string = (string) $string;

    if (strlen($string) === 0) {
        return '';
    }

    $decodedString = html_entity_decode($string, ENT_QUOTES, 'UTF-8');

    return $decodedString;
}



function saveOptions($site_option,$data){
    $res = array();
    if($site_option){
        $response = $site_option->update($data);
        if($response){
            $res['msgType'] = 'success';
            $res['msg'] = __('Data Updated Successfully');
        }else{
            $res['msgType'] = 'error';
            $res['msg'] = __('Data update failed');
        }
    }else{
        $site_options = Site_option::create($data);
        $response = $site_options->save();
        if($response){
            $res['msgType'] = 'success';
            $res['msg'] = __('Data Updated Successfully');
        }else{
            $res['msgType'] = 'error';
            $res['msg'] = __('Data update failed');
        }
    }
    return $res;
}


function getSiteInfo(){

    $site = getSite();
    if($site){
        $site_option = $site->site_options;
    }
    $data = array();

    $general_settings = $site_option->general_settings ?? null ;
    if($general_settings){
        $general_settingsData = json_decode($general_settings);
        $data['site_name'] = $site->site_name;
        $data['site_title'] = $general_settingsData->site_title;
        $data['company'] = $general_settingsData->company;
        $data['invoice_email'] = $general_settingsData->email;
        $data['invoice_phone'] = $general_settingsData->phone;
        $data['invoice_address'] = $general_settingsData->address;
        $data['timezone'] = $general_settingsData->timezone;
    }else{
        $data['site_name'] = 'zxcv';
        $data['site_title'] = 'xxxx';
        $data['company'] = '';
        $data['invoice_email'] = '';
        $data['invoice_phone'] = '';
        $data['invoice_address'] = '';
        $data['timezone'] = '';
    }

    //theme_logo
    $theme_logo = $site_option->theme_logo ?? null ;
    if($theme_logo){
        $theme_logoData = json_decode($theme_logo);
        $data['favicon'] = $theme_logoData->favicon;
        $data['front_logo'] = $theme_logoData->front_logo;
        $data['back_logo'] = $theme_logoData->back_logo;
    }else{
        $data['favicon'] = '';
        $data['front_logo'] = '';
        $data['back_logo'] = '';
    }

    //currency
    $currency = $site_option->currency ?? null ;
    if($currency){
        $currencyData = json_decode($currency);
//		$currencyObj = json_decode($currencyData[0]->option_value);
        $data['currency_name'] = $currencyData->currency_name;
        $data['currency_icon'] = $currencyData->currency_icon;
        $data['currency_position'] = $currencyData->currency_position;
        $data['thousands_separator'] = $currencyData->thousands_separator ?? ',';
        $data['decimal_separator'] = $currencyData->decimal_separator ?? '.';
        $data['decimal_digit'] = $currencyData->decimal_digit ?? 2;
    }else{
        $data['currency_name'] = '';
        $data['currency_icon'] = '';
        $data['currency_position'] = '';
        $data['thousands_separator'] = ',';
        $data['decimal_separator'] = '.';
        $data['decimal_digit'] = 2;
    }


    $theme_option_header =  $site_option->theme_option_header ?? null ;
    if($theme_option_header){
        $theme_option_headerData = json_decode($theme_option_header);
//		$theme_option_headerObj = json_decode($theme_option_headerData[0]->option_value);
        $data['address'] = $theme_option_headerData->address;
        $data['phone'] = $theme_option_headerData->phone;
        $data['is_publish'] = $theme_option_headerData->is_publish;
    }else{
        $data['address'] = '';
        $data['phone'] = '';
        $data['is_publish'] = '';
    }

    //Language Switcher
    $language_switcher_data =  $site_option->language_switcher ?? null ;


    if($language_switcher_data){
        $wsData = json_decode($language_switcher_data);
        $data['is_language_switcher'] = $wsData->is_language_switcher;
    }else{
        $data['is_language_switcher'] = '';
    }

    //theme_option_footer
    $theme_option_footer =  $site_option->theme_option_footer ?? null ;
    if($theme_option_footer){
        $theme_option_footerObj = json_decode($theme_option_footer);
        $data['about_logo_footer'] = $theme_option_footerObj->about_logo;
        $data['about_desc_footer'] = $theme_option_footerObj->about_desc;
        $data['is_publish_about'] = $theme_option_footerObj->is_publish_about;
        $data['address_footer'] = $theme_option_footerObj->address;
        $data['email_footer'] = $theme_option_footerObj->email;
        $data['phone_footer'] = $theme_option_footerObj->phone;
        $data['is_publish_contact'] = $theme_option_footerObj->is_publish_contact;
        $data['copyright'] = $theme_option_footerObj->copyright;
        $data['is_publish_copyright'] = $theme_option_footerObj->is_publish_copyright;
        $data['payment_gateway_icon'] = $theme_option_footerObj->payment_gateway_icon;
        $data['is_publish_payment'] = $theme_option_footerObj->is_publish_payment;
    }else{
        $data['about_logo_footer'] = '';
        $data['about_desc_footer'] = '';
        $data['is_publish_about'] = '';
        $data['address_footer'] = '';
        $data['email_footer'] = '';
        $data['phone_footer'] = '';
        $data['is_publish_contact'] = '';
        $data['copyright'] = '';
        $data['is_publish_copyright'] = '';
        $data['payment_gateway_icon'] = '';
        $data['is_publish_payment'] = '';
    }

    //isRTL
    $isRTL = Language::where('language_code', app()->getLocale())->first();
    $data['is_rtl'] = $isRTL['is_rtl'];

    //facebook
    $facebook = $site_option->facebook ?? null ;
    if($facebook){
        $facebookObj = json_decode($facebook);
        $data['fb_app_id'] = $facebookObj->fb_app_id;
        $data['fb_publish'] = $facebookObj->is_publish;
    }else{
        $data['fb_app_id'] = '';
        $data['fb_publish'] = '';
    }

    //twitter
    $twitter = $site_option->twitter ?? null ;
    if($twitter){
        $twitterObj = json_decode($twitter);
        $data['twitter_id'] = $twitterObj->twitter_id;
        $data['twitter_publish'] = $twitterObj->is_publish;
    }else{
        $data['twitter_id'] = '';
        $data['twitter_publish'] = '';
    }

    //Theme Option SEO
    $theme_option_seo = $site_option->theme_option_seo ?? null ;
    if($theme_option_seo){
        $SEOObj = json_decode($theme_option_seo);
        $data['og_title'] = $SEOObj->og_title;
        $data['og_image'] = $SEOObj->og_image;
        $data['og_description'] = $SEOObj->og_description;
        $data['og_keywords'] = $SEOObj->og_keywords;
        $data['seo_publish'] = $SEOObj->is_publish;
    }else{
        $data['og_title'] = '';
        $data['og_image'] = '';
        $data['og_description'] = '';
        $data['og_keywords'] = '';
        $data['seo_publish'] = '';
    }

    //Theme Option Facebook Pixel
    $theme_option_facebook_pixel = $site_option->facebook_pixel ?? null ;
    if($theme_option_facebook_pixel){
        $fb_PixelObj = json_decode($theme_option_facebook_pixel);
        $data['fb_pixel_id'] = $fb_PixelObj->fb_pixel_id;
        $data['fb_pixel_publish'] = $fb_PixelObj->is_publish;
    }else{
        $data['fb_pixel_id'] = '';
        $data['fb_pixel_publish'] = '';
    }

    //Theme Option Google Analytics
    $theme_option_google_analytics = $site_option->google_analytics ?? null ;
    if($theme_option_google_analytics){
        $gaObj = json_decode($theme_option_google_analytics);
        $data['tracking_id'] = $gaObj->tracking_id;
        $data['ga_publish'] = $gaObj->is_publish;
    }else{
        $data['tracking_id'] = '';
        $data['ga_publish'] = '';
    }

    //Theme Option Google Tag Manager
    $theme_option_google_tag_manager = $site_option->google_tag_manager ?? null ;


    if($theme_option_google_tag_manager){
        $gtmObj = json_decode($theme_option_google_tag_manager);
        $data['google_tag_manager_id'] = $gtmObj->google_tag_manager_id;
        $data['gtm_publish'] = $gtmObj->is_publish;
    }else{
        $data['google_tag_manager_id'] = '';
        $data['gtm_publish'] = '';
    }

    //Google Recaptcha
    $theme_option_google_recaptcha = Tp_option::where('option_name', 'google_recaptcha')->get();

    $google_recaptcha_id = '';
    foreach ($theme_option_google_recaptcha as $row){
        $google_recaptcha_id = $row->id;
    }

    if($google_recaptcha_id != ''){
        $grData = json_decode($theme_option_google_recaptcha);
        $grObj = json_decode($grData[0]->option_value);
        $data['sitekey'] = $grObj->sitekey;
        $data['secretkey'] = $grObj->secretkey;
        $data['is_recaptcha'] = $grObj->is_recaptcha;
    }else{
        $data['sitekey'] = '';
        $data['secretkey'] = '';
        $data['is_recaptcha'] = '';
    }

    //Google Map
    $theme_option_google_map = Tp_option::where('option_name', 'google_map')->get();

    $google_map_id = '';
    foreach ($theme_option_google_map as $row){
        $google_map_id = $row->id;
    }

    if($google_map_id != ''){
        $gmData = json_decode($theme_option_google_map);
        $gmObj = json_decode($gmData[0]->option_value);
        $data['googlemap_apikey'] = $gmObj->googlemap_apikey;
        $data['is_googlemap'] = $gmObj->is_googlemap;
    }else{
        $data['googlemap_apikey'] = '';
        $data['is_googlemap'] = '';
    }

    //Theme Color
    $theme_color = $site_option->theme_color ?? null ;

    if($theme_color){
        $tcObj = json_decode($theme_color);
        $data['theme_color'] = $tcObj->theme_color;
        $data['green_color'] = $tcObj->green_color;
        $data['light_green_color'] = $tcObj->light_green_color;
        $data['lightness_green_color'] = $tcObj->lightness_green_color;
        $data['gray_color'] = $tcObj->gray_color;
        $data['dark_gray_color'] = $tcObj->dark_gray_color;
        $data['light_gray_color'] = $tcObj->light_gray_color;
        $data['black_color'] = $tcObj->black_color;
        $data['white_color'] = $tcObj->white_color;
    }else{
        $data['theme_color'] = '#61a402';
        $data['green_color'] = '#65971e';
        $data['light_green_color'] = '#daeac5';
        $data['lightness_green_color'] = '#fdfff8';
        $data['gray_color'] = '#8d949d';
        $data['dark_gray_color'] = '#595959';
        $data['light_gray_color'] = '#e7e7e7';
        $data['black_color'] = '#232424';
        $data['white_color'] = '#ffffff';
    }

    //Mail Settings
    $theme_option_mail_settings = $site_option->mail_settings ?? null ;
    if($theme_option_mail_settings){
        $msObj = json_decode($theme_option_mail_settings);
        $data['ismail'] = $msObj->ismail;
        $data['from_name'] = $msObj->from_name;
        $data['from_mail'] = $msObj->from_mail;
        $data['to_name'] = $msObj->to_name;
        $data['to_mail'] = $msObj->to_mail;
        $data['mailer'] = $msObj->mailer;
        $data['smtp_host'] = $msObj->smtp_host;
        $data['smtp_port'] = $msObj->smtp_port;
        $data['smtp_security'] = $msObj->smtp_security;
        $data['smtp_username'] = $msObj->smtp_username;
        $data['smtp_password'] = $msObj->smtp_password;
    }else{
        $data['ismail'] = '';
        $data['from_name'] = '';
        $data['from_mail'] = '';
        $data['to_name'] = '';
        $data['to_mail'] = '';
        $data['mailer'] = '';
        $data['smtp_host'] = '';
        $data['smtp_port'] = '';
        $data['smtp_security'] = '';
        $data['smtp_username'] = '';
        $data['smtp_password'] = '';
    }

    //theme_option_social_media
    $theme_option_social_media =  $site_option->theme_option_social_media ?? null ;
    if($theme_option_social_media){
        $theme_option_social_mediaArr= json_decode($theme_option_social_media,true);
        $social_mediaArr = [];
        foreach ($theme_option_social_mediaArr as $key=>$value ){
            if ($value['is_publish'] == 1) {
                $social_mediaArr[$key] = $value;
            }
        }
        $data['social_media'] = $social_mediaArr;

    }else{
        $data['social_media'] = null;
    }

    //theme_option_ads_manage
    $theme_option_ads_manage =  $site_option->theme_option_ads_manage ?? null ;
    if($theme_option_ads_manage){
        $theme_option_ads_manageaArr= json_decode($theme_option_ads_manage,true);
        foreach ($theme_option_ads_manageaArr as $key=>$ads_manage){
            $data[$key] = $ads_manage;
        }
    }


    return $data;
}

function allCategories(){
    $allCategories = \App\Models\Categories::orderBy('id')
        ->get();
    return $allCategories ;
}

function getCategoriesSite(){
    $site = getSite();
    $categories = collect();
    if($site){
        $categories = $site->categories()
            ->where('is_publish', 1)
            ->whereHas('news', function ($query) {
                $query->where('is_publish', 1);
            })
            ->get();
    }
    return  $categories;
}


function getNewsBreakingSite(){
    $site = getSite();
    $newsBreaking = collect();
    if ($site){
        $newsQuery = $site->news()
            ->with('categories')
            ->where('news.is_publish', 1);

        $newsCount = $newsQuery->count();
        $limit = min($newsCount, 3);
        $newsBreaking = $newsQuery->where('news.breaking_news', 1)->take($limit)->get();
    }
    return  $newsBreaking;
}

function getNewsViewersSite(){
    $site = getSite();
    $newsViewers = collect();
    if ($site){
        $newsQuery = $site->news()
            ->with('categories')
            ->where('news.is_publish', 1);

        $newsCount = $newsQuery->count();
        $limit = min($newsCount, 3);
        $newsViewers = ($limit > 0) ? $newsQuery->orderBy('news.viewers', 'desc')->take($limit)->get() : collect();
    }
    return  $newsViewers;
}





