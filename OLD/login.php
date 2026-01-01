<?php
include 'db.php';
session_start();

// 錯誤訊息變數
$error_message = '';

// 1. 如果已經登入，直接導向
if (isset($_SESSION['user'])) {
    header("Location: dashboardTEST.php");
    exit;
}

// 2. 處理登入請求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account = trim($_POST['account']);
    $password = trim($_POST['password']);
    $input_captcha = trim($_POST['captcha']);

    // --- 驗證碼檢查邏輯 (由後端 Session 驗證) ---
    // 若要啟用，請取消下方註解
    /*
    if (!isset($_SESSION['login_captcha']) || strtolower($input_captcha) !== strtolower($_SESSION['login_captcha'])) {
        $error_message = '驗證碼錯誤，請重新輸入';
    }
    */

    // 只有在沒有錯誤時才繼續檢查帳號密碼
    if (empty($error_message)) {
        try {
            // 支援 Email / 電話 / 員工編號
            $stmt = $pdo->prepare("SELECT * FROM employees WHERE email=? OR phone=? OR employee_id=? LIMIT 1");
            $stmt->execute([$account, $account, $account]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // A. 登入成功：更換 Session ID (防止 Session Fixation 攻擊)
                session_regenerate_id(true);
                $_SESSION['user'] = $user;

                // B. 背景執行 Python (非阻塞模式)
                // 這樣網頁不會因為寄信而卡住
                $email = escapeshellarg($user['email']);
                $name = escapeshellarg($user['name']);      
                $employee_id = escapeshellarg($user['employee_id']);
                
                $cmd = "python send_safeemail.py $email $name $employee_id";
                
                // 判斷作業系統，決定背景執行指令
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    // Windows: 使用 start /B 
                    pclose(popen("start /B " . $cmd, "r")); 
                } else {
                    // Linux/Mac: 使用 > /dev/null 2>&1 &
                    exec($cmd . " > /dev/null 2>&1 &");
                }

                header("Location: dashboardTEST.php");
                exit;
            } else {
                $error_message = '帳號或密碼錯誤';
            }
        } catch (PDOException $e) {
            // 隱藏詳細資料庫錯誤，只顯示通用訊息
            error_log($e->getMessage()); // 記錄到伺服器日誌
            $error_message = '系統忙碌中，請稍後再試';
        }
    }
}

// 3. 產生新的驗證碼 (每次載入頁面都更新，供前端顯示)
// 這裡簡單產生5碼隨機字串
$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$captcha_code = substr(str_shuffle($chars), 0, 5);
$_SESSION['login_captcha'] = $captcha_code;
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>誠訊職員登入系統</title>
<style>
/* 基礎設定 - 保持您喜歡的 Apple/微軟潔淨風格 */
body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Microsoft JhengHei", Roboto, sans-serif;
    height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); /* 更柔和的商務藍灰調 */
    display: flex;
    justify_content: center;
    align-items: center;
}

form {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px); /* 毛玻璃特效 */
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    width: 360px;
    max-width: 90%;
    animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

h2 {
    text-align: center;
    margin: 0 0 10px 0;
    color: #1d1d1f;
    font-weight: 600;
}

p.subtitle {
    text-align: center;
    font-size: 13px;
    color: #86868b;
    margin-bottom: 25px;
}

/* 輸入框樣式優化 */
.input-group {
    margin-bottom: 15px;
}

input {
    width: 100%;
    box-sizing: border-box;
    padding: 14px;
    border-radius: 10px;
    border: 1px solid #d2d2d7;
    font-size: 15px;
    background: #fff;
    transition: all 0.2s ease;
}

input:focus {
    border-color: #0071e3;
    box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.2); /* Apple 風格 Focus */
    outline: none;
}

/* 按鈕樣式 */
button[type="submit"] {
    width: 100%;
    padding: 14px;
    margin-top: 10px;
    background: #0071e3;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

button[type="submit"]:hover {
    background: #005bb5;
    transform: scale(1.01);
}

button:disabled {
    background: #9caab9;
    cursor: wait;
    transform: none;
}

/* 驗證碼區域 */
.captcha-container {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.captcha-display {
    flex: 1;
    background: #f0f2f5;
    color: #333;
    font-family: "Courier New", monospace;
    font-size: 22px;
    font-weight: bold;
    letter-spacing: 4px;
    text-align: center;
    padding: 10px;
    border-radius: 8px;
    user-select: none;
    border: 1px dashed #ccc;
    text-decoration: line-through; /* 增加干擾線效果 */
}

/* 錯誤訊息提示框 */
.alert-box {
    background-color: #fff2f2;
    border-left: 4px solid #ff3b30;
    color: #cc2d2d;
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 6px;
    font-size: 14px;
    display: flex;
    align-items: center;
}

@media (max-width: 480px) {
    form { padding: 30px 20px; }
}
</style>
</head>
<body>

<form method="POST" onsubmit="return handleLogin(this)">
    <h2>誠訊職員登入</h2>
    <p class="subtitle">請使用員工編號、Email 或電話登入</p>

    <?php if (!empty($error_message)): ?>
        <div class="alert-box">
            ⚠️ <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>

    <div class="input-group">
        <input type="text" name="account" placeholder="帳號" required value="<?= isset($_POST['account']) ? htmlspecialchars($_POST['account']) : '' ?>">
    </div>
    
    <div class="input-group">
        <input type="password" name="password" placeholder="密碼" required>
    </div>

    <div class="captcha-container">
        <div class="captcha-display" title="驗證碼"><?= $captcha_code ?></div>
        <input type="text" name="captcha" placeholder="輸入驗證碼" style="flex: 1.5;" autocomplete="off">
    </div>

    <button type="submit" id="loginBtn">立即登入</button>
</form>

<script>
function handleLogin(form) {
    const btn = document.getElementById('loginBtn');
    
    // 簡單的前端檢查
    const account = form.account.value.trim();
    const password = form.password.value.trim();
    
    if(!account || !password) {
        return false;
    }

    // 變更按鈕狀態
    btn.innerHTML = '<span>↻</span> 驗證中...';
    btn.disabled = true;
    btn.style.opacity = "0.8";

    return true; // 允許表單提交
}

// 如果是後端返回錯誤重整頁面，這段 JS 可以讓游標自動聚焦在密碼欄位（體驗更好）
<?php if (!empty($error_message)): ?>
    document.querySelector('input[name="password"]').focus();
<?php endif; ?>
</script>

</body>
</html>