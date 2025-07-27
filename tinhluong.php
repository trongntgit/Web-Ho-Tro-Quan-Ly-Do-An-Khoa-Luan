<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Phần favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="./favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="./favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Phần reset css -->
    <link rel="stylesheet" href="./assets/css/reset.css">

    <!-- Phần custom css -->
    <link rel="stylesheet" href="./assets/css/chamcong.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> <!-- Thêm plugin -->   
    <title>Tính lương Mobifone</title>
</head>
<body>
    <div class="main">
        <div class="body">
            <div class="content">
                <div class="title"><a href=""><img src="https://www.mobifone.vn/assets/source/icons/logo-mobile.png" alt="Lesson." class="logo_img"></a></div>
                <div class="name_class">
                    <p>Mã bảng chấm công: <span id="mal"></span></p>

                </div>  
                <div class="summary">
                   
                </div>

                <div class="table-diemdanh">
                    <form action="xulydd.php">
                        <table id="attendanceTable" border="1">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>MSNV</th>
                                    <th>Họ và tên</th>
                                    <th id="ngaydd">Số ngày đi làm</th>
                                    <th>Số ngày nghỉ</th>
                                    <th>Số ngày đi trễ</th>
                                    <th>Tổng lương</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dữ liệu sẽ được thêm tự động tại đây -->
                            </tbody>
                        </table>
                    </form>
                </div>

                <div class="btn-action">
                    <div class="btn-dd">
                        <button class="btn" id="hoantat">Hoàn tất</button>
                        <button class="btn" id="tinhluong">Tính lương</button>
                        <button class="btn" id="xuatfile">Xuất file</button>
                        <button  class="btn" id="thongke" onclick="openStatisticsDialog()">Thống kê</button>
                        <a class="btn" href="./index.php">Thoát</a>
                    </div>
                </div>
                <div id="man" style="width: 300px; height: 200px;"></div>
            </div>
            <div class="overlay"></div>
            <div id="salaryDialog" class="modern-dialog">
                        <h3>Nhập thông tin lương</h3>
                        <label for="dailySalary">Lương một ngày:</label>
                        <input type="number" id="dailySalary" value="0"><br><br>

                        <label for="allowance">Phụ cấp:</label>
                        <input type="number" id="allowance" value="0"><br><br>

                        <label for="latePenalty">Tiền phạt đi trễ:</label>
                        <input type="number" id="latePenalty" value="0"><br><br>

                        <label for="absencePenalty">Tiền phạt nghĩ:</label>
                        <input type="number" id="absencePenalty" value="0"><br><br>

                        <div class="dialog-buttons">
                            <button class="btn-save" onclick="calculateSalary()">Lưu</button>
                            <button class="btn-close" onclick="closeDialog()">Đóng</button>
                        </div>
            </div>

            <!-- Modal -->
          <!-- Dialog cho việc nhập tên file và chọn vị trí lưu -->
                <div id="exportModal" style="display: none;">
                    <div class="modal-content">
                        <h2>Xuất File Excel</h2>
                        <label for="filename">Tên file:</label>
                        <input type="text" id="filename" name="filename" placeholder="Nhập tên file" required>
                        <label for="directory">Vị trí lưu:</label>
                        <select id="directory" name="directory">
                            <option value="default">Thư mục mặc định</option>
                            <!-- Bạn có thể thêm các tùy chọn khác nếu muốn -->
                        </select>
                        <br>
                        <button id="saveFileBtn">Lưu</button>
                        <button id="cancelBtn">Hủy</button>
                    </div>
                </div>


                <div class="container">
        <!-- Nút thống kê -->
       
        <!-- <h1>Biểu đồ số ngày làm việc của nhân viên</h1> -->
    <!-- Dialog thống kê -->
    <div id="statistics-dialog" class="dialog2">
        <div class="dialog-content">
            <span class="close-button" onclick="closeDialog2()">&times;</span>
            <h3>Chọn loại thống kê</h3>
            <select id="filter-type">
                <option value="week">Theo tuần</option>
                <option value="month">Theo tháng</option>
            </select>
            <button onclick="showStatistics()">Xem thống kê</button>
            
   
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>
    </div>
           
        </div>

    </div>
    <script src="./assets/javas/tinhluong.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</body>
</html>
