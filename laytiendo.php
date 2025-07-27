<?php
$conn = new mysqli("localhost", "root", "", "doan2", 3309);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Kết nối CSDL thất bại."]));
}

$madetai = $_GET['madetai'] ?? null;
$loaidetai = $_GET['loaidetai'] ?? null;
$ngaynop = $_GET['ngaynop'] ?? null;

if ($madetai && $loaidetai && $ngaynop) {
    $sql = "SELECT danhgia, phantram, 
                   LEAST(100, GREATEST(0, (SELECT COALESCE(SUM(phantram), 0) FROM tiendo WHERE madetai = '$madetai'))) AS tongphantram 
            FROM tiendo 
            WHERE madetai = '$madetai' AND loaitiendo = '$loaidetai' AND ngaynop = '$ngaynop' LIMIT 1";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'evaluation' => $row['danhgia'], 
            'percentage' => $row['phantram'], 
            'total_percentage' => $row['tongphantram']
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Không có dữ liệu đánh giá.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Thông tin không hợp lệ.']);
}

$conn->close();
?>
