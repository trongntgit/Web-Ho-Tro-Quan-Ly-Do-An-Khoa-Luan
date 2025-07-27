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

$sql_tao = "SELECT madetai, tendetai, trangthai,soluongmax, soluongdk, ngaytao,duyetlanhdao FROM detai WHERE manguoitao = ? AND (duyetlanhdao = 'Chờ duyệt' or trangthai = 'Chờ đăng ký')";
$sql_all = "SELECT madetai, tendetai, trangthai,soluongmax, soluongdk, ngaytao FROM detai WHERE manguoitao = ? AND (trangthai = 'Đăng ký' OR trangthai='Khóa đăng ký') AND duyetlanhdao = 'Được duyệt'";
$sql_in_progress = "SELECT 
    d.madetai, 
    d.tendetai, 
    d.trangthai, 
    d.ngaytao,
     d.manguoitao, 
    COALESCE(SUM(t.phantram), 0) AS phantram_tiendo
FROM 
    detai d
LEFT JOIN 
    tiendo t ON d.madetai = t.madetai AND t.loaitiendo = 'progress'
WHERE 
    d.manguoitao = ?
    AND d.trangthai = 'Đang thực hiện'
GROUP BY 
    d.madetai, d.tendetai, d.trangthai, d.ngaytao;
";
$sql_completed = "SELECT madetai,manguoitao, tendetai, trangthai, ngaytao FROM detai WHERE manguoitao = ? AND (trangthai = 'Hoàn thành'  or trangthai = 'Không đạt')";


$stmt_tao = $conn->prepare($sql_tao);
$stmt_tao->bind_param("s", $manguoitao);
$stmt_tao->execute();
$result_tao = $stmt_tao->get_result();

$stmt_all = $conn->prepare($sql_all);
$stmt_all->bind_param("s", $manguoitao);
$stmt_all->execute();
$result_all = $stmt_all->get_result();

$stmt_in_progress = $conn->prepare($sql_in_progress);
$stmt_in_progress->bind_param("s", $manguoitao);
$stmt_in_progress->execute();
$result_in_progress = $stmt_in_progress->get_result();

