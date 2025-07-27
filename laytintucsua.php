<?php
// Thông tin kết nối cơ sở dữ liệu
$host = "localhost";
$user = "root";
$password = "";
$database = "doan2";
$port = 3309;

// Kết nối tới cơ sở dữ liệu
$conn = new mysqli($host, $user, $password, $database, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode(["error" => "Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error]);
    exit;
}

// Lấy ID từ yêu cầu GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo json_encode(["error" => "ID không hợp lệ"]);
    exit;
}

// Truy vấn lấy thông tin tin tức dựa trên ID
$sql = "SELECT id, title, description, image_url, date, duongdan FROM news_events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra kết quả truy vấn
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(["error" => "Không tìm thấy tin tức với ID này"]);
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
