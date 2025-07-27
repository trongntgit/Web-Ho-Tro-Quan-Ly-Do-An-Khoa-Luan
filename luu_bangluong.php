<?php
$server = "localhost";
$data = "qlnv";
$user = "root";
$pass = "";
$port = 3309;

$con = mysqli_connect($server, $user, $pass, $data, $port);

if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

// Nhận dữ liệu từ AJAX
$input = file_get_contents("php://input");
$rows = json_decode($input, true);

$mabcc = ""; // Bạn có thể thay đổi mã bảng chấm công này theo yêu cầu của bạn

if ($rows) {
    foreach ($rows as $row) {
        $manv = mysqli_real_escape_string($con, $row['manv']);
        $hoten = mysqli_real_escape_string($con, $row['hoten']);
        $songaylam = (int)$row['songaylam'];
        $songaynghi = (int)$row['songaynghi'];
        $songayditre = (int)$row['songayditre'];
        $tongluong = (float)$row['tongluong'];
        $mabcc = $row['mab'];

        $sql = "INSERT INTO bangluong (manv, hoten, mabcc, songaylam, songaynghi, songayditre, tongluong) 
                VALUES ('$manv', '$hoten', '$mabcc', $songaylam, $songaynghi, $songayditre, $tongluong)";

        if (!mysqli_query($con, $sql)) {
            echo "Lỗi: " . mysqli_error($con);
            exit;
        }
    }

    echo "Lưu dữ liệu thành công!";
} else {
    echo "Không có dữ liệu để lưu!";
}

mysqli_close($con);
?>
