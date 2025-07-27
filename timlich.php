<?php
$sever = "localhost";
$data = "qlnv";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($sever, $user, $pass, $data, $port);

if (!$con) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

if (isset($_GET['manv']) && isset($_GET['searchType'])) {
    $manv = $_GET['manv'];
    $searchType = $_GET['searchType'];

    // Lấy thời gian hiện tại
    $current_date = date('Y-m-d');

    if ($searchType == 'week') {
        $start_of_week = date('Y-m-d', strtotime('monday this week'));
        $end_of_week = date('Y-m-d', strtotime('sunday this week'));
        $sql = "SELECT * FROM lich_lam_viec WHERE manv = '$manv' AND ngay BETWEEN '$start_of_week' AND '$end_of_week'";
    } elseif ($searchType == 'month') {
        $start_of_month = date('Y-m-01');
        $end_of_month = date('Y-m-t');
        $sql = "SELECT * FROM lich_lam_viec WHERE manv = '$manv' AND ngay BETWEEN '$start_of_month' AND '$end_of_month'";
    }

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<thead><tr><th>Ngày</th><th>Thông tin ca làm</th></tr></thead>";
        echo "<tbody>";
        while($row = $result->fetch_assoc()) {
            $day_of_week = date('l', strtotime($row['ngay']));
            $highlight_class = (date('Y-m-d') == $row['ngay']) ? 'highlight' : '';
            $ngay = date('d/m', strtotime($row['ngay']));
            $thu = "Thứ " . date('N', strtotime($row['ngay']))+1;

            echo "<tr class='$highlight_class'>";
            echo "<td>$thu<br>$ngay</td>";
            echo "<td>Ca làm : " . $row['ca_lam'] . "<br>Thời gian : (" . $row['gio_bat_dau'] . " - " . $row['gio_ket_thuc'] . ")<br></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "Không tìm thấy lịch làm việc cho nhân viên này trong khoảng thời gian đã chọn.";
    }
}

$con->close();
?>
