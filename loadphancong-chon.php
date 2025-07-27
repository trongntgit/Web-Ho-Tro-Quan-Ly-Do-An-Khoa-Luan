<?php
session_start();
$server = "localhost";
$database = "doan2";
$user = "root";
$password = "";
$port = 3309;

$con = mysqli_connect($server, $user, $password, $database, $port);

if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

// Lấy dữ liệu từ bảng phancongkhoaluan với điều kiện
$query = "SELECT id, madetai FROM phancongkhoaluan WHERE ngaybaove IS NULL AND buoibaove = 0 and chon ='Chưa chọn'";
$result = mysqli_query($con, $query);

$options = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $options[] = $row;
    }
}

// Trả dữ liệu về frontend dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($options);

mysqli_close($con);
?>
