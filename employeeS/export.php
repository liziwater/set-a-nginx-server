<?php
session_start();
require 'db.php';

// 1. 權限檢查：只有 法人 或 總經理 可以匯出
if (!isset($_SESSION['user_id'])) { exit; }

$adminId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT position FROM users WHERE id = ?");
$stmt->execute([$adminId]);
$admin = $stmt->fetch();

if (!in_array($admin['position'], ['法人', '總經理'])) {
    die("您沒有權限執行此操作。");
}

// 2. 設定 header 告訴瀏覽器這是一個 CSV 下載檔案
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=員工資料表_' . date('Ymd') . '.csv');

// 3. 開啟輸出串流
$output = fopen('php://output', 'w');

// ★★★ 關鍵：寫入 BOM 表頭，讓 Excel 能正確讀取中文 ★★★
fputs($output, "\xEF\xBB\xBF");

// 4. 設定 CSV 的標題列 (第一行)
fputcsv($output, ['系統ID', '員工編號', '姓名', '部門', '職位', '到職日', '電話', 'Email']);

// 5. 從資料庫抓取所有資料
// 注意：這裡我用 id 排序避免報錯，若您已確認有 user_code 欄位，可改用 user_code 排序
$sql = "SELECT * FROM users ORDER BY id ASC";
$rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    // 處理可能的空值，避免 CSV 跑版
    $emp_id = $row['emp_id'] ?? $row['user_code'] ?? ''; 
    
    // 寫入每一列資料
    fputcsv($output, [
        $row['id'],
        $emp_id,
        $row['username'],
        $row['department'],
        $row['position'],
        $row['arrival_date'],
        $row['phone'],
        $row['email']
    ]);
}

fclose($output);
exit;
?>