<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function Search(Request $request)
    {

        $site = getSite();
        if(!$site){
            return 1;
        }
        $searchValue = htmlDecode(rawurlencode($request->search));

        $newsQuery = $site
            ->news()
            ->where('news.is_publish',1)
            ->where(function ($query) use ($searchValue) {
                $query
                    ->where('news.title', 'like', '%' . $searchValue . '%')
                    ->orwhere('news.summary', 'like', '%' . $searchValue . '%')
                    ->orwhere('news.description', 'like', '%' . $searchValue . '%');
            });


        $searchNews = $newsQuery
            ->orderByDesc('news.id')
            ->paginate(10);

        $popularsNews = $newsQuery
            ->orderByDesc('news.viewers')
            ->limit(4)
            ->get();

        $recentNews = $newsQuery
            ->orderByDesc('news.id')
            ->limit(5)
            ->get();


        return view('frontend.pages.search',compact('searchNews','popularsNews','recentNews'));
    }
}
