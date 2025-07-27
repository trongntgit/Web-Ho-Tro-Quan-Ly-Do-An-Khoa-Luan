<?php
        session_start();
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

    <!--Phần reset css -->
    <link rel="stylesheet" href="./assets/css/reset.css">

    <!--Phần custom css -->
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Quản lý đồ án, khóa 
    luận</title>
    <body>
     <main >
        <!--Phần header menu -->
        <header class="heaader fixed">
            <div class="content">
                <div class="body">
                <div class="logo">  
                    <a href="" class="logo-container">
                        <img src="./imge/logo.png" alt="Logo." class="logo_img">
                        <div class="logo-text-container">
                            <span class="logo-title">Hệ thống quản lý</span>
                            <span class="logo-subtitle">Đồ án, khóa luận</span>
                        </div>
                    </a>
                </div>


                    <nav class="nav">
                        <ul id="big-option">
                            <li class="active" ><a href="#" name="summary" >Trang chủ</a></li>
                            <li class="li-s"><a href="#search" name="search">Đề tài & Tiến độ</a></li>
                            <li><a href="#contact" name="contact" >Phân công</a></li>
                            <li><a href="" name="envent">Hội đồng bảo vệ</a></li>
                        </ul>
                    </nav>
                    <!--Nut dang nhap-->
                  
                    <a href="./login.php" class="btn dangnhap" id="btndn">Đăng nhập</a>
                      <!-- Biểu tượng người dùng -->
                      <nav class="navbar">
                            <div class="navbar-content">
                            <div class="notification-container" id="notification-container" style="position: relative;">
                                <!-- Biểu tượng thông báo -->
                                <div id="notificationIcon" class="notification-icon">
                                    <img src="./imge/notification.png" alt="Notification Icon" width="40" height="40">
                                    <!-- Số lượng thông báo -->
                                    <div id="notificationCount" class="notification-count">0</div>
                                </div>

                                <!-- Menu thả xuống thông báo -->
                                <div id="notificationMenu" class="notification-menu" style="display: none;">
                                    <div class="notification-header">Thông báo</div>
                                    <div id="notificationList" class="notification-list">
                                        <!-- Các thông báo sẽ được thêm vào đây -->
                                        <div class="notification-item">Bạn chưa có thông báo mới</div>
                                    </div>
                                </div>
                            </div>



                                <div class="user-info">
                                    <img src="./imge/user2.png" alt="User Icon" id="userIcon" class="user-icon" width="40" height="40">
                                    <span id="name"></span>
                                    <div id="userMenu" class="user-menu">
                                        <div class="div-option">
                                            <a class="a-option" href="#" id="infoButton">
                                                <img class="img-option" src="./imge/info.png" alt=""><span>Thông tin</span>
                                            </a>
                                        </div>
                                        <div class="div-option" id="qlnd">
                                            <a class="a-option" href="" id="nhansuButton">
                                                <img class="img-option" src="./imge/nhansu.png" alt=""><span>Quản lý người dùng</span>
                                            </a>
                                        </div>
                                        <div class="div-option" id="qldotdk">
                                            <a class="a-option" href="./quanlydotdk.php" id="dotButton">
                                                <img class="img-option" src="./imge/quanlydk.png" alt=""><span>Quản lý đợt đăng ký</span>
                                            </a>
                                        </div>
                                        <div class="div-option" id="qldiem">
                                            <a class="a-option" href="./quanlydiem.php" id="qldiemButton">
                                                <img class="img-option" src="./imge/quanlydiem.png" alt=""><span>Quản lý điểm</span>
                                            </a>
                                        </div>
                                        
                                        <div class="div-option" id="dtct">
                                            <a class="a-option" href="" id="detaiButton">
                                                <img class="img-option" src="./imge/detai.png" alt=""><span>Đề tài của tôi</span>
                                            </a>
                                        </div>
                                        <div class="div-option" id="ddt">
                                            <a class="a-option" href="./detaicuatoilanhdao.php" id="duyetButton">
                                                <img class="img-option" src="./imge/detai.png" alt=""><span>Duyệt đề tài</span>
                                            </a>
                                        </div>

                                        <div class="div-option" id="cddt">
                                            <a class="a-option" href="./chamdiem.php" id="chamdiemButton">
                                                <img class="img-option" src="./imge/chamdiem.png" alt=""><span>Chấm điểm đề tài</span>
                                            </a>
                                        </div>
                                        <div class="div-option">
                                            <a class="a-option" href="./changepw.php">
                                                <img class="img-option" src="./imge/changpw.png" alt=""><span>Đổi mật khẩu</span>
                                            </a>
                                        </div>
                                        <div class="div-option">
                                            <a class="a-option" href="#" id="logoutButton">
                                                <img class="img-option" src="./imge/logout.png" alt=""><span>Đăng xuất</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="overlay"></div>

                            <!-- Hộp thoại thông tin nhân viên -->
                            <div id="employeeInfoDialog" style="display: none;">
                                <div class="dialog-header">
                                    <span class="dialog-title">Thông tin người dùng</span>
                                    <span class="close" id="dong-info">&times;</span>
                                </div>
                                <div id="employeeInfoContent"></div>
                            </div>
                        </nav>

                        
                </div>
            </div>  

        </header>
      
    
        <!--Phần giới thiệu tóm tăt trang web  SUMMARY-->
        <div class="summary con" id="summary">
            <div class="content">
                <div class="body">
                    <div class="list_summary">

                        
                        <div class="item">
                            <p class="hi" style="margin-top: 100px;">Trang web hỗ trợ quản lý <strong>đồ án, khóa luận</strong> trực tuyến</p>
                        </div>
                        <!-- item 2 -->
                        <div class="item">
                            <p class="info">
                                
                            </p>
                        </div>
                         <!--item 3 -->
                        <div class="item">
              
                        <p class="hi" style="margin-top: 100px;">Trang web còn rất nhiều thiếu sót mong nhận được sự góp ý của cô và các bạn</p>
                            
                        </div>

                    </div>
                    <div class="controls">
                        <button class="control-btn" onclick="tran_left()">
                            <svg
                                width="8"
                                height="14"
                                viewBox="0 0 8 14"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M7 1L1 7L7 13"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </button>
                        <button class="control-btn" onclick="tran_right()">
                            <svg
                                width="8"
                                height="14"
                                viewBox="0 0 8 14"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M1 1L7 7L1 13"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="featured">
                    <div class="content">
                        <header>
                            <h2 class="sub-title">Tin tức nổi bật</h2>
                            <button onclick="hienFormThemTinTuc('tin_tuc')" id="them-tin-tuc">Thêm Tin Tức</button>
                        </header>
                        <div class="carousel" id="carousel-tin-tuc">
                            <button class="prev-btn">&lt;</button>
                            <div class="list">
                                <!-- Tin tức sẽ được tải động -->
                            </div>
                            <button class="next-btn">&gt;</button>
                        </div>
                    </div>
                </div>
                <div id="overlay-tin-tuc">
                        <div id="modal-tin-tuc" class="modal" style="display : none;">
                            <form id="form-tin-tuc">
                                <h3 id="form-tin-tuc-title">Thêm Tin Tức</h3>
                                <input type="hidden" id="tin-tuc-id">
                                <label for="tin-tuc-title-input">Tiêu đề:</label>
                                <input type="text" id="tin-tuc-title-input" required>
                                <label for="tin-tuc-desc-input">Mô tả:</label>
                                <textarea id="tin-tuc-desc-input" required></textarea>
                                <label for="tin-tuc-img-input">URL Ảnh:</label>
                                <input type="text" id="tin-tuc-img-input" required>
                                <label for="tin-tuc-url-input">Đường dẫn bài viết:</label>
                                <input type="text" id="tin-tuc-url-input" required>
                                <label for="tin-tuc-date-input">Ngày:</label>
                                <input type="date" id="tin-tuc-date-input" required>
                                <button type="submit" id="tin-tuc-save-btn">Lưu</button>
                                <button type="button" id="tin-tuc-cancel-btn" onclick="dongFormTinTuc()">Hủy</button>
                            </form>
                        </div>

                    </div>
                

        </div>
        

        <!--Phần search-->
        <div class="search con" id="search">
    <div class="content">
        <div class="body">
                    
                    <div class="search-top">
                            <h1 class="title">Tìm kiếm đề tài đồ án , khóa luận</h1>
                            <div class="search-input">
                                <form action="./xulytimdetai.php" method="POST">
                                        <div class="input">
                                            <input type="text" id="madt" name="madt" placeholder=" Nhập vào tên/mã đề tài...." onkeyup="searchSuggestion()">
                                            <div id="suggestions" class="suggestions"></div>
                                        </div>
                                        <button class="btn" type="submit" id="tracuu">Tìm kiếm</button>

                                
                                    <div class="input-list">
                                        <select name="branch" id="branch" style="height: 40px; width: 120px;"  onchange="searchSuggestion()" >
                                            <?php
                                               // Kết nối CSDL và thực hiện truy vấn
                                               $sever = "localhost";
                                               $data = "doan2";
                                               $user = "root";
                                               $pass = "";
                                               $port = 3309;
                                               $con = mysqli_connect($sever, $user, $pass, $data, $port);

                                               if (!$con) {
                                                   die("Kết nối CSDL thất bại: " . mysqli_error($con));
                                               }

                                               // Truy vấn SQL để lấy mã môn và tên môn từ bảng môn học
                                               $query = "SELECT ma,hoky,nambd,namkt FROM hocky";
                                               $result = mysqli_query($con, $query);
                                               echo '<option value="">Tất cả học kỳ</option>';
                                               // Hiển thị các tùy chọn
                                               while ($row = mysqli_fetch_assoc($result)) {
                                               
                                                   echo '<option value="' . $row['ma'] . '">Học kỳ ' . $row['hoky'] . ', ' . $row['nambd'] . ' - ' . $row['namkt'] . '</option>';

                                               }

                                               // Đóng kết nối CSDL
                                               mysqli_close($con);
                                            ?>
                                        </select>
                                        <select name="loaidetai" id="bra-loaidetai" style="height: 40px; width: 120px;" onchange="searchSuggestion()">
                                            <option value="">Tất cả loại đề tài</option>
                                            <option value="Khóa luận">Khóa luận</option>
                                            <option value="Đồ án 1">Đồ án 1</option>
                                            <option value="Đồ án 2">Đồ án 2</option>
                                        </select>
                                    </div>
                                </form>

                                    <div class="them-btn">
                                        <button class="btn-them" id="btn-them">Thêm mới</button>
                                    </div>

                               <!-- Dialog thêm mới -->
                                    <div id="dialog-them" class="modal">
                                        <div class="modal-content" style="height: 980px;">
                                            <span class="dialog-title">Thêm mới đề tài</span>
                                            <hr>

                                            <!-- Tabs -->
                                            <div class="tab-container">
                                                <button class="tab-link chon" onclick="openTab(event, 'manualForm')">Thêm thủ công</button>
                                                <button class="tab-link" id="upfile-them">Upload file</button>
                                            </div>

                                            <!-- Giao diện Thêm thủ công (Tab 1) -->
                                            <div id="manualForm" class="tab-content" style="display: block;">
                                                <form id="form-them" class="form-grid" action="./xulythemdetai.php" method="POST">
                                                    <div class="form-group">
                                                        <label for="tengv">Tên giáo viên :</label>
                                                        <input type="text" id="tengv" name="tengv" disabled>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="tendetai">Tên đề tài</label>
                                                        <input type="text" id="tendetai" name="tendetai" required>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="loaidetai">Loại đề tài</label>
                                                        <select id="loaidetai" name="loaidetai" required>
                                                            <option value="Khóa luận">Khóa luận</option>
                                                            <option value="Đồ án 1">Đồ án 1</option>
                                                            <option value="Đồ án 2">Đồ án 2</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="linhvuc">Lĩnh vực</label>
                                                        <select id="linhvuc" name="linhvuc" required>
                                                            <option value="Khoa học máy tính">Khoa học máy tính</option>
                                                            <option value="Mạng máy tính">Mạng máy tính</option>
                                                            <option value="Trí tuệ nhân tạo">Trí tuệ nhân tạo</option>
                                                            <option value="IoT">IoT</option>
                                                            <option value="Phát triển phần mền">Phát triển phần mền</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="tg-batdau">Thời gian bắt đầu:</label>
                                                        <input type="date" id="tg-batdau" name="tg_batdau" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="tg-ketthuc">Thời gian kết thúc:</label>
                                                        <input type="date" id="tg-ketthuc" name="tg_ketthuc" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="solmax">Số lượng tối đa:</label>
                                                        <input type="number" id="solmax" name="solmax" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="ma-hocky">Học kỳ:</label>
                                                        <select name="mahocky" id="mahocky">
                                                            <?php
                                                                // Kết nối CSDL và thực hiện truy vấn
                                                                $sever = "localhost";
                                                                $data = "doan2";
                                                                $user = "root";
                                                                $pass = "";
                                                                $port = 3309;
                                                                $con = mysqli_connect($sever, $user, $pass, $data, $port);

                                                                if (!$con) {
                                                                    die("Kết nối CSDL thất bại: " . mysqli_error($con));
                                                                }

                                                                // Truy vấn SQL để lấy mã môn và tên môn từ bảng môn học
                                                                $query = "SELECT ma, hoky, nambd, namkt FROM hocky";
                                                                $result = mysqli_query($con, $query);
                                                            
                                                                // Hiển thị các tùy chọn
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo '<option value="' . $row['ma'] . '">Học kỳ ' . $row['hoky'] . ', ' . $row['nambd'] . ' - ' . $row['namkt'] . '</option>';
                                                                }

                                                                // Đóng kết nối CSDL
                                                                mysqli_close($con);
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="mota">Mô tả:</label>
                                                        <textarea id="mota" name="mota" required rows="4" style="width: 100%; resize: none;"></textarea>
                                                    </div>

                                                    <div class="form-group full-width">
                                                        <button type="button" class="btn-luu" onclick="submitForm()">Lưu</button>
                                                        <button type="button" id="dong-dialog" class="btn-dong">Đóng</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Giao diện Upload file (Tab 2) -->
                                            <div id="uploadForm" class="tab-content" style="display: none;">
                                                <form id="uploadExcelForm" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="excelFile">Chọn file để upload:</label>
                                                        <input type="file" name="excelFile" id="excelFile" accept=".xlsx, .xls">
                                                    </div>
                                                    <div class="form-group full-width">
                                                        <button type="button" class="btn-luu" id="uploadBtn">Tải lên</button>
                                                        <button type="button" id="dong-dialog2" class="btn-dong">Đóng</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                </div>


                                
                            </div>
                        
                            <div class="contan-item">
                                 <div id="search-results1"></div>
                            </div>

                            <!-- Modal Dialog -->
                            <div id="editModal" class="modal">
                            <div class="modal-content">
                                <span class="close" id="dong-sua">&times;</span>
                                <h2 class="dialog-title">Sửa thông tin đề tài</h2>
                                <form id="editForm">
                                <label for="modal-madetai">Mã đề tài :</label>
                                <input type="text" id="modal-madetai" disabled>
                                
                                <label for="modal-tendetai">Tên đề tài:</label>
                                <input type="text" id="modal-tendetai">

                                <label for="modal-tg_batdau">Thời gian bắt đầu :</label>
                                <input type="date" id="modal-tg_batdau">

                                <label for="modal-tg_ketthuc">Thời gian hoàn thành :</label>
                                <input type="date" id="modal-tg_ketthuc">

                                <label for="sua-solmax">Số lượng tối đa :</label>
                                <input type="number" id="sua-solmax">

                                <label for="sua-mota">Mô tả:</label>
                                <textarea id="sua-mota" name="sua-mota" required rows="4" style="width: 100%; resize: none;"></textarea>

                                <button type="button" id="saveBtn">Lưu</button>
                                </form>
                            </div>
                            </div>
                                                            
                        
                    </div>
                        
    
                   
                    

        </div>
    </div>               
