<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Media_option;
use App\Models\MultipleSites;
use App\Models\Site_option;
use App\Models\Tp_option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ThemeOptionsController extends Controller
{
    //Theme Options page load
    public function getThemeOptionsPageLoad()
    {
        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Logo',
            'favicon' => '',
            'front_logo' => '',
            'back_logo' => '',
        ];
        if (isset($site_option)) {
            $results = $site_option->theme_logo;
            if ($results) {
                $dataObj = json_decode($results);
                $data['favicon'] = $dataObj->favicon;
                $data['front_logo'] = $dataObj->front_logo;
                $data['back_logo'] = $dataObj->back_logo;
            }
        }

        $datalist = $data;

        $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);

        return view('backend.theme-options', compact('datalist', 'media_datalist'));
    }

    //Save data for Theme Logo
    public function saveThemeLogo(Request $request)
    {
        $id = $request->input('site_id');
        $favicon = $request->input('favicon');
        $front_logo = $request->input('front_logo');
        $back_logo = $request->input('back_logo');

        $validator_array = array(
            'favicon' => $request->input('favicon'),
            'front_logo' => $request->input('front_logo'),
            'back_logo' => $request->input('back_logo')
        );

        $validator = Validator::make($validator_array, [
            'favicon' => 'required',
            'front_logo' => 'required',
            'back_logo' => 'required'
        ]);

        $errors = $validator->errors();

        if ($errors->has('favicon')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('favicon');
            return response()->json($res);
        }

        if ($errors->has('front_logo')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('front_logo');
            return response()->json($res);
        }

        if ($errors->has('back_logo')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('back_logo');
            return response()->json($res);
        }

        $option = array(
            'favicon' => $favicon,
            'front_logo' => $front_logo,
            'back_logo' => $back_logo
        );

        $site_option = Site_option::where('site_id', $id)->first();
        $data = array(
            'site_id' => $id,
            'theme_logo' => json_encode($option)
        );
        $res = saveOptions($site_option, $data);
        return response()->json($res);
    }

    //Theme Options Header page load
    public function getThemeOptionsHeaderPageLoad()
    {
        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Header',
            'address' => '',
            'phone' => '',
            'is_publish' => '',
        ];

        if (isset($site_option)) {
            $results = $site_option->theme_option_header;
            if ($results) {
                $dataObj = json_decode($results);
                $data['address'] = $dataObj->address;
                $data['phone'] = $dataObj->phone;
                $data['is_publish'] = $dataObj->is_publish;
            }
        }

        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        $datalist = $data;

        return view('backend.theme-options-header', compact('datalist', 'statuslist'));
    }

    //Save data for Theme Options Header
    public function saveThemeOptionsHeader(Request $request)
    {

        $id = $request->input('site_id');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $is_publish = $request->input('is_publish');

        $option = array(
            'address' => $address,
            'phone' => $phone,
            'is_publish' => $is_publish
        );

        $data = array(
            'site_id' => $id,
            'theme_option_header' => json_encode($option)
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }

    //Language Switcher page load
    public function getLanguageSwitcher()
    {
        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();
        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Logo',
            'is_language_switcher' => '2',
        ];
        if (isset($site_option)) {
            $results = $site_option->language_switcher;
            if ($results) {
                $dataObj = json_decode($results);
                $data['is_language_switcher'] = $dataObj->is_language_switcher;
            }
        }

        $datalist = $data;
        return view('backend.language-switcher', compact('datalist', 'statuslist'));
    }

    //Save data for Language Switcher
    public function saveLanguageSwitcher(Request $request)
    {
        $id = $request->input('site_id');
        $is_language_switcher = $request->input('is_language_switcher');

        $option = array(
            'is_language_switcher' => $is_language_switcher
        );

        $data = array(
            'site_id' => $id,
            'language_switcher' => json_encode($option)
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }

    //Theme Options Footer page load
    public function getThemeOptionsFooterPageLoad()
    {
        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();
        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Footer',

            'about_logo' => '',
            'about_desc' => '',
            'is_publish_about' => '2',
            'address' => '',
            'email' => '',
            'phone' => '',
            'is_publish_contact' => '2',
            'copyright' => '',
            'is_publish_copyright' => '2',
            'payment_gateway_icon' => '',
            'is_publish_payment' => '2',
        ];

        if (isset($site_option)) {
            $results = $site_option->theme_option_footer;
            if ($results) {
                $dataObj = json_decode($results);
                $data['about_logo'] = $dataObj->about_logo;
                $data['about_desc'] = $dataObj->about_desc;
                $data['is_publish_about'] = $dataObj->is_publish_about;
                $data['address'] = $dataObj->address;
                $data['email'] = $dataObj->email;
                $data['phone'] = $dataObj->phone;
                $data['is_publish_contact'] = $dataObj->is_publish_contact;
                $data['copyright'] = $dataObj->copyright;
                $data['is_publish_copyright'] = $dataObj->is_publish_copyright;
                $data['payment_gateway_icon'] = $dataObj->payment_gateway_icon;
                $data['is_publish_payment'] = $dataObj->is_publish_payment;
            }
        }
        $datalist = $data;

        $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);

        return view('backend.theme-options-footer', compact('datalist', 'media_datalist', 'statuslist'));
    }

    //Save data for Theme Options Footer
    public function saveThemeOptionsFooter(Request $request)
    {
        $id = $request->input('site_id');
        $about_logo = $request->input('about_logo');
        $about_desc = $request->input('about_desc');
        $is_publish_about = $request->input('is_publish_about');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $is_publish_contact = $request->input('is_publish_contact');
        $copyright = $request->input('copyright');
        $is_publish_copyright = $request->input('is_publish_copyright');
        $payment_gateway_icon = $request->input('payment_gateway_icon');
        $is_publish_payment = $request->input('is_publish_payment');

        $option = array(
            'about_logo' => $about_logo,
            'about_desc' => $about_desc,
            'is_publish_about' => $is_publish_about,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'is_publish_contact' => $is_publish_contact,
            'copyright' => $copyright,
            'is_publish_copyright' => $is_publish_copyright,
            'payment_gateway_icon' => $payment_gateway_icon,
            'is_publish_payment' => $is_publish_payment
        );

        $data = array(
            'site_id' => $id,
            'theme_option_footer' => json_encode($option)
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }

    //Custom CSS page load
    public function getCustomCSSPageLoad()
    {
        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Custom CSS',

            'custom_css' => '',
        ];
        if (isset($site_option)) {
            $results = $site_option->custom_css;
            if ($results) {
                $data['custom_css'] = $results;
            }
        }
        $datalist = $data;
        return view('backend.custom-css', compact('datalist'));
    }

    //Save data for Custom CSS
    public function saveCustomCSS(Request $request)
    {

        $id = $request->input('site_id');
        $custom_css = $request->input('custom_css');

        $data = array(
            'site_id' => $id,
            'custom_css' => $custom_css
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }

    //Custom JS page load
    public function getCustomJSPageLoad()
    {
        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Custom JS',

            'custom_js' => '',
        ];

        if (isset($site_option)) {
            $results = $site_option->custom_css;
            if ($results) {
                $data['custom_css'] = $results;
            }
        }

        $datalist = $data;

        return view('backend.custom-js', compact('datalist'));
    }

    //Save data for Custom JS
    public function saveCustomJS(Request $request)
    {
        $id = $request->input('site_id');
        $custom_js = $request->input('custom_js');

        $data = array(
            'site_id' => $id,
            'custom_js' => $custom_js
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }

    //Theme Options SEO page load
    public function getThemeOptionsSEOPageLoad()
    {
        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();
        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'SEO',

            'og_title' => '',
            'og_image' => '',
            'og_description' => '',
            'og_keywords' => '',
            'is_publish' => '2',
        ];

        if (isset($site_option)) {
            $results = $site_option->theme_option_seo;
            if ($results) {
                $dataObj = json_decode($results);
                $data['og_title'] = $dataObj->og_title;
                $data['og_image'] = $dataObj->og_image;
                $data['og_description'] = $dataObj->og_description;
                $data['og_keywords'] = $dataObj->og_keywords;
                $data['is_publish'] = $dataObj->is_publish;
            }
        }
        $datalist = $data;

        $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);

        return view('backend.theme-options-seo', compact('datalist', 'media_datalist', 'statuslist'));
    }

    //Save data for Theme Options SEO
    public function saveThemeOptionsSEO(Request $request)
    {

        $id = $request->input('site_id');
        $og_title = $request->input('og_title');
        $og_image = $request->input('og_image');
        $og_description = $request->input('og_description');
        $og_keywords = $request->input('og_keywords');
        $is_publish = $request->input('is_publish');

        $option = array(
            'og_title' => $og_title,
            'og_image' => $og_image,
            'og_description' => $og_description,
            'og_keywords' => $og_keywords,
            'is_publish' => $is_publish
        );

        $data = array(
            'site_id' => $id,
            'theme_option_seo' => json_encode($option)
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }

    //Theme Options Color page load
    public function getThemeOptionsColorPageLoad()
    {

        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Color',

            'theme_color' => '',
            'green_color' => '',
            'light_green_color' => '',
            'lightness_green_color' => '',
            'gray_color' => '',
            'dark_gray_color' => '',
            'light_gray_color' => '',
            'black_color' => '',
            'white_color' => '',
        ];
        if (isset($site_option)) {
            $results = $site_option->theme_color;
            if ($results) {
                $dataObj = json_decode($results);
                $data['theme_color'] = $dataObj->theme_color;
                $data['green_color'] = $dataObj->green_color;
                $data['light_green_color'] = $dataObj->light_green_color;
                $data['lightness_green_color'] = $dataObj->lightness_green_color;
                $data['gray_color'] = $dataObj->gray_color;
                $data['dark_gray_color'] = $dataObj->dark_gray_color;
                $data['light_gray_color'] = $dataObj->light_gray_color;
                $data['black_color'] = $dataObj->black_color;
                $data['white_color'] = $dataObj->white_color;
            }
        }
        $datalist = $data;

        return view('backend.theme-options-color', compact('datalist'));
    }

    //Save data for Theme Options Color
    public function saveThemeOptionsColor(Request $request)
    {
        $id = $request->input('site_id');

        $theme_color = $request->input('theme_color');
        $green_color = $request->input('green_color');
        $light_green_color = $request->input('light_green_color');
        $lightness_green_color = $request->input('lightness_green_color');
        $gray_color = $request->input('gray_color');
        $dark_gray_color = $request->input('dark_gray_color');
        $light_gray_color = $request->input('light_gray_color');
        $black_color = $request->input('black_color');
        $white_color = $request->input('white_color');

        $validator_array = array(
            'theme_color' => $request->input('theme_color'),
            'green_color' => $request->input('green_color'),
            'light_green_color' => $request->input('light_green_color'),
            'lightness_green_color' => $request->input('lightness_green_color'),
            'gray_color' => $request->input('gray_color'),
            'dark_gray_color' => $request->input('dark_gray_color'),
            'light_gray_color' => $request->input('light_gray_color'),
            'black_color' => $request->input('black_color'),
            'white_color' => $request->input('white_color')
        );

        $validator = Validator::make($validator_array, [
            'theme_color' => 'required',
            'green_color' => 'required',
            'light_green_color' => 'required',
            'lightness_green_color' => 'required',
            'gray_color' => 'required',
            'dark_gray_color' => 'required',
            'light_gray_color' => 'required',
            'black_color' => 'required',
            'white_color' => 'required'
        ]);

        $errors = $validator->errors();

        if ($errors->has('theme_color')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('theme_color');
            return response()->json($res);
        }

        if ($errors->has('green_color')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('green_color');
            return response()->json($res);
        }

        if ($errors->has('light_green_color')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('light_green_color');
            return response()->json($res);
        }

        if ($errors->has('lightness_green_color')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('lightness_green_color');
            return response()->json($res);
        }

        if ($errors->has('gray_color')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('gray_color');
            return response()->json($res);
        }

        if ($errors->has('dark_gray_color')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('dark_gray_color');
            return response()->json($res);
        }

        if ($errors->has('light_gray_color')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('light_gray_color');
            return response()->json($res);
        }

        if ($errors->has('black_color')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('black_color');
            return response()->json($res);
        }

        if ($errors->has('white_color')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('white_color');
            return response()->json($res);
        }

        $option = array(
            'theme_color' => $theme_color,
            'green_color' => $green_color,
            'light_green_color' => $light_green_color,
            'lightness_green_color' => $lightness_green_color,
            'gray_color' => $gray_color,
            'dark_gray_color' => $dark_gray_color,
            'light_gray_color' => $light_gray_color,
            'black_color' => $black_color,
            'white_color' => $white_color
        );

        $data = array(
            'site_id' => $id,
            'theme_color' => json_encode($option)
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }

    //Theme Options Facebook page load
    public function getThemeOptionsFacebookPageLoad()
    {

        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        $results = Tp_option::where('option_name', 'facebook')->get();

        $id = '';
        $fb_app_id = '';
        $is_publish = '2';
        foreach ($results as $row) {
            $id = $row->id;
        }

        $data = array();
        if ($id != '') {

            $sData = json_decode($results);
            $dataObj = json_decode($sData[0]->option_value);

            $data['fb_app_id'] = $dataObj->fb_app_id;
            $data['is_publish'] = $dataObj->is_publish;
        } else {
            $data['fb_app_id'] = '';
            $data['is_publish'] = '2';
        }

        $datalist = $data;

        return view('backend.theme-options-facebook', compact('datalist', 'statuslist'));
    }

    //Save data for Theme Options Facebook
    public function saveThemeOptionsFacebook(Request $request)
    {
        $res = array();

        $fb_app_id = $request->input('fb_app_id');
        $is_publish = $request->input('is_publish');

        $option = array(
            'fb_app_id' => $fb_app_id,
            'is_publish' => $is_publish
        );

        $data = array(
            'option_name' => 'facebook',
            'option_value' => json_encode($option)
        );

        $gData = Tp_option::where('option_name', 'facebook')->get();
        $id = '';
        foreach ($gData as $row) {
            $id = $row['id'];
        }

        if ($id == '') {
            $response = Tp_option::create($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('New Data Added Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data insert failed');
            }
        } else {
            $response = Tp_option::where('id', $id)->update($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }
        }

        return response()->json($res);
    }

    //Theme Options Facebook Pixel page load
    public function getThemeOptionsFacebookPixelLoad()
    {

        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        $results = Tp_option::where('option_name', 'facebook-pixel')->get();

        $id = '';
        $fb_pixel_id = '';
        $is_publish = '2';
        foreach ($results as $row) {
            $id = $row->id;
        }

        $data = array();
        if ($id != '') {

            $sData = json_decode($results);
            $dataObj = json_decode($sData[0]->option_value);

            $data['fb_pixel_id'] = $dataObj->fb_pixel_id;
            $data['is_publish'] = $dataObj->is_publish;
        } else {
            $data['fb_pixel_id'] = '';
            $data['is_publish'] = '2';
        }

        $datalist = $data;

        return view('backend.theme-options-facebook-pixel', compact('datalist', 'statuslist'));
    }

    //Save data for Theme Options Facebook Pixel
    public function saveThemeOptionsFacebookPixel(Request $request)
    {
        $res = array();

        $fb_pixel_id = $request->input('fb_pixel_id');
        $is_publish = $request->input('is_publish');

        $option = array(
            'fb_pixel_id' => $fb_pixel_id,
            'is_publish' => $is_publish
        );

        $data = array(
            'option_name' => 'facebook-pixel',
            'option_value' => json_encode($option)
        );

        $gData = Tp_option::where('option_name', 'facebook-pixel')->get();
        $id = '';
        foreach ($gData as $row) {
            $id = $row['id'];
        }

        if ($id == '') {
            $response = Tp_option::create($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('New Data Added Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data insert failed');
            }
        } else {
            $response = Tp_option::where('id', $id)->update($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }
        }

        return response()->json($res);
    }

    //Theme Options Twitter page load
    public function getThemeOptionsTwitterPageLoad()
    {

        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        $results = Tp_option::where('option_name', 'twitter')->get();

        $id = '';
        $twitter_id = '';
        $is_publish = '2';
        foreach ($results as $row) {
            $id = $row->id;
        }

        $data = array();
        if ($id != '') {

            $sData = json_decode($results);
            $dataObj = json_decode($sData[0]->option_value);

            $data['twitter_id'] = $dataObj->twitter_id;
            $data['is_publish'] = $dataObj->is_publish;
        } else {
            $data['twitter_id'] = '';
            $data['is_publish'] = '2';
        }

        $datalist = $data;

        return view('backend.theme-options-twitter', compact('datalist', 'statuslist'));
    }

    //Save data for Theme Options Twitter
    public function saveThemeOptionsTwitter(Request $request)
    {
        $res = array();

        $twitter_id = $request->input('twitter_id');
        $is_publish = $request->input('is_publish');

        $option = array(
            'twitter_id' => $twitter_id,
            'is_publish' => $is_publish
        );

        $data = array(
            'option_name' => 'twitter',
            'option_value' => json_encode($option)
        );

        $gData = Tp_option::where('option_name', 'twitter')->get();
        $id = '';
        foreach ($gData as $row) {
            $id = $row['id'];
        }

        if ($id == '') {
            $response = Tp_option::create($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('New Data Added Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data insert failed');
            }
        } else {
            $response = Tp_option::where('id', $id)->update($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }
        }

        return response()->json($res);
    }

    //Google Analytics page load
    public function getGoogleAnalytics()
    {

        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        $results = Tp_option::where('option_name', 'google_analytics')->get();

        $id = '';
        foreach ($results as $row) {
            $id = $row->id;
        }

        $data = array();
        if ($id != '') {

            $sData = json_decode($results);
            $dataObj = json_decode($sData[0]->option_value);

            $data['tracking_id'] = $dataObj->tracking_id;
            $data['is_publish'] = $dataObj->is_publish;
        } else {
            $data['tracking_id'] = '';
            $data['is_publish'] = '2';
        }

        $datalist = $data;

        return view('backend.google-analytics', compact('datalist', 'statuslist'));
    }

    //Save data for Google Analytics
    public function saveGoogleAnalytics(Request $request)
    {
        $res = array();

        $tracking_id = $request->input('tracking_id');
        $is_publish = $request->input('is_publish');

        $option = array(
            'tracking_id' => $tracking_id,
            'is_publish' => $is_publish
        );

        $data = array(
            'option_name' => 'google_analytics',
            'option_value' => json_encode($option)
        );

        $gData = Tp_option::where('option_name', 'google_analytics')->get();
        $id = '';
        foreach ($gData as $row) {
            $id = $row['id'];
        }

        if ($id == '') {
            $response = Tp_option::create($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('New Data Added Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data insert failed');
            }
        } else {
            $response = Tp_option::where('id', $id)->update($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }
        }

        return response()->json($res);
    }

    //Google Tag Manager page load
    public function getGoogleTagManager()
    {

        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        $results = Tp_option::where('option_name', 'google_tag_manager')->get();

        $id = '';
        foreach ($results as $row) {
            $id = $row->id;
        }

        $data = array();
        if ($id != '') {

            $sData = json_decode($results);
            $dataObj = json_decode($sData[0]->option_value);

            $data['google_tag_manager_id'] = $dataObj->google_tag_manager_id;
            $data['is_publish'] = $dataObj->is_publish;
        } else {
            $data['google_tag_manager_id'] = '';
            $data['is_publish'] = '2';
        }

        $datalist = $data;

        return view('backend.google-tag-manager', compact('datalist', 'statuslist'));
    }

    //Save data for Google Tag Manager
    public function saveGoogleTagManager(Request $request)
    {
        $res = array();

        $google_tag_manager_id = $request->input('google_tag_manager_id');
        $is_publish = $request->input('is_publish');

        $option = array(
            'google_tag_manager_id' => $google_tag_manager_id,
            'is_publish' => $is_publish
        );

        $data = array(
            'option_name' => 'google_tag_manager',
            'option_value' => json_encode($option)
        );

        $gData = Tp_option::where('option_name', 'google_tag_manager')->get();
        $id = '';
        foreach ($gData as $row) {
            $id = $row['id'];
        }

        if ($id == '') {
            $response = Tp_option::create($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('New Data Added Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data insert failed');
            }
        } else {
            $response = Tp_option::where('id', $id)->update($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }
        }

        return response()->json($res);
    }

    //Theme Options Whatsapp page load
    public function getThemeOptionsWhatsappPageLoad()
    {

        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Whatsapp',

            'whatsapp_id' => '',
            'whatsapp_text' => '',
            'position' => '',
            'is_publish' => '2',

        ];
        if (isset($site_option)) {
            $results = $site_option->whatsapp;
            if ($results) {
                $dataObj = json_decode($results);
                $data['whatsapp_id'] = $dataObj->whatsapp_id;
                $data['whatsapp_text'] = $dataObj->whatsapp_text;
                $data['position'] = $dataObj->position;
                $data['is_publish'] = $dataObj->is_publish;
            }
        }
        $datalist = $data;
        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        return view('backend.theme-options-whatsapp', compact('datalist', 'statuslist'));
    }

    //Save data for Theme Options Whatsapp
    public function saveThemeOptionsWhatsapp(Request $request)
    {
        $id = $request->input('site_id');
        $whatsapp_id = $request->input('whatsapp_id');
        $whatsapp_text = $request->input('whatsapp_text');
        $position = $request->input('position');
        $is_publish = $request->input('is_publish');

        $option = array(
            'whatsapp_id' => $whatsapp_id,
            'whatsapp_text' => $whatsapp_text,
            'position' => $position,
            'is_publish' => $is_publish
        );

        $data = array(
            'site_id' => $id,
            'whatsapp' => json_encode($option)
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }

    //Theme Options Telegram page load
    public function getThemeOptionsTelegramPageLoad()
    {
        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Telegram',

            'telegram_id' => '',
            'position' => '',
            'is_publish' => '2',

        ];
        if (isset($site_option)) {
            $results = $site_option->telegram;
            if ($results) {
                $dataObj = json_decode($results);
                $data['telegram_id'] = $dataObj->telegram_id;
                $data['position'] = $dataObj->position;
                $data['is_publish'] = $dataObj->is_publish;
            }
        }
        $datalist = $data;
        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        return view('backend.theme-options-telegram', compact('datalist', 'statuslist'));
    }

    //Save data for Theme Options Telegram
    public function saveThemeOptionsTelegram(Request $request)
    {
        $id = $request->input('site_id');
        $telegram_id = $request->input('telegram_id');
        $position = $request->input('position');
        $is_publish = $request->input('is_publish');

        $option = array(
            'telegram_id' => $telegram_id,
            'position' => $position,
            'is_publish' => $is_publish
        );

        $data = array(
            'site_id' => $id,
            'telegram' => json_encode($option)
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }

    //Theme Options home-video
    public function getThemeOptionsHomeVideo()
    {

        $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);

        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Home Video Section',

            'title' => '',
            'short_desc' => '',
            'url' => '',
            'video_url' => '',
            'button_text' => '',
            'target' => '',
            'image' => '',
            'is_publish' => '2',

        ];

        if (isset($site_option)) {
            $results = $site_option->home_video;
            if ($results) {
                $dataObj = json_decode($results);
                $data['title'] = $dataObj->title;
                $data['short_desc'] = $dataObj->short_desc;
                $data['url'] = $dataObj->url;
                $data['video_url'] = $dataObj->video_url;
                $data['button_text'] = $dataObj->button_text;
                $data['target'] = $dataObj->target;
                $data['image'] = $dataObj->image;
                $data['is_publish'] = $dataObj->is_publish;
            }
        }
        $datalist = $data;
        return view('backend.home-video', compact('media_datalist', 'datalist', 'statuslist'));
    }

    //Save data for Home Video Section
    public function saveThemeOptionsHomeVideo(Request $request)
    {
        $site_id = $request->input('site_id');
        $title = $request->input('title');
        $short_desc = $request->input('short_desc');
        $url = $request->input('url');
        $video_url = $request->input('video_url');
        $button_text = $request->input('button_text');
        $target = $request->input('target');
        $image = $request->input('image');
        $is_publish = $request->input('is_publish');

        $option = array(
            'title' => $title,
            'short_desc' => $short_desc,
            'url' => $url,
            'video_url' => $video_url,
            'button_text' => $button_text,
            'target' => $target,
            'image' => $image,
            'is_publish' => $is_publish
        );

        $data = array(
            'site_id' => $site_id,
            'home_video' => json_encode($option)
        );

        $site_option = Site_option::where('site_id', $site_id)->first();
        $res = saveOptions($site_option, $data);
        return response()->json($res);
    }

    //Page Variation
    public function getPageVariation()
    {

        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Page Variation',

            'home_variation' => 'home_1',
            'category_variation' => 'left_sidebar',
            'brand_variation' => 'left_sidebar',
            'seller_variation' => 'left_sidebar',

        ];

        if (isset($site_option)) {
            $results = $site_option->page_variation;
            if ($results) {
                $dataObj = json_decode($results);
                $data['home_variation'] = $dataObj->home_variation;
                $data['category_variation'] = $dataObj->category_variation;
                $data['brand_variation'] = $dataObj->brand_variation;
                $data['seller_variation'] = $dataObj->seller_variation;
            }
        }
