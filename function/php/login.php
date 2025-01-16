<?php
include('config.php'); // Include config.php để sử dụng $pdo_diendan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Khởi tạo session lưu lỗi và dữ liệu form đăng nhập
    $_SESSION['login_error'] = [];
    $_SESSION['login_data'] = $_POST;

    $masv = $_POST['masv'] ?? '';
    $mk = $_POST['mk'] ?? '';

    // Kiểm tra các trường nhập vào
    if (empty($masv)) {
        $_SESSION['login_error']['masv'] = 'Vui lòng nhập mã sinh viên.';
    } elseif (strlen($masv) !== 10) {
        $_SESSION['login_error']['masv'] = 'Mã sinh viên phải có đúng 10 ký tự.';
    }

    if (empty($mk)) {
        $_SESSION['login_error']['mk'] = 'Vui lòng nhập mật khẩu.';
    } elseif (strlen($mk) < 8) {
        $_SESSION['login_error']['mk'] = 'Mật khẩu phải có ít nhất 8 ký tự.';
    }


    // Nếu không có lỗi thì kiểm tra đăng nhập
    if (empty($_SESSION['login_error'])) {
        // Sử dụng kết nối PDO từ config.php
        $stmt = $pdo_diendan->prepare("SELECT * FROM account WHERE masv = :masv");
        $stmt->execute(['masv' => $masv]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra thông tin tài khoản
        if ($user && $mk === $user['mk']) {
            $_SESSION['masv'] = $user['masv'];
            $_SESSION['ho_va_ten'] = $user['ho_va_ten'];
            $_SESSION['role'] = $user['role'];

            // Chuyển hướng về home.php
            header("Location: " . $base_url);
            exit();
        } else {
            $_SESSION['login_error']['general'] = 'Mã Sinh viên hoặc Mật khẩu không chính xác.';
        }
    }

    // Chuyển hướng về lại trang home với popup mở ở tab đăng nhập
    header("Location: " . $base_url . "?popup=login");
    exit();
}
?>