</div>
       

        
        <!--Phân công-->
        <div class="contact con" id="contact">
           <div class="content">
                <div class="body">
                    <div class="search-top">
                        <h1 class="title">Tìm kiếm bảng phân công</h1>
                        <div class="search-input">
                            <form action="./xulytimbcc2.php" method="POST">
                                <div class="input">
                                    <input type="text" id="malop2" name="malop" placeholder=" Nhập vào tên/mã đề tài...." onkeyup="searchSuggestion2()">
                                    <div id="suggestions2" class="suggestions"></div>
                                </div>
                                <button class="btn" type="button" style="  margin-left: 0px; "  id="tracuu2">Tìm kiếm</button>
                                <div class="input-list">
                                <select name="loaidetai-phancong" id="bra-loaidetai-phancong" style="height: 40px; width: 120px;" onchange="searchSuggestion2()">
                                            <option value="">Tất cả loại đề tài</option>
                                            <option value="Khóa luận">Khóa luận</option>
                                            <option value="Đồ án 1">Đồ án 1</option>
                                            <option value="Đồ án 2">Đồ án 2</option>
    
                                </select>
                                    </div>

                            </form>

                        </div>

                    </div>
                    <div class="contan-item">
                                 <div id="search-results-phancong"></div>
                    </div>
                    <h1 class="title" id="tl-phancong">Quản lý phân công đồ án, khóa luận</h1>
                    <div class="section phan-cong" id="section phan-cong">

                            <!-- Section Đồ án -->
                            <section id="do-an-section" class="section detai">
                               
                                <h2 class="section-header">Danh sách Đồ án cần phân công</h2>
                                <div class="filter-group">
                                <select class="form-control filter-select" id="filter-do-an-khoa" aria-label="Chọn khóa">
                                    <?php
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
                                            $sql_dot = "select * from dotdangky";
                                            $stmt_dot = $conn->prepare($sql_dot);
                                            $stmt_dot->execute();
                                            $result_dot = $stmt_dot->get_result();
                                            if ($result_dot->num_rows > 0) {
                                                while ($row = $result_dot->fetch_assoc()) {
                                                echo "<option value='{$row['id']}'>{$row['tendot']}</option>";
                                                }
                                            }
                                            ?>
                                </select>
                                <input type="text" class="form-control filter-search" id="search-do-an" placeholder="Tìm kiếm theo tên đề tài, giảng viên hướng dẫn...">
                                </div>

                                <table class="table detai-table">
                                <thead>
                                    <tr>
                                    <th>Mã đề tài</th>
                                    <th>Tên đề tài</th>
                                    <th>Sinh viên thực hiện</th>
                                    <th>Lĩnh vực</th>
                                    <th>Giáo viên hướng dẫn</th>
                                    <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="do-an-table-body">
                                    <!-- Dữ liệu sẽ được tải vào đây bằng JavaScript -->
                                </tbody>
                                </table>
                            </section>
                            <!-- Lịch sử phân công Đồ án -->
                            <section id="lich-su-phan-cong-do-an" class="section">
                                <h2 class="section-header">Lịch sử phân công Đồ án</h2>
                                <table class="table detai-table">
                                    <thead>
                                        <tr>
                                            <th>Mã đề tài</th>
                                            <th>Tên đề tài</th>
                                            <th>Giáo viên hướng dẫn</th>
                                            <th>Phản biện</th>
                                            <th>Ngày phân công</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lich-su-table-body-do-an">
                                        <!-- Lịch sử phân công cho Đồ án sẽ được tải vào đây bằng JavaScript -->
                                    </tbody>
                                </table>
                            </section>

                            <!-- Section Khóa luận -->
                            <section id="khoa-luan-section" class="section detai">
                                <h2 class="section-header">Danh sách Khóa luận cần phân công</h2>
                                <div class="filter-group">
                                <select class="form-control filter-select" id="filter-khoa-luan-khoa" aria-label="Chọn khóa">
                                        <?php
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
                                                $sql_dot = "select * from dotdangky";
                                                $stmt_dot = $conn->prepare($sql_dot);
                                                $stmt_dot->execute();
                                                $result_dot = $stmt_dot->get_result();
                                                if ($result_dot->num_rows > 0) {
                                                    while ($row = $result_dot->fetch_assoc()) {
                                                    echo "<option value='{$row['id']}'>{$row['tendot']}</option>";
                                                    }
                                                }
                                                ?>
                                </select>
                                <input type="text" class="form-control filter-search" id="search-khoa-luan" placeholder="Tìm kiếm theo tên đề tài, giảng viên hướng dẫn...">
                                </div>

                                <table class="table detai-table">
                                <thead>
                                    <tr>
                                    <th>Mã đề tài</th>
                                    <th>Tên đề tài</th>
                                    <th>Sinh viên thực hiện</th>
                                    <th>Lĩnh vực</th>
                                    <th>Giáo viên hướng dẫn</th>
                                    <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="khoa-luan-table-body">
                                    <!-- Dữ liệu sẽ được tải vào đây bằng JavaScript -->
                                </tbody>
                                </table>
                            </section>

                            <!-- Lịch sử phân công Khóa luận -->
                            <section id="lich-su-phan-cong-khoa-luan" class="section">
                                <h2 class="section-header">Lịch sử phân công Khóa luận</h2>
                                <table class="table detai-table">
                                    <thead>
                                        <tr>
                                            <th>Mã đề tài</th>
                                            <th>Tên đề tài</th>
                                            <th>Thư ký</th>
                                            <th>Phản biện</th>
                                            <th>Chủ tịch</th>
                                            <th>Ngày phân công</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lich-su-table-body-khoa-luan">
                                        <!-- Lịch sử phân công cho Khóa luận sẽ được tải vào đây bằng JavaScript -->
                                    </tbody>
                                </table>
                            </section>

                    </div>
                    <div id="modal-phancongda" class="modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Phân công đồ án</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Nội dung được load từ JavaScript -->
                                            </div>
                                            <div class="modal-footer">
                                                <button id="btn-save-phancongda" class="btn btn-primary" onclick="savePhanCongda()">Lưu</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModalda()">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="modalSuaPhanCong-da" class="modal">
                                    <div class="modal-content">
                                        <span class="close"  onclick="closeModalSuaPhanCongda()">&times;</span>
                                        <h2 class="modal-title">Sửa Phân Công</h2>
                                        <div id="modal-body-sua-da">
                                            <p>Đang tải dữ liệu...</p>
                                        </div>
                                        <button class="btn btn-primary" onclick="luuSuaPhanCongda()">Lưu</button>
                                    </div>
                                </div>





                                <div id="modal-phancong" class="modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Phân công khóa luận</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Nội dung được load từ JavaScript -->
                                            </div>
                                            <div class="modal-footer">
                                                <button id="btn-save-phancong" class="btn btn-primary" onclick="savePhanCongkl()">Lưu</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModalkl()">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div id="modalSuaPhanCong" class="modal">
                                    <div class="modal-content">
                                        <span class="close" onclick="closeModalSuaPhanCong()">&times;</span>
                                        <h2 class="modal-title">Sửa Phân Công</h2>
                                        <div id="modal-body-sua">
                                            <p>Đang tải dữ liệu...</p>
                                        </div>
                                        <button class="btn btn-primary" onclick="luuSuaPhanCong()">Lưu </button>
                                    </div>
                                </div>


                </div>

            </div>
        </div>


       


                 
        
        
                 <!-- Phan hội đồng-->
                        <div class="envent con" id="envent">
                            <div class="content">
                                <div class="body">
                                <div class="search-top">
                                    <h1 class="title">Tìm kiếm lịch, kết quả </h1>
                                    <div class="search-input">
                                        <form action="./xulytimbcc2.php" method="POST">
                                                <div class="input">
                                                    <input type="text" id="malop3" name="malop3" placeholder=" Nhập vào tên/mã đề tài...." onkeyup="searchSuggestion3()">
                                                    <div id="suggestions3" class="suggestions"></div>
                                                </div>
                                                <button class="btn" type="button" id="tracuu-env">Tìm kiếm</button>
                                               
                                        
                                            <div class="input-list">
                                                <select name="loaidetai-hoidong" id="bra-loaidetai-hoidong" style="height: 40px; width: 120px;" onchange="searchSuggestion3()">
                                                    <option value="">Tất cả loại đề tài</option>
                                                    <option value="Khóa luận">Khóa luận</option>
                                                    <option value="Đồ án 1">Đồ án 1</option>
                                                    <option value="Đồ án 2">Đồ án 2</option>
    
                                                 </select>
                                            </div>
                                        </form>


                                  
                                </div>
                                <div class="contan-item">
                                    <div id="search-results-hoidong"></div>
                                </div>
                                <div class="control-envet" id="control-envet">
                                    <h1 class="title sl">Sắp lịch bảo vệ khóa luận</h1>
                                    <button class="btn-them" id="btn-them-buoi">Thêm buổi bảo vệ</button>
                                    
                                </div>
                                <div class="section buoibaove" id="section buoibaove"> 
                                    <section id="buoibaaove" class="section">
                                        <h2 class="section-header">Danh sách các buổi đã thêm</h2>
                                        <section id="buoidathem" class="section">
                                                <table class="table detai-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Tên buổi bảo vệ</th>
                                                            <th>Địa điểm</th>
                                                            <th>Thư ký</th>
                                                            <th>Ngày</th>
                                                            <th>Học kỳ</th>
                                                            <th>Hành động</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-body-buoi">
                                                        <?php
                                                        // Kết nối cơ sở dữ liệu
                                                        $server = "localhost";
                                                        $database = "doan2";
                                                        $user = "root";
                                                        $password = "";
                                                        $port = 3309;

                                                        $con = mysqli_connect($server, $user, $password, $database, $port);

                                                        if (!$con) {
                                                            die("Kết nối CSDL thất bại: " . mysqli_connect_error());
                                                        }

                                                        // Truy vấn SQL để lấy dữ liệu
                                                        $query = "
                                                                SELECT 
                                                                            buoibaove.id AS mabuoi, -- ID của buổi bảo vệ
                                                                            buoibaove.TenBuoi AS tenbuoi, 
                                                                            buoibaove.DiaDiem AS diadiem, 
                                                                            giangvien.hoten AS thuky, 
                                                                            buoibaove.Ngay AS ngay, 
                                                                            buoibaove.ThuKy AS mathuky,
                                                                            CONCAT('Học kỳ ', hocky.hoky, ' (', hocky.nambd, '-', hocky.namkt, ')') AS hocky
                                                                        FROM 
                                                                            buoibaove
                                                                        JOIN 
                                                                            giangvien ON giangvien.ma = buoibaove.ThuKy
                                                                        JOIN 
                                                                            hocky ON hocky.ma = buoibaove.HocKy
                                                                        WHERE 
                                                                            buoibaove.trangthai = 'Chưa diễn ra' and buoibaove.saplich = 0
                                                        ";

                                                        $result = mysqli_query($con, $query);

                                                        if (!$result) {
                                                            die("Lỗi truy vấn: " . mysqli_error($con));
                                                        }

                                                        // Hiển thị dữ liệu trong bảng
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo '<tr>';
                                                            echo '<td>' . htmlspecialchars($row['tenbuoi']) . '</td>';
                                                            echo '<td>' . htmlspecialchars($row['diadiem']) . '</td>';  
                                                            echo '<td>' . htmlspecialchars($row['thuky']) . '</td>';
                                                            echo '<td>' . htmlspecialchars($row['ngay']) . '</td>';
                                                            echo '<td>' . htmlspecialchars($row['hocky']) . '</td>';   
                                                            echo '<td>';
                                                            echo '<button class="btn-danger" onclick="deleteBuoi(\'' . $row['mabuoi'] . '\')">Xóa</button>';
                                                            echo '<button class="btn-primary" onclick="saplichBuoi(\'' 
                                                            . addslashes($row['mabuoi']) . '\', \'' 
                                                            . addslashes($row['tenbuoi']) . '\', \'' 
                                                            . addslashes($row['diadiem']) . '\', \'' 
                                                            . addslashes($row['thuky']) . '\', \'' 
                                                            . addslashes($row['mathuky']) . '\', \'' 
                                                            . addslashes($row['ngay']) . '\')">Sắp lịch</button>';
                                                        
                                                            echo '</td>';
                                                            
                                                            echo '</tr>';
                                                        }

                                                        // Đóng kết nối cơ sở dữ liệu
                                                        mysqli_close($con);
                                                        ?>
                                                    </tbody>
                                                </table>


                                        </section>
                                        



                                        <h2 class="section-header">Danh sách các buổi đã sắp lịch</h2>
                                        <section id="buoidathem-da" class="section">
                                                <table class="table detai-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Tên buổi bảo vệ</th>
                                                            <th>Địa điểm</th>
                                                            <th>Thư ký</th>
                                                            <th>Ngày</th>
                                                            <th>Học kỳ</th>
                                                            <th>Hành động</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-body-buoi-da">
                                                        <?php
                                                        // Kết nối cơ sở dữ liệu
                                                        $server = "localhost";
                                                        $database = "doan2";
                                                        $user = "root";
                                                        $password = "";
                                                        $port = 3309;

                                                        $con = mysqli_connect($server, $user, $password, $database, $port);

                                                        if (!$con) {
                                                            die("Kết nối CSDL thất bại: " . mysqli_connect_error());
                                                        }

                                                        // Truy vấn SQL để lấy dữ liệu
                                                        $query = "
                                                                SELECT 
                                                                            buoibaove.id AS mabuoi, -- ID của buổi bảo vệ
                                                                            buoibaove.TenBuoi AS tenbuoi, 
                                                                            buoibaove.DiaDiem AS diadiem, 
                                                                            giangvien.hoten AS thuky, 
                                                                            buoibaove.Ngay AS ngay, 
                                                                            CONCAT('Học kỳ ', hocky.hoky, ' (', hocky.nambd, '-', hocky.namkt, ')') AS hocky
                                                                        FROM 
                                                                            buoibaove
                                                                        JOIN 
                                                                            giangvien ON giangvien.ma = buoibaove.ThuKy
                                                                        JOIN 
                                                                            hocky ON hocky.ma = buoibaove.HocKy
                                                                        WHERE 
                                                                            buoibaove.trangthai = 'Chưa diễn ra' and buoibaove.saplich = 1
                                                        ";

                                                        $result = mysqli_query($con, $query);

                                                        if (!$result) {
                                                            die("Lỗi truy vấn: " . mysqli_error($con));
                                                        }

                                                        // Hiển thị dữ liệu trong bảng
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo '<tr>';
                                                            echo '<td>' . htmlspecialchars($row['tenbuoi']) . '</td>';
                                                            echo '<td>' . htmlspecialchars($row['diadiem']) . '</td>';  
                                                            echo '<td>' . htmlspecialchars($row['thuky']) . '</td>';
                                                            echo '<td>' . htmlspecialchars($row['ngay']) . '</td>';
                                                            echo '<td>' . htmlspecialchars($row['hocky']) . '</td>';   
                                                            echo '<td>';
                                                            echo '<button class="btn-danger" onclick="huyBuoi(\'' 
                                                            . addslashes($row['mabuoi']) . '\'
                                                            
                                                           )">Hủy</button>';
                                                            
                                                            echo '</tr>';
                                                        }

                                                        // Đóng kết nối cơ sở dữ liệu
                                                        mysqli_close($con);
                                                        ?>
                                                    </tbody>
                                                </table>


                                        </section>

                                    </section>
                                </div>


                                
                            </div>
                        
                            <div class="contan-item2">
                                 <div id="search-results2"></div>
                            </div>


                                                      
                        
                            </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div id="modal-thembuoi" class="modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Thêm buổi bảo vệ khóa luận</h5>
                                                <button type="button" class="close" id="close-buoi" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form-thembuoi">
                                                    <div class="form-group">
                                                        <label for="tenbuoi">Tên buổi bảo vệ:</label>
                                                        <input type="text" id="tenbuoi" name="tenbuoi" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="diadiem">Địa điểm:</label>
                                                        <select id="diadiem" name="diadiem" class="form-control" required>
                                                            <option value="Phòng C101">Phòng C101</option>
                                                            <option value="Phòng C201">Phòng C201</option>
                                                            <option value="Phòng C301">Phòng C301</option>
                                                            <option value="Phòng C401">Phòng C401</option>
                                                            <option value="Phòng C501">Phòng C501</option>
                                                            <option value="Phòng C601">Phòng C601</option>
                                                            <option value="Phòng C701">Phòng C701</option>
                                                            <option value="Phòng C801">Phòng C801</option>
                                                            <option value="Phòng C901">Phòng C901</option>
                                                           
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="thuky-buoi">Thư ký:</label>
                                                        <select id="thuky-buoi" name="thuky-buoi" class="form-control" required>
                                                        <?php
                                                                // Kết nối cơ sở dữ liệu
                                                                $server = "localhost";
                                                                $database = "doan2";
                                                                $user = "root";
                                                                $password = "";
                                                                $port = 3309;

                                                                $con = mysqli_connect($server, $user, $password, $database, $port);

                                                                if (!$con) {
                                                                    die("Kết nối CSDL thất bại: " . mysqli_error($con));
                                                                }

                                                                // Truy vấn SQL để lấy danh sách giảng viên không có mã trong bảng phancongkhoaluan
                                                                $query = "
                                                                    SELECT ma, hoten 
                                                                    FROM giangvien 
                                                                    WHERE ma NOT IN (
                                                                        SELECT gvthuky FROM phancongkhoaluan
                                                                        UNION
                                                                        SELECT gvphanbien FROM phancongkhoaluan
                                                                        UNION
                                                                        SELECT chutich FROM phancongkhoaluan
                                                                    )
                                                                ";

                                                                $result = mysqli_query($con, $query);

                                                                if (!$result) {
                                                                    die("Lỗi truy vấn: " . mysqli_error($con));
                                                                }

                                                                // Hiển thị các tùy chọn
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo '<option value="' . $row['ma'] . '">' . $row['hoten'] . '</option>';
                                                                }

                                                                // Đóng kết nối cơ sở dữ liệu
                                                                mysqli_close($con);
                                                                ?>

                                                        </select>
                                                       
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ngay">Ngày:</label>
                                                        <input type="date" id="ngay" name="ngay" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="hocky-buoi">Học kỳ:</label>
                                                        <select id="hocky-buoi" name="hocky-buoi" class="form-control" required>
                                                            <?php
                                                                    // Kết nối CSDL và thực hiện truy vấn
                                                                    $sever = "localhost";
                                                                    $data = "doan2";
                                                                    $user = "root";
                                                                    $pass = "";
                                                                    $port = 3309;
                                                                    $con = mysqli_connect($sever, $user, $pass, $data, $port);

                                                                    if (!$con) {
                                                                        die("Kết nối CSDL thất bại: " . mysqli_error($con));
                                                                    }

                                                                    // Truy vấn SQL để lấy mã môn và tên môn từ bảng môn học
                                                                    $query = "SELECT ma, hoky, nambd, namkt FROM hocky";
                                                                    $result = mysqli_query($con, $query);
                                                                
                                                                    // Hiển thị các tùy chọn
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo '<option value="' . $row['ma'] . '">Học kỳ ' . $row['hoky'] . ', ' . $row['nambd'] . ' - ' . $row['namkt'] . '</option>';
                                                                    }

                                                                    // Đóng kết nối CSDL
                                                                    mysqli_close($con);
                                                                ?>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="modal-footer">
                                                <button id="btn-save-buoi" class="btn btn-primary" onclick="savethem_buoi()">Lưu</button>
                                                <button  id="btn-close-buoi"type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModathem_buoi()">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                          <!-- Modal Sắp Lịch -->
                            <div class="modal-saplich-overlay" id="modalSapLich">
                                <div class="modal-saplich-content">
                                    <!-- Header -->
                                    <div class="modal-saplich-header">
                                        <h2 class="title">Sắp Lịch Bảo Vệ</h2>
                                        <button class="modal-saplich-close" onclick="dongModalSapLich()">×</button>
                                    </div>
                                    <!-- Body -->
                                    <div class="modal-saplich-body">
                                        <!-- Thêm phần nhập ngày -->
                                        <div class="mb-3">
                                            <label for="tenbuoi-saplich" class="form-label">Tên buổi</label>
                                            <input type="text" id="tenbuoi-saplich" class="modal-saplich-input">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ngay-saplich" class="form-label">Ngày</label>
                                            <input type="date" id="ngay-saplich" class="modal-saplich-input">
                                        </div>
                                        <!-- Thêm phần nhập địa điểm -->
                                        <div class="mb-3">
                                            <label for="diadiem-saplich" class="form-label">Địa điểm</label>
                                            <select id="diadiem-saplich" name="diadiem-saplich" class="modal-saplich-input" required>
                                                            <option value="Phòng C101">Phòng C101</option>
                                                            <option value="Phòng C201">Phòng C201</option>
                                                            <option value="Phòng C301">Phòng C301</option>
                                                            <option value="Phòng C401">Phòng C401</option>
                                                            <option value="Phòng C501">Phòng C501</option>
                                                            <option value="Phòng C601">Phòng C601</option>
                                                            <option value="Phòng C701">Phòng C701</option>
                                                            <option value="Phòng C801">Phòng C801</option>
                                                            <option value="Phòng C901">Phòng C901</option>
                                                           
                                                        </select>
                                        </div>
                                        <!-- Thêm phần nhập thư ký -->
                                        <div class="mb-3">
                                            <label for="thuky-saplich" class="form-label">Thư ký</label>
                                            <select id="thuky-saplich" name="thuky-saplich" class="modal-saplich-input" required>
                                                        <?php
                                                                // Kết nối cơ sở dữ liệu
                                                                $server = "localhost";
                                                                $database = "doan2";
                                                                $user = "root";
                                                                $password = "";
                                                                $port = 3309;

                                                                $con = mysqli_connect($server, $user, $password, $database, $port);

                                                                if (!$con) {
                                                                    die("Kết nối CSDL thất bại: " . mysqli_error($con));
                                                                }

                                                                // Truy vấn SQL để lấy danh sách giảng viên không có mã trong bảng phancongkhoaluan
                                                                $query = "
                                                                    SELECT ma, hoten 
                                                                    FROM giangvien 
                                                                    WHERE ma NOT IN (
                                                                        SELECT gvthuky FROM phancongkhoaluan
                                                                        UNION
                                                                        SELECT gvphanbien FROM phancongkhoaluan
                                                                        UNION
                                                                        SELECT chutich FROM phancongkhoaluan
                                                                    )
                                                                ";

                                                                $result = mysqli_query($con, $query);

                                                                if (!$result) {
                                                                    die("Lỗi truy vấn: " . mysqli_error($con));
                                                                }

                                                                // Hiển thị các tùy chọn
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo '<option value="' . $row['ma'] . '">' . $row['hoten'] . '</option>';
                                                                }

                                                                // Đóng kết nối cơ sở dữ liệu
                                                                mysqli_close($con);
                                                                ?>

                                                        </select>
                                           
                                        </div>
                                        <table class="modal-saplich-table">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                
                                                    <th>MSSV</th>
                                                    <th>HỌ VÀ TÊN SV</th>
                                                    <th>MÃ LỚP</th>
                                                    <th>TÊN ĐỀ TÀI</th>
                                                    <th>GIẢNG VIÊN HƯỚNG DẪN</th>
                                                    <th>GV CHẤM HỘI ĐỒNG</th>
                                                    <th>THỜI GIAN</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                            </tbody>
                                        </table>
                                        <button class="modal-saplich-add-row" onclick="themDong()">Thêm dòng</button>
                                    </div>
                                    <!-- Footer -->
                                    <div class="modal-saplich-footer">
                                        <button class="modal-saplich-save" onclick="xuatExcel()">Xuất Excel</button>
                                        <button class="modal-saplich-save" onclick="hoantatsaplich()">Hoàn tất</button>
                                        <button class="modal-saplich-cancel" onclick="dongModalSapLich()">Đóng</button>
                                        <button class="modal-saplich-save" onclick="luuSapLich()">Lưu</button>
                                        <button class="modal-saplich-autoschedule" onclick="moModalLuaChon()">Sắp Lịch Tự Động</button>
                                    </div>
                                </div>
                            </div>

                            <div id="modal-loadphancong" class="modal" style="display: none;">
                                <div class="modal-content">
                                    <h3>Chọn đề tài</h3>
                                    <select id="phancong-select" class="modal-select">
                                        <!-- Các option sẽ được load tại đây -->
                                    </select>
                                    <div class="modal-buttons">
                                        <button id="btn-luu-chonpc" onclick="luuLuaChon()">Lưu</button>
                                        <button onclick="dongModal()">Đóng</button>
                                    </div>
                                </div>
                            </div>


                            

                            <div class="modal-luachon-overlay" id="modalLuaChon" style="display: none;" class="modal">
                                <div class="modal-luachon-content">
                                    <div class="modal-luachon-header">
                                        <h2>Chọn Thời Gian Cho Đề Tài</h2>
                                        <button class="modal-luachon-close" onclick="dongModalLuaChon()">×</button>
                                    </div>
                                    <div class="modal-luachon-body">
                                        <label for="thoigian-luachon" class="form-label">Thời gian mỗi đề tài (phút)</label>
                                        <select id="thoigian-luachon" class="modal-luachon-input">
                                            <option value="10">10 phút</option>
                                            <option value="15">15 phút</option>
                                            <option value="30">30 phút</option>
                                            <option value="40">40 phút</option>
                                            <option value="60">60 phút</option>
                                        </select>
                                    </div>
                                    <div class="modal-luachon-footer">
                                        <button class="modal-luachon-cancel" onclick="dongModalLuaChon()">Hủy</button>
                                        <button class="modal-luachon-save" onclick="sapLichTuDong()">Sắp Lịch</button>
                                    </div>
                                </div>
                            </div>


                            





                            





                        


                </div>
            </div>
        </div>
					
        <!--Phần footer-->

        <div class="footer" id="footer">
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


            <!-- Modal cho Đồ Án -->
            <div id="doAnModal" class="modal-diem" style="display:none;">
                <div class="modal-content-diem">
                    <!-- Thêm phần tử cho hiệu ứng an ủi -->
                    <div id="comfortEffect" class="comfort-effect" style="display: none;"></div>


                <div class="pyro"><div class="before"></div><div class="after"></div></div>
                    <span class="close" onclick="closeDoAnModal()">&times;</span>
                    <h2>Kết Quả Đồ Án</h2>
                    <div id="doAnBody">
                    <!-- Nội dung kết quả Đồ Án -->
                    </div>
                </div>
            </div>

            <!-- Modal cho Khóa Luận -->
            <div id="khoaLuanModal" class="modal-diem" style="display:none;">
            <div class="modal-content-diem">
                <!-- Thêm phần tử cho hiệu ứng an ủi -->
                <div id="comfortEffect" class="comfort-effect" style="display: none;"></div>


            <div class="pyro"><div class="before"></div><div class="after"></div></div>
                <span class="close" onclick="closeKhoaLuanModal()">&times;</span>
                <h2>Kết Quả Khóa Luận</h2>
                <div id="khoaLuanBody">
                <!-- Nội dung kết quả Khóa Luận -->
                </div>
            </div>
            </div>
            


             
        


     </main>
     <script src="./assets/javas/index.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
     
     <?php
        if (isset($_SESSION['username'])) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('btndn').style.display = 'none';
                        document.getElementById('userIcon').style.display = 'block';
                        document.getElementById('notification-container').style.display = 'block';
                        document.getElementById('name').textContent = '{$_SESSION['username']}';
                    });
                </script>";
        
        }
        else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('btndn').style.display = 'block';
                        document.getElementById('userIcon').style.display = 'none';
                         document.getElementById('notification-container').style.display = 'none';
                       
                    });
                </script>";
        
        }
        

        if( $_SESSION['role']=="giangvien"){
            echo "<script>
                    var detaiButton = document.getElementById('detaiButton');
                    detaiButton.setAttribute('href', './detaicuatoi.php');
                     var detaiButton = document.getElementById('duyetButton');
                    detaiButton.setAttribute('href', './detaicuatoilanhdao.php');
            
            </script>";
        }
        else{
            echo "<script>
                    var detaiButton = document.getElementById('detaiButton');
                    detaiButton.setAttribute('href', './detaicuatoisinhvien.php');
            
            </script>";
        }
        echo"<script> var detaiButton = document.getElementById('nhansuButton');
                    detaiButton.setAttribute('href', './quanlynguoidung.php'); </script>";
        
        include 'nhacnhotiendo.php';

        // $tb = $_SESSION['thongbao'];
        // if ($tb == "themtc") {
        //     echo "<script>
        //         hienThiThongBao('thanhcong', 'Thêm đề tài thành công !');
        //     </script>";
        //     unset($_SESSION['thongbao']); // Xóa thông báo sau khi đã hiển thị
        // }
        // elseif ($tb =="themthatbai"){
        //     echo "<script>
        //         hienThiThongBao('thatbai', 'Thêm đề tài không thành công !');
        //     </script>";
        //     unset($_SESSION['thongbao']); // Xóa thông báo sau khi đã hiển thị

        // }
        
    ?>


</body>

</html>