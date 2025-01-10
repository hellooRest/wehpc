<?php
include(__DIR__ . '/config.php');
session_start(); // Đảm bảo session được khởi tạo

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $masv = $_POST['masv'];
    $ho_va_ten = $_POST['ho_va_ten'];
    $mk = $_POST['mk'];
    $gmail = $_POST['gmail'];

    // Kiểm tra mã sinh viên đã tồn tại chưa
    $stmt = $pdo->prepare("SELECT * FROM account WHERE masv = :masv");
    $stmt->execute(['masv' => $masv]);

    if ($stmt->rowCount() > 0) 
    {
        echo "<script>alert('Mã Sinh Viên đã được dùng để đăng kí tài khoản');</script>";
    } 
    else 
    {
        // Thực hiện đăng ký tài khoản
        $stmt = $pdo->prepare("INSERT INTO account (masv, ho_va_ten, mk, gmail) VALUES (:masv, :ho_va_ten, :mk, :gmail)");
        $stmt->execute([
            'masv' => $masv,
            'ho_va_ten' => $ho_va_ten,
            'mk' => $mk,
            'gmail' => $gmail
        ]);

        // Lưu thông tin vào session sau khi đăng ký thành công
        $_SESSION['masv'] = $masv;
        $_SESSION['ho_va_ten'] = $ho_va_ten;

        // Hiển thị thông báo đăng ký thành công và chuyển hướng
        echo "<script>
                alert('Đăng ký thành công!');
                window.location.href = '" . $base_url . "';
              </script>";
    }
}
?>
