<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MultipleSites;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;
use App\Models\Pro_category;
use App\Models\Offer_ad;
use App\Models\Brand;
use App\Models\Tp_option;
use App\Models\Section_manage;

class HomeFrontendController extends Controller
{
	//Get Frontend Data
    public function homePageLoad(Request $request)
	{
		$lan = glan();
        $site = getSite();

        if(!$site){
            return 1;
        }

        $site_id = $site->id;

//		$PageVariation = PageVariation();
//        $home = $PageVariation['home_variation'];

        $SectionManage =  Section_manage::orderBy('section_manages.id','asc')->get();
        $SiteSectionManage = $site->section_manage;
        $SectionManages = $SectionManage->merge($SiteSectionManage);

        $section = array();
        for($i=1; $i<=16; $i++){
            $section['section'.$i] = searchMultiArray('section_'.$i,$SectionManages,'section');
            if($section['section'.$i] ==''){
                $section_array =  array();
                $section_array['image'] = '';
                $section_array['is_publish'] = 2;
                $section['section'.$i] = json_decode(json_encode($section_array));
            }
        }

        $section1 = $section['section1'];
        $section2 = $section['section2'];
        $section3 = $section['section3'];
        $section4 = $section['section4'];
        $section5 = $section['section5'];
        $section6 = $section['section6'];
        $section7 = $section['section7'];
        $section8 = $section['section8'];
        $section9 = $section['section9'];
        $section10 = $section['section10'];
        $section11 = $section['section11'];
        $section12 = $section['section12'];
        $section13 = $section['section13'];
        $section14 = $section['section14'];
        $section15 = $section['section15'];
        $section16= $section['section16'];



        //Home Video Section
        $site_option = $site->site_options;
        $home_video = [
            'title' => '',
            'short_desc' => '',
            'url' => '',
            'video_url' => '',
            'button_text' => '',
            'target' => '',
            'image' => '',
            'is_publish' => '2',

        ];
        if(isset($site_option)){
            $results = $site_option->home_video;
            if($results){
                $dataObj = json_decode($results);
                $home_video['title'] = $dataObj->title;
                $home_video['short_desc'] = $dataObj->short_desc;
                $home_video['url'] = $dataObj->url;
                $home_video['video_url'] = $dataObj->video_url;
                $home_video['button_text'] = $dataObj->button_text;
                $home_video['target'] = $dataObj->target;
                $home_video['image'] = $dataObj->image;
                $home_video['is_publish'] = $dataObj->is_publish;
            }
        }

        //Product Category
        $pro_category = $site->categories()->where('is_publish', '=', 1)->orderBy('id', 'desc')->get();

        $brand = Brand::whereHas('products.categories.site', function ($query) use ($site_id) {
            $query->where('multiple_site_id', $site_id);
            })
            ->where('is_publish', '=', 1)->where('is_featured', '=', 1)
            ->get();

        //Popular Products
        $popular_products = $this->getProduct($site_id,1);

        //New Products
        $new_products = $this->getProduct($site_id,1,false,false,false,8,'id');

        //Top Selling
        $top_selling = $this->getProduct($site_id,1,false,false,false,48,'id',true);

        //Trending Products
        $trending_products = $this->getProduct($site_id,1,true,false,false,8,'id');

        //Top Rated
        $top_rated = $this->getProduct($site_id,1,false,false,false,8,'reviews_avg',false,true);

        //Deals Of The Day
        $deals_products = $this->getProduct($site_id,1,false,false,true,8,'id');

        //Slider
        $slider = $site->sliders()->where('is_publish', '=', 1)->orderBy('id', 'desc')->get();

        //Offer & Ads - Position 1
        $offer_ad_position1 = $site->offer_ads()->where('is_publish', '=', 1)->where('offer_ad_type', '=', 'position1')->orderBy('id', 'desc')->get();

        //Offer & Ads - Position 2
        $offer_ad_position2 = $site->offer_ads()->where('is_publish', '=', 1)->where('offer_ad_type', '=', 'position2')->orderBy('id', 'desc')->get();


        return view('frontend.home', compact(
			'section1',
			'section2',
			'section3',
			'section4',
			'section5',
			'section6',
			'section7',
			'section8',
			'section9',
			'section10',
			'section11',
			'section12',
			'section13',
			'section14',
			'section15',
			'section16',
			'slider',
			'pro_category',
			'offer_ad_position1',
			'offer_ad_position2',
			'home_video',
			'brand',
			'popular_products',
			'new_products',
			'top_selling',
			'trending_products',
			'top_rated',
			'deals_products'
		));
    }

    public function getProduct($site_id, $is_publish = 1,$is_trending = false, $is_popular = false,$is_discount = false  ,$limit = 10,$order='RAND()',$top_selling = false, $top_rate = false){
        if($top_selling){
            $products =  Product::orderBy($order,'desc')
                ->whereHas('categories.site', function ($query) use ($is_publish, $site_id) {
                    $query
                        ->where('is_publish', $is_publish)
                        ->where('multiple_site_id', $site_id);
                })
                ->whereHas('order_items.order_masters', function ($query) {
                    $query->where('order_status_id', 4);
                })
                ->limit(4)
                ->get();
        }elseif ($top_rate){
            $products =  Product::orderBy($order,'desc')
                ->withCount(['reviews as reviews_avg' => function($query) {
                    $query->select(DB::raw('avg(rating)'));
                }])
                ->whereHas('categories.site', function ($query) use ($is_publish, $site_id) {
                    $query
                        ->where('is_publish', $is_publish)
                        ->where('multiple_site_id', $site_id);
                })
                ->limit($limit)
                ->get();
        }elseif ($is_trending){
            $products =  Product::orderBy($order,'desc')
                ->where('collection_id',1)
                ->whereHas('categories.site', function ($query) use ($is_publish, $site_id) {
                    $query
                        ->where('is_publish', $is_publish)
                        ->where('multiple_site_id', $site_id);
                })
                ->limit($limit)
                ->get();
        }elseif ($is_popular){
            $products =  Product::orderBy($order,'desc')
                ->where('is_featured',1)
                ->whereHas('categories.site', function ($query) use ($is_publish, $site_id) {
                    $query
                        ->where('is_publish', $is_publish)
                        ->where('multiple_site_id', $site_id);
                })
                ->limit($limit)
                ->get();
        }elseif ($is_discount){
            $products =  Product::orderBy($order,'desc')
                ->where('is_discount',1)
                ->whereHas('categories.site', function ($query) use ($is_publish, $site_id) {
                    $query
                        ->where('is_publish', $is_publish)
                        ->where('multiple_site_id', $site_id);
                })
                ->limit($limit)
                ->get();
        }
        else{

            $products = Product::orderByRaw($order)
                ->whereHas('categories.site', function ($query) use ($is_publish, $site_id) {
                    $query
                        ->where('is_publish', $is_publish)
                        ->where('multiple_site_id', $site_id);
                })
                ->where('is_publish', $is_publish)
                ->limit($limit)
                ->get();

        }
        for($i=0; $i<count($products); $i++){
            $Reviews = getReviews($products[$i]->id);
            $products[$i]->TotalReview = $Reviews[0]->TotalReview;
            $products[$i]->TotalRating = $Reviews[0]->TotalRating;
            $products[$i]->ReviewPercentage = number_format($Reviews[0]->ReviewPercentage);
            $products[$i]->brand = $products[$i]->brand;
        }

        return $products;
    }
}
