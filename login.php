<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="apple-touch-icon" sizes="57x57" href="./favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="./favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
   

    
    <link rel="stylesheet" href="./assets/css/reset.css">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./asssets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--Phần custom css -->
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Đăng nhập</title>
</head>
<body>
    <main>
       <div class="content">
        <div class="body">
           <h1 class="login_title">  <a href=""><img src="./imge/logo.png" alt="Lesson." class="logo_img"></a> </h1>
           <p>Trang web quản lý đồ án, khóa luận</p>
           
           <div class="main-login">
                    <form action="./xulydangnhap.php" method="POST">
                        <div class="name_ac">
                            <div class="icon"><img src="./imge/user-regular.svg" alt=""></div>
                            <input type="text" name="tentk" placeholder="Tên dăng nhập...">
                        </div>
                        
                        <hr>
                        <div class="pass">
                            <div class="passw_ac">
                                <div class="icon"><img src="./imge/lock-solid.svg" alt=""></div>
                                <input type="password" name="mk" placeholder="Mật khẩu....">
                            
                            </div>
                            <div class="eys">  <input type="image" src="./imge/eye-slash-solid.svg" class="icon-eye" id="icon-eys" value="on" onclick="onclick_eys()"></div>
                     </div>
                        <hr>
                        <div class="remenber-login">
                            
                            <input type="checkbox" class="remenber" id="remenber">
                            <label for="remenber">Ghi nhớ đăng nhập</label>
                        </div>
                        <button type="submit" class="btn">Đăng nhập</button>
                        <div class="last-login">
                            <a href="./quenmatkhau.php">Quên mật khẩu?</a>
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