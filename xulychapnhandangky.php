<?php
session_start();
$sever = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($sever, $user, $pass, $data, $port);

if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

// Đặt múi giờ chính xác
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đảm bảo múi giờ là Việt Nam

// Nhận dữ liệu từ yêu cầu
$data = json_decode(file_get_contents('php://input'), true);
$response = [];

if (isset($data['madetai'], $data['madot'])) {
    $madetai = $data['madetai'];
    $madot = (int)$data['madot']; // Đảm bảo madot là số nguyên

    // Thiết lập giá trị cho trạng thái của bảng detai
    $trangthai_detai = "Đang thực hiện";

    // Cập nhật bảng detai
    $query_detai = "UPDATE detai SET trangthai = ? WHERE madetai = ?";
    $stmt_detai = $con->prepare($query_detai);

    if (!$stmt_detai) {
        $response['success'] = false;
        $response['message'] = "Lỗi chuẩn bị truy vấn bảng detai: " . $con->error;
        echo json_encode($response);
        exit;
    }
    $stmt_detai->bind_param("ss", $trangthai_detai, $madetai);

    // Bắt đầu giao dịch
    $con->begin_transaction();

    try {
        // Thực hiện cập nhật bảng detai
        if (!$stmt_detai->execute()) {
            throw new Exception("Lỗi khi cập nhật trạng thái của bảng detai: " . $stmt_detai->error);
        }

        // Lấy danh sách sinh viên
        $query_masv = "SELECT masv FROM dangkydetai WHERE madetai = ? AND trangthai = 'Chấp nhận' AND dotdangky = ?";
        $stmt_masv = $con->prepare($query_masv);

        if (!$stmt_masv) {
            throw new Exception("Lỗi chuẩn bị truy vấn bảng dangkydetai: " . $con->error);
        }

        $stmt_masv->bind_param("si", $madetai, $madot);
        $stmt_masv->execute();
        $result = $stmt_masv->get_result();

        // Thêm thông báo cho từng sinh viên
        while ($row = $result->fetch_assoc()) {
            $masv = $row['masv'];
            $noidung = "Giáo viên đã mở bắt đầu thực hiện đề tài " . $madetai . ". Hãy bắt đầu thực hiện";

            // Lấy thời gian hiện tại (ngày và giờ chính xác)
            $now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
            $ngaygui = $now->format('Y-m-d H:i:s'); // Định dạng ngày giờ: "YYYY-MM-DD HH:MM:SS"

            // Thêm thông báo vào bảng thongbao
            $query_thongbao = "INSERT INTO thongbao (manguoinhan, noidung, ngay) VALUES (?, ?, ?)";
            $stmt_thongbao = $con->prepare($query_thongbao);

            if (!$stmt_thongbao) {
                throw new Exception("Lỗi chuẩn bị truy vấn bảng thongbao: " . $con->error);
            }

            $stmt_thongbao->bind_param("sss", $masv, $noidung, $ngaygui);

            if (!$stmt_thongbao->execute()) {
                throw new Exception("Lỗi khi thêm thông báo: " . $stmt_thongbao->error);
            }
        }

        // Commit giao dịch
        $con->commit();
        $response['success'] = true;
        $response['message'] = "Cập nhật trạng thái và thông báo thành công.";
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        $con->rollback();
        $response['success'] = false;
        $response['message'] = "Không thể cập nhật trạng thái và thông báo: " . $e->getMessage();
    }
} else {
    $response['success'] = false;
    $response['message'] = "Mã đề tài hoặc mã đợt không có.";
}

// Trả về phản hồi dưới dạng JSON
echo json_encode($response);
?>
