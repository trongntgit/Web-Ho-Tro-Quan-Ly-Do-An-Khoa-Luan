<?php
header('Content-Type: application/json');
session_start();

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Kết nối thất bại: ' . $conn->connect_error]));
}

// Lấy ID người dùng từ session
$userId = $_SESSION['userid'];

// Kiểm tra giá trị của userId
if (empty($userId)) {
    die(json_encode(['success' => false, 'message' => 'Không có userId trong session']));
}

// Truy vấn để lấy thông báo mới nhất
$sql = "SELECT mathongbao, noidung, ngay FROM thongbao WHERE manguoinhan = ? ORDER BY ngay DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId);
$stmt->execute();

// Kiểm tra lỗi truy vấn
if ($stmt->error) {
    die(json_encode(['success' => false, 'message' => 'Lỗi truy vấn: ' . $stmt->error]));
}

$result = $stmt->get_result();

// Kiểm tra xem có thông báo không
if ($result->num_rows > 0) {
    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        // Chuyển ngày sang định dạng ISO 8601
        // $row['ngay'] = date('c', strtotime($row['ngay']));
        $notifications[] = $row;
    }
    echo json_encode(['success' => true, 'notifications' => $notifications]);
} else {
    echo json_encode(['success' => false, 'message' => 'Không có thông báo']);
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
