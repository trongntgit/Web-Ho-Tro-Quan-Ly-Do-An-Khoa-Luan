<?php
$conn = new mysqli("localhost", "root", "", "doan2", 3309);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Kết nối CSDL thất bại."]));
}

$data = json_decode(file_get_contents('php://input'), true);
$madetai = $data['madetai'] ?? null;
$loaidetai = $data['loaidetai'] ?? null;
$ngaynop = $data['ngaynop'] ?? null;
$evaluation = $data['evaluation'] ?? null;
$percentage = $data['percentage'] ?? null;

if ($madetai && $loaidetai && $ngaynop) {
    // Kiểm tra xem bản ghi đã tồn tại hay chưa
    $check_sql = "SELECT id FROM tiendo WHERE madetai = '$madetai' AND loaitiendo = '$loaidetai' AND ngaynop = '$ngaynop'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Cập nhật bản ghi nếu đã tồn tại
        $update_sql = "UPDATE tiendo SET danhgia = '$evaluation', phantram = '$percentage' 
                       WHERE madetai = '$madetai' AND loaitiendo = '$loaidetai' AND ngaynop = '$ngaynop'";
        if ($conn->query($update_sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Cập nhật đánh giá thành công.']);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } else {
        // Tạo bản ghi mới nếu chưa tồn tại
        $insert_sql = "INSERT INTO tiendo (madetai, loaitiendo, ngaynop, danhgia, phantram) 
                       VALUES ('$madetai', '$loaidetai', '$ngaynop', '$evaluation', '$percentage')";
        if ($conn->query($insert_sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Thêm mới đánh giá thành công.']);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Dữ liệu không hợp lệ.']);
}

$conn->close();
?>
