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
        gv1.ma AS gvhd, 
        gv1.hoten AS tengvhd, 
        gv2.ma AS gvphanbien
    FROM phancongdoan pkl
    LEFT JOIN detai dt ON pkl.madetai = dt.madetai
    LEFT JOIN giangvien gv1 ON pkl.gvhd = gv1.ma
    LEFT JOIN giangvien gv2 ON pkl.gvphanbien = gv2.ma
    WHERE pkl.madetai = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $madetai);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Lấy danh sách giảng viên phản biện (không bao gồm giảng viên hướng dẫn)
    $phanbienQuery = $conn->prepare("
        SELECT ma, hoten 
        FROM giangvien 
        WHERE ma != ? AND (chucvu='Giảng viên' or chucvu ='Trưởng bộ môn' or chucvu ='Trưởng khoa')
    ");
    $phanbienQuery->bind_param("s", $row['gvhd']);
    $phanbienQuery->execute();
    $dsPhanBien = $phanbienQuery->get_result()->fetch_all(MYSQLI_ASSOC);

    // Lấy danh sách giảng viên chủ tịch
    $chutichQuery = $conn->query("
    SELECT ma, hoten 
    FROM giangvien
    WHERE ma != '{$row['gvhd']}' AND (chucvu = 'Trưởng bộ môn' OR chucvu = 'Trưởng khoa')
");

    $dsChuTich = $chutichQuery->fetch_all(MYSQLI_ASSOC);

    $data = [
        "success" => true,
        "madetai" => $row['madetai'],
        "tendetai" => $row['tendetai'],
        "gvhd" => $row['gvhd'],
        "tengvhd" => $row['tengvhd'],
        "gvphanbien" => $row['gvphanbien'],
        "dsPhanBien" => $dsPhanBien,
        "dsChuTich" => $dsChuTich
    ];
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["success" => false, "message" => "Không tìm thấy dữ liệu cho mã đề tài này."]);
}

$conn->close();
?>
