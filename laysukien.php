<?php
// Kết nối cơ sở dữ liệu
$host = "localhost";
$user = "root";
$password = "";
$database = "doan2";
$port = 3309;

$conn = new mysqli($host, $user, $password, $database, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode(["error" => "Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error]);
    exit;
}

// Truy vấn dữ liệu sự kiện
$sql = "SELECT id, title, description, image_url, date FROM news_events WHERE type = 'su_kien' ORDER BY date DESC";
$result = $conn->query($sql);

if ($result) {
    $data = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
} else {
    echo json_encode(["error" => "Lỗi truy vấn cơ sở dữ liệu: " . $conn->error]);
}

$conn->close();
?>
