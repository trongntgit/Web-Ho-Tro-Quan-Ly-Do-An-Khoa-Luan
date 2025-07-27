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
$lop = $_POST['lop'];
$diem = $_POST['diem'];
$email = $_POST['email'];
$sdt = $_POST['sdt'];
$diachi = $_POST['diachi'];
$khoa= $_POST['khoa'];

// Cập nhật thông tin sinh viên
$sql = "UPDATE sinhvien 
        SET hoten = ?, 
           lop = ?, 
            diemtichluy = ?, 
            email = ?, 
            sdt = ?, 
            diachi = ? ,
            khoa = ? 
        WHERE ma = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("ssssssss", $hoten, $lop, $diem, $email, $sdt, $diachi, $khoa,$ma);

if ($stmt->execute()) {
    echo "Cập nhật thành công!";
} else {
    echo "Lỗi khi cập nhật: " . $con->error;
}

// Đóng kết nối
$stmt->close();
$con->close();
?>
