<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Lấy dữ liệu POST từ JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra dữ liệu đầu vào
if (!isset($data['madetai']) || empty($data['madetai'])) {
    echo json_encode(['success' => false, 'error' => 'Mã đề tài không hợp lệ']);
    exit;
}

$mabcc = $data['madetai'];

// Kết nối tới cơ sở dữ liệu
$server = "localhost";
$username = "root";
$password = "";
$database = "doan2";
$port = 3309;

$conn = new mysqli($server, $username, $password, $database, $port);
$magv = $_SESSION['userid']; // Lấy ID của giảng viên từ session

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Không thể kết nối tới cơ sở dữ liệu']);
    exit;
}

// Kiểm tra xem giảng viên có quyền xóa đề tài này không
$sql_check = "SELECT * FROM detai WHERE madetai=? AND manguoitao=?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ss", $mabcc, $magv);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    // Kiểm tra trạng thái phê duyệt
    $row = $result->fetch_assoc();
    if ($row['duyetlanhdao'] !== 'Chờ duyệt' && $row['duyetlanhdao'] !== 'Không duyệt' ) {
        echo json_encode([
            'success' => false,
            'error' => 'Đề tài đã được duyệt hoặc không ở trạng thái "Chờ duyệt", không thể xóa'
        ]);
    } else {
        // Nếu đề tài hợp lệ để xóa
        $sql_delete = "DELETE FROM detai WHERE madetai=? AND manguoitao=?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("ss", $mabcc, $magv);

        if ($stmt_delete->execute()) {
            echo json_encode(['success' => true, 'message' => 'Xóa đề tài thành công']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Lỗi trong quá trình xóa đề tài']);
        }
        $stmt_delete->close();
    }
} else {
    // Không tìm thấy hoặc không có quyền xóa
    echo json_encode(['success' => false, 'error' => 'Bạn không có quyền xóa đề tài này hoặc đề tài không tồn tại']);
}

$stmt_check->close();
$conn->close();
?>
