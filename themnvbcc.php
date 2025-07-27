<?php
// add-nhanvien-to-chamcong.php
header('Content-Type: application/json'); // Đảm bảo phản hồi có loại nội dung JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Đọc dữ liệu JSON từ yêu cầu POST
    $data = json_decode(file_get_contents('php://input'), true);

    // Kiểm tra nếu JSON hợp lệ
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'message' => 'Dữ liệu JSON không hợp lệ.']);
        exit;
    }

    // Lấy các giá trị từ dữ liệu JSON
    $manv = $data['manv'] ?? '';
    $hoten = $data['hoten'] ?? '';
    $mabcc = $data['mabcc'] ?? '';

    // Kết nối tới cơ sở dữ liệu MySQL
    $server = "localhost";
    $database = "qlnv";
    $user = "root";
    $pass = "";
    $port = 3309;
    
    $con = new mysqli($server, $user, $pass, $database, $port);

    // Kiểm tra kết nối
    if ($con->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Kết nối CSDL thất bại: ' . $con->connect_error]);
        exit;
    }

    // Kiểm tra xem nhân viên đã có trong bảng chấm công chưa
    $checkQuery = "SELECT COUNT(*) AS count FROM chamcong WHERE manv = ? AND mabcc = ?";
    $checkStmt = $con->prepare($checkQuery);

    if ($checkStmt) {
        $checkStmt->bind_param('ss', $manv, $mabcc);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            // Nhân viên đã tồn tại
            echo json_encode(['success' => false, 'message' => 'Nhân viên đã có trong bảng chấm công.']);
            $con->close();
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi kiểm tra dữ liệu.']);
        $con->close();
        exit;
    }

    // Chuẩn bị và thực thi câu lệnh SQL để thêm nhân viên
    $query = "INSERT INTO chamcong (manv, hoten, mabcc) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param('sss', $manv, $hoten, $mabcc);
        $stmt->execute();
        
        // Kiểm tra kết quả thực thi
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể thêm nhân viên vào bảng chấm công.']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi chuẩn bị câu lệnh SQL.']);
    }

    // Đóng kết nối
    $con->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Phương thức yêu cầu không hợp lệ.']);
}
