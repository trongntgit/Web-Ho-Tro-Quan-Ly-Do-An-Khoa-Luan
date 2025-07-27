<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Kết nối cơ sở dữ liệu thất bại"]);
    exit;
}

require 'vendor/autoload.php'; // Đảm bảo bạn đã cài PHPSpreadsheet qua Composer.

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Truy vấn dữ liệu giảng viên
$query = "SELECT * FROM quantri";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Đặt tiêu đề cột
    $sheet->setCellValue('A1', 'Mã Quản Trị')
        ->setCellValue('B1', 'Họ Tên')
        ->setCellValue('E1', 'Email')
        ->setCellValue('F1', 'SĐT')
        ->setCellValue('G1', 'Địa Chỉ');

    // Thêm dữ liệu
    $rowNumber = 2;
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue("A$rowNumber", $row['ma'])
            ->setCellValue("B$rowNumber", $row['hoten'])
            ->setCellValue("E$rowNumber", $row['email'])
            ->setCellValue("F$rowNumber", $row['sdt'])
            ->setCellValue("G$rowNumber", $row['diachi']);
        $rowNumber++;
    }

    // Lưu file vào thư mục tạm thời
    $filename = 'Danh_sach_quan_tri_' . time() . '.xlsx';
    $writer = new Xlsx($spreadsheet);
    $filePath = 'temp/' . $filename;

    if (!is_dir('temp')) {
        mkdir('temp', 0777, true);
    }

    $writer->save($filePath);

    echo json_encode(["success" => true, "file" => $filePath]);
} else {
    echo json_encode(["success" => false, "message" => "Không có dữ liệu quản trị để xuất"]);
}
?>
