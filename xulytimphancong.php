<?php
session_start();
$server = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($server, $user, $pass, $data, $port);

// Kiểm tra kết nối CSDL
if (!$con) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => 'Kết nối CSDL thất bại: ' . mysqli_connect_error()]);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

$query = isset($_POST['madetai']) ? $_POST['madetai'] : '';
$loaidetai = isset($_POST['loaidetai']) ? $_POST['loaidetai'] : '';

$madt = "";
$ar_ma = explode("-", $query);

if (!empty($ar_ma)) {
    $madt = mysqli_real_escape_string($con, $ar_ma[0]);
    $data = [];

    if ($loaidetai === "Đồ án 1" || $loaidetai === "Đồ án 2") {
        $sql = "
            SELECT id, madetai, gvhd AS gvthuky, gvphanbien, dot, ngayphancong
            FROM phancongdoan
            WHERE madetai = '$madt'
        ";
    } elseif ($loaidetai === "Khóa luận") {
        $sql = "
            SELECT id, madetai, gvthuky, gvphanbien, chutich, dot, ngayphancong, trangthai, ngaybaove, buoibaove, chon
            FROM phancongkhoaluan
            WHERE madetai = '$madt'
        ";
    } else {
        $sql = "
            SELECT 'phancongdoan' AS table_name, id, madetai, gvhd AS gvthuky, gvphanbien, NULL AS chutich, dot, ngayphancong, NULL AS trangthai, NULL AS ngaybaove, NULL AS buoibaove, NULL AS chon
            FROM phancongdoan
            WHERE madetai = '$madt'
            UNION
            SELECT 'phancongkhoaluan' AS table_name, id, madetai, gvthuky, gvphanbien, chutich, dot, ngayphancong, trangthai, ngaybaove, buoibaove, chon    
            FROM phancongkhoaluan
            WHERE madetai = '$madt'
        ";
    }

    $result = mysqli_query($con, $sql);

    if (!$result) {
        echo json_encode(['error' => mysqli_error($con)]);
        exit;
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $currentTable = $row['table_name'] ?? ($loaidetai === "Khóa luận" ? 'phancongkhoaluan' : 'phancongdoan');

            // Lấy tên đề tài từ bảng 'detai'
            $detai_sql = "SELECT tendetai FROM detai WHERE madetai = '$madt'";
            $detai_result = mysqli_query($con, $detai_sql);

            if ($detai_result && mysqli_num_rows($detai_result) > 0) {
                $detai_row = mysqli_fetch_assoc($detai_result);
                $row['tendetai'] = $detai_row['tendetai'];
            } else {
                $row['tendetai'] = null;
            }

            // Thêm thông tin giảng viên
            $gvthuky = $row['gvthuky'] ?? null;
            $gvphanbien = $row['gvphanbien'] ?? null;
            $chutich = $row['chutich'] ?? null;

            $giangvien_sql = "
                SELECT 
                    (SELECT hoten FROM giangvien WHERE ma = '" . ($gvthuky ? mysqli_real_escape_string($con, $gvthuky) : "") . "') AS gvthuky_ten,
                    (SELECT hoten FROM giangvien WHERE ma = '" . ($gvphanbien ? mysqli_real_escape_string($con, $gvphanbien) : "") . "') AS gvphanbien_ten
            ";
            if ($currentTable === 'phancongkhoaluan') {
                $giangvien_sql .= ",
                    (SELECT hoten FROM giangvien WHERE ma = '" . ($chutich ? mysqli_real_escape_string($con, $chutich) : "") . "') AS chutich_ten
                ";
            }

            $giangvien_result = mysqli_query($con, $giangvien_sql);

            if ($giangvien_result && mysqli_num_rows($giangvien_result) > 0) {
                $giangvien_row = mysqli_fetch_assoc($giangvien_result);
                $row['gvthuky_ten'] = $giangvien_row['gvthuky_ten'] ?? 'N/A';
                $row['gvphanbien_ten'] = $giangvien_row['gvphanbien_ten'] ?? 'N/A';
                if ($currentTable === 'phancongkhoaluan') {
                    $row['chutich_ten'] = $giangvien_row['chutich_ten'] ?? 'N/A';
                }
            } else {
                $row['gvthuky_ten'] = 'N/A';
                $row['gvphanbien_ten'] = 'N/A';
                if ($currentTable === 'phancongkhoaluan') {
                    $row['chutich_ten'] = 'N/A';
                }
            }

            // Thêm dữ liệu vào mảng $data
            $data[] = [
                'table' => $currentTable,
                'data' => $row
            ];
        }
    } else {
        $data = ['error' => 'Không tìm thấy dữ liệu trong bảng'];
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(['error' => 'Không tìm thấy mã đề tài hợp lệ']);
}

mysqli_close($con);
