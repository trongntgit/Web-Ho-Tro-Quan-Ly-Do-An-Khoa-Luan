<?php
session_start();
$sever = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($sever, $user, $pass, $data, $port);

if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

$query = isset($_POST['madetai']) ? $_POST['madetai'] : '';
$madt = "";
$ar_ma = explode("-", $query); // Dùng explode thay vì split

if(!empty($ar_ma)){
    $madt = $ar_ma[0];

    // Thực hiện truy vấn SQL
    $sql = "SELECT * FROM detai WHERE madetai = '$madt' AND duyetlanhdao = 'Được duyệt'";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        echo json_encode(['error' => mysqli_error($con)]);
        exit;
    }

    $data = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row; 
        }
    }

    // Trả về JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Không tìm thấy mã đề tài hợp lệ']);
}

mysqli_close($con);
?>
