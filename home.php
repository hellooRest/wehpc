<?php
include 'config.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Wehpc - Trang chủ</title>
        <link rel="stylesheet" href="css/home1.css" type="text/css" />
    </head>
    
    <body>
        <!-- Đầu Trang -->
        <div class="home">
            <p id="menu_symbol">☰</p>
            <div id="menu">
                <ul>
                    <?php
                    session_start();
            
                    if (isset($_SESSION['user'])) 
                    {
                        echo "<li>" . $_SESSION['ho_va_ten'] . "</li>";
                        echo "<a href='#'><li>Tài khoản</li></a>";
                        echo "<a href='#'><li>Xem thời khóa biểu</li></a>";
                        echo "<a href='logout.php'><li>Đăng xuất</li></a>";
                    } 
                    else 
                    {
                        echo "<form id='account' action='login.php' method='POST'>";
                        echo "<li><button type='submit'>Đăng Nhập</button></li>";
                        echo "</form>";
                        echo "<form method='POST' action='register.php'>";
                        echo "<button type='submit'>Đăng ký</button>";
                        echo "</form>";
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
                            Mục 12
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
            
        <script src="/function/java/menu-left.js"></script>
        <script src="/function/java/page_slide.js"></script>
        <script src="/function/java/search-placeholder.js"></script>
    </body>
</html>