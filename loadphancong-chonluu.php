<?php
session_start();
$server = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($server, $user, $pass, $data, $port);

if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

// Lấy mã đề tài từ yêu cầu GET
$madetai = $_GET['madetai'];

// Truy vấn để lấy thông tin từ bảng `phancongkhoaluan` và `detai`
$query = "
    SELECT 
        p.madetai,
        d.tendetai, -- Lấy tên đề tài từ bảng detai
        dk.masv,
        s.hoten AS tensinhvien,
        s.lop,
        g1.hoten AS gvthuky,
        g2.hoten AS gvphanbien,
        g3.hoten AS chutich,
        p.chon
    FROM phancongkhoaluan p
    LEFT JOIN detai d ON p.madetai = d.madetai -- Tham chiếu bảng detai để lấy tên đề tài
    LEFT JOIN dangkydetai dk ON p.madetai = dk.madetai
    LEFT JOIN sinhvien s ON dk.masv = s.ma
    LEFT JOIN giangvien g1 ON p.gvthuky = g1.ma
    LEFT JOIN giangvien g2 ON p.gvphanbien = g2.ma
    LEFT JOIN giangvien g3 ON p.chutich = g3.ma
    WHERE p.id = '$madetai'
";

$result = mysqli_query($con, $query);

// Kiểm tra nếu có dữ liệu
if ($result && mysqli_num_rows($result) > 0) {
    $students = [];
    $commonData = null;
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = [
            "masv" => $row['masv'],
            "tensinhvien" => $row['tensinhvien'],
            "lop" => $row['lop']
        ];
        // Lưu thông tin chung
        $commonData = [
            "madetai" => $row['madetai'],
            "tendetai" => $row['tendetai'], // Thêm tên đề tài
            "gvthuky" => $row['gvthuky'],
            "gvphanbien" => $row['gvphanbien'],
            "chutich" => $row['chutich'],
            "chon" => $row['chon']
        ];
    }

    // Cập nhật cột `chon` thành "Chọn"
    $updateQuery = "UPDATE phancongkhoaluan SET chon = 'Chọn' WHERE id = '$madetai'";
    mysqli_query($con, $updateQuery);

    // Trả về danh sách sinh viên cùng thông tin chung
    echo json_encode([
        "students" => $students,
        "commonData" => $commonData
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Không tìm thấy dữ liệu với mã đề tài này."
    ]);
}

// Đóng kết nối
mysqli_close($con);
?>
