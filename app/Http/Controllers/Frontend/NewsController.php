<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Torann\GeoIP\Facades\GeoIP;

class NewsController extends Controller
{
    public function maanNewsComment(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required'
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
        if (!$site) {
            return 1;
        }

        $category = $site->categories()
            ->where('is_publish', 1)
            ->where('name', rawurlencode($category))
            ->first();
        $newsQuery = $category
            ->news()
            ->where('news.is_publish', 1);

        $newsCount = $newsQuery->count();
        $limit = min($newsCount, 4);

        $allNews = $newsQuery
            ->orderByDesc('news.id')
            ->paginate(10);

        $newsViewers = ($limit > 0) ? $newsQuery->orderBy('news.viewers', 'desc')->take($limit)->get() : collect();
        $newsRandom = ($limit > 0) ? $newsQuery->inRandomOrder()->take($limit)->get() : collect();

        return view('frontend.pages.news', compact('allNews', 'newsViewers', 'newsRandom', 'category'));
    }


    public function newsDetails($id, $slug = null)
    {

        $site = getSite();
        if (!$site) {
            return 1;
        }

        $newsQuery = $site
            ->news();

        $news = $newsQuery->findOrFail($id);
        $news->increment('viewers');

        $this->tracknews($news);

        $relatedNews = $newsQuery
            ->orderByDesc('news.id')
            ->where('news.id', '!=', $id)
            ->where('news.is_publish', 1)
            ->limit(3)
            ->get();

        $site_option = $site->site_options;
        $theme_option_social_media = $site_option->theme_option_social_media ?? null;
        $social_media = $theme_option_social_media ? json_decode($theme_option_social_media, true) : null;

        return view('frontend.pages.news_details', compact('news', 'relatedNews', 'social_media'));
    }

    public function tracknews($news){
        $ip_address = getIp();

        $location = GeoIP::getLocation($ip_address);
        $agent = new Agent();

        $track_news = [
            'news_id' => $news->id,
            'is_robot' => $agent->isRobot(),
            'robot' => $agent->robot(),
            'ip_address' => $ip_address,
            'device_name' => $agent->device(),
            'device_name_full' => $agent->getUserAgent(),
            'platform_name' => $agent->platform() !=0 ? $agent->platform() : 'other',
            'country' => $location['country'],
            'created_at' => Carbon::now()->startOfDay()
        ];


        return $news->trackNews()
            ->updateOrCreate($track_news)
            ->increment('count', 1);
    }


}
