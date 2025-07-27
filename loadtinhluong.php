<?php
// Kết nối đến cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'qlnv',3309);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy mã bảng chấm công từ request (ví dụ: thông qua POST hoặc GET)
$mabcc = $_POST['mabcc']; // Hoặc $_GET['mabcc'], tùy thuộc vào cách bạn gửi dữ liệu
// if (isset($_POST['mabcc'])) {
//     $mabcc = $_POST['mabcc'];
//     // In giá trị lên console
//     echo "<script>console.log('Mã bảng chấm công nhận được: " . $mabcc . "');</script>";
// } else {
//     // In thông báo lỗi lên console
//     echo "<script>console.log('mabcc không được gửi đến');</script>";
// }
// Truy vấn lấy dữ liệu từ bảng chamcong dựa trên mabcc
$sql = "SELECT manv, hoten, ttchamconng,mabcc 
        FROM chamcong 
        WHERE mabcc = ? AND ttchamconng IN ('Có', 'Vắng', 'Trễ')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $mabcc); // 's' nghĩa là string
$stmt->execute();
$result = $stmt->get_result();

$attendanceData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $manv = $row['manv'];
        $hoten = $row['hoten'];
        $ttchamcong = $row['ttchamconng'];
        $mabcc = $row['mabcc'];

        // Khởi tạo dữ liệu cho nhân viên nếu chưa có
        if (!isset($attendanceData[$manv])) {
            $attendanceData[$manv] = [
                'hoten' => $hoten,
                'somaylam' => 0,
                'somaynghi' => 0,
                'somayditre' => 0,
                'mabcc' => $mabcc,
            ];
        }

        // Đếm số ngày đi làm, nghỉ và đi trễ
        if ($ttchamcong == 'Có') {
            $attendanceData[$manv]['somaylam'] += 1;
        } elseif ($ttchamcong == 'Vắng') {
            $attendanceData[$manv]['somaynghi'] += 1;
        } elseif ($ttchamcong == 'Trễ') {
            $attendanceData[$manv]['somayditre'] += 1;
            $attendanceData[$manv]['somaylam'] += 1; // Trễ cũng được tính là đi làm
        }
    }
}

$stmt->close();
$conn->close();

// Trả dữ liệu dưới dạng JSON
echo json_encode($attendanceData);
?>
