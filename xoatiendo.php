<?php
// Kết nối cơ sở dữ liệu
$server = "localhost";
$username = "root";
$password = "";
$database = "doan2";
$port = 3309;

$conn = new mysqli($server, $username, $password, $database, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    http_response_code(500); // Mã lỗi server
    die(json_encode(["success" => false, "error" => "Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error]));
}

// Lấy dữ liệu từ yêu cầu POST
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['madetai'], $data['loaitiendo'], $data['ngaynop'])) {
    $madetai = $conn->real_escape_string($data['madetai']);
    $loaitiendo = $conn->real_escape_string($data['loaitiendo']);
    $ngaynop = $conn->real_escape_string($data['ngaynop']);

    // Kiểm tra xem bản ghi có tồn tại trước khi xóa
    $check_sql = "SELECT * FROM tiendo WHERE madetai = '$madetai' AND loaitiendo = '$loaitiendo' AND ngaynop = '$ngaynop'";
    $check_result = $conn->query($check_sql);

    if ($check_result && $check_result->num_rows > 0) {
        // Xóa bản ghi
        $delete_sql = "DELETE FROM tiendo WHERE madetai = '$madetai' AND loaitiendo = '$loaitiendo' AND ngaynop = '$ngaynop'";
        if ($conn->query($delete_sql) === TRUE) {
            http_response_code(200); // Thành công
            echo json_encode(["success" => true, "message" => "Bản ghi đã được xóa thành công."]);
        } else {
            http_response_code(500); // Lỗi server
            echo json_encode(["success" => false, "error" => "Lỗi khi xóa bản ghi: " . $conn->error]);
        }
    } else {
        http_response_code(404); // Không tìm thấy
        echo json_encode(["success" => false, "error" => "Bản ghi không tồn tại."]);
    }
} else {
    http_response_code(400); // Lỗi yêu cầu
    echo json_encode(["success" => false, "error" => "Dữ liệu không hợp lệ."]);
}

// Đóng kết nối
$conn->close();
?>
