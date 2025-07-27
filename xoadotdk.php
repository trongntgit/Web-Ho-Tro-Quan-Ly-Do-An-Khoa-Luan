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

if (isset($data['id'])) {
    $dotId = $data['id'];

    // Bắt đầu một giao dịch
    $conn->begin_transaction();

    try {
        // Xóa dữ liệu trong bảng dotdangky_detai
        $sql1 = "DELETE FROM dotdangky_detai WHERE id_dotdk = $dotId";
        if ($conn->query($sql1) !== TRUE) {
            throw new Exception("Lỗi khi xóa dữ liệu trong dotdangky_detai.");
        }

        // Xóa dữ liệu trong bảng dotdangky_sinhvien
        $sql2 = "DELETE FROM dotdangky_sinhvien WHERE id_dotdk = $dotId";
        if ($conn->query($sql2) !== TRUE) {
            throw new Exception("Lỗi khi xóa dữ liệu trong dotdangky_sinhvien.");
        }

        // Xóa đợt đăng ký trong bảng dotdangky
        $sql3 = "DELETE FROM dotdangky WHERE id = $dotId";
        if ($conn->query($sql3) !== TRUE) {
            throw new Exception("Lỗi khi xóa đợt đăng ký.");
        }

        // Nếu tất cả các câu lệnh đều thành công, commit giao dịch
        $conn->commit();
        
        // Trả về kết quả thành công
        echo json_encode(['success' => true, 'message' => 'Đợt đăng ký và dữ liệu liên quan đã được xóa.']);
    } catch (Exception $e) {
        // Nếu có lỗi, rollback giao dịch
        $conn->rollback();
        
        // Trả về thông báo lỗi
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
}

$conn->close();
?>
