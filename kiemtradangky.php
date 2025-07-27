<?php
// kiemtradangky.php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Đọc dữ liệu JSON từ body của yêu cầu
$data = json_decode(file_get_contents('php://input'), true);

$madetai = $data['madetai']; // Lấy mã đề tài từ dữ liệu JSON
$masv = $_SESSION['userid'];


// Kiểm tra đợt đăng ký mới nhất của sinh viên
$sql_dotdk = "SELECT id_dotdk FROM dotdangky_sinhvien WHERE masv = ? ORDER BY id_dotdk DESC LIMIT 1";
$stmt_dotdk = $conn->prepare($sql_dotdk);
$stmt_dotdk->bind_param("s", $masv);
$stmt_dotdk->execute();
$result_dotdk = $stmt_dotdk->get_result();
$row_dotdk = $result_dotdk->fetch_assoc();
$id_dotdk = $row_dotdk['id_dotdk'] ?? null;

$dotdk_open = false;
$madetai_in_dotdk = false;

if ($id_dotdk) {
    // Kiểm tra trạng thái của đợt đăng ký
    $sql_status = "SELECT trangthai FROM dotdangky WHERE id = ? AND trangthai = 'Mở'";
    $stmt_status = $conn->prepare($sql_status);
    $stmt_status->bind_param("i", $id_dotdk);
    $stmt_status->execute();
    $result_status = $stmt_status->get_result();
    $dotdk_open = $result_status->num_rows > 0;

    // Kiểm tra đề tài có trong đợt đăng ký
    $sql_madetai = "SELECT COUNT(*) as count FROM dotdangky_detai WHERE id_dotdk = ? AND madetai = ?";
    $stmt_madetai = $conn->prepare($sql_madetai);
    $stmt_madetai->bind_param("is", $id_dotdk, $madetai);
    $stmt_madetai->execute();
    $result_madetai = $stmt_madetai->get_result();
    $row_madetai = $result_madetai->fetch_assoc();
    $madetai_in_dotdk = $row_madetai['count'] > 0;
}



// Kiểm tra trạng thái đăng ký của chủ đề cụ thể
$sql_check = "SELECT COUNT(*) as count FROM dangkydetai WHERE madetai = ? AND masv = ? AND trangthai = 'Chờ duyệt' AND dotdangky = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ssi", $madetai, $masv,$id_dotdk);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row_check = $result_check->fetch_assoc();
$registered = $row_check['count'] > 0; // true nếu có ít nhất 1 dòng

// Đếm số lần đăng ký với trạng thái "Chờ duyệt"
$sql_count = "SELECT COUNT(*) as total_count FROM dangkydetai WHERE masv = ? AND (trangthai = 'Chờ duyệt' or trangthai = 'Chấp nhận') AND dotdangky = ?";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param("si", $masv,$id_dotdk);
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$row_count = $result_count->fetch_assoc();
$total_count = $row_count['total_count'];

// Kiểm tra nếu sinh viên đang thực hiện đề tài (trạng thái "thực hiện")
$sql_in_progress = "SELECT COUNT(*) as in_progress_count FROM dangkydetai WHERE masv = ? AND madetai = ? AND trangthai = 'Chấp nhận' AND dotdangky = ?";
$stmt_in_progress = $conn->prepare($sql_in_progress);
$stmt_in_progress->bind_param("ssi", $masv, $madetai,$id_dotdk);
$stmt_in_progress->execute();
$result_in_progress = $stmt_in_progress->get_result();
$row_in_progress = $result_in_progress->fetch_assoc();
$in_progress = $row_in_progress['in_progress_count'] > 0; // true nếu đang thực hiện ít nhất 1 đề tài



// Trả về kết quả dưới dạng JSON
echo json_encode([
    'registered' => $registered,
    'registration_count' => $total_count,
    'in_progress' => $in_progress,
    'dotdk_open' => $dotdk_open,
    'madetai_in_dotdk' => $madetai_in_dotdk
]);

// Đóng kết nối
$stmt_check->close();
$stmt_count->close();
$stmt_in_progress->close();
if (isset($stmt_dotdk)) $stmt_dotdk->close();
if (isset($stmt_status)) $stmt_status->close();
if (isset($stmt_madetai)) $stmt_madetai->close();
$conn->close();
?>
