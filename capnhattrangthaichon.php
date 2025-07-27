<?php
session_start();
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra phương thức HTTP
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Lấy dữ liệu từ yêu cầu POST
    $madetai = $_POST['madetai'] ?? '';

    // Kiểm tra dữ liệu đầu vào
    if (!empty($madetai)) {
        // Chuẩn bị câu lệnh SQL để cập nhật
        $stmt = $conn->prepare("UPDATE phancongkhoaluan 
                        SET chon = 'Chưa chọn', 
                            ngaybaove = NULL,
                            buoibaove = 0, 
                            giobd = NULL, 
                            giokt = NULL 
                        WHERE madetai = ?");
        $stmt->bind_param("s", $madetai);

        // Thực thi câu lệnhss
        if ($stmt->execute()) {
            // Trả về phản hồi thành công
            echo json_encode([
                "status" => "success",
                "message" => "Cập nhật thành công mã đề tài: $madetai."
            ]);
        } else {
            // Trả về phản hồi lỗi khi thực thi
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Lỗi khi cập nhật mã đề tài: $madetai."
            ]);
        }

        // Đóng câu lệnh
        $stmt->close();
    } else {
        // Trả về phản hồi lỗi do dữ liệu không hợp lệ
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Dữ liệu đầu vào không hợp lệ."
        ]);
    }
} else {
    // Trả về phản hồi lỗi nếu không phải phương thức POST
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Phương thức không được hỗ trợ."
    ]);
}

// Đóng kết nối
$conn->close();
?>
