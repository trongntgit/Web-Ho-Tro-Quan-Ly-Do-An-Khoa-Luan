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
if (isset($data['madetai']) && isset($data['masv'])) {
    $madetai = $data['madetai'];
    $masv = $data['masv'];
    $dot = $data['dotdangky'];

    // Thực hiện xóa sinh viên khỏi đăng ký đề tài
    $query = "UPDATE dangkydetai SET trangthai='Bị loại' WHERE madetai = ? AND masv = ? AND dotdangky = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssi", $madetai, $masv,$dot);
    $response = [];

    if ($stmt->execute()) {
        // Nếu xóa thành công, giảm 1 vào cột soluongdk của bảng detai
        $updateQuery = "UPDATE detai SET soluongdk = soluongdk - 1 WHERE madetai = ?";
        $updateStmt = $con->prepare($updateQuery);
        $updateStmt->bind_param("s", $madetai);
        $updateStmt->execute();

        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['message'] = "Không thể loại bỏ sinh viên.";
    }
    
    echo json_encode($response);
}
?>

