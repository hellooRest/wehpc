    <?php
    session_start();
    session_unset(); 
    session_destroy(); 

    if (isset($_COOKIE[session_name()])) 
    {
        setcookie(session_name(), '', time() - 3600, '/');
    }

    // Xóa giá trị tìm kiếm nếu được lưu trữ trong cookie
    if (isset($_COOKIE['search_temp'])) {
        setcookie('search_temp', '', time() - 3600, '/'); // Xóa cookie tìm kiếm
    }
    
    // Xóa giá trị tìm kiếm nếu được lưu trong session
    if (isset($_SESSION['search_temp'])) {
        unset($_SESSION['search_temp']); // Xóa session tìm kiếm
    }

    header("Location: /home.php");
    exit();
    ?>
