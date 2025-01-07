<?php
    include 'function/php/config.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Wehpc - Trang chủ</title>
        <link rel="stylesheet" href="css/home1.css" type="text/css"/>
    </head>
    
    <body>
        <!-- Đầu Trang -->
        <p id="menu_symbol">☰</p>
        <div class="home">
            
            <div id="menu">
                <ul>
                <?php
                    session_start();
                    if (isset($_SESSION['user'])) {
                        echo "<li>" . $_SESSION['ho_va_ten'] . "</li>";
                        echo "<a href='#'><li>Tài khoản</li></a>";
                        echo "<a href='#'><li>Xem thời khóa biểu</li></a>";
                        echo "<a href='logout.php'><li>Đăng xuất</li></a>";
                    } else {
                        echo "<a href='#' onclick='togglePopup()'><li>Đăng Nhập/Đăng Ký</li></a>";
                    }
                ?>

                    <a href="#"><li>Liên Hệ</li></a>
                    <a href="#"><li>Về Nhà Trường</li></a>
                </ul>
            </div>
            
            <div id="menu_overlay"></div>
            <p id="time">Loadding...</p>
            <script src="function/java/time.js"></script>
            <span id="search">
                <form id="search-form" action="function/search.php" method="post">
                    <input type="text" name="search" id="search-input"/>
                    <button type="button" id="search-button"><img src="icon/search-analytics.png"></button>
                </form>
            </span>
        </div>
            
            <!-- Thân Trang -->
            <div class="main">
                <div class="switch">
                    <button id="btn-diendan" class="active">Diễn Đàn</button>
                    <button id="btn-gopy">Góp Ý</button>
                </div>
            
                <div class="body">
                    <div class="diendan">
                        <div class="bai">
                            Mục 1
                        </div>
                        <div class="baiviet"></div>
                        <button class="diendan-btn">+</button>
                    </div>
            
                    <div class="gopy">
                        Mục Góp ý
                        <button class="gopy-btn">+</button>
                    </div>
                </div>
            </div>

            <!-- Popup Đăng Nhập/Đăng Ký -->
            <div id="login-register">
                <div class="popup-container">
                    <span class="close-btn" onclick="togglePopup()">✖</span>
                    <div class="tabs">
                        <button id="btn-login" class="active" onclick="switchTab('login')">Đăng Nhập</button>
                        <button id="btn-register" onclick="switchTab('register')">Đăng Ký</button>
                    </div>
                    <div class="form-wrapper" id="form-wrapper">
                        <div id="login" class="form-container login-section">
                            <form action="function/php/login.php" method="POST">
                                <input type="text" name="masv" placeholder="Mã sinh viên" required />
                                <input type="password" name="mk" placeholder="Mật khẩu" required />
                                <button type="submit">Đăng Nhập</button>
                            </form>
                        </div>
                        <div id="register" class="form-container register-section">
                            <form action="function/php/register.php" method="POST">
                                <input type="text" name="masv" placeholder="Mã sinh viên" required />
                                <input type="text" name="ho_va_ten" placeholder="Họ và tên" required />
                                <input type="password" name="mk" placeholder="Mật khẩu" required />
                                <button type="submit">Đăng Ký</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <script src="/function/java/popup.js"></script>
        <script src="/function/java/menu-left.js"></script>
        <script src="/function/java/page_slide.js"></script>
        <script src="/function/java/search-placeholder.js"></script>       
    </body>
</html>