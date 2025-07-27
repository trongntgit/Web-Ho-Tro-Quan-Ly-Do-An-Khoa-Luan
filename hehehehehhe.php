<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Khởi tạo một đối tượng Spreadsheet mới
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World!');

// Ghi tệp Excel mới
$writer = new Xlsx($spreadsheet);
$writer->save('hello_world.xlsx');
echo "Tạo tệp Excel thành công!";
?>