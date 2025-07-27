<?php
session_start();

$server = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;

$con = mysqli_connect($server, $user, $pass, $data, $port);

if (!$con) {
    die(json_encode(["success" => false, "message" => "Kết nối CSDL thất bại"]));
}

$input = json_decode(file_get_contents("php://input"), true);
$madetai = $input['madetai'];
$startTime = $input['startTime'];
$endTime = $input['endTime'];
$ngay = $input['ngay'];

$updateQuery = "
    UPDATE phancongkhoaluan
    SET giobd = ?, giokt = ?, ngaybaove = ?
    WHERE madetai = ?
";
$stmt = $con->prepare($updateQuery);
$stmt->bind_param("ssss", $startTime, $endTime, $ngay, $madetai);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Cập nhật thành công"]);
} else {
    echo json_encode(["success" => false, "message" => "Cập nhật thất bại"]);
}
?>
