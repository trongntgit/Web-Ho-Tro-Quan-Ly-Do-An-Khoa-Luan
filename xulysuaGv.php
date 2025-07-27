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
$trinhdo = $_POST['trinhdo'];
$chucvu = $_POST['chucvu'];
$email = $_POST['email'];
$sdt = $_POST['sdt'];
$diachi = $_POST['diachi'];

// Cập nhật thông tin giảng viên
$sql = "UPDATE giangvien 
        SET hoten = ?, 
            trinhdo = ?, 
            chucvu = ?, 
            email = ?, 
            sdt = ?, 
            diachi = ? 
        WHERE ma = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("sssssss", $hoten, $trinhdo, $chucvu, $email, $sdt, $diachi, $ma);

if ($stmt->execute()) {
    echo "Cập nhật thành công!";
} else {
    echo "Lỗi khi cập nhật: " . $con->error;
}

// Đóng kết nối
$stmt->close();
$con->close();
?>
