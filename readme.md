## [中文文档阅读](#)

## Description

[Laravel Excel](https://github.com/Maatwebsite/Laravel-Excel) brings the power of PHPOffice's PHPExcel to Laravel 5 with a touch of the Laravel Magic. It includes features like: importing Excel and CSV to collections, exporting models, array's and views to Excel, importing batches of files and importing a file by a config file.

This project is very simple demo to show you how to use the laravel excel package quickly.

> This project was created by [The EST Group](http://est-group.org/) and [PHPHub](https://phphub.org/).

Welcome to follow `LaravelTips` on wechat, this account will focus on the services to serve the laravel developers, we try to help those developers to learning the laravel framework better and faster.

![](http://ww4.sinaimg.cn/large/76dc7f1bjw1f23moqj4qzj20by0bywfa.jpg)

## Table of contents

1. Installation
2. Basic Usage
3. More Usage

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

## Basic Usage

### Decode Excel file

```php
# $excel_file_path = Your excel file path
$excel_data = Excel::load($excel_file_path, function($reader) {
    $excel_data = Excel::load($excel_file_path)->get()->toArray();

    echo 'job.xlsx contents is:';
    dd($excel_data);
});
```

### Simple Excel Export

```php
// Export Excel
Excel::create($export_file_name, function ($excel) {
    $excel->sheet('Sheetname', function ($sheet) {
        $sheet->appendRow(['data 1', 'data 2']);
        $sheet->appendRow(['data 3', 'data 4']);
        $sheet->appendRow(['data 5', 'data 6']);
    });
})->download('xls');

// Export Excel and save it to a specified folder
Excel::create($export_file_name, function ($excel) {
    $excel->sheet('Sheetname', function ($sheet) {
        $sheet->appendRow(['data 1', 'data 2']);
        $sheet->appendRow(['data 3', 'data 4']);
        $sheet->appendRow(['data 5', 'data 6']);
    });
})->store('xls', $object_path);
```

Then you can get something like this.

### More Usage

除了上述的解析/导出功能外, 此扩展包还支持:

1. Selecting sheets and columns;
2. Format Dates;
3. Calculate formulas;
4. Caching and Cell caching;
5. Chunk importer;
6. Converting;
7. @Blade to Excel

You can refer to the [documentation](http://www.maatwebsite.nl/laravel-excel/docs/getting-started) to learn more about this package.

---

欢迎关注 `LaravelTips`, 一个专注于为 Laravel 开发者服务, 致力于帮助开发者更好的掌握 Laravel 框架, 提升开发效率的微信公众号.

![](http://ww4.sinaimg.cn/large/76dc7f1bjw1f23moqj4qzj20by0bywfa.jpg)


