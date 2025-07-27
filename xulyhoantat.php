<?php
$sever = "localhost";
$data = "qlnv";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($sever, $user, $pass, $data, $port);
if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

// Lấy dữ liệu từ request
$masv = $_POST['manv'];
$malop = $_POST['mabcc'];
$hoten =$_POST['hoten'];
$ngaydd = $_POST['ngaydd'];
$giodd = $_POST['giodd'];
$trangthaidd = $_POST['trangthaidd'];

// Đảm bảo định dạng ngàydd đúng (ví dụ: 'YYYY-MM-DD')
$ngaydd = date('Y-m-d', strtotime($ngaydd));

// Thực hiện truy vấn để chèn dữ liệu mới vào CSDL
$sql = "INSERT INTO chamcong (manv, mabcc, ngaycc, giocc, ttchamconng,hoten) VALUES ('$masv', '$malop', '$ngaydd', '$giodd', '$trangthaidd','$hoten')";
$result = mysqli_query($con, $sql);

// Kiểm tra và trả kết quả
if ($result === TRUE) {
    echo "Đã chèn dữ liệu điểm danh mới thành công";
} else {
    echo "Lỗi: " . $sql . "<br>" . mysqli_error($con);
}

// Đóng kết nối CSDL
mysqli_close($con);
?>
