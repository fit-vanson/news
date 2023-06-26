<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\MultipleSites;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Review;
use App\Models\Order_master;
use App\Models\Product;
use App\Models\Pro_category;
use App\Models\Brand;
use App\Models\User;

class DashboardController extends Controller
{
    //Dashboard page load
    public function getDashboardData(){

        if (auth()->user()->role_id == 1){
            $total_sites = MultipleSites::count();
            $total_categories = Categories::count();
            $allNews = News::all();
            $total_news = count($allNews);
            $limit = min($total_news, 10);
            $newsLatest = ($limit > 0) ?  $allNews->sortByDesc('created_at')->take($limit) : collect();
            $newsViewers = ($limit > 0) ? $allNews->sortByDesc('viewers')->take($limit) : collect();

            return view('backend.dashboard', compact('total_sites', 'total_categories', 'total_news', 'newsLatest', 'newsViewers'));
        }elseif (auth()->user()->role_id == 3){
            $user_id = Auth::user()->id;
            $total_sites = MultipleSites::count();
            $total_categories = Categories::count();
            $allNews = News::where('user_id',$user_id)->get();
            $total_news = count($allNews);
            $limit = min($total_news, 10);
//        $newsLatest = ($limit > 0) ?  $allNews->sortByDesc('created_at')->take($limit) : collect();
            $newsViewers = ($limit > 0) ? $allNews->sortByDesc('viewers')->take($limit) : collect();
            return view('editor.dashboard',  compact('total_sites', 'total_categories', 'total_news', 'newsViewers'));
        }


    }
}
