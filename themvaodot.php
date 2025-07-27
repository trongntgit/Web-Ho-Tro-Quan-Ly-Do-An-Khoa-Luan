<?php
// Hiển thị lỗi trong quá trình debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Đảm bảo trả về JSON
header("Content-Type: application/json; charset=UTF-8");

session_start(); // Bắt đầu phiên làm việc

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error]);
    exit();
}

try {
    // Đọc dữ liệu từ Fetch API
    $data = json_decode(file_get_contents("php://input"), true);

    // Ghi log dữ liệu nhận được để debug
    error_log("Dữ liệu nhận được: " . json_encode($data));

    // Kiểm tra dữ liệu đầu vào
    $id_dot = $data["id_dot"] ?? null;
    $sinhvien = $data["sinhvien"] ?? [];
    $detai = $data["detai"] ?? [];

    if (!$id_dot || empty($sinhvien) || empty($detai)) {
        echo json_encode(["success" => false, "message" => "Thiếu thông tin cần thiết."]);
        exit();
    }

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    // Thêm sinh viên vào đợt
    $stmt_sv = $conn->prepare("INSERT INTO dotdangky_sinhvien (id_dotdk, masv) VALUES (?, ?)");
    if (!$stmt_sv) {
        throw new Exception("Lỗi chuẩn bị truy vấn (Sinh viên): " . $conn->error);
    }

    foreach ($sinhvien as $sv) {
        $stmt_sv->bind_param("is", $id_dot, $sv);
        $stmt_sv->execute();
    }

    // Thêm đề tài vào đợt
    $stmt_dt = $conn->prepare("INSERT INTO dotdangky_detai (id_dotdk, madetai) VALUES (?, ?)");
    if (!$stmt_dt) {
        throw new Exception("Lỗi chuẩn bị truy vấn (Đề tài): " . $conn->error);
    }

    foreach ($detai as $dt) {
        $stmt_dt->bind_param("is", $id_dot, $dt);
        $stmt_dt->execute();
    }

    // Commit giao dịch
    $conn->commit();

    // Đóng kết nối
    $stmt_sv->close();
    $stmt_dt->close();
    $conn->close();

    echo json_encode(["success" => true, "message" => "Gán thành công!"]);

} catch (Exception $e) {
    // Nếu có lỗi, rollback và trả về lỗi
    if ($conn->in_transaction) {
        $conn->rollback();
    }
    error_log("Lỗi: " . $e->getMessage()); // Ghi log lỗi chi tiết
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    $conn->close();
}
?>
