<?php
// --- 🔴 除錯設定 (確認運作正常後可註解掉) ---
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

session_start();
require 'db.php'; 

// ==========================================
// 🔴 設定區：Google reCAPTCHA 金鑰
// ==========================================
$recaptcha_secret = '6LcbfygsAAAAADo16Y-B3MKZmob4JoXO0FOeuqNY'; 
// ==========================================

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account = trim($_POST['account']);
    $password = $_POST['password'];
    $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

    if (empty($account) || empty($password)) {
        $error = "請輸入帳號與密碼";
    } elseif (empty($recaptcha_response)) {
        $error = "請勾選「我不是機器人」";
    } else {
        // --- 1. 驗證機器人 (Linux 建議使用 CURL) ---
        $verify_url = "https://www.google.com/recaptcha/api/siteverify";
        $data = [
            'secret' => $recaptcha_secret,
            'response' => $recaptcha_response
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $verify_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 樹莓派憑證若有問題可忽略
        $verify_response = curl_exec($ch);
        curl_close($ch);

        $response_data = json_decode($verify_response);

        if (!$response_data || !$response_data->success) {
            $error = "機器人驗證失敗，請重新整理頁面。";
        } else {
            // --- 2. 驗證通過，查詢資料庫 ---
            try {
                $sql = "SELECT * FROM users WHERE email = ? OR user_code = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$account, $account]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    // --- 登入成功 ---
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_code'] = $user['user_code'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['avatar'] = $user['avatar_path'];

                    // ==========================================
                    //  Python Email 警告 (樹莓派自動路徑版)
                    // ==========================================
                    $u_email = escapeshellarg($user['email']);
                    $u_name = escapeshellarg($user['username']);
                    
                    $ip = $_SERVER['REMOTE_ADDR'];
                    if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
                    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    $u_ip = escapeshellarg($ip);

                    // ✅ 自動抓取當前目錄，不再依賴 Windows 路徑
                    $scriptPath = __DIR__ . '/send_alert.py';

                    if (file_exists($scriptPath)) {
                        // Linux 背景執行
                        exec("python3 $scriptPath $u_email $u_name $u_ip > /dev/null 2>&1 &");
                    }
                    // ==========================================

                    header("Location: interface.php");
                    exit;
                } else {
                    $error = "帳號或密碼錯誤";
                }
            } catch (PDOException $e) {
                $error = "系統錯誤，請稍後再試";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>誠訊工作室 - 員工登入</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <style>
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Noto Sans TC', sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* ✨ 動態漸層背景 ✨ */
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        /* 背景動畫關鍵影格 */
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .main-container {
            /* ✨ 毛玻璃特效 ✨ */
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px); /* 背景模糊 */
            border: 1px solid rgba(255, 255, 255, 0.5); /* 半透明邊框 */
            
            width: 900px;
            height: 600px;
            display: flex;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); /* 更深的陰影 */
            overflow: hidden;
        }

        .left-side {
            flex: 1;
            /* 圖片來源：辦公室科技感 */
            background: url('https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover no-repeat;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 40px;
            color: white;
        }
        
        .left-side::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            /* 漸層遮罩，讓文字更清楚 */
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 60%);
        }

        .left-text { position: relative; z-index: 2; text-shadow: 0 2px 4px rgba(0,0,0,0.5); }
        .left-text h2 { margin: 0 0 10px 0; font-size: 32px; font-weight: 700; letter-spacing: 1px; }
        .left-text p { margin: 0; font-size: 15px; opacity: 0.95; font-weight: 300; }

        .right-side {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header { text-align: center; margin-bottom: 30px; }
        .login-header h1 { color: #333; font-size: 28px; margin-bottom: 8px; font-weight: 700; }
        .login-header p { color: #666; font-size: 14px; margin: 0; }

        .form-group { margin-bottom: 20px; }
        .form-group label { 
            display: block; margin-bottom: 8px; color: #444; font-size: 14px; font-weight: 600; 
        }
        
        .form-group input {
            width: 100%; 
            padding: 14px 16px; 
            border: 2px solid #eee; 
            border-radius: 10px; 
            font-size: 15px; 
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        
        /* 輸入框互動特效 */
        .form-group input:focus {
            border-color: #4a90e2;
            background-color: #fff;
            outline: none;
            box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.1);
        }

        .recaptcha-container {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
            margin-top: 10px;
        }

        .btn-login {
            width: 100%; 
            padding: 16px; 
            background: linear-gradient(135deg, #4a90e2 0%, #007bff 100%); 
            color: white; 
            border: none; 
            border-radius: 10px; 
            font-size: 16px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
        }
        
        /* 按鈕懸停特效 */
        .btn-login:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
            filter: brightness(1.1);
        }

        .error-banner {
            background-color: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; font-size: 14px; text-align: center; margin-bottom: 20px; border: 1px solid #fecaca;
        }

        .links { margin-top: 30px; text-align: center; font-size: 14px; color: #666; }
        .links a { color: #4a90e2; text-decoration: none; font-weight: 600; transition: color 0.2s; }
        .links a:hover { color: #0056b3; text-decoration: underline; }

        @media (max-width: 768px) {
            .main-container { width: 90%; height: auto; flex-direction: column; }
            .left-side { display: none; }
            .right-side { padding: 40px 25px; }
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="left-side">
        <div class="left-text">
            <h2>Chengxun Studio</h2>
            <p>Empowering Innovation with Technology</p>
        </div>
    </div>

    <div class="right-side">
        <div class="login-header">
            <h1>CHENGXUN登入</h1>
            <p>請輸入您的帳號資訊以繼續</p>
        </div>

        <?php if ($error): ?>
            <div class="error-banner">
                ⚠️ <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="account">帳號 / Email</label>
                <input type="text" id="account" name="account" placeholder="user@example.com" required>
            </div>

            <div class="form-group">
                <label for="password">密碼(123)</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="recaptcha-container">
                <div class="g-recaptcha" data-sitekey="6LcbfygsAAAAAA8r6ti9knuBkizuF2YpM8Sc3Adg"></div>
            </div>

            <button type="submit" class="btn-login">立即登入</button>
        </form>

        <div class="links">
            還沒有帳號？ <a href="register.php">註冊新員工</a>
        </div>
    </div>
</div>

</body>
</html>