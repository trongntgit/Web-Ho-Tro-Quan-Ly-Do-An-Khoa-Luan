<?php
session_start();
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

header('Content-Type: application/json');

$server = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($server, $user, $pass, $data, $port);

if (!$con) {
    echo json_encode(['success' => false, 'errors' => ['Kết nối CSDL thất bại: ' . mysqli_connect_error()]]);
    exit();
}

// Tạo mã quản trị mới
$query_count = "SELECT COUNT(*) AS count FROM quantri";
$result_count = $con->query($query_count);
$row_count = $result_count->fetch_assoc();
$quantri_count = $row_count['count'];

$new_qt_code = "qt" . ($quantri_count + 1);

if ($_FILES['excelFileQT']['error'] == UPLOAD_ERR_OK) {
    $file = $_FILES['excelFileQT']['tmp_name'];

    try {
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $errors = [];
        $success_list = [];

        foreach ($rows as $index => $row) {
            if ($index == 0) continue;

            $hoten = $con->real_escape_string($row[0]);
            $email = $row[1];
            $sdt = $row[2];
            $diachi = $row[3];

            $query_insert = "INSERT INTO quantri (ma, hoten, email, sdt, diachi) 
                             VALUES ('$new_qt_code', '$hoten','$email', '$sdt', '$diachi')";

            if ($con->query($query_insert)) {
                // Tạo tài khoản cho quản trị
                $tentk = $new_qt_code;
                $matkhau = "1234";
                $quyen = "quantri";

                $query_account = "INSERT INTO taikhoan2 (tentk, mk, quyen, maqt) 
                                  VALUES ('$tentk', '$matkhau', '$quyen', '$new_qt_code')";

                if ($con->query($query_account)) {
                    $success_list[] = "Quản trị '$hoten' và tài khoản thêm thành công!";
                } else {
                    $errors[] = "Thêm tài khoản thất bại cho quản trị '$hoten': " . $con->error;
                }

                // Cập nhật mã quản trị mới cho lần tiếp theo
                $quantri_count++;
                $new_qt_code = "qt" . ($quantri_count + 1);
            } else {
                $errors[] = "Thêm quản trị thất bại tại dòng $index: $hoten (" . $con->error . ")";
            }
        }

        echo json_encode([
            'success' => empty($errors),
            'message' => $success_list,
            'errors' => $errors,
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'errors' => ['Lỗi xử lý file: ' . $e->getMessage()]]);
    }
} else {
    echo json_encode(['success' => false, 'errors' => ['Tải file thất bại.']]);
}

$con->close();
exit();
?>
