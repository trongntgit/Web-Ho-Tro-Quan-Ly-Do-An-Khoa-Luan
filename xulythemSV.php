<?php
session_start();
$sever = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$conn = mysqli_connect($sever, $user, $pass, $data, $port);

if (!$conn) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoten = $_POST['hotenSV'];
    $lop = $_POST['lopSV'];
    $diemtichluy = $_POST['diemSV'];
    $email = $_POST['emailSV'];
    $sdt = $_POST['sdtSV'];
    $diachi = $_POST['diachiSV'];
    $khoa = $_POST['khoaSV'];

    // Lấy số lượng sinh viên hiện tại để tạo mã mới
    $sql_count = "SELECT COUNT(*) AS total FROM sinhvien";
    $result = $conn->query($sql_count);
    $row = $result->fetch_assoc();
    $next_id = $row['total'] + 1;
    $masv = "sv" . $next_id;

    // Thêm sinh viên vào CSDL
    $sql = "INSERT INTO sinhvien (ma, hoten, lop, diemtichluy, email, sdt, diachi,khoa) 
            VALUES ('$masv', '$hoten', '$lop', '$diemtichluy', '$email', '$sdt', '$diachi','$khoa')";

    if ($conn->query($sql) === TRUE) {
        // Tạo tài khoản cho sinh viên
        $tentk = $masv;
        $matkhau = "1234";
        $quyen = "sinhvien";

        $sql_account = "INSERT INTO taikhoan2 (tentk, mk, quyen, masv) 
                        VALUES ('$tentk', '$matkhau', '$quyen', '$masv')";

        if ($conn->query($sql_account) === TRUE) {
            header("Location: quanlynguoidung.php?success=Sinh viên và tài khoản đã được thêm thành công");
        } else {
            header("Location: quanlynguoidung.php?error=Lỗi khi tạo tài khoản cho sinh viên: " . $conn->error);
        }
    } else {
        header("Location: quanlynguoidung.php?error=Lỗi khi thêm sinh viên: " . $conn->error);
    }

    $conn->close();
}
?>
