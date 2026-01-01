<?php
$servername = "localhost";
$username = "lizi";
$password = "123";
$dbname = "employee_system";

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線
if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}
?>
