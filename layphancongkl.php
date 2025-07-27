<?php
header('Content-Type: application/json');

// Kết nối cơ sở dữ liệu
$host = "localhost";
$user = "root";
$password = "";
$database = "doan2";
$port = 3309;

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error]);
    exit;
}

$conn->set_charset("utf8mb4");

// Lấy mã đề tài từ yêu cầu POST
$input = json_decode(file_get_contents('php://input'), true);
$madetai = $input['madetai'] ?? null;

if (!$madetai) {
    echo json_encode(["success" => false, "message" => "Mã đề tài không hợp lệ."]);
    exit;
}

// Truy vấn dữ liệu chi tiết phân công
$sql = "
    SELECT 
        pkl.madetai, 
        dt.tendetai, 
        gv1.ma AS gvthuky, 
        gv1.hoten AS tenthuky,
        gv2.ma AS gvphanbien, 
        gv3.ma AS chutich
    FROM phancongkhoaluan pkl
    LEFT JOIN detai dt ON pkl.madetai = dt.madetai
    LEFT JOIN giangvien gv1 ON pkl.gvthuky = gv1.ma
    LEFT JOIN giangvien gv2 ON pkl.gvphanbien = gv2.ma
    LEFT JOIN giangvien gv3 ON pkl.chutich = gv3.ma
    WHERE pkl.madetai = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $madetai);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $gvthuky = $row['gvthuky'];

    // Lấy danh sách giảng viên phản biện và chủ tịch, loại trừ gvthuky
    $dsPhanBienQuery = "
        SELECT ma, hoten 
        FROM giangvien 
        WHERE ma != ? AND (chucvu='Giảng viên' or chucvu ='Trưởng bộ môn' or chucvu ='Trưởng khoa')
    ";
    $dsChuTichQuery = "
        SELECT ma, hoten 
        FROM giangvien
        WHERE ma != ? AND (chucvu = 'Trưởng bộ môn' OR chucvu = 'Trưởng khoa')
    ";

    $stmtPhanBien = $conn->prepare($dsPhanBienQuery);
    $stmtPhanBien->bind_param("s", $gvthuky);
    $stmtPhanBien->execute();
    $dsPhanBien = $stmtPhanBien->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmtChuTich = $conn->prepare($dsChuTichQuery);
    $stmtChuTich->bind_param("s", $gvthuky);
    $stmtChuTich->execute();
    $dsChuTich = $stmtChuTich->get_result()->fetch_all(MYSQLI_ASSOC);

    $data = [
        "success" => true,
        "madetai" => $row['madetai'],
        "tendetai" => $row['tendetai'],
        "gvthuky" => $row['gvthuky'],
        "tenthuky" => $row['tenthuky'],
        "gvphanbien" => $row['gvphanbien'],
        "chutich" => $row['chutich'],
        "dsPhanBien" => $dsPhanBien,
        "dsChuTich" => $dsChuTich
    ];
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["success" => false, "message" => "Không tìm thấy dữ liệu cho mã đề tài này."]);
}

$conn->close();
?>
