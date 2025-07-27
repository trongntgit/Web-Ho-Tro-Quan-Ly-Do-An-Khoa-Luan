<?php
session_start();

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;
$madetai = "241DA202";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy nội dung giao diện từ bảng `giaodien`
$sql_all = "SELECT giaodien FROM giaodien WHERE id = ?";
$stmt_all = $conn->prepare($sql_all);
$stmt_all->bind_param("s", $madetai);
$stmt_all->execute();
$result_all = $stmt_all->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đề tài của tôi</title>
    <link rel="stylesheet" href="../assets/css/detai.css">
</head>
<body>
    <div class="container">
        <?php
        if ($result_all->num_rows > 0) {
            while ($row = $result_all->fetch_assoc()) {
                // Giải mã nội dung đã mã hóa
                $decodedContent = base64_decode($row['giaodien']);
                echo $decodedContent;
            }
        } else {
            echo "<p>Không có đề tài nào.</p>";
        }
        ?>
    </div>
</body>
</html>