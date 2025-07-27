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

$sql_tao = "SELECT 
            pc.madetai AS madt,
            dt.tendetai AS tendt,
            gvcham.hoten AS tengvcham,
            dt.tengv AS tengv,
            gvcham.ma AS manguoicham,
            GROUP_CONCAT(DISTINCT sv.ma) AS masinhvien,
            GROUP_CONCAT(DISTINCT sv.hoten) AS tensinhvien,
            GROUP_CONCAT(DISTINCT sv.lop) AS lop,
            CASE 
                WHEN pc.gvhd = ? THEN 'gvhd'
                WHEN pc.gvphanbien = ? THEN 'gvphanbien'
                ELSE 'khac'
            END AS vaitro
        FROM phancongdoan pc
        JOIN detai dt ON pc.madetai = dt.madetai
        JOIN dangkydetai dk ON dt.madetai = dk.madetai
        JOIN sinhvien sv ON dk.masv = sv.ma
        JOIN giangvien gvcham ON gvcham.ma = ?
        LEFT JOIN phieudiem pd ON pc.madetai = pd.madetai AND pd.magv = ?
        WHERE (pc.gvhd = ? OR pc.gvphanbien = ?)
          AND pd.madetai IS NULL
        GROUP BY pc.madetai, dt.tendetai, gvcham.hoten";








$sql_all = "SELECT 
            pc.madetai AS madt,
            dt.tendetai AS tendt,
            gvcham.hoten AS tengvcham,
            dt.tengv AS tengv,
            gvcham.ma AS manguoicham,   
            bbv.ngay AS ngaybv,
            GROUP_CONCAT(DISTINCT sv.ma) AS masinhvien,
            GROUP_CONCAT(DISTINCT sv.hoten) AS tensinhvien,
            GROUP_CONCAT(DISTINCT sv.lop) AS lop,
            CASE 
                WHEN pc.gvthuky = ? THEN 'gvthuky'
                WHEN pc.gvphanbien = ? THEN 'gvphanbien'
                WHEN pc.chutich = ? THEN 'chutich'
                ELSE 'khac'
            END AS vaitro
        FROM phancongkhoaluan pc
        JOIN detai dt ON pc.madetai = dt.madetai
        JOIN dangkydetai dk ON dt.madetai = dk.madetai
        JOIN sinhvien sv ON dk.masv = sv.ma
        JOIN buoibaove bbv ON pc.buoibaove = bbv.id
        JOIN giangvien gvcham ON gvcham.ma = ?
        LEFT JOIN phieudiem pd ON pc.madetai = pd.madetai AND pd.magv = ?
        WHERE (pc.gvthuky = ? OR pc.gvphanbien = ? OR pc.chutich = ?)
          AND pd.madetai IS NULL
        GROUP BY pc.madetai, dt.tendetai, gvcham.hoten";




$sql_in_progress = "SELECT 
            pc.madetai AS madt,
            dt.tendetai AS tendt,
            gvcham.hoten AS tengvcham,
            dt.tengv AS tengv,
            gvcham.ma AS manguoicham,
            GROUP_CONCAT(DISTINCT sv.ma) AS masinhvien,
            GROUP_CONCAT(DISTINCT sv.hoten) AS tensinhvien,
            GROUP_CONCAT(DISTINCT sv.lop) AS lop,
            pd.id AS phieudiem_id,
            pd.diem AS diem,
            pd.nhanxet AS nhanxet,
            CASE 
                WHEN pc.gvhd = ? THEN 'gvhd'
                WHEN pc.gvphanbien = ? THEN 'gvphanbien'
                ELSE 'unknown'
            END AS vaitro,
            CASE 
                WHEN kq.madetai IS NULL THEN 'Chưa nữa'
                WHEN kq.trangthai = 'Chờ công bố' THEN 'Chưa'
                WHEN kq.trangthai = 'Công bố' THEN 'Rồi'
                ELSE 'Chưa nữa'
            END AS trangthai_congbo
        FROM phancongdoan pc
        JOIN detai dt ON pc.madetai = dt.madetai
        JOIN dangkydetai dk ON dt.madetai = dk.madetai
        JOIN sinhvien sv ON dk.masv = sv.ma
        JOIN giangvien gvcham ON gvcham.ma = ?
        LEFT JOIN phieudiem pd ON pc.madetai = pd.madetai AND pd.magv = ?
        LEFT JOIN ketqua kq ON pc.madetai = kq.madetai
        WHERE (pc.gvhd = ? OR pc.gvphanbien = ?) AND pd.magv = ?
        GROUP BY pc.madetai, dt.tendetai, gvcham.hoten, pd.id, pd.diem, pd.nhanxet, kq.trangthai";


