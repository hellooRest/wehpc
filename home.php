<?php
include('function/php/config.php');

if (isset($_GET['popup'])) {
    $popup = $_GET['popup'];
    echo "<script>document.addEventListener('DOMContentLoaded', function() { togglePopup(); switchTab('$popup'); });</script>";
}

// Lấy lỗi đăng nhập/đăng ký (nếu có)
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : [];
unset($_SESSION['error_message']); // Xóa lỗi sau khi load
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
                if (isset($_SESSION['role']) == 'admin')
                {
                    echo "<a href='#'><li>Thông báo Website</li></a>";
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
            <script src="function/java/time.js"></script>
            <span id="search">
                <form id="search-form" action="/function/php/search.php" method="post">
                    <input type="text" name="search" id="search-input" />
                    <input type="hidden" name="active_section" id="active-section" value="diendan" />
                    <button type="submit" id="search-button">
                        <img src="icon/search-analytics.png" />
                    </button>
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
                        <?php
                        if(isset($_SESSION['role']) == "admin")
                        {
                            echo '<button class="trending-btn">+</button>';
                        }
                        ?>
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
                                    echo '<button id="post-btn1" onclick="togglePopup()">Hôm nay bạn thế nào!!!</button>';
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
                $sql = "SELECT * FROM diendanpost ORDER BY date DESC, time DESC";
                $stmt = $pdo_diendan->prepare($sql);
                $stmt->execute();
                $posts = $stmt->fetchAll();

                if ($posts) 
                {
                    foreach ($posts as $post) 
                    {
                        $date = DateTime::createFromFormat('Y-m-d', $post['date'])->format('d/m/yy  ');
                        $time = DateTime::createFromFormat('H:i:s', $post['time'])->format('H:i');

                        echo "<div class='post-item'>";
                        echo "<div class='post-header'>";
                        echo "<p class='post-user'>" . htmlspecialchars($post['ho_va_ten']) . "</p>";
                        echo "<p class='post-time'>" . $date . " lúc " . $time . "</p>";
                        echo "<div class='post-menu'>";
                        echo "<button class='menu-btn'>⋮</button>";
                        echo "<div class='menu-dropdown'>";

                        if ($_SESSION['masv'] === $post['masv']) {
                            echo "<button class='dropdown-btn' onclick='toggleEditPostPopup({$post['id']}, \"" . htmlspecialchars($post['title']) . "\", \"" . htmlspecialchars($post['content']) . "\")'>Chỉnh sửa</button>";
                            echo "<button class='dropdown-btn' onclick='toggleDeletePostPopup({$post['id']})'>Xóa</button>";
                        } elseif ($_SESSION['role'] === 'admin') {
                            echo "<button class='dropdown-btn' onclick='toggleDeletePostPopup({$post['id']})'>Xóa</button>";
                        } else {
                            echo "<button class='dropdown-btn' onclick='reportPost({$post['id']})'>Tố cáo</button>";
                        }

                        echo "</div>";
                        echo "</div>"; 
                        echo "</div>"; 
                        echo "<h3>" . htmlspecialchars($post['title']) . "</h3>";
                        echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";


                        // Lấy tổng số vote
                        $stmt = $pdo_diendan->prepare("
                            SELECT 
                                SUM(vote) AS total_votes 
                            FROM diendanvote 
                            WHERE id = :id
                        ");

                        $stmt->execute([':id' => $post['id']]);
                        $votes = $stmt->fetch(PDO::FETCH_ASSOC);

                        $totalVotes = $votes['total_votes'] ?? 0;

                        if (isset($_SESSION['masv']) && isset($_SESSION['ho_va_ten'])) {
                            // Kiểm tra người dùng đã vote bài viết này chưa
                            $stmt = $pdo_diendan->prepare("SELECT vote FROM diendanvote WHERE id = :id AND masv = :masv");
                            $stmt->execute([':id' => $post['id'], ':masv' => $_SESSION['masv']]);
                            $userVote = $stmt->fetch(PDO::FETCH_ASSOC);

                            // Trạng thái nút upvote và downvote
                            $upvoteActive = ($userVote && $userVote['vote'] == 1) ? "chose" : "default";
                            $downvoteActive = ($userVote && $userVote['vote'] == -1) ? "chose" : "default";
                            
                            echo "<div class='vote' data-post-id='{$post['id']}'>";
                            echo "<button class='upvote {$upvoteActive}' data-action='upvote'>";
                            echo "<img src='icon/arrow-up.png' alt='Upvote' class='default'>";
                            echo "<img src='icon/arrow-up-chose.png' alt='Upvote' class='chose'>";
                            echo "</button>";
                            echo "<span class='vote-count' id='vote-count-{$post['id']}'>" . $totalVotes . "</span>";
                            echo "<button class='downvote {$downvoteActive}' data-action='downvote'>";
                            echo "<img src='icon/arrow-down.png' alt='Downvote' class='default'>";
                            echo "<img src='icon/arrow-down-chose.png' alt='Downvote' class='chose'>";
                            echo "</button>";
                            echo "</div>";
                        } 
                        else 
                        {
                            echo "<span class='vote-count' id='vote-count-{$post['id']}'>" . $totalVotes . " trending</span>";
                        }
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
                            if (isset($_SESSION['masv']) && isset($_SESSION['ho_va_ten'])) {
                                echo '<button id="post-btn" onclick="toggleAddPostPopup()">';
                                echo "Xin chào " . htmlspecialchars($_SESSION['ho_va_ten']) . ", bạn muốn góp ý gì?";
                                echo '</button>';
                            } else {
                                echo '<button id="post-btn1" onclick="togglePopup()">Chúng tôi lắng nghe góp ý từ bạn!</button>';
                            }
                            ?>
                        </div>                 
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo "<div class='success-message'>" . $_SESSION['message'] . "</div>";
                            unset($_SESSION['message']);
                        }

                        if (isset($_SESSION['error'])) {
                            echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                            unset($_SESSION['error']);
                        }
                        ?>
                        <?php
                        $sql = "SELECT * FROM gopypost ORDER BY date DESC, time DESC";
                        $stmt = $pdo_diendan->prepare($sql);
                        $stmt->execute();
                        $posts = $stmt->fetchAll();

                        if ($posts) 
                {
                    foreach ($posts as $post) 
                    {
                        $date = DateTime::createFromFormat('Y-m-d', $post['date'])->format('d/m/yy  ');
                        $time = DateTime::createFromFormat('H:i:s', $post['time'])->format('H:i');

                        echo "<div class='post-item'>";
                        echo "<div class='post-header'>";
                        echo "<p class='post-user'>" . htmlspecialchars($post['ho_va_ten']) . "</p>";
                        echo "<p class='post-time'>" . $date . " lúc " . $time . "</p>";
                        echo "<div class='post-menu'>";
                        echo "<button class='menu-btn'>⋮</button>";
                        echo "<div class='menu-dropdown'>";

                        if ($_SESSION['masv'] === $post['masv']) {
                            echo "<button class='dropdown-btn' onclick='toggleEditPostPopup({$post['id']}, \"" . htmlspecialchars($post['title']) . "\", \"" . htmlspecialchars($post['content']) . "\")'>Chỉnh sửa</button>";
                            echo "<button class='dropdown-btn' onclick='toggleDeletePostPopup({$post['id']})'>Xóa</button>";
                        } elseif ($_SESSION['role'] === 'admin') {
                            echo "<button class='dropdown-btn' onclick='toggleDeletePostPopup({$post['id']})'>Xóa</button>";
                        } else {
                            echo "<button class='dropdown-btn' onclick='reportPost({$post['id']})'>Tố cáo</button>";
                        }

                        echo "</div>";
                        echo "</div>"; 
                        echo "</div>"; 
                        echo "<h3>" . htmlspecialchars($post['title']) . "</h3>";
                        echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";



                        // Lấy tổng số vote
                        $stmt = $pdo_diendan->prepare("
                            SELECT 
                                SUM(vote) AS total_votes 
                            FROM diendanvote 
                            WHERE id = :id
                        ");

                        $stmt->execute([':id' => $post['id']]);
                        $votes = $stmt->fetch(PDO::FETCH_ASSOC);

                        $totalVotes = $votes['total_votes'] ?? 0;

                        if (isset($_SESSION['masv']) && isset($_SESSION['ho_va_ten'])) {
                            // Kiểm tra người dùng đã vote bài viết này chưa
                            $stmt = $pdo_diendan->prepare("SELECT vote FROM diendanvote WHERE id = :id AND masv = :masv");
                            $stmt->execute([':id' => $post['id'], ':masv' => $_SESSION['masv']]);
                            $userVote = $stmt->fetch(PDO::FETCH_ASSOC);

                            // Trạng thái nút upvote và downvote
                            $upvoteActive = ($userVote && $userVote['vote'] == 1) ? "chose" : "default";
                            $downvoteActive = ($userVote && $userVote['vote'] == -1) ? "chose" : "default";
                            
                            echo "<div class='vote' data-post-id='{$post['id']}'>";
                            echo "<button class='upvote {$upvoteActive}' data-action='upvote'>";
                            echo "<img src='icon/arrow-up.png' alt='Upvote' class='default'>";
                            echo "<img src='icon/arrow-up-chose.png' alt='Upvote' class='chose'>";
                            echo "</button>";
                            echo "<span class='vote-count' id='vote-count-{$post['id']}'>" . $totalVotes . "</span>";
                            echo "<button class='downvote {$downvoteActive}' data-action='downvote'>";
                            echo "<img src='icon/arrow-down.png' alt='Downvote' class='default'>";
                            echo "<img src='icon/arrow-down-chose.png' alt='Downvote' class='chose'>";
                            echo "</button>";
                            echo "</div>";
                        } 
                        else 
                        {
                            echo "<span class='vote-count' id='vote-count-{$post['id']}'>" . $totalVotes . " trending</span>";
                        }
                        echo "</div>";
                    }
                }
                ?>
                </div>
                </div>
                </div>
            </div>
        </div>

        <!-- thêm bài viết vào diễn đàn -->
        <div id="add-post-popup">
            <div class="popup-content">
                <span class="close-btn" onclick="toggleAddPostPopup()">✖</span>
                <div class="form-wrapper">
                    <form id="post-form" method="POST">
                        <h2>Thêm bài viết mới</h2>
                        <input type="text" name="title" id="post-title" placeholder="Tiêu đề bài viết" required />
                        <textarea name="content" id="post-content" placeholder="Nội dung bài viết" rows="10" maxlength="5000" required></textarea>
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
                <!-- Form Đăng Nhập -->
                <div id="login" class="form-container login-section">
                    <form action="function/php/login.php" method="POST">
                        <input type="text" name="masv" placeholder="Mã sinh viên"
                            class="<?= isset($_SESSION['login_error']['masv']) ? 'error' : '' ?>"
                            value="<?= isset($_SESSION['login_data']['masv']) ? htmlspecialchars($_SESSION['login_data']['masv']) : '' ?>" />
                        <?php if (isset($_SESSION['login_error']['masv'])): ?>
                            <small class="error-message"><?= $_SESSION['login_error']['masv'] ?></small>
                        <?php endif; ?>

                        <input type="password" name="mk" placeholder="Mật khẩu"
                            class="<?= isset($_SESSION['login_error']['mk']) ? 'error' : '' ?>" />
                        <?php if (isset($_SESSION['login_error']['mk'])): ?>
                            <small class="error-message"><?= $_SESSION['login_error']['mk'] ?></small>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['login_error']['general'])): ?>
                            <div class="error-message general"><?= $_SESSION['login_error']['general'] ?></div>
                        <?php endif; ?>

                        <button type="submit">Đăng Nhập</button>
                    </form>
                </div>

                <!-- Form Đăng Ký -->
                <div id="register" class="form-container register-section">
                    <form action="function/php/register.php" method="POST">
                        <input type="text" name="masv" placeholder="Mã sinh viên" required minlength="10" maxlength="10"
                            class="<?= isset($_SESSION['register_error']['masv']) ? 'error' : '' ?>"
                            value="<?= isset($_SESSION['register_data']['masv']) ? htmlspecialchars($_SESSION['register_data']['masv']) : '' ?>" />
                        <?php if (isset($_SESSION['register_error']['masv'])): ?>
                            <small class="error-message"><?= $_SESSION['register_error']['masv'] ?></small>
                        <?php endif; ?>

                        <input type="text" name="ho_va_ten" placeholder="Họ và tên"
                            class="<?= isset($_SESSION['register_error']['ho_va_ten']) ? 'error' : '' ?>"
                            value="<?= isset($_SESSION['register_data']['ho_va_ten']) ? htmlspecialchars($_SESSION['register_data']['ho_va_ten']) : '' ?>" />
                        <?php if (isset($_SESSION['register_error']['ho_va_ten'])): ?>
                            <small class="error-message"><?= $_SESSION['register_error']['ho_va_ten'] ?></small>
                        <?php endif; ?>

                        <input type="password" name="mk" placeholder="Mật khẩu"
                            class="<?= isset($_SESSION['register_error']['mk']) ? 'error' : '' ?>" />
                        <?php if (isset($_SESSION['register_error']['mk'])): ?>
                            <small class="error-message"><?= $_SESSION['register_error']['mk'] ?></small>
                        <?php endif; ?>

                        <input type="email" name="gmail" placeholder="Gmail"
                            class="<?= isset($_SESSION['register_error']['gmail']) ? 'error' : '' ?>"
                            value="<?= isset($_SESSION['register_data']['gmail']) ? htmlspecialchars($_SESSION['register_data']['gmail']) : '' ?>" />
                        <?php if (isset($_SESSION['register_error']['gmail'])): ?>
                            <small class="error-message"><?= $_SESSION['register_error']['gmail'] ?></small>
                        <?php endif; ?>

                        <button type="submit">Đăng Ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <script src="/function/java/post_enviromet.js"></script>
        <script src="/function/java/vote.js"></script>
        <script src="/function/java/post-status.js"></script>
        <script src="/function/java/post-popup.js" ></script>
        <script src="/function/java/scrollbar.js"></script>
        <script src="/function/java/popup.js"></script>
        <script src="/function/java/menu-left.js"></script>
        <script src="/function/java/page_switch.js"></script>
        <script src="/function/java/search.js"></script>
</body>     
</html>
