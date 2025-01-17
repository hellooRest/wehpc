<?php
// search.php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = $_POST['search'] ?? '';
    $activeSection = $_POST['active_section'] ?? 'diendan'; // Mặc định là 'diendan'

    // Loại bỏ khoảng trắng thừa
    $searchTerm = trim($searchTerm);

    if (empty($searchTerm)) {
        // Nếu không có từ khóa tìm kiếm, xóa session search_term và search_ids, hiển thị lại tất cả bài viết
        unset($_SESSION['search_ids']);
        $_SESSION['search_term'] = '';  // Xóa từ khóa tìm kiếm
        header("Location: ../../home.php");  // Quay lại trang chính
        exit();
    }

    try {
        // Chọn bảng phù hợp dựa trên section
        $tableName = ($activeSection === 'gopy') ? 'gopypost' : 'diendanpost';

        // Tìm kiếm bài viết phù hợp
        $sql = "
            SELECT id 
            FROM {$tableName} 
            WHERE title LIKE :search OR content LIKE :search
        ";
        $stmt = $pdo_diendan->prepare($sql);
        $stmt->execute([':search' => '%' . $searchTerm . '%']);
        $matchingPosts = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Lưu giá trị tìm kiếm và danh sách bài viết vào session
        $_SESSION['search_ids'] = $matchingPosts ?: [];  // Đảm bảo không để null
        $_SESSION['search_term'] = $searchTerm;  // Lưu từ khóa tìm kiếm vào session

        header("Location: ../../home.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Lỗi khi tìm kiếm: " . $e->getMessage();
        header("Location: ../../home.php");
        exit();
    }
}
?>
