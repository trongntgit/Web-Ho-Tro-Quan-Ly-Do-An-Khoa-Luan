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
$phieudiem_id = $requestData['phieudiem_id'];
$diem = $requestData['diem'];
$nhanxet = $requestData['nhanxet'];

// Kiểm tra dữ liệu đầu vào
if (empty($phieudiem_id) || !isset($diem)) {
    echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ"]);
    exit;
}

// Thực hiện truy vấn cập nhật
$sql = "UPDATE phieudiem SET diem = ?, nhanxet = ?, ngaycham = NOW() WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("isi", $diem, $nhanxet, $phieudiem_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi khi cập nhật dữ liệu: " . $stmt->error]);
}

$stmt->close();
mysqli_close($con);
?>
