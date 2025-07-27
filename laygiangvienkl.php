<?php
header('Content-Type: application/json');

// Kết nối cơ sở dữ liệu
$host = "localhost";
$user = "root";
$password = "";
$database = "doan2";
$port = 3309;

$conn = new mysqli($host, $user, $password, $database, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode(["error" => "Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error]);
    exit;
}

// Nhận dữ liệu từ yêu cầu POST (dữ liệu dạng JSON)
$data = json_decode(file_get_contents('php://input'), true);
$madetai = $data['madetai'];
$magv = $data['magv'];

// Lấy thông tin đề tài từ cơ sở dữ liệu
$detaiQuery = $conn->prepare("SELECT madetai, tendetai, linhvuc FROM detai WHERE madetai = ?");
$detaiQuery->bind_param("s", $madetai);
$detaiQuery->execute();
$detai = $detaiQuery->get_result()->fetch_assoc();

if (!$detai) {
    echo json_encode(["error" => "Không tìm thấy thông tin đề tài."]);
    exit;
}

// Lấy thông tin giảng viên phản biện (Chức vụ từ giảng viên trở lên, loại trừ $magv)
$phanbienQuery = $conn->prepare("
    SELECT ma, hoten 
    FROM giangvien 
    WHERE ((chucvu = 'Giảng viên'  AND chuyenmon = ?) OR (chucvu = 'Trưởng bộ môn' AND chuyenmon = ? ) OR (chucvu = 'Trưởng khoa') )
      AND ma != ?
");
$phanbienQuery->bind_param("sss", $detai['linhvuc'],$detai['linhvuc'] ,$magv);
$phanbienQuery->execute();
$phanbienResult = $phanbienQuery->get_result();
$dsPhanBien = [];
while ($row = $phanbienResult->fetch_assoc()) {
    $dsPhanBien[] = $row;
}

// Lấy thông tin giảng viên chủ tịch (Chức vụ từ Trưởng bộ môn trở lên, cùng lĩnh vực, loại trừ $magv)
$chutichQuery = $conn->prepare("
    SELECT ma, hoten 
    FROM giangvien 
    WHERE ((chucvu = 'Trưởng bộ môn' AND chuyenmon = ?) OR chucvu = 'Trưởng khoa') 
      AND ma != ?
");
$chutichQuery->bind_param("ss", $detai['linhvuc'], $magv);
$chutichQuery->execute();
$chutichResult = $chutichQuery->get_result();
$dsChuTich = [];
while ($row = $chutichResult->fetch_assoc()) {
    $dsChuTich[] = $row;
}

// Trả về dữ liệu dưới dạng JSON
echo json_encode([
    'success' => true,
    'madetai' => $detai['madetai'],
    'tendetai' => $detai['tendetai'],
    'linhvuc' => $detai['linhvuc'],
    'dsPhanBien' => $dsPhanBien,
    'dsChuTich' => $dsChuTich
]);

// Đóng kết nối
$conn->close();
?>
