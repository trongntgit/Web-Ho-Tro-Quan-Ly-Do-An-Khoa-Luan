<?php
// Hiển thị lỗi trong quá trình debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error]);
    exit();
}

// Nhận id_dotdangky từ yêu cầu
$id_dot = isset($_GET['id_dotdangky']) ? (int)$_GET['id_dotdangky'] : null;
if (!$id_dot) {
    echo json_encode(["success" => false, "message" => "Thiếu thông tin đợt đăng ký."]);
    exit();
}

try {
    // Truy vấn lấy danh sách sinh viên trong đợt đăng ký từ bảng dotdangky_sinhvien
    $stmt = $conn->prepare("
        SELECT sv.ma, sv.hoten, sv.lop
        FROM sinhvien sv
        WHERE sv.ma IN (
            SELECT masv
            FROM dotdangky_sinhvien
            WHERE id_dotdk = ?
        )
    ");

    // Truyền tham số id_dot
    $stmt->bind_param("i", $id_dot);
    $stmt->execute();
    $result = $stmt->get_result();

    $sinhvien = [];
    while ($row = $result->fetch_assoc()) {
        // Kiểm tra trạng thái đăng ký của từng sinh viên
        $stmt2 = $conn->prepare("
            SELECT trangthai
            FROM dangkydetai
            WHERE masv = ? AND dotdangky = ? LIMIT 1
        ");
        $stmt2->bind_param("si", $row['ma'], $id_dot); // masv là kiểu VARCHAR
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        $exclude = false; // Biến để kiểm tra loại bỏ sinh viên
        if ($result2->num_rows > 0) {
            $status = $result2->fetch_assoc()['trangthai'];
            if ($status === 'Chấp nhận') {
                $exclude = true; // Loại bỏ sinh viên có trạng thái "Chấp nhận"
            }
        }

        $stmt2->close();

        // Nếu không cần loại bỏ, thêm sinh viên vào danh sách
        if (!$exclude) {
            $row['lydo'] = ($result2->num_rows > 0) ? 'Không được chấp nhận' : 'Chưa đăng ký';
            $sinhvien[] = $row;
        }
    }

    // Kiểm tra nếu không có sinh viên
    if (count($sinhvien) === 0) {
        echo json_encode(["success" => true, "sinhvien" => [], "message" => "Không có sinh viên nào trong đợt đăng ký này."]);
    } else {
        echo json_encode(["success" => true, "sinhvien" => $sinhvien]);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    $conn->close();
}
