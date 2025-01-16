<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = htmlspecialchars($_POST['search']);
    $activeSection = $_POST['active_section'];  // Đảm bảo đã gửi đúng giá trị này từ JS

    if (empty($searchTerm)) {
        $_SESSION['error'] = "Vui lòng nhập từ khóa tìm kiếm!";
    } else {
        // Chọn bảng cần tìm kiếm dựa trên active section
        if ($activeSection === 'diendan') {
            $table = 'diendanpost';
        } elseif ($activeSection === 'gopy') {
            $table = 'gopypost';
        } else {
            $_SESSION['error'] = "Trang không hợp lệ!";
        }

        try {
            $sql = "SELECT * FROM $table WHERE title LIKE :search OR content LIKE :search ORDER BY date DESC, time DESC";
            $stmt = $pdo_diendan->prepare($sql);
            $stmt->execute([':search' => '%' . $searchTerm . '%']);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['error'] = "Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage();
        }
    }
}

// Lấy lỗi đăng nhập/đăng ký (nếu có)
$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Xóa lỗi sau khi load
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Wehpc - Trang chủ</title>
    <link rel="stylesheet" href="/css/home.css" type="text/css"/>
</head>

<body>
    <!-- Đầu Trang -->
    <p id="menu_symbol">☰</p>
    <div class="home">
        <div id="menu">
            <ul>
                <?php
                if (isset($_SESSION['masv']) && isset($_SESSION['ho_va_ten'])) {
                    echo "<li>Xin chào, " . htmlspecialchars($_SESSION['ho_va_ten']) . "</li>";
                    echo "<a href='#'><li>Tài khoản</li></a>";
                    echo "<a href='#'><li>Xem thời khóa biểu</li></a>";
                } else {
                    echo "<a href='#' onclick='togglePopup()'><li>Đăng Nhập/Đăng Ký</li></a>";
                }
                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                    echo "<a href='#'><li>Thông báo Website</li></a>";
                }
                ?>
                <a href="#"><li>Liên Hệ</li></a>
                <a href="https://tuyensinh.bachkhoahanoi.edu.vn/"><li>Về Nhà Trường</li></a>
            </ul>
            <ul id="btn-logout">
                <?php
                if (isset($_SESSION['masv']) && isset($_SESSION['ho_va_ten'])) {
                    echo "<a href='function/php/logout.php'><li>Đăng xuất</li></a>";
                }
                ?>
            </ul>
        </div>

        <div id="menu_overlay"></div>
        <p id="time">Loadding...</p>
        <script src="function/java/time.js"></script>
        <span id="search">
            <form id="search-form" action="search.php" method="post">
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
                    if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
                        echo '<button class="trending-btn">+</button>';
                    }
                    ?>
                </div>
                <div class="baiviet">
                    <div id="post">
                        <?php
                        if (isset($_SESSION['masv']) && isset($_SESSION['ho_va_ten'])) {
                            echo '<button id="post-btn" onclick="toggleAddPostPopup()">';
                            echo "Xin chào " . htmlspecialchars($_SESSION['ho_va_ten']) . ", bạn muốn chia sẻ điều gì?";
                            echo '</button>';
                        } else {
                            echo '<button id="post-btn1" onclick="togglePopup()">Hôm nay bạn thế nào!!!</button>';
                        }
                        ?>
                    </div>

                    <?php
                    if ($error_message) {
                        echo "<div class='error-message'>" . $error_message . "</div>";
                    }

                    // Hiển thị kết quả tìm kiếm
                    if (isset($results) && !empty($results)) {
                        foreach ($results as $result) {
                            $date = DateTime::createFromFormat('Y-m-d', $result['date'])->format('d/m/yy');
                            $time = DateTime::createFromFormat('H:i:s', $result['time'])->format('H:i');
                            echo '<div class="post-item">';
                            echo '<div class="post-header">';
                            echo '<p class="post-user">' . htmlspecialchars($result['ho_va_ten']) . '</p>';
                            echo '<p class="post-time">' . $date . ' lúc ' . $time . '</p>';
                            echo '</div>';
                            echo '<h3>' . htmlspecialchars($result['title']) . '</h3>';
                            echo '<p>' . nl2br(htmlspecialchars($result['content'])) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo "<div class='no-results'>Không có bài viết nào phù hợp với tìm kiếm của bạn.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
