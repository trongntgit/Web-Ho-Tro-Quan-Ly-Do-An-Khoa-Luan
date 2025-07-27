<?php
header('Content-Type: application/json; charset=utf-8');

// Bật ghi lỗi để debug
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log'); // Ghi log lỗi vào file `error.log`

// Kết nối cơ sở dữ liệu
$host = "localhost";
$user = "root";
$password = "";
$database = "doan2";
$port = 3309;

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    echo json_encode(["error" => "Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error]);
    exit;
}

// Kiểm tra tham số đầu vào
if (!isset($_GET['id_dotdk']) || !is_numeric($_GET['id_dotdk'])) {
    echo json_encode(["error" => "Tham số 'id_dotdk' không hợp lệ hoặc không tồn tại."]);
    exit;
}

$idDotDangKy = intval($_GET['id_dotdk']);

// Khởi tạo mảng kết quả
$resultData = [];

// Lấy danh sách đề tài từ đợt đăng ký
$sqlDotDangKy = "SELECT madetai FROM dotdangky_detai WHERE id_dotdk = ?";
$stmtDotDangKy = $conn->prepare($sqlDotDangKy);

if (!$stmtDotDangKy) {
    echo json_encode(["error" => "Lỗi chuẩn bị truy vấn dotdangky_detai: " . $conn->error]);
    exit;
}

$stmtDotDangKy->bind_param("i", $idDotDangKy);
$stmtDotDangKy->execute();
$resultDotDangKy = $stmtDotDangKy->get_result();

$maDeTaiArray = [];
while ($row = $resultDotDangKy->fetch_assoc()) {
    $maDeTaiArray[] = $row['madetai'];
}
$stmtDotDangKy->close();

// Nếu không có mã đề tài
if (empty($maDeTaiArray)) {
    echo json_encode(["message" => "Không có đề tài nào trong đợt đăng ký này."]);
    exit;
}

// Truy vấn thông tin đề tài và sinh viên, kiểm tra trạng thái và loại đề tài
$placeholders = implode(",", array_fill(0, count($maDeTaiArray), "?"));
$sqlDeTaiSinhVien = "
    SELECT 
        detai.madetai, detai.tendetai, detai.linhvuc, detai.trangthai, detai.soluongmax, detai.soluongdk, detai.tengv, detai.loaidetai, detai.manguoitao,
        GROUP_CONCAT(sinhvien.hoten SEPARATOR ', ') AS sinhvien
    FROM detai
    LEFT JOIN dangkydetai ON detai.madetai = dangkydetai.madetai
    LEFT JOIN sinhvien ON dangkydetai.masv = sinhvien.ma
    WHERE detai.madetai IN ($placeholders) 
      AND detai.trangthai IN ('Đang thực hiện', 'Đã hoàn thành')
      AND detai.loaidetai != 'Khóa luận'
      AND NOT EXISTS (
          SELECT 1 
          FROM phancongdoan 
          WHERE phancongdoan.madetai = detai.madetai
      )
    GROUP BY detai.madetai
";


$stmtDeTaiSinhVien = $conn->prepare($sqlDeTaiSinhVien);
if (!$stmtDeTaiSinhVien) {
    echo json_encode(["error" => "Lỗi chuẩn bị truy vấn detai và sinhvien: " . $conn->error]);
    exit;
}

$stmtDeTaiSinhVien->bind_param(str_repeat("s", count($maDeTaiArray)), ...$maDeTaiArray);
$stmtDeTaiSinhVien->execute();
$resultDeTaiSinhVien = $stmtDeTaiSinhVien->get_result();

while ($row = $resultDeTaiSinhVien->fetch_assoc()) {
    $resultData[] = [
        'madetai' => $row['madetai'],
        'tendetai' => $row['tendetai'],
        'linhvuc' => $row['linhvuc'] ?? "Không có",
        'trangthai' => $row['trangthai'],
        'soluongmax' => $row['soluongmax'],
        'soluongdk' => $row['soluongdk'] ?? 0,
        'tengv' => $row['tengv'] ?? "Không có",
        'loaidetai' => $row['loaidetai'] ?? "Không rõ",
        'sinhvien' => $row['sinhvien'] ?? "Không có sinh viên",
        'magv' => $row['manguoitao'] ?? "Không có mã",
    ];
}
$stmtDeTaiSinhVien->close();

// Trả về JSON
echo json_encode($resultData, JSON_UNESCAPED_UNICODE);

// Đóng kết nối
$conn->close();
?>
