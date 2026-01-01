<?php
$host = 'localhost';  // 你的MariaDB主機名稱
$dbname = 'company';
$username = 'lizi';   // 資料庫使用者名稱
$password = '123';       // 資料庫密碼

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
