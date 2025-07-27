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
$masv = isset($_POST['masv']) ? $_POST['masv'] : '';

$madt = "";
$ar_ma = explode("-", $query);




if (!empty($ar_ma)) {
    $madt = mysqli_real_escape_string($con, $ar_ma[0]);
    $data = [];
    $kt_sv = false; // Biến kiểm tra sinh viên có thuộc đề tài không

    if ($loaidetai === "Đồ án 1" || $loaidetai === "Đồ án 2") {
        $sql = "
            SELECT id, madetai, gvhd AS gvthuky, gvphanbien, dot, ngayphancong
            FROM phancongdoan
            WHERE madetai = '$madt'
        ";
    } elseif ($loaidetai === "Khóa luận") {
        $sql = "
            SELECT 
                'phancongkhoaluan' AS table_name, 
                pkl.id, pkl.madetai, pkl.gvthuky, pkl.gvphanbien, pkl.chutich, 
                pkl.dot, pkl.ngayphancong, pkl.trangthai, pkl.ngaybaove, 
                pkl.buoibaove, pkl.giobd, pkl.giokt, 
                bb.tenbuoi, bb.diadiem
            FROM phancongkhoaluan pkl
            LEFT JOIN buoibaove bb ON pkl.buoibaove = bb.id
            WHERE pkl.madetai = '$madt'
        ";
    } else {
        $sql = "
            SELECT 'phancongdoan' AS table_name, id, madetai, gvhd AS gvthuky, gvphanbien, NULL AS chutich, dot, ngayphancong, NULL AS trangthai, NULL AS ngaybaove, NULL AS buoibaove, NULL AS giobd, NULL AS giokt, NULL AS tenbuoi, NULL AS diadiem
            FROM phancongdoan
            WHERE madetai = '$madt'
            UNION
            SELECT 'phancongkhoaluan' AS table_name, 
                   pkl.id, pkl.madetai, pkl.gvthuky, pkl.gvphanbien, pkl.chutich, 
                   pkl.dot, pkl.ngayphancong, pkl.trangthai, pkl.ngaybaove, 
                   pkl.buoibaove, pkl.giobd, pkl.giokt, 
                   bb.tenbuoi, bb.diadiem
            FROM phancongkhoaluan pkl
            LEFT JOIN buoibaove bb ON pkl.buoibaove = bb.id
            WHERE pkl.madetai = '$madt'
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

            // Thêm thông tin giảng viên (mã và tên tách riêng)
            $gvthuky = $row['gvthuky'] ?? null;
            $gvphanbien = $row['gvphanbien'] ?? null;
            $chutich = $row['chutich'] ?? null;

            $giangvien_sql = "
                SELECT 
                    (SELECT ma FROM giangvien WHERE ma = '" . ($gvthuky ? mysqli_real_escape_string($con, $gvthuky) : "") . "') AS gvthuky_ma,
                    (SELECT hoten FROM giangvien WHERE ma = '" . ($gvthuky ? mysqli_real_escape_string($con, $gvthuky) : "") . "') AS gvthuky_ten,
                    (SELECT ma FROM giangvien WHERE ma = '" . ($gvphanbien ? mysqli_real_escape_string($con, $gvphanbien) : "") . "') AS gvphanbien_ma,
                    (SELECT hoten FROM giangvien WHERE ma = '" . ($gvphanbien ? mysqli_real_escape_string($con, $gvphanbien) : "") . "') AS gvphanbien_ten
            ";
            if ($currentTable === 'phancongkhoaluan') {
                $giangvien_sql .= ",
                    (SELECT ma FROM giangvien WHERE ma = '" . ($chutich ? mysqli_real_escape_string($con, $chutich) : "") . "') AS chutich_ma,
                    (SELECT hoten FROM giangvien WHERE ma = '" . ($chutich ? mysqli_real_escape_string($con, $chutich) : "") . "') AS chutich_ten
                ";
            }

            $giangvien_result = mysqli_query($con, $giangvien_sql);

            if ($giangvien_result && mysqli_num_rows($giangvien_result) > 0) {
                $giangvien_row = mysqli_fetch_assoc($giangvien_result);
                $row['gvthuky_ma'] = $giangvien_row['gvthuky_ma'] ?? null;
                $row['gvthuky_ten'] = $giangvien_row['gvthuky_ten'] ?? 'N/A';
                $row['gvphanbien_ma'] = $giangvien_row['gvphanbien_ma'] ?? null;
                $row['gvphanbien_ten'] = $giangvien_row['gvphanbien_ten'] ?? 'N/A';
                if ($currentTable === 'phancongkhoaluan') {
                    $row['chutich_ma'] = $giangvien_row['chutich_ma'] ?? null;
                    $row['chutich_ten'] = $giangvien_row['chutich_ten'] ?? 'N/A';
                }
            }

            // Kiểm tra sinh viên có thuộc đề tài không
            $check_sv_sql = "
            SELECT d.madetai 
            FROM dangkydetai d
            INNER JOIN detai t ON d.madetai = t.madetai
            WHERE d.masv = '$masv' AND d.madetai = '$madt' AND (t.trangthai = 'Đang thực hiện' OR t.trangthai = 'Hoàn thành')
            ";
            $check_sv_result = mysqli_query($con, $check_sv_sql);

            if (mysqli_num_rows($check_sv_result) > 0) {
            $kt_sv = true;
            }

            // Kiểm tra xem đề tài đã có kết quả công bố hay chưa
            $check_ketqua_sql = "
            SELECT diemgvhd, diemgvpb, diemchutich 
            FROM ketqua 
            WHERE madetai = '$madt' AND trangthai = 'Công bố'
            ";
            $check_ketqua_result = mysqli_query($con, $check_ketqua_sql);

            $ketqua_data = null;
            if (mysqli_num_rows($check_ketqua_result) > 0) {
            $ketqua_data = mysqli_fetch_assoc($check_ketqua_result);
            }

            // Thêm dữ liệu vào mảng $data
            $data[] = [
                'table' => $currentTable,
                'data' => $row,
                'kt_sv' => $kt_sv,
                'ketqua' => $ketqua_data
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
?>
