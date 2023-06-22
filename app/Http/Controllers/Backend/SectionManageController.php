<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MultipleSites;
use App\Models\SiteSectionManages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Section_manage;
use App\Models\Media_option;

class SectionManageController extends Controller
{

 //Section manage page load
    public function getSectionManagePageLoad() {

		$media_datalist = Media_option::orderBy('id','desc')->paginate(28);
		$statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        $id = \request()->site_id;
        $site = MultipleSites::find($id);

        $SectionManage =  Section_manage::orderBy('section_manages.id','asc')->get();
        $SiteSectionManage = $site->section_manage ?? collect();

        $datalist = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Section Manage',
            'SectionManages' =>$SectionManage->merge($SiteSectionManage)
        ];
        return view('backend.section-manage', compact('media_datalist', 'statuslist', 'datalist'));
    }

	//Get data for Section Manage Pagination
//	public function getSectionManageTableData(Request $request){
//
//		$search = $request->search;
//		$manage_type = $request->manage_type;
//
//		if($request->ajax()){
//
//			if($search != ''){
//				$datalist = DB::table('section_manages')
////					->join('tp_status', 'section_manages.is_publish', '=', 'tp_status.id')
////					->select('section_manages.*', 'tp_status.status')
//					->where(function ($query) use ($search){
//						$query->where('title', 'like', '%'.$search.'%')
//							->orWhere('url', 'like', '%'.$search.'%')
//							->orWhere('desc', 'like', '%'.$search.'%');
//					})
//					->orderBy('section_manages.id','asc')
//					->paginate(20);
//			}else{
//
//				$datalist = DB::table('section_manages')
////					->join('tp_status', 'section_manages.is_publish', '=', 'tp_status.id')
////					->select('section_manages.*', 'tp_status.status')
//
//					->orderBy('section_manages.id','asc')
//					->paginate(20);
//			}
//
//			return view('backend.partials.section_manage_table', compact('datalist'))->render();
//		}
//	}

	//Save data for Section Manage
    public function saveSectionManageData(Request $request){
		$res = array();
//        dd($request->all());
        $site_id = $request->input('site_id');
        $sectionId = $request->input('sectionId');
		$id = $request->input('RecordId');
		$title = $request->input('title');
		$desc = $request->input('desc');
		$image = $request->input('image');
		$is_publish = $request->input('is_publish');

		$validator_array = array(
			'title' => $request->input('title')
		);

		$validator = Validator::make($validator_array, [
			'title' => 'required|max:191'
		]);

		$errors = $validator->errors();
		if($errors->has('title')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('title');
			return response()->json($res);
		}

		$data = array(
			'site_id' => $site_id,
			'section_id' => $sectionId,
			'title' => $title,
			'desc' => $desc,
			'image' => $image,
			'is_publish' => $is_publish
		);



		if($id ==''){
			$response = SiteSectionManages::create($data);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('New Data Added Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data insert failed');
			}
		}else{
			$response = SiteSectionManages::where('id', $id)->update($data);
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

	//Get data for Section Manage by id
    public function getSectionManageById(Request $request){

		$id = $request->id;
        $site_id = $request->site_id;

        $data = SiteSectionManages::where('section_id', $id)->where('site_id',$site_id)->first();

        if(!$data){
            $data = Section_manage::where('id', $id)->first();
            $data->rowId =  null;
        }else{
            $data->rowId =  $data->id;
        }
        $data->section_id =  $id;
		return response()->json($data);
	}

	//Delete data for Section Manage
	public function deleteSectionManage(Request $request){

		$res = array();

		$id = $request->id;

		if($id != ''){
			$response = Section_manage::where('id', $id)->delete();
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

	//Bulk Action for Section Manage
	public function bulkActionSectionManage(Request $request){

		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);

		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Section_manage::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}

		}elseif($BulkAction == 'draft'){

			$response = Section_manage::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}

		}elseif($BulkAction == 'delete'){
			$response = Section_manage::whereIn('id', $idsArray)->delete();
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
