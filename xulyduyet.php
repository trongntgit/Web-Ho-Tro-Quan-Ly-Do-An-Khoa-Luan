<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy giá trị từ yêu cầu AJAX
if (isset($_POST['madetai']) && isset($_POST['action'])) {
    $madetai = $_POST['madetai'];
    $action = $_POST['action'];

    // Chuẩn bị câu lệnh SQL để cập nhật trạng thái trong bảng detai
    if ($action == 'approve') {
        $sql_update = "UPDATE detai SET duyetlanhdao = 'Được duyệt' WHERE madetai = ?";
        $noidung = "Đề tài \"$madetai\" của bạn đã được lãnh đạo duyệt.";
    } elseif ($action == 'reject') {
        $sql_update = "UPDATE detai SET duyetlanhdao = 'Không duyệt' WHERE madetai = ?";
        $noidung = "Đề tài \"$madetai\" của bạn không được lãnh đạo duyệt.";
    }

    // Lấy manguoitao từ bảng detai
    $sql_get_creator = "SELECT manguoitao FROM detai WHERE madetai = ?";
    if ($stmt_get = $conn->prepare($sql_get_creator)) {
        $stmt_get->bind_param("s", $madetai);
        $stmt_get->execute();
        $stmt_get->bind_result($manguoitao);
        $stmt_get->fetch();
        $stmt_get->close();

        if (!empty($manguoitao)) {
            // Thực hiện cập nhật trạng thái
            if ($stmt_update = $conn->prepare($sql_update)) {
                $stmt_update->bind_param("s", $madetai);
                if ($stmt_update->execute()) {
                    // Gửi thông báo vào bảng thongbao
                    $sql_insert_notification = "INSERT INTO thongbao (manguoinhan, noidung) VALUES (?, ?)";
                    if ($stmt_notify = $conn->prepare($sql_insert_notification)) {
                        $stmt_notify->bind_param("ss", $manguoitao, $noidung);
                        if ($stmt_notify->execute()) {
                            echo "Cập nhật và gửi thông báo thành công!";
                        } else {
                            echo "Cập nhật thành công, nhưng không thể gửi thông báo!";
                        }
                        $stmt_notify->close();
                    } else {
                        echo "Lỗi chuẩn bị câu lệnh gửi thông báo!";
                    }
                } else {
                    echo "Có lỗi khi cập nhật!";
                }
                $stmt_update->close();
            } else {
                echo "Lỗi chuẩn bị câu lệnh cập nhật!";
            }
        } else {
            echo "Không tìm thấy người tạo đề tài!";
        }
    } else {
        echo "Lỗi chuẩn bị câu lệnh lấy người tạo!";
    }
} else {
    echo "Thông tin không hợp lệ!";
}

$conn->close();
?>
