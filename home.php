<?php
include('function/php/config.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Wehpc - Trang chủ</title>
        <link rel="stylesheet" href="css/home.css" type="text/css"/>
    </head>
    
    <body>
        <!-- Đầu Trang -->
        <p id="menu_symbol">☰</p>
        <div class="home">
            <div id="menu">
                <ul>
                <?php
                if (isset($_SESSION['masv']) && isset($_SESSION['ho_va_ten'])) 
                {
                    echo "<li style='color=red;'>Xin chào, " . htmlspecialchars($_SESSION['ho_va_ten']) . "</li>";
                    echo "<a href='#'><li>Tài khoản</li></a>";
                    echo "<a href='#'><li>Xem thời khóa biểu</li></a>";
                    echo "<a href='function/php/logout.php'><li>Đăng xuất</li></a>";
                } 
                else 
                {
                    echo "<a href='#' onclick='togglePopup()'><li>Đăng Nhập/Đăng Ký</li></a>";
                }
                ?>
                    <a href="#"><li>Liên Hệ</li></a>
                    <a href="https://tuyensinh.bachkhoahanoi.edu.vn/"><li>Về Nhà Trường</li></a>
                </ul>
            </div>
            
            <div id="menu_overlay"></div>
            <p id="time">Loadding...</p>
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
                    <div class="trending">
                        <h1>Trending</h1>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p><p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p><p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        
                    </div>
                    <div class="baiviet">
                        <div id="post">
                            <?php
                                if (isset($_SESSION['masv']) && isset($_SESSION['ho_va_ten'])) 
                                {
                                    echo "Xin chào, " . htmlspecialchars($_SESSION['ho_va_ten']) . "";
                                }
                                else
                                {
                                    echo 'Hôm nay bạn thế nào';
                                }
                            ?>
                        </div>

                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p><p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p><p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p><p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p><p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p><p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                        <p>sadfsad</p>
                    </div>
                </div>
        
                <div class="gopy">
                <div class="trending">
                        <h1>Trending</h1>
                        
                    </div>
                    <div class="baiviet">
                        <div id="post">
                            <?php
                                if (isset($_SESSION['masv']) && isset($_SESSION['ho_va_ten'])) 
                                {
                                    echo "Xin chào, " . htmlspecialchars($_SESSION['ho_va_ten']) . "";
                                }
                                else
                                {
                                    echo 'Hôm nay bạn thế nào';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Thêm bài viết admin -->
        <?php
            if(isset($_SESSION['role']) == "admin")
            {
                echo '<button class="baiviet-btn">+</button>';
            }
        ?>
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
                            <input type="text" name="masv" placeholder="Mã sinh viên" required/>
                            <input type="password" name="mk" placeholder="Mật khẩu" required />
                            <button type="submit">Đăng Nhập</button>
                        </form>
                    </div>
                    <div id="register" class="form-container register-section">
                        <form action="function/php/register.php" method="POST">
                            <input type="text" name="masv" placeholder="Mã sinh viên" required />
                            <input type="text" name="ho_va_ten" placeholder="Họ và tên" required />
                            <input type="password" name="mk" placeholder="Mật khẩu" required />
                            <input type="gmail" name="gmail" placeholder="Gmail" required />
                            <button type="submit">Đăng Ký</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="/function/java/scrollbar.js"></script>
        <script src="/function/java/time.js"></script>
        <script src="/function/java/popup.js"></script>
        <script src="/function/java/menu-left.js"></script>
        <script src="/function/java/page_slide.js"></script>
        <script src="/function/java/search-placeholder.js"></script>       
</body>     
</html>
