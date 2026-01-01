<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>誠訊員工管理系統</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f5f5f5;
            --text-primary: #1a1a1a;
            --text-secondary: #666666;
            --border-color: #d4d4d4;
            --accent-color: #2563eb;
            --accent-hover: #1d4ed8;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        [data-theme="dark"] {
            --bg-primary: #1a1a1a;
            --bg-secondary: #262626;
            --text-primary: #f5f5f5;
            --text-secondary: #a3a3a3;
            --border-color: #404040;
            --accent-color: #3b82f6;
            --accent-hover: #60a5fa;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-hover: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Microsoft JhengHei', sans-serif;
            background: var(--bg-secondary);
            color: var(--text-primary);
            line-height: 1.6;
            transition: background 0.2s, color 0.2s;
        }

        /* 頂部導航 */
        .navbar {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 64px;
        }

        .logo {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: 0.5px;
        }

        .logo i {
            color: var(--accent-color);
            font-size: 20px;
        }

        .theme-toggle {
            background: transparent;
            border: 1px solid var(--border-color);
            padding: 8px 16px;
            cursor: pointer;
            transition: all 0.2s;
            color: var(--text-secondary);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .theme-toggle:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border-color: var(--text-secondary);
        }

        /* 主要內容區 */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 48px 24px;
        }

        .page-header {
            margin-bottom: 48px;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 16px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .page-header p {
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* 功能卡片網格 */
        .function-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
            margin-bottom: 64px;
        }

        .function-card {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            padding: 32px 24px;
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            position: relative;
            overflow: hidden;
        }

        .function-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 0;
            background: var(--accent-color);
            transition: height 0.2s;
        }

        .function-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
            border-color: var(--accent-color);
        }

        .function-card:hover::before {
            height: 100%;
        }

        .function-card i {
            font-size: 32px;
            color: var(--accent-color);
            margin-bottom: 16px;
        }

        .function-card .title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .function-card .desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* 公告區域 */
        .announcement-section {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            padding: 32px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--border-color);
        }

        .section-header i {
            color: var(--accent-color);
            font-size: 22px;
        }

        .section-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .announcement-item {
            padding: 24px 0;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s;
        }

        .announcement-item:last-child {
            border-bottom: none;
        }

        .announcement-item:hover {
            padding-left: 12px;
            background: var(--bg-secondary);
            margin: 0 -12px;
            padding-right: 12px;
        }

        .announcement-item h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .announcement-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 12px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .announcement-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .announcement-meta i {
            color: var(--accent-color);
            font-size: 12px;
        }

        .announcement-content {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        /* 響應式設計 */
        @media (max-width: 768px) {
            .nav-container {
                padding: 0 16px;
            }

            .container {
                padding: 32px 16px;
            }

            .function-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .page-header h1 {
                font-size: 24px;
            }

            .announcement-section {
                padding: 24px 16px;
            }
        }

        /* 滾動條 */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-secondary);
        }
    </style>
</head>
<body data-theme="light">
    <!-- 導航欄 -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">
                <i class="fas fa-building"></i>
                誠訊管理系統
            </a>
            <button class="theme-toggle" onclick="toggleTheme()">
                <i class="fas fa-moon" id="theme-icon"></i>
                <span id="theme-text">深色模式</span>
            </button>
        </div>
    </nav>

    <!-- 主要內容 -->
    <div class="container">
        <div class="page-header">
            <h1>員工快速捷徑</h1>
            <p>選擇下方功能進入對應系統</p>
        </div>

        <!-- 功能卡片 -->
        <div class="function-grid">
            <a href="index.php" class="function-card">
                <i class="fas fa-home"></i>
                <div class="title">系統首頁</div>
                <div class="desc">回到主控制台</div>
            </a>

            <a href="registerTEST.php" class="function-card">
                <i class="fas fa-user-shield"></i>
                <div class="title">員工報到</div>
                <div class="desc">內部管理系統</div>
            </a>

            <a href="upload_document.php" class="function-card">
                <i class="fas fa-file-signature"></i>
                <div class="title">簽核文件</div>
                <div class="desc">命令文件簽核</div>
            </a>

            <a href="manage.php" class="function-card">
                <i class="fas fa-bullhorn"></i>
                <div class="title">發布命令</div>
                <div class="desc">協理以上專用</div>
            </a>

            <a href="manage.php" class="function-card">
                <i class="fas fa-calendar-alt"></i>
                <div class="title">請假系統</div>
                <div class="desc"></div>
            </a>


            <a href="manage.php" class="function-card">
                <i class="fas fa-shopping-cart"></i>
                <div class="title">採購系統</div>
                <div class="desc"></div>
            </a>

            <a href="manage.php" class="function-card">
                <i class="fas fa-user-times"></i>
                <div class="title">離職系統</div>
                <div class="desc"></div>
            </a>
        </div>

        

    <script>
        function toggleTheme() {
            const body = document.body;
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            const currentTheme = body.getAttribute('data-theme');
            
            if (currentTheme === 'light') {
                body.setAttribute('data-theme', 'dark');
                themeIcon.className = 'fas fa-sun';
                themeText.textContent = '淺色模式';
                localStorage.setItem('theme', 'dark');
            } else {
                body.setAttribute('data-theme', 'light');
                themeIcon.className = 'fas fa-moon';
                themeText.textContent = '深色模式';
                localStorage.setItem('theme', 'light');
            }
        }

        function loadTheme() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const body = document.body;
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            
            body.setAttribute('data-theme', savedTheme);
            
            if (savedTheme === 'dark') {
                themeIcon.className = 'fas fa-sun';
                themeText.textContent = '淺色模式';
            }
        }

        document.addEventListener('DOMContentLoaded', loadTheme);
    </script>
</body>
</html>