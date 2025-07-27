<?php
require 'vendor/autoload.php'; // Đảm bảo bạn đã cài TCPDF qua Composer

session_start();
ini_set('display_errors', 1); 
error_reporting(E_ALL);


// Thông tin kết nối CSDL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;

// Kết nối đến CSDL
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error]);
    exit;
}

// Truy vấn dữ liệu giảng viên
$query = "SELECT * FROM sinhvien";
$result = $conn->query($query);

if (!$result) {
    echo json_encode(["success" => false, "message" => "Lỗi khi truy vấn dữ liệu: " . $conn->error]);
    exit;
}

// Tạo file PDF
$pdf = new \TCPDF(); // Chú ý thêm dấu backslash ở trước TCPDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Quản lý sinh viên');
$pdf->SetTitle('Danh Sách Sinh Viên');

// Sử dụng font hỗ trợ tiếng Việt
$pdf->SetFont('dejavusans', '', 12); // Thay 'helvetica' bằng 'dejavusans'

$pdf->AddPage();

// Tiêu đề PDF
$pdf->SetFont('dejavusans', 'B', 14); // Đổi font cho tiêu đề
$pdf->Cell(0, 10, 'Danh Sách Sinh Viên', 0, 1, 'C');

// Bảng dữ liệu
$pdf->SetFont('dejavusans', '', 12); // Đổi font cho nội dung
$pdf->Ln(5);

// Kẽ bảng với các ô có độ rộng phù hợp (không sử dụng MultiCell)
$pdf->Cell(30, 10, 'Mã', 1, 0, 'C'); // Thay MultiCell bằng Cell
$pdf->Cell(40, 10, 'Họ Tên', 1, 0, 'C'); 
$pdf->Cell(30, 10, 'Lớp', 1, 0, 'C'); 
$pdf->Cell(30, 10, 'Điểm tích lũy', 1, 0, 'C');
$pdf->Cell(50, 10, 'Email', 1, 0, 'C'); 
$pdf->Cell(50, 10, 'sdt', 1, 0, 'C'); 
$pdf->Cell(50, 10, 'Địa chỉ', 1, 1, 'C'); // Dòng kết thúc và xuống dòng ở đây
$pdf->Ln();

// Duyệt qua dữ liệu và thêm vào bảng
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Sử dụng Cell thay cho MultiCell để ngừng việc xuống dòng
        $pdf->Cell(30, 10, $row['ma'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['hoten'], 1, 0, 'L');
        $pdf->Cell(30, 10, $row['lop'], 1, 0, 'L');
        $pdf->Cell(30, 10, $row['diemtichluy'], 1, 0, 'L');
        $pdf->Cell(50, 10, $row['email'], 1, 0, 'L'); 
        $pdf->Cell(50, 10, $row['sdt'], 1, 0, 'L'); 
        $pdf->Cell(50, 10, $row['diachi'], 1, 1, 'L'); // Dòng kết thúc và xuống dòng ở đây
    }
} else {
    $pdf->Cell(0, 10, 'Không có dữ liệu', 1, 1, 'C');
}

// Làm sạch bộ đệm để đảm bảo không có dữ liệu rác
ob_clean();

// Xuất file PDF
$pdf->Output('Danh_sach_sinh_vien.pdf', 'D'); // Chế độ 'D' để tải về
exit;


?>