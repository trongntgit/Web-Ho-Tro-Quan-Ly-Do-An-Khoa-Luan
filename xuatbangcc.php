<?php
require './vendor/autoload.php'; // Assuming you have installed PhpSpreadsheet via Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Thông tin kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlnv";
$port = 3309;

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['mabcc'])) {
    // Lấy mã bảng chấm công
    $mabcc = $_POST['mabcc'];

    // Truy vấn lấy tên bảng chấm công
    $sql_tenbcc = "SELECT tenbcc FROM bangchamcong WHERE mabcc = '$mabcc'";
    $result_tenbcc = $conn->query($sql_tenbcc);
    $tenbcc = '';
    if ($result_tenbcc->num_rows > 0) {
        $row = $result_tenbcc->fetch_assoc();
        $tenbcc = $row['tenbcc'];
    }

    // Truy vấn dữ liệu để lấy thông tin ngày chấm công và trạng thái của mỗi nhân viên
    $sql = "
        SELECT manv, hoten, ngaycc, ttchamconng 
        FROM chamcong 
        WHERE ttchamconng IN ('Có', 'Vắng', 'Trễ') AND mabcc = '$mabcc'
        GROUP BY manv, hoten, ngaycc, ttchamconng
        ORDER BY ngaycc ASC
    ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Đặt tiêu đề cột cho file Excel
        $sheet->setCellValue('A1', 'Mã NV');
        $sheet->setCellValue('B1', 'Họ tên');

        // Tạo một mảng để lưu trữ các ngày chấm công khác nhau
        $dates = [];
        while ($data = $result->fetch_assoc()) {
            if (!in_array($data['ngaycc'], $dates)) {
                $dates[] = $data['ngaycc'];
            }
        }

        // Đặt tiêu đề cột theo từng ngày chấm công
        foreach ($dates as $key => $date) {
            $columnIndex = $key + 3; // Bắt đầu từ cột C (index = 3)
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
            $sheet->setCellValue($columnLetter . '1', $date);
        }

        // Truy vấn lại để đổ dữ liệu chấm công vào file Excel
        $result->data_seek(0); // Đưa con trỏ dữ liệu về đầu kết quả
        $employees = [];

        while ($data = $result->fetch_assoc()) {
            $manv = $data['manv'];
            $hoten = $data['hoten'];
            $ngaycc = $data['ngaycc'];
            $ttchamcong = $data['ttchamconng'];

            if (!isset($employees[$manv])) {
                $employees[$manv] = ['hoten' => $hoten, 'dates' => array_fill(0, count($dates), '')];
            }

            $dateIndex = array_search($ngaycc, $dates);
            $employees[$manv]['dates'][$dateIndex] = $ttchamcong;
        }

        // Đổ dữ liệu nhân viên và trạng thái chấm công vào file Excel
        $row = 2;
        foreach ($employees as $manv => $info) {
            $sheet->setCellValue('A' . $row, $manv);
            $sheet->setCellValue('B' . $row, $info['hoten']);
            foreach ($info['dates'] as $key => $ttchamcong) {
                $columnIndex = $key + 3; // Bắt đầu từ cột C (index = 3)
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
                $sheet->setCellValue($columnLetter . $row, $ttchamcong);
            }
            $row++;
        }

        // Đặt tên file theo mã bảng chấm công và tên bảng chấm công
        $filename = $mabcc . "_" . $tenbcc . ".xlsx";

        // Thiết lập header để xuất file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Xuất file Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    } else {
        echo "Không có dữ liệu để xuất.";
    }

    $conn->close();
}
?>
