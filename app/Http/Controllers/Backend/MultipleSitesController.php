<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Media_option;
use App\Models\MultipleSites;
use App\Models\Pro_category;
use App\Models\Site_option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class MultipleSitesController extends Controller
{

    //Multiple Site page load
    public function getMultipleSitesPageLoad()
    {

        $AllCount = MultipleSites::count();
        $PublishedCount = MultipleSites::where('is_publish', '=', 1)->count();
        $DraftCount = MultipleSites::where('is_publish', '=', 2)->count();
        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();


        $datalist = MultipleSites::orderBy('id', 'desc')
            ->with('tp_status', 'categories')
            ->paginate(20);
        return view('backend.multiple_sites', compact('AllCount', 'PublishedCount', 'DraftCount', 'statuslist', 'datalist'));
    }

    //Get data for Products Pagination
    public function getMultipleSitesTableData(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $category_id = $request->category_id;
        if ($request->ajax()) {
            if ($search != '') {
                $datalist = MultipleSites::orderBy('id', 'desc')
                    ->where(function ($query) use ($search) {
                        $query
                            ->where('multiple_sites.site_name', 'like', '%' . $search . '%')
                            ->orwhere('multiple_sites.site_web', 'like', '%' . $search . '%');
                    })
                    ->where(function ($query) use ($status) {
                        $query->whereRaw("multiple_sites.is_publish = '" . $status . "' OR '" . $status . "' = '0'");
                    })
                    ->paginate(20);
            } else {
                $datalist = MultipleSites::orderBy('id', 'desc')
                    ->where(function ($query) use ($status) {
                        $query->whereRaw("multiple_sites.is_publish = '" . $status . "' OR '" . $status . "' = '0'");
                    })
                    ->paginate(20);
            }

            return view('backend.partials.multiple_sites_table', compact('datalist'))->render();
        }
    }

    //Save data for Multiple Sites
    public function saveMultipleSitesData(Request $request)
    {
        $res = array();

        $id = $request->input('RecordId');
        $name = $request->input('site_name');
        $web = $request->input('site_web');
        $is_publish = $request->input('is_publish');
//        $cat_id = $request->input('categoryid');


        $company = $request->input('company');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $site_title = $request->input('site_title');
        $address = $request->input('address');
        $timezone = $request->input('timezone');


        $validator_array = array(
            'site_name' => $request->input('site_name'),
            'site_web' => $request->input('site_web'),
            'category' => $request->input('categoryid'),
        );

        $rId = $id == '' ? '' : ',' . $id;
        $validator = Validator::make($validator_array, [
            'site_name' => 'required|max:191|unique:multiple_sites,site_name' . $rId,
            'site_web' => 'required|max:191|unique:multiple_sites,site_web' . $rId,
            'category' => 'required',

        ]);

        $errors = $validator->errors();

        if ($errors->has('site_name')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('site_name');
            return response()->json($res);
        }
        if ($errors->has('site_web')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('site_web');
            return response()->json($res);
        }


        $data = array(
            'site_name' => $name,
            'site_web' => $web,
            'is_publish' => $is_publish
        );


        $option_value = array(
            'company' => $company,
            'email' => $email,
            'phone' => $phone,
            'site_title' => $site_title,
            'address' => $address,
            'timezone' => $timezone
        );

        if ($id == '') {
            $response = MultipleSites::create($data);
            if ($response) {
                $site_options = new Site_option([
                    'site_id' => $response->id,
                    'general_settings' => json_encode($option_value)
                ]);
                $response->site_options()->save($site_options);

                $res['id'] = $response->id;
                $res['msgType'] = 'success';
                $res['msg'] = __('New Data Added Successfully');
            } else {
                $res['id'] = '';
                $res['msgType'] = 'error';
                $res['msg'] = __('Data insert failed');
            }
        } else {
            $response = MultipleSites::where('id', $id)->first();

            if ($response) {
                $response->update($data);
                $response->site_options()->update([
                    'site_id' => $response->id,
                    'general_settings' => json_encode($option_value)
                ]);
                $res['id'] = $id;
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['id'] = '';
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }
        }
        return response()->json($res);
    }

    //get Multiple Sites
    public function getMultipleSitesPageData($id = null)
    {

        $site = MultipleSites::where('id', $id)->firstOrFail();
        $general_settings = json_decode($site->site_options->general_settings, true);

        $data = [
            'id' => $id,
            'title_row' => 'Site',
            'name' => $site->site_name,
            'web' => $site->site_web,
            'is_publish' => $site->is_publish,
            'site_title' => $general_settings['site_title'] ?? null,
            'company' => $general_settings['company'] ?? null,
            'email' => $general_settings['email'] ?? null,
            'phone' => $general_settings['phone'] ?? null,
            'address' => $general_settings['address'] ?? null,
            'timezone' => $general_settings['timezone'] ?? null,


        ];
        $datalist = $data;
        $timezonelist = DB::table('timezones')->orderBy('timezone_name', 'asc')->get();

        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();
        $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);
        return view('backend.theme-site', compact('datalist', 'statuslist', 'media_datalist', 'timezonelist'));

    }

    //Delete data for Multiple Sites
    public function deleteMultipleSites(Request $request)
    {

        $res = array();
        $id = $request->id;
        $site = MultipleSites::find($id)->delete();
        if ($site) {
            $res['msgType'] = 'success';
            $res['msg'] = __('Data Removed Successfully');
        } else {
            $res['msgType'] = 'error';
            $res['msg'] = __('Data remove failed');
        }

        return response()->json($res);
    }

    //Delete data for cloneMultipleSites
    public function cloneMultipleSites(Request $request)
    {


        $res = array();
        $id = $request->id;
        $site = MultipleSites::find($id);

        $newSite = $site->replicate();
        $newSite->site_name = $site->site_name . '_copy';

        $newSite->push();

        foreach ($site->categories as $category) {
            $newSite->categories()->attach($category);
            // you may set the timestamps to the second argument of attach()
        }

        $site_option = $site->site_options->toArray();
        $site_option['site_id'] = $newSite->id;

        $site->site_options->create($site_option);

        $newSite->push();

        if ($site) {
            $res['msgType'] = 'success';
            $res['msg'] = __('Data Removed Successfully');
        } else {
            $res['msgType'] = 'error';
            $res['msg'] = __('Data remove failed');
        }

        return response()->json($res);
    }
}
