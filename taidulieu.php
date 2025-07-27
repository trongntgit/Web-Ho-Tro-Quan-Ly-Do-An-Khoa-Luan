<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Kết nối đến cơ sở dữ liệu
$server = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;

$con = mysqli_connect($server, $user, $pass, $data, $port);

if (!$con) {
    die(json_encode(['success' => false, 'error' => "Kết nối CSDL thất bại: " . mysqli_connect_error()])); 
}

$response = ['success' => false];

try {
    // Kiểm tra xem mã đề tài có được truyền vào không
    if (!isset($_GET['madetai'])) {
        throw new Exception("Thiếu mã đề tài");
    }

    $madetai = $_GET['madetai'];

    // Tránh SQL Injection
    $madetai = mysqli_real_escape_string($con, $madetai);

    // Lấy dữ liệu từ bảng giaodien dựa trên mã đề tài
    $query = "SELECT giaodien FROM giaodien WHERE id = '$madetai'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        throw new Exception("Lỗi khi truy vấn dữ liệu: " . mysqli_error($con));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $decodedHtmlContent = base64_decode($row['giaodien']); // Giải mã nội dung HTML đã lưu
        $response['success'] = true;
        $response['data'] = $decodedHtmlContent;
    } else {
        throw new Exception("Không tìm thấy dữ liệu cho mã đề tài: $madetai");
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

// Trả về JSON
echo json_encode($response);

// Đóng kết nối
mysqli_close($con);

?>
