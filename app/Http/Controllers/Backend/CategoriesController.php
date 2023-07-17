<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Media_option;
use App\Models\MultipleSites;
use App\Models\Pro_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    //Categories page load
    public function getCategoriesPageLoad()
    {
        $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);

        $statuslist = DB::table('tp_status')->orderBy('id', 'asc')->get();

        $id = \request()->site_id;
        $site = MultipleSites::findorFail($id);
        $data = [
            'id' => $id,
            'title_row' => 'Categories',
            'name' => $site->site_name,
            'web' => $site->site_web,
        ];
        $datalist = $data;
        $categories = $site->categories()->orderBy('categories.id', 'desc')->paginate(10);
        return view('backend.categories', compact('media_datalist', 'statuslist', 'datalist', 'categories'));

    }

    //Get data for Categories Pagination
    public function getCategoriesTableData(Request $request)
    {

        $search = $request->search;
        $site_id = $request->site_id;
        $site = MultipleSites::findorFail($site_id);
        if ($request->ajax()) {
            if ($search != '') {
                $categories = $site->categories()
                    ->where(function ($query) use ($search) {
                        $query->where('name', 'like', '%' . rawurlencode($search) . '%')
                            ->orWhere('description', 'like', '%' . $search . '%');
                    })
                    ->orderBy('categories.id', 'desc')
                    ->paginate(10);
            } else {
                $categories = $site->categories()
                    ->orderBy('categories.id', 'desc')
                    ->paginate(10);
            }

            return view('backend.partials.categories_table', compact('categories'))->render();
        }

    }

    //Save data for Categories
    public function saveCategoriesData(Request $request)
    {
        $res = array();
        $site_id = \request()->site_id;
        $id = $request->input('RecordId');
        $name = esc($request->input('name'));
        $slug = esc(str_slug($request->input('slug')));
        $thumbnail = $request->input('thumbnail');
        $description = esc($request->input('description'));
        $is_publish = $request->input('is_publish');

        $og_title = esc($request->input('og_title'));
        $og_image = $request->input('og_image');
        $og_description = esc($request->input('og_description'));
        $og_keywords = esc($request->input('og_keywords'));


        $validator_array = array(
            'name' => $request->input('name'),
            'slug' => $slug,
            'is_publish' => $request->input('is_publish')
        );

        $rId = $id == '' ? '' : ',' . $id;
        $validator = Validator::make($validator_array, [
            'name' => 'required|max:191',
            'slug' => 'required|max:191|unique:categories,slug' . $rId,
            'is_publish' => 'required'
        ]);

        $errors = $validator->errors();

        if ($errors->has('name')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('name');
            return response()->json($res);
        }

        if ($errors->has('slug')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('slug');
            return response()->json($res);
        }

        if ($errors->has('is_publish')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('is_publish');
            return response()->json($res);
        }

        $data = array(
            'site_id' => $site_id,
            'name' => rawurlencode($name),
            'slug' => rawurlencode($slug),
            'description' => rawurlencode($description),

            'is_publish' => $is_publish,
            'thumbnail' => $thumbnail,
            'og_image' => $og_image,


            'og_title' => rawurlencode($og_title),
            'og_description' => rawurlencode($og_description),
            'og_keywords' => rawurlencode($og_keywords)
        );

        if ($id == '') {
            $response = Categories::create($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('New Data Added Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data insert failed');
            }
        } else {
            $response = Categories::where('id', $id)->update($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }
        }

        return response()->json($res);
    }

    //Get data for Categories by id
    public function getCategoriesById(Request $request)
    {

        $id = $request->id;
        $data = Categories::where('id', $id)->first();
        return response()->json($data);
    }

    //Delete data for Categories
    public function deleteCategories(Request $request)
    {

        $res = array();

        $id = $request->id;

        if ($id != '') {
            $response = Categories::where('id', $id)->first();

            if (count($response->news) == 0) {
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
                $res['msg'] = __('Không thể xoá!');
            }

        }

        return response()->json($res);
    }

    //Bulk Action for Categories
    public function bulkActionCategories(Request $request)
    {

        $res = array();

        $idsStr = $request->ids;
        $idsArray = explode(',', $idsStr);

        $BulkAction = $request->BulkAction;

        if ($BulkAction == 'publish') {
            $response = Categories::whereIn('id', $idsArray)->update(['is_publish' => 1]);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }

        } elseif ($BulkAction == 'draft') {

            $response = Categories::whereIn('id', $idsArray)->update(['is_publish' => 2]);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }

        } elseif ($BulkAction == 'delete') {
            $response = Categories::whereIn('id', $idsArray)->delete();
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

    //has Category Slug
    public function hasCategorySlug(Request $request)
    {
        $res = array();

        $slug = str_slug($request->slug);
        $count = Categories::where('slug', 'like', '%' . $slug . '%')->count();
        if ($count == 0) {
            $res['slug'] = $slug;
        } else {
            $incr = $count + 1;
            $res['slug'] = $slug . '-' . $incr;
        }

        return response()->json($res);
    }

    //Save data for Categories Bulk
    public function saveCategoriesBulk(Request $request)
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
            $existingCategory = Pro_category::where('name', $row[0])->first();

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
        $response = Pro_category::insert($categories);
        if ($response) {
            $res['msgType'] = 'success';
            $res['msg'] = __('Data Updated Successfully');
        } else {
            $res['msgType'] = 'error';
            $res['msg'] = __('Data update failed');
        }
        return response()->json($res);
    }
}
