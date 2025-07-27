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


$manguoitao = 1;


$sql_all = "SELECT giaodien FROM giaodien WHERE id = ? ";

$stmt_all = $conn->prepare($sql_all);
$stmt_all->bind_param("s", $manguoitao);
$stmt_all->execute();
$result_all = $stmt_all->get_result();


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đề tài của tôi</title>
    <!-- <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/detaicuatoi.css"> -->
</head>
<body>
    <div class="container">
      
    <?php
                                if ($result_all->num_rows > 0) {
                                    while ($row = $result_all->fetch_assoc()) {
                                       echo $row['giaodien'];

                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Không có đề tài nào.</td></tr>";
                                }
                                ?>
        <footer>
            <p>&copy; 2024 Hệ thống quản lý đồ án, khóa luận</p>
        </footer>
    </div>

<?php
$stmt_all->close();
$conn->close();
?>
<!-- <script src="./assets/javas/detaicuatoi.js"></script> -->
</body>
</html>
