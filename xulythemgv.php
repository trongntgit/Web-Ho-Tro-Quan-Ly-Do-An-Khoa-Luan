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
    $hoten = $_POST['hoten'];
    $trinhdo = $_POST['trinhdo'];
    $chucvu = $_POST['chucvu'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $diachi = $_POST['diachi'];
    $chuyenmon = $_POST['chuyenmon'];

    // Lấy số lượng giảng viên hiện tại để tạo mã mới
    $sql_count = "SELECT COUNT(*) AS total FROM giangvien";
    $result = $conn->query($sql_count);
    $row = $result->fetch_assoc();
    $next_id = $row['total'] + 1;
    $magv = "gv" . $next_id;

    // Thêm giảng viên vào CSDL
    $sql = "INSERT INTO giangvien (ma, hoten, trinhdo, chucvu, email, sdt, diachi, chuyenmon) 
            VALUES ('$magv', '$hoten', '$trinhdo', '$chucvu', '$email', '$sdt', '$diachi','$chuyenmon')";

    if ($conn->query($sql) === TRUE) {
        // Xác định quyền dựa trên chức vụ
        $quyen = '';
        if ($chucvu == 'Giảng viên' || $chucvu == 'Trưởng bộ môn' || $chucvu == 'Trợ giảng' ) {
            $quyen = 'giangvien';
        } else if ($chucvu == 'Giáo vụ') {
            $quyen = 'giaovu';
        } else if ($chucvu == 'Trưởng khoa') {
            $quyen = 'lanhdao';
        } 

        // Thêm tài khoản vào bảng taikhoan2
        $tentk = $magv;
        $matkhau = "1234";
        $sql_taikhoan = "INSERT INTO taikhoan2 (tentk, mk, quyen, magv) 
                         VALUES ('$tentk', '$matkhau', '$quyen', '$magv')";

        if ($conn->query($sql_taikhoan) === TRUE) {
            header("Location: index.php?success=Giảng viên và tài khoản đã được thêm thành công");
        } else {
            header("Location: index.php?error=Lỗi khi thêm tài khoản: " . $conn->error);
        }
    } else {
        header("Location: index.php?error=Lỗi khi thêm giảng viên: " . $conn->error);
    }

    $conn->close();
}
?>
