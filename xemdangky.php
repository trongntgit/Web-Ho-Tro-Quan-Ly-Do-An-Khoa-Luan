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

// Nhận dữ liệu từ yêu cầu
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['madetai'])) { // Kiểm tra xem 'madetai' có tồn tại không
    $madetai = $data['madetai'];

    // Lấy danh sách sinh viên đã đăng ký cho đề tài và hoten từ bảng sinhvien
    $query = "
        SELECT d.masv, s.hoten, d.ngaydangky, s.diemtichluy, d.quantri, d.dotdangky, d.trangthai
        FROM dangkydetai d
        JOIN sinhvien s ON d.masv = s.ma
        WHERE d.madetai = ? AND (d.trangthai = 'Chờ duyệt' or d.trangthai = 'Chấp nhận')
    ";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $madetai);
    $stmt->execute();
    $result = $stmt->get_result();

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row; // Thêm sinh viên vào mảng
    }

    echo json_encode($students); // Trả về danh sách sinh viên dưới dạng JSON
} else {
    echo json_encode([]); // Nếu không có 'madetai', trả về mảng rỗng
}
?>
