<?php
require './vendor/autoload.php'; // Assuming you have installed PhpSpreadsheet via Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlnv";
$port = 3309;

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$mabcc = $_GET['mabcc']; // mabcc from request

// Fetch the latest records for the specified mabcc
$sql = "
    SELECT *
    FROM bangluong
    WHERE mabcc = '$mabcc'
      AND (manv, mabl) IN (
          SELECT manv, MAX(mabl)
          FROM bangluong
          WHERE mabcc = '$mabcc'
          GROUP BY manv
      )
    ORDER BY manv ASC
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set column names
    $sheet
        ->setCellValue('A1', 'Mã nhân viên')
        ->setCellValue('B1', 'Họ và tên')
        ->setCellValue('C1', 'Mã bảng chấm công')
        ->setCellValue('D1', 'Số ngày làm')
        ->setCellValue('E1', 'Số ngày nghỉ')
        ->setCellValue('F1', 'Số ngày đi trễ')
        ->setCellValue('G1', 'Tổng lương');
    
    $rowNumber = 2;
    while ($row = $result->fetch_assoc()) {
        $sheet
            ->setCellValue('A' . $rowNumber, $row['manv'])
            ->setCellValue('B' . $rowNumber, $row['hoten'])
            ->setCellValue('C' . $rowNumber, $row['mabcc'])
            ->setCellValue('D' . $rowNumber, $row['songaylam'])
            ->setCellValue('E' . $rowNumber, $row['songaynghi'])
            ->setCellValue('F' . $rowNumber, $row['songayditre'])
            ->setCellValue('G' . $rowNumber, $row['tongluong']);
        $rowNumber++;
    }

    // Set filename from GET parameter, defaulting to 'output.xlsx'
    $fileName = isset($_GET['filename']) ? $_GET['filename'] . '.xlsx' : 'output.xlsx';

    // Output to browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output'); // Save file to output stream

    exit; // Ensure the script stops after the file is sent

} else {
    echo "No data found";
}

$conn->close();
?>
