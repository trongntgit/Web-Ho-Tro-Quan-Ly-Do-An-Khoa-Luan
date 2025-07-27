<?php
// Thiết lập kết nối tới cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "doan2", 3309);

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Kết nối CSDL thất bại."]);
    exit();
}

// Lấy dữ liệu từ request JSON
$data = json_decode(file_get_contents('php://input'), true);
$madetai = $data['madetai'] ?? null;
$loaitiendo = $data['loaitiendo'] ?? null;
$ngay_nop = $data['ngay_nop'] ?? null;

// Kiểm tra các tham số có hợp lệ hay không
if (!$madetai || !$loaitiendo || !$ngay_nop) {
    echo json_encode(['success' => false, 'error' => 'Thiếu tham số yêu cầu']);
    echo $madetai;
    echo $loaitiendo;
    echo $ngay_nop;
    exit();
}

// Thực hiện truy vấn lấy ghi chú từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT ghichu FROM tiendo WHERE madetai = ? AND loaitiendo = ? AND ngaynop = ?");
$stmt->bind_param('sss', $madetai, $loaitiendo, $ngay_nop);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra kết quả truy vấn
if ($row = $result->fetch_assoc()) {
    // Trả về ghi chú dưới dạng JSON nếu tìm thấy
    echo json_encode(['success' => true, 'note' => $row['ghichu']]);
} else {
    // Nếu không tìm thấy ghi chú
    echo json_encode(['success' => false, 'note' => 'Không tìm thấy ghi chú']);
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
