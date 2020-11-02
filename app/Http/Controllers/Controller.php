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
        //print_r($excel_data);exit;
        foreach( $excel_data as $sheet_data){
                $this->createDataExcel($sheet_data);
        }
        

        return view('welcome', compact('excel_data'));
    }
    public function createDataExcel($sheet_data){
       //echo $sheet_data[2][7] ;exit;
        //print_r($sheet_data);exit;

        $dataExcel = [
    "namespace" => $sheet_data[2][7],
    "use_param" => [
      'Tests\TestCase',
        $sheet_data[2][7] . "\\". $sheet_data[3][7],
     
      'App\Lib\PwCommon\PwException',
      'Exception'
    ],
     //'App\Lib\PwCommon\Calculator',
    "class" => $sheet_data[3][7],
    "extends" => "TestCase",
    'function' => [
        $sheet_data[4][7] => [
            1 => [
                'param' => null,
                'param_class' => null,
                'param_literal' => null,
                'param_literal_val' => [14, 32],
                'return' => null,
                'return_literal' => null,
                'return_literal_val' => ['expected' => 0.8],
                'exception' => null,
                ]
        ]
    ],
];
            
            
            $case_st = false;

            foreach($sheet_data as $index_row => $columns){
                foreach($columns as $index_colum => $cell){
                    if($case_st == false && strpos($cell, "#case_st") !== false){
                        echo 'case_st position: ', $index_row,'-', $index_colum, "\n";
                        //print_r($columns); //exit; 
                        $case_st = true;
                    }
                    if($case_st && preg_match("/^[\d]+$/", $cell)){
                        echo 'value position: ', $index_row,'-', $index_colum, "\n";
                        echo $cell, "\n";
                    }
                    if($case_st  && strpos($cell, "#param_literal_val") !== false){
                        echo '#param_literal_val position: ', $index_row,'-', $index_colum, "\n";
                        echo $cell, "\n";
                        echo $sheet_data[$index_row][4], "\n";
                    }
                    if($case_st  && strpos($cell, "#return_literal_val") !== false){
                        echo '#return_literal_val position: ', $index_row,'-', $index_colum, "\n";
                        echo $cell, "\n";
                        echo $sheet_data[$index_row][4], "\n";
                    }
                    if($case_st  && strpos($cell, "#exception_class") !== false){
                        echo '#exception_class position: ', $index_row,'-', $index_colum, "\n";
                        echo $cell, "\n";
                        echo $sheet_data[$index_row][3], "\n";
                    }
                    if($case_st  && strpos($cell, "#exception_code") !== false){
                        echo '#exception_code position: ', $index_row,'-', $index_colum, "\n";
                        echo $cell, "\n";
                        echo $sheet_data[$index_row][4], "\n";
                    }
                    if(strpos($cell, "#case_ed") !== false){
                        echo 'case_ed position: ', $index_row,'-', $index_colum, "\n";
                        //print_r($columns); //exit; 
                        $case_st = false;

                        exit;
                    }
                }
            }

            print_r($dataExcel);exit;
            return $dataExcel;
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
