<?php
session_start();

$server = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;

$con = mysqli_connect($server, $user, $pass, $data, $port);

if (!$con) {
    die(json_encode(["success" => false, "message" => "Kết nối CSDL thất bại"]));
}

$input = json_decode(file_get_contents("php://input"), true);
$madetai = $input['madetai'];
$ngay = $input['ngay'];
$thoigianMoiDeTai = intval($input['thoigianMoiDeTai']);

$query = "SELECT gvthuky, gvphanbien, chutich FROM phancongkhoaluan WHERE madetai = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $madetai);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Không tìm thấy mã đề tài"]);
    exit;
}

$row = $result->fetch_assoc();
$giaoviens = [$row['gvthuky'], $row['gvphanbien'], $row['chutich']];

$startHour = 7;
$endHour = 17;
$interval = $thoigianMoiDeTai * 60; // Tính bằng giây
$events = [];

// Lấy tất cả lịch đã phân công để kiểm tra xung đột
foreach ($giaoviens as $gv) {
    $eventQuery = "
        SELECT giobd, giokt FROM phancongkhoaluan
        WHERE ngaybaove = ? AND (gvthuky = ? OR gvphanbien = ? OR chutich = ?)
    ";
    $stmt = $con->prepare($eventQuery);
    $stmt->bind_param("ssss", $ngay, $gv, $gv, $gv);
    $stmt->execute();
    $resultEvents = $stmt->get_result();
    while ($row = $resultEvents->fetch_assoc()) {
        $events[] = ["start" => $row['giobd'], "end" => $row['giokt']];
    }
}

// Sắp xếp sự kiện theo thời gian bắt đầu
usort($events, function ($a, $b) {
    return strtotime($a['start']) - strtotime($b['start']);
});



$slots = [];
$currentStart = sprintf("%02d:%02d:00", $startHour, 0);  // Bắt đầu từ 7h

foreach ($events as $event) {
    while (strtotime($currentStart) + $interval <= strtotime($event['start'])) {
        $slots[] = [
            "start" => $currentStart,
            "end" => date("H:i:s", strtotime($currentStart) + $interval),
        ];
        $currentStart = date("H:i:s", strtotime($currentStart) + $interval);
    }
    $currentStart = max($currentStart, $event['end']);
}

while (strtotime($currentStart) + $interval <= strtotime("$endHour:00:00")) {
    $slots[] = [
        "start" => $currentStart,
        "end" => date("H:i:s", strtotime($currentStart) + $interval),
    ];
    $currentStart = date("H:i:s", strtotime($currentStart) + $interval);
}


echo json_encode(["success" => true, "slots" => $slots]);
?>
