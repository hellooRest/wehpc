<?php
session_start();

$host = 'localhost'; 
$dbname = 'diendan';
$username = 'root'; 
$password = '';       

$base_url = 'http://wehpc.com/';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>