$sql_completed = "SELECT 
                pc.madetai AS madt,
                dt.tendetai AS tendt,
                gvcham.hoten AS tengvcham,
                dt.tengv AS tengv,
                gvcham.ma AS manguoicham,
                GROUP_CONCAT(DISTINCT sv.ma) AS masinhvien,
                GROUP_CONCAT(DISTINCT sv.hoten) AS tensinhvien,
                GROUP_CONCAT(DISTINCT sv.lop) AS lop,
                pd.id AS phieudiem_id,
                pd.diem AS diem,
                pd.nhanxet AS nhanxet,
                CASE 
                    WHEN pc.gvthuky = ? THEN 'gvthuky'
                    WHEN pc.gvphanbien = ? THEN 'gvphanbien'
                    WHEN pc.chutich = ? THEN 'chutich'
                    ELSE 'unknown'
                END AS vaitro
        FROM phancongkhoaluan pc
        JOIN detai dt ON pc.madetai = dt.madetai
        JOIN dangkydetai dk ON dt.madetai = dk.madetai
        JOIN sinhvien sv ON dk.masv = sv.ma
        JOIN giangvien gvcham ON gvcham.ma = ?
        LEFT JOIN phieudiem pd ON pc.madetai = pd.madetai AND pd.magv = ?
        WHERE (pc.gvthuky = ? OR pc.gvphanbien = ? OR pc.chutich = ?)
          AND pd.magv = ?
        GROUP BY pc.madetai, dt.tendetai, gvcham.hoten, pd.id, pd.diem, pd.nhanxet";


$stmt_tao = $conn->prepare($sql_tao);
$stmt_tao->bind_param("ssssss", $manguoitao,$manguoitao,$manguoitao,$manguoitao,$manguoitao,$manguoitao);
$stmt_tao->execute();
$result_tao = $stmt_tao->get_result();

$stmt_all = $conn->prepare($sql_all);
$stmt_all->bind_param("ssssssss", $manguoitao,$manguoitao,$manguoitao,$manguoitao,$manguoitao,$manguoitao,$manguoitao, $manguoitao);
$stmt_all->execute();
$result_all = $stmt_all->get_result();

$stmt_in_progress = $conn->prepare($sql_in_progress);
$stmt_in_progress->bind_param("sssssss", $manguoitao,$manguoitao,$manguoitao,$manguoitao,$manguoitao,$manguoitao,$manguoitao);
$stmt_in_progress->execute();
$result_in_progress = $stmt_in_progress->get_result();

