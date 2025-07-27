<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Nhận dữ liệu từ AJAX
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id']) && isset($data['dot_name']) && isset($data['start_date']) && isset($data['end_date'])) {
    $dotId = $data['id'];
    $dotName = $data['dot_name'];
    $startDate = $data['start_date'];
    $endDate = $data['end_date'];

    // Cập nhật đợt đăng ký
    $sql = "UPDATE dotdangky SET tendot = '$dotName', ngaybatdau = '$startDate', ngayketthuc = '$endDate' WHERE id = $dotId";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Đợt đăng ký đã được cập nhật.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật đợt.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
}

$conn->close();
?>