//        dd($results);
        $datalist = $data;

        return view('backend.page-variation', compact('datalist'));
    }

    //Save for Page Variation
    public function savePageVariation(Request $request)
    {

        $id = $request->input('site_id');
        $home_variation = $request->input('home_variation');
        $category_variation = $request->input('category_variation');
        $brand_variation = $request->input('brand_variation');
        $seller_variation = $request->input('seller_variation');

        $option = array(
            'home_variation' => $home_variation,
            'category_variation' => $category_variation,
            'brand_variation' => $brand_variation,
            'seller_variation' => $seller_variation
        );

        $data = array(
            'site_id' => $id,
            'page_variation' => json_encode($option)
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }


    //Theme Options Bank Transfer load
    public function getThemeOptionsBankTransferPageLoad()
    {
        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Bank Transfer',

            'description' => '',
            'isenable' => '',


        ];
        if (isset($site_option)) {
            $results = $site_option->bank_transfer;
            if ($results) {
                $dataObj = json_decode($results);
                $data['description'] = $dataObj->description;
                $data['isenable'] = $dataObj->isenable;
            }
        }
        $datalist = $data;
        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        return view('backend.bank-transfer', compact('datalist', 'statuslist'));
    }

    //Save data for Bank Transfer Telegram
    public function saveThemeOptionsBankTransfer(Request $request)
    {
        $id = $request->input('site_id');
        $is_enable = $request->input('isenable_bank');
        $description_bank = $request->input('description_bank');

        if ($is_enable == 'true' || $is_enable == 'on') {
            $isenable = 1;
        } else {
            $isenable = 0;
        }

        $option = array(
            'isenable' => $isenable,
            'description' => $description_bank
        );

        $data = array(
            'site_id' => $id,
            'bank_transfer' => json_encode($option)
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }


    //Theme Options Social Media
    public function getThemeOptionsSocialMediaPageLoad()
    {
        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();
        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $socials = [
            'facebook', 'youtube', 'twitter', 'instagram', 'linkedin', 'pinterest'
        ];

        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Social Media',
        ];

        foreach ($socials as $social) {
            $data['socials_media'][$social] = [
                'url' => 'https://www.' . $social . '.com/',
                'followers' => rand(50, 100),
                'is_publish' => '2',
            ];
        }

        if (isset($site_option)) {
            $results = $site_option->theme_option_social_media;
            if ($results) {
                $dataObj = json_decode($results, true);
                foreach ($dataObj as $key => $item) {
                    $data['socials_media'][$key] = [
                        'url' => $item['url'],
                        'followers' => $item['followers'],
                        'is_publish' => $item['is_publish'],
                    ];
                }
            }
        }
        $datalist = $data;
        return view('backend.theme-options-social-media', compact('datalist', 'statuslist'));
    }

    //Save data for Theme Options Social Media
    public function saveThemeOptionsSocialMedia(Request $request)
    {
        $id = $request->input('site_id');
        $socials_media = $request->input('socials_media');
        $data = array(
            'site_id' => $id,
            'theme_option_social_media' => json_encode($socials_media)
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }

    //Theme Options Ads Manage
    public function getThemeOptionsAdsManagePageLoad()
    {
        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();
        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;


        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Ads Manage',


            'header_code' => '',
            'header_adss' => '',
            'sidebar_adss' => '',
            'before_adss' => '',
            'after_adss' => '',
            'adssss_txt' => '',
        ];


        if (isset($site_option)) {
            $results = $site_option->theme_option_ads_manage;
            if ($results) {
                $dataObj = json_decode($results);

                $data['header_code'] = $dataObj->header_code ?? null;
                $data['header_adss'] = $dataObj->header_ads ?? null;
                $data['sidebar_adss'] = $dataObj->sidebar_ads ?? null;
                $data['before_adss'] = $dataObj->before_ads ?? null;
                $data['after_adss'] = $dataObj->after_ads ?? null;
                $data['adssss_txt'] = $dataObj->adssss_txt ?? null;
            }
        }
        $datalist = $data;
        return view('backend.theme-options-adss-manage', compact('datalist', 'statuslist'));
    }

    //Save data for Theme Options Ads Manage
    public function saveThemeOptionsAdsManage(Request $request)
    {
        $id = $request->input('site_id');


        $header_code = $request->input('header_code');
        $header_ads = $request->input('header_adss');
        $sidebar_ads = $request->input('sidebar_adss');
        $before_ads = $request->input('before_adss');
        $after_ads = $request->input('after_adss');
        $adssss_txt = $request->input('adssss_txt');


        $option = array(
            'header_code' => $header_code,
            'header_ads' => $header_ads,
            'sidebar_ads' => $sidebar_ads,
            'before_ads' => $before_ads,
            'after_ads' => $after_ads,
            'adssss_txt' => $adssss_txt,

        );

        $data = array(
            'site_id' => $id,
            'theme_option_ads_manage' => json_encode($option)
        );

        $site_option = Site_option::where('site_id', $id)->first();

        $res = saveOptions($site_option, $data);

        return response()->json($res);
    }


    /**
     * public function saveOptions($site_option,$data){
     * $res = array();
     * if($site_option){
     * $response = $site_option->update($data);
     * if($response){
     * $res['msgType'] = 'success';
     * $res['msg'] = __('Data Updated Successfully');
     * }else{
     * $res['msgType'] = 'error';
     * $res['msg'] = __('Data update failed');
     * }
     * }else{
     * $site_options = Site_option::create($data);
     * $response = $site_options->save();
     * if($response){
     * $res['msgType'] = 'success';
     * $res['msg'] = __('Data Updated Successfully');
     * }else{
     * $res['msgType'] = 'error';
     * $res['msg'] = __('Data update failed');
     * }
     * }
     * return $res;
     * }
     **/
}
