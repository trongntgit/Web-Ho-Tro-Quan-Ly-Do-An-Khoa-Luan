<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $server = "localhost";
    $database = "qlnv";
    $user = "root";
    $password = "";
    $port = 3309;
    $con = mysqli_connect($server, $user, $password, $database, $port);

    if (!$con) {
        die("Kết nối CSDL thất bại: " . mysqli_connect_error());
    }

    // Nhận dữ liệu từ POST request
    $mabcc = $_POST['mabcc'];

    $sql = "SELECT DISTINCT chamcong.manv, chamcong.hoten AS ten_sv, bangchamcong.tenbcc, bangchamcong.mabcc, bangchamcong.tg_chamcong 
        FROM chamcong
        JOIN bangchamcong ON chamcong.mabcc = bangchamcong.mabcc
        WHERE chamcong.mabcc = '$mabcc'";
            
    $result = $con->query($sql);

    $attendanceData = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $attendanceData[] = $row;
        }
    }

    $con->close();

    // Trả về dữ liệu dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($attendanceData);
?>
