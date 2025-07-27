<?php
header('Content-Type: application/json');

// Kết nối cơ sở dữ liệu
$server = "localhost";
$database = "doan2";
$user = "root";
$password = "";
$port = 3309;

$con = mysqli_connect($server, $user, $password, $database, $port);

if (!$con) {
    echo json_encode(['success' => false, 'message' => 'Kết nối CSDL thất bại: ' . mysqli_connect_error()]);
    exit;
}

// Lấy dữ liệu từ request
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;

// Kiểm tra ID
if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID không hợp lệ.']);
    exit;
}

// Cập nhật saplich thành 1
$sql = "UPDATE buoibaove SET saplich = 0 WHERE id = ?";
$stmt = $con->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Hủy sắp lịch thành công.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị câu lệnh SQL: ' . $con->error]);
}

// Đóng kết nối
mysqli_close($con);
?>
