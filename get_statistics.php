<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$server = "localhost";
$data = "qlnv";
$user = "root";
$pass = "";
$port = 3309;

$conn = mysqli_connect($server, $user, $pass, $data, $port);
if (!$conn) {
    echo json_encode(["error" => "Kết nối CSDL thất bại: " . mysqli_connect_error()]);
    exit();
}

// Truy vấn tổng số ngày làm việc của từng nhân viên
$sql = "SELECT hoten, SUM(songaylam) as tong_ngay_lam FROM bangluong GROUP BY hoten";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => "Lỗi SQL: " . $conn->error]);
    $conn->close();
    exit();
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>
