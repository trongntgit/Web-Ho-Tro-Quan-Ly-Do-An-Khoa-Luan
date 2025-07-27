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

    // Nếu loại là "Không chấm", thêm điểm mặc định 0 vào bảng ketqua
    if ($loai == "Không chấm") {
        $diemGvThuky = 0;
        $diemGvPhanbien = 0;

        // Thêm kết quả vào bảng ketqua
        $insert_sql = "
            INSERT INTO ketqua (madetai, diemgvhd, diemgvpb)
            VALUES (?, ?, ?)
        ";

        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sdd", $madt, $diemGvThuky, $diemGvPhanbien);

        if ($insert_stmt->execute()) {
            echo "Tổng hợp điểm thành công với điểm mặc định (Không chấm)!";
        } else {
            echo "Có lỗi khi tổng hợp điểm (Không chấm)!";
        }

        // Đóng statement
        $insert_stmt->close();
    } elseif ($loai == "Được chấm") {
        // Loại là "Được chấm", xử lý như bình thường
        $sql = "
            SELECT 
                pc.madetai,
                pd.diem AS diem,
                pd.vaitro
            FROM phancongdoan pc
            LEFT JOIN phieudiem pd ON pc.madetai = pd.madetai
            WHERE pc.madetai = ?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $madt);
        $stmt->execute();
        $result = $stmt->get_result();

        // Khởi tạo biến để lưu điểm với giá trị mặc định
        $diemGvThuky = 0;
        $diemGvPhanbien = 0;

        // Xử lý dữ liệu
        while ($row = $result->fetch_assoc()) {
            $vaitro = trim(strtolower($row['vaitro'])); // Chuẩn hóa vai trò
            if ($vaitro === 'gvhd') {
                $diemGvThuky = $row['diem'] ?? 0;
            } elseif ($vaitro === 'gvphanbien') {
                $diemGvPhanbien = $row['diem'] ?? 0;
            }
        }

        // Đóng statement sau khi truy vấn xong
        $stmt->close();

        // Kiểm tra nếu không có dữ liệu
        if ($diemGvThuky === 0 || $diemGvPhanbien === 0) {
            echo "Giáo viên vẫn chưa chấm điểm xong cho đề tài: $madt";
            exit;
        }

        // Thêm kết quả tổng hợp vào bảng ketqua
        $insert_sql = "
            INSERT INTO ketqua (madetai, diemgvhd, diemgvpb)
            VALUES (?, ?, ?)
        ";

        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sdd", $madt, $diemGvThuky, $diemGvPhanbien);

        if ($insert_stmt->execute()) {
            echo "Tổng hợp điểm thành công!";
        } else {
            echo "Có lỗi khi tổng hợp điểm!";
        }

        // Đóng statement
        $insert_stmt->close();
    } else {
        echo "Loại không hợp lệ!";
    }
} else {
    echo "Dữ liệu không hợp lệ!";
}

// Đóng kết nối
$conn->close();
?>
