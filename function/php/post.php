<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['masv'], $_SESSION['ho_va_ten']) && !empty($_POST['title']) && !empty($_POST['content'])) {
        $ho_va_ten = $_SESSION['ho_va_ten'];
        $masv = $_SESSION['masv'];
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);

        // Lấy thời gian từ API
        $currentDateTime = get_time_from_api();
        $date = $currentDateTime->format('Y-m-d');
        $time = $currentDateTime->format('H:i:s');

        // Xác định bảng cần chèn bài viết
        $table = isset($_POST['type']) && $_POST['type'] === 'gopy' ? 'gopypost' : 'diendanpost';

        // Tạo câu lệnh SQL
        $sql = "INSERT INTO $table (ho_va_ten, masv, title, content, date, time) VALUES (:ho_va_ten, :masv, :title, :content, :date, :time)";
        $stmt = $pdo_diendan->prepare($sql);

        try {
            $stmt->execute([
                ':ho_va_ten' => $ho_va_ten,
                ':masv' => $masv,
                ':title' => $title,
                ':content' => $content,
                ':date' => $date,
                ':time' => $time
            ]);
            $_SESSION['message'] = ($table === 'gopypost') ? "Góp ý đã được đăng thành công!" : "Bài viết đã được đăng thành công!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Lỗi khi đăng bài viết: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin và đăng nhập!";
    }

    header("Location: ../../home.php");
    exit();
}
?>
