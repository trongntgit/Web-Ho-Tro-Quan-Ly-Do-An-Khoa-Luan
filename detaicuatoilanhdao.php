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


$manguoitao = $_SESSION['userid'];


$sql_all = "SELECT * FroM detai WHERE  duyetlanhdao = 'Chờ duyệt' ORDER BY manguoitao";

$sql_in_progress = "SELECT * FroM detai WHERE  duyetlanhdao = 'Được duyệt' AND (trangthai ='Đăng ký' OR trangthai= 'Chờ đăng ký')";
$sql_in_ko = "SELECT * FroM detai WHERE  duyetlanhdao = 'Không duyệt'";


$stmt_all = $conn->prepare($sql_all);
$stmt_all->execute();
$result_all = $stmt_all->get_result();

$stmt_in_progress = $conn->prepare($sql_in_progress);
$stmt_in_progress->execute();
$result_in_progress = $stmt_in_progress->get_result();

$stmt_in_ko = $conn->prepare($sql_in_ko);
$stmt_in_ko->execute();
$result_in_ko = $stmt_in_ko->get_result();



?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!--Phần favicon -->
     <link rel="apple-touch-icon" sizes="57x57" href="./favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="./favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <title>Duyệt đề tài đò án, khóa luận</title>
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/detaicuatoi.css">
</head>
<body>
    <div class="container">
    <header class="header">
    <a href="./" class="logo-container">
                        <img src="./imge/logo.png" alt="Logo." class="logo_img">
                        <div class="logo-text-container">
                            <span class="logo-title">Hệ thống quản lý</span>
                            <span class="logo-subtitle">Đồ án, khóa luận</span>
                        </div>
        </a>
        <h1 class="main-title">Duyệt đề tài đò án, khóa luận</h1>
    </header>



        <div class="main-content">
                <aside class="user-info">
                    <div class="user-card">
                        <img src="./imge/user2.png" alt="Avatar người dùng" class="avatar">
                        <h3 id="hoten"></h3>
                        <p id="email"></p>
                        <p id="vaitro"></p>
                    </div>
                </aside>

                <section class="project-lists">
                    <!-- Đề tài cần duyệt -->
                    <div class="project-list">
                        <h2>Danh sách đề tài cần duyệt</h2>
                        <table >
                            <tbody>
                                <?php
                                $current_teacher = ""; // Biến để theo dõi giảng viên hiện tại

                                if ($result_all->num_rows > 0) {
                                    while ($row = $result_all->fetch_assoc()) {
                                        // Nếu là giảng viên mới, hiển thị tên giảng viên và tiêu đề bảng
                                        if ($current_teacher != $row['tengv']) {
                                            $current_teacher = $row['tengv'];

                                            // Hiển thị tên giảng viên
                                            echo "<tr class='teacher-row'>";
                                            echo "<td colspan='6'>{$row['tengv']} - {$row['manguoitao']}</td>";
                                            echo "</tr>";

                                            // Hiển thị tiêu đề bảng
                                            echo "<tr class='table-header'>";
                                            echo "<th>Mã đề tài</th>";
                                            echo "<th>Tên đề tài</th>";
                                            echo "<th>Loại đề tài</th>";
                                            echo "<th>Mô tả</th>";
                                            echo "<th>Ngày tạo</th>";
                                            echo "<th>Hành động</th>";
                                            echo "</tr>";
                                        }

                                        // Hiển thị các đề tài thuộc giảng viên đó
                                        echo "<tr>";
                                        echo "<td>{$row['madetai']}</td>";
                                        echo "<td>{$row['tendetai']}</td>";
                                        echo "<td>{$row['loaidetai']}</td>";
                                        echo "<td>{$row['mota']}</td>";
                                        echo "<td>{$row['ngaytao']}</td>";
                                        echo "<td>";
                                        echo '<button class="btn-approve" onclick="duyetdetai(\'' . $row['madetai'] . '\')">Duyệt</button>';
                                        echo '<button class="btn-reject" onclick="khongduyet(\'' . $row['madetai'] . '\')">Không duyệt</button>';

                                        echo "</td>";

                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Không có đề tài nào.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    



                    <!-- Đề tài đã duyệt-->
                    <div class="project-list">
                        <h2>Danh sách các đề tài đã duyệt</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã đề tài</th>
                                    <th>Tên đề tài</th>
                                    <th>Loại đề tài</th>
                                    <th>Tên giáo viên</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_in_progress->num_rows > 0) {
                                    while ($row = $result_in_progress->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row['madetai']}</td>";
                                        echo "<td>{$row['tendetai']}</td>";
                                        echo "<td>{$row['loaidetai']}</td>";
                                        echo "<td>{$row['tengv']}</td>";
                                     
                                        echo "<td>";
                            
                                        echo '<button class="btn-reject" onclick="khongduyet(\'' . $row['madetai'] . '\')">Hủy duyệt</button>';
                                        echo "</td>";
                                        
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Không có đề tài nào.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>


                      <!-- Đề tài hủy duyệt -->
                      <div class="project-list">
                        <h2>Danh sách các đề tài không duyệt</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã đề tài</th>
                                    <th>Tên đề tài</th>
                                    <th>Loại đề tài</th>
                                    <th>Tên giáo viên</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_in_ko->num_rows > 0) {
                                    while ($row = $result_in_ko->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row['madetai']}</td>";
                                        echo "<td>{$row['tendetai']}</td>";
                                        echo "<td>{$row['loaidetai']}</td>";
                                        echo "<td>{$row['tengv']}</td>";
                                     
                                        echo "<td>";

                                        echo '<button class="btn-approve" onclick="duyetdetai(\'' . $row['madetai'] . '\')">Duyệt lại</button>';
                                        echo "</td>";
                                       
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Không có đề tài nào.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>


              
            </div>
            <a class="btn-back" href="./index.php">Trở về</a>
                <!-- Dialog Thông báo -->
            <div id="dialog-thongbao" class="notification">
                <div class="modal-content">
                    <span class="dialog-title">Thông báo</span>
                    <hr>
                    <p id="dialog-thongbao-message">Nội dung thông báo</p>
                </div>
            </div>

            <!-- Dialog Thành công -->
            <div id="dialog-thanhcong" class="notification">
                <div class="modal-content">
                    <span class="dialog-title">Thành công</span>
                    <hr>
                    <p id="dialog-thanhcong-message">Hành động đã được thực hiện thành công!</p>
                </div>
            </div>

            <!-- Dialog Thất bại -->
            <div id="dialog-thatbai" class="notification">
                <div class="modal-content">
                    <span class="dialog-title">Thất bại</span>
                    <hr>
                    <p id="dialog-thatbai-message">Đã có lỗi xảy ra, vui lòng thử lại!</p>
                </div>
            </div>
            <div class="loading-overlay" id="loading-overlay">
                <div class="loader"></div>
            </div>

            <div class="footer">
                <div class="content">
                    <div class="body">
                        <div class="footer-left">
                            <p class="title">TRƯỜNG ĐẠI HỌC SƯ PHẠM KỸ THUẬT VĨNH LONG</p>
                            <div class="desc"><span>Địa chỉ</span>: 73 Nguyễn Huệ, phường 2, thành phố Vĩnh Long, tỉnh Vĩnh Long</div>
                            <div class="desc"><span>Điện thoại</span>: (+84) 02703.822141 - <span>Fax</span>: (+84) 02703.821003 - <span>Email</span>: spktvl@vlute.edu.vn</div>
                        </div>
                        <div class="footer-right">
                            <div class="desc"><strong>2024</strong> <span>Nguyễn Tuấn Trọng</span></div>
                            <div class="desc"><span>Email</span> : 21004235@st.vlute.edu.vn</div>
                        </div>
                    </div>
            </div>
        </div> 
    </div>

<?php
$stmt_all->close();
$stmt_in_progress->close();
$conn->close();
?>
<script src="./assets/javas/detaicuatoi.js"></script>
</body>
</html>
