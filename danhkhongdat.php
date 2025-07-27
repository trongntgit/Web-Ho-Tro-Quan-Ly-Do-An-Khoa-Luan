<?php
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
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Đặt múi giờ chính xác
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kiểm tra nếu có gửi mã đề tài
if (isset($_POST['madetai'])) {
    $madetai = $_POST['madetai'];
    $magv = $_POST['magv'];

    // Cập nhật trạng thái trong bảng detai
    $sql = "UPDATE detai SET trangthai = 'Không đạt' WHERE madetai = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Lỗi chuẩn bị câu lệnh cập nhật trạng thái: " . $conn->error);
    }
    $stmt->bind_param("s", $madetai);

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Thực hiện cập nhật trạng thái
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi cập nhật trạng thái: " . $stmt->error);
        }

        // Lấy danh sách sinh viên từ bảng dangkydetai
        $query_masv = "SELECT masv FROM dangkydetai WHERE madetai = ? and trangthai='Chấp nhận'";
        $stmt_masv = $conn->prepare($query_masv);
        if ($stmt_masv === false) {
            throw new Exception("Lỗi chuẩn bị truy vấn danh sách sinh viên: " . $conn->error);
        }
        $stmt_masv->bind_param("s", $madetai);
        $stmt_masv->execute();
        $result = $stmt_masv->get_result();

        // Chèn thông báo cho từng sinh viên
        $query_thongbao = "INSERT INTO thongbao (manguoinhan, noidung, ngay) VALUES (?, ?, ?)";
        $stmt_thongbao = $conn->prepare($query_thongbao);
        if ($stmt_thongbao === false) {
            throw new Exception("Lỗi chuẩn bị câu lệnh chèn thông báo: " . $conn->error);
        }

        // Nội dung thông báo
        $noidung = "Đề tài $madetai của bạn đã bị giáo viên đánh giá là không đạt yêu cầu, vì vậy bạn không thể thực hiện tiếp tục.";
        $ngay = date("Y-m-d H:i:s"); // Lấy thời gian hiện tại

        while ($row = $result->fetch_assoc()) {
            $masv = $row['masv'];
            $stmt_thongbao->bind_param("sss", $masv, $noidung, $ngay);
            if (!$stmt_thongbao->execute()) {
                throw new Exception("Lỗi khi thêm thông báo cho sinh viên $masv: " . $stmt_thongbao->error);
            }
        }

        // Thêm dữ liệu vào bảng phieudiem
        $query_phieudiem = "INSERT INTO phieudiem (madetai, loaicham, diem, magv) VALUES (?, 'Không chấm', 0,?)";
        $stmt_phieudiem = $conn->prepare($query_phieudiem);
        if ($stmt_phieudiem === false) {
            throw new Exception("Lỗi chuẩn bị câu lệnh chèn dữ liệu vào phieudiem: " . $conn->error);
        }

        $stmt_phieudiem->bind_param("ss", $madetai,$magv);
        if (!$stmt_phieudiem->execute()) {
            throw new Exception("Lỗi khi thêm dữ liệu vào phieudiem: " . $stmt_phieudiem->error);
        }

        // Commit giao dịch
        $conn->commit();
        echo "Cập nhật trạng thái, gửi thông báo và thêm dữ liệu vào phieudiem thành công!";
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        $conn->rollback();
        echo "Lỗi: " . $e->getMessage();
    } finally {
        // Đóng câu lệnh
        $stmt->close();
        $stmt_masv->close();
        $stmt_thongbao->close();
        $stmt_phieudiem->close();
    }
} else {
    echo "Mã đề tài không được cung cấp!";
}

// Đóng kết nối
$conn->close();
?>
