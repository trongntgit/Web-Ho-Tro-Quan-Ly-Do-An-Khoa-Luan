<?php
session_start();
$server = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($server, $user, $pass, $data, $port);

if (!$con) {
    die(json_encode(["success" => false, "error" => "Kết nối CSDL thất bại: " . mysqli_connect_error()]));
}

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['loai_tien_do']) && isset($data['ngay_nop']) && isset($data['madetai'])) {
    $loai_tien_do = mysqli_real_escape_string($con, $data['loai_tien_do']);
    $ngay_nop = mysqli_real_escape_string($con, $data['ngay_nop']);
    $madetai = mysqli_real_escape_string($con, $data['madetai']);

    $query = "INSERT INTO tiendo (loaitiendo, ngaynop, madetai) VALUES ('$loai_tien_do', '$ngay_nop', '$madetai')";

    if (mysqli_query($con, $query)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Lỗi khi lưu dữ liệu: " . mysqli_error($con)]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Dữ liệu không hợp lệ."]);
}

mysqli_close($con);
?>
