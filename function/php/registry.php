<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $masv = $_POST['masv'];
    $ho_va_ten = $_POST['ho_va_ten'];
    $mk = $_POST['mk'];
    $gmail = $_POST['gmail'];

    $stmt = $pdo->prepare("SELECT * FROM account WHERE masv = :masv");
    $stmt->execute(['masv' => $masv]);

    if ($stmt->rowCount() > 0) 
    {
        echo "Mã Sinh Viên đã được dùng để đăng kí tài khoản";
    } 
    else 
    {
            $stmt = $pdo->prepare("INSERT INTO account (masv,ho_va_ten, mk, gmail) VALUES (:masv, :ho_va_ten, :mk, :gmail)");
            $stmt->execute([
                'masv' => $masv,
                'ho_va_ten' => $ho_va_ten,
                'mk' => $mk,
                'gmail' => $gmail
            ]);

            echo "Đăng ký thành công!";
    }
}
?>
