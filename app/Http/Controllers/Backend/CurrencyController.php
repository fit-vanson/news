<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MultipleSites;
use App\Models\Site_option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Tp_option;

class CurrencyController extends Controller
{
    //Currency page load
    public function getCurrencyPageLoad() {



        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $site_option = $site->site_options;
        $data = [
            'id' => $id,
            'name' => $site->site_name,
            'web' => $site->site_web,
            'title_row' => 'Currency',

            'currency_name' => '',
            'currency_icon' => '',
            'currency_position' => '',
            'thousands_separator' => ',',
            'decimal_separator' => '.',
            'decimal_digit' => 0,

        ];
        if(isset($site_option)){
            $results = $site_option->currency;
            if($results){
                $dataObj = json_decode($results);
                $data['currency_name'] = $dataObj->currency_name;
                $data['currency_icon'] = $dataObj->currency_icon;
                $data['currency_position'] = $dataObj->currency_position;
                $data['thousands_separator'] = $dataObj->thousands_separator ?? ',';
                $data['decimal_separator'] = @$dataObj->decimal_separator ?? '.';
                $data['decimal_digit'] = @$dataObj->decimal_digit ?? 2;
            }
        }
        $datalist = $data;
        return view('backend.currency', compact('datalist'));
	}

	//Save data for Currency
    public function saveCurrencyData(Request $request){

        $id = $request->input('site_id');
        $currency_name = esc($request->input('currency_name'));
		$currency_icon = esc($request->input('currency_icon'));
		$currency_position = $request->input('currency_position');
		$thousands_separator = $request->input('thousands_separator');
        $decimal_separator = $request->input('decimal_separator');
		$decimal_digit= $request->input('decimal_digit');

		$validator_array = array(
			'currency_name' => $request->input('currency_name'),
			'currency_icon' => $request->input('currency_icon'),
			'currency_position' => $request->input('currency_position'),
			'thousands_separator' => $request->input('thousands_separator'),
			'decimal_separator' => $request->input('decimal_separator'),
			'decimal_digit' => $request->input('decimal_digit')
		);

		$validator = Validator::make($validator_array, [
			'currency_name' => 'required',
			'currency_icon' => 'required',
			'currency_position' => 'required',
			'thousands_separator' => 'required',
			'decimal_separator' => 'required',
			'decimal_digit' => 'required'
		]);

		$errors = $validator->errors();

		if($errors->has('currency_name')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('currency_name');
			return response()->json($res);
		}

		if($errors->has('currency_icon')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('currency_icon');
			return response()->json($res);
		}

		if($errors->has('currency_position')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('currency_position');
			return response()->json($res);
		}
		if($errors->has('thousands_separator')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('thousands_separator');
			return response()->json($res);
		}

        if($errors->has('decimal_separator')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('decimal_separator');
			return response()->json($res);
		}

        if($errors->has('decimal_digit')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('decimal_digit');
			return response()->json($res);
		}

		$option = array(
			'currency_name' => $currency_name,
			'currency_icon' => $currency_icon,
			'currency_position' => $currency_position,
			'thousands_separator' => $thousands_separator,
			'decimal_separator' => $decimal_separator,
			'decimal_digit' => $decimal_digit,
		);

		$data = array(
            'site_id' => $id,
			'currency' => json_encode($option)
		);

        $site_option = Site_option::where('site_id', $id)->first();
        $res = saveOptions($site_option,$data);

        return response()->json($res);

    }
}
