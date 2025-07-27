<?php
header('Content-Type: application/json');

// Enable error display (for development only; remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Decode JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input data
if (!isset($data['madetai'], $data['newtendetai'], $data['newTg_batdau'], $data['newTg_ketthuc'], $data['new_solmax'], $data['new_mota'])) {
    echo json_encode(['success' => false, 'error' => 'Dữ liệu không đầy đủ']);
    exit();
}

// Assign variables
$mabcc = $data['madetai'];
$newTenbcc = $data['newtendetai'];
$newTg_batdau = $data['newTg_batdau'];
$newTg_ketthuc = $data['newTg_ketthuc'];
$new_solmax = $data['new_solmax'];
$new_mota = $data['new_mota'];

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// Prepare the SQL statement to update
$sql = "UPDATE detai SET tendetai=?, thoigianbatdau=?, thoigianhoanthanh=?, soluongmax=?, mota=? WHERE madetai=?";
$stmt = $conn->prepare($sql);

// Check if prepare was successful
if ($stmt === false) {
    echo json_encode(['success' => false, 'error' => 'Prepare statement failed: ' . $conn->error]);
    exit();
}

// Bind parameters and execute the statement
$stmt->bind_param("ssssis", $newTenbcc, $newTg_batdau, $newTg_ketthuc, $new_solmax, $new_mota, $mabcc);

// Execute the statement and check for success
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Không có dòng nào được cập nhật. Kiểm tra xem mabcc có tồn tại và khớp không']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Execute failed: ' . $stmt->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
