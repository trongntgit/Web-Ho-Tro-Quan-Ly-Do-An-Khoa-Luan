<?php
// Đặt tiêu đề là JSON
header('Content-Type: application/json');

// Kết nối cơ sở dữ liệu
$host = "localhost";
$user = "root";
$password = "";
$database = "doan2";
$port = 3309;

$conn = new mysqli($host, $user, $password, $database, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error]);
    exit;
}

// Nhận dữ liệu từ yêu cầu POST (dữ liệu dạng JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra nếu dữ liệu không tồn tại hoặc không hợp lệ
if (!$data || !isset($data['madetai'], $data['gvhd'], $data['phanbien'], $data['dot'])) {
    echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ hoặc thiếu thông tin."]);
    exit;
}

// Lấy dữ liệu từ yêu cầu
$madetai = $data['madetai'];
$gvhd = $data['gvhd'];
$phanbien = $data['phanbien'];
$dot = $data['dot'];

// Kiểm tra dữ liệu không trống
if (empty($madetai) || empty($gvhd) || empty($phanbien)|| empty($dot)) {
    echo json_encode(["success" => false, "message" => "Thiếu thông tin cần thiết."]);
    exit;
}

// Lưu thông tin phân công vào bảng phancongkhoaluan
$query = $conn->prepare("INSERT INTO phancongdoan (madetai, gvhd, gvphanbien, dot) VALUES (?, ?, ?, ?)");
if (!$query) {
    echo json_encode(["success" => false, "message" => "Lỗi chuẩn bị câu lệnh SQL: " . $conn->error]);
    exit;
}

$query->bind_param("sssi", $madetai, $gvhd, $phanbien, $dot);

// Thực hiện truy vấn
if ($query->execute()) {
    echo json_encode(["success" => true, "message" => "Lưu thông tin phân công thành công."]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi khi lưu thông tin phân công: " . $query->error]);
}

// Đóng kết nối
$query->close();
$conn->close();
?>
