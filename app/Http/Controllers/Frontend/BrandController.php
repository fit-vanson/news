<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;
use App\Models\Tp_option;

class BrandController extends Controller
{
    //get Brand Page
    public function getBrandPage($id, $title){

		$params = array('brand_id' => $id);
        $site = getSite();


		$mdata = Brand::where('id', '=', $id)->where('is_publish', '=', 1)->first();

		if($mdata !=''){
			$metadata = $mdata;
		}else{
			$metadata = array(
				'id' => '',
				'name' => '',
				'slug' => '',
				'thumbnail' => '',
				'is_publish' => ''
			);
		}

        $PageVariation = PageVariation();
        $brand_variation = $PageVariation['brand_variation'];

		if(($brand_variation == 'left_sidebar') || ($brand_variation == 'right_sidebar')){
			$num = 9;
		}else{
			$num = 12;
		}

        $datalist = Product::whereHas('categories.site', function ($query) use ($site) {
            $query->where('multiple_site_id', $site->id);
        })
            ->orderBy('products.id','desc')
            ->where('brand_id', $id)
            ->paginate($num);

		for($i=0; $i<count($datalist); $i++){
			$Reviews = getReviews($datalist[$i]->id);
			$datalist[$i]->TotalReview = $Reviews[0]->TotalReview;
			$datalist[$i]->TotalRating = $Reviews[0]->TotalRating;
			$datalist[$i]->ReviewPercentage = number_format($Reviews[0]->ReviewPercentage);
		}

        return view('frontend.brand', compact('params', 'metadata', 'brand_variation', 'datalist'));
    }

	//Get data for Brand Pagination
	public function getBrandGrid(Request $request){
        $site = getSite();
		$brand_id = $request->brand_id;
		$min_price = $request->min_price == '' ? 0 : $request->min_price;
		$max_price = $request->max_price;

        $PageVariation = PageVariation();
        $brand_variation = $PageVariation['brand_variation'];

		if($request->num !=''){
			$num = $request->num;
		}else{
			if(($brand_variation == 'left_sidebar') || ($brand_variation == 'right_sidebar')){
				$num = 9;
			}else{
				$num = 12;
			}
		}

		$field_name = 'id';
		$order_name = 'desc';
		if($request->sortby !=''){
			if($request->sortby == 'date_asc'){
				$field_name = 'created_at';
				$order_name = 'asc';
			}elseif($request->sortby == 'date_desc'){
				$field_name = 'created_at';
				$order_name = 'desc';
			}elseif($request->sortby == 'name_asc'){
				$field_name = 'title';
				$order_name = 'asc';
			}elseif($request->sortby == 'name_desc'){
				$field_name = 'title';
				$order_name = 'desc';
			}
		}else{
			$field_name = 'id';
			$order_name = 'desc';
		}

		if($request->ajax()){
			if($max_price !=''){

                $datalist = Product::whereHas('categories.site', function ($query) use ($site) {
                    $query->where('multiple_site_id', $site->id);
                })
                    ->where('products.is_publish', '=', 1)
                    ->where('brand_id', $brand_id)
                    ->whereBetween('products.sale_price', [$min_price, $max_price])
                    ->orderBy('products.'.$field_name, $order_name)
                    ->paginate($num);

			}else{
                $datalist = Product::whereHas('categories.site', function ($query) use ($site) {
                    $query->where('multiple_site_id', $site->id);
                })
                    ->where('products.is_publish', '=', 1)
                    ->where('brand_id', $brand_id)
                    ->orderBy('products.'.$field_name, $order_name)
                    ->paginate($num);
			}

 			for($i=0; $i<count($datalist); $i++){
				$Reviews = getReviews($datalist[$i]->id);
				$datalist[$i]->TotalReview = $Reviews[0]->TotalReview;
				$datalist[$i]->TotalRating = $Reviews[0]->TotalRating;
				$datalist[$i]->ReviewPercentage = number_format($Reviews[0]->ReviewPercentage);
			}

			return view('frontend.partials.brand-grid', compact('brand_variation', 'datalist'))->render();
		}
	}
}
