<?php
header('Content-Type: application/json; charset=utf-8');

// Bật ghi lỗi để debug
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

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

// Lấy danh sách lịch sử phân công
$sqlPhanCong = "
    SELECT 
        pc.madetai, 
        dt.tendetai, 
        gvtk.hoten AS ten_gvtk, 
        gvpb.hoten AS ten_gvpb, 
        gvct.hoten AS ten_gvct, 
        pc.ngayphancong 
    FROM phancongkhoaluan pc
    LEFT JOIN detai dt ON pc.madetai = dt.madetai
    LEFT JOIN giangvien gvtk ON pc.gvthuky = gvtk.ma
    LEFT JOIN giangvien gvpb ON pc.gvphanbien = gvpb.ma
     LEFT JOIN giangvien gvct ON pc.chutich = gvct.ma
    WHERE pc.dot = ?
";

$stmtPhanCong = $conn->prepare($sqlPhanCong);

if (!$stmtPhanCong) {
    echo json_encode(["error" => "Lỗi chuẩn bị truy vấn phancongdoan: " . $conn->error]);
    exit;
}

$stmtPhanCong->bind_param("i", $idDotDangKy);
$stmtPhanCong->execute();
$resultPhanCong = $stmtPhanCong->get_result();

$phanCongData = [];
while ($row = $resultPhanCong->fetch_assoc()) {
    $phanCongData[] = [
        'madetai' => $row['madetai'],
        'tendetai' => $row['tendetai'] ?? "Không có",
        'ten_gvtk' => $row['ten_gvtk'] ?? "Không có",
        'ten_gvpb' => $row['ten_gvpb'] ?? "Không có",
        'ten_gvct' => $row['ten_gvct'] ?? "Không có",
        'ngayphancong' => $row['ngayphancong'] ?? "Không có"
    ];
}
$stmtPhanCong->close();

// Trả về JSON
echo json_encode($phanCongData, JSON_UNESCAPED_UNICODE);

// Đóng kết nối
$conn->close();
?>
