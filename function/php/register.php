<?php
include('config.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Khởi tạo session lưu lỗi và dữ liệu form đăng ký
    $_SESSION['register_error'] = [];
    $_SESSION['register_data'] = $_POST;

    $masv = $_POST['masv'] ?? '';
    $ho_va_ten = $_POST['ho_va_ten'] ?? '';
    $mk = $_POST['mk'] ?? '';
    $gmail = $_POST['gmail'] ?? '';

    // Kiểm tra các trường nhập vào
    if (empty($masv)) {
        $_SESSION['register_error']['masv'] = 'Vui lòng nhập mã sinh viên.';
    } elseif (strlen($masv) !== 10) {
        $_SESSION['register_error']['masv'] = 'Mã sinh viên phải có đúng 10 ký tự.';
    }

    if (empty($ho_va_ten)) {
        $_SESSION['register_error']['ho_va_ten'] = 'Vui lòng nhập họ và tên.';
    } elseif (!preg_match("/^[a-zA-ZÀ-ỹ\s]+$/u", $ho_va_ten)) {
        $_SESSION['register_error']['ho_va_ten'] = 'Họ và tên chỉ được chứa chữ và khoảng trắng.';
    }

    if (empty($mk)) {
        $_SESSION['register_error']['mk'] = 'Vui lòng nhập mật khẩu.';
    } elseif (strlen($mk) < 8) {
        $_SESSION['register_error']['mk'] = 'Mật khẩu phải có ít nhất 8 ký tự.';
    }

    if (empty($gmail)) {
        $_SESSION['register_error']['gmail'] = 'Vui lòng nhập Gmail.';
    }


    // Nếu không có lỗi trong quá trình kiểm tra, thực hiện đăng ký
    if (empty($_SESSION['register_error'])) {
        // Kiểm tra mã sinh viên đã tồn tại
        $stmt = $pdo_diendan->prepare("SELECT * FROM account WHERE masv = :masv");
        $stmt->execute(['masv' => $masv]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['register_error']['masv'] = 'Mã sinh viên đã tồn tại.';
        } else {
            // Thêm tài khoản mới vào cơ sở dữ liệu
            $stmt = $pdo_diendan->prepare("
                INSERT INTO account (masv, ho_va_ten, mk, gmail) 
                VALUES (:masv, :ho_va_ten, :mk, :gmail)
            ");
            $stmt->execute([
                'masv' => $masv,
                'ho_va_ten' => $ho_va_ten,
                'mk' => $mk,  // Lưu mật khẩu thẳng (không mã hóa mật khẩu ở đây vì yêu cầu)
                'gmail' => $gmail,
            ]);

            // Lấy thông tin người dùng vừa đăng ký
            $stmt = $pdo_diendan->prepare("SELECT * FROM account WHERE masv = :masv");
            $stmt->execute(['masv' => $masv]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Lưu thông tin người dùng vào session
            $_SESSION['message'] = 'Đăng ký thành công!';
            $_SESSION['masv'] = $user['masv'];
            $_SESSION['ho_va_ten'] = $user['ho_va_ten'];
            $_SESSION['role'] = $user['role'];

            // Xóa dữ liệu lỗi và form đăng ký sau khi đăng ký thành công
            unset($_SESSION['register_error'], $_SESSION['register_data']); 
            
            // Chuyển hướng về trang chủ sau khi đăng ký thành công
            header("Location: " . $base_url);
            exit();
        }
    }

    // Chuyển hướng về lại trang home với popup mở ở tab đăng ký
    header("Location: " . $base_url . "?popup=register");
    exit();
}
?>
