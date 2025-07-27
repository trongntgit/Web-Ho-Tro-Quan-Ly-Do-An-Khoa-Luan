<?php
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION["userid"]) || !isset($data['messageId'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized or missing data"]);
    exit;
}

$userId = $_SESSION["userid"];
$messageId = $data['messageId'];

$conn = new mysqli("localhost", "root", "", "doan2", 3309);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Only delete if the current user is the sender of the message
$stmt = $conn->prepare("DELETE FROM chat WHERE id = ? AND manguoigui = ?");
$stmt->bind_param("is", $messageId, $userId);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Message deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Message not found or you are not the sender"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
