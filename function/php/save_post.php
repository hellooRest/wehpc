<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['ho_va_ten']) && !empty($_POST['title']) && !empty($_POST['content'])) {
        $ho_va_ten = $_SESSION['ho_va_ten'];
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $date = date('Y-m-d');
        $time = date('H:i:s');

        $sql = "INSERT INTO post (ho_va_ten, title, content, date, time) VALUES (:ho_va_ten, :title, :content, :date, :time)";
        $stmt = $pdo_diendan->prepare($sql);

        try {
            $stmt->execute([
                ':ho_va_ten' => $ho_va_ten,
                ':title' => $title,
                ':content' => $content,
                ':date' => $date,
                ':time' => $time
            ]);
            $_SESSION['message'] = "Bài viết đã được đăng thành công!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Lỗi khi đăng bài viết: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
    }
    header("Location: ../../home.php");
    exit();
} else {
    header("Location: ../../home.php");
    exit();
}
