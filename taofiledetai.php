<?php
session_start();

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doan2";
$port = 3309;
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_POST['madetai'])) {
    $madetai = $_POST['madetai'];
    $_SESSION['madetai-tao'] = $madetai;
    $filename = "./detai/{$madetai}.php";
    
    // Nội dung HTML cần mã hóa
    $htmlContent = <<<HTML
<!-- Đặt vào file đề tài (vd. detai/madetai.php) -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xem chi tiết đề tài</title>
     <!--Phần favicon -->
     <link rel="apple-touch-icon" sizes="57x57" href="../favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
    <link rel="manifest" href="../favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="../assets/css/detai.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Thêm CSS cho ghi chú */
        .note-input {
            width: 100%;
            height: 100px;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            resize: none;
        }

        /* Styling for the submission title */
        .submission-title {
            font-weight: bold;
            font-size: 1.1em;
            color: #333;
            margin-bottom: 10px;
        }
        .message.self {
            text-align: right;
            background-color: #d1e7dd;
            border-radius: 10px;
            padding: 5px;
            margin: 5px 0;
        }
        .message.other {
            text-align: left;
            background-color: #f8d7da;
            border-radius: 10px;
            padding: 5px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header-big">
        <a href="../index.php" class="logo-container">
            <img src="../imge/logo.png" alt="Logo." class="logo_img">
            <div class="logo-text-container">
                <span class="logo-title">Hệ thống quản lý</span>
                <span class="logo-subtitle">Đồ án, khóa luận</span>
            </div>
        </a>
        <h1 class="main-title">Xem chi tiết đề tài</h1>
    </header>

    <div class="container-top">
        <header class="header">
            <h1 class="title" id="title">Xem chi tiết đề tài</h1>
            <button class="button button-add" onclick="addSection()">Thêm Phần Mới</button>
        </header>

        <!-- Phần thông báo -->
        <section class="section">
            <div class="section-header">
                <h2>Thông Báo</h2>
                <button class="button button-add" onclick="addSubSection(this, 'thongbao')"><i class="fas fa-plus"></i> Thêm Thông Báo</button>
            </div>
            <div class="section-content"></div>
        </section>

        <!-- Phần thông tin đề tài -->
        <section class="section">
            <div class="section-header">
                <h2>Thông Tin Đề Tài</h2>
                <button class="button button-add" onclick="addSubSection(this, 'thongtin')"><i class="fas fa-plus"></i> Thêm Thông Tin</button>
            </div>
            <div class="section-content"></div>
        </section>

        <!-- Phần nộp bài -->
        <section class="section">
            <div class="section-header">
                <h2>Nộp sản phẩm</h2>
                <button class="button button-add" onclick="addSubSection(this, 'nopbai')"><i class="fas fa-upload"></i> Thêm Nộp Sản Phẩm</button>
            </div>
            <div class="section-content">
    
            </div>
        </section>

        <!-- Phần tài liệu tham khảo -->
        <section class="section">
            <div class="section-header">
                <h2>Tài Liệu Tham Khảo</h2>
                <button class="button button-add" onclick="addSubSection(this, 'tailieu')"><i class="fas fa-book"></i> Thêm Tài Liệu</button>
            </div>
            <div class="section-content">
    
            </div>
        </section>

        <!-- Phần trao đổi - Thảo Luận -->
        <section class="section">
            <div class="section-header">
                <h2>Trao Đổi - Thảo Luận</h2>
            </div>
            <div class="section-content">
                <div class="chat-container">
                    <div class="chat-box" id="chatBox"></div>
                    <textarea id="chatInput" class="chat-input" placeholder="Nhập tin nhắn..." onkeyup="checkEnter(event, userId, dt2)"></textarea>
                    <button class="button button-send" onclick="sendChatMessage(userId, username, dt2)">Gửi</button>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal for adding content -->
    <div class="modal" id="subSectionModal">
        <div class="modal-content">
            <h2>Thêm Nội Dung Con</h2>
            <label for="subSectionType">Loại nội dung:</label>
            <select id="subSectionType" onchange="toggleSubmissionOptions()">
                <option value="thongbao">Thông Báo</option>
                <option value="nopbai">Nộp sản phẩm</option>
                <option value="tailieu">Tài Liệu</option>
                <option value="thaoLuan">Thảo Luận</option>
            </select>

            <!-- Additional fields for "Nộp sản phẩm" -->
            <div id="submissionOptions" style="display: none; margin-top: 10px;">
                <label for="submissionType">Chọn loại nộp:</label>
                <select id="submissionType">
                    <option value="progress">Nộp tiến độ</option>
                    <option value="final">Nộp sản phẩm cuối cùng</option>
                </select>
                <label for="submissionDeadline" style="width: 603px;">Thời hạn nộp:</label>
                <input type="date" id="submissionDeadline">
            </div>

            <button onclick="addSubSectionContent()">Thêm</button>
            <button onclick="closeModal()">Hủy</button>
        </div>
    </div>

    <!-- Modal for editing submission -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Chỉnh sửa Nộp sản phẩm</h2>
            <label for="editDeadline">Thời hạn nộp:</label>
            <input type="date" id="editDeadline" />
            <label for="editNote">Ghi chú:</label>
            <textarea id="editNote" placeholder="Nhập ghi chú..."></textarea>
            <button onclick="saveSubSectionChanges()">Lưu thay đổi</button>
        </div>
    </div>

        <!-- Modal cho chỉnh sửa "Thông báo" -->
        <div id="editAnnouncementModal" class="modal">
            <div class="modal-content">
                <h2>Chỉnh sửa Thông Báo</h2>
                <textarea id="editAnnouncementContent" placeholder="Nhập nội dung thông báo..."></textarea>
                <div class="modal-buttons">
                    <button class="btn btn-save" onclick="saveEditAnnouncement()">Lưu thay đổi</button>
                    <button class="btn btn-close" onclick="closeModal2('editAnnouncementModal')">Đóng</button>
                </div>
            </div>
        </div>

    <!-- Modal cho chỉnh sửa "Tài liệu" -->
    <div id="editDocumentModal" class="modal">
        <h2>Chỉnh sửa Tài liệu</h2>
        <input type="file" id="editDocumentFile">
        <button onclick="saveEditDocument()">Lưu thay đổi</button>
        <button onclick="closeModal2('editDocumentModal')">Đóng</button>
    </div>

        <!-- Modal Đánh Giá -->

    <div id="model-danhgia" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal2('model-danhgia')">&times;</span>
            <h2>Đánh Giá Tiến Độ</h2>
            <div class="modal-body">
                <textarea id="evaluation-content" placeholder="Nhập nội dung đánh giá"></textarea>
                <label for="progress-percentage">Phần trăm hoàn thành:</label>
                <input type="number" id="progress-percentage" min="0" max="100" placeholder="Nhập phần trăm" />
                <div>
                    <label>Tổng phần trăm tiến độ:</label>
                    <span id="total-percentage" style="font-weight: bold;">0%</span>
                </div>
            </div>
            <div class="modal-footer">
                <button class="button-save" id="save-evaluation">Lưu đánh giá</button>
            </div>
        </div>
    </div>


    <!-- Modal Check AI -->
    <div id="model-ai" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal2('model-ai')">&times;</span>
            <h2>Kết Quả Kiểm Tra AI</h2>
            <div class="modal-body">
                <p>Kết quả kiểm tra sẽ được hiển thị ở đây.</p>
            </div>
            <div class="modal-footer">
                <button class="button-close" onclick="closeModal2('model-ai')">Đóng</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="content">
            <div class="footer-left">
                <p class="title">TRƯỜNG ĐẠI HỌC SƯ PHẠM KỸ THUẬT VĨNH LONG</p>
                <div class="desc"><span>Địa chỉ</span>: 73 Nguyễn Huệ, phường 2, thành phố Vĩnh Long, tỉnh Vĩnh Long</div>
                <div class="desc"><span>Điện thoại</span>: (+84) 02703.822141 - <span>Fax</span>: (+84) 02703.821003 - <span>Email</span>: spktvl@vlute.edu.vn</div>
            </div>
            <div class="footer-right">
                <div class="desc"><strong>2024</strong> <span>Nguyễn Tuấn Trọng</span></div>
                <div class="desc"><span>Email</span>: 21004235@st.vlute.edu.vn</div>
            </div>
        </div>
    </footer>

    <script src="../assets/javas/detai.js"></script>
</body>
</html>

HTML;

// Mã hóa nội dung HTML trước khi lưu vào CSDL
$encodedHtmlContent = base64_encode($htmlContent);

// Tạo nội dung file PHP để hiển thị trang
$phpContent2 = <<<PHP
<?php
session_start();

// Kết nối đến cơ sở dữ liệu
\$servername = "localhost";
\$username = "root";
\$password = "";
\$dbname = "doan2";
\$port = 3309;
\$madetai = "{$_SESSION['madetai-tao']}";

// Tạo kết nối
\$conn = new mysqli(\$servername, \$username, \$password, \$dbname, \$port);

// Kiểm tra kết nối
if (\$conn->connect_error) {
    die("Kết nối thất bại: " . \$conn->connect_error);
}

// Lấy nội dung giao diện từ bảng `giaodien`
\$sql_all = "SELECT giaodien FROM giaodien WHERE id = ?";
\$stmt_all = \$conn->prepare(\$sql_all);
\$stmt_all->bind_param("s", \$madetai);
\$stmt_all->execute();
\$result_all = \$stmt_all->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đề tài của tôi</title>
    <link rel="stylesheet" href="../assets/css/detai.css">
</head>
<body>
    <div class="container">
        <?php
        if (\$result_all->num_rows > 0) {
            while (\$row = \$result_all->fetch_assoc()) {
                // Giải mã nội dung đã mã hóa
                \$decodedContent = base64_decode(\$row['giaodien']);
                echo \$decodedContent;
            }
        } else {
            echo "<p>Không có đề tài nào.</p>";
        }
        ?>
    </div>
</body>
</html>
PHP;

// Kiểm tra xem file có được tạo thành công không
if (file_put_contents($filename, $phpContent2)) {
    // Tạo câu truy vấn để thêm vào bảng `giaodien`
    $stmt = $conn->prepare("INSERT INTO giaodien (id, giaodien) VALUES (?, ?)");
    $stmt->bind_param("ss", $madetai, $encodedHtmlContent);

    // Thực thi truy vấn và kiểm tra kết quả
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'File được tạo và giao diện đã thêm vào CSDL']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Tạo file thành công nhưng không thêm được vào CSDL']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi tạo file']);
}

    $conn->close();
}
?>
