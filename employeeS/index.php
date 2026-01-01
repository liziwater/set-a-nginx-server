<?php
session_start();

// 檢查使用者是否已登入
$isLoggedIn = isset($_SESSION['user_id']);
$username = $isLoggedIn ? $_SESSION['username'] : '訪客';
$avatar = $isLoggedIn && !empty($_SESSION['avatar']) ? $_SESSION['avatar'] : 'uploads/default.png';

// 確保圖片路徑正確 (如果圖片在同層級目錄)
if ($isLoggedIn && !file_exists($avatar)) {
    $avatar = 'uploads/default.png'; 
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>誠訊工作室 - 員工專區入口</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Noto Sans TC', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* 動態漸層背景 (延續登入頁風格) */
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            padding: 20px;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .dashboard-container {
            /* 毛玻璃特效 */
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            
            width: 100%;
            max-width: 800px;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* 頂部歡迎區 */
        .header-section {
            background: url('https://images.unsplash.com/photo-1497215728101-856f4ea42174?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80') center/cover;
            padding: 40px;
            text-align: center;
            position: relative;
            color: white;
        }

        .header-section::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.6), rgba(0,0,0,0.8));
        }

        .header-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .user-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid rgba(255,255,255,0.8);
            object-fit: cover;
            margin-bottom: 15px;
            background-color: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .welcome-text h1 { margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 1px; }
        .welcome-text p { margin: 5px 0 0; font-size: 14px; opacity: 0.9; }

        /* 功能選單區 */
        .menu-grid {
            padding: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }

        .menu-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 15px;
            padding: 25px 15px;
            text-align: center;
            text-decoration: none;
            color: #444;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 160px;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border-color: transparent;
        }

        /* 顏色主題 */
        .card-blue:hover { background: linear-gradient(135deg, #e3f2fd, #bbdefb); color: #1565c0; }
        .card-green:hover { background: linear-gradient(135deg, #e8f5e9, #c8e6c9); color: #2e7d32; }
        .card-purple:hover { background: linear-gradient(135deg, #f3e5f5, #e1bee7); color: #6a1b9a; }
        .card-orange:hover { background: linear-gradient(135deg, #fff3e0, #ffe0b2); color: #ef6c00; }
        .card-red:hover { background: linear-gradient(135deg, #ffebee, #ffcdd2); color: #c62828; }
        .card-gray:hover { background: linear-gradient(135deg, #f5f5f5, #e0e0e0); color: #333; }

        .icon-box {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: inherit;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
        }

        .card-desc {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }
        
        .menu-card:hover .card-desc { color: inherit; opacity: 0.8; }

        /* 頁尾 */
        .footer {
            text-align: center;
            padding: 20px;
            background: #f9f9f9;
            color: #888;
            font-size: 13px;
            border-top: 1px solid #eee;
        }

        @media (max-width: 600px) {
            .menu-grid { grid-template-columns: repeat(2, 1fr); padding: 20px; gap: 15px; }
            .menu-card { height: 140px; padding: 15px; }
            .icon-box { font-size: 2rem; }
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    
    <div class="header-section">
        <div class="header-content">
            <?php if ($isLoggedIn): ?>
                <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" class="user-avatar" onerror="this.src='https://placehold.co/100?text=User'">
                <div class="welcome-text">
                    <h1>早安，<?php echo htmlspecialchars($username); ?></h1>
                    <p>誠訊工作室員工專區</p>
                </div>
            <?php else: ?>
                <div class="user-avatar" style="display:flex;align-items:center;justify-content:center;font-size:40px;color:#ccc;">
                    <i class="fa-solid fa-user-lock"></i>
                </div>
                <div class="welcome-text">
                    <h1>歡迎來到員工專區</h1>
                    <p>請先登入以存取系統功能</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="menu-grid">
        
        <?php if (!$isLoggedIn): ?>
            <a href="login.php" class="menu-card card-blue">
                <div class="icon-box"><i class="fa-solid fa-right-to-bracket"></i></div>
                <div class="card-title">員工登入</div>
                <div class="card-desc">Login</div>
            </a>

            <a href="register.php" class="menu-card card-green">
                <div class="icon-box"><i class="fa-solid fa-user-plus"></i></div>
                <div class="card-title">註冊帳號</div>
                <div class="card-desc">Register</div>
            </a>
        <?php else: ?>
            <a href="contract_upload.php" class="menu-card card-blue">
                <div class="icon-box"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                <div class="card-title">提交文件</div>
                <div class="card-desc">Upload Docs</div>
            </a>

            <a href="contract_approval.php" class="menu-card card-purple">
                <div class="icon-box"><i class="fa-solid fa-file-signature"></i></div>
                <div class="card-title">簽核文件</div>
                <div class="card-desc">Sign & Approve</div>
            </a>

            <a href="interface.php" class="menu-card card-orange">
                <div class="icon-box"><i class="fa-solid fa-user-gear"></i></div>
                <div class="card-title">個人中心</div>
                <div class="card-desc">Dashboard</div>
            </a>

            <a href="logout.php" class="menu-card card-red" onclick="return confirm('確定要登出嗎？');">
                <div class="icon-box"><i class="fa-solid fa-power-off"></i></div>
                <div class="card-title">安全登出</div>
                <div class="card-desc">Logout</div>
            </a>
        <?php endif; ?>

        <a href="../index.php" class="menu-card card-gray">
            <div class="icon-box"><i class="fa-solid fa-house"></i></div>
            <div class="card-title">回官網首頁</div>
            <div class="card-desc">Back Home</div>
        </a>

    </div>

    <div class="footer">
        &copy; 2025 Chengxun Studio. System by Li Zi Jie.
    </div>

</div>

</body>
</html>