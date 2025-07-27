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


$query = $_GET['query'];
$branch = $_GET['branch'];
$loaidetai = $_GET['loaidetai'];


$sql = "SELECT madetai, tendetai FROM detai WHERE (madetai LIKE '%$query%' OR tendetai LIKE '%$query%') AND duyetlanhdao = 'Được duyệt'";


if (!empty($branch)) {
    $sql .= " AND mahocky = '$branch'";
}
if (!empty($loaidetai)) {
    $sql .= " AND loaidetai = '$loaidetai'";
}

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestion = $row['madetai'] . ' - ' . $row['tendetai'];
        echo "<div onclick=\"selectSuggestion3('$suggestion')\">$suggestion</div>";
    }
} else {
    echo "<div>Không có kết quả nào</div>";
}

mysqli_close($con);
?>
