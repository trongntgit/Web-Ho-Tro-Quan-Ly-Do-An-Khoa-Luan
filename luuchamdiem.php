<?php
$sever = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($sever, $user, $pass, $data, $port);

if (!$con) {
    die(json_encode(["success" => false, "message" => "Kết nối CSDL thất bại"]));
}

// Nhận dữ liệu JSON từ AJAX
$requestData = json_decode(file_get_contents("php://input"), true);
$magv = $requestData['magv'];
$madetai = $requestData['madetai'];
$diem = $requestData['diem'];
$nhanxet = $requestData['nhanxet'];
$vaitro =  $requestData['vaitro'];

// Kiểm tra dữ liệu trước khi lưu
if (empty($magv) || empty($madetai) || !isset($diem)) {
    echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ"]);
    exit;
}

// Thực hiện truy vấn thêm dữ liệu vào bảng `phieudiem`
$sql = "INSERT INTO phieudiem (magv, madetai, diem, nhanxet, ngaycham,vaitro) 
        VALUES ('$magv', '$madetai', $diem, '$nhanxet', NOW(), '$vaitro')";

if (mysqli_query($con, $sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi khi thêm dữ liệu: " . mysqli_error($con)]);
}

mysqli_close($con);
?>
