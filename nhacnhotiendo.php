<?php
// Kết nối CSDL
$servername = "localhost";    
$username = "root";           
$password = "";               
$dbname = "doan2";            
$port = 3309;                  // Sử dụng port của MySQL nếu có

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ngày hiện tại
$today = date("Y-m-d");

// Kiểm tra ngày hiện tại
echo "Today's date: $today <br>";

// Truy vấn để lấy các deadline có ngaynop trùng với ngày hôm nay
$deadlineQuery = "
    SELECT tiendo.madetai, tiendo.ngaynop
    FROM tiendo
    WHERE tiendo.ngaynop = ?";

$stmt = $conn->prepare($deadlineQuery);
$stmt->bind_param("s", $today);

if (!$stmt->execute()) {
    echo "Error executing deadline query: " . $stmt->error;
} else {
    $deadlines = $stmt->get_result();

    if ($deadlines->num_rows == 0) {
        echo "No deadlines found matching today's date.<br>";
    } else {
        echo "Deadlines found: " . $deadlines->num_rows . "<br>";

        $insertNotification = $conn->prepare("
            INSERT INTO thongbao (manguoinhan, noidung, ngay) 
            VALUES (?, ?, NOW())");

        while ($row = $deadlines->fetch_assoc()) {
            $madetai = $row['madetai'];
            $message = "Bạn có thời hạn nộp sản phẩm phải hoàn thành trong hôm nay của đề tài $madetai. Hãy nhanh chóng hoàn thành.";

            // Truy vấn bảng dangkydetai để tìm các masv có madetai và trangthai là 'Chấp nhận'
            $studentQuery = "
                SELECT masv 
                FROM dangkydetai 
                WHERE madetai = ? 
                AND trangthai = 'Chấp nhận'";

            $studentStmt = $conn->prepare($studentQuery);
            $studentStmt->bind_param("s", $madetai);
            $studentStmt->execute();
            $students = $studentStmt->get_result();

            // Gửi thông báo cho từng sinh viên
            while ($student = $students->fetch_assoc()) {
                $masv = $student['masv'];

                // Kiểm tra xem thông báo đã được gửi hôm nay cho sinh viên này chưa
                $checkNotificationQuery = "
                    SELECT 1 FROM thongbao 
                    WHERE manguoinhan = ? 
                    AND noidung = ? 
                    AND DATE(ngay) = ?";

                $checkStmt = $conn->prepare($checkNotificationQuery);
                $checkStmt->bind_param("sss", $masv, $message, $today);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();

                if ($checkResult->num_rows == 0) {
                    // Gửi thông báo nếu chưa gửi hôm nay
                    $insertNotification->bind_param("ss", $masv, $message);
                    if ($insertNotification->execute()) {
                        echo "Notification sent successfully to student $masv for topic $madetai.<br>";
                    } else {
                        echo "Error sending notification to student $masv: " . $insertNotification->error . "<br>";
                    }
                } else {
                    echo "Notification already sent today to student $masv for topic $madetai.<br>";
                }
            }
        }
    }
}

$conn->close();
?>
