<?php
header('Content-Type: application/json');

// Kết nối cơ sở dữ liệu
$server = "localhost";
$database = "doan2";
$user = "root";
$password = "";
$port = 3309;

$con = mysqli_connect($server, $user, $password, $database, $port);

if (!$con) {
    die(json_encode(['success' => false, 'message' => 'Kết nối CSDL thất bại: ' . mysqli_connect_error()]));
}

// Lấy dữ liệu từ request
$tenbuoi = $_POST['tenbuoi'] ?? '';
$diadiem = $_POST['diadiem'] ?? '';
$thuky = $_POST['thuky-buoi'] ?? '';
$ngay = $_POST['ngay'] ?? '';
$hocky = $_POST['hocky-buoi'] ?? '';
$thoigianbatdau = $_POST['thoigianbatdau'] ?? '';
$thoigianketthuc = $_POST['thoigianketthuc'] ?? '';

// Kiểm tra dữ liệu đầu vào
if (empty($tenbuoi) || empty($diadiem) || empty($thuky) || empty($ngay) || empty($hocky) || empty($thoigianbatdau) || empty($thoigianketthuc)) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin.']);
    exit;
}

// Kiểm tra trùng lịch theo khoảng thời gian chồng chéo chính xác
$sql_check = "SELECT * FROM buoibaove WHERE (DiaDiem = ? OR ThuKy = ?) AND Ngay = ? 
    AND (
        (ThoiGianBatDau < ? AND ThoiGianKetThuc > ?) 
        OR (ThoiGianBatDau < ? AND ThoiGianKetThuc > ?)
        OR (? < ThoiGianBatDau AND ? > ThoiGianKetThuc)
    )";
$stmt_check = $con->prepare($sql_check);

if ($stmt_check) {
    $stmt_check->bind_param("ssssssss", $diadiem, $thuky, $ngay, $thoigianketthuc, $thoigianbatdau, $thoigianketthuc, $thoigianbatdau, $thoigianbatdau, $thoigianketthuc);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Đã có buổi bảo vệ trùng lịch trong khoảng thời gian này.']);
        $stmt_check->close();
        mysqli_close($con);
        exit;
    }
    $stmt_check->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị câu lệnh kiểm tra: ' . $con->error]);
    mysqli_close($con);
    exit;
}

// Thêm buổi bảo vệ mới
$sql_insert = "INSERT INTO buoibaove (TenBuoi, DiaDiem, ThuKy, Ngay, HocKy, ThoiGianBatDau, ThoiGianKetThuc) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt_insert = $con->prepare($sql_insert);

if ($stmt_insert) {
    $stmt_insert->bind_param("ssssiis", $tenbuoi, $diadiem, $thuky, $ngay, $hocky, $thoigianbatdau, $thoigianketthuc);
    if ($stmt_insert->execute()) {
        echo json_encode(['success' => true, 'message' => 'Thêm buổi bảo vệ thành công.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi khi thêm buổi bảo vệ: ' . $stmt_insert->error]);
    }
    $stmt_insert->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi chuẩn bị câu lệnh SQL: ' . $con->error]);
}

// Đóng kết nối
mysqli_close($con);
?>
