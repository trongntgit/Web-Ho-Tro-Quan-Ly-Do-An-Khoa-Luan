<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon links -->
    <link rel="apple-touch-icon" sizes="57x57" href="./favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="./favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Reset and custom CSS -->
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/login.css">

    <title>Quên mật khẩu</title>
</head>
<body>
    <main>
        <div class="content">
            <div class="body">
                <h1 class="login_title">
                    <a href="./index.php"><img src="./imge/logo.png" alt="Logo" class="logo_img"></a>
                </h1>
                <p>Trang web quản lý đồ án, khóa luận</p>

                <div class="main-login">
                    <form action="./xulyquenmatkhau.php" method="POST">
                        <div class="name_ac">
                            <div class="icon">
                                <img src="./imge/user-regular.svg" alt="User Icon">
                            </div>
                            <input type="text" name="ma" placeholder="Mã người dùng..." required>
                        </div>

                        <hr>

                        <div class="name_ac">
                            <div class="icon">
                                <img src="./imge/email.svg" alt="Email Icon">
                            </div>
                            <input type="email" name="email" placeholder="Nhập Email..." required>
                        </div>

                        <hr>

                        <button type="submit" class="btn">Gửi đi</button>
                        <div class="last-login">
                            <a href="./login.php">Đăng nhập</a>
                            <a href="./index.php">Về trang chủ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="./assets/javas/login.js"></script>
</body>
</html>
