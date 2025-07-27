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
$hoten = $_POST['hoten'];
$email = $_POST['email'];
$sdt = $_POST['sdt'];
$diachi = $_POST['diachi'];

// Cập nhật thông tin sinh viên
$sql = "UPDATE quantri 
        SET hoten = ?, 
            email = ?, 
            sdt = ?, 
            diachi = ? 
        WHERE ma = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("sssss", $hoten, $email, $sdt, $diachi, $ma);

if ($stmt->execute()) {
    echo "Cập nhật thành công!";
} else {
    echo "Lỗi khi cập nhật: " . $con->error;
}

// Đóng kết nối
$stmt->close();
$con->close();
?>
