<?php
$conn = new mysqli("localhost", "root", "", "doan2", 3309);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Kết nối CSDL thất bại."]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['madetai']) && !empty($data['loaitiendo']) && !empty($data['oldDeadline']) && !empty($data['newDeadline'])) {
    $madetai = $conn->real_escape_string($data['madetai']);
    $loaitiendo = $conn->real_escape_string($data['loaitiendo']);
    $oldDeadline = $conn->real_escape_string($data['oldDeadline']);
    $newDeadline = $conn->real_escape_string($data['newDeadline']);
    $newNote = $conn->real_escape_string($data['newNote']);

    // Update the record only if the old deadline matches
    $sql = "UPDATE tiendo 
            SET ngaynop = '$newDeadline', ghichu = '$newNote' 
            WHERE madetai = '$madetai' AND loaitiendo = '$loaitiendo' AND ngaynop = '$oldDeadline'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Dữ liệu không hợp lệ."]);
}

$conn->close();
?>
