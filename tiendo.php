<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xem chi tiết đề tài</title>
    <link rel="stylesheet" href="./assets/css/detai.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Thêm CSS cho ghi chú */
        .note-input {
            width: 100%;
            height: 100px; /* Chiều cao cố định */
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            resize: none; /* Ngăn không cho người dùng thay đổi kích thước */
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
        <a href="./index.php" class="logo-container">
            <img src="./imge/logo.png" alt="Logo." class="logo_img">
            <div class="logo-text-container">
                <span class="logo-title">Hệ thống quản lý</span>
                <span class="logo-subtitle">Đồ án, khóa luận</span>
            </div>
        </a>
        <h1 class="main-title">Xem chi tiết đề tài</h1>
    </header>

    <!-- Container -->
    <div class="container">
        
        <!-- Chi tiết đề tài -->
        <header class="header">
            <h1 class="title">Chi tiết đề tài</h1>
            <button class="button button-add" onclick="addSection()">Thêm Phần Mới</button>
        </header>

        <!-- Phần Thông Báo -->
        <section class="section">
            <div class="section-header">
                <h2>Thông Báo</h2>
                <button class="button button-add" onclick="addSubSection(this, 'thongbao')"><i class="fas fa-plus"></i> Thêm Thông Báo</button>
            </div>
            <div class="section-content"></div>
        </section>

        <!-- Phần Thông Tin Đề Tài -->
        <section class="section">
            <div class="section-header">
                <h2>Thông Tin Đề Tài</h2>
                <button class="button button-add" onclick="addSubSection(this, 'thongtin')"><i class="fas fa-plus"></i> Thêm Thông Tin</button>
            </div>
            <div class="section-content"></div>
        </section>

        <!-- Phần Nộp Sản Phẩm -->
        <section class="section">
            <div class="section-header">
                <h2>Nộp sản phẩm</h2>
                <button class="button button-add" onclick="addSubSection(this, 'nopbai')"><i class="fas fa-upload"></i> Thêm Nộp Sản Phẩm</button>
            </div>
        </section>

        <!-- Phần Tài Liệu Tham Khảo -->
        <section class="section">
            <div class="section-header">
                <h2>Tài Liệu Tham Khảo</h2>
                <button class="button button-add" onclick="addSubSection(this, 'tailieu')"><i class="fas fa-book"></i> Thêm Tài Liệu</button>
            </div>
        </section>

        <!-- Phần Trao Đổi - Thảo Luận -->
        <section class="section">
            <div class="section-header">
                <h2>Trao Đổi - Thảo Luận</h2>
                <button class="button button-add" onclick="showChatModal()"><i class="fas fa-comments"></i> Thêm Thảo Luận</button>
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
                <label for="submissionDeadline">Thời hạn nộp:</label>
                <input type="date" id="submissionDeadline">
            </div>

            <button onclick="addSubSectionContent()">Thêm</button>
            <button onclick="closeModal()">Hủy</button>
        </div>
    </div>


    <!-- Modal Đánh Giá -->
<div id="model-danhgia" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('model-danhgia')">&times;</span>
        <h2>Đánh Giá Tiến Độ</h2>
        <div class="modal-body">
            <textarea id="evaluation-content" placeholder="Nhập nội dung đánh giá"></textarea>
            <label for="progress-percentage">Phần trăm hoàn thành:</label>
            <input type="number" id="progress-percentage" min="0" max="100" placeholder="Nhập phần trăm" />
        </div>
        <div class="modal-footer">
            <button class="button-save" id="save-evaluation">Lưu đánh giá</button>
        </div>
    </div>
</div>

<!-- Modal Check AI -->
<div id="model-ai" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('model-ai')">&times;</span>
        <h2>Kết Quả Kiểm Tra AI</h2>
        <div class="modal-body">
            <p>Kết quả kiểm tra sẽ được hiển thị ở đây.</p>
        </div>
        <div class="modal-footer">
            <button class="button-close" onclick="closeModal('model-ai')">Đóng</button>
        </div>
    </div>
</div>

    <!-- Footer -->
    <footer class="footer">
        <div class="content">
            <div class="body">
                <div class="footer-left">
                    <p class="title">TRƯỜNG ĐẠI HỌC SƯ PHẠM KỸ THUẬT VĨNH LONG</p>
                    <div class="desc"><span>Địa chỉ</span>: 73 Nguyễn Huệ, phường 2, thành phố Vĩnh Long, tỉnh Vĩnh Long</div>
                    <div class="desc"><span>Điện thoại</span>: (+84) 02703.822141 - <span>Fax</span>: (+84) 02703.821003 - <span>Email</span>: spktvl@vlute.edu.vn</div>
                </div>
                <div class="footer-right">
                    <div class="desc"><strong>2024</strong> <span>Nguyễn Tuấn Trọng</span></div>
                    <div class="desc"><span>Email</span> : 21004235@st.vlute.edu.vn</div>
                </div>
            </div>
        </div>  
    </footer>

    <script src="./assets/javas/detai.js"></script>
</body>
</html>