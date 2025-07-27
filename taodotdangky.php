<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra nếu dữ liệu được gửi qua AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận dữ liệu JSON từ phía client
    $data = json_decode(file_get_contents("php://input"), true);

    $dot_name = $data['dot_name'];
    $start_date = $data['start_date']; // ngày bắt đầu
    $end_date = $data['end_date']; // ngày kết thúc

    // Kiểm tra tính hợp lệ của ngày (đảm bảo đúng định dạng DATE)
    if (strtotime($start_date) > strtotime($end_date)) {
        echo json_encode(['success' => false, 'message' => 'Ngày kết thúc phải sau ngày bắt đầu.']);
        exit;
    }

    // Lưu đợt đăng ký vào cơ sở dữ liệu
    $sql = "INSERT INTO dotdangky (tendot, ngaybatdau, ngayketthuc) VALUES ('$dot_name', '$start_date', '$end_date')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Tạo đợt đăng ký thành công!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi lưu đợt.']);
    }

    // Đóng kết nối
    $conn->close();
}
?>
