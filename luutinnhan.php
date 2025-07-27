<?php
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

// Đặt múi giờ cho PHP (múi giờ Việt Nam)
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ theo Việt Nam

// Kiểm tra dữ liệu và session
if (!isset($_SESSION["username"]) || !$data || empty($data['dt2']) || empty($data['message'])) {
    echo json_encode(["status" => "error", "message" => "Missing data or session"]);
    exit;
}

$userId = $_SESSION["userid"];
$username = $_SESSION["username"];
$madetai = $data['dt2'];
$message = $data['message'];

// Lấy ngày giờ hiện tại với múi giờ đã thiết lập
$timestamp = date('Y-m-d H:i:s');  // Định dạng: "YYYY-MM-DD HH:MM:SS"

$conn = new mysqli("localhost", "root", "", "doan2", 3309);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO chat (manguoigui, tennguoigui, madetai, noidung, ngaygui) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $userId, $username, $madetai, $message, $timestamp);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Message saved successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
