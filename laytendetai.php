<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Kết nối đến cơ sở dữ liệu
$server = "localhost";
$user = "root";
$pass = "";
$data = "doan2";
$port = 3309;

$con = mysqli_connect($server, $user, $pass, $data, $port);

if (!$con) {
    die(json_encode(['success' => false, 'error' => 'Không thể kết nối cơ sở dữ liệu']));
}

try {
    // Lấy dữ liệu từ POST
    $input = json_decode(file_get_contents('php://input'), true);
    $madetai = $input['madetai'] ?? null;

    if (!$madetai) {
        throw new Exception("Mã đề tài không hợp lệ");
    }

    // Truy vấn dữ liệu đề tài
    $madetai = mysqli_real_escape_string($con, $madetai);
    $query = "SELECT tendetai, madetai FROM detai WHERE madetai = '$madetai'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $detai = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'detai' => $detai]);
    } else {
        throw new Exception("Không tìm thấy đề tài với mã '$madetai'");
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    mysqli_close($con);
}
?>
