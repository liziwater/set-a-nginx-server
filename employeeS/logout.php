<?php
// logout.php
session_start();
session_destroy(); // 清除所有 Session
header("Location: login.php"); // 跳轉回登入頁
exit;
?>