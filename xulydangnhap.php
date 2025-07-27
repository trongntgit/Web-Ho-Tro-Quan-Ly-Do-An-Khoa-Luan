<?php
$sever = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;

$con = mysqli_connect($sever, $user, $pass, $data, $port);
if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

$ten = $_POST["tentk"];
$mk = $_POST["mk"];

if (!$ten || !$mk) {
    echo "<script>alert('Vui lòng nhập đầy đủ thông tin.'); window.location.href='login.php';</script>";
    exit();
}

// Escaping special characters for SQL injection prevention
$ten = mysqli_real_escape_string($con, $ten);
$mk = mysqli_real_escape_string($con, $mk);

$sql = "SELECT * FROM taikhoan2 WHERE tentk = '$ten' AND mk = '$mk' AND trangthai = 'Hoạt động'";
$kq = mysqli_query($con, $sql);
$hoten="";
$email="";

if ($kq) {
    if (mysqli_num_rows($kq) > 0) {
        $row = mysqli_fetch_assoc($kq);
        $role = $row['quyen'];
        $maqt = $row['maqt'];
        $magv = $row['magv'];
        $masv = $row['masv'];
        
        $ma = "";
        if ($maqt !== null) {
            $ma = $maqt;
        } elseif ($magv !== null) {
            $ma = $magv;
        } elseif ($masv !== null) {
            $ma = $masv;
        }
        

        // Check the role and retrieve information from the respective table
        if ($role == "quantri") {
            // For administrators, retrieve from 'quantri' table
            $sql2 = "SELECT * FROM quantri WHERE ma = '$ma'";
        } elseif ($role == "sinhvien") {
            // For students, retrieve from 'sinhvien' table
            $sql2 = "SELECT * FROM sinhvien WHERE ma = '$ma'";
        } else {
            // For other roles (assume 'giangvien'), retrieve from 'giangvien' table
            $sql2 = "SELECT * FROM giangvien WHERE ma = '$ma'";
        }

        $result2 = mysqli_query($con, $sql2);

        if ($result2 && mysqli_num_rows($result2) > 0) {
            $userRow = mysqli_fetch_assoc($result2);
            $hoten = $userRow['hoten'];
            $email = $userRow['email'];
        } else {
            echo "<script>alert('Không tìm thấy thông tin người dùng.'); window.location.href='login.php';</script>";
            exit();
        }

        $matk = $row['matk'];
        session_start();
        $_SESSION['username'] = $hoten;
        $_SESSION['role'] = $role;
        $_SESSION['matk'] = $matk;
        $_SESSION['userid'] = $ma;


        echo "<script>
            console.log('User Role: $role');
            console.log('Username: $hoten');
            console.log('User ID: $matk');
            localStorage.setItem('quyen', '" . $_SESSION['role'] . "');
            localStorage.setItem('email', '$email');
            localStorage.setItem('hoten', '$hoten');
            localStorage.setItem('ma', '$ma');
            
            window.location.href = 'index.php'; // Change this to your target page
        </script>";
        exit();
    } else {
        echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu.'); window.location.href='login.php';</script>";
        exit();
    }
} else {
    die("Lỗi truy vấn: " . mysqli_error($con));
}

mysqli_close($con);
?>
