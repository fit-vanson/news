<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MultipleSites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Media_option;
use App\Models\Offer_ad;

class Offer_adsController extends Controller
{
    //Offer Ads page load
    public function getOfferAdsPageLoad() {

		$media_datalist = Media_option::orderBy('id','desc')->paginate(28);

		$statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        $id = \request()->site_id;

        $site = MultipleSites::findorFail($id);

        $data = [
            'id' => $id,
            'title_row' => 'Offer & Ads',
            'name' => $site->site_name,
            'web' => $site->site_web,
        ];

        $datalist = $data;
        $offer_ads = $site->offer_ads()->paginate(10);
        return view('backend.offer-ads', compact('media_datalist', 'statuslist', 'datalist','offer_ads'));
    }

	//Get data for Offer Ads Pagination
	public function getOfferAdsTableData(Request $request){

		$search = $request->search;
        $site_id = $request->site_id;
        $site = MultipleSites::findorFail($site_id);

		if($request->ajax()){

			if($search != ''){

                $offer_ads =  $site->offer_ads()
                    ->where(function ($query) use ($search){
						$query->where('title', 'like', '%'.$search.'%')
							->orWhere('url', 'like', '%'.$search.'%');
					})
					->orderBy('id','desc')
					->paginate(10);
			}else{
                $offer_ads =  $site->offer_ads()
                    ->orderBy('id','desc')
					->paginate(10);
			}

			return view('backend.partials.offer_ads_table', compact('offer_ads'))->render();
		}
	}

	//Save data for Offer Ads
    public function saveOfferAdsData(Request $request){
		$res = array();

        $site_id = \request()->site_id;
		$id = $request->input('RecordId');
		$title = $request->input('text_1');
		$offer_ad_type = $request->input('offer_ad_type');
		$url = $request->input('url');
		$image = $request->input('image');
		$is_publish = $request->input('is_publish');
		$bg_color = $request->input('bg_color');
		$text_1 = $request->input('text_1');
		$text_2 = $request->input('text_2');
		$button_text = $request->input('button_text');
		$target = $request->input('target');

		$validator_array = array(
			'image' => $request->input('image'),
			'is_publish' => $request->input('is_publish')
		);

		$validator = Validator::make($validator_array, [
			'image' => 'required',
			'is_publish' => 'required'
		]);

		$errors = $validator->errors();

		if($errors->has('image')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('image');
			return response()->json($res);
		}

		if($errors->has('is_publish')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('is_publish');
			return response()->json($res);
		}

		$desc = array(
			'bg_color' => $bg_color,
			'text_1' => $text_1,
			'text_2' => $text_2,
			'button_text' => $button_text,
			'target' => $target
		);

		$data = array(
            'site_id' =>$site_id,
			'offer_ad_type' => $offer_ad_type,
			'title' => $title,
			'url' => $url,
			'image' => $image,
			'desc' => json_encode($desc),
			'is_publish' => $is_publish
		);

		if($id ==''){
			$response = Offer_ad::create($data);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('New Data Added Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data insert failed');
			}
		}else{
			$response = Offer_ad::where('id', $id)->update($data);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
		}

		return response()->json($res);
    }

	//Get data for Offer Ads by id
    public function getOfferAdsById(Request $request){

		$id = $request->id;

		$data = Offer_ad::where('id', $id)->first();

		return response()->json($data);
	}

	//Delete data for Offer Ads
	public function deleteOfferAds(Request $request){

		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Offer_ad::where('id', $id)->delete();
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Removed Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data remove failed');
			}
		}

		return response()->json($res);
	}

	//Bulk Action for Offer Ads
	public function bulkActionOfferAds(Request $request){

		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);

		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Offer_ad::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}

		}elseif($BulkAction == 'draft'){

			$response = Offer_ad::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}

		}elseif($BulkAction == 'delete'){
			$response = Offer_ad::whereIn('id', $idsArray)->delete();
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Removed Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data remove failed');
			}
		}

		return response()->json($res);
	}
}
