<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Media_option;
use App\Models\MultipleSites;
use App\Models\News;
use App\Models\Pro_category;
use App\Models\TrackNewsUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class NewsController extends Controller
{
    //News page load
    public function getNewsPageLoad()
    {
        $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);

        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();
        $id = \request()->site_id;

        $categorylist = Categories::orderBy('name', 'asc')
            ->where('site_id', $id)
            ->where('is_publish', 1)
            ->get();


        $site = MultipleSites::findorFail($id);
        $data = [
            'id' => $id,
            'title_row' => 'News',
            'name' => $site->site_name,
            'web' => $site->site_web,
        ];
        $datalist = $data;

        $news = $site->news()->orderBy('news.id', 'desc')->paginate(10);
        return view('backend.news', compact('media_datalist', 'statuslist', 'datalist', 'news', 'categorylist'));

    }

    //Get data for News Pagination
    public function getNewsTableData(Request $request)
    {

        $search = $request->search;
        $site_id = $request->site_id;
        $category_id = $request->category_id;

        $site = MultipleSites::findorFail($site_id);
        if ($request->ajax()) {
            if ($search != '') {
                $news = $site->news()
                    ->where(function ($query) use ($search) {
                        $query->whereRaw("LOWER(title) LIKE '%" . strtolower(rawurlencode($search)) . "%'");
                    })
                    ->where(function ($query) use ($category_id) {
                        $query->whereRaw("categories.id = '" . $category_id . "' OR '" . $category_id . "' = '0'");
                    })
                    ->orderBy('news.id', 'desc')
                    ->paginate(10);
            } else {
                $news = $site->news()
                    ->orderBy('news.id', 'desc')
                    ->where(function ($query) use ($category_id) {
                        $query->whereRaw("categories.id = '" . $category_id . "' OR '" . $category_id . "' = '0'");
                    })
                    ->paginate(10);
            }
            return view('backend.partials.news_table', compact('news'))->render();
        }
    }

    //Save data for News
    public function saveNewsData(Request $request)
    {
        $res = array();

        $id = $request->input('RecordId');
        $title = esc($request->input('news_title'));
        $slug = esc(str_slug($request->input('slug')));
        $summary = esc($request->input('summary'));
        $content = esc($request->input('content'));

        $thumbnail = $request->input('thumbnail');
        $is_publish = $request->input('is_publish');
        $breaking_news = $request->input('breaking_news');

        $og_title = esc($request->input('og_title'));
        $og_image = $request->input('og_image');
        $og_description = esc($request->input('og_description'));
        $og_keywords = esc($request->input('og_keywords'));


        $original_url = $request->input('original_url');
        $category_id = $request->input('cate_id');


        $validator_array = array(
            'news_title' => $title,
            'slug' => $slug,
            'summary' => $summary,
            'content' => $content,
            'cate_id' => $category_id,

            'is_publish' => $request->input('is_publish')
        );

        $rId = $id == '' ? '' : ',' . $id;
        $validator = Validator::make($validator_array, [
            'news_title' => 'required|max:191',
            'slug' => 'required|max:191|unique:news,slug' . $rId,
            'summary' => 'required',
            'content' => 'required',
            'cate_id' => 'required',
            'is_publish' => 'required',
        ]);

        $errors = $validator->errors();

        if ($errors->has('news_title')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('title');
            return response()->json($res);
        }

        if ($errors->has('slug')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('slug');
            return response()->json($res);
        }

        if ($errors->has('summary')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('summary');
            return response()->json($res);
        }
        if ($errors->has('content')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('content');
            return response()->json($res);
        }
        if ($errors->has('cate_id')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('cate_id');
            return response()->json($res);
        }

        if ($errors->has('is_publish')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('is_publish');
            return response()->json($res);
        }

        $user = Auth::id();


        $data = array(
            'category_id' => $category_id,

            'title' => rawurlencode($title),
            'slug' => rawurlencode($slug),
            'summary' => rawurlencode($summary),
            'description' => rawurlencode($content),
            'original_url' => rawurlencode($original_url),

            'thumbnail' => $thumbnail,
            'is_publish' => $is_publish,
            'breaking_news' => $breaking_news,
            'og_image' => $og_image,


            'og_title' => rawurlencode($og_title),
            'og_description' => rawurlencode($og_description),
            'og_keywords' => rawurlencode($og_keywords)
        );


        if ($id == '') {
            $data['user_id'] = $user;

            $response = News::create($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('New Data Added Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data insert failed');
            }
        } else {
            $response = News::where('id', $id)->first();
            if (auth()->user()->role_id == 1 || $user == $response->user_id) {
                $response->update($data);
                if ($response) {
                    $res['msgType'] = 'success';
                    $res['msg'] = __('Data Updated Successfully');
                } else {
                    $res['msgType'] = 'error';
                    $res['msg'] = __('Data update failed');
                }
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Tài khoản không thể chỉnh sửa bài viết này');
            }

        }

        return response()->json($res);
    }

    //Get data for News by id
    public function getNewsById(Request $request)
    {

        $id = $request->id;
        $data = News::where('id', $id)->first()->toArray();
        return response()->json($data);
    }

    //Delete data for News
    public function deleteNews(Request $request)
    {

        $res = array();
        $id = $request->id;
        $user = Auth::id();


        if ($id != '') {
            $response = News::where('id', $id)->first();
            if (auth()->user()->role_id == 1 || $user == $response->user_id) {
                $response->delete();
                if ($response) {
                    $res['msgType'] = 'success';
                    $res['msg'] = __('Data Removed Successfully');
                } else {
                    $res['msgType'] = 'error';
                    $res['msg'] = __('Data remove failed');
                }
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Tài khoản không thể xoá bài viết này');
            }
        }

        return response()->json($res);
    }

    //Bulk Action for News
    public function bulkActionNews(Request $request)
    {

        $res = array();

        $idsStr = $request->ids;
        $idsArray = explode(',', $idsStr);

        $BulkAction = $request->BulkAction;

        if ($BulkAction == 'publish') {
            $response = News::whereIn('id', $idsArray)->update(['is_publish' => 1]);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }

        } elseif ($BulkAction == 'draft') {

            $response = News::whereIn('id', $idsArray)->update(['is_publish' => 2]);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }

        } elseif ($BulkAction == 'delete') {
            $response = News::whereIn('id', $idsArray)->delete();
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

    //has News Slug
    public function hasNewsSlug(Request $request)
    {
        $res = array();

        $slug = str_slug($request->slug);
        $count = News::where('slug', 'like', '%' . $slug . '%')->count();
        if ($count == 0) {
            $res['slug'] = $slug;
        } else {
            $incr = $count + 1;
            $res['slug'] = $slug . '-' . $incr;
        }

        return response()->json($res);
    }

    //Save data for News Bulk
    public function saveNewsBulk(Request $request)
    {
        $file = $request->file('csv_file');
        $validator_array = array(
            'csv_file' => $file
        );
        $validator = Validator::make($validator_array, [
            'csv_file' => 'required|mimes:csv,txt'
        ]);
        $errors = $validator->errors();
        if ($errors->has('csv_file')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('csv_file');
            return response()->json($res);
        }
        // Đọc dữ liệu từ file CSV
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));

        array_shift($rows);

        $categories = [];
        foreach ($rows as $row) {
            $existingCategory = News::where('name', $row[0])->first();

            $isValidRow = true;
            foreach ($row as $value) {
                if (is_null($value)) {
                    $isValidRow = false;
                    break;
                }
            }
            if ($isValidRow) {
                if (!$existingCategory) {
                    $categories[] = [
                        'name' => $row[0],
                        'slug' => $row[1] != "" ? $row[1] : str_slug($row[0]),
                        'is_publish' => $row[2] != "" ? $row[2] : 1,
                        'description' => $row[3] != "" ? $row[3] : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }
        $response = News::insert($categories);
        if ($response) {
            $res['msgType'] = 'success';
            $res['msg'] = __('Data Updated Successfully');
        } else {
            $res['msgType'] = 'error';
            $res['msg'] = __('Data update failed');
        }
        return response()->json($res);
    }


    //News page load
    public function getTrackNewsPageLoad()
    {
        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $data = [
            'id' => $id,
            'title_row' => 'News',
            'name' => $site->site_name,
            'web' => $site->site_web,
        ];
        $datalist = $data;

        $news_id = $site->news->pluck('id')->toArray();

        $trackNews = TrackNewsUrl::query()->whereIn('news_id',$news_id)->orderBy('created_at', 'desc')->paginate(10);


        return view('backend.track_news', compact(  'datalist', 'trackNews'));

    }

    //Get data for News Pagination
    public function getTrackNewsTableData(Request $request)
    {
        $search = $request->search;
        $site_id = $request->site_id;

        $site = MultipleSites::findorFail($site_id);

        $news_id = $site->news->pluck('id')->toArray();
        if ($request->ajax()) {
            if ($search != '') {
                $trackNews = TrackNewsUrl::query()
                    ->whereIn('news_id',$news_id)
                    ->whereHas('news', function ($query) use ($search) {
                        $query->whereRaw("LOWER(title) LIKE '%" . strtolower(rawurlencode($search)) . "%'");

                    })
                    ->OrwhereRaw("ip_address LIKE '%" . $search . "%'")
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            } else {
                $trackNews = TrackNewsUrl::query()
                    ->whereIn('news_id',$news_id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }
            return view('backend.partials.track_news_table', compact('trackNews'))->render();
        }
    }


    //Read Time  page load
    public function getTrackReadTimePageLoad()
    {
        $trackReadTime = TrackNewsUrl::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.track_read_time', compact(  'trackReadTime'));

    }

    //Get data for Read Time Pagination
    public function getTrackReadTimeTableData(Request $request)
    {
        $search = $request->search;

        if ($request->ajax()) {
            if ($search != '') {
                $trackReadTime = TrackNewsUrl::query()
                    ->whereHas('news.categories.site', function ($query) use ($search) {
                        $query->whereRaw("LOWER(title) LIKE '%" . strtolower(rawurlencode($search)) . "%'")
                            ->orwhereRaw("site_web LIKE '%" . $search . "%'");
                    })
                    ->OrwhereRaw("ip_address LIKE '%" . $search . "%'")
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            } else {
                $trackReadTime = TrackNewsUrl::query()
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }
            return view('backend.partials.track_read_time_table', compact('trackReadTime'))->render();
        }
    }
}