$stmt_completed = $conn->prepare($sql_completed);
$stmt_completed->bind_param("sssssssss", $manguoitao,$manguoitao,$manguoitao,$manguoitao,$manguoitao,$manguoitao,$manguoitao,$manguoitao, $manguoitao);
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
    <title>Chấm điểm đồ án, khóa luận</title>
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
        <h1 class="main-title">Chấm điểm đồ án, khóa luận</h1>
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
                            <h2>Danh sách đề tài đồ án cần chấm</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Mã sinh viên</th>
                                        <th>Họ và tên</th>
                                        <th>Mã Lớp</th>
                                        <th>Tên đề tài</th>
                                        <th>Giáo viên hướng dẫn</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result_tao->num_rows > 0) {
                                        while ($row = $result_tao->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>{$row['masinhvien']}</td>";
                                            echo "<td>{$row['tensinhvien']}</td>";
                                            echo "<td>{$row['lop']}</td>";
                                            echo "<td>{$row['tendt']}</td>";
                                            echo "<td>{$row['tengv']}</td>";
                                            
                                            echo "<td>";
                                            echo "<button class='view-btn-cham' onclick=\"chamdiemDoan('{$row['masinhvien']}', '{$row['tendt']}', '{$row['madt']}', '{$row['manguoicham']}', '{$row['tengvcham']}','{$row['vaitro']}')\">Chấm điểm</button>";
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




                           <!-- Đề tài đang thực hiện -->
                    <div class="project-list">
                        <h2>Danh sách các đề tài đồ án đã chấm</h2>
                        <table>
                            <thead>
                                <tr>
                                <th>Mã sinh viên</th>
                                        <th>Họ và tên</th>
                                        <th>Mã Lớp</th>
                                        <th>Tên đề tài</th>
                                        <th>Giáo viên hướng dẫn</th>
                                        <th>Điểm đã chấm</th>
                                        <th>Nhận xét</th>
                                        <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_in_progress->num_rows > 0) {
                                    while ($row = $result_in_progress->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row['masinhvien']}</td>";
                                        echo "<td>{$row['tensinhvien']}</td>";
                                        echo "<td>{$row['lop']}</td>";
                                        echo "<td>{$row['tendt']}</td>";
                                        echo "<td>{$row['tengv']}</td>";
                                        echo "<td>{$row['diem']}</td>";
                                        echo "<td>{$row['nhanxet']}</td>";
                                        echo "<td>";
                                        if ($row['trangthai_congbo'] == "Chưa nữa") {
                                            // Nếu trạng thái là "Chưa", hiển thị nút sửa điểm
                                            echo "<button class='view-btn-sua' onclick=\"suadiemDoan('{$row['phieudiem_id']}', '{$row['tendt']}', '{$row['madt']}', '{$row['tengv']}','{$row['diem']}', '{$row['nhanxet']}','{$row['vaitro']}')\">Sửa điểm</button>";
                                        } else {
                                            // Nếu trạng thái không phải "Chưa", hiển thị thông báo không thể sửa
                                            echo "<span style='color: red;'>Không thể sửa điểm</span>";
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



                    <!-- Đề tài được duyệt -->
                    <div class="project-list">
                        <h2>Danh sách khóa luận cần chấm</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã sinh viên</th>
                                        <th>Họ và tên</th>
                                        <th>Mã Lớp</th>
                                        <th>Tên đề tài</th>
                                        <th>Giáo viên hướng dẫn</th>
                                        <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_all->num_rows > 0) {
                                    while ($row = $result_all->fetch_assoc()) {
                                        echo "<tr>";
                                            echo "<td>{$row['masinhvien']}</td>";
                                            echo "<td>{$row['tensinhvien']}</td>";
                                            echo "<td>{$row['lop']}</td>";
                                            echo "<td>{$row['tendt']}</td>";
                                            echo "<td>{$row['tengv']}</td>";
                                           
                                            echo "<td>";
                                                    $current_date = date('Y-m-d'); // Lấy ngày hiện tại (định dạng Y-m-d)
                                                    if ($row['ngaybv'] === $current_date) {
                                                        echo "<button class='view-btn-cham' onclick=\"chamdiemDoan('{$row['masinhvien']}', '{$row['tendt']}', '{$row['madt']}', '{$row['manguoicham']}', '{$row['tengvcham']}','{$row['vaitro']}')\">Chấm điểm</button>";
                                                    } else {
                                                        echo "<span style='color: red;'>Chưa đến hạn chấm điểm</span>";
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

                 

                 

                    <!-- Đề tài đã hoàn thành -->
                    <div class="project-list">
                        <h2>Danh sách các đề tài khóa luận đã chấm</h2>
                        <table>
                            <thead>
                                <tr>
                                <th>Mã sinh viên</th>
                                        <th>Họ và tên</th>
                                        <th>Mã Lớp</th>
                                        <th>Tên đề tài</th>
                                        <th>Giáo viên hướng dẫn</th>
                                        <th>Điểm đã chấm</th>
                                        <th>Nhận xét</th>
                                        <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_completed->num_rows > 0) {
                                    while ($row = $result_completed->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row['masinhvien']}</td>";
                                        echo "<td>{$row['tensinhvien']}</td>";
                                        echo "<td>{$row['lop']}</td>";
                                        echo "<td>{$row['tendt']}</td>";
                                        echo "<td>{$row['tengv']}</td>";
                                        echo "<td>{$row['diem']}</td>";
                                        echo "<td>{$row['nhanxet']}</td>";
                                        echo "<td>";
                                        echo "<button class='view-btn-sua' onclick=\"suadiemDoan('{$row['phieudiem_id']}', '{$row['tendt']}', '{$row['madt']}', '{$row['tengv']}','{$row['diem']}', '{$row['nhanxet']}','{$row['vaitro']}')\">Sửa điểm</button>";
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

            <div id="chamdiemModal" style="display : none;">
                                <div id="chamdiemContent">
                                    <span id="closeModal" onclick="closeModalChamDiem()">&times;</span>
                                    <h2>Chấm điểm: <span id="modalTendetai"></span></h2>
                                    <p><strong>Mã đề tài:</strong> <span id="modalMadt"></span></p>
                                    <p><strong>Tên người chấm :</strong> <span id="modalTen"></span></p>

                                    <form id="chamdiemForm">
                                        <label for="diem">Điểm:</label>
                                        <input type="number" id="diem" name="diem" min="0" max="10" step="0.5" required><br><br>

                                        <label for="nhanxet">Nhận xét:</label><br>
                                        <textarea id="nhanxet" name="nhanxet" rows="4" cols="50" required></textarea><br><br>

                                        <button  type="button" id="btnSaveChamDiem">Lưu</button>
                                    </form>
                                </div>
                            </div>
            

                            <div id="suadiemModal" style="display: none;">
                                <div id="suadiemContent">
                                    <span id="closeModal" onclick="closeModalSuaDiem()">&times;</span>
                                    <h2>Sửa điểm: <span id="modalSuaTendetai"></span></h2>
                                    <p><strong>Mã đề tài:</strong> <span id="modalSuaMadt"></span></p>
                                    <p><strong>Tên người chấm :</strong> <span id="modalSuaTen"></span></p>

                                    <form id="suadiemForm">
                                        <label for="suaDiem">Điểm:</label>
                                        <input type="number" id="suaDiem" name="diem" min="0" max="10" step="0.5" required><br><br>

                                        <label for="suaNhanxet">Nhận xét:</label><br>
                                        <textarea id="suaNhanxet" name="nhanxet" rows="4" cols="50" required></textarea><br><br>

                                        <button type="button" id="btnSaveSuaDiem" onclick="submitSuaDiem()">Lưu</button>
                                    </form>
                                </div>
                            </div>

                           

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
