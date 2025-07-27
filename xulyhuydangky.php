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

// Nhận dữ liệu từ yêu cầu
$data = json_decode(file_get_contents('php://input'), true);
$madetai = $data['madetai'];
$masv = $_SESSION['userid'];

// Bắt đầu giao dịch
$conn->begin_transaction();

try {
    // Kiểm tra xem sinh viên đã đăng ký đề tài này hay chưa
    $checkQuery = "SELECT COUNT(*) FROM dangkydetai WHERE masv = ? AND madetai = ?";
    $stmtCheck = $conn->prepare($checkQuery);
    $stmtCheck->bind_param("ss", $masv, $madetai);
    $stmtCheck->execute();
    $stmtCheck->bind_result($count);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if ($count == 0) {
        // Nếu không có bản ghi đăng ký, trả về lỗi
        echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng ký đề tài này']);
        return;
    }

    // Kiểm tra số lượng đăng ký hiện tại
    $querySoluong = "SELECT soluongdk FROM detai WHERE madetai = ?";
    $stmtSoluong = $conn->prepare($querySoluong);
    $stmtSoluong->bind_param("s", $madetai);
    $stmtSoluong->execute();
    $stmtSoluong->bind_result($soluongdk);
    $stmtSoluong->fetch();
    $stmtSoluong->close();

    // Giảm số lượng đăng ký nếu lớn hơn 0
    if ($soluongdk > 0) {
        $updateQuery = "UPDATE detai SET soluongdk = soluongdk - 1 WHERE madetai = ?";
        $stmtUpdate = $conn->prepare($updateQuery);
        $stmtUpdate->bind_param("s", $madetai);
        $stmtUpdate->execute();
        $stmtUpdate->close();
    }

    // Xóa bản ghi trong bảng dangkydetai
    $deleteQuery = "DELETE FROM dangkydetai WHERE masv = ? AND madetai = ?";
    $stmtDelete = $conn->prepare($deleteQuery);
    $stmtDelete->bind_param("ss", $masv, $madetai);
    $stmtDelete->execute();
    $stmtDelete->close();

    // Cam kết giao dịch
    $conn->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Nếu có lỗi, hoàn tác giao dịch
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
}

// Đóng kết nối
$conn->close();
?>
