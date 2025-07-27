<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Kết nối thất bại: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? null;
$madot = $data['madot'] ?? null;

if (!$action || !$madot) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin cần thiết.']);
    exit;
}

if ($action === 'open' || $action === 'close') {
    $trangthai_dot = ($action === 'open') ? 'Mở' : 'Đóng';
    $trangthai_detai = ($action === 'open') ? 'Đăng ký' : 'Khóa đăng ký';

    // Cập nhật trạng thái của đợt đăng ký
    $update_dot_query = "UPDATE dotdangky SET trangthai = ? WHERE id = ?";
    $update_dot_stmt = $conn->prepare($update_dot_query);
    $update_dot_stmt->bind_param('si', $trangthai_dot, $madot);

    if ($update_dot_stmt->execute()) {
        // Lấy danh sách mã đề tài từ bảng dotdangky_detai
        $query = "SELECT madetai FROM dotdangky_detai WHERE id_dotdk = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Lỗi chuẩn bị truy vấn: ' . $conn->error]);
            exit;
        }
        $stmt->bind_param('i', $madot);
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Lỗi thực thi truy vấn: ' . $stmt->error]);
            exit;
        }

        $result = $stmt->get_result();
        $madetais = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($madetais)) {
            $madetai_list = array_column($madetais, 'madetai');

            // Duyệt qua từng mã đề tài để kiểm tra trạng thái trước khi cập nhật
            foreach ($madetai_list as $madetai) {
                // Lấy trạng thái hiện tại của đề tài
                $check_query = "SELECT trangthai FROM detai WHERE madetai = ?";
                $check_stmt = $conn->prepare($check_query);
                $check_stmt->bind_param('s', $madetai);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result();
                $row = $check_result->fetch_assoc();

                if ($row) {
                    $current_status = $row['trangthai'];
                    // Bỏ qua nếu trạng thái là "Đang thực hiện" hoặc "Hoàn thành"
                    if (in_array($current_status, ['Đang thực hiện', 'Hoàn thành'])) {
                        continue;
                    }

                    // Cập nhật trạng thái nếu hợp lệ
                    $update_query = "UPDATE detai SET trangthai = ? WHERE madetai = ?";
                    $update_stmt = $conn->prepare($update_query);
                    $update_stmt->bind_param('ss', $trangthai_detai, $madetai);
                    if (!$update_stmt->execute()) {
                        echo json_encode(['success' => false, 'message' => "Lỗi cập nhật trạng thái cho mã đề tài $madetai: " . $update_stmt->error]);
                        exit;
                    }
                }
            }

            echo json_encode(['success' => true, 'message' => 'Cập nhật thành công trạng thái của đợt và các đề tài.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy mã đề tài nào trong đợt đăng ký.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Cập nhật trạng thái đợt đăng ký thất bại.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Hành động không hợp lệ.']);
}

$conn->close();
