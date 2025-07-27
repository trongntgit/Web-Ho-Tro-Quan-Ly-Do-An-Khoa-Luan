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

// Kiểm tra nếu có yêu cầu từ AJAX
if (isset($_POST['madetai']) && isset($_POST['masv'])) {
    $madetai = $_POST['madetai'];
    $masv = $_POST['masv'];

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Xóa dữ liệu trong bảng dangkydetai
        $sql_delete = "DELETE FROM dangkydetai WHERE masv = ? AND madetai = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("ss", $masv, $madetai); // 'ss' vì masv và madetai là chuỗi
        $stmt_delete->execute();

        // Giảm giá trị soluongdk trong bảng detai
        $sql_update = "UPDATE detai SET soluongdk = soluongdk - 1 WHERE madetai = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("s", $madetai); // 's' vì madetai là chuỗi
        $stmt_update->execute();

        // Commit giao dịch
        $conn->commit();

        // Trả về thông báo thành công
        echo json_encode(['success' => true, 'message' => 'Hủy đăng ký thành công!']);
    } catch (Exception $e) {
        // Rollback nếu có lỗi xảy ra
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
}
?>
