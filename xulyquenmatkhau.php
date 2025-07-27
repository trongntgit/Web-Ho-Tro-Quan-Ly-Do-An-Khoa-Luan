<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

// Hàm gửi email
function sendResetEmail($email, $token) {
    $mail = new PHPMailer(true);
    try {
       // Cấu hình SMTP
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = '21004235@st.vlute.edu.vn'; // Email gửi
$mail->Password = 'ntt21092003gm'; // Mật khẩu email
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

// Thiết lập người gửi và người nhận
$mail->setFrom('21004235@st.vlute.edu.vn', 'Hệ thống quản lý đồ án, khóa luận');
$mail->addAddress($email);

// Thiết lập mã hóa UTF-8 cho cả tiêu đề và nội dung
$mail->CharSet = 'UTF-8';

// Nội dung email
$mail->isHTML(true);
$mail->Subject = 'Thông báo Xác nhận cấp lại mật khẩu';
$mail->Body = "
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            color: #B22222; /* Đỏ đậm */
            font-size: 24px;
            margin-bottom: 20px;
        }
        .email-body {
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #32CD32; /* Xanh lá */
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .button:hover {
            background-color: #228B22; /* Màu xanh lá đậm hơn khi hover */
        }
    </style>
</head>
<body>
    <div class='email-container'>
        <div class='email-header'>
            Xác nhận cấp lại mật khẩu
        </div>
        <div class='email-body'>
            <p>Chào bạn,</p>
            <p>Chúng tôi nhận thấy yêu cầu cấp lại mật khẩu cho tài khoản của bạn trong hệ thống. Để tiếp tục, vui lòng nhấp vào liên kết dưới đây để thiết lập lại mật khẩu của bạn:</p>
            <p><a href='http://localhost/Doan2/datlaimatkhau.php?token=$token' class='button'>Cấp lại mật khẩu</a></p>
            <p>Chúc bạn một ngày tốt lành!</p>
            <p>Trân trọng,<br>Hệ thống quản lý đồ án, khóa luận</p>
        </div>
    </div>
</body>
</html>
";



        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Xử lý yêu cầu quên mật khẩu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ma = $_POST['ma'];
    $email = $_POST['email'];

    // Kiểm tra trong các bảng
    $checkSinhVien = "SELECT * FROM sinhvien WHERE ma='$ma' AND email='$email'";
    $checkGiangVien = "SELECT * FROM giangvien WHERE ma='$ma' AND email='$email'";
    $checkQuanTri = "SELECT * FROM quantri WHERE ma='$ma' AND email='$email'";

    $resultSV = mysqli_query($con, $checkSinhVien);
    $resultGV = mysqli_query($con, $checkGiangVien);
    $resultQT = mysqli_query($con, $checkQuanTri);

    if (mysqli_num_rows($resultSV) > 0 || mysqli_num_rows($resultGV) > 0 || mysqli_num_rows($resultQT) > 0) {
        // Tạo token và lưu vào bảng taikhoan
        $token = bin2hex(random_bytes(16));
        $updateToken = "UPDATE taikhoan2 SET token='$token', ngaycapnhat=NOW() WHERE tentk='$ma'";
        if (mysqli_query($con, $updateToken)) {
            // Gửi email
            if (sendResetEmail($email, $token)) {
                echo "<script>alert('Email reset mật khẩu đã được gửi!'); window.location.href='quenmatkhau.php';</script>";
            } else {
                echo "<script>alert('Gửi email thất bại!'); window.location.href='quenmatkhau.php';</script>";
            }
        } else {
            echo "<script>alert('Cập nhật token thất bại!'); window.location.href='quenmatkhau.php';</script>";
        }
    } else {
        echo "<script>alert('Không tìm thấy mã người dùng hoặc email!'); window.location.href='quenmatkhau.php';</script>";
    }
}
?>
