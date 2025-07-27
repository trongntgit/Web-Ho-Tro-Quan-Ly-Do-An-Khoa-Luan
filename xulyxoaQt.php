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

// Xóa dòng tương ứng trong bảng `quantri`
$sql_qt = "DELETE FROM quantri WHERE ma = ?";
$stmt_qt = $con->prepare($sql_qt);
$stmt_qt->bind_param("s", $ma);

// Xóa tài khoản liên kết trong bảng `taikhoan2`
$sql_tk = "DELETE FROM taikhoan2 WHERE maqt = ?";
$stmt_tk = $con->prepare($sql_tk);
$stmt_tk->bind_param("s", $ma);

// Thực hiện xóa
if ($stmt_qt->execute() && $stmt_tk->execute()) {
    echo "Xóa quản trị và tài khoản thành công!";
} else {
    echo "Lỗi khi xóa: " . $con->error;
}

// Đóng kết nối
$stmt_qt->close();
$stmt_tk->close();
$con->close();
?>
