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

    /*
     *  解析 Excel
     */
    public function import() {
        $file_name = public_path().'/excel/job.xlsx';
        $excel_data = Excel::load($file_name)->get()->toArray();
    }

    /*
     *  将数据导出成 Excel
     */
    public function export() {
        $file_name = time();
        Excel::create($file_name, function ($excel) {
            $excel->sheet('Sheetname', function ($sheet) {
                // 设置 excel 的 header
                $header_row = ['姓名', '年龄'];
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
        $user_data[] = ['name' => '张三', 'age' => '15'];
        $user_data[] = ['name' => '李四', 'age' => '16'];
        $user_data[] = ['name' => '王五', 'age' => '17'];
        $user_data[] = ['name' => '小明', 'age' => '18'];
        $user_data[] = ['name' => '小红', 'age' => '19'];
        $user_data[] = ['name' => '小军', 'age' => '20'];

        return $user_data;
    }
}
