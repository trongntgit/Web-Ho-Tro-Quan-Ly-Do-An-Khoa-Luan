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

$sql_sv = "select * from sinhvien";
$sql_dot = "SELECT d.id, d.tendot
FROM dotdangky d
LEFT JOIN dotdangky_sinhvien ds ON d.id = ds.id_dotdk
LEFT JOIN dotdangky_detai dd ON d.id = dd.id_dotdk
WHERE ds.id_dotdk IS NULL AND dd.id_dotdk IS NULL;
";
$sql_dt = "select * from detai where (trangthai ='Chờ đăng ký' or trangthai = 'Khóa đăng ký') and duyetlanhdao ='Được duyệt'";
$sql_svdk = "select * from dangkydetai";
$sql_dot2 = "select * from dotdangky";


$stmt_sv = $conn->prepare($sql_sv);
$stmt_sv->execute();
$result_sv = $stmt_sv->get_result();

$stmt_dot = $conn->prepare($sql_dot);
$stmt_dot->execute();
$result_dot = $stmt_dot->get_result();

$stmt_dt = $conn->prepare($sql_dt);
$stmt_dt->execute();
$result_dt = $stmt_dt->get_result();

$stmt_dot2 = $conn->prepare($sql_dot2);
$stmt_dot2->execute();
$result_dot2 = $stmt_dot2->get_result();

// $stmt_tk = $conn->prepare($sql_tk);
// $stmt_tk->execute();
// $result_tk = $stmt_tk->get_result();


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
  <title>Quản lý đợt đăng ký</title>
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
  <h1 class="main-title">Quản lý đợt đăng ký</h1>
  
  
</header>
<div class="container mt-5">
<div class="loading-overlay" id="loading-overlay">
                <div class="loader"></div>
</div>
<section id="dot-dk" class="mb-5">
        <h2 class="mb-4">Các đợt đã tạo</h2>
        <button class="btn btn-primary mt-3" onclick="openModal()">Tạo đợt đăng ký</button>
        <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
            <th>STT</th>
            <th>Tên đợt</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Thao tác</th>
            </tr>
        </thead>
        <tbody id="dot-tbody">
            <?php
            // Giả sử bạn đã truy vấn và lấy danh sách đợt
            $sql = "SELECT * FROM dotdangky";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            $index = 1;
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>{$index}</td>";
              echo "<td>{$row['tendot']}</td>";
              echo "<td>{$row['ngaybatdau']}</td>";
              echo "<td>{$row['ngayketthuc']}</td>";
              echo "<td>";
          
              // Nút mở/đóng dựa vào trạng thái
              if ($row['trangthai'] === "Đóng") {
                  echo "<button class='btn btn-success btn-sm' onclick='moDot({$row['id']})'>Mở đợt</button>";
              } elseif ($row['trangthai'] === "Mở") {
                  echo "<button class='btn btn-warning btn-sm' onclick='dongDot({$row['id']})'>Đóng đợt</button>";
              }
          
              echo "<button class='btn btn-danger btn-sm' onclick='xoaDot({$row['id']})'>Xóa</button>";
              echo "<button class='btn btn-warning btn-sm' onclick='suaDot(
                      {$row['id']}, 
                      \"" . addslashes($row['tendot']) . "\", 
                      \"" . $row['ngaybatdau'] . "\", 
                      \"" . $row['ngayketthuc'] . "\"
                  )'>Sửa</button>";
          
              echo "</td>";
              echo "</tr>";
          
              $index++;
          }
            } else {
            echo "<tr><td colspan='5'>Không có đợt đăng ký nào.</td></tr>";
            }
            ?>
        </tbody>
        </table>

    </select>
  </div>



