<?php
header("Content-Type: application/json");

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error]);
    exit();
}

// Nhận dữ liệu từ JavaScript
$data = json_decode(file_get_contents("php://input"), true);

$masv = $data['masv'] ?? null;
$madetai = $data['madetai'] ?? null;
$dotdangky = $data['dotdangky'] ?? null;
$quantri = $data['quantri'] ?? 1; // Mặc định là quản trị viên

if (!$masv || !$madetai || !$dotdangky) {
    echo json_encode(["success" => false, "message" => "Thiếu dữ liệu yêu cầu."]);
    exit;
}

// Thêm dữ liệu vào bảng dangkydetai
$sql = "INSERT INTO dangkydetai (masv, madetai, dotdangky, quantri) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $masv, $madetai, $dotdangky, $quantri);

if ($stmt->execute()) {
    // Tăng số lượng đăng ký trong bảng detai
    $updateSql = "UPDATE detai SET soluongdk = soluongdk + 1 WHERE madetai = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("s", $madetai);

    if ($updateStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Gán đề tài thành công và cập nhật số lượng đăng ký."]);
    } else {
        echo json_encode(["success" => false, "message" => "Không thể cập nhật số lượng đăng ký: " . $updateStmt->error]);
    }

    $updateStmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Không thể thêm dữ liệu vào cơ sở dữ liệu: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
