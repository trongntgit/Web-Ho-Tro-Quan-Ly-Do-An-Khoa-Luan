<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Thông tin kết nối cơ sở dữ liệu
$server = "localhost";
$data = "doan2";
$user = "root";
$pass = "";
$port = 3309;
$con = mysqli_connect($server, $user, $pass, $data, $port);

// Kiểm tra kết nối CSDL
if (!$con) {
    die(json_encode(['success' => false, 'error' => "Kết nối CSDL thất bại: " . mysqli_connect_error()]));
}

$targetDir = "up-file/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Kiểm tra nếu có file tải lên
if (isset($_FILES['file']) && isset($_POST['positionID']) && isset($_POST['sectionTitle'])) {
    $fileName = basename($_FILES['file']['name']);
    
    // Thêm timestamp vào tên tệp để tránh trùng lặp
    $uniqueFileName = time() . "_" . $fileName;
    $targetFilePath = $targetDir . $uniqueFileName;
    $positionID = $_POST['positionID'];
    $sectionTitle = $_POST['sectionTitle'];

    // Di chuyển file tới thư mục đích
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
        $stmt = $con->prepare("INSERT INTO tep_tai_len (ten_phan, vi_tri_id, duong_dan_tep, ten_tep) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $sectionTitle, $positionID, $targetFilePath, $uniqueFileName);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'file_path' => $targetFilePath]);
        } else {
            echo json_encode(['success' => false, 'error' => "Lỗi khi lưu vào CSDL: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Lỗi khi lưu tệp.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Thiếu tệp hoặc thông tin vị trí.']);
}

$con->close();
?>
