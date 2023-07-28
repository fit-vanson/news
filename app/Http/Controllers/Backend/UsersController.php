<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Media_option;
use App\Models\News;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UsersController extends Controller
{
    //Users page load
    public function getUsersPageLoad()
    {
        $statuslist = DB::table('user_status')->orderBy('id', 'asc')->get();
        $roleslist = DB::table('user_roles')->whereNotIn('id', [2])->orderBy('id', 'asc')->get();
        $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);

        $datalist = User::orderBy('users.name', 'asc')
            ->paginate(20);
        return view('backend.users', compact('statuslist', 'roleslist', 'media_datalist', 'datalist'));
    }

    //Get data for Users Pagination
    public function getUsersTableData(Request $request)
    {

        $search = $request->search;

        if ($request->ajax()) {

            if ($search != '') {

                $datalist = DB::table('users')
                    ->join('user_roles', 'users.role_id', '=', 'user_roles.id')
                    ->join('user_status', 'users.status_id', '=', 'user_status.id')
                    ->select('users.id', 'users.name', 'users.email', 'users.phone', 'users.address', 'users.photo', 'user_roles.role', 'user_status.status', 'users.status_id')
                    ->where(function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%');
                    })
//					->whereNotIn('users.role_id', 1)
                    ->orderBy('users.name', 'asc')
                    ->paginate(20);
            } else {

                $datalist = DB::table('users')
                    ->join('user_roles', 'users.role_id', '=', 'user_roles.id')
                    ->join('user_status', 'users.status_id', '=', 'user_status.id')
                    ->select('users.id', 'users.name', 'users.email', 'users.phone', 'users.address', 'users.photo', 'user_roles.role', 'user_status.status', 'users.status_id')
//				->whereNotIn('users.role_id', 1)
                    ->orderBy('users.name', 'asc')
                    ->paginate(20);
            }

            return view('backend.partials.users_table', compact('datalist'))->render();
        }
    }

    //Save data for Users
    public function saveUsersData(Request $request)
    {
        $res = array();

        $id = $request->input('RecordId');
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $status_id = $request->input('status_id');
        $role_id = $request->input('role_id');
        $photo = $request->input('photo');

        $validator_array = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        );
        $rId = $id == '' ? '' : ',' . $id;
        $validator = Validator::make($validator_array, [
            'name' => 'required|max:191',
            'email' => 'required|max:191|unique:users,email' . $rId,
            'password' => 'required|max:191'
        ]);

        $errors = $validator->errors();

        if ($errors->has('name')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('name');
            return response()->json($res);
        }

        if ($errors->has('email')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('email');
            return response()->json($res);
        }

        if ($errors->has('password')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('password');
            return response()->json($res);
        }

        $data = array(
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'phone' => $phone,
            'address' => $address,
            'status_id' => $status_id,
            'role_id' => $role_id,
            'photo' => $photo,
            'bactive' => base64_encode($password)
        );

        if ($id == '') {
            $response = User::create($data);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('New Data Added Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data insert failed');
            }
        } else {
            $response = User::where('id', $id)->update($data);
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

    //Get data for User by id
    public function getUserById(Request $request)
    {

        $id = $request->id;

        $data = DB::table('users')->where('id', $id)->first();

        $data->bactive = base64_decode($data->bactive);

        return response()->json($data);
    }

    //Delete data for User
    public function deleteUser(Request $request)
    {

        $res = array();

        $id = $request->id;

        if ($id != '') {
            $response = User::where('id', $id)->first();
            if (count($response->news) == 0) {
                $response->delete();
                if ($response) {
                    $res['msgType'] = 'success';
                    $res['msg'] = __('Data Removed Successfully');
                } else {
                    $res['msgType'] = 'error';
                    $res['msg'] = __('Data remove failed');
                }
            } elseif ($response->id == Auth::id()) {
                $res['msgType'] = 'error';
                $res['msg'] = __('Không thể xoá');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('User không thể xoá');
            }
        }

        return response()->json($res);
    }

    //Bulk Action for Users
    public function bulkActionUsers(Request $request)
    {

        $res = array();

        $idsStr = $request->ids;
        $idsArray = explode(',', $idsStr);

        $BulkAction = $request->BulkAction;

        if ($BulkAction == 'active') {
            $response = User::whereIn('id', $idsArray)->update(['status_id' => 1]);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }

        } elseif ($BulkAction == 'inactive') {

            $response = User::whereIn('id', $idsArray)->update(['status_id' => 2]);
            if ($response) {
                $res['msgType'] = 'success';
                $res['msg'] = __('Data Updated Successfully');
            } else {
                $res['msgType'] = 'error';
                $res['msg'] = __('Data update failed');
            }

        } elseif ($BulkAction == 'delete') {
            $response = User::whereIn('id', $idsArray)->delete();
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

    //Profile page load
    public function getProfilePageLoad()
    {
        $media_datalist = Media_option::orderBy('id', 'desc')->paginate(28);

        return view('backend.profile', compact('media_datalist'));
    }

    //Save data for User Profile
    public function profileUpdate(Request $request)
    {
        $res = array();

        $id = $request->input('RecordId');
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $photo = $request->input('photo');

        $validator_array = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        );

        $rId = $id == '' ? '' : ',' . $id;
        $validator = Validator::make($validator_array, [
            'name' => 'required|max:191',
            'email' => 'required|max:191|unique:users,email' . $rId,
            'password' => 'required|max:191'
        ]);

        $errors = $validator->errors();

        if ($errors->has('name')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('name');
            return response()->json($res);
        }

        if ($errors->has('email')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('email');
            return response()->json($res);
        }

        if ($errors->has('password')) {
            $res['msgType'] = 'error';
            $res['msg'] = $errors->first('password');
            return response()->json($res);
        }

        $data = array(
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'phone' => $phone,
            'address' => $address,
            'photo' => $photo,
            'bactive' => base64_encode($password)
        );

        $response = User::where('id', $id)->update($data);
        if ($response) {
            $res['msgType'] = 'success';
            $res['msg'] = __('Data Updated Successfully');
        } else {
            $res['msgType'] = 'error';
            $res['msg'] = __('Data update failed');
        }

        return response()->json($res);
    }

    public function getNewsChartData( Request $request,$client = null)
    {
        $input = $request->all();
        $start_date = Carbon::parse($input['start_date'])->format('Y-m-d');
        $end_date = Carbon::parse($input['end_date'])->format('Y-m-d');

        $period = CarbonPeriod::create($start_date, $end_date);
        $dates = $period->toArray();

        $total_news = News::whereBetween('news.created_at', [$start_date, $end_date]) // Chỉ định rõ ràng cột 'created_at' thuộc về bảng 'news'
        ->select('user_id', 'users.name', DB::raw('DATE(news.created_at) as date'), DB::raw('COUNT(*) as total_news_user'))
            ->join('users', 'users.id', '=', 'news.user_id')
            ->groupBy('user_id', 'users.name', DB::raw('DATE(news.created_at)')) // Chỉ định rõ ràng cột 'created_at' thuộc về bảng 'news'
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy('name'); // Nhóm theo 'name' thay vì 'user_id'

        $labelsData = [];
        $incomeOverviewData = [];

        foreach ($dates as $date) {
            $formattedDate = $date->format('Y-m-d');
            $labelsData[] = $date->format('M d');

            foreach ($total_news as $name => $userNews) {
                $newsForDate = $userNews->firstWhere('date', $formattedDate);
                $newsCount = $newsForDate ? $newsForDate->total_news_user : 0;
                $incomeOverviewData[$name][] = $newsCount;
            }
        }

        $data['labels'] = $labelsData;
        $data['total_news'] = $incomeOverviewData;

        return $data;
    }

    //Users page load
    public function getUserNewsPageLoad( Request $request)
    {
        $input = $request->all();
        $start_date = isset($input['start_date']) ?  Carbon::parse($input['start_date'])->format('Y-m-d'): Carbon::now()->startOfMonth()->format('Y-m-d');
        $end_date =  isset($input['end_date']) ?  Carbon::parse($input['end_date'])->format('Y-m-d') : Carbon::now()->endOfMonth()->format('Y-m-d');


        $user = User::find($input['id']);
        $datalist =  $user->news()->whereBetween('news.created_at', [$start_date, $end_date])
            ->select(DB::raw('DATE(news.created_at) as date'), DB::raw('COUNT(*) as total_news_user'))
            ->groupBy('date') // Nhóm kết quả theo ngày (cột 'date')
            ->orderBy('date', 'asc') // Sắp xếp kết quả theo ngày tăng dần
            ->get();
        return view('backend.user_news', compact('user','datalist'));

    }

    //Get data for Users Pagination
    public function getUserNewsTableData(Request $request)
    {
        $input = $request->all();
        $start_date = isset($input['start_date']) ?  Carbon::parse($input['start_date'])->format('Y-m-d'): Carbon::now()->startOfMonth()->format('Y-m-d');
        $end_date =  isset($input['end_date']) ?  Carbon::parse($input['end_date'])->format('Y-m-d') : Carbon::now()->endOfMonth()->format('Y-m-d');
        $datalist = News::where('user_id', $input['user_id'])
            ->whereBetween('news.created_at', [$start_date, $end_date])
            ->select(DB::raw('DATE(news.created_at) as date'), DB::raw('COUNT(*) as total_news_user'))
            ->groupBy('date') // Nhóm kết quả theo ngày (cột 'date')
            ->orderBy('date', 'asc') // Sắp xếp kết quả theo ngày tăng dần
            ->get();
        return view('backend.partials.user_news_table', compact('datalist'))->render();
    }




    public function excelExportUserNews(Request $request){


        $use_id = $request->user_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;


        $user = User::find($use_id);

        $datalist = $user->news()->where('user_id', $use_id)
            ->whereBetween('news.created_at', [$start_date, $end_date])
            ->select(DB::raw('DATE(news.created_at) as date'), DB::raw('COUNT(*) as total_news_user'))
            ->groupBy('date') // Nhóm kết quả theo ngày (cột 'date')
            ->orderBy('date', 'asc') // Sắp xếp kết quả theo ngày tăng dần
            ->get();


        $spreadsheet = new Spreadsheet();

        //Page Setup
        //Page Orientation(ORIENTATION_LANDSCAPE/ORIENTATION_PORTRAIT),
        //Paper Size(PAPERSIZE_A3,PAPERSIZE_A4,PAPERSIZE_A5,PAPERSIZE_LETTER,PAPERSIZE_LEGAL etc)
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

        //Set Page Margins for a Worksheet
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.75);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.70);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.70);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.75);

        //Center a page horizontally/vertically
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        //Show/hide gridlines(true/false)
        $spreadsheet->getActiveSheet()->setShowGridlines(true);

        //Activate work sheet
        $spreadsheet->createSheet(0);
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet(0);
        //work sheet name
        $spreadsheet->getActiveSheet()->setTitle('Data');
        //Default Font Set
        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
        //Default Font Size Set
        $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

        //Border color
        $styleThinBlackBorderOutline = array('borders' => array('outline'=> array('borderStyle' => Border::BORDER_THIN, 'color' => array('argb' => '5a5a5a'))));
        $spreadsheet->getActiveSheet()->SetCellValue('A2', __($user->name));
        $spreadsheet->getActiveSheet()->getStyle('A2')->getFont();

        //Font Size for Cells
        $spreadsheet -> getActiveSheet()->getStyle('A2') -> applyFromArray(array('font' => array('size' => '14', 'bold' => true)), 'A2');

        //Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT)
        $spreadsheet -> getActiveSheet()->getStyle('A2') -> getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);

        //Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM)
        $spreadsheet -> getActiveSheet() -> getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //merge Cell
        $spreadsheet -> getActiveSheet() -> mergeCells('A2:L2');

        //Value Set for Cells
        $spreadsheet -> getActiveSheet()
            ->SetCellValue('A4', '#')
            ->SetCellValue('B4', __('Date'))
            ->SetCellValue('C4', __('Count'));

        //Font Size for Cells
        $spreadsheet -> getActiveSheet()->getStyle('A4') -> applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'A4');
        $spreadsheet -> getActiveSheet()->getStyle('B4') -> applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'B4');
        $spreadsheet -> getActiveSheet()->getStyle('C4') -> applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'C4');


        //Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT)
        $spreadsheet -> getActiveSheet()->getStyle('A4') -> getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet -> getActiveSheet()->getStyle('B4') -> getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $spreadsheet -> getActiveSheet()->getStyle('C4') -> getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);


        //Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM)
        $spreadsheet -> getActiveSheet() -> getStyle('A4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet -> getActiveSheet() -> getStyle('B4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet -> getActiveSheet() -> getStyle('C4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


        //Width for Cells
        $spreadsheet -> getActiveSheet() -> getColumnDimension('A') -> setWidth(5);
        $spreadsheet -> getActiveSheet() -> getColumnDimension('B') -> setWidth(20);
        $spreadsheet -> getActiveSheet() -> getColumnDimension('C') -> setWidth(20);


        //Wrap text
        $spreadsheet->getActiveSheet()->getStyle('A4')->getAlignment()->setWrapText(true);

        //*border color set for cells
        $spreadsheet -> getActiveSheet() -> getStyle('A4:A4') -> applyFromArray($styleThinBlackBorderOutline);
        $spreadsheet -> getActiveSheet() -> getStyle('B4:B4') -> applyFromArray($styleThinBlackBorderOutline);
        $spreadsheet -> getActiveSheet() -> getStyle('C4:C4') -> applyFromArray($styleThinBlackBorderOutline);

        $i=1;
        $j=5;
        foreach($datalist as $row){
             $date = $row->date;
            $count = $row->total_news_user;
            //Value Set for Cells
            $spreadsheet->getActiveSheet()
                ->SetCellValue('A'.$j, $i)
                ->SetCellValue('B'.$j, $date)
                ->SetCellValue('C'.$j, $count);

            //border color set for cells
            $spreadsheet -> getActiveSheet() -> getStyle('A' . $j . ':A' . $j) -> applyFromArray($styleThinBlackBorderOutline);
            $spreadsheet -> getActiveSheet() -> getStyle('B' . $j . ':B' . $j) -> applyFromArray($styleThinBlackBorderOutline);
            $spreadsheet -> getActiveSheet() -> getStyle('C' . $j . ':C' . $j) -> applyFromArray($styleThinBlackBorderOutline);


            //Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT)
            $spreadsheet -> getActiveSheet()->getStyle('A' . $j . ':A' . $j) -> getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $spreadsheet -> getActiveSheet()->getStyle('B' . $j . ':B' . $j) -> getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $spreadsheet -> getActiveSheet()->getStyle('C' . $j . ':C' . $j) -> getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);


            //Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM)
            $spreadsheet -> getActiveSheet() -> getStyle('A' . $j . ':A' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $spreadsheet -> getActiveSheet() -> getStyle('B' . $j . ':B' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $spreadsheet -> getActiveSheet() -> getStyle('C' . $j . ':C' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            //DateTime format Cell B
            $spreadsheet->getActiveSheet()->getStyle('B'.$j)->getNumberFormat()->setFormatCode('dd-mm-yyyy'); //Date Format

            $i++; $j++;
        }

        $exportTime = date("Y-m-d-His", time());
        $fileName = $user->name.'-news-' . $exportTime . '.xlsx';
        $filePath = 'export/' . $fileName;

        // Kiểm tra và tạo thư mục nếu nó không tồn tại
        if (!File::exists('export')) {
            File::makeDirectory('export', $mode = 0777, true, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return response()->json(['file' => $fileName]);
        // Trả về tập tin xuất bằng Response
        return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
    }
}
