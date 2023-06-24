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
    public function homePageLoad()
	{
        $site = getSite();

        if(!$site){
            return 1;
        }

        $categories = $site->categories()
            ->where('is_publish', 1)
            ->whereHas('news', function ($query) {
                $query->where('is_publish', 1);
            })
            ->get();


        $newsQuery = $site->news()
            ->with('categories')
            ->where('news.is_publish', 1);

        $newsCount = $newsQuery->count();
        $limit = min($newsCount, 5);

        $newsLatest = $newsQuery->latest()->take($limit)->get();
        $newsRandom = ($limit > 0) ? $newsQuery->inRandomOrder()->take($limit)->get() : collect();
        $newsViewers = ($limit > 0) ? $newsQuery->orderBy('news.viewers', 'desc')->take($limit)->get() : collect();
        $newsBreaking = $newsQuery->where('news.breaking_news', 1)->take($limit)->get();


        return view('frontend.pages.home',compact('categories','newsLatest','newsViewers','newsRandom','newsBreaking'));


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
