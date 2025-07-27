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
    // Kiểm tra xem dữ liệu đã được gửi chưa
    if (!isset($_POST['madetai']) || !isset($_POST['htmlContent'])) {
        throw new Exception("Thiếu dữ liệu cần thiết: madetai hoặc htmlContent");
    }

    $madetai = $_POST['madetai'];
    $htmlContent = $_POST['htmlContent']; // Lấy nội dung HTML đã được truyền

    // Mã hóa nội dung HTML trước khi lưu vào CSDL
    $encodedHtmlContent = base64_encode($htmlContent);

    // Tránh SQL Injection bằng cách dùng mysqli_real_escape_string
    $madetai = mysqli_real_escape_string($con, $madetai);
    $encodedHtmlContent = mysqli_real_escape_string($con, $encodedHtmlContent);

    // Kiểm tra nếu dữ liệu tồn tại trong CSDL rồi, nếu chưa thì INSERT, nếu có thì UPDATE
    $checkQuery = "SELECT * FROM giaodien WHERE id = '$madetai'";
    $checkResult = mysqli_query($con, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        // Dữ liệu đã tồn tại, thực hiện UPDATE
        $updateQuery = "UPDATE giaodien SET giaodien = '$encodedHtmlContent' WHERE id = '$madetai'";
        if (!mysqli_query($con, $updateQuery)) {
            throw new Exception("Cập nhật dữ liệu không thành công: " . mysqli_error($con));
        }
    } else {
        // Dữ liệu chưa tồn tại, thực hiện INSERT
        $insertQuery = "INSERT INTO giaodien (id, giaodien) VALUES ('$madetai', '$encodedHtmlContent')";
        if (!mysqli_query($con, $insertQuery)) {
            throw new Exception("Chèn dữ liệu không thành công: " . mysqli_error($con));
        }
    }

    $response['success'] = true;

} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

// Đảm bảo trả về JSON hợp lệ
echo json_encode($response);

// Đóng kết nối
mysqli_close($con);

?>
