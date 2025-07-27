<?php
session_start();
require 'vendor/autoload.php'; // Gọi thư viện PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

$sever = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($sever, $user, $pass, $data, $port);

header('Content-Type: application/json'); // Đảm bảo phản hồi là JSON

if (!$con) {
    echo json_encode(['success' => false, 'errors' => ['Kết nối CSDL thất bại: ' . mysqli_connect_error()]]);
    exit();
}

$query_count = "SELECT COUNT(*) AS count FROM sinhvien";
$result_count = $con->query($query_count);
$row_count = $result_count->fetch_assoc();
$sinhvien_count = $row_count['count'];

$new_sv_code = "sv" . ($sinhvien_count + 1);

if ($_FILES['excelFileSV']['error'] == UPLOAD_ERR_OK) {
    $file = $_FILES['excelFileSV']['tmp_name'];

    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    $errors = [];
    $success_list = [];

    foreach ($rows as $index => $row) {
        if ($index == 0) continue;

        $hoten = $con->real_escape_string($row[0]); // Họ tên
        $lop = $row[1];                            // Lớp
        $khoa = $row[2];                           // Khoa (thêm dòng này)
        $diem = $row[3];                           // Điểm
        $email = $row[4];                          // Email
        $sdt = $row[5];                            // Số điện thoại
        $diachi = $row[6];                         // Địa chỉ

        $query_insert = "INSERT INTO sinhvien (ma, hoten, lop, khoa, diemtichluy, email, sdt, diachi) 
                         VALUES ('$new_sv_code', '$hoten', '$lop', '$khoa', '$diem', '$email', '$sdt', '$diachi')";

        if ($con->query($query_insert)) {
            // Tạo tài khoản cho sinh viên
            $tentk = $new_sv_code;
            $matkhau = "1234";
            $quyen = "sinhvien";

            $query_account = "INSERT INTO taikhoan2 (tentk, mk, quyen, masv) 
                              VALUES ('$tentk', '$matkhau', '$quyen', '$new_sv_code')";

            if ($con->query($query_account)) {
                $success_list[] = "Sinh viên '$hoten' và tài khoản thêm thành công!";
            } else {
                $errors[] = "Thêm tài khoản thất bại cho sinh viên '$hoten': " . $con->error;
            }

            // Cập nhật mã sinh viên mới cho lần tiếp theo
            $sinhvien_count++;
            $new_sv_code = "sv" . ($sinhvien_count + 1);
        } else {
            $errors[] = "Thêm sinh viên thất bại tại dòng $index: $hoten (" . $con->error . ")";
        }
    }

    echo json_encode([
        'success' => empty($errors),
        'message' => $success_list,
        'errors' => $errors,
    ]);

    $con->close();
    exit();
} else {
    echo json_encode(['success' => false, 'errors' => ['Tải file thất bại.']]);
    exit();
}
?>
