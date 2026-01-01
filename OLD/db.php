<?php
// --- 請修改為您自己的資料庫設定 ---
$db_host = 'localhost'; // 資料庫主機
$db_name = 'chengxunemployee';  // 資料庫名稱
$db_user = 'lizi';      // 資料庫使用者名稱
$db_pass = '123';          // 資料庫使用者密碼
// ---------------------------------

$charset = 'utf8mb4';
$dsn = "mysql:host=$db_host;dbname=$db_name;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (\PDOException $e) {
    // 在生產環境中，不應顯示詳細錯誤訊息
    error_log($e->getMessage());
    die("資料庫連線失敗，請聯繫系統管理員。");
}
?>
