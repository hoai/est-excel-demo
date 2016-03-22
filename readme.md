## [中文文档阅读](#)

## Description

[Laravel Excel](https://github.com/Maatwebsite/Laravel-Excel) brings the power of PHPOffice's PHPExcel to Laravel 5 with a touch of the Laravel Magic. It includes features like: importing Excel and CSV to collections, exporting models, array's and views to Excel, importing batches of files and importing a file by a config file.

This project is very simple demo to show you how to use the laravel excel package quickly.

> This project was created by [The EST Group](http://est-group.org/) and [PHPHub](https://phphub.org/).

Welcome to follow `LaravelTips` on wechat, this account will focus on the services to serve the laravel developers, we try to help those developers to learning the laravel framework better and faster.

![](http://ww4.sinaimg.cn/large/76dc7f1bjw1f23moqj4qzj20by0bywfa.jpg)

## Installation

Require this package in your composer.json and update composer. This will download the package and PHPExcel of PHPOffice.

```shell
"maatwebsite/excel": "~2.1.0"
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`

```php
'providers' => [
    ...
    Maatwebsite\Excel\ExcelServiceProvider::class,
],
```

You can use the facade for shorter code. Add this to your aliases:

```php
'aliases' => [
    ...
    'Excel' => Maatwebsite\Excel\Facades\Excel::class,
]
```

To publish the config settings in Laravel 5 use:

```shell
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
```

This will add an `excel.php` config file to your config folder.

## Usage

### Decode Excel file

```php
$excel_data = Excel::load($excel_file_path, function($reader) {
    $reader = $reader->getSheet(0);

    // print job.xlsx file content
    echo 'job.xlsx 表格内容为:';
    dd($reader->toArray());
});
```

### Simple Excel Export

```php
// Export Excel
Excel::create($export_file_name, function ($excel) {
    $excel->sheet('Sheetname', function ($sheet) {
        $sheet->appendRow(['数据 1', '数据 2']);
        $sheet->appendRow(['数据 3', '数据 4']);
        $sheet->appendRow(['数据 5', '数据 6']);
    });
})->download('xls');

// Export Excel and save it to a specified folder
Excel::create($export_file_name, function ($excel) {
    $excel->sheet('Sheetname', function ($sheet) {
        $sheet->appendRow(['数据 1', '数据 2']);
        $sheet->appendRow(['数据 3', '数据 4']);
        $sheet->appendRow(['数据 5', '数据 6']);
    });
})->store('xls', $object_path);
```

Then you can get something like this.

### More usage

You can refer to the [documentation](http://www.maatwebsite.nl/laravel-excel/docs) to learn more about the laravel excel.