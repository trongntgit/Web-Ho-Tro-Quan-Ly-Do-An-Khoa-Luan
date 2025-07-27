<?php
session_start();
$sever = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($sever, $user, $pass, $data, $port);
if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

$matk = $_SESSION['matk']; 
$mk = $_POST["mk"];
$mk_moi = $_POST["mk_conf"];
$mk_conf = $_POST["mk_conf2"];

if (!$mk || !$mk_moi || !$mk_conf) {
    echo "<script>alert('Vui lòng nhập đầy đủ thông tin.'); window.location.href='changepw.php';</script>";
    exit();
}

if ($mk_moi != $mk_conf) {
    echo "<script>alert('Xác nhận mật khẩu không đúng.'); window.location.href='changepw.php';</script>";
    exit();
}

// Kiểm tra sự tồn tại của tên tài khoản và mật khẩu hiện tại
$kiem_tra_sql = "SELECT * FROM taikhoan2 WHERE matk = '$matk' AND mk = '$mk'";
$kiem_tra_kq = mysqli_query($con, $kiem_tra_sql);

if (mysqli_num_rows($kiem_tra_kq) > 0) {
    // Tên tài khoản và mật khẩu đúng, tiến hành câu lệnh UPDATE
    $sql = "UPDATE taikhoan2 SET mk='$mk_conf' WHERE matk = '$matk' AND mk = '$mk'";
    $kq = mysqli_query($con, $sql);

    if ($kq) {
        echo "<script>alert('Đổi mật khẩu thành công.'); window.location.href='index.php';</script>";
        exit();
    } else {
        die("Lỗi truy vấn UPDATE: " . mysqli_error($con));
    }
} else {
    echo "<script>alert('Mật khẩu không đúng.'); window.location.href='changepw.php';</script>";
    exit();
}

mysqli_close($con);
?>
