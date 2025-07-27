<?php

if (!empty($success_list)) {
    $_SESSION['excel-tc'] = 'thanhcong';
    $_SESSION['exceltc-mes'] = $success_list; // Lưu thông báo thành công
}

if (!empty($fail_list)) {
    $_SESSION['excel-tb'] = 'thatbai';
    $_SESSION['exceltb-mes'] = $fail_list; // Lưu thông báo thất bại
}



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

$sql_sv = "select * from sinhvien";
$sql_gv = "select * from giangvien";
$sql_qt = "select * from quantri";
$sql_tk = "select * from taikhoan2";


$stmt_sv = $conn->prepare($sql_sv);
$stmt_sv->execute();
$result_sv = $stmt_sv->get_result();

$stmt_gv = $conn->prepare($sql_gv);
$stmt_gv->execute();
$result_gv = $stmt_gv->get_result();

$stmt_qt = $conn->prepare($sql_qt);
$stmt_qt->execute();
$result_qt = $stmt_qt->get_result();

$stmt_tk = $conn->prepare($sql_tk);
$stmt_tk->execute();
$result_tk = $stmt_tk->get_result();


?>


<!DOCTYPE html>
<html lang="en">
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
  <title>Quản lý người dùng</title>
  <!-- Bootstrap CSS -->
 
  <!-- Custom CSS -->
  <link rel="stylesheet" href="./assets/css/quanlynguoidung.css">

   <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body>
