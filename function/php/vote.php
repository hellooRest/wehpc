<?php
include('config.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $postId = $data['id'] ?? null;
    $action = $data['action'] ?? null;
    $masv = $_SESSION['masv'] ?? null;

    // Ensure session variable is set
    if (!$masv) {
        echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
        exit;
    }

    // Kiểm tra xem đang ở phần diễn đàn hay góp ý
    $isGopy = isset($data['is_gopy']) && $data['is_gopy'] === true;
    $table = $isGopy ? 'gopyvote' : 'diendanvote';

    try {
        $pdo_diendan->beginTransaction();

        // Kiểm tra nếu người dùng đã vote bài viết này
        $stmt = $pdo_diendan->prepare("SELECT vote FROM $table WHERE id = :id AND masv = :masv");
        $stmt->execute([':id' => $postId, ':masv' => $masv]);
        $userVote = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userVote) {
            // Nếu đã vote, xử lý theo hành động
            if ($action === 'remove') {
                // Xóa phiếu bầu
                $stmt = $pdo_diendan->prepare("DELETE FROM $table WHERE id = :id AND masv = :masv");
                $stmt->execute([':id' => $postId, ':masv' => $masv]);
            } elseif ($action === 'upvote' && $userVote['vote'] != 1) {
                // Chuyển sang upvote
                $stmt = $pdo_diendan->prepare("UPDATE $table SET vote = 1 WHERE id = :id AND masv = :masv");
                $stmt->execute([':id' => $postId, ':masv' => $masv]);
            } elseif ($action === 'downvote' && $userVote['vote'] != -1) {
                // Chuyển sang downvote
                $stmt = $pdo_diendan->prepare("UPDATE $table SET vote = -1 WHERE id = :id AND masv = :masv");
                $stmt->execute([':id' => $postId, ':masv' => $masv]);
            }
        } else {
            // Nếu chưa vote, thêm mới
            $voteValue = $action === 'upvote' ? 1 : ($action === 'downvote' ? -1 : 0);

            $stmt = $pdo_diendan->prepare("INSERT INTO $table (id, masv, vote) VALUES (:id, :masv, :vote)");
            $stmt->execute([
                ':id' => $postId,
                ':masv' => $masv,
                ':vote' => $voteValue
            ]);
        }

        // Lấy tổng số vote mới
        $stmt = $pdo_diendan->prepare("
            SELECT 
                SUM(vote) AS total_votes 
            FROM $table
            WHERE id = :id
        ");
        $stmt->execute([':id' => $postId]);
        $votes = $stmt->fetch(PDO::FETCH_ASSOC);

        $pdo_diendan->commit();

        // Trả về dữ liệu JSON
        echo json_encode(
            [
                'success' => true, 
                'total_votes' => $votes['total_votes'] ?? 0, 
                'message' => 'Thay đổi phiếu bầu thành công' 
            ]
        ); 

    } catch (Exception $e) {
        $pdo_diendan->rollBack();
        echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]); 
    }
}
?>