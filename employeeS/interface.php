<?php
session_start();
require 'db.php';

// 1. 安全檢查
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = '';

// ==========================================
// NEW: 處理個性簽名 (Slogan) 更新
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['slogan'])) {
    $newSlogan = trim($_POST['slogan']);
    // 限制字數，避免過長 (例如 50 字)
    if (mb_strlen($newSlogan) > 50) {
        $message = "個性簽名過長，請限制在 50 字以內。";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE users SET slogan = ? WHERE id = ?");
            $stmt->execute([$newSlogan, $_SESSION['user_id']]);
            $message = "個性簽名更新成功！";
        } catch (PDOException $e) {
            $message = "系統錯誤：" . $e->getMessage();
        }
    }
}

// ==========================================
// 處理大頭貼上傳
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['new_avatar'])) {
    $file = $_FILES['new_avatar'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (in_array($file['type'], $allowedTypes)) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newFileName = time() . '_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                try {
                    $update = $pdo->prepare("UPDATE users SET avatar_path = ? WHERE id = ?");
                    $update->execute([$targetPath, $_SESSION['user_id']]);
                    $_SESSION['avatar'] = $targetPath;
                    $message = "大頭貼更新成功！";
                } catch (PDOException $e) {
                    $message = "系統錯誤：" . $e->getMessage();
                }
            } else {
                $message = "檔案上傳失敗。";
            }
        } else {
            $message = "檔案格式不支援。";
        }
    }
}

