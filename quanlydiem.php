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

$sql_tao = "
    SELECT 
        pc.madetai AS madt,
        dt.tendetai AS tendt,
        gvcham.hoten AS tengvcham,
        gvcham.ma AS magvcham,
        pd.diem AS diem,
        pd.nhanxet AS nhanxet,
        pd.vaitro AS vaitro,
        pd.loaicham AS loai
    FROM phancongdoan pc
    JOIN detai dt ON pc.madetai = dt.madetai
    JOIN giangvien gvcham ON pc.gvhd = gvcham.ma OR pc.gvphanbien = gvcham.ma
    LEFT JOIN phieudiem pd ON pc.madetai = pd.madetai AND gvcham.ma = pd.magv
    WHERE NOT EXISTS (
        SELECT 1 FROM ketqua kq WHERE kq.madetai = pc.madetai
    )
    ORDER BY pc.madetai, pd.vaitro, gvcham.hoten
";







$sql_all = "
    SELECT 
        pc.madetai AS madt,
        dt.tendetai AS tendt,
        gvcham.hoten AS tengvcham,
        gvcham.ma AS magvcham,
        pd.diem AS diem,
        pd.nhanxet AS nhanxet,
        pd.loaicham AS loai,
        CASE 
            WHEN pc.gvthuky = gvcham.ma THEN 'gvthuky'
            WHEN pc.gvphanbien = gvcham.ma THEN 'gvphanbien'
            WHEN pc.chutich = gvcham.ma THEN 'chutich'
            ELSE 'khac'
        END AS vaitro
    FROM phancongkhoaluan pc
    JOIN detai dt ON pc.madetai = dt.madetai
    JOIN giangvien gvcham ON pc.gvthuky = gvcham.ma 
        OR pc.gvphanbien = gvcham.ma 
        OR pc.chutich = gvcham.ma
    LEFT JOIN phieudiem pd ON pc.madetai = pd.madetai AND gvcham.ma = pd.magv
    WHERE NOT EXISTS (
        SELECT 1 FROM ketqua kq WHERE kq.madetai = pc.madetai
    )
    ORDER BY pc.madetai, vaitro, gvcham.hoten
";







$sql_in_progress = "SELECT * FROM ketqua WHERE diemchutich IS NULL ";

          


$sql_completed = "SELECT * FROM ketqua WHERE diemchutich IS NOT NULL";



$stmt_tao = $conn->prepare($sql_tao);
$stmt_tao->execute();
$result_tao = $stmt_tao->get_result();


$stmt_all = $conn->prepare($sql_all);
$stmt_all->execute();
$result_all = $stmt_all->get_result();

$stmt_in_progress = $conn->prepare($sql_in_progress);
$stmt_in_progress->execute();
$result_in_progress = $stmt_in_progress->get_result();

