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
$id_dot = $_GET['id_dotdangky'] ?? null;
if (!$id_dot) {
    echo json_encode(["success" => false, "message" => "Thiếu thông tin đợt đăng ký."]);
    exit();
}

try {
    // Truy vấn mã đề tài liên quan đến đợt đăng ký
    $stmt1 = $conn->prepare("
        SELECT madetai 
        FROM dotdangky_detai 
        WHERE id_dotdk = ?
    ");
    $stmt1->bind_param("i", $id_dot);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    $madetai_list = [];
    while ($row = $result1->fetch_assoc()) {
        $madetai_list[] = $row['madetai'];
    }
    $stmt1->close();

    // Nếu không có mã đề tài nào, trả về kết quả rỗng
    if (empty($madetai_list)) {
        echo json_encode(["success" => true, "detai" => [], "message" => "Không có đề tài nào liên quan đến đợt đăng ký."]);
        $conn->close();
        exit();
    }

    // Truy vấn danh sách đề tài chưa đủ số lượng sinh viên
    $in_query = implode(',', array_fill(0, count($madetai_list), '?'));
    $query = "
        SELECT madetai, tendetai, soluongmax, soluongdk 
        FROM detai 
        WHERE madetai IN ($in_query) 
          AND soluongdk < soluongmax 
          AND (trangthai = 'Đăng ký' OR trangthai ='Khóa đăng ký')
    ";
    $stmt2 = $conn->prepare($query);
    $stmt2->bind_param(str_repeat('s', count($madetai_list)), ...$madetai_list);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $detai = [];
    while ($row = $result2->fetch_assoc()) {
        $detai[] = $row;
    }
    $stmt2->close();

    // Trả kết quả về dưới dạng JSON
    echo json_encode(["success" => true, "detai" => $detai]);
    $conn->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    $conn->close();
}
?>
