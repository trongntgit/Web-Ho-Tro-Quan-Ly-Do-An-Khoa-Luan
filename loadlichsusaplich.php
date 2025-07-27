<?php
header('Content-Type: application/json');

// Kết nối cơ sở dữ liệu
$server = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($server, $user, $pass, $data, $port);

if (!$con) {
    echo json_encode(["status" => "error", "message" => "Kết nối CSDL thất bại: " . mysqli_connect_error()]);
    exit;
}

// Lấy mabuoi từ yêu cầu GET
$mabuoi = isset($_GET['mabuoi']) ? $_GET['mabuoi'] : null;

if (!$mabuoi) {
    echo json_encode(["status" => "error", "message" => "Thiếu tham số 'mabuoi'."]);
    exit;
}

// Truy vấn dữ liệu
$query = "
    SELECT 
        p.madetai,
        d.tendetai,
        p.giobd,
        p.giokt,
        g1.hoten AS gvthuky,
        g2.hoten AS gvphanbien,
        g3.hoten AS chutich,
        s.ma,
        s.hoten AS tensinhvien,
        s.lop
    FROM phancongkhoaluan p
    LEFT JOIN detai d ON p.madetai = d.madetai
    LEFT JOIN dangkydetai dk ON p.madetai = dk.madetai
    LEFT JOIN sinhvien s ON dk.masv = s.ma
    LEFT JOIN giangvien g1 ON p.gvthuky = g1.ma
    LEFT JOIN giangvien g2 ON p.gvphanbien = g2.ma
    LEFT JOIN giangvien g3 ON p.chutich = g3.ma
    WHERE p.buoibaove = ?
";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $mabuoi);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = [
            "madetai" => $row['madetai'],
            "tendetai" => $row['tendetai'],
            "giobd" => $row['giobd'],
            "giokt" => $row['giokt'],
            "gvthuky" => $row['gvthuky'],
            "gvphanbien" => $row['gvphanbien'],
            "chutich" => $row['chutich'],
            "masv" => $row['ma'],
            "tensinhvien" => $row['tensinhvien'],
            "lop" => $row['lop']
        ];
    }

    echo json_encode(["status" => "success", "data" => $rows]);
} else {
    echo json_encode(["status" => "error", "message" => "Không có dữ liệu cho buoibaove = $mabuoi."]);
}

// Đóng kết nối
mysqli_close($con);