$stmt_completed = $conn->prepare($sql_completed);
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
    <title>Quản lý điểm đồ án, khóa luận</title>
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
        <h1 class="main-title">Quản lý điểm đồ án, khóa luận</h1>
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
                        <h2>Danh sách điểm các đề tài đồ án</h2>

                        <?php
                            $result_tao = $conn->query($sql_tao);

                            if ($result_tao->num_rows > 0) {
                                $current_madt = null;
                                $loai = "Được chấm"; // Giá trị mặc định cho mỗi đề tài

                                while ($row = $result_tao->fetch_assoc()) {
                                    // Nếu là một đề tài mới, hiển thị tiêu đề đề tài
                                    if ($current_madt !== $row['madt']) {
                                        if ($current_madt !== null) {
                                            echo "</ul>"; // Kết thúc danh sách điểm cũ
                                            echo "<button class='btn-tonghop' onclick=\"tongHopDiemDoan('{$current_madt}', '{$loai}')\">Tổng hợp điểm</button>";
                                            echo "</div>"; // Kết thúc div cho đề tài cũ
                                        }

                                        // Reset $loai cho đề tài mới
                                        $loai = "Được chấm";

                                        // Hiển thị tiêu đề đề tài
                                        echo "<div class='project-item' style='";
                                        if ($row['loai'] === "Không chấm") {
                                            echo "background-color: #ffcccc;"; // Thêm nền đỏ nếu không đạt
                                        }
                                        echo "'>";
                                        echo "<h3>Đề tài: {$row['tendt']} (Mã: {$row['madt']})</h3>";
                                        echo "<ul class='score-list'>";  // Mở danh sách điểm
                                        $current_madt = $row['madt'];
                                    }

                                    // Kiểm tra giá trị "loai"
                                    if ($row['loai'] === "Không chấm") {
                                        $loai = "Không chấm"; // Đánh dấu nếu có bất kỳ dòng nào không được chấm

                                        // Hiển thị ghi chú và nền đỏ cho dòng "Không chấm"
                                        echo "<li class='score-item fail' style='background-color: #ffcccc;'>
                                                Điểm: 0
                                                <span class='note' style='color: red;'>Đề tài không đạt</span>
                                            </li>";
                                    } else {
                                        // Hiển thị điểm và thông tin người chấm bình thường
                                        echo "<li class='score-item'>
                                                Điểm " . 
                                                ($row['vaitro'] == 'gvhd' ? 'Giáo viên hướng dẫn' : 'Giáo viên phản biện') . 
                                                " ({$row['tengvcham']}): " . 
                                                ($row['diem'] ? "{$row['diem']}" : "Chưa chấm") . 
                                            "</li>";
                                    }
                                }

                                // Kết thúc danh sách điểm và nút tổng hợp cho đề tài cuối cùng
                                echo "</ul>";
                                echo "<button class='btn-tonghop' onclick=\"tongHopDiemDoan('{$current_madt}', '{$loai}')\">Tổng hợp điểm</button>";
                                echo "</div>"; // Kết thúc div cho đề tài cuối cùng
                            } else {
                                echo "<p>Không có dữ liệu</p>";
                            }
                            ?>

                    </div>







                           <!-- Đề tài đang thực hiện -->
                       
                           <div class="project-list">

                                <h2>Danh sách điểm các khóa luận</h2>

                                <?php
                                    $result_all = $conn->query($sql_all);

                                    if ($result_all->num_rows > 0) {
                                        $current_madt = null;
                                        $loai = "Được chấm"; // Giá trị mặc định

                                        while ($row = $result_all->fetch_assoc()) {
                                            // Nếu là một đề tài mới, hiển thị tiêu đề đề tài
                                            if ($current_madt !== $row['madt']) {
                                                if ($current_madt !== null) {
                                                    echo "</ul>"; // Kết thúc danh sách điểm cũ
                                                    echo "<button class='btn-tonghop' onclick=\"tongHopDiem('{$current_madt}', '{$loai}')\">Tổng hợp điểm</button>";
                                                    echo "</div>"; // Kết thúc div cho đề tài cũ
                                                }

                                                // Reset $loai cho đề tài mới
                                                $loai = "Được chấm";

                                                // Hiển thị tiêu đề đề tài
                                                echo "<div class='project-item'>";
                                                echo "<h3>Đề tài: {$row['tendt']} (Mã: {$row['madt']})</h3>";
                                                echo "<ul class='score-list'>"; // Mở danh sách điểm
                                                $current_madt = $row['madt'];
                                            }

                                            // Kiểm tra giá trị "loai" và tùy chỉnh hiển thị
                                            if ($row['loai'] === "Không chấm") {
                                                $loai = "Không chấm"; // Đánh dấu nếu có bất kỳ dòng nào không được chấm
                                                echo "<li class='score-item fail' style='background-color: #ffcccc;'>
                                                        Điểm: 0
                                                        <span class='note' style='color: red;'>Đề tài không đạt</span>
                                                    </li>";
                                            } else {
                                                // Hiển thị bình thường
                                                echo "<li class='score-item'>
                                                        Điểm " . 
                                                        ($row['vaitro'] == 'gvthuky' ? 'Giáo viên thư ký' :
                                                        ($row['vaitro'] == 'gvphanbien' ? 'Giáo viên phản biện' :
                                                        ($row['vaitro'] == 'chutich' ? 'Chủ tịch hội đồng' : $row['vaitro']))) .
                                                        " ({$row['tengvcham']}): " . 
                                                        ($row['diem'] ? "{$row['diem']}" : "Chưa chấm") . 
                                                    "</li>";
                                            }
                                        }

                                        // Kết thúc danh sách điểm và nút tổng hợp cho đề tài cuối cùng
                                        echo "</ul>";
                                        echo "<button class='btn-tonghop' onclick=\"tongHopDiem('{$current_madt}', '{$loai}')\">Tổng hợp điểm</button>";
                                        echo "</div>"; // Kết thúc div cho đề tài cuối cùng
                                    } else {
                                        echo "<p>Không có dữ liệu</p>";
                                    }
                                    ?>

                            </div>




                            <div class="project-list">
                        <h2>Danh sách kết quả đồ án</h2>
                        <table>
                            <thead>
                                <tr>
                                        <th>Mã đề tài</th>
                                        <th>Điểm giáo viên hướng dẫn</th>
                                        <th>Điểm giáo viên phản biện</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt_in_progress = $conn->prepare($sql_in_progress);
                                $stmt_in_progress->execute();
                                $result_in_progress = $stmt_in_progress->get_result();
                                if ( $result_in_progress->num_rows > 0) {
                                    while ($row = $result_in_progress->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row['madetai']}</td>";
                                        echo "<td>{$row['diemgvhd']}</td>";
                                        echo "<td>{$row['diemgvpb']}</td>";
                                        echo "<td>{$row['trangthai']}</td>";

                                        echo "<td>";
                                          // Kiểm tra trạng thái để hiển thị nút phù hợp
                                          if ($row['trangthai'] === "Chờ công bố") {
                                            echo "<button class='btn-suakq' onclick=\"suadiemKetQuaDoAn('{$row['madetai']}','{$row['diemgvhd']}','{$row['diemgvpb']}')\">Sửa điểm</button>";
                                            echo "<button class='btn-congbo' onclick=\"congBoDiem('{$row['madetai']}')\">Công bố</button>";
                                            echo "<button class='btn-huykq' onclick=\"huyKetQua('{$row['madetai']}')\">Hủy kết quả</button>";
                                        } elseif ($row['trangthai'] === "Công bố") {
                                           
                                            echo "<button class='btn-huycongbo' onclick=\"huyCongBo('{$row['madetai']}')\">Hủy công bố</button>";
                                            echo "<button class='btn-huykq' onclick=\"huyKetQua('{$row['madetai']}')\">Hủy kết quả</button>";
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
                        <h2>Danh sách kết quả khóa luận</h2>
                        <table>
                            <thead>
                                <tr>
                                        <th>Mã đề tài</th>
                                        <th>Điểm giáo viên hướng dẫn</th>
                                        <th>Điểm giáo viên phản biện</th>
                                        <th>Điểm chủ tịch </th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                // Chuẩn bị câu lệnh
                                    $stmt_completed = $conn->prepare($sql_completed);
                                    
                                    // Thực thi câu lệnh
                                    $stmt_completed->execute();
                                    
                                    // Lấy kết quả
                                    $result_completed = $stmt_completed->get_result();
                                    
                                    // Kiểm tra và xử lý kết quả
                                    if ($result_completed->num_rows > 0) {
                                        while ($row = $result_completed->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>{$row['madetai']}</td>";
                                            echo "<td>{$row['diemgvhd']}</td>";
                                            echo "<td>{$row['diemgvpb']}</td>";
                                            echo "<td>{$row['diemchutich']}</td>";
                                            echo "<td>{$row['trangthai']}</td>";
                                            echo "<td>";

                                            // Kiểm tra trạng thái để hiển thị nút phù hợp
                                            if ($row['trangthai'] === "Chờ công bố") {
                                                echo "<button class='btn-suakq' onclick=\"suadiemKetQua('{$row['madetai']}','{$row['diemgvhd']}','{$row['diemgvpb']}','{$row['diemchutich']}')\">Sửa điểm</button>";
                                                echo "<button class='btn-congbo' onclick=\"congBoDiem('{$row['madetai']}')\">Công bố</button>";
                                                echo "<button class='btn-huykq' onclick=\"huyKetQua('{$row['madetai']}')\">Hủy kết quả</button>";
                                            } elseif ($row['trangthai'] === "Công bố") {
                                              
                                                echo "<button class='btn-huycongbo' onclick=\"huyCongBo('{$row['madetai']}')\">Hủy công bố</button>";
                                                echo "<button class='btn-huykq' onclick=\"huyKetQua('{$row['madetai']}')\">Hủy kết quả</button>";
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
                

                 

                    <!-- Đề tài đã hoàn thành -->
                  
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

                            <div id="modalSuaDiemKetQua" style="display: none;">
                                <div id="contentSuaDiemKetQua">
                                    <span id="closeModalSuaDiemKetQua" onclick="closeModalSuaDiemKetQua()">&times;</span>
                                    <h2>Sửa điểm: <span id="modalSuaTenDeTaiKetQua"></span></h2>
                                    <p><strong>Mã đề tài:</strong> <span id="modalSuaMaDeTaiKetQua"></span></p>

                                    <form id="formSuaDiemKetQua">
                                        <label for="inputDiemGVHD">Điểm GVHD:</label>
                                        <input type="number" id="inputDiemGVHD" name="diem_gvhd" min="0" max="10" step="0.5" required><br><br>

                                        <label for="inputDiemGVPB">Điểm GVPB:</label>
                                        <input type="number" id="inputDiemGVPB" name="diem_gvpb" min="0" max="10" step="0.5" required><br><br>

                                        <label for="inputDiemChuTich">Điểm Chủ tịch:</label>
                                        <input type="number" id="inputDiemChuTich" name="diem_chutich" min="0" max="10" step="0.5" required><br><br>


                                        <button type="button" id="btnSaveSuaDiemKetQua" onclick="submitSuaDiemKetQua()">Lưu</button>
                                    </form>
                                </div>
                            </div>


                            <div id="modalSuaDiemKetQuaDoAn" style="display: none;">
                                <div id="contentSuaDiemKetQuaDoAn">
                                    <span id="closeModalSuaDiemKetQuaDoAn" onclick="closeModalSuaDiemKetQuaDoAn()">&times;</span>
                                    <h2>Sửa điểm: <span id="modalSuaTenDeTaiKetQuaDoAn"></span></h2>
                                    <p><strong>Mã đề tài:</strong> <span id="modalSuaMaDeTaiKetQuaDoAn"></span></p>

                                    <form id="formSuaDiemKetQuaDoAn">
                                        <label for="inputDiemGVHDDoAn">Điểm GVHD:</label>
                                        <input type="number" id="inputDiemGVHDDoAn" name="diem_gvhdDoAn" min="0" max="10" step="0.5" required><br><br>

                                        <label for="inputDiemGVPBDoAn">Điểm GVPB:</label>
                                        <input type="number" id="inputDiemGVPBDoAn" name="diem_gvpbDoAn" min="0" max="10" step="0.5" required><br><br>


                                        <button type="button" id="btnSaveSuaDiemKetQua" onclick="submitSuaDiemKetQuaDoAn()">Lưu</button>
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
