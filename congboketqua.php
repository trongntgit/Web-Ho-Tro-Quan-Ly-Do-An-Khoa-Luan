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

// Hàm công bố
function congBoDiem($madetai, $conn) {
    // Bắt đầu transaction
    $conn->begin_transaction();

    try {
        // 1. Cập nhật bảng ketqua
        $sql = "UPDATE ketqua SET trangthai = 'Công bố' WHERE madetai = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $madetai);
        if (!$stmt->execute()) {
            throw new Exception("Lỗi cập nhật ketqua: " . $stmt->error);
        }
        $stmt->close();

        // 2. Cập nhật bảng detai
        $sql = "UPDATE detai SET trangthai = 'Hoàn thành' WHERE madetai = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $madetai);
        if (!$stmt->execute()) {
            throw new Exception("Lỗi cập nhật detai: " . $stmt->error);
        }
        $stmt->close();

        // 3. Lấy danh sách sinh viên từ bảng dangkydetai
        $sql = "SELECT masv FROM dangkydetai WHERE madetai = ? AND trangthai = 'Chấp nhận'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $madetai);
        $stmt->execute();
        $result = $stmt->get_result();
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row['masv'];
        }
        $stmt->close();

        // 4. Gửi thông báo đến sinh viên
        $sql = "INSERT INTO thongbao (manguoinhan, noidung, ngay) VALUES (?, ?, current_timestamp())";
        $stmt = $conn->prepare($sql);
        $message = "Bạn đã có kết quả của đề tài $madetai, hãy kiểm tra.";

        foreach ($students as $student) {
            $stmt->bind_param("ss", $student, $message);
            if (!$stmt->execute()) {
                throw new Exception("Lỗi gửi thông báo: " . $stmt->error);
            }
        }
        $stmt->close();

        // Commit transaction
        $conn->commit();

        echo "Đề tài '$madetai' đã được công bố và thông báo đã được gửi.";
    } catch (Exception $e) {
        // Rollback transaction nếu có lỗi
        $conn->rollback();
        echo "Lỗi: " . $e->getMessage();
    }
}

// Hàm hủy công bố
function huyCongBo($madetai, $conn) {
    $sql = "UPDATE ketqua SET trangthai = 'Chờ công bố' WHERE madetai = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $madetai);
    if ($stmt->execute()) {
        echo "Đề tài '$madetai' đã hủy công bố.";
    } else {
        echo "Lỗi: " . $stmt->error;
    }
    $stmt->close();
}

// Nhận dữ liệu từ AJAX
$action = $_POST['action'] ?? '';
$madetai = $_POST['madetai'] ?? '';

if ($action === 'congbo') {
    congBoDiem($madetai, $conn);
} elseif ($action === 'huycongbo') {
    huyCongBo($madetai, $conn);
}

$conn->close();
?>
