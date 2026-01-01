<?php
// 資料庫設定 (請依照您的開發環境修改)
$host = 'localhost';      // 主機位置，通常是 localhost
$db   = 'system_db';      // 資料庫名稱 (對應剛才建立的 SQL)
$user = 'lizi';           // 資料庫帳號 (XAMPP 預設為 root)
$pass = '123';               // 資料庫密碼 (XAMPP 預設為空)
$charset = 'utf8mb4';     // 字元編碼 (支援 Emoji)

// 設定 DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// 設定 PDO 選項
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // 發生錯誤時拋出異常
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // 預設將資料回傳為關聯陣列
    PDO::ATTR_EMULATE_PREPARES   => false,                  // 禁用模擬預處理 (增加安全性)
];

try {
    // 建立連線
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // 如果需要測試連線是否成功，可以暫時取消下面這行的註解，測試完請務必註解回去
    // echo "資料庫連線成功！";

} catch (\PDOException $e) {
    // 連線失敗時顯示錯誤訊息 (正式上線建議隱藏詳細錯誤，改寫入 Log)
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>


