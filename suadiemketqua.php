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
    die(json_encode(['success' => false, 'message' => 'Kết nối thất bại: ' . $conn->connect_error]));
}

// Lấy phương thức request
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST') {
    // Lấy dữ liệu từ yêu cầu
    $data = json_decode(file_get_contents('php://input'), true);

    $madetai = $data['madetai'] ?? '';
    $diemGVHD = $data['diem_gvhd'] ?? null;
    $diemGVPB = $data['diem_gvpb'] ?? null;
    $diemChuTich = $data['diem_chutich'] ?? null;

    // Kiểm tra dữ liệu đầu vào
    if (empty($madetai) || $diemGVHD === null || $diemGVPB === null || $diemChuTich === null) {
        echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
        exit;
    }

    // Cập nhật điểm và nhận xét
    $stmt = $conn->prepare("UPDATE ketqua SET diemgvhd = ?, diemgvpb = ?, diemchutich = ? WHERE madetai = ?");
    $stmt->bind_param("ddds", $diemGVHD, $diemGVPB, $diemChuTich, $madetai);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cập nhật điểm thành công.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật: ' . $stmt->error]);
    }

    $stmt->close();
}
?>