$stmt_completed = $conn->prepare($sql_completed);
$stmt_completed->bind_param("s", $manguoitao);
$stmt_completed->execute();
$result_completed = $stmt_completed->get_result();
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
    <title>Đề tài của tôi</title>
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
        <h1 class="main-title">Đề tài của tôi</h1>
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
                       <!-- Đề tài đã tạo -->
                    <div class="project-list">
                            <h2>Danh sách đề tài đã tạo</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Mã đề tài</th>
                                        <th>Tên đề tài</th>
                                        <th>Ngày tạo</th>
                                        <th>Duyệt lãnh đạo</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result_tao->num_rows > 0) {
                                        while ($row = $result_tao->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>{$row['madetai']}</td>";
                                            echo "<td>{$row['tendetai']}</td>";
                                            echo "<td>{$row['ngaytao']}</td>";
                                            echo "<td>{$row['duyetlanhdao']}</td>";
                                            echo "<td>{$row['trangthai']}</td>";
                                            echo "<td>";
                                            echo '<button 
                                            class="btn-reject" 
                                            id="' . $row['madetai'] . '" 
                                            data-madt="' . $row['madetai'] . '" 
                                            data-sol="' . $row['soluongdk'] . '" 
                                            data-solmax="' . $row['soluongmax'] . '" 
                                            onclick="xoadetai(\'' . $row['madetai'] . '\')">Xóa đề tài</button>';
                                    
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



                    <!-- Đề tài được duyệt -->
                    <div class="project-list">
                        <h2>Danh sách đề tài đang đăng ký</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã đề tài</th>
                                    <th>Tên đề tài</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Số lượng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_all->num_rows > 0) {
                                    while ($row = $result_all->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row['madetai']}</td>";
                                        echo "<td>{$row['tendetai']}</td>";
                                        echo "<td>{$row['ngaytao']}</td>";
                                        echo "<td>{$row['trangthai']}</td>";
                                        echo "<td>{$row['soluongdk']}/{$row['soluongmax']}</td>";
                                        echo "<td>";
                                        echo '<button style="width : 110px;" class="view-btn" id="'.$row['madetai'].'" data-madt="' . $row['madetai'] . '" data-sol ="'.$row['soluongdk'].'" data-solmax ="'.$row['soluongmax'].'">Xem đăng ký</button>';
                                        echo "</td>";
                                        echo "</tr>";
                                        echo "<script>localStorage.setItem('sol-dk', '" . $row['soluongdk'] . "');
                                            localStorage.setItem('sol-dk', '" . $row['soluongdk'] . "');
                                        
                                        </script>";

                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Không có đề tài nào.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="dialog-xemdk" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeDialog()">&times;</span>
                            <h2>Danh sách sinh viên đã đăng ký</h2>
                            <table id="student-list">   
                                <thead>
                                    <tr>
                                        <th>Mã sinh viên</th>
                                        <th>Họ và tên</th>
                                        <th>Điểm tích lũy</th>
                                        <th>Ngày đăng ký</th>
                                        <th>Ghi chú</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="student-tbody">
                                    <!-- Dữ liệu sinh viên sẽ được thêm vào đây -->
                                </tbody>
                            </table>
                            <button id="accept-btn" class="button" onclick="acceptRegistration()">Thực hiện</button>
                            <button class="button button-close" onclick="closeDialog()">Đóng</button>
                        </div>
                    </div>

                 

                    <!-- Đề tài đang thực hiện -->
                    <div class="project-list">
                        <h2>Đề tài đang thực hiện</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã đề tài</th>
                                    <th>Tên đề tài</th>
                                    <th>Ngày tạo</th>
                                    <th>Tiến độ</th>
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
                                        echo "<td>{$row['ngaytao']}</td>";
                                        echo "<td>
                                                <div style='position: relative; width: 100%; height: 20px; background-color: #f3f3f3; border: 1px solid #ccc; border-radius: 5px; display: flex; align-items: center; justify-content: center;'>
                                                    <div style='width: {$row['phantram_tiendo']}%; height: 100%; background-color: #4caf50; border-radius: 5px; position: absolute; top: 0; left: 0;'></div>
                                                    <span style='z-index: 1; color: #000; font-size: 12px; font-weight: bold;'>{$row['phantram_tiendo']}%</span>
                                                </div>
                                            </td>";
                                            

                                        echo "<td>";
                                        echo "<a class='view-btn-tiendo' href='./detai/" . $row['madetai'] . ".php'>Xem chi tiết</a>";
                                        echo "<a class='view-btn-khongdat' onclick='khongdat(\"" . $row['madetai'] . "\", \"" . $row['manguoitao'] . "\")'>Không đạt</a>";


                                       
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

                    <!-- Đề tài đã hoàn thành -->
                    <div class="project-list">
                        <h2>Đề tài đã hoàn thành</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã đề tài</th>
                                    <th>Tên đề tài</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if ($result_completed->num_rows > 0) {
                                    while ($row = $result_completed->fetch_assoc()) {
                                        // Kiểm tra trạng thái
                                        $trangthai = $row['trangthai'];
                                        $rowClass = ($trangthai === 'Không đạt') ? 'class="red-row"' : '';
                                        
                                        echo "<tr $rowClass>";
                                        echo "<td>{$row['madetai']}</td>";
                                        echo "<td>{$row['tendetai']}</td>";
                                        echo "<td>{$row['ngaytao']}</td>";
                                        echo "<td>{$trangthai}</td>";
                                        echo "<td>";
                                        
                                        if ($trangthai === 'Không đạt') {
                                            echo "<button class='retry-btn' onclick='cholamlai(\"" . $row['madetai'] . "\", \"" . $row['manguoitao'] . "\")'>Cho làm lại</a>";
                                        } else {
                                            echo "<a class='view-btn-tiendo' href='./detai/" . $row['madetai'] . ".php'>Xem chi tiết</a>";
                                        }
                                        
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
                </section>
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
$stmt_completed->close();
$conn->close();
?>
<script src="./assets/javas/detaicuatoi.js"></script>
</body>
</html>
