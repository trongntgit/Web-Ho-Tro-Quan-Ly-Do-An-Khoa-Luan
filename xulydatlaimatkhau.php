<?php
// Cấu hình cơ sở dữ liệu
$server = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($server, $user, $pass, $data, $port);

if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $token = $_POST['token'];

    // Kiểm tra xác nhận mật khẩu
    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Mật khẩu xác nhận không khớp!'); window.location.href = 'datlaimatkhau.php?token=$token';</script>";
        exit;
    }

    // Xác minh token và đặt lại mật khẩu
    $sql = "SELECT * FROM taikhoan2 WHERE token='$token' AND TIMESTAMPDIFF(MINUTE, ngaycapnhat, NOW()) <= 30";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Cập nhật mật khẩu (không mã hóa)
        $update = "UPDATE taikhoan2 SET mk='$newPassword', token=NULL WHERE token='$token'";
        if (mysqli_query($con, $update)) {
            echo "<script>alert('Mật khẩu đã được đặt lại thành công!'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Cập nhật mật khẩu thất bại!'); window.location.href = 'datlaimatkhau.php?token=$token';</script>";
        }
    } else {
        echo "<script>alert('Token không hợp lệ hoặc đã hết hạn!'); window.location.href = 'datlaimatkhau.php';</script>";
    }
}
?>
