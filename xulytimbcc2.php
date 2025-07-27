<?php
session_start();
$sever = "localhost";
$data = "qlnv";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($sever, $user, $pass, $data, $port);

if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['role']) || $_SESSION['role'] == null) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    echo "<script>alert('Bạn phải đăng nhập để truy cập trang này.');window.location.href='login.php';</script>";
    exit();
}

// Giả sử quyền của người dùng hiện tại được lưu trong session
$ma_nhan_vien = $_SESSION['role'];
$query = isset($_POST['malop']) ? $_POST['malop'] : '';
$branch = isset($_POST['branch']) ? $_POST['branch'] : '';

// Xây dựng câu truy vấn SQL
$sql = "SELECT mabcc, tenbcc, tg_batdau, tg_ketthuc, tg_chamcong, machinhanh FROM bangchamcong 
        WHERE (mabcc LIKE '%$query%' OR tenbcc LIKE '%$query%')";

// Kiểm tra quyền của người dùng
if ($ma_nhan_vien != 'admin-full') {
    $user_branch = substr($ma_nhan_vien, strpos($ma_nhan_vien, '-') + 1);
    
    if ($branch != '' && $branch != $user_branch) {
        echo json_encode([]);
        mysqli_close($con);
        exit();
    }
    
    $sql .= " AND machinhanh = '$user_branch'";
} else {
    if (!empty($branch)) {
        $sql .= " AND machinhanh = '$branch'";
    }
}

$result = mysqli_query($con, $sql);

$data = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

echo json_encode($data);

mysqli_close($con);
?>