// ==========================================
// 讀取資料
// ==========================================
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    if (!$user) { header("Location: logout.php"); exit; }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// 權限變數
$isAdmin = in_array($user['position'], ['法人', '總經理', '董事長']);
$isManager = in_array($user['position'], ['部長', '協理', '副總經理', '總經理', '董事長']);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>員工中心 | 誠訊工作室</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* 專業配色：企業藍與中性灰 */
            --primary: #2563eb;       /* 核心藍色 */
            --primary-dark: #1e40af;
            --secondary: #64748b;     /* 次要文字 */
            --bg-body: #f1f5f9;       /* 整體背景 (淺灰藍) */
            --bg-sidebar: #1e293b;    /* 側邊欄 (深色) */
            --bg-card: #ffffff;       /* 卡片背景 */
            --text-main: #0f172a;     /* 主要文字 */
            --text-light: #94a3b8;    /* 淺色文字 (用於深底) */
            --border: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --radius: 12px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* 暗黑模式變數 */
        .dark-mode {
            --bg-body: #0f172a;
            --bg-sidebar: #1e293b; 
            --bg-card: #1e293b;
            --text-main: #f8fafc;
            --text-light: #cbd5e1;
            --border: #334155;
            --secondary: #94a3b8;
        }

        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Inter', 'Microsoft JhengHei', sans-serif; background-color: var(--bg-body); color: var(--text-main); display: flex; min-height: 100vh; transition: 0.3s; }
        a { text-decoration: none; color: inherit; }

        /* ============================
           側邊欄 (Sidebar)
           ============================ */
        .sidebar {
            width: 260px;
            background-color: var(--bg-sidebar);
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0; top: 0;
            z-index: 100;
            transition: 0.3s;
        }
        
        .brand { padding: 25px; font-size: 1.5rem; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); letter-spacing: 1px; display: flex; align-items: center; gap: 10px; }
        .brand i { color: var(--primary); }

        .menu { list-style: none; padding: 20px 10px; margin: 0; flex: 1; }
        .menu li { margin-bottom: 5px; }
        .menu a { display: flex; align-items: center; padding: 12px 15px; border-radius: 8px; color: var(--text-light); transition: 0.2s; font-size: 0.95rem; }
        .menu a:hover, .menu a.active { background-color: rgba(255,255,255,0.1); color: white; }
        .menu a i { width: 25px; margin-right: 10px; text-align: center; }

        .sidebar-footer { padding: 20px; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-mini { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .user-mini img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary); }
        .user-mini div { display: flex; flex-direction: column; }
        .user-mini .name { font-size: 0.9rem; font-weight: 600; color: white; }
        .user-mini .role { font-size: 0.75rem; color: var(--text-light); }

        /* ============================
           主內容區 (Main Content)
           ============================ */
        .main-content {
            flex: 1;
            margin-left: 260px; /* 留出側邊欄寬度 */
            padding: 30px;
            transition: 0.3s;
        }

        /* 頂部工具列 */
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-title { font-size: 1.5rem; font-weight: 700; color: var(--text-main); }
        
        .actions { display: flex; gap: 15px; }
        .icon-btn { 
            width: 40px; height: 40px; border-radius: 50%; border: 1px solid var(--border); 
            background: var(--bg-card); color: var(--text-main); 
            display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; 
        }
        .icon-btn:hover { background: var(--border); }

        /* ============================
           儀表板網格 (Dashboard Grid)
           ============================ */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 350px 1fr; /* 左邊員工證，右邊資訊 */
            gap: 25px;
        }

        /* 1. 數位員工證卡片 (Digital ID) */
        .id-card-wrapper {
            background: var(--bg-card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 30px;
            text-align: center;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }
        /* 裝飾背景圓 */
        .bg-circle { position: absolute; width: 200px; height: 200px; background: var(--primary); opacity: 0.1; border-radius: 50%; top: -80px; left: -50px; }
        
        .avatar-lg { 
            width: 140px; height: 140px; border-radius: 50%; object-fit: cover; 
            border: 4px solid var(--bg-card); box-shadow: 0 8px 16px rgba(0,0,0,0.1); 
            margin-bottom: 15px; position: relative; z-index: 2;
        }
        
        .badge { 
            display: inline-block; padding: 5px 12px; border-radius: 20px; 
            font-size: 0.8rem; font-weight: 600; background: rgba(37, 99, 235, 0.1); color: var(--primary); margin-bottom: 10px; 
        }
        
        .emp-name { font-size: 1.5rem; font-weight: 700; margin-bottom: 5px; }
        .emp-id { color: var(--secondary); font-size: 0.9rem; margin-bottom: 15px; font-family: monospace; letter-spacing: 1px; }

        /* NEW: 個性簽名樣式 */
        .slogan-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            margin-bottom: 20px;
            padding: 0 10px;
        }
        .slogan-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--border);
            color: var(--secondary);
            font-size: 0.9rem;
            text-align: center;
            padding: 5px;
            outline: none;
            transition: 0.2s;
            font-family: inherit;
        }
        .slogan-input:focus {
            border-bottom-color: var(--primary);
            color: var(--text-main);
        }
        .slogan-btn {
            background: transparent;
            border: none;
            color: var(--primary);
            cursor: pointer;
            padding: 5px;
            font-size: 1rem;
            opacity: 0.6;
            transition: 0.2s;
        }
        .slogan-btn:hover { opacity: 1; transform: scale(1.1); }


        .upload-trigger {
            background: var(--bg-body); color: var(--secondary); padding: 8px 16px; 
            border-radius: 6px; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s;
        }
        .upload-trigger:hover { background: var(--border); color: var(--text-main); }

        /* 2. 資訊面板 (Info Panel) */
        .info-panel {
            display: flex; flex-direction: column; gap: 20px;
        }

        .card {
            background: var(--bg-card); border-radius: var(--radius);
            padding: 25px; box-shadow: var(--shadow); border: 1px solid var(--border);
        }
        
        .section-header { font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 10px; }
        .section-header i { color: var(--primary); }

        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .info-item label { display: block; font-size: 0.8rem; color: var(--secondary); margin-bottom: 5px; }
        .info-item span { font-size: 1rem; font-weight: 500; color: var(--text-main); }

        /* 3. 快速功能區 (Quick Actions) */
        .action-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 15px; margin-top: 5px;
        }
        .action-tile {
            background: var(--bg-card); padding: 20px; border-radius: var(--radius);
            border: 1px solid var(--border); text-align: center; transition: 0.2s;
            display: flex; flex-direction: column; align-items: center; justify-content: center; height: 120px;
            box-shadow: var(--shadow);
        }
        .action-tile:hover { transform: translateY(-3px); border-color: var(--primary); }
        .action-tile i { font-size: 2rem; margin-bottom: 10px; color: var(--primary); }
        .action-tile.danger i { color: var(--danger); }
        .action-tile.warning i { color: var(--warning); }
        .action-tile span { font-weight: 600; font-size: 0.9rem; }

        /* 訊息提示 */
        .alert-box { padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: 500; }
        .success { background: rgba(16, 185, 129, 0.2); color: var(--success); border: 1px solid var(--success); }
        .error { background: rgba(239, 68, 68, 0.2); color: var(--danger); border: 1px solid var(--danger); }

        /* RWD */
        @media (max-width: 900px) {
            .dashboard-grid { grid-template-columns: 1fr; }
            .info-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 260px; }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; }
            #menu-toggle { display: flex !important; }
        }
    </style>
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <i class="fas fa-layer-group"></i> 誠訊工作室
        </div>
        
        <ul class="menu">
            <li><a href="#" class="active"><i class="fas fa-id-badge"></i> 個人中心</a></li>
            <li><a href="contract_my_list.php"><i class="fas fa-file-contract"></i> 我的文件</a></li>
            <?php if ($isManager): ?>
                <li><a href="contract_approval.php"><i class="fas fa-stamp"></i> 待簽核匣</a></li>
            <?php endif; ?>
            <li><a href="#"><i class="fas fa-calendar-check"></i> 出勤紀錄</a></li>
            <li><a href="#"><i class="fas fa-search-dollar"></i> 薪資查詢</a></li>
        </ul>

        <div class="sidebar-footer">
            <div class="user-mini">
                <?php $avatarMini = !empty($user['avatar_path']) ? $user['avatar_path'] : 'uploads/default.png'; ?>
                <img src="<?php echo htmlspecialchars($avatarMini); ?>?v=<?php echo time(); ?>" alt="Avatar">
                <div>
                    <span class="name"><?php echo htmlspecialchars($user['username']); ?></span>
                    <span class="role"><?php echo htmlspecialchars($user['position']); ?></span>
                </div>
            </div>
            <a href="logout.php" style="color: var(--text-light); font-size: 0.85rem; display: block; margin-top: 10px;">
                <i class="fas fa-sign-out-alt"></i> 登出系統
            </a>
        </div>
    </aside>

    <main class="main-content">
        
        <header class="top-bar">
            <div style="display: flex; align-items: center; gap: 15px;">
                <button class="icon-btn" id="menu-toggle" style="display: none;"><i class="fas fa-bars"></i></button>
                <div class="page-title">員工資料中心</div>
            </div>
            
            <div class="actions">
                <button class="icon-btn" id="theme-toggle" title="切換模式"><i class="fas fa-moon"></i></button>
                <?php if ($isAdmin): ?>
                    <a href="admin.php" class="icon-btn" title="後台管理" style="background: var(--warning); color: #fff; border:none;">
                        <i class="fas fa-cog"></i>
                    </a>
                <?php endif; ?>
            </div>
        </header>

        <?php if ($message): ?>
            <div class="alert-box <?php echo strpos($message, '成功') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-grid">
            
            <div class="left-col">
                <div class="id-card-wrapper">
                    <div class="bg-circle"></div>
                    
                    <?php $avatarShow = !empty($user['avatar_path']) ? $user['avatar_path'] : 'uploads/default.png'; ?>
                    <img src="<?php echo htmlspecialchars($avatarShow); ?>?v=<?php echo time(); ?>" class="avatar-lg" alt="Avatar">
                    
                    <div>
                        <span class="badge"><?php echo htmlspecialchars($user['department'] ?? '未分配'); ?></span>
                    </div>
                    <div class="emp-name"><?php echo htmlspecialchars($user['username']); ?></div>
                    <div class="emp-id">ID: <?php echo htmlspecialchars($user['emp_id'] ?? $user['user_code'] ?? '-----'); ?></div>

                    <form action="" method="POST" class="slogan-group">
                        <input type="text" name="slogan" class="slogan-input" 
                               value="<?php echo htmlspecialchars($user['slogan'] ?? ''); ?>" 
                               placeholder="寫點什麼..." maxlength="50">
                        <button type="submit" class="slogan-btn" title="儲存簽名"><i class="fas fa-save"></i></button>
                    </form>

                    <form action="interface.php" method="POST" enctype="multipart/form-data" id="avatarForm">
                        <input type="file" name="new_avatar" id="fileInput" style="display: none;" accept="image/*" onchange="document.getElementById('avatarForm').submit();">
                        <div class="upload-trigger" onclick="document.getElementById('fileInput').click();">
                            <i class="fas fa-camera"></i> 更換照片
                        </div>
                    </form>
                </div>

                <div class="card" style="margin-top: 25px;">
                    <div class="section-header" style="font-size: 1rem; border:none; margin-bottom: 10px;">
                        <i class="fas fa-chart-pie"></i> 本月概況
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem;">
                        <span style="color: var(--secondary);">出勤天數</span>
                        <span style="font-weight: bold;">20 天</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-top: 10px;">
                        <span style="color: var(--secondary);">遲到/早退</span>
                        <span style="font-weight: bold; color: var(--success);">0 次</span>
                    </div>
                </div>
            </div>

            <div class="info-panel">
                
                <div class="card">
                    <div class="section-header"><i class="fas fa-user-circle"></i> 人員檔案詳情</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>職位名稱</label>
                            <span><?php echo htmlspecialchars($user['position']); ?></span>
                        </div>
                        <div class="info-item">
                            <label>入職日期</label>
                            <span><?php echo htmlspecialchars($user['arrival_date'] ?? '未設定'); ?></span>
                        </div>
                        <div class="info-item">
                            <label>電子郵件</label>
                            <span><?php echo htmlspecialchars($user['email']); ?></span>
                        </div>
                        <div class="info-item">
                            <label>聯絡電話</label>
                            <span><?php echo htmlspecialchars($user['phone']); ?></span>
                        </div>
                        <div class="info-item">
                            <label>生日</label>
                            <span><?php echo htmlspecialchars($user['birthday']); ?></span>
                        </div>
                        <div class="info-item">
                            <label>帳號狀態</label>
                            <span style="color: var(--success);"><i class="fas fa-check-circle"></i> 在職中</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="section-header"><i class="fas fa-rocket"></i> 快速功能入口</div>
                    <div class="action-grid">
                        <a href="contract_my_list.php" class="action-tile">
                            <i class="fas fa-file-signature"></i>
                            <span>我的簽核</span>
                        </a>
                        
                        <?php if ($isManager): ?>
                        <a href="contract_approval.php" class="action-tile warning">
                            <i class="fas fa-pen-fancy"></i>
                            <span>主管簽核</span>
                        </a>
                        <?php endif; ?>

                        <?php if ($isAdmin): ?>
                        <a href="admin.php" class="action-tile danger">
                            <i class="fas fa-cogs"></i>
                            <span>系統後台</span>
                        </a>
                        <?php endif; ?>
                        
                        <div class="action-tile" style="opacity: 0.5; cursor: not-allowed;">
                            <i class="fas fa-print"></i>
                            <span>薪資單列印</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <script>
        // 1. 手機版選單切換
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });

        // 點擊主內容區時，如果是手機版，自動收合選單
        document.querySelector('.main-content').addEventListener('click', () => {
            if (window.innerWidth <= 768 && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // 2. 暗黑模式 (支援 LocalStorage 記憶)
        const themeBtn = document.getElementById('theme-toggle');
        const themeIcon = themeBtn.querySelector('i');
        const body = document.body;

        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            body.classList.add('dark-mode');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
        }

        themeBtn.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            } else {
                localStorage.setItem('theme', 'light');
                themeIcon.classList.replace('fa-sun', 'fa-moon');
            }
        });
    </script>
</body>
</html>
