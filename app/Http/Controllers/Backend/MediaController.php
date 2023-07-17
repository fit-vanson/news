<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Jobs\InsertHashJob;
use App\Models\Media_option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    //Media page load
    public function getMediaPageLoad(Request $request)
    {

        $search = $request->search;

        if ($search != '') {
            $media_datalist = Media_option::where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('alt_title', 'like', '%' . $search . '%');
            })
                ->orderBy('id', 'desc')
                ->paginate(28);

            $media_datalist->appends(['search' => $search]);

        } else {
            $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);
        }

        return view('backend.media', compact('media_datalist'));
    }

    //Get data for Media Pagination
    public function getMediaPaginationData(Request $request)
    {

        $search = $request->search;

        if ($request->ajax()) {

            if ($search != '') {
                $media_datalist = Media_option::where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('alt_title', 'like', '%' . $search . '%');
                })
                    ->orderBy('id', 'desc')
                    ->paginate(28);

                $media_datalist->appends(['search' => $search]);

            } else {
                $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);
            }

            return view('backend.partials.media_pagination_data', compact('media_datalist'))->render();
        }
    }

    //Get data for media by id
    public function getMediaById(Request $request)
    {

        $id = $request->id;

        $data = Media_option::where('id', $id)->first();

        return response()->json($data);
    }

    //Save data for media
    public function mediaUpdate(Request $request)
    {
        $res = array();

        $id = $request->input('RecordId');
        $title = $request->input('title');
        $alt_title = $request->input('alternative_text');

        $data = array(
            'title' => $title,
            'alt_title' => $alt_title
        );

        $response = Media_option::where('id', $id)->update($data);
        if ($response) {
            $res['msgType'] = 'success';
            $res['msg'] = __('Data Updated Successfully');
        } else {
            $res['msgType'] = 'error';
            $res['msg'] = __('Data update failed');
        }

        return response()->json($res);
    }

    //Delete data for Media
    public function onMediaDelete(Request $request)
    {

        $res = array();

        $id = $request->id;

        if ($id != '') {

            $datalist = Media_option::where('id', $id)->first();
            $thumbnail = $datalist['thumbnail'];
            $large_image = $datalist['large_image'];

            if (file_exists(public_path('media/' . $thumbnail))) {
                unlink(public_path('media/' . $thumbnail));
            }

            if (file_exists(public_path('media/' . $large_image))) {
                unlink(public_path('media/' . $large_image));
            }

            $response = Media_option::where('id', $id)->delete();
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

    //Get data for Global Media
    public function getGlobalMediaData(Request $request)
    {

        $search = $request->search;

        if ($request->ajax()) {

            if ($search != '') {
                $media_datalist = Media_option::where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('alt_title', 'like', '%' . $search . '%');
                })
                    ->orderBy('id', 'desc')
                    ->paginate(28);

                $media_datalist->appends(['search' => $search]);

            } else {
                $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);
            }

            return view('backend.partials.global_media_pagination_data', compact('media_datalist'))->render();
        }
    }

    /**
     * public function syncImagesAndTable()
     * {
     * $mediaOptions = Media_option::select('id', 'thumbnail', 'large_image')->get();
     *
     * $allFiles = $this->getFilesRecursively('public/media');
     *
     *
     * // Xóa tiền tố 'public/media/' khỏi các tệp hình ảnh
     * $allFiles = array_map(function($file) {
     * return str_replace('public/media/', '', $file);
     * }, $allFiles);
     *
     * $deletedFiles = [];
     * $deletedRows = [];
     *
     * // Xóa các hình ảnh không có trong table media_options
     * foreach ($allFiles as $file) {
     * $thumbnailExists = $mediaOptions->contains('thumbnail', $file);
     * $largeImageExists = $mediaOptions->contains('large_image', $file);
     *
     * if (!$thumbnailExists && !$largeImageExists) {
     * Storage::delete('public/media/' . $file);
     * $deletedFiles[] = $file;
     * }
     * }
     *
     * // Xóa các row không có trong thư mục
     * foreach ($mediaOptions as $mediaOption) {
     * $thumbnailExists = in_array($mediaOption->thumbnail, $allFiles);
     * $largeImageExists = in_array($mediaOption->large_image, $allFiles);
     *
     * if (!$thumbnailExists || !$largeImageExists) {
     * $deletedRows[] = $mediaOption->toArray();
     * $mediaOption->delete();
     * }
     * }
     *
     * return ['deleted_files' => $deletedFiles, 'deleted_rows' => $deletedRows];
     * }
     **/
    public function syncImagesAndTable()
    {
        Log::info('Entering syncImagesAndTable');
        try {
            set_time_limit(0);
            ini_set('memory_limit', '512M'); // Adjust the value as needed

            $deletedFiles = [];
            $deletedRows = [];

            // Get all image paths from the database
            $imagePaths = Media_option::select('thumbnail', 'large_image')->get()->flatMap(function ($mediaOption) {
                return [$mediaOption->thumbnail, $mediaOption->large_image];
            })->unique();

            // Compare image paths from the database with actual files and delete unused files
            foreach ($this->getFilesRecursively('public/media') as $file) {
                $relativeFile = str_replace('public/media/', '', $file);
                if (!$imagePaths->contains($relativeFile)) {
                    Storage::delete($file);
                    $deletedFiles[] = $relativeFile;
                }
            }

            // Process media options using cursor to save memory
            $mediaOptions = Media_option::orderBy('id')->cursor();
            $idsToDelete = [];
            $rowsToDelete = [];

            foreach ($mediaOptions as $mediaOption) {
                $thumbnailExists = Storage::exists('public/media/' . $mediaOption->thumbnail);
                $largeImageExists = Storage::exists('public/media/' . $mediaOption->large_image);

                if (!$thumbnailExists || !$largeImageExists) {
                    $idsToDelete[] = $mediaOption->id;
                    $rowsToDelete[] = $mediaOption->toArray();

                    if (count($idsToDelete) >= 500) { // Customize the chunk size if needed
                        Media_option::whereIn('id', $idsToDelete)->delete();
                        $deletedRows = array_merge($deletedRows, $rowsToDelete);
                        $idsToDelete = [];
                        $rowsToDelete = [];
                    }
                }
            }

            // Delete remaining rows if any
            if (count($idsToDelete) > 0) {
                Media_option::whereIn('id', $idsToDelete)->delete();
                $deletedRows = array_merge($deletedRows, $rowsToDelete);
            }

            return ['deleted_files' => $deletedFiles, 'deleted_rows' => $deletedRows];
        } catch (\Exception $e) {
            Log::error('syncImagesAndTable : ' . $e->getMessage() . ' - line: ' . $e->getLine());
            return null;
        }
    }

    private function getFilesRecursively($directory)
    {
        $files = Storage::files($directory);
        foreach ($files as $file) {
            yield $file;
        }

        $subDirectories = Storage::directories($directory);
        foreach ($subDirectories as $subDirectory) {
            yield from $this->getFilesRecursively($subDirectory);
        }
    }

    public function insertHash()
    {
        $limit = 1000;
        $totalRows = Media_option::getMediaOptionWithoutHash()->count();

        if ($totalRows == 0) {
            return 'All images already have hash.';
        }

        $totalBatch = ceil($totalRows / $limit);

        for ($i = 0; $i < $totalBatch; $i++) {
            $offset = $i * $limit;
            $mediaOptions = Media_option::getMediaOptionWithoutHash($limit, $offset);

            if ($mediaOptions->count() == 0) {
                break;
            }
            $job = new InsertHashJob($mediaOptions->all());
            dispatch($job);
        }
        return 'Insert hash job dispatched.';
    }


