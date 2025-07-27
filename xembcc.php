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
    <title>Xem chấm công Mobifone</title>
</head>
<body>
    <div class="main">
        <div class="body">
            <div class="content">
                <div class="title"><a href=""><img src="https://www.mobifone.vn/assets/source/icons/logo-mobile.png" alt="Lesson." class="logo_img"></a></div>
                <div class="name_class">
                    <p>Mã bảng chấm công: <span id="mal"></span></p>
                    <p>Tên bảng chấm công: <span id="tenmon"></span></p>
                </div>  
                <div class="summary">
                    <!-- <p>Đánh dấu check vào những nhân viên có đi làm</p>
                    <p>Nhân viên phản hồi khi có sai sót</p> -->
                </div>

                <div class="table-diemdanh">
                    <form action="xulydd.php">
                        <table id="attendanceTable" border="1">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>MSNV</th>
                                    <th>Họ và tên</th>
                                    <th id="ngaydd">Ngày chấm công</th>
                                    <th>Chấm công</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dữ liệu sẽ được thêm tự động tại đây -->
                            </tbody>
                        </table>
                    </form>
                </div>

                <div class="btn-action">
                    <!-- <div class="check">
                        <input type="checkbox" id="check-all" class="inp">
                        <p>Chấm công tất cả</p>
                    </div> -->
                    <div class="btn-dd">
                        <!-- <button class="btn" id="hoantat">Hoàn tất</button>
                        <button class="btn" id="ddqr">Chấm công khuôn mặt</button>
                        <button class="btn" id="themnv">Thêm nhân viên</button> -->
                        <a class="btn" href="./index.php">Thoát</a>
                    </div>
                </div>
                <!--     -->
</div>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.js"
	integrity="sha256-JOJ7NmVm2chxYZ1KPcAYd2bwVK7NaFj9QKMp7DClews=" crossorigin="anonymous"></script>
    <script src="./assets/javas/xembcc.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</body>
</html>
