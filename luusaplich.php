<?php
header('Content-Type: application/json');

// Hiển thị lỗi PHP để debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kết nối cơ sở dữ liệu
$host = "localhost";
$user = "root";
$password = "";
$database = "doan2";
$port = 3309;

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "messages" => ["Lỗi kết nối cơ sở dữ liệu: " . $conn->connect_error]]);
    exit;
}

// Lấy dữ liệu từ request
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

if (!is_array($data)) {
    echo json_encode(["success" => false, "messages" => ["Dữ liệu đầu vào không hợp lệ", "Raw input: $rawInput"]]);
    exit;
}

// Khởi tạo phản hồi
$response = ["success" => true, "messages" => []];

// Cập nhật bảng buoibaove
$firstRow = $data[0] ?? null;
if ($firstRow) {
    $ngay = $firstRow['ngaySapLich'] ?? null;
    $tenbuoi = $firstRow['tenbuoi'] ?? null;
    $mathuky = $firstRow['mathuky'] ?? null;
    $diadiem = $firstRow['diadiem'] ?? null;
    $mb = $firstRow['mb'] ?? null;

    if ($ngay && $tenbuoi && $mathuky && $diadiem && $mb) {
        // Kiểm tra trùng phòng trong ngày
        $checkRoomQuery = "
            SELECT * FROM buoibaove 
            WHERE DiaDiem = ? AND Ngay = ? AND id != ?
        ";
        $stmt = $conn->prepare($checkRoomQuery);
        if ($stmt) {
            $stmt->bind_param("ssi", $diadiem, $ngay, $mb);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $response['success'] = false;
                $response['messages'][] = "Trùng phòng: Địa điểm $diadiem đã có buổi bảo vệ khác vào ngày $ngay.";
                echo json_encode($response);
                exit;
            }
        } else {
            $response['success'] = false;
            $response['messages'][] = "Lỗi kiểm tra phòng trùng: " . $conn->error;
            echo json_encode($response);
            exit;
        }

        // Thực hiện cập nhật nếu không trùng phòng
        $updateSapLichQuery = "
            UPDATE buoibaove
            SET TenBuoi = ?, DiaDiem = ?, ThuKy = ?, Ngay = ?
            WHERE id = ?
        ";
        $stmt = $conn->prepare($updateSapLichQuery);

        if ($stmt) {
            $stmt->bind_param("ssssi", $tenbuoi, $diadiem, $mathuky, $ngay, $mb);

            if (!$stmt->execute()) {
                $response['success'] = false;
                $response['messages'][] = "Lỗi khi cập nhật buổi bảo vệ ID: $mb.";
            } else {
                $response['messages'][] = "Cập nhật thành công buổi bảo vệ ID: $mb.";
            }
        } else {
            $response['success'] = false;
            $response['messages'][] = "Lỗi chuẩn bị truy vấn cập nhật buổi bảo vệ: " . $conn->error;
        }
    } else {
        $response['success'] = false;
        $response['messages'][] = "Thiếu thông tin để cập nhật buổi bảo vệ.";
    }
}

// Xử lý các mục trong bảng phancongkhoaluan
foreach ($data as $row) {
    $madetai = $row['madetai'] ?? null;
    $ngay = $row['ngaySapLich'] ?? null;
    $start_time = $row['startTime'] ?? null;
    $end_time = $row['endTime'] ?? null;

    if (!$madetai || !$ngay || !$start_time || !$end_time) {
        $response['success'] = false;
        $response['messages'][] = "Thiếu dữ liệu cần thiết cho mã đề tài $madetai.";
        continue;
    }

    // Kiểm tra trùng lịch
    $checkQuery = "
        SELECT * FROM phancongkhoaluan 
        WHERE ngaybaove = ? AND madetai != ? AND (
            (giobd <= ? AND giokt > ?) OR 
            (giobd < ? AND giokt >= ?)
        )
    ";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ssssss", $ngay, $madetai, $start_time, $start_time, $end_time, $end_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['success'] = false;
        $response['messages'][] = "Trùng lịch: Mã đề tài $madetai vào ngày $ngay từ $start_time đến $end_time.";
        continue;
    }

    // Cập nhật bảng phancongkhoaluan
    $updateQuery = "
        UPDATE phancongkhoaluan 
        SET ngaybaove = ?, giobd = ?, giokt = ?, buoibaove = ?
        WHERE madetai = ?
    ";
    $stmt = $conn->prepare($updateQuery);

    if ($stmt) {
        $stmt->bind_param("sssis", $ngay, $start_time, $end_time, $mb, $madetai);

        if (!$stmt->execute()) {
            $response['success'] = false;
            $response['messages'][] = "Lỗi khi cập nhật mã đề tài $madetai.";
        } else {
            $response['messages'][] = "Cập nhật thành công mã đề tài $madetai.";
        }
    } else {
        $response['success'] = false;
        $response['messages'][] = "Lỗi chuẩn bị truy vấn cập nhật: " . $conn->error;
    }
}

$conn->close();
echo json_encode($response);
?>
