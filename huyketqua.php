<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy giá trị madetai từ request
if (isset($_POST['madetai'])) {
    $madetai = $_POST['madetai'];

    // Truy vấn SQL để xóa dữ liệu
    $sql = "DELETE FROM ketqua WHERE madetai = ?";
    
    // Chuẩn bị câu lệnh SQL
    if ($stmt = $conn->prepare($sql)) {
        // Liên kết tham số và thực thi câu lệnh
        $stmt->bind_param("s", $madetai); // "s" cho kiểu string
        if ($stmt->execute()) {
            echo "Hủy kết quả thành công!";
        } else {
            echo "Lỗi: Không thể hủy kết quả.";
        }
        $stmt->close();
    } else {
        echo "Lỗi: Câu lệnh SQL không hợp lệ.";
    }
} else {
    echo "Dữ liệu không hợp lệ.";
}

// Đóng kết nối
$conn->close();
?>
