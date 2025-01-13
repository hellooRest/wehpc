<?php
session_start();

// Kết nối tới DB lưu trữ thông tin tài khoản
$host_account = 'localhost';
$dbname_account = 'wehpc';
$username_account = 'root';
$password_account = '';

// Kết nối tới DB lưu trữ bài viết
$host_diendan = 'localhost';
$dbname_diendan = 'diendan';
$username_diendan = 'root';
$password_diendan = '';

try {
    // Kết nối tới database "account"
    $pdo_account = new PDO("mysql:host=$host_account;dbname=$dbname_account", $username_account, $password_account);
    $pdo_account->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Kết nối tới database "diendan"
    $pdo_diendan = new PDO("mysql:host=$host_diendan;dbname=$dbname_diendan", $username_diendan, $password_diendan);
    $pdo_diendan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối tới cơ sở dữ liệu thất bại: " . $e->getMessage());
}

$base_url = 'http://wehpc.com/';
?>
