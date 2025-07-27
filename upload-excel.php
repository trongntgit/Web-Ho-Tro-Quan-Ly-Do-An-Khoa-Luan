<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Đảm bảo đường dẫn đúng đến autoload.php của PhpSpreadsheet
require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Exception;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hiển thị thông tin về tệp tin gửi lên cho mục đích gỡ lỗi
    error_log(print_r($_FILES, true));

    // Kiểm tra xem có tệp tin được gửi không
    if (!isset($_FILES['file']['tmp_name']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Không có file tải lên hoặc có lỗi xảy ra khi tải lên.']);
        exit;
    }

    $file = $_FILES['file']['tmp_name'];
    $spreadsheet = null;

    try {
        $spreadsheet = IOFactory::load($file);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi đọc file Excel: ' . $e->getMessage()]);
        exit;
    }

    $server = "localhost";
    $database = "qlnv";
    $user = "root";
    $pass = "";
    $port = 3309;

    $con = new mysqli($server, $user, $pass, $database, $port);

    if ($con->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Kết nối CSDL thất bại: ' . $con->connect_error]);
        exit;
    }

    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    if (empty($rows)) {
        echo json_encode(['success' => false, 'message' => 'Tệp Excel không có dữ liệu.']);
        $con->close();
        exit;
    }

    $header = array_shift($rows);

    $successCount = 0;
    $failureCount = 0;
    $existingEmployees = [];
    $failedRecords = [];

    foreach ($rows as $row) {
        if (count($row) >= 3) {
            $manv = $row[0];
            $hoten = $row[1];
            $mabcc = $row[2];

            if (empty($mabcc)) {
                $failureCount++;
                $failedRecords[] = ['manv' => $manv, 'hoten' => $hoten, 'mabcc' => $mabcc, 'error' => 'Mã bcc không được bỏ trống'];
                continue;
            }

            $checkQuery = "SELECT COUNT(*) AS count FROM chamcong WHERE manv = ? AND mabcc = ?";
            $checkStmt = $con->prepare($checkQuery);

            if ($checkStmt) {
                $checkStmt->bind_param('ss', $manv, $mabcc);
                $checkStmt->execute();
                $checkStmt->bind_result($count);
                $checkStmt->fetch();
                $checkStmt->close();

                if ($count > 0) {
                    $existingEmployees[] = $manv;
                    $failureCount++;
                    $failedRecords[] = ['manv' => $manv, 'hoten' => $hoten, 'mabcc' => $mabcc, 'error' => 'Nhân viên đã tồn tại'];
                    continue;
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi kiểm tra dữ liệu: ' . $con->error]);
                $con->close();
                exit;
            }

            $query = "INSERT INTO chamcong (manv, hoten, mabcc) VALUES (?, ?, ?)";
            $stmt = $con->prepare($query);
            
            if ($stmt) {
                $stmt->bind_param('sss', $manv, $hoten, $mabcc);
                $stmt->execute();
                
                if ($stmt->affected_rows > 0) {
                    $successCount++;
                } else {
                    $failureCount++;
                    $failedRecords[] = ['manv' => $manv, 'hoten' => $hoten, 'mabcc' => $mabcc, 'error' => 'Lỗi khi thêm dữ liệu'];
                    error_log('Lỗi khi thêm dữ liệu: ' . $stmt->error);
                }
                
                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi chuẩn bị câu lệnh SQL: ' . $con->error]);
                $con->close();
                exit;
            }
        } else {
            $failureCount++;
            $failedRecords[] = ['error' => 'Dữ liệu không đầy đủ'];
        }
    }

    $con->close();

    echo json_encode([
        'success' => true,
        'message' => 'Hoàn tất. Thêm thành công ' . $successCount . ' nhân viên, không thêm được ' . $failureCount . ' nhân viên.',
        'existingEmployees' => $existingEmployees,
        'failedRecords' => $failedRecords
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Phương thức yêu cầu không hợp lệ.']);
}
?>
