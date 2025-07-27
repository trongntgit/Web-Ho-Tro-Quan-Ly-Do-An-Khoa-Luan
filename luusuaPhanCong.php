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
    echo json_encode(["success" => false, "message" => "Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error]);
    exit;
}

// Đặt mã hóa UTF-8
$conn->set_charset("utf8mb4");

// Lấy dữ liệu từ yêu cầu POST
$input = json_decode(file_get_contents('php://input'), true);

$madetai = $input['madetai'] ?? null;
$gvphanbien = $input['gvphanbien'] ?? null;
$chutich = $input['chutich'] ?? null;

// Kiểm tra dữ liệu đầu vào
if (!$madetai || !$gvphanbien || !$chutich) {
    echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ. Vui lòng kiểm tra lại."]);
    exit;
}

// Truy vấn cập nhật phân công
$sql = "
    UPDATE phancongkhoaluan
    SET gvphanbien = ?, chutich = ?
    WHERE madetai = ?
";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(["success" => false, "message" => "Lỗi khi chuẩn bị truy vấn: " . $conn->error]);
    exit;
}

$stmt->bind_param("sss", $gvphanbien, $chutich, $madetai);
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "Lưu thay đổi thành công."]);
    } else {
        echo json_encode(["success" => false, "message" => "Không có thay đổi nào được thực hiện."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Lỗi khi lưu dữ liệu: " . $stmt->error]);
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
