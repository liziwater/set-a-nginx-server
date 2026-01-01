<?php
/*
 * 檔案：reset_password.php
 * 說明：驗證權杖，並顯示重設密碼的表單
 */

include 'db_config.php';

$token = $_GET['token'];
$error_message = "";
$show_form = false;

if (empty($token)) {
    $error_message = "無效的權杖。";
} else {
    // 1. (安全性) 檢查權杖是否有效，且尚未過期 (NOW() 是 SQL 的現在時間)
    $stmt = $conn->prepare("SELECT id FROM employees WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // 權杖有效，顯示表單
        $show_form = true;
    } else {
        $error_message = "無效或已過期的權杖。請重新申請。";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>設定新密碼</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { background-color: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .container h2 { text-align: center; color: #333; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #555; font-weight: bold; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { width: 100%; padding: 0.75rem; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; font-weight: bold; }
        .btn:hover { background-color: #0056b3; }
        .message.error { background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>設定您的新密碼</h2>
        
        <?php if ($show_form): ?>
            <form action="update_password.php" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                
                <div class="form-group">
                    <label for="new_password">新密碼</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">確認新密碼</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn">更新密碼</button>
            </form>
        <?php else: ?>
            <div class="message error"><?php echo $error_message; ?></div>
            <div style="text-align:center; margin-top: 1rem;">
                <a href="forgot_password.html">返回忘記密碼頁面</a>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>