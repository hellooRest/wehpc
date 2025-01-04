<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $masv = $_POST['masv'];
    $mk = $_POST['mk']; 
    
    $stmt = $pdo->prepare("SELECT * FROM account WHERE masv = :masv");
    $stmt->execute(['masv' => $masv]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($user && $mk === $user['mk']) 
    {
        $_SESSION['user_id'] = $user['masv'];
        $_SESSION['ho_va_ten'] = $user['ho_va_ten'];
        header("Location: home.php");
        exit();
    } else 
    {
        echo "Mã Sinh viên hoặc Mật khẩu không chính xác!";
    }
}
?>
