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
    $hoten = $_POST['hotenQT'];
    $email = $_POST['emailQT'];
    $sdt = $_POST['sdtQT'];
    $diachi = $_POST['diachiQT'];

    // Lấy số lượng quản trị hiện tại để tạo mã mới
    $sql_count = "SELECT COUNT(*) AS total FROM quantri";
    $result = $conn->query($sql_count);
    $row = $result->fetch_assoc();
    $next_id = $row['total'] + 1;
    $maqt = "qt" . $next_id;

    // Thêm quản trị vào CSDL
    $sql = "INSERT INTO quantri (ma, hoten, email, sdt, diachi) 
            VALUES ('$maqt', '$hoten', '$email', '$sdt', '$diachi')";

    if ($conn->query($sql) === TRUE) {
        // Tạo tài khoản cho quản trị
        $tentk = $maqt;
        $matkhau = "1234";
        $quyen = "quantri";

        $sql_account = "INSERT INTO taikhoan2 (tentk, mk, quyen, maqt) 
                        VALUES ('$tentk', '$matkhau', '$quyen', '$maqt')";

        if ($conn->query($sql_account) === TRUE) {
            header("Location: quanlynguoidung.php?success=Quản trị và tài khoản đã được thêm thành công");
        } else {
            header("Location: quanlynguoidung.php?error=Lỗi khi tạo tài khoản cho quản trị: " . $conn->error);
        }
    } else {
        header("Location: quanlynguoidung.php?error=Lỗi khi thêm quản trị: " . $conn->error);
    }

    $conn->close();
}
?>
