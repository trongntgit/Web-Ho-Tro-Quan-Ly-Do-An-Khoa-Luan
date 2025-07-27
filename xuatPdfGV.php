<?php
require 'vendor/autoload.php'; // Đảm bảo bạn đã cài TCPDF qua Composer

session_start();

// Thông tin kết nối CSDL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

// Bắt đầu bộ đệm để ngăn output không mong muốn
ob_start();

// Kết nối đến CSDL
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => "Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error]);
    exit;
}

// Truy vấn dữ liệu giảng viên
$query = "SELECT * FROM giangvien";
$result = $conn->query($query);

if (!$result) {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => "Lỗi khi truy vấn dữ liệu: " . $conn->error]);
    exit;
}

// Tạo file PDF
$pdf = new \TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Hệ thống Quản lý Giảng viên');
$pdf->SetTitle('Danh Sách Giảng Viên');

// Sử dụng font hỗ trợ tiếng Việt
$pdf->SetFont('dejavusans', '', 12); // Thay 'helvetica' bằng 'dejavusans'

$pdf->AddPage();

// Tiêu đề PDF
$pdf->SetFont('dejavusans', 'B', 14); // Đổi font cho tiêu đề
$pdf->Cell(0, 10, 'Danh Sách Giảng Viên', 0, 1, 'C');

// Bảng dữ liệu
$pdf->SetFont('dejavusans', '', 12); // Đổi font cho nội dung
$pdf->Ln(5);

// Kẽ bảng với các ô có độ rộng phù hợp
$pdf->Cell(30, 10, 'Mã', 1, 0, 'C');
$pdf->Cell(40, 10, 'Họ Tên', 1, 0, 'C'); 
$pdf->Cell(30, 10, 'Trình Độ', 1, 0, 'C'); 
$pdf->Cell(30, 10, 'Chức Vụ', 1, 0, 'C');
$pdf->Cell(50, 10, 'Email', 1, 1, 'C');

// Duyệt qua dữ liệu và thêm vào bảng
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['ma'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['hoten'], 1, 0, 'L');
        $pdf->Cell(30, 10, $row['trinhdo'], 1, 0, 'L');
        $pdf->Cell(30, 10, $row['chucvu'], 1, 0, 'L');
        $pdf->Cell(50, 10, $row['email'], 1, 1, 'L');
    }
} else {
    $pdf->Cell(0, 10, 'Không có dữ liệu', 1, 1, 'C');
}

// Xóa bộ đệm nếu có dữ liệu rác
if (ob_get_length()) {
    ob_end_clean();
}

// Đường dẫn lưu file PDF tạm thời
$filePath = './file-xuat/Danh_sach_giang_vien.pdf';

// Tạo thư mục nếu chưa tồn tại
if (!file_exists('./file-xuat')) {
    mkdir('./file-xuat', 0777, true);
}

// Lưu PDF vào server
$pdf->Output($filePath, 'F');

// Trả về JSON đường dẫn file PDF
header('Content-Type: application/json');
echo json_encode(["success" => true, "file" => $filePath]);
exit;
