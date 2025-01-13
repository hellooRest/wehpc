<?php
include(__DIR__ . '/config.php');  // Bao gồm config.php với các kết nối PDO đã khởi tạo

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $masv = $_POST['masv'];
    $mk = $_POST['mk'];

    // Sử dụng kết nối PDO từ cơ sở dữ liệu "wehpc" (pdo_account)
    $stmt = $pdo_account->prepare("SELECT * FROM account WHERE masv = :masv");
    $stmt->execute(['masv' => $masv]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $mk === $user['mk']) {
        $_SESSION['masv'] = $user['masv'];
        $_SESSION['ho_va_ten'] = $user['ho_va_ten'];
        $_SESSION['role'] = $user['role'];
        header("Location: " . $base_url);
        exit();
    } else {
        echo "<script>
                alert('Mã Sinh viên hoặc Mật khẩu không chính xác!');
              </script>";
    }
}
?>
