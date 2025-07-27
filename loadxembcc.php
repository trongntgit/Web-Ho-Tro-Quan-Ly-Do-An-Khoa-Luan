<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

$server = "localhost";
$database = "qlnv";
$user = "root";
$password = "";
$port = 3309;
$con = mysqli_connect($server, $user, $password, $database, $port);

if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

// Nhận dữ liệu từ POST request
$mabcc = $_POST['mabcc'];
$matk = $_SESSION['matk'];

// Truy xuất thông tin mã nhân viên dựa trên mã tài khoản (matk)
$sql_get_manv = "SELECT manv FROM nhanvien WHERE matk = '$matk'";
$result_get_manv = $con->query($sql_get_manv);

if ($result_get_manv->num_rows > 0) {
    $row = $result_get_manv->fetch_assoc();
    $ma_nhan_vien = $row['manv'];

    // Sau khi lấy được mã nhân viên, thực hiện truy vấn để lấy dữ liệu chấm công
    $sql = "SELECT chamcong.manv, chamcong.hoten AS ten_sv, bangchamcong.tenbcc, bangchamcong.mabcc, chamcong.ttchamconng, chamcong.ngaycc
            FROM chamcong
            JOIN bangchamcong ON chamcong.mabcc = bangchamcong.mabcc
            WHERE chamcong.manv = '$ma_nhan_vien' AND chamcong.mabcc = '$mabcc' AND ttchamconng IN ('Có', 'Vắng', 'Trễ')";
    
    $result = $con->query($sql);

    $attendanceData = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $attendanceData[] = $row;
        }
    }
} else {
    $attendanceData = array('error' => 'Không tìm thấy mã nhân viên cho mã tài khoản này.');
}

$con->close();

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($attendanceData);
?>
