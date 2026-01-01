<?php
// (極重要) 啟用 Session，必須放在最頂端
session_start();

// 檢查使用者是否已登入
// 如果 $_SESSION['loggedin'] 不存在或不是 true，就強制轉跳回登入頁面
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.html');
    exit;
}

// (!!!) 修正點 (!!!)
// 1. 先定義權限檢查函數
function is_manager_or_above($position) {
    // 根據您先前定義的職等
    $allowed_ranks = [
        '部長',
        '協理',
        '副總經理',
        '總經理',
        '董事長'
    ];
    return in_array($position, $allowed_ranks);
}

// (!!!) 修正點 (!!!)
// 2. 先從 Session 中取出所有資料
// (使用 htmlspecialchars 避免 XSS 攻擊)
$full_name = htmlspecialchars($_SESSION['full_name']);
$department = htmlspecialchars($_SESSION['department']);
$position = htmlspecialchars($_SESSION['position']); // <- 必須先在這裡定義
$employee_id = htmlspecialchars($_SESSION['employee_id']);

// (!!!) 修正點 (!!!)
// 3. 在取得 $position 之後，才進行權限檢查
$is_manager = is_manager_or_above($position);

// 如果程式能執行到這裡，代表使用者已經登入
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>員工後台</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        .header { background-color: #333; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { margin: 0; font-size: 1.5rem; }
        .header a { color: #fff; background-color: #dc3545; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px; }
        .header a:hover { background-color: #c82333; }
        .content { max-width: 900px; margin: 2rem auto; padding: 2rem; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .profile { border-bottom: 2px solid #f0f0f0; padding-bottom: 1rem; }
        .profile h2 { color: #007bff; }
        .profile p { font-size: 1.1rem; line-height: 1.6; }
        .profile strong { color: #333; min-width: 100px; display: inline-block; }
        .functions-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1.5rem; }
        .function-box { background-color: #f4f4f4; border: 1px solid #ddd; padding: 1.5rem; border-radius: 8px; text-align: center; }
        .function-box h4 { margin-top: 0; color: #0056b3; }
        .function-box p { font-size: 0.9rem; color: #555; }
        .function-box a { text-decoration: none; background-color: #007bff; color: white; padding: 0.5rem 1rem; border-radius: 4px; display: inline-block; margin-top: 1rem; }
        .function-box a:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <div class="header">
        <h1>公司內部系統</h1>
        <a href="logout.php">登出</a>
    </div>

    <div class="content">
        <div class="profile">
            <h2>歡迎，<?php echo $full_name; ?> (<?php echo $position; ?>)！</h2>
            </div>
        
        <div class="main-functions">
            <h3>系統功能</h3>
            
            <div class="functions-grid">
                <div class="function-box">
                    <h4>個人資料</h4>
                    <p>查看或編輯您的個人聯絡資訊。</p>
                    <a href="#">查看 (尚未實作)</a>
                </div>

                <?php if ($is_manager): ?>
                <div class="function-box">
                    <h4>文件簽核系統</h4>
                    <p>提出新提案，或簽核待審批的文件。</p>
                    <a href="approval_system.php">進入系統</a>
                </div>
                <?php endif; ?>
                
                <div class="function-box">
                    <h4>公告欄</h4>
                    <p>查看最新的公司內部公告。</p>
                    <a href="#">查看 (尚未實作)</a>
                </div>
            </div>

        </div>
    </div>

</body>
</html>