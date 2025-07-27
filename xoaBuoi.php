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
    echo json_encode(["status" => "error", "message" => "Kết nối CSDL thất bại: " . mysqli_connect_error()]);
    exit;
}

// Lấy dữ liệu từ yêu cầu POST
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id'])) {
    echo json_encode(["status" => "error", "message" => "ID không hợp lệ."]);
    exit;
}

$id = intval($data['id']);

// Xóa buổi bảo vệ
$sqlDelete = "DELETE FROM buoibaove WHERE id = ?";
$stmtDelete = mysqli_prepare($con, $sqlDelete);

if ($stmtDelete) {
    mysqli_stmt_bind_param($stmtDelete, "i", $id);
    if (mysqli_stmt_execute($stmtDelete)) {
        $deleteMessage = "Buổi đã được xóa thành công.";

        // Cập nhật bảng phancongkhoaluan
        $sqlUpdate = "
            UPDATE phancongkhoaluan
            SET ngaybaove = NULL, giobd = NULL, giokt = NULL, buoibaove = 0, chon ='Chưa chọn'
            WHERE buoibaove = ?
        ";
        $stmtUpdate = mysqli_prepare($con, $sqlUpdate);

        if ($stmtUpdate) {
            mysqli_stmt_bind_param($stmtUpdate, "i", $id);
            if (mysqli_stmt_execute($stmtUpdate)) {
                echo json_encode([
                    "status" => "success",
                    "message" => $deleteMessage . " Các đề tài liên quan đã được cập nhật thành công."
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Không thể cập nhật các đề tài liên quan: " . mysqli_error($con)
                ]);
            }
            mysqli_stmt_close($stmtUpdate);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Lỗi chuẩn bị truy vấn cập nhật: " . mysqli_error($con)
            ]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Không thể xóa buổi: " . mysqli_error($con)]);
    }
    mysqli_stmt_close($stmtDelete);
} else {
    echo json_encode(["status" => "error", "message" => "Lỗi chuẩn bị truy vấn xóa: " . mysqli_error($con)]);
}

mysqli_close($con);
?>
