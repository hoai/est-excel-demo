<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Maatwebsite\Excel\Facades\Excel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function import() {
        //$file_path  = public_path().'/excel/CalclatorTest_VN.xlsx';
        $file_path  = public_path().'/excel/StringUtilsTest_VN.xlsx';
        
       // $excel_data = Excel::load($file_path)->get()->toArray();

        $excel_data = Excel::load($file_path, function($reader) {

            // Getting all results
            $results = $reader->get();

            // ->all() is a wrapper for ->get() and will work the same
            $results = $reader->all();

        })->get()->toArray();
        print_r($excel_data);exit;

        return view('welcome', compact('excel_data'));
    }

    public function export() {
        $file_name = time();
        Excel::create(time(), function ($excel) {
    $excel->sheet('Sheetname', function ($sheet) {
        $sheet->appendRow(['data 1', 'data 2']);
        $sheet->appendRow(['data 3', 'data 4']);
        $sheet->appendRow(['data 5', 'data 6']);
    });
})->download('xls');exit;
        Excel::create($file_name, function ($excel) {
            $excel->sheet('Sheetname', function ($sheet) {
                // 设置 excel 的 header
                $header_row = ['Name', 'age'];
                $sheet->appendRow($header_row);

                foreach ($this->create_temp_data() as $user) {
                    $sheet->appendRow([
                        $user['name'],
                        $user['age']
                    ]);
                }
            });
        })->download('xls');
    }

    public function create_temp_data() {
        $user_data = [];
        $user_data[] = ['name' => 'Li', 'age' => '15'];
        $user_data[] = ['name' => 'Wang', 'age' => '16'];
        $user_data[] = ['name' => 'Min', 'age' => '17'];
        $user_data[] = ['name' => 'Monkey', 'age' => '18'];
        $user_data[] = ['name' => 'Connie', 'age' => '19'];
        $user_data[] = ['name' => 'Apple', 'age' => '20'];

        return $user_data;
    }
}
