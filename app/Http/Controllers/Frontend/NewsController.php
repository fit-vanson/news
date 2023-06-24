<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Newscategory;
use App\Models\Newscomment;
use App\Models\Socialshare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function maanNewsComment(Request $request,$id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'comment'=>'required'
        ]);
        $newscomments = new Newscomment();
        $newscomments->news_id = $id;
        $newscomments->name = $request->name;
        $newscomments->email = $request->email;
        $newscomments->comment = $request->comment;
        $newscomments->save();
        return redirect()->back();
    }

    public function news($category)
    {
        $site = getSite();
        if(!$site){
            return 1;
        }

        $category = $site->categories()
            ->where('is_publish', 1)
            ->where('name',rawurlencode($category))
            ->first();
        $newsQuery = $category
            ->news()
            ->where('news.is_publish',1);

        $newsCount = $newsQuery->count();
        $limit = min($newsCount, 3);

        $allNews = $newsQuery
            ->orderByDesc('news.id')
            ->paginate(10);

        $newsViewers = ($limit > 0) ? $newsQuery->orderBy('news.viewers', 'desc')->take($limit)->get() : collect();
        $newsRandom = ($limit > 0) ? $newsQuery->inRandomOrder()->take($limit)->get() : collect();

        return view('frontend.pages.news',compact('allNews','newsViewers','newsRandom','category'));
    }

/*    public function newsDetails($id,$slug=null)
    {

        $news = News::find($id);

        $viewers = $news->viewers;
        $news->viewers = $viewers +1;
        $news->save();

        //related news
        $relatedgetsnews = News::orderByDesc('news.id')
            ->where('news.id','!=',$id)
            ->where('news.is_publish',1)
            ->limit(3)
            ->get();

        $site = getSite();
        $site_option = $site->site_options;
        $theme_option_social_media =  $site_option->theme_option_social_media ?? null ;
        if($theme_option_social_media){
            $social_media = json_decode($theme_option_social_media,true);
        }else{
            $social_media = null;
        }

        return view('frontend.pages.news_details',compact('news','relatedgetsnews','social_media'));
    }*/

    public function newsDetails($id, $slug = null)
    {
        $news = News::findOrFail($id);

        $news->increment('viewers');

        $relatedNews = News::orderByDesc('id')
            ->where('id', '!=', $id)
            ->where('is_publish', 1)
            ->limit(3)
            ->get();

        $site = getSite();
        $site_option = $site->site_options;
        $theme_option_social_media = $site_option->theme_option_social_media ?? null;
        $social_media = $theme_option_social_media ? json_decode($theme_option_social_media, true) : null;

        return view('frontend.pages.news_details', compact('news', 'relatedNews', 'social_media'));
    }


}
