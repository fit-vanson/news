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
        $limit = min($newsCount, 3);

        $newsLatest = $newsQuery->latest()->take($limit)->get();
        $newsRandom = ($limit > 0) ? $newsQuery->inRandomOrder()->take($limit)->get() : collect();
        $newsViewers = ($limit > 0) ? $newsQuery->orderBy('news.viewers', 'desc')->take($limit)->get() : collect();
        $newsBreaking = $newsQuery->where('news.breaking_news', 1)->take($limit)->get();

        return view('frontend.pages.home',compact('categories','newsLatest','newsViewers','newsRandom','newsBreaking'));

    }
}
