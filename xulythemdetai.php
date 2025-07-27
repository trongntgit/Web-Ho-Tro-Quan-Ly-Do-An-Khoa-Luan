<?php
session_start();
$sever = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($sever, $user, $pass, $data, $port);

if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

// Lấy dữ liệu từ form
$ma = $_SESSION['userid'];
$tendetai = $_POST['tendetai'];
$loaidetai = $_POST['loaidetai'];
$tg_batdau = $_POST['tg_batdau'];
$tg_ketthuc = $_POST['tg_ketthuc'];
$solmax = $_POST['solmax'];
$mahocky = $_POST['mahocky']; 
$mota = $_POST['mota'];
$hoten =  $_SESSION['username'];
$linhvuc =  $_POST['linhvuc'];

// Tách năm học từ mã học kỳ
$query = "SELECT nambd, namkt FROM hocky WHERE ma = '$mahocky'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $nambd = $row['nambd'];
    $namhoc = substr($nambd, -2); // Lấy 2 chữ số cuối của năm bắt đầu
    $hoky = substr($mahocky, -1); // Lấy học kỳ từ mã học kỳ (giả sử nó là ký tự cuối)

    // Tạo mã loại đề tài viết tắt
    $ma_loai_de_tai = "";
    switch ($loaidetai) {
        case "Khóa luận":
            $ma_loai_de_tai = "KL";
            break;
        case "Đồ án 1":
            $ma_loai_de_tai = "DA1";
            break;
        case "Đồ án 2":
            $ma_loai_de_tai = "DA2";
            break;
    }

    // Tạo mã đề tài tự động
    $query = "SELECT COUNT(*) as count FROM detai";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $madetai_number = $row['count'] + 1; // Số đề tài tiếp theo
    $madetai = $namhoc . $hoky . $ma_loai_de_tai . sprintf("%02d", $madetai_number); // Ghép mã đề tài

    // Thêm dữ liệu vào bảng detai
    $sql = "INSERT INTO detai (madetai, tendetai, mota, soluongmax, soluongdk, thoigianbatdau, thoigianhoanthanh, trangthai, ngaytao, ngaycapnhat, manguoitao,mahocky,tengv, linhvuc) 
            VALUES ('$madetai', '$tendetai', '$mota', $solmax, 0, '$tg_batdau', '$tg_ketthuc', 'Chờ đăng ký', CURRENT_DATE(), CURRENT_TIMESTAMP(),'$ma','$mahocky','$hoten','$linhvuc')";

    if (mysqli_query($con, $sql)) {
        // Thêm thành công, hiển thị thông báo và thêm vào bảng thongbao
        $noidung = "Bạn đã thêm đề tài thành công: $tendetai (Mã Đề Tài: $madetai)";
        $sql_thongbao = "INSERT INTO thongbao (noidung, manguoinhan) VALUES ('$noidung', '$ma')";
        mysqli_query($con, $sql_thongbao); // Thực hiện thêm vào bảng thongbao

        $_SESSION['thongbao'] = "themtc";
        header("Location: ./index.php#search");
        exit(); // Dừng thực thi tiếp theo
    } else {
        header("Location: ./index.php#search");
        $_SESSION['thongbao'] = "themthatbai";
    }
} else {
    header("Location: ./index.php#search");
    $_SESSION['thongbao'] = "themthatbai";
}

// Đóng kết nối CSDL
mysqli_close($con);
?>
