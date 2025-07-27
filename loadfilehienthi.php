<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Thông tin kết nối cơ sở dữ liệu
$server = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($server, $user, $pass, $data, $port);

// Kiểm tra kết nối CSDL
if (!$con) {
    echo json_encode(['success' => false, 'error' => "Kết nối CSDL thất bại: " . mysqli_connect_error()]);
    exit;
}

// Thực hiện truy vấn để lấy dữ liệu
$query = "SELECT ten_phan, vi_tri_id, duong_dan_tep, ten_tep FROM tep_tai_len";
$result = mysqli_query($con, $query);

$fileData = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $fileData[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $fileData]);
} else {
    echo json_encode(['success' => false, 'error' => "Lỗi khi truy vấn dữ liệu: " . mysqli_error($con)]);
}

mysqli_close($con);
?>
