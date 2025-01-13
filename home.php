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
                    echo "<li>Xin chào, " . htmlspecialchars($_SESSION['ho_va_ten']) . "</li>";
                    echo "<a href='#'><li>Tài khoản</li></a>";
                    echo "<a href='#'><li>Xem thời khóa biểu</li></a>";
                    
                } 
                else 
                {
                    echo "<a href='#' onclick='togglePopup()'><li>Đăng Nhập/Đăng Ký</li></a>";
                }
                ?>
                    <a href="#"><li>Liên Hệ</li></a>
                    <a href="https://tuyensinh.bachkhoahanoi.edu.vn/"><li>Về Nhà Trường</li></a>
                </ul>
                <ul id="btn-logout">
                    <?php
                        if (isset($_SESSION['masv']) && isset($_SESSION['ho_va_ten'])) 
                        {
                            echo "<a href='function/php/logout.php'><li>Đăng xuất</li></a>";
                        }
                    ?>
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
                    </div>
                    <div class="baiviet">
                        <div id="post">
                            <?php
                                if (isset($_SESSION['masv']) && isset($_SESSION['ho_va_ten'])) 
                                {
                                    echo '<button id="post-btn" onclick="toggleAddPostPopup()">';
                                    echo "Xin chào " . htmlspecialchars($_SESSION['ho_va_ten']) . ", bạn muốn chia sẻ điều gì?";
                                    echo '</button>';
                                } 
                                else
                                {
                                    echo '<button id="post-btn1" onclick="togglePopup()">Hôm nay bạn thế nào</button>';
                                }
                            ?>
                        </div>      
                        <?php
                        if (isset($_SESSION['message'])) 
                        {
                            echo "<div class='success-message'>" . $_SESSION['message'] . "</div>";
                            unset($_SESSION['message']); 
                        }

                        if (isset($_SESSION['error'])) 
                        {
                            echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                            unset($_SESSION['error']);
                        }
                        ?>

                        <?php
                        $sql = "SELECT * FROM post ORDER BY date DESC, time DESC";
                        $stmt = $pdo_diendan->prepare($sql);
                        $stmt->execute();
                        $posts = $stmt->fetchAll();

                        if ($posts) 
                        {
                            foreach ($posts as $post) 
                            {
                                echo "<div class='post-item'>";
                                echo "<small>Đăng bởi: " . htmlspecialchars($post['ho_va_ten']) . " vào " . $post['date'] . " lúc " . $post['time'] . "</small>";
                                echo "<h3>" . htmlspecialchars($post['title']) . "</h3>";
                                echo "<p>" . htmlspecialchars($post['content']) . "</p>";
                                echo "</div>";
                            }
                        } 
                        ?>                
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

        <!-- Thêm bài viết diễn đàn -->
        <div id="add-post-popup">
            <div class="popup-content">
            <span class="close-btn" onclick="toggleAddPostPopup()">✖</span>
            <div class="form-wrapper">
                <form action="function/php/save_post.php" method="POST">
                    <h2>Thêm bài viết mới</h2>
                    <input type="text" name="title" placeholder="Tiêu đề bài viết" required />
                    <textarea name="content" placeholder="Nội dung bài viết" rows="5" required></textarea>
                    <button type="submit">Đăng bài</button>
                </form>
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
        
        <script src="/function/java/post-status.js"></script>
        <script src="/function/java/post-popup.js" ></script>
        <script src="/function/java/scrollbar.js"></script>
        <script src="/function/java/time.js"></script>
        <script src="/function/java/popup.js"></script>
        <script src="/function/java/menu-left.js"></script>
        <script src="/function/java/page_slide.js"></script>
        <script src="/function/java/search-placeholder.js"></script>       
</body>     
</html>