<div class="container mt-5">
<section id="them-dot-dang-ky" class="mb-5">
  <h2 class="mb-4">Thêm vào đợt đăng ký</h2>
  <!-- Bộ lọc khóa và đợt -->
  <div class="mb-3">
    <label for="filter-khoa" class="form-label">Chọn khóa:</label>
    <select id="filter-khoa" class="form-select" onchange="locSinhVienTheoKhoaVaDot()">
      <option value="all">Tất cả</option>
      <option value="44">Khóa 44</option>
      <option value="45">Khóa 45</option>
      <option value="46">Khóa 46</option>
      <option value="47">Khóa 47</option>
    </select>
  </div>
  
  <div class="mb-3">
    <label for="filter-dotdk" class="form-label">Chọn đợt:</label>
    <select id="filter-dotdk" class="form-select" >
  
     
      <?php
      if ($result_dot->num_rows > 0) {
        while ($row = $result_dot->fetch_assoc()) {
          echo "<option value='{$row['id']}'>{$row['tendot']}</option>";
        }
      }
      ?>
    </select>
  </div>

  <!-- Bảng danh sách sinh viên -->
  <h4>Danh sách sinh viên</h4>
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th><input type="checkbox" id="select-all-sv" onclick="selectAll('sv')"></th>
        <th>Mã sinh viên</th>
        <th>Họ tên</th>
        <th>Lớp</th>
        <th>Khóa</th>
      </tr>
    </thead>
    <tbody id="sinhvien-tbody">
      <!-- PHP: Danh sách sinh viên -->
      <?php
      if ($result_sv->num_rows > 0) {
        while ($row = $result_sv->fetch_assoc()) {
          echo "<tr>";
          echo "<td><input type='checkbox' class='checkbox-sv' value='{$row['ma']}'></td>";
          echo "<td>{$row['ma']}</td>";
          echo "<td>{$row['hoten']}</td>";
          echo "<td>{$row['lop']}</td>";
          echo "<td>{$row['khoa']}</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='5'>Không có sinh viên.</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <!-- Bảng danh sách đề tài -->
  <h4>Danh sách đề tài đã duyệt</h4>
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th><input type="checkbox" id="select-all-dt" onclick="selectAll('dt')"></th>
        <th>Mã đề tài</th>
        <th>Tên đề tài</th>
        <th>Giảng viên hướng dẫn</th>
      </tr>
    </thead>
    <tbody id="detai-tbody">
      <!-- PHP: Danh sách đề tài -->
      <?php
      if ($result_dt->num_rows > 0) {
        while ($row = $result_dt->fetch_assoc()) {
          echo "<tr>";
          echo "<td><input type='checkbox' class='checkbox-dt' value='{$row['madetai']}'></td>";
          echo "<td>{$row['madetai']}</td>";
          echo "<td>{$row['tendetai']}</td>";
          echo "<td>{$row['tengv']}</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='4'>Không có đề tài nào.</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <button class="btn btn-primary mt-3" onclick="themDotDangKy()">Thêm vào đợt đăng ký</button>
</section>
<section id="sinhvien-dot-section" class="mb-5">
  <h2 class="mb-4">Sinh viên chưa có đề tài theo đợt</h2>

  <!-- Lọc đợt -->
  <div class="mb-3">
    <label for="filter-dot-sv" class="form-label">Chọn đợt:</label>
    <select id="filter-dot-sv" class="form-select" onchange="locSinhVienChuaCoDeTai(); loadDeTaiChuaDuSinhVien(this.value);">
        <!-- PHP: Load các đợt đăng ký -->
        <?php
      if ($result_dot2->num_rows > 0) {
        while ($row = $result_dot2->fetch_assoc()) {
          echo "<option value='{$row['id']}'>{$row['tendot']}</option>";
        }
      }
      ?>
    </select>
  </div>

  <!-- Bảng sinh viên chưa có đề tài -->
  <h4>Danh sách sinh viên</h4>
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Chọn</th>
        <th>Mã sinh viên</th>
        <th>Họ tên</th>
        <th>Lớp</th>
        <th>Lý do</th>
      </tr>
    </thead>
    <tbody id="sinhvien-chua-tbody">
   
    </tbody>
  </table>

  <!-- Bảng đề tài chưa đủ sinh viên -->
  <h4>Danh sách đề tài chưa đủ sinh viên</h4>
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Chọn</th>
        <th>Mã đề tài</th>
        <th>Tên đề tài</th>
        <th>Số lượng sinh viên hiện tại</th>
        <th>Số lượng tối đa</th>
      </tr>
    </thead>
    <tbody id="detai-assign-tbody">
     
    </tbody>
  </table>

  <button class="btn btn-primary mt-3" onclick="assignDeTai()">Gán đề tài</button>
</section>

<a class="btn-back" href="./index.php">Trở về</a>
</div>

<!-- Modal Tạo đợt đăng ký -->
<div id="createDotModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h5>Tạo đợt đăng ký</h5>
      <span class="close" onclick="closeModal()">&times;</span>
    </div>
    <div class="modal-body">
      <form id="createDotForm">
        <div class="mb-3">
          <label for="dot-name" class="form-label">Tên đợt đăng ký:</label>
          <input type="text" id="dot-name" class="form-control" required placeholder="Nhập tên đợt đăng ký">
        </div>
        <div class="mb-3">
          <label for="start-date" class="form-label">Ngày bắt đầu:</label>
          <input type="date" id="start-date" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="end-date" class="form-label">Ngày kết thúc:</label>
          <input type="date" id="end-date" class="form-control" required>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn" onclick="closeModal()">Đóng</button>
      <button type="button" class="btn" onclick="taoDotDangKy()">Tạo đợt</button>
    </div>
  </div>
</div>

<!-- Modal Sửa đợt đăng ký -->
<div id="modal-sua" class="modal" style="display:none;">
  <div class="modal-content">
    <div class="modal-header">
      <h5>Sửa đợt đăng ký</h5>
      <span class="close" onclick="dongModal()">&times;</span>
    </div>
    <div class="modal-body">
      <form id="form-sua-dot">
        <input type="hidden" id="edit-dot-id" name="id">
        
        <div class="mb-3">
          <label for="edit-dot-name" class="form-label">Tên đợt:</label>
          <input type="text" id="edit-dot-name" name="dot_name" class="form-control" required>
        </div>
        
        <div class="mb-3">
          <label for="edit-start-date" class="form-label">Ngày bắt đầu:</label>
          <input type="date" id="edit-start-date" name="start_date" class="form-control" required>
        </div>
        
        <div class="mb-3">
          <label for="edit-end-date" class="form-label">Ngày kết thúc:</label>
          <input type="date" id="edit-end-date" name="end_date" class="form-control" required>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn" onclick="dongModal()">Đóng</button>
          <button type="button" class="btn" onclick="capNhatDot()">Cập nhật</button>
        </div>
      </form>
    </div>
  </div>
 >
</div>







<!-- Scripts -->
<script src="./assets/javas/quanlydotdk.js"></script>
</body>
</html>
