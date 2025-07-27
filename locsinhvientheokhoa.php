<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy giá trị khóa từ yêu cầu
$khoa = $_GET['khoa'] ?? 'all';

// Tạo câu lệnh SQL để lọc
$sql = "SELECT * FROM sinhvien";
if ($khoa !== 'all') {
    $sql .= " WHERE khoa = ?";
}

// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);

if ($khoa !== 'all') {
    $stmt->bind_param("s", $khoa);
}

$stmt->execute();
$result = $stmt->get_result();

// Tạo mảng kết quả
$sinhviens = [];
while ($row = $result->fetch_assoc()) {
    $sinhviens[] = $row;
}

// Trả về dữ liệu dạng JSON
header('Content-Type: application/json');
echo json_encode($sinhviens);

// Đóng kết nối
$conn->close();
