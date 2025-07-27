<?php
header("Content-Type: application/json");

// Thông tin kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Kết nối CSDL thất bại!"]);
    exit;
}

// Nhận dữ liệu từ yêu cầu
$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"];

// Thực hiện truy vấn xóa dữ liệu
$sql = "DELETE FROM news_events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Xóa thất bại!"]);
}

$stmt->close();
$conn->close();
