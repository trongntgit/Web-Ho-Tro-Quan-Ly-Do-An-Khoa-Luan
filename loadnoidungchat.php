<?php
session_start();
header('Content-Type: application/json');

$madetai = $_GET['madetai'];
$currentUserId = $_SESSION["userid"];

$conn = new mysqli("localhost", "root", "", "doan2", 3309);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$stmt = $conn->prepare("SELECT id, manguoigui, tennguoigui, noidung, ngaygui FROM chat WHERE madetai = ? ORDER BY ngaygui");
$stmt->bind_param("s", $madetai);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    // Check if the message was sent by the current user
    $row['isSelf'] = ($row['manguoigui'] === $currentUserId);
    $messages[] = $row;
}

echo json_encode($messages);

$stmt->close();
$conn->close();
?>
