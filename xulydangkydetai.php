<?php
session_start();

// Kết nối đến cơ sở dữ liệu
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

// Lấy mã đề tài từ yêu cầu
$data = json_decode(file_get_contents("php://input"));
$madetai = $data->madetai;
$masv = $_SESSION['userid']; // Giả định rằng mã sinh viên được lưu trong phiên

// Bắt đầu giao dịch
$conn->begin_transaction();

try {
    // Lấy `id_dotdk` mới nhất từ bảng `dotdangky_sinhvien` cho sinh viên
    $getDotDKSql = "SELECT id_dotdk FROM dotdangky_sinhvien WHERE masv = ? ORDER BY id_dotdk DESC LIMIT 1";
    $stmtDotDK = $conn->prepare($getDotDKSql);
    $stmtDotDK->bind_param("s", $masv);
    $stmtDotDK->execute();
    $stmtDotDK->bind_result($id_dotdk);
    $stmtDotDK->fetch();
    $stmtDotDK->close();

    if (!$id_dotdk) {
        throw new Exception("Không tìm thấy đợt đăng ký nào cho sinh viên.");
    }

    // Kiểm tra trạng thái "Mở" trong bảng `dotdangky`
    $checkDotTrangThaiSql = "SELECT trangthai FROM dotdangky WHERE id = ?";
    $stmtCheckTrangThai = $conn->prepare($checkDotTrangThaiSql);
    $stmtCheckTrangThai->bind_param("i", $id_dotdk);
    $stmtCheckTrangThai->execute();
    $stmtCheckTrangThai->bind_result($trangthai_dotdk);
    $stmtCheckTrangThai->fetch();
    $stmtCheckTrangThai->close();

    if ($trangthai_dotdk !== "Mở") {
        throw new Exception("Đợt đăng ký không ở trạng thái 'Mở'.");
    }

    // Kiểm tra nếu sinh viên đã đăng ký đề tài này
    $checkSql = "SELECT COUNT(*) FROM dangkydetai WHERE masv = ? AND madetai = ?";
    $stmtCheck = $conn->prepare($checkSql);
    $stmtCheck->bind_param("ss", $masv, $madetai);
    $stmtCheck->execute();
    $stmtCheck->bind_result($count);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if ($count > 0) {
        // Nếu sinh viên đã đăng ký đề tài, thoát khỏi quá trình và gửi thông báo
        echo json_encode(['success' => false, 'message' => 'Bạn đã đăng ký đề tài này.']);
    } else {
        // Tăng số lượng đăng ký trong bảng detai
        $updateSql = "UPDATE detai SET soluongdk = soluongdk + 1 WHERE madetai = ?";
        $stmtUpdate = $conn->prepare($updateSql);
        $stmtUpdate->bind_param("s", $madetai);
        $stmtUpdate->execute();

        // Thêm vào bảng dangkydetai
        $insertSql = "INSERT INTO dangkydetai (trangthai, masv, madetai, ngaydangky, dotdangky) VALUES ('Chờ duyệt', ?, ?, NOW(), ?)";
        $stmtInsert = $conn->prepare($insertSql);
        $stmtInsert->bind_param("ssi", $masv, $madetai, $id_dotdk);
        $stmtInsert->execute();

        // Commit giao dịch
        $conn->commit();
        echo json_encode(['success' => true]);
    }
} catch (Exception $e) {
    // Rollback nếu có lỗi
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    $conn->close();
}
?>