//    function  checkDuplicateImage(string $imagePath, int $similarity = 5): bool
//    {
//
//        $hasher = new ImageHash(new DifferenceHash());
//
//        $duplicates = DB::table('media_options')->select('id', 'hash_image')->get();
//        if ($duplicates->isEmpty()) {
//            return null;
//        }
//        foreach ($rows as $row) {
//            // Kiểm tra xem hash của ảnh có tồn tại trong mảng hashes chưa
//            if (in_array($row->hash_image, $hashes)) {
//                // Nếu đã tồn tại thì xoá row và ảnh tương ứng
//                DB::table('media_options')->where('id', $row->id)->delete();
//                // Cập nhật thông tin cho các bảng liên quan
//                updateProductAndProImageTable($row->hash_image);
//            } else {
//                // Nếu chưa tồn tại thì thêm hash vào mảng
//                $hashes[] = $row->hash_image;
//            }
//        }
//    }
//
//    function updateProductAndProImageTable($hash)
//    {
//        // Lấy tất cả các row trong bảng media_options có hash_image = $hash
//        $rows = DB::table('media_options')->where('hash_image', $hash)->get();
//
//        foreach ($rows as $row) {
//            // Cập nhật thông tin cho bảng pro_image
//            DB::table('pro_image')->where('thumbnail', $row->thumbnail)->update(['hash_image' => '']);
//            // Cập nhật thông tin cho bảng product
//            DB::table('product')->where('f_thumbnail', $row->thumbnail)->update(['f_thumbnail' => '']);
//        }
//    }


}
