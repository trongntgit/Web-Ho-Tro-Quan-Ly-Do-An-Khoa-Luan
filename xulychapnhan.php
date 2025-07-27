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

    $response = [];

    // Chấp nhận đề tài cho sinh viên
    $query = "UPDATE dangkydetai SET trangthai='Chấp nhận' WHERE madetai = ? AND masv = ? AND dotdangky = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssi", $madetai, $masv, $dot);
    $stmt->execute();

    // Lấy danh sách mã đề tài bị hủy bỏ
    $query_select = "SELECT madetai FROM dangkydetai WHERE madetai != ? AND masv = ? AND dotdangky = ? AND trangthai != 'Hủy bỏ'";
    $stmt_select = $con->prepare($query_select);
    $stmt_select->bind_param("ssi", $madetai, $masv, $dot);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $huy_madetai_list = [];
    while ($row = $result->fetch_assoc()) {
        $huy_madetai_list[] = $row['madetai'];
    }

    // Hủy bỏ các đăng ký khác của sinh viên
    $query2 = "UPDATE dangkydetai SET trangthai='Hủy bỏ' WHERE madetai != ? AND masv = ? AND dotdangky = ?";
    $stmt2 = $con->prepare($query2);
    $stmt2->bind_param("ssi", $madetai, $masv, $dot);
    $stmt2->execute();

    // Giảm số lượng đăng ký (soluongdk) cho các mã đề tài bị hủy
    foreach ($huy_madetai_list as $huy_madetai) {
        $query_update_detai = "UPDATE detai SET soluongdk = soluongdk - 1 WHERE madetai = ?";
        $stmt3 = $con->prepare($query_update_detai);
        $stmt3->bind_param("s", $huy_madetai);
        $stmt3->execute();
    }

    if ($stmt->affected_rows > 0 || $stmt2->affected_rows > 0) {
        $response['success'] = true;
        $response['message'] = "Cập nhật thành công.";
    } else {
        $response['success'] = false;
        $response['message'] = "Không thể loại bỏ sinh viên.";
    }

    echo json_encode($response);
}
?>
