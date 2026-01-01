<?php
/*
 * 檔案：logout.php
 * 說明：登出系統
 */

// 1. 啟用 Session
session_start();

// 2. 清除所有 Session 變數
$_SESSION = array();

// 3. 銷毀 Session
session_destroy();

// 4. 轉跳回登入頁面
header('Location: login.html');
exit;
?>