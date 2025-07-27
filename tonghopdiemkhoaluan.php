<?php
// Cấu hình kết nối
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

// Kiểm tra nếu có tham số 'madt' và 'loai' được gửi qua AJAX
if (isset($_POST['madt']) && isset($_POST['loai'])) {
    $madt = $_POST['madt'];
    $loai = $_POST['loai'];

    if ($loai === "Không chấm") {
        // Thêm trực tiếp điểm 0 vào bảng ketqua
        $insert_sql = "
            INSERT INTO ketqua (madetai, diemgvhd, diemgvpb, diemchutich)
            VALUES (?, 0, 0, 0)
        ";

        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("s", $madt);

        if ($insert_stmt->execute()) {
            echo "Tổng hợp điểm thành công với điểm 0!";
        } else {
            echo "Có lỗi khi tổng hợp điểm!";
        }

        $insert_stmt->close();
    } else {
        // Truy vấn để lấy điểm của các vai trò
        $sql = "
            SELECT 
                pc.madetai,
                pd.diem AS diem,
                pd.vaitro
            FROM phancongkhoaluan pc
            LEFT JOIN phieudiem pd ON pc.madetai = pd.madetai
            WHERE pc.madetai = ?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $madt);
        $stmt->execute();
        $result = $stmt->get_result();

        // Khởi tạo biến để lưu điểm
        $diemGvThuky = null;
        $diemGvPhanbien = null;
        $diemChuTich = null;

        // Xử lý dữ liệu
        while ($row = $result->fetch_assoc()) {
            if ($row['vaitro'] === 'gvthuky') {
                $diemGvThuky = $row['diem'];
            } elseif ($row['vaitro'] === 'gvphanbien') {
                $diemGvPhanbien = $row['diem'];
            } elseif ($row['vaitro'] === 'chutich') {
                $diemChuTich = $row['diem'];
            }
        }

        // Đóng statement
        $stmt->close();

        // Kiểm tra nếu có giá trị null trong các biến điểm
        if ($diemGvThuky === null || $diemGvPhanbien === null || $diemChuTich === null) {
            echo "Giáo viên vẫn chưa chấm điển xong cho đề tài: $madt";
        } else {
            // Thêm kết quả tổng hợp vào bảng ketqua
            $insert_sql = "
                INSERT INTO ketqua (madetai, diemgvhd, diemgvpb, diemchutich)
                VALUES (?, ?, ?, ?)
            ";

            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sdds", $madt, $diemGvThuky, $diemGvPhanbien, $diemChuTich);

            // Kiểm tra kết quả thêm mới
            if ($insert_stmt->execute()) {
                echo "Tổng hợp điểm thành công!";
            } else {
                echo "Có lỗi khi tổng hợp điểm!";
            }

            // Đóng statement
            $insert_stmt->close();
        }
    }
} else {
    echo "Mã đề tài hoặc loại không hợp lệ!";
}

// Đóng kết nối
$conn->close();
?>
