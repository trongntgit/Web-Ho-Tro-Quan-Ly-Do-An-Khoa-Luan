<?php
header('Content-Type: application/json');

// Kết nối cơ sở dữ liệu
$host = "localhost";
$user = "root";
$password = "";
$database = "doan2";
$port = 3309;

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error]);
    exit;
}

// Đặt mã hóa UTF-8
$conn->set_charset("utf8mb4");

// Lấy dữ liệu từ request
$data = json_decode(file_get_contents('php://input'), true);
$madetai = $data['madetai'] ?? '';

// Kiểm tra dữ liệu
if (empty($madetai)) {
    echo json_encode(['success' => false, 'message' => 'Mã đề tài không hợp lệ.']);
    exit;
}

// Xóa phân công theo mã đề tài
$sql = "DELETE FROM phancongdoan WHERE madetai = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $madetai);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Xóa phân công thành công.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa phân công.']);
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
