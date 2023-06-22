<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Pro_category;
use App\Models\Brand;
use App\Models\Tax;
use App\Models\Attribute;
use App\Models\Media_option;
use App\Models\Pro_image;
use App\Models\Related_product;
use Imagick;
use Maatwebsite\Excel\Facades\Excel;
use mysql_xdevapi\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductsController extends Controller
{
    //Products page load
    public function getProductsPageLoad() {

		$AllCount = Product::count();
		$PublishedCount = Product::where('is_publish', '=', 1)->count();
		$DraftCount = Product::where('is_publish', '=', 2)->count();
		$brandlist = Brand::where('is_publish', 1)->orderBy('name','asc')->get();
		$categorylist = Pro_category::where('is_publish', 1)->orderBy('name','asc')->get();
        $datalist = Product::orderBy('products.id','desc')->paginate(20);
        return view('backend.products', compact('AllCount', 'PublishedCount', 'DraftCount', 'categorylist','brandlist', 'datalist'));
	}

	//Get data for Products Pagination
	public function getProductsTableData(Request $request){

		$search = $request->search;
		$status = $request->status;
//		$language_code = $request->language_code;
		$category_id = $request->category_id;
		$brand_id = $request->brand_id;
//		$user_id = $request->store_id;

		if($request->ajax()){
			if($search != ''){
				$datalist = Product::orderBy('products.id','desc')
                    ->where(function ($query) use ($search){
						$query->where('products.title', 'like', '%'.$search.'%')
							->orWhere('pro_categories.name', 'like', '%'.$search.'%')
							->orWhere('brands.name', 'like', '%'.$search.'%')
							->orWhere('cost_price', 'like', '%'.$search.'%');
					})
					->where(function ($query) use ($status){
						$query->whereRaw("products.is_publish = '".$status."' OR '".$status."' = '0'");
					})
					->where(function ($query) use ($category_id){
						$query->whereRaw("products.cat_id = '".$category_id."' OR '".$category_id."' = '0'");
					})
					->where(function ($query) use ($brand_id){
						$query->whereRaw("products.brand_id = '".$brand_id."' OR '".$brand_id."' = 'all'");
					})
					->paginate(20);
			}else{
                $datalist = Product::orderBy('products.id','desc')
                    ->where(function ($query) use ($status){
						$query->whereRaw("products.is_publish = '".$status."' OR '".$status."' = '0'");
					})
					->where(function ($query) use ($category_id){
						$query->whereRaw("products.cat_id = '".$category_id."' OR '".$category_id."' = '0'");
					})
					->where(function ($query) use ($brand_id){
						$query->whereRaw("products.brand_id = '".$brand_id."' OR '".$brand_id."' = 'all'");
					})
					->paginate(20);
			}

			return view('backend.partials.products_table', compact('datalist'))->render();
		}
	}

	//Save data for Products
    public function saveProductsData(Request $request){
		$res = array();

		$id = $request->input('RecordId');
		$title = esc($request->input('title'));
		$slug = esc(str_slug($request->input('slug')));
		$cat_id = $request->input('categoryid');
		$brand_id = $request->input('brandid');

		$validator_array = array(
			'product_name' => $request->input('title'),
			'slug' => $slug,
//			'language' => $request->input('lan'),
			'category' => $request->input('categoryid'),
			'brand' => $request->input('brandid'),
//			'store' => $request->input('storeid')
		);

		$rId = $id == '' ? '' : ','.$id;
		$validator = Validator::make($validator_array, [
			'product_name' => 'required',
			'slug' => 'required|max:191|unique:products,slug' . $rId,
//			'language' => 'required',
			'category' => 'required',
			'brand' => 'required',
//			'store' => 'required'
		]);

		$errors = $validator->errors();

		if($errors->has('product_name')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('product_name');
			return response()->json($res);
		}

		if($errors->has('slug')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('slug');
			return response()->json($res);
		}

//		if($errors->has('language')){
//			$res['msgType'] = 'error';
//			$res['msg'] = $errors->first('language');
//			return response()->json($res);
//		}

		if($errors->has('category')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('category');
			return response()->json($res);
		}

		if($errors->has('brand')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('brand');
			return response()->json($res);
		}
//
//		if($errors->has('store')){
//			$res['msgType'] = 'error';
//			$res['msg'] = $errors->first('store');
//			return response()->json($res);
//		}

		$data = array(
			'title' => $title,
			'slug' => $slug,
			'cat_id' => $cat_id,
			'category_ids' => $cat_id,
			'brand_id' => $brand_id,
			'user_id' => null,
//			'lan' => $lan,
			'is_publish' => 1
		);

		if($id ==''){
			$response = Product::create($data)->id;
			if($response){
				$res['id'] = $response;
				$res['msgType'] = 'success';
				$res['msg'] = __('New Data Added Successfully');
			}else{
				$res['id'] = '';
				$res['msgType'] = 'error';
				$res['msg'] = __('Data insert failed');
			}
		}else{
			$response = Product::where('id', $id)->update($data);
			if($response){

				$res['id'] = $id;
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['id'] = '';
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}
		}

		return response()->json($res);
    }

	//Delete data for Products
	public function deleteProducts(Request $request){

		$res = array();

		$id = $request->id;

        if ($id != '') {
            $product = Product::find($id);


            // Xóa các hình ảnh sản phẩm
            $proImages = Pro_image::where('product_id', $id)->get();
            foreach ($proImages as $proImage) {
                $this->deleteImageFiles($proImage->thumbnail);
                $this->deleteImageFiles($proImage->large_image);
            }

            // Xóa dữ liệu trong các bảng liên quan
            Pro_image::where('product_id', $id)->delete();
            Related_product::where('product_id', $id)->delete();

            $this->deleteImageFiles($product->f_thumbnail);
            $this->deleteImageFiles($product->large_image);
            $response = $product->delete();
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

	//Bulk Action for Products
	public function bulkActionProducts(Request $request){

		$res = array();

		$idsStr = $request->ids;
		$idsArray = explode(',', $idsStr);

		$BulkAction = $request->BulkAction;

		if($BulkAction == 'publish'){
			$response = Product::whereIn('id', $idsArray)->update(['is_publish' => 1]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}

		}elseif($BulkAction == 'draft'){

			$response = Product::whereIn('id', $idsArray)->update(['is_publish' => 2]);
			if($response){
				$res['msgType'] = 'success';
				$res['msg'] = __('Data Updated Successfully');
			}else{
				$res['msgType'] = 'error';
				$res['msg'] = __('Data update failed');
			}

		}elseif($BulkAction == 'delete'){
            $proImages = Pro_image::whereIn('product_id', $idsArray)->get();
            foreach ($proImages as $proImage) {
                $this->deleteImageFiles($proImage->thumbnail);
                $this->deleteImageFiles($proImage->large_image);
            }

            Pro_image::whereIn('product_id', $idsArray)->delete();
            Related_product::whereIn('product_id', $idsArray)->delete();

            $response = Product::whereIn('id', $idsArray)->get();

            foreach ($response as $resImage){
                $this->deleteImageFiles($resImage->f_thumbnail);
                $this->deleteImageFiles($resImage->large_image);
                $resImage->delete();
            }
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Removed Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data remove failed');
            }
		}

		return response()->json($res);
	}

	//has Product Slug
    public function hasProductSlug(Request $request){
		$res = array();

		$slug = str_slug($request->slug);
        $count = Product::where('slug', $slug) ->count();
		if($count == 0){
			$res['slug'] = $slug;
		}else{
			$incr = $count+1;
			$res['slug'] = $slug.'-'.$incr;
		}

		return response()->json($res);
	}

    //get Product
    public function getProductPageData($id){

		$datalist = Product::where('id', $id)->first();

		$statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

		$brandlist = Brand::where('is_publish', '=', 1)->orderBy('name','asc')->get();
		$categorylist = Pro_category::where('is_publish', '=', 1)->orderBy('name','asc')->get();

		$taxlist = Tax::orderBy('title','asc')->get();
		$unitlist = Attribute::orderBy('name','asc')->get();
		$media_datalist = Media_option::orderBy('id','desc')->paginate(28);

        return view('backend.product', compact('datalist', 'statuslist', 'categorylist','brandlist', 'taxlist', 'media_datalist',  'unitlist'));
    }

	//Update data for Products
    public function updateProductsData(Request $request){
		$res = array();

		$id = $request->input('RecordId');
		$title = esc($request->input('title'));
		$slug = esc(str_slug($request->input('slug')));
		$short_desc = $request->input('short_desc');
		$description = $request->input('description');
		$brand_id = $request->input('brand_id');
		$tax_id = $request->input('tax_id');
		$collection_id = $request->input('collection_id');
		$is_featured = $request->input('is_featured');
		$is_publish = $request->input('is_publish');
		$f_thumbnail = $request->input('f_thumbnail');
        $large_image = $request->input('large_image');
		$category_ids = $request->input('cat_id');
		$cat_id = $request->input('cat_id');
		$variation_size = $request->input('variation_size');
		$sale_price_per = $request->input('sale_price_per');
		$old_price = $request->input('old_price');

		$validator_array = array(
			'product_name' => $request->input('title'),
			'slug' => $slug,
			'featured_image' => $request->input('f_thumbnail'),
			'category' => $request->input('cat_id'),
			'status' => $request->input('is_publish'),
			'variation_size' => $request->input('variation_size'),
			'sale_price_per' => $request->input('sale_price_per'),
			'old_price' => $request->input('old_price')
		);

		$rId = $id == '' ? '' : ','.$id;
		$validator = Validator::make($validator_array, [
			'product_name' => 'required',
			'slug' => 'required|max:191|unique:products,slug' . $rId,
			'featured_image' => 'required',
			'category' => 'required',
			'status' => 'required',
			'variation_size' => 'required',
			'sale_price_per' => 'required',
			'old_price' => 'required',
		]);

		$errors = $validator->errors();

		if($errors->has('product_name')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('product_name');
			return response()->json($res);
		}

		if($errors->has('slug')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('slug');
			return response()->json($res);
		}

		if($errors->has('category')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('category');
			return response()->json($res);
		}

		if($errors->has('featured_image')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('featured_image');
			return response()->json($res);
		}

		if($errors->has('status')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('status');
			return response()->json($res);
		}

		if($errors->has('variation_size')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('variation_size');
			return response()->json($res);
		}

		if($errors->has('sale_price_per')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('sale_price_per');
			return response()->json($res);
		}
		if($errors->has('old_price')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('old_price');
			return response()->json($res);
		}

		$data = array(
			'title' => $title,
			'slug' => $slug,
			'f_thumbnail' => $f_thumbnail,
			'large_image' => $large_image,
			'short_desc' => $short_desc,
			'description' => $description,
			'category_ids' => $category_ids,
			'cat_id' => $cat_id,
			'brand_id' => $brand_id,
			'tax_id' => $tax_id,
			'collection_id' => $collection_id,
			'is_featured' => $is_featured,
			'is_publish' => $is_publish,
			'variation_size' => $variation_size,
			'sale_price' => (string) $old_price - ($old_price*$sale_price_per/100),
			'old_price' => $old_price,
		);

		$response = Product::where('id', $id)->update($data);
		if($response){

			//Update Parent and Child Menu
			gMenuUpdate($id, 'product', $title, $slug);

			$res['msgType'] = 'success';
			$res['msg'] = __('Data Updated Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data update failed');
		}

		return response()->json($res);
    }

    //get Price
    public function getPricePageData($id){

		$datalist = Product::where('id', $id)->first();

        return view('backend.price', compact('datalist'));
    }

	//Save data for Price
    public function savePriceData(Request $request){
		$res = array();

		$id = $request->input('RecordId');
		$cost_price = $request->input('cost_price');
		$sale_price = $request->input('sale_price');
		$old_price = $request->input('old_price');
		$start_date = date("Y-m-d");
		$end_date = $request->input('end_date');
		$is_discount = $request->input('is_discount');

		$validator_array = array(
			'sale_price' => $sale_price
		);

		$validator = Validator::make($validator_array, [
			'sale_price' => 'required'
		]);

		$errors = $validator->errors();

		if($errors->has('sale_price')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('sale_price');
			return response()->json($res);
		}

		if($end_date == ''){
			$data = array(
				'cost_price' => $cost_price,
				'sale_price' => $sale_price,
				'old_price' => $old_price,
				'start_date' => NULL,
				'end_date' => NULL,
				'is_discount' => $is_discount
			);
		}else{
			$data = array(
				'cost_price' => $cost_price,
				'sale_price' => $sale_price,
				'old_price' => $old_price,
				'start_date' => $start_date,
				'end_date' => $end_date,
				'is_discount' => $is_discount
			);
		}

		$response = Product::where('id', $id)->update($data);
		if($response){
			$res['msgType'] = 'success';
			$res['msg'] = __('Data Updated Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data update failed');
		}

		return response()->json($res);
    }

    //get Inventory
    public function getInventoryPageData($id){

		$datalist = Product::where('id', $id)->first();

        return view('backend.inventory', compact('datalist'));
    }

	//Save data for Inventory
    public function saveInventoryData(Request $request){
		$res = array();

		$id = $request->input('RecordId');
		$is_stock = $request->input('is_stock');
		$stock_status_id = $request->input('stock_status_id');
		$sku = $request->input('sku');
		$stock_qty = $request->input('stock_qty');
        $product = Product::find($id);

		$data = array(
			'is_stock' => $is_stock,
			'stock_status_id' => $stock_status_id,
			'sku' => $sku ?? $this->SKU_gen($product->title,$product->categories->id,$product->brand->id,$product->id),
			'stock_qty' => $stock_qty
		);

		$response = $product->update($data);
		if($response){
			$res['msgType'] = 'success';
			$res['msg'] = __('Data Updated Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data update failed');
		}

		return response()->json($res);
    }

    //get Product Images
    public function getProductImagesPageData($id){

		$datalist = Product::where('id', $id)->first();
		$imagelist = Pro_image::where('product_id', $id)->orderBy('id','desc')->paginate(15);
		$media_datalist = Media_option::orderBy('id','desc')->paginate(28);

        return view('backend.product-images', compact('datalist', 'imagelist', 'media_datalist'));
    }

	//Get data for Product Images Pagination
	public function getProductImagesTableData(Request $request){

		$id = $request->id;

		if($request->ajax()){
			$imagelist = Pro_image::where('product_id', $id)->orderBy('id','desc')->paginate(15);

			return view('backend.partials.product_images_list', compact('imagelist'))->render();
		}
	}

	//Save data for Product Images
    public function saveProductImagesData(Request $request){
		$res = array();

		$product_id = $request->input('product_id');
		$thumbnail = $request->input('thumbnail');
		$large_image = $request->input('large_image');

		$validator_array = array(
			'image' => $request->input('thumbnail')
		);

		$validator = Validator::make($validator_array, [
			'image' => 'required'
		]);

		$errors = $validator->errors();

		if($errors->has('image')){
			$res['msgType'] = 'error';
			$res['msg'] = $errors->first('image');
			return response()->json($res);
		}

		$data = array(
			'product_id' => $product_id,
			'thumbnail' => $thumbnail,
			'large_image' => $large_image
		);

		$response = Pro_image::create($data);
		if($response){
			$res['msgType'] = 'success';
			$res['msg'] = __('New Data Added Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data insert failed');
		}

		return response()->json($res);
    }

	//Delete data for Product Images
	public function deleteProductImages(Request $request){
		$res = array();
		$id = $request->id;
		if($id != ''){
            $proImage = Pro_image::find($id);
            if ($proImage) {
                $this->deleteImageFiles($proImage->thumbnail);
                $this->deleteImageFiles($proImage->large_image);

                $response = $proImage->delete();
                if ($response) {
                    $res['msgType'] = 'success';
                    $res['msg'] = __('Data Removed Successfully');
                } else {
                    $res['msgType'] = 'error';
                    $res['msg'] = __('Data remove failed');
                }
            }
		}

		return response()->json($res);
	}

    //get Variations
    public function getVariationsPageData($id){

		$datalist = Product::where('id', $id)->first();
		$sizelist = Attribute::where('att_type', 'Size')->orderBy('id','asc')->get();
		$colorlist = Attribute::where('att_type', 'Color')->orderBy('id','asc')->get();

        return view('backend.variations', compact('datalist', 'sizelist', 'colorlist'));
    }

	//Save data for Variations
    public function saveVariationsData(Request $request){
		$res = array();

		$id = $request->input('RecordId');
		$sizes = $request->input('variation_size');
		$colors = $request->input('variation_color');

		$variation_size = NULL;
		$i = 0;
		if($sizes !=''){
			foreach ($sizes as $key => $size) {
				if($i++){
					$variation_size .= ',';
				}
				$variation_size .= $size;
			}
		}

		$variation_color = NULL;
		$f = 0;
		if($colors !=''){
			foreach ($colors as $key => $color) {
				if($f++){
					$variation_color .= ',';
				}
				$variation_color .= $color;
			}
		}
		$data = array(
			'variation_size' => $variation_size,
			'variation_color' => $variation_color
		);

		$response = Product::where('id', $id)->update($data);
		if($response){
			$res['msgType'] = 'success';
			$res['msg'] = __('Data Updated Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data update failed');
		}

		return response()->json($res);
    }

    //get Product SEO
    public function getProductSEOPageData($id){

		$datalist = Product::where('id', $id)->first();
		$media_datalist = Media_option::orderBy('id','desc')->paginate(28);

        return view('backend.product-seo', compact('datalist', 'media_datalist'));
	}

	//Save data for Product SEO
    public function saveProductSEOData(Request $request){
		$res = array();

		$id = $request->input('RecordId');
		$og_title = $request->input('og_title');
		$og_image = $request->input('og_image');
		$og_description = $request->input('og_description');
		$og_keywords = $request->input('og_keywords');

		$data = array(
			'og_title' => $og_title,
			'og_image' => $og_image,
			'og_description' => $og_description,
			'og_keywords' => $og_keywords
		);

		$response = Product::where('id', $id)->update($data);
		if($response){
			$res['msgType'] = 'success';
			$res['msg'] = __('Data Updated Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data update failed');
		}

		return response()->json($res);
    }

    //get Related Products
    public function getRelatedProductsPageData($id){

		$datalist = Product::where('id', $id)->first();

		$productlist = DB::table('products')
			->join('tp_status', 'products.is_publish', '=', 'tp_status.id')
//			->join('languages', 'products.lan', '=', 'languages.language_code')
			->select('products.id', 'products.title', 'products.f_thumbnail', 'products.cost_price', 'products.sale_price', 'products.is_stock', 'products.is_publish', 'tp_status.status')
			->whereNotIn('products.id', [$id])
			->where('products.is_publish', 1)
			->orderBy('products.id','desc')
			->paginate(20);

		$relateddatalist = DB::table('products')
			->join('tp_status', 'products.is_publish', '=', 'tp_status.id')
//			->join('languages', 'products.lan', '=', 'languages.language_code')
			->join('related_products', 'products.id', '=', 'related_products.related_item_id')
			->select('related_products.id', 'products.title', 'products.f_thumbnail', 'products.is_publish', 'tp_status.status', )
			->where('related_products.product_id', $id)
			->where('products.is_publish', 1)
			->orderBy('related_products.id','desc')
			->paginate(20);

        return view('backend.related-products', compact('datalist', 'productlist', 'relateddatalist'));
    }

	//Get data for Products Pagination Related Products
	public function getProductListForRelatedTableData(Request $request){

		$search = $request->search;
		$id = $request->product_id;

		if($request->ajax()){

			if($search != ''){
				$productlist = DB::table('products')
					->join('tp_status', 'products.is_publish', '=', 'tp_status.id')
//					->join('languages', 'products.lan', '=', 'languages.language_code')
					->select('products.id', 'products.title', 'products.f_thumbnail', 'products.cost_price', 'products.sale_price', 'products.is_stock', 'products.is_publish', 'tp_status.status')
					->where(function ($query) use ($search){
						$query->where('title', 'like', '%'.$search.'%')
							->orWhere('cost_price', 'like', '%'.$search.'%');
					})
					->whereNotIn('products.id', [$id])
					->where('products.is_publish', 1)
					->orderBy('products.id','desc')
					->paginate(20);
			}else{
				$productlist = DB::table('products')
					->join('tp_status', 'products.is_publish', '=', 'tp_status.id')
//					->join('languages', 'products.lan', '=', 'languages.language_code')
					->select('products.id', 'products.title', 'products.f_thumbnail', 'products.cost_price', 'products.sale_price', 'products.is_stock', 'products.is_publish', 'tp_status.status')
					->whereNotIn('products.id', [$id])
					->where('products.is_publish', 1)
					->orderBy('products.id','desc')
					->paginate(20);
			}

			return view('backend.partials.products_list_for_related_product', compact('productlist'))->render();
		}
	}

	//Get data for Related Products Pagination
	public function getRelatedProductTableData(Request $request){

		$search = $request->search;
		$id = $request->product_id;

		if($request->ajax()){

			if($search != ''){
				$relateddatalist = DB::table('products')
					->join('tp_status', 'products.is_publish', '=', 'tp_status.id')
//					->join('languages', 'products.lan', '=', 'languages.language_code')
					->join('related_products', 'products.id', '=', 'related_products.related_item_id')
					->select('related_products.id', 'products.title', 'products.f_thumbnail', 'products.is_publish', 'tp_status.status')
					->where(function ($query) use ($search){
						$query->where('title', 'like', '%'.$search.'%')
							->orWhere('languages.language_name', 'like', '%'.$search.'%');
					})
					->where('related_products.product_id', $id)
					->where('products.is_publish', 1)
					->orderBy('related_products.id','desc')
					->paginate(20);
			}else{
				$relateddatalist = DB::table('products')
					->join('tp_status', 'products.is_publish', '=', 'tp_status.id')
//					->join('languages', 'products.lan', '=', 'languages.language_code')
					->join('related_products', 'products.id', '=', 'related_products.related_item_id')
					->select('related_products.id', 'products.title', 'products.f_thumbnail', 'products.is_publish', 'tp_status.status')
					->where('related_products.product_id', $id)
					->where('products.is_publish', 1)
					->orderBy('related_products.id','desc')
					->paginate(20);
			}

			return view('backend.partials.related_products_table', compact('relateddatalist'))->render();
		}
	}

	//Save data for Related Products
    public function saveRelatedProductsData(Request $request){
		$res = array();

		$product_id = $request->input('product_id');
		$related_item_id = $request->input('related_item_id');

		$data = array(
			'product_id' => $product_id,
			'related_item_id' => $related_item_id
		);

		$response = Related_product::create($data);
		if($response){
			$res['msgType'] = 'success';
			$res['msg'] = __('New Data Added Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data insert failed');
		}

		return response()->json($res);
    }

	//Delete data for Related Product
	public function deleteRelatedProduct(Request $request){
		$res = array();

		$id = $request->id;

		$response = Related_product::where('id', $id)->delete();
		if($response){
			$res['msgType'] = 'success';
			$res['msg'] = __('Data Removed Successfully');
		}else{
			$res['msgType'] = 'error';
			$res['msg'] = __('Data remove failed');
		}

		return response()->json($res);
	}

    //Save data for Products Bulk
    public function saveProductsBulk(Request $request){
        try {
            $file = $request->file('csv_file');
            $validator_array = array(
                'csv_file' => $file
            );
            $validator = Validator::make($validator_array, [
                'csv_file' => 'required|mimes:csv,txt'
            ]);
            $errors = $validator->errors();
            if($errors->has('csv_file')){
                $res['msgType'] = 'error';
                $res['msg'] = $errors->first('csv_file');
                return response()->json($res);
            }
            $response =  Excel::import(new ProductsImport, $file);

            if($response){
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            }else{
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }
            return response()->json($res);
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }

    }

    public function SKU_gen($pname, $cat=null, $brand=null, $id = null){
        $results = ''; // empty string

        $array = explode(' ', $pname);
        $str1 = array_shift($array);
        $str1 = strtoupper(substr($str1, 0, 3));
        $str2 = str_pad($cat , 3, 0, STR_PAD_LEFT);
        $str3 = str_pad($brand , 3, 0, STR_PAD_LEFT);
        $id = str_pad($id , 4, 0, STR_PAD_LEFT);
        $results .= "{$str1}-{$str2}{$str3}-{$id}";
        return $results;
    }

    public function excelToCsv($excelFile)
    {
        // Đọc dữ liệu từ file Excel
        $spreadsheet = IOFactory::load($excelFile);
        $worksheet = $spreadsheet->getActiveSheet();

        // Lưu dữ liệu sang file CSV
        $csvFile = public_path( uniqid() . '.csv');
        $file = fopen($csvFile, 'w');
        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }
            fputcsv($file, $rowData);
        }
        fclose($file);

        return $csvFile;
    }

    private function deleteImageFiles($path)
    {
        $imagePath = public_path('media/'). $path;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

}
