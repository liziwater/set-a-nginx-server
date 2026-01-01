<?php
/*
 * 檔案：update_password.php
 * 說明：最後一步，驗證權杖並更新密碼
 */

include 'db_config.php';

// 1. 獲取表單資料
$token = $_POST['token'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// 2. 驗證
if (empty($token) || empty($new_password) || empty($confirm_password)) {
    die("錯誤：所有欄位皆為必填。");
}

if (strlen($new_password) < 6) {
    die("錯誤：密碼長度至少需要 6 個字元。");
}

if ($new_password !== $confirm_password) {
    die("錯誤：兩次輸入的密碼不一致。");
}

// 3. (極重要) 再次驗證權杖是否有效且未過期
$stmt = $conn->prepare("SELECT id FROM employees WHERE reset_token = ? AND token_expiry > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // 4. 權杖有效，獲取使用者 ID
    $user = $result->fetch_assoc();
    $user_id = $user['id'];

    // 5. (極重要) 加密新密碼
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // 6. (安全性) 更新密碼，並將權杖設為 NULL (使其失效)
    $stmt_update = $conn->prepare("UPDATE employees SET password = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?");
    $stmt_update->bind_param("si", $hashed_password, $user_id);
    
    if ($stmt_update->execute()) {
        // 密碼更新成功
        echo '<html><head><title>成功</title><meta charset="UTF-8">';
        echo '<style>body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 90vh; background-color: #f4f4f4; } .container { background-color: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; } .message.success { background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; } a { color: #007bff; text-decoration: none; margin-top: 1rem; display: inline-block; }</style>';
        echo '</head><body><div class="container">';
        echo '<div class="message success">您的密碼已成功更新！</div>';
        echo '<a href="login.html">點此返回登入頁面</a>';
        echo '</div></body></html>';
    } else {
        die("更新密碼時發生錯誤，請聯繫管理員。");
    }
    $stmt_update->close();

} else {
    die("錯誤：無效或已過期的權杖。");
}

$stmt->close();
$conn->close();

?>