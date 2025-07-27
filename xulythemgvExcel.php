<?php
session_start();
require 'vendor/autoload.php'; // Gọi thư viện PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

// Kết nối cơ sở dữ liệu
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

// Đếm số giảng viên hiện tại trong cơ sở dữ liệu để tạo mã giảng viên tự động
$query_count = "SELECT COUNT(*) AS count FROM giangvien";
$result_count = $con->query($query_count);
$row_count = $result_count->fetch_assoc();
$giangvien_count = $row_count['count'];

// Tạo mã giảng viên mới (gvX, X là số thứ tự)
$new_gv_code = "gv" . ($giangvien_count + 1);

if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
    $file = $_FILES['excelFile']['tmp_name'];

    // Đọc file Excel
    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    $errors = [];
    $success_list = [];

    // Duyệt qua từng dòng trong file Excel
    foreach ($rows as $index => $row) {
        if ($index == 0) continue; // Bỏ qua dòng tiêu đề

        $hoten = $con->real_escape_string($row[0]); // Họ tên
        $trinhdo = $row[1]; // Trình độ
        $chucvu = $row[2]; // Chức vụ
        $chuyenmon =$row[3];
        $email = $row[4]; // Email
        $sdt = $row[5]; // SĐT
        $diachi = $row[6]; // Địa chỉ
       


        // Thêm giảng viên vào cơ sở dữ liệu
        $query_insert = "INSERT INTO giangvien (ma, hoten, trinhdo, chucvu, email, sdt, diachi, chuyenmon) 
                         VALUES ('$new_gv_code', '$hoten', '$trinhdo', '$chucvu', '$email', '$sdt', '$diachi','$chuyenmon')";

        if ($con->query($query_insert)) {
            // Xác định quyền dựa trên chức vụ
            $quyen = '';
            if ($chucvu == 'Giảng viên' || $chucvu == 'Trưởng bộ môn' || $chucvu == 'Trợ giảng' ) {
                $quyen = 'giangvien';
            } else if ($chucvu == 'Giáo vụ') {
                $quyen = 'giaovu';
            } else if ($chucvu == 'Trưởng khoa') {
                $quyen = 'lanhdao';
            } 

            // Thêm tài khoản vào bảng taikhoan2
            $tentk = $new_gv_code;
            $matkhau = "1234";
            $query_taikhoan = "INSERT INTO taikhoan2 (tentk, mk, quyen, magv) 
                               VALUES ('$tentk', '$matkhau', '$quyen', '$new_gv_code')";

            if ($con->query($query_taikhoan)) {
                $success_list[] = "Giảng viên '$hoten' và tài khoản được thêm thành công!";
            } else {
                $errors[] = "Thêm tài khoản thất bại cho '$hoten': " . $con->error;
            }

            // Cập nhật mã giảng viên mới cho lần tiếp theo
            $giangvien_count++;
            $new_gv_code = "gv" . ($giangvien_count + 1);
        } else {
            $errors[] = "Thêm giảng viên thất bại tại dòng $index: $hoten (" . $con->error . ")";
        }
    }

    // Phản hồi về trạng thái thêm giảng viên và tài khoản
    echo json_encode([
        'success' => empty($errors),
        'message' => $success_list,
        'errors' => $errors,
    ]);

    $con->close();
} else {
    echo json_encode(['success' => false, 'errors' => ['Tải file thất bại.']]);
}
?>
