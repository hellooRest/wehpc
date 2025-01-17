<?php
    session_start();
$host = 'localhost';
$dbname = 'wehpc';  // Cập nhật lại tên cơ sở dữ liệu
$username = 'root';
$password = '';

try 
{
    // Kết nối tới database "wehpc"
    $pdo_diendan = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo_diendan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Kết nối tới cơ sở dữ liệu thất bại: " . $e->getMessage());
}

$base_url = 'http://wehpc.com/'; 

function get_time_from_api() 
{
    $url = "http://worldtimeapi.org/api/timezone/Etc/UTC"; // Timezone chuẩn UTC
    $timeout = 5; // Thời gian tối đa cho phép kết nối (giây)
    $ch = curl_init();

    // Thiết lập cURL, nếu không kết nối được sever thì lấy dữ liệu từ người dùng//
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

    $response = curl_exec($ch);
    $curlError = curl_errno($ch); // Kiểm tra lỗi từ cURL
    curl_close($ch);

    if ($response && !$curlError) 
    {
        $data = json_decode($response, true);
        if (isset($data['datetime'])) {
            // Định dạng thời gian từ API: 2025-01-15T12:45:00.000Z
            return new DateTime($data['datetime'], new DateTimeZone('UTC'));
        }
    }

    // Trường hợp không kết nối được, trả về thời gian hệ thống với múi giờ Asia/Ho_Chi_Minh
    return new DateTime("now", new DateTimeZone('Asia/Ho_Chi_Minh'));
}

?>