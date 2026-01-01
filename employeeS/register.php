<?php
// 開啟錯誤顯示 (除錯用)
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php'; // 引入資料庫連線

$message = ''; // 訊息提示變數
$msg_type = ''; // 訊息類型 (success/error)

// 檢查是否有表單送出
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $birthday = $_POST['birthday'];

    // 1. 處理自動編號 (格式: YYYYMMDDxxx)
    try {
        $datePrefix = date("Ymd");
        
        $sql_code = "SELECT user_code FROM users WHERE user_code LIKE ? ORDER BY user_code DESC LIMIT 1";
        $stmt_code = $pdo->prepare($sql_code);
        $stmt_code->execute([$datePrefix . '%']);
        $lastCode = $stmt_code->fetchColumn();

        if ($lastCode) {
            $sequence = intval(substr($lastCode, -3)) + 1;
        } else {
            $sequence = 1;
        }

        $new_user_code = $datePrefix . str_pad($sequence, 3, "0", STR_PAD_LEFT);

        // 2. 處理檔案上傳 (大頭貼)
        $avatar_path = 'uploads/default.png'; // 預設圖片
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $fileName = time() . '_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
                $avatar_path = $targetPath;
            }
        }

        // 3. 檢查帳號是否重複
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ? OR phone = ?");
        $check->execute([$email, $phone]);
        if ($check->rowCount() > 0) {
            $message = "⚠️ 錯誤：Email 或電話號碼已被註冊！";
            $msg_type = "error";
        } else {
            // 4. 寫入資料庫
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (user_code, username, phone, email, password, birthday, avatar_path) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute([$new_user_code, $username, $phone, $email, $hashed_password, $birthday, $avatar_path])) {
                
                // ==========================================
                // 🚀 新增功能：呼叫 Python 發送歡迎信
                // ==========================================
                $py_email = escapeshellarg($email);
                $py_name = escapeshellarg($username);
                $py_code = escapeshellarg($new_user_code);
                
                // 自動抓取當前目錄下的 send_register.py
                $scriptPath = __DIR__ . '/send_register.py';
                
                if (file_exists($scriptPath)) {
                    // Linux 背景執行指令
                    exec("python3 $scriptPath $py_email $py_name $py_code > /dev/null 2>&1 &");
                } else {
                    error_log("找不到註冊通知腳本: $scriptPath");
                }
                // ==========================================

                $message = "🎉 註冊成功！<br>歡迎信已發送至您的信箱。<br>您的員工編號為：<strong>$new_user_code</strong>";
                $msg_type = "success";
            } else {
                $message = "❌ 註冊失敗，請稍後再試。";
                $msg_type = "error";
            }
        }

    } catch (PDOException $e) {
        $message = "資料庫錯誤：" . $e->getMessage();
        $msg_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>誠訊工作室 - 員工註冊</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Noto Sans TC', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .main-container {
            background: white;
            width: 1000px;
            min-height: 600px;
            display: flex;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .left-side {
            flex: 1;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 40px;
            text-align: center;
        }
        .left-side h2 { font-size: 32px; margin-bottom: 15px; }
        .left-side p { font-size: 16px; opacity: 0.9; line-height: 1.6; }
        .right-side {
            flex: 1.2;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .form-header { text-align: center; margin-bottom: 30px; }
        .form-header h1 { color: #333; font-size: 24px; margin-bottom: 5px; }
        .form-header p { color: #888; font-size: 14px; margin: 0; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .form-group { margin-bottom: 5px; }
        .form-group.full-width { grid-column: span 2; }
        label { display: block; margin-bottom: 8px; color: #555; font-size: 14px; font-weight: 500; }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"], input[type="file"] {
            width: 100%; padding: 12px 15px; border: 2px solid #e1e1e1; border-radius: 8px; font-size: 15px; transition: all 0.3s; background-color: #f9f9f9; font-family: 'Noto Sans TC', sans-serif;
        }
        input[type="file"] { padding: 9px; background: white; }
        input:focus { border-color: #4a90e2; background-color: #fff; outline: none; box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1); }
        .btn-submit {
            grid-column: span 2; width: 100%; padding: 14px; background: linear-gradient(135deg, #28a745 0%, #218838 100%); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; margin-top: 20px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3); }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 25px; font-size: 14px; line-height: 1.5; animation: fadeIn 0.5s ease; }
        .alert.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .success-link { display: inline-block; margin-top: 10px; padding: 8px 15px; background-color: #155724; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .footer-links { grid-column: span 2; text-align: center; margin-top: 20px; font-size: 14px; }
        .footer-links a { color: #4a90e2; text-decoration: none; font-weight: 500; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 768px) {
            .main-container { flex-direction: column; width: 100%; height: auto; }
            .left-side { padding: 30px; }
            .right-side { padding: 30px 20px; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full-width { grid-column: span 1; }
            .btn-submit, .footer-links { grid-column: span 1; }
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="left-side">
        <h2>Join Our Team</h2>
        <p>歡迎加入誠訊工作室。<br>請填寫您的資料以建立員工檔案，<br>讓我們一起創造價值。</p>
    </div>

    <div class="right-side">
        <div class="form-header">
            <h1>建立新帳號</h1>
            <p>請填寫以下資訊完成註冊</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert <?php echo $msg_type; ?>">
                <?php echo $message; ?>
                <?php if ($msg_type == 'success'): ?>
                    <br><a href="login.php" class="success-link">前往登入頁面</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($msg_type) || $msg_type == 'error'): ?>
        <form action="register.php" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group">
                    <label>真實姓名</label>
                    <input type="text" name="username" placeholder="王小明" required>
                </div>
                
                <div class="form-group">
                    <label>手機號碼</label>
                    <input type="text" name="phone" placeholder="0912345678" required>
                </div>

                <div class="form-group full-width">
                    <label>電子郵件 (將作為登入帳號)</label>
                    <input type="email" name="email" placeholder="example@email.com" required>
                </div>

                <div class="form-group full-width">
                    <label>設定密碼</label>
                    <input type="password" name="password" placeholder="至少 6 位數" required>
                </div>

                <div class="form-group">
                    <label>生日</label>
                    <input type="date" name="birthday" required>
                </div>

                <div class="form-group">
                    <label>上傳大頭貼</label>
                    <input type="file" name="avatar" accept="image/*">
                </div>

                <button type="submit" class="btn-submit">立即註冊</button>
                
                <div class="footer-links">
                    已經有帳號了嗎？ <a href="login.php">直接登入</a>
                </div>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>