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

$title = $data["title"];
$description = $data["description"];
$image_url = $data["image_url"];
$date = $data["date"];
$dd = $data["dd"];

// Thực hiện truy vấn thêm dữ liệu
$sql = "INSERT INTO news_events (title, description, image_url, date, duongdan) VALUES (?, ?, ?, ?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $title, $description, $image_url, $date, $dd);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Thêm thất bại!"]);
}

$stmt->close();
$conn->close();