<header class="header">
        <a href="./" class="logo-container">
                            <img src="./imge/logo.png" alt="Logo." class="logo_img">
                            <div class="logo-text-container">
                                <span class="logo-title">Hệ thống quản lý</span>
                                <span class="logo-subtitle">Đồ án, khóa luận</span>
                            </div>
            </a>
            <h1 class="main-title">Quản lý người dùng</h1>
        </header>

    <div class="container mt-5">
        <!-- Quản lý giảng viên -->
        <section id="giangvien-section" class="mb-5">
        <h2 class="mb-4">Quản lý giảng viên</h2>
        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" onclick="themgv()">Thêm mới giảng viên</button>
            <button class="btn btn-secondary" id="xuatExcelGV">Xuất Excel</button>
        </div>
        <input type="text" id="search-giangvien" class="form-control mb-3" placeholder="Tìm kiếm giảng viên theo tên, chức vụ, trình độ...">
        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>Mã giảng viên</th>
                <th>Họ Tên</th>
                <th>Trình Độ</th>
                <th>Chức Vụ</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Địa Chỉ</th>
                <th>Hành Động</th>
            </tr>
            </thead>
            <tbody>
            <?php
                                      // Tạo bảng
                if ($result_gv->num_rows > 0) {
                    while ($row = $result_gv->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['ma']}</td>";
                        echo "<td>{$row['hoten']}</td>";
                        echo "<td>{$row['trinhdo']}</td>";
                        echo "<td>{$row['chucvu']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>{$row['sdt']}</td>";
                        echo "<td>{$row['diachi']}</td>";
                        echo "<td>";
                        echo '<button class="btn btn-warning btn-sm" onclick="hienthisuaGv(' .
                            "'{$row['ma']}', '{$row['hoten']}', '{$row['trinhdo']}', '{$row['chucvu']}', '{$row['email']}', '{$row['sdt']}', '{$row['diachi']}'" .
                            ')">Sửa</button>';
                        echo '<button class="btn btn-danger btn-sm" onclick="xoaGv(' . "'{$row['ma']}'" . ')">Xóa</button>';
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Không có dữ liệu giảng viên.</td></tr>";
                }

                    ?>

            </tbody>
        </table>
        </section>

        <div id="modalThemgv" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal('modalThemgv')">&times;</span>
                <h2 class = "title-themm">Thêm mới giảng viên</h2>
                <div class="tabs">
                    <button class="tab-button active" onclick="showTab('tab-manual')">Thêm thủ công</button>
                    <button class="tab-button" onclick="showTab('tab-excel')">Thêm bằng Excel</button>
                </div>
                <div id="tab-manual" class="tab-content active">
                    <form id="formThemgv" method="POST" action="">
                        <div class="form-group">
                            <label for="hoten">Họ Tên</label>
                            <input type="text" id="hoten" name="hoten" required>
                        </div>
                        <div class="form-group">
                            <label for="trinhdo">Trình Độ</label>
                            <select id="trinhdo" name="trinhdo" required>
                                <option value="Cử nhân">Cử nhân</option>
                                <option value="Thạc sĩ">Thạc sĩ</option>
                                <option value="Tiến sĩ">Tiến sĩ</option>
                                <option value="P.Giáo sư">P.Giáo sư</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="chucvu">Chức Vụ</label>
                                <select id="chucvu" name="chucvu" required>
                                    <option value="Giáo vụ">Giáo vụ</option>
                                    <option value="Trợ giảng">Trợ giảng</option>
                                    <option value="Giảng viên">Giảng viên</option>
                                    <option value="Trưởng bộ môn">Trưởng bộ môn</option>
                                    <option value="Trưởng khoa">Trưởng khoa</option>
                                   
                                    <option value="">Không có</option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="chuyenmon">Chuyên Môn</label>
                                <select id="chuyenmon" name="chuyenmon" required>
                                    <option value="Khoa học máy tính">Khoa học máy tính</option>
                                    <option value="Mạng máy tính">Mạng máy tính</option>
                                    <option value="IoT">IoT</option>
                                    <option value="Phát triển phần mền">Phát triển phần mền</option>
                                    <option value="Trí tuệ nhân tạo">Trí tuệ nhân tạo</option>
                                   
                                    <option value="">Không có</option>
                                </select>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="sdt">SĐT</label>
                            <input type="text" id="sdt" name="sdt" required>
                        </div>
                        <div class="form-group">
                            <label for="diachi">Địa Chỉ</label>
                            <input type="text" id="diachi" name="diachi" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="closeModal('modalThemgv')">Hủy</button>
                            <button type="submit" class="btn-submit">Thêm</button>
                        </div>
                    </form>
                </div>
                <div id="tab-excel" class="tab-content" style = "display : none;">
                    <form id="formExcel" enctype="multipart/form-data" method="POST" action="./xulythemgvExcel.php">
                        <div class="form-group">
                            <label for="excelFile">Tải lên file Excel</label>
                            <input type="file" id="excelFile" name="excelFile" accept=".xls,.xlsx" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="closeModal('modalThemgv')">Hủy</button>
                            <button type="submit" class="btn-submit">Tải lên</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


             <!-- Modal sửa giảng viên -->
            <div class="modal" id="model-suagv">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeModal('model-suagv')">&times;</span>
                    <h2 class = "title-themm">Sửa Thông Tin Giảng Viên</h2>
                    <form id="form-suagv">
                        <input type="hidden" id="suagv-ma" name="ma">
                        <div class="form-group">
                            <label for="suagv-hoten">Họ Tên</label>
                            <input type="text" id="suagv-hoten" name="hoten" required>
                        </div>
                        <div class="form-group">
                            <label for="suagv-trinhdo">Trình Độ</label>
                            <select id="suagv-trinhdo" name="trinhdo" required>
                                <option value="Cử nhân">Cử nhân</option>
                                <option value="Thạc sĩ">Thạc sĩ</option>
                                <option value="Tiến sĩ">Tiến sĩ</option>
                                <option value="P.Giáo sư">P.Giáo sư</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="suagv-chucvu">Chức Vụ</label>
                            <select id="suagv-chucvu" name="chucvu" required>
                                <option value="Giảng viên">Giảng viên</option>
                                <option value="Lãnh đạo">Lãnh đạo</option>
                                <option value="Giáo vụ">Giáo vụ</option>
                                <option value="">Không có</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="suagv-email">Email</label>
                            <input type="email" id="suagv-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="suagv-sdt">SĐT</label>
                            <input type="text" id="suagv-sdt" name="sdt" required>
                        </div>
                        <div class="form-group">
                            <label for="suagv-diachi">Địa Chỉ</label>
                            <input type="text" id="suagv-diachi" name="diachi" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="closeModal('model-suagv')">Hủy</button>
                            <button type="button" class="btn-submit" onclick="saveChangesGV()">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>







        <!-- Quản lý sinh viên -->
        <section id="sinhvien-section" class="mb-5">
        <h2 class="mb-4">Quản lý sinh viên</h2>
        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSinhVienModal" onclick="themSv()"  >Thêm mới sinh viên</button>
            <button class="btn btn-secondary" id="xuatExcelSV">Xuất Excel</button>
        </div>
        <input type="text" class="form-control mb-3" id="timSV" placeholder="Tìm kiếm sinh viên theo tên, lớp, điểm tích lũy...">
        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>Mã sinh viên</th>
                <th>Họ Tên</th>
                <th>Địa chỉ</th>
                <th>Lớp</th>
                <th>Khóa</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Điểm Tích Lũy</th>
                <th>Hành Động</th>
            </tr>
            </thead>
            <tbody>
                    <?php
                                        if ($result_sv->num_rows > 0) {
                                            while ($row = $result_sv->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>{$row['ma']}</td>";
                                                echo "<td>{$row['hoten']}</td>";
                                                echo "<td>{$row['diachi']}</td>";
                                                echo "<td>{$row['lop']}</td>";
                                                echo "<td>{$row['khoa']}</td>";
                                                echo "<td>{$row['email']}</td>";
                                                echo "<td>{$row['sdt']}";
                                                echo "<td>{$row['diemtichluy']}";
                                                echo "<td>";
                                                echo '<button class="btn btn-warning btn-sm" onclick="hienthisuaSV(' .
                                                "'{$row['ma']}', '{$row['hoten']}', '{$row['diachi']}', '{$row['diemtichluy']}', '{$row['email']}', '{$row['sdt']}',  '{$row['lop']}','{$row['khoa']}'" .
                                                ')">Sửa</button>';
                                                 echo '<button class="btn btn-danger btn-sm" onclick="xoaSv(' . "'{$row['ma']}'" . ')">Xóa</button>';
                                                echo "</td>";
                                                echo "</tr>";

                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>Không có đề tài nào.</td></tr>";
                                        }
                    ?>

            </tbody>
        </table>
        </section>

        <div id="modalThemSV" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal('modalThemSV')">&times;</span>
                <h2 class = "title-themm">Thêm mới sinh viên</h2>
                <div class="tabs">
                    <button class="tab-button active" onclick="showTab('tab-manualSv')">Thêm thủ công</button>
                    <button class="tab-button" onclick="showTab('tab-excelSv')">Thêm bằng Excel</button>
                </div>
                <div id="tab-manualSv" class="tab-content active">
                    <form id="formThemsv" method="POST" action="./xulythemSV.php">
                        <div class="form-group">
                            <label for="hotenSV">Họ Tên</label>
                            <input type="text" id="hotenSV" name="hotenSV" required>
                        </div>
                        <div class="form-group">
                            <label for="lopSV">Lớp</label>
                            <input type="text" id="lopSV" name="lopSV" required>
                        </div>
                        <div class="form-group">
                            <label for="khoaSV">Khóa</label>
                            <input type="number" id="khoaSV" name="khoaSV" required>
                        </div>
                        <div class="form-group">
                            <label for="diemSV">Điểm tích lũy</label>
                            <input type="text" id="diemSV" name="diemSV" required>
                        </div>
                       
                       
                        <div class="form-group">
                            <label for="emailSV">Email</label>
                            <input type="email" id="emailSV" name="emailSV" required>
                        </div>
                        <div class="form-group">
                            <label for="sdtSV">SĐT</label>
                            <input type="text" id="sdtSV" name="sdtSV" required>
                        </div>
                        <div class="form-group">
                            <label for="diachiSV">Địa Chỉ</label>
                            <input type="text" id="diachiSV" name="diachiSV" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="closeModal('modalThemSV')">Hủy</button>
                            <button type="submit" class="btn-submit">Thêm</button>
                        </div>
                    </form>
                </div>
                <div id="tab-excelSv" class="tab-content" style = "display : none;">
                    <form id="formExcelSv" enctype="multipart/form-data" method="POST" action="./xulythemsvExcel.php">
                        <div class="form-group">
                            <label for="excelFileSV">Tải lên file Excel</label>
                            <input type="file" id="excelFileSV" name="excelFileSV" accept=".xls,.xlsx" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="closeModal('modalThemSV')">Hủy</button>
                            <button type="submit" class="btn-submit">Tải lên</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



               <!-- Modal sửa sinh viên -->
               <div class="modal" id="model-suasv">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeModal('model-suasv')">&times;</span>
                    <h2 class = "title-themm" >Sửa Thông Tin Sinh Viên</h2>
                    <form id="form-suasv">
                        <input type="hidden" id="suasv-ma" name="ma">
                        <div class="form-group">
                            <label for="suasv-hoten">Họ Tên</label>
                            <input type="text" id="suasv-hoten" name="hoten" required>
                        </div>
                        <div class="form-group">
                            <label for="suasv-lop">Lớp</label>
                            <input type="text" id="suasv-lop" name="lop" required>
                        </div>
                        <div class="form-group">
                            <label for="suasv-khoa">Khóa</label>
                            <input type="number" id="suasv-khoa" name="khoa" required>
                        </div>
                        <div class="form-group">
                            <label for="suasv-diem">Điểm tích lũy</label>
                            <input type="text" id="suasv-diem" name="diem" required>
                        </div>
                       
                        <div class="form-group">
                            <label for="suasv-email">Email</label>
                            <input type="email" id="suasv-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="suasv-sdt">SĐT</label>
                            <input type="text" id="suasv-sdt" name="sdt" required>
                        </div>
                        <div class="form-group">
                            <label for="suasv-diachi">Địa Chỉ</label>
                            <input type="text" id="suasv-diachi" name="diachi" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="closeModal('model-suasv')">Hủy</button>
                            <button type="button" class="btn-submit" onclick="saveChangesSV()">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>





                <!-- Quản lý quản trị viên -->
        <section id="quantrivien-section" class="mb-5">
            <h2 class="mb-4">Quản lý quản trị viên</h2>
            <div class="mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuanTriVienModal" onclick="themQT()">Thêm mới quản trị viên</button>
                <button class="btn btn-secondary" id="xuatExcelQT">Xuất Excel</button>
            </div>
            <input type="text" class="form-control mb-3" id="timQT" placeholder="Tìm kiếm quản trị viên theo tên, quyền...">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Mã QTV</th>
                        <th>Họ Tên</th>
                        <th>Địa chỉ</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                                        if ($result_qt->num_rows > 0) {
                                            while ($row = $result_qt->fetch_assoc()) {
                                               
                                                echo "<tr>";
                                                echo "<td>{$row['ma']}</td>";
                                                echo "<td>{$row['hoten']}</td>";
                                                echo "<td>{$row['diachi']}</td>";
                                                echo "<td>{$row['email']}</td>";
                                                echo "<td>{$row['sdt']}";
                                                echo "<td>";
                                                echo '<button class="btn btn-warning btn-sm" onclick="hienthisuaQT(' .
                                                "'{$row['ma']}', '{$row['hoten']}', '{$row['diachi']}', '{$row['email']}', '{$row['sdt']}'" .
                                                ')">Sửa</button>';
                                                 echo '<button class="btn btn-danger btn-sm" onclick="xoaQT(' . "'{$row['ma']}'" . ')">Xóa</button>';
                                                echo "</td>";
                                                echo "</tr>";

                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>Không có đề tài nào.</td></tr>";
                                        }
                    ?>
                    </tr>
                </tbody>
            </table>
        </section>


        <div id="modalThemQT" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal('modalThemQT')">&times;</span>
                <h2 class = "title-themm" >Thêm mới quản trị</h2>
                <div class="tabs">
                    <button class="tab-button active" onclick="showTab('tab-manualQT')">Thêm thủ công</button>
                    <button class="tab-button" onclick="showTab('tab-excelQT')">Thêm bằng Excel</button>
                </div>
                <div id="tab-manualQT" class="tab-content active">
                    <form id="formThemQT" method="POST" action="./xulythemQT.php">
                        <div class="form-group">
                            <label for="hotenQT">Họ Tên</label>
                            <input type="text" id="hotenQT" name="hotenQT" required>
                        </div>
                       
                       
                        <div class="form-group">
                            <label for="emailQT">Email</label>
                            <input type="email" id="emailQT" name="emailQT" required>
                        </div>
                        <div class="form-group">
                            <label for="sdtQT">SĐT</label>
                            <input type="text" id="sdtQT" name="sdtQT" required>
                        </div>
                        <div class="form-group">
                            <label for="diachiQT">Địa Chỉ</label>
                            <input type="text" id="diachiQT" name="diachiQT" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="closeModal('modalThemQT')">Hủy</button>
                            <button type="submit" class="btn-submit">Thêm</button>
                        </div>
                    </form>
                </div>
                <div id="tab-excelQT" class="tab-content" style = "display : none;">
                    <form id="formExcelQT" enctype="multipart/form-data" method="POST" action="#">
                        <div class="form-group">
                            <label for="excelFileQT">Tải lên file Excel</label>
                            <input type="file" id="excelFileQT" name="excelFileQT" accept=".xls,.xlsx" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="closeModal('modalThemQT')">Hủy</button>
                            <button type="submit" class="btn-submit">Tải lên</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


          <!-- Modal sửa quản trị -->
          <div class="modal" id="model-suaqt">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeModal('model-suaqt')">&times;</span>
                    <h2 class = "title-themm" >Sửa Thông Tin Quản Trị</h2>
                    <form id="form-suaqt">
                        <input type="hidden" id="suaqt-ma" name="ma">
                        <div class="form-group">
                            <label for="suaqt-hoten">Họ Tên</label>
                            <input type="text" id="suaqt-hoten" name="hoten" required>
                        </div>
                        <div class="form-group">
                            <label for="suaqt-email">Email</label>
                            <input type="email" id="suaqt-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="suaqt-sdt">SĐT</label>
                            <input type="text" id="suaqt-sdt" name="sdt" required>
                        </div>
                        <div class="form-group">
                            <label for="suaqt-diachi">Địa Chỉ</label>
                            <input type="text" id="suaqt-diachi" name="diachi" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="closeModal('model-suaqt')">Hủy</button>
                            <button type="button" class="btn-submit" onclick="saveChangesQT()">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>



        <!-- Quản lý tài khoản -->
        <section id="taikhoan-section" class="mb-5">
            <h2 class="mb-4">Quản lý tài khoản</h2>
            <!-- <div class="mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaiKhoanModal">Thêm mới tài khoản</button>
            </div> -->
            <input type="text" class="form-control mb-3" id="timTK" placeholder="Tìm kiếm tài khoản theo tên, quyền...">
            <table class="table table-bordered">
                <thead class="table-dark">
                <tr style="background-color: #15972b;">
                    <th>Tên TK</th>
                    <th>Mật khẩu</th>
                    <th>Quyền</th>
                    <th>Trạng thái</th>
                    <th>Liên Kết</th>
                    <th>Hành Động</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($result_tk->num_rows > 0) {
                    while ($row = $result_tk->fetch_assoc()) {
                        $lienket = $row['maqt'] ?? $row['magv'] ?? $row['masv'];
                        echo "<tr>";
                        echo "<td>{$row['tentk']}</td>";
                        echo "<td>
                                <div class='d-flex align-items-center'>
                                    <span class='password-text' style='-webkit-text-security: disc;'>{$row['mk']}</span>
                                    <button class='btn btn-sm btn-outline-secondary ms-2 view-password-btn' 
                                            data-bs-toggle='modal' 
                                            data-bs-target='#modal-mknangcao' 
                                            data-tentk='{$row['tentk']}'>
                                        🔒
                                    </button>
                                </div>
                            </td>";
                        echo "<td>{$row['quyen']}</td>";
                        echo "<td>{$row['trangthai']}</td>";
                        echo "<td>{$lienket}</td>";
                        echo "<td>";
                                                echo '<button class="btn btn-warning btn-sm" onclick="hienthisuaTK(' .
                                                "'{$row['matk']}', '{$row['tentk']}', '{$row['quyen']}', '{$row['mk']}', '{$row['trangthai']}'" .
                                                ')">Sửa</button>';
                                                
                                                echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Không có tài khoản nào.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </section>
        <a class="btn-back" href="./index.php">Trở về</a>
        <div class="modal" id="model-suatk">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal('model-suatk')">&times;</span>
                <h2 class = "title-themm" >Sửa Thông Tin Tài Khoản</h2>
                <form id="form-suatk">
                    <input type="hidden" id="suatk-ma" name="ma">
                    <div class="form-group">
                        <label for="suatk-tentk">Tên tài khoản</label>
                        <input type="text" id="suatk-tentk" name="tentk" required>
                    </div>
                    <div class="form-group">
                        <label for="suatk-mk">Mật khẩu</label>
                        <div class="password-container">
                            <input type="password" id="suatk-mk" name="mk" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('suatk-mk', this)">🔒</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="suatk-quyen">Quyền</label>
                        <select id="suatk-quyen" name="quyen" required>
                            <option value="giaovu">Giáo vụ</option>
                            <option value="lanhdao">Lãnh đạo</option>
                            <option value="sinhvien">Sinh viên</option>
                            <option value="giangvien">Giảng viên</option>
                            <option value="quantri">Quản trị</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="suatk-tt">Trạng thái</label>
                        <select id="suatk-tt" name="tt" required>
                            <option value="Hoạt động">Hoạt động</option>
                            <option value="Vô hiệu hóa">Vô hiệu hóa</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="closeModal('model-suatk')">Hủy</button>
                        <button type="button" class="btn-submit" onclick="saveChangesTK()">Lưu</button>
                    </div>
                </form>
            </div>
        </div>






        <div class="modal fade" id="modal-mknangcao" tabindex="-1" aria-labelledby="modalMKNangCaoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalMKNangCaoLabel">Xác Thực Mật Khẩu Nâng Cao</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-mknangcao">
                            <div class="mb-3">
                                <label for="input-mknangcao" class="form-label">Mật Khẩu Nâng Cao</label>
                                <input type="password" class="form-control" id="input-mknangcao" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Xác Nhận</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



      
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

            <div class="loading-overlay" id="loading-overlay">
                <div class="loader"></div>
            </div>

  <!-- Bootstrap JS -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"> -->
<script src="./assets/javas/quanlynguoidung.js">
  </script>
</body>
</html>
