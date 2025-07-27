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

// Lấy mã cần xóa
$ma = $_POST['ma'];

// Xóa dòng tương ứng trong bảng `giangvien`
$sql_gv = "DELETE FROM giangvien WHERE ma = ?";
$stmt_gv = $con->prepare($sql_gv);
$stmt_gv->bind_param("s", $ma);

// Xóa tài khoản liên kết trong bảng `taikhoan2`
$sql_tk = "DELETE FROM taikhoan2 WHERE magv = ?";
$stmt_tk = $con->prepare($sql_tk);
$stmt_tk->bind_param("s", $ma);

// Thực hiện xóa
if ($stmt_gv->execute() && $stmt_tk->execute()) {
    echo "Xóa giảng viên và tài khoản thành công!";
} else {
    echo "Lỗi khi xóa: " . $con->error;
}

// Đóng kết nối
$stmt_gv->close();
$stmt_tk->close();
$con->close();
?>
