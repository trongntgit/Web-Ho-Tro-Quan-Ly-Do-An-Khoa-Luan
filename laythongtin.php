<?php
session_start();

$server = "localhost";
$data = "Doan2";
$user = "root";
$pass = "";
$port = 3309;

// Kết nối đến cơ sở dữ liệu
$con = mysqli_connect($server, $user, $pass, $data, $port);
if (!$con) {
    die(json_encode(["error" => "Kết nối CSDL thất bại"]));
}

// Kiểm tra session có tồn tại
if (!isset($_SESSION['role']) || !isset($_SESSION['userid'])) {
    echo json_encode(["error" => "Chưa đăng nhập"]);
    exit();
}

$role = $_SESSION['role'];
$ma = $_SESSION['userid'];

// Lấy thông tin từ bảng tương ứng dựa trên role
if ($role == "quantri") {
    $sql2 = "SELECT HoTen, DiaChi, Email, SDT FROM quantri WHERE ma = '$ma'";
} elseif ($role == "sinhvien") {
    $sql2 = "SELECT HoTen, DiaChi, Email, SDT FROM sinhvien WHERE ma = '$ma'";
} else {
    $sql2 = "SELECT HoTen, DiaChi, Email, SDT FROM giangvien WHERE ma = '$ma'";
}

$result2 = mysqli_query($con, $sql2);

if ($result2 && mysqli_num_rows($result2) > 0) {
    $userRow = mysqli_fetch_assoc($result2);
    $userData = [
        'ma' => $ma,
        'hoten' => $userRow['HoTen'],
        'diachi' => $userRow['DiaChi'],
        'email' => $userRow['Email'],
        'sdt' => $userRow['SDT']
    ];
  

    echo json_encode($userData); // Trả về JSON
} else {
    echo json_encode(["error" => "Không tìm thấy thông tin người dùng"]);
}


mysqli_close($con);
?>
