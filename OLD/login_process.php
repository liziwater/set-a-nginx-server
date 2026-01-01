<?php
/*
 * 檔案：login_process.php (更新版)
 * 說明：使用 員工編號 或 Email 或 電話 登入
 */

session_start();

include 'db_config.php';

// 1. 獲取表單資料 (欄位名稱改為 "account")
$account = $_POST['account'];
$password = $_POST['password'];

if (empty($account) || empty($password)) {
    header('Location: login.php?error=1'); // 建議將 login.html 改為 login.php
    exit;
}

// 2. (安全性) 修改 SQL 查詢
// 查詢條件改為： 員工編號 = ? OR Email = ? OR 電話號碼 = ?
// 並且帳號狀態必須是 'active'
$stmt = $conn->prepare("
    SELECT id, employee_id, full_name, department, position, password 
    FROM employees 
    WHERE (employee_id = ? OR email = ? OR phone_number = ?) 
      AND status = 'active'
");

// 3. (安全性) 綁定參數
// "sss" 代表三個參數都是字串。我們把 $account 變數傳遞三次
$stmt->bind_param("sss", $account, $account, $account);

$stmt->execute();
$result = $stmt->get_result();

// 4. 驗證使用者是否存在
if ($result->num_rows == 1) {
    // 使用者存在，抓取資料
    $user = $result->fetch_assoc();

    // 5. (極重要) 驗證密碼
    if (password_verify($password, $user['password'])) {
        // 密碼正確！
        
        // 6. 登入成功，將使用者資訊存入 Session
        $_SESSION['loggedin'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['employee_id'] = $user['employee_id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['department'] = $user['department'];
        $_SESSION['position'] = $user['position'];

        // 7. 轉跳到登入後的頁面
        header('Location: dashboard.php');
        exit;

    } else {
        // 密碼錯誤
        header('Location: login.php?error=1');
        exit;
    }
} else {
    // 帳號不存在 (或不符/被停用)
    header('Location: login.php?error=1');
    exit;
}

$stmt->close();
$conn->close();
?>