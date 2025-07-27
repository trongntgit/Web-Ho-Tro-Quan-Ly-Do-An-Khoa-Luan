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

if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
    $file = $_FILES['excelFile']['tmp_name'];

    // Đọc file Excel
    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    $errors = [];
    $success_list = [];
    $fail_list = [];
    foreach ($rows as $index => $row) {
        if ($index == 0) continue; // Bỏ qua dòng tiêu đề

        $tendetai = $con->real_escape_string($row[0]); // Tên đề tài
        $loaidetai = $row[1]; // Loại đề tài
        $linhvuc = $row[2]; // Lĩnh vực
        $thoigianbatdau = date('Y-m-d', strtotime($row[3]));
        $thoigianhoanthanh = date('Y-m-d', strtotime($row[4]));
        $soluongmax = intval($row[5]);
        $hocky = explode('-', $row[6]); // (1,2024,2025)
        $mota = $con->real_escape_string($row[7]);

        // Tìm mã học kỳ trong DB
        $query_hocky = "SELECT ma FROM hocky WHERE hoky = $hocky[0] AND nambd = $hocky[1] AND namkt = $hocky[2]";
        $result_hocky = $con->query($query_hocky);
        if ($result_hocky->num_rows > 0) {
            $row_hocky = $result_hocky->fetch_assoc();
            $mahocky = $row_hocky['ma'];
        } else {
            $fail_list[] = "Không tìm thấy học kỳ cho dòng $index: $tendetai";
            continue;
        }

        // Tạo mã đề tài tự động
        $query_count = "SELECT COUNT(*) as count FROM detai";
        $result_count = $con->query($query_count);
        $row_count = $result_count->fetch_assoc();
        $madetai_number = $row_count['count'] + 1;

        $nambd = $hocky[1];
        $namhoc = substr($nambd, -2); // Lấy 2 chữ số cuối của năm bắt đầu
        $hoky = $hocky[0];
        
        // Chuyển đổi loại đề tài thành mã viết tắt
        $ma_loai_de_tai = "";
        switch ($loaidetai) {
            case "Khóa luận":
                $ma_loai_de_tai = "KL";
                break;
            case "Đồ án 1":
                $ma_loai_de_tai = "DA1";
                break;
            case "Đồ án 2":
                $ma_loai_de_tai = "DA2";
                break;
        }

        $madetai = $namhoc . $hoky . $ma_loai_de_tai . sprintf("%02d", $madetai_number);
        $manguoitao = $_SESSION['userid']; // Mã người tạo từ session
        $tengv = "";

        // Lấy tengv từ bảng giangvien dựa trên manguoitao
        $query_get_tengv = "SELECT hoten FROM giangvien WHERE ma = '$manguoitao'";
        $result = mysqli_query($con, $query_get_tengv);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $tengv = $row['hoten']; // Đảm bảo lấy đúng trường hoten từ bảng giangvien
        }

        // Kiểm tra xem tengv có hợp lệ không
        if (empty($tengv)) {
            $fail_list[] = "Không tìm thấy giảng viên với mã người tạo '$manguoitao' tại dòng $index.";
            continue;
        }

        // Thêm dữ liệu vào bảng detai
        $query_insert = "INSERT INTO detai (madetai, tendetai, mota, soluongmax, thoigianhoanthanh, thoigianbatdau, loaidetai, mahocky, trangthai, manguoitao, linhvuc, soluongdk, tengv) 
                         VALUES ('$madetai', '$tendetai', '$mota', $soluongmax, '$thoigianhoanthanh', '$thoigianbatdau', '$loaidetai', $mahocky, 'Chờ đăng ký', '$manguoitao', '$linhvuc', 0, '$tengv')";
        
        if ($con->query($query_insert)) {
            $success_list[] = "Đề tài '$tendetai' thêm thành công!";

            // Thêm thông báo vào bảng thongbao
            $noidung = "Bạn đã thêm đề tài thành công: $tendetai (Mã Đề Tài: $madetai)";
            $query_thongbao = "INSERT INTO thongbao (noidung, manguoinhan) VALUES ('$noidung', '$manguoitao')";
            $con->query($query_thongbao); // Thực hiện thêm vào bảng thongbao
        } else {
            $fail_list[] = "Thêm dữ liệu thất bại tại dòng $index: $tendetai (" . $con->error . ")";
        }
    }

    // Lưu thông báo vào session
    if (!empty($success_list)) {
        $_SESSION['excel-tc'] = 'thanhcong';
        $_SESSION['exceltc-mes'] = $success_list;
    }

    if (!empty($fail_list)) {
        $_SESSION['excel-tb'] = 'thatbai';
        $_SESSION['exceltb-mes'] = $fail_list;
    }

    // Phản hồi về trạng thái thêm dữ liệu
    if (empty($fail_list)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'errors' => $fail_list]);
    }

    $con->close();
} else {
    echo json_encode(['success' => false, 'errors' => ['Tải file thất bại.']]);
}
?>
