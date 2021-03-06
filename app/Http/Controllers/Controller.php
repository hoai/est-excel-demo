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
        $dataExcel = [];
        foreach( $excel_data as $sheet_data){
               $dataExcel =  array_merge($dataExcel, $this->createDataExcel($sheet_data, $dataExcel));
               // $dataExcel =  $this->createDataExcel($sheet_data);
                // print_r($dataExcel);
        }

        print_r($dataExcel); exit;
        

        return view('welcome', compact('excel_data'));
    }
    public function createDataExcel($sheet_data , $dataExcel){
       ////echo $sheet_data[2][7] ;exit;
        //print_r($sheet_data);exit;
        //check exist cell #namespace
       // print_r();
        $namespace_cell =  $sheet_data[2][0];
        if($namespace_cell !=  '#namespace'){
            return [];
        }
        $static = $sheet_data[5][7];
        $function_name = $sheet_data[4][7];
        $path_class =  $sheet_data[2][7] ;
        $main_class = $sheet_data[3][7];

      
        if(empty($dataExcel) ){

            $dataExcel = [
                "namespace" => $sheet_data[2][7],
                "use_param" => [
                  'Tests\TestCase',
                   $path_class . "\\". $main_class,
     
                  //'App\Lib\PwCommon\PwException',
                  'Exception'
                ],
                 //'App\Lib\PwCommon\Calculator',
                "class" => $sheet_data[3][7],
                "extends" => "TestCase"
            ];
            
        }
        else{
            if(!in_array($path_class . "\\". $main_class, $dataExcel["use_param"])){
                $dataExcel['use_param'] =  $path_class . "\\". $main_class;

            }

        }
        
            
            
            $case_st = false;

            $list_case_all = [];
            $position_case_all = [];
            $list_return_all = [] ;
            $list_exception_class_all = [] ;
            $list_exception_code_all = [] ;

            foreach($sheet_data as $index_row => $columns){
                foreach($columns as $index_colum => $cell){
                    if($case_st == false && strpos($cell, "#case_st") !== false){
                        //echo 'case_st position: ', $index_row,'-', $index_colum, "\n";
                        //print_r($columns); //exit; 
                        $case_st = true;

                        $list_case = [];
                        $position_case = [];
                        $list_return = [] ;
                        $list_exception_class = [] ;
                        $list_exception_code = [] ;

                    }
                    if($case_st && preg_match("/^[\d]+$/", $cell)){
                        //echo 'value position: ', $index_row,'-', $index_colum, "\n";
                        //echo $cell, "\n";
                        if(!isset($position_case[$cell]) && $cell > 0){
                            $position_case[$cell] = $index_colum;
                        }
                    }
                    if($case_st  && strpos($cell, "#param_literal_val") !== false){
                       

                        //echo '#param_literal_val position: ', $index_row,'-', $index_colum, "\n";
                        //echo $cell, "\n";
                        //echo $sheet_data[$index_row][4], "\n";
                        $param_name = $sheet_data[$index_row][4];
                        foreach($position_case as $index_case => $index_colum_case){
                            $list_case[$index_case][$param_name] =  $sheet_data[$index_row][$index_colum_case];
                        }
                      
                    }
                    if($case_st  && strpos($cell, "#return_literal_val") !== false){
                        //echo '#return_literal_val position: ', $index_row,'-', $index_colum, "\n";
                        //echo $cell, "\n";
                        //echo $sheet_data[$index_row][4], "\n";
                        $return_literal_name = $sheet_data[$index_row][4];
                        foreach($position_case as $index_case => $index_colum_case){
                            $list_return[$index_case][$return_literal_name] =  $sheet_data[$index_row][$index_colum_case];
                        }
                         
                    }
                    if($case_st  && strpos($cell, "#exception_class") !== false){
                        //echo '#exception_class position: ', $index_row,'-', $index_colum, "\n";
                        //echo $cell, "\n";
                        //echo $sheet_data[$index_row][3], "\n";

                        $exception_class_name = $sheet_data[$index_row][3];

                        if(!empty($exception_class_name)){
                            if(!in_array($path_class . "\\". $exception_class_name, $dataExcel['use_param'])){
                                $dataExcel['use_param'][] = $path_class . "\\". $exception_class_name;
                            }
                         

                            //print_r($position_case);exit;
                            foreach($position_case as $index_case => $index_colum_case){
                                $list_exception_class[$index_case][$exception_class_name] =  $sheet_data[$index_row][$index_colum_case];
                            }
                          //print_r($list_exception_class);exit;
                        }
                    }
                    if($case_st  && strpos($cell, "#exception_code") !== false){
                        //echo '#exception_code position: ', $index_row,'-', $index_colum, "\n";
                        //echo $cell, "\n";
                        //echo $sheet_data[$index_row][4], "\n";

                         $exception_code_name = $sheet_data[$index_row][4];

                        // print_r($position_case);exit;

                        foreach($position_case as $index_case => $index_colum_case){
                            $list_exception_code[$index_case][$exception_code_name] =  $sheet_data[$index_row][$index_colum_case];
                        }
                        //print_r($list_exception_code);exit;
                        

                    }
                    if($case_st  && strpos($cell, "#case_ed") !== false){
                        //echo 'case_ed position: ', $index_row,'-', $index_colum, "\n";
                        //print_r($columns); //exit; 
                        $case_st = false;

                        $list_case_all = array_merge($list_case_all, array_values($list_case));
                        $position_case_all = array_merge($position_case_all, array_values($position_case));
                        $list_return_all = array_merge($list_return_all, array_values($list_return) );
                        $list_exception_class_all = array_merge($list_exception_class_all, array_values($list_exception_class) );
                        $list_exception_code_all = array_merge($list_exception_code_all, array_values($list_exception_code) );

                        //print_r($list_case);
                       //print_r($list_return);
                        
                       //exit;

                        //exit;
                    }
                }
            }

            /*print_r($list_case_all);
            print_r($list_return_all);
            print_r($list_exception_class_all);
            print_r($list_exception_code_all);
            exit;*/
            foreach ($list_case_all as $index_case => $param_value){
                        $dataExcel['function'][$function_name][$index_case + 1] =
                            [
                                'param' => null,
                                'param_class' => null,
                                'param_literal' => null,
                                'param_literal_val' => $param_value,
                                'return' => null,
                                'return_literal' => null,
                                'return_literal_val' => isset($list_return_all[$index_case]) ? $list_return_all[$index_case] : null,
                                'exception_class' => isset($list_exception_class_all[$index_case]) ? $list_exception_class_all[$index_case] : null,
                                'exception_code' => isset( $list_exception_code_all[$index_case] ) ?  $list_exception_code_all[$index_case]  : null,
                            ];
            }
            //print_r($dataExcel);exit;

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
