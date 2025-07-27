<?php
// Kết nối CSDL
$sever = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;

$con = mysqli_connect($sever, $user, $pass, $data, $port);

// Kiểm tra kết nối
if (!$con) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Lấy dữ liệu từ form
$ma = $_POST['ma'];
$quyen = $_POST['quyen'];
$mk = $_POST['mk'];
$trangthai = $_POST['tt'];


// Cập nhật thông tin sinh viên
$sql = "UPDATE taikhoan2
        SET quyen = ?, 
           mk = ?, 
            trangthai = ?
        WHERE matk = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("ssss", $quyen, $mk, $trangthai, $ma);

if ($stmt->execute()) {
    echo "Cập nhật thành công!";
} else {
    echo "Lỗi khi cập nhật: " . $con->error;
}

// Đóng kết nối
$stmt->close();
$con->close();
?>
