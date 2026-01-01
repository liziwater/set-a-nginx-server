<?php
/*
 * 檔案：db_config.php
 * 說明：資料庫連線設定檔
 */

$servername = "localhost";    // 您的資料庫主機名稱 (通常是 localhost)
$username = "lizi";           // 您的資料庫使用者名稱
$password = "123";               // 您的資料庫密碼
$dbname = "db"; // 您的資料庫名稱

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線
if ($conn->connect_error) {
    die("資料庫連線失敗: " . $conn->connect_error);
}

// 設定連線編碼為 UTF-8
$conn->set_charset("utf8mb4");

?>