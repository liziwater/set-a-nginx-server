<?php
// 此檔案名: index.php 或 dashboard.php (假設您在主頁面)
include 'db.php'; // 確保資料庫連線正常
session_start();

// 檢查是否已登入，若無則跳轉
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$employee_id = $user['employee_id'];

// 取得最新的使用者資料
try {
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE employee_id = ?");
    $stmt->execute([$employee_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        // 如果找不到使用者，強制登出
        session_destroy();
        header("Location: login.php");
        exit;
    }
} catch (PDOException $e) {
    // 處理資料庫錯誤，此處簡化為顯示錯誤
    die("資料庫錯誤: " . $e->getMessage());
}


// 更新 session
$_SESSION['user'] = $user;

// --- 邏輯計算 ---
// 職級名稱對應
$levels = [1 => '工讀生', 2 => '副專員', 3 => '專員', 4 => '高級專員', 5 => '經理', 6 => '部長', 7 => '協理', 8 => '副總經理', 9 => '總經理', 10 => '董事長', 0 => '法人'];

// 計算在職天數
$hire_date = new DateTime($user['hire_date']);
$today = new DateTime();
$days_worked = $today->diff($hire_date)->days;

// 薪資計算
$base_salary_per_day = 0.01;
$bonus_rate_per_100_days = 0.01;

$base_salary = $days_worked * $base_salary_per_day;
$bonus_rate_multiplier = floor($days_worked / 100);
$bonus_rate = $bonus_rate_multiplier * $bonus_rate_per_100_days; // e.g., 200天 -> 2 * 0.01 = 0.02 (2%)
$bonus = $base_salary * $bonus_rate;
$total_salary = $base_salary + $bonus;

// 距離下次加薪
$days_to_next_bonus = 100 - ($days_worked % 100);
if ($days_to_next_bonus == 100) $days_to_next_bonus = 0; // 剛好滿100天時，設為0或下一個100天

// 計算未來薪資預測（接下來365天，每30天一筆）
$salary_projection = [];
$projection_data_points = 12; // 預測一年12期
$salary_projection[] = [
    'days' => $days_worked,
    'base' => $base_salary,
    'bonus' => $bonus,
    'total' => $total_salary
]; // 加入目前資料點
for ($i = 1; $i <= $projection_data_points; $i++) {
    $future_days = $days_worked + ($i * 30);
    $future_base = $future_days * $base_salary_per_day;
    $future_bonus_rate_multiplier = floor($future_days / 100);
    $future_bonus_rate = $future_bonus_rate_multiplier * $bonus_rate_per_100_days;
    $future_bonus = $future_base * $future_bonus_rate;
    $future_total = $future_base + $future_bonus;
    $salary_projection[] = [
        'days' => $future_days,
        'base' => $future_base,
        'bonus' => $future_bonus,
        'total' => $future_total
    ];
}

// 取得各職級的所有員工
$stmt = $pdo->prepare("SELECT level, name, employee_id, email, phone, hire_date FROM employees WHERE is_active = 1 ORDER BY level DESC, name ASC");
$stmt->execute();
$allEmployees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 按職級分組
$employeesByLevel = [];
foreach ($allEmployees as $emp) {
    $employeesByLevel[$emp['level']][] = $emp;
}

// 處理登出
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// 為了讓 JavaScript 容易處理，將員工資料轉換為 JSON 格式
$employeesJson = json_encode($employeesByLevel);

?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>誠訊職員系統 - 儀表板</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzL4A0xOQ5k1z/vjQ8rJp+p2K4p/fQ9dG9H5R/cR4t/M1H1Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5Ff5F5WfQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* 新增/修改 CSS */
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #1e3a8a;
            --background-color: #f5f5f5;
            --card-background: white;
            --text-color: #333;
            --light-border: #e8e8e8;
            --shadow-light: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Microsoft JhengHei", "微軟正黑體", Arial, sans-serif;
            background: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        /* 頂部標題列 */
        .header {
            background: var(--primary-color);
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .site-title {
            font-size: 20px;
            font-weight: bold;
        }

        .user-bar {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-name {
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* 主容器 (儀表板佈局) */
        .container {
            max-width: 1300px;
            margin: 20px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr; /* Default to single column */
            gap: 20px;
        }
        
        @media (min-width: 992px) {
            .container {
                grid-template-columns: 1fr 2fr; /* Desktop layout: 1/3 (Profile/Nav) and 2/3 (Content) */
            }
            .main-content {
                grid-column: 2 / 3;
            }
            .sidebar {
                grid-column: 1 / 2;
                grid-row: 1 / 3; /* Sidebar spans across the first two rows */
            }
        }

        /* 側邊欄 (Sidebar) */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        /* 一般卡片樣式 */
        .card {
            background: var(--card-background);
            border-radius: 8px;
            box-shadow: var(--shadow-light);
            padding: 20px;
            border: 1px solid var(--light-border);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid var(--light-border);
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: bold;
            color: var(--primary-color);
        }

        /* 個人資料卡片 */
        .profile-card {
            padding: 30px;
            border-left: 5px solid var(--primary-color);
        }

        .profile-name {
            font-size: 28px;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        
        .profile-title {
            font-size: 16px;
            color: #666;
            margin-bottom: 15px;
        }

        .profile-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-size: 14px;
            color: #666;
            margin-top: 15px;
        }

        .profile-details span strong {
            color: var(--secondary-color);
            min-width: 70px;
            display: inline-block;
        }
        
        /* 快速統計面板 */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .stat-box {
            text-align: center;
            padding: 15px 10px;
            background: #f9f9f9;
            border-radius: 6px;
            border-left: 3px solid var(--primary-color);
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 3px;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
        }
        
        /* 主要內容區 (Main Content) */
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        /* 快速功能面板 (Quick Access) */
        .quick-access-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }
        
        .quick-access-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: #e8f4f8; /* 淺藍色背景 */
            border-radius: 8px;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: bold;
            transition: background 0.2s, transform 0.2s;
            border: 1px solid #c2e0e9;
        }
        
        .quick-access-item:hover {
            background: #d4eaf1;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .quick-access-icon {
            font-size: 30px;
            margin-bottom: 10px;
        }
        
        /* 薪資區塊 (Salary) */
        .salary-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: var(--background-color);
            border-radius: 6px;
            border: 1px solid var(--light-border);
            margin-bottom: 15px;
        }

        .salary-label {
            font-size: 14px;
            color: #666;
        }

        .salary-amount {
            font-size: 32px;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .salary-breakdown {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .breakdown-item {
            padding: 15px;
            background: #f9f9f9;
            border-radius: 4px;
            border: 1px solid var(--light-border);
        }

        .breakdown-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
        }

        .breakdown-value {
            font-size: 18px;
            font-weight: bold;
            color: var(--text-color);
        }

        .breakdown-note {
            font-size: 11px;
            color: #999;
            margin-top: 5px;
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 15px;
        }

        .salary-info {
            padding: 15px;
            background: #f0f0f0;
            border-radius: 4px;
            font-size: 12px;
            color: #666;
            line-height: 1.8;
        }
        
        /* 職務資訊表格 */
        .info-table th {
            width: 40%;
            background: #f0f0f0;
        }

        /* 組織架構圖 */
        .org-chart-container {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .org-level {
            text-align: center;
            margin-bottom: 15px;
        }

        .org-box {
            padding: 12px 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            min-width: 180px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            display: inline-block;
        }

        .org-box:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .org-box.current {
            background: #dff0d8; /* 突顯目前職位 */
            border: 2px solid #5cb85c;
            box-shadow: 0 0 15px rgba(92, 184, 92, 0.3);
        }

        .org-level-title {
            font-size: 16px;
            font-weight: bold;
            color: var(--text-color);
        }

        .org-level-num {
            font-size: 11px;
            color: #999;
        }

        .org-employee-count {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .count-badge {
            background: var(--primary-color);
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: normal;
        }

        .org-arrow {
            font-size: 20px;
            color: #aaa;
            margin: 5px 0;
        }
        
        /* 員工列表彈窗 (Modal) - 沿用並優化 */
        .employee-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .employee-modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            max-width: 650px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            position: sticky; /* 標題固定 */
            top: 0;
            z-index: 10;
        }
        
        .modal-body {
            padding: 10px 20px 20px;
        }
        
        .employee-item {
            padding: 12px;
            margin-top: 10px;
            border: 1px solid var(--light-border);
            border-radius: 4px;
            transition: all 0.2s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .employee-item:hover {
            background: #f0f0f0;
            border-left: 5px solid var(--primary-color);
        }
        
        .employee-item.current-user {
            background: #e8f4f8;
            border-left: 5px solid var(--secondary-color);
        }
        
        .emp-details {
            display: flex;
            flex-direction: column;
        }

        .emp-name {
            font-size: 16px;
            font-weight: bold;
            color: var(--text-color);
        }
        
        .emp-info {
            font-size: 13px;
            color: #666;
        }
        
        .emp-id-date {
            text-align: right;
            font-size: 12px;
            color: #999;
        }
        
        /* 摺疊功能 - 移除，採用卡片分區更直覺 */
        /* 您原始碼中的摺疊功能已移除，若需要請自行還原 */
        
        /* 頁尾 */
        .footer {
            margin-top: 20px;
            text-align: center;
            padding: 15px 0;
            color: #666;
            font-size: 12px;
            border-top: 1px solid var(--light-border);
        }

        /* 響應式調整 */
        @media (max-width: 991px) {
            .container {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
             .header-content {
                flex-direction: column;
                gap: 10px;
                text-align: center;
             }
             .user-bar {
                gap: 10px;
             }
             .site-title {
                font-size: 18px;
             }
             .profile-card {
                padding: 20px;
             }
             .stats-grid {
                grid-template-columns: repeat(2, 1fr);
             }
             .salary-breakdown {
                grid-template-columns: 1fr;
             }
             .quick-access-grid {
                grid-template-columns: repeat(2, 1fr);
             }
             .employee-item {
                flex-direction: column;
                align-items: flex-start;
             }
             .emp-id-date {
                text-align: left;
                margin-top: 5px;
             }
        }
    </style>
</head>
<body>

<div class="header">
    <div class="header-content">
        <div class="site-title"><i class="fas fa-building"></i> 誠訊科技股份有限公司 - 職員管理系統</div>
        <div class="user-bar">
            <span class="user-name"><i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($user['name']); ?> (Level <?php echo $user['level']; ?>)</span>
            <span class="ip-info" id="ip-info"><i class="fas fa-network-wired"></i> IP: 載入中...</span>
            <a href="?logout=1" class="logout-link" onclick="return confirm('確定要登出嗎？')"><i class="fas fa-sign-out-alt"></i> 登出</a>
        </div>
    </div>
</div>

<div class="container">

    <div class="sidebar">
        <div class="card profile-card">
            <div class="profile-name"><?php echo htmlspecialchars($user['name']); ?></div>
            <div class="profile-title">
                <?php echo $levels[$user['level']] ?? '一般職員'; ?>
                <span class="status <?php echo $user['is_active'] == 1 ? 'status-active' : 'status-inactive'; ?>" style="margin-left: 10px;">
                    <?php echo $user['is_active'] == 1 ? '在職中' : '離職/停用'; ?>
                </span>
            </div>
            
            <hr style="border: 0; border-top: 1px dashed var(--light-border); margin: 15px 0;">

            <div class="profile-details">
                <span><strong>員工編號：</strong><?php echo htmlspecialchars($user['employee_id']); ?></span>
                <span><strong>電子郵件：</strong><?php echo htmlspecialchars($user['email']); ?></span>
                <span><strong>電話號碼：</strong><?php echo htmlspecialchars($user['phone']); ?></span>
                <span><strong>到職日期：</strong><?php echo date('Y年m月d日', strtotime($user['hire_date'])); ?></span>
                <span><strong>在職天數：</strong><?php echo $days_worked; ?> 天</span>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="fas fa-briefcase"></i> 職務與帳號狀態</div>
            <table class="info-table">
                <tr>
                    <th>目前職級</th>
                    <td>Level <?php echo $user['level']; ?> (<?php echo $levels[$user['level']] ?? '一般職員'; ?>)</td>
                </tr>
                <tr>
                    <th>到職年資</th>
                    <td>約 <?php echo round($days_worked / 365, 1); ?> 年</td>
                </tr>
                <tr>
                    <th>帳號狀態</th>
                    <td>
                        <span class="status <?php echo $user['is_active'] == 1 ? 'status-active' : 'status-inactive'; ?>">
                            <?php echo $user['is_active'] == 1 ? '已啟用' : '未啟用'; ?>
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="main-content">
        
        <div class="card">
            <div class="card-header"><i class="fas fa-bolt"></i> 快速功能面板</div>
            <div class="quick-access-grid">
                <a href="javascript:alert('打卡功能開發中')" class="quick-access-item">
                    <i class="fas fa-clock quick-access-icon"></i>
                    <span>出勤打卡</span>
                </a>
                <a href="javascript:alert('薪資查詢功能開發中')" class="quick-access-item">
                    <i class="fas fa-money-check-alt quick-access-icon"></i>
                    <span>薪資查詢</span>
                </a>
                <a href="javascript:alert('請假申請功能開發中')" class="quick-access-item">
                    <i class="fas fa-calendar-alt quick-access-icon"></i>
                    <span>請假申請</span>
                </a>
                <a href="documents.php" class="quick-access-item">
                    <i class="fas fa-file-contract quick-access-icon"></i>
                    <span>文件中心</span>
                </a>
            </div>
        </div>

        <div class="card salary-section">
            <div class="card-header"><i class="fas fa-chart-line"></i> 薪資計算與成長預測</div>
            <div class="salary-content">
                
                <div class="salary-summary">
                    <div>
                        <div class="salary-label">目前累積總薪資</div>
                        <div class="salary-amount">NT$ <?php echo number_format($total_salary, 2); ?></div>
                    </div>
                </div>
                
                <div class="salary-breakdown">
                    <div class="breakdown-item">
                        <div class="breakdown-label">基本薪資總額</div>
                        <div class="breakdown-value">NT$ <?php echo number_format($base_salary, 2); ?></div>
                        <div class="breakdown-note">每天 $<?php echo $base_salary_per_day; ?> × <?php echo $days_worked; ?> 天</div>
                    </div>
                    <div class="breakdown-item">
                        <div class="breakdown-label">績效獎金總額</div>
                        <div class="breakdown-value">NT$ <?php echo number_format($bonus, 2); ?></div>
                        <div class="breakdown-note">獎金率：<?php echo number_format($bonus_rate * 100, 0); ?>%</div>
                    </div>
                    <div class="<?php echo $days_to_next_bonus > 0 ? 'breakdown-item' : 'breakdown-item current-bonus'; ?>">
                        <div class="breakdown-label">距離下次加薪點</div>
                        <div class="breakdown-value"><?php echo $days_to_next_bonus > 0 ? $days_to_next_bonus . ' 天' : '已達成！'; ?></div>
                        <div class="breakdown-note">下次獎金率將提升至 <?php echo number_format(($bonus_rate_multiplier + 1) * 100 * $bonus_rate_per_100_days, 0); ?>%</div>
                    </div>
                </div>
                
                <div class="chart-container">
                    <canvas id="salaryChart"></canvas>
                </div>
                
                <div class="salary-info">
                    <strong>說明：</strong>基本薪資為每日 $<?php echo $base_salary_per_day; ?> 元。每滿 **100 天**，獎金率自動增加 **1%**。圖表為未來一年薪資成長預測。
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="fas fa-sitemap"></i> 組織階層總覽</div>
            <div class="org-chart-container">
                <?php
                $userLevel = $user['level'];
                // 反轉職級順序，由高到低顯示
                $orgLevels = array_reverse($levels, true); 
                
                foreach ($orgLevels as $level => $title) {
                    if ($level == 0) continue; // 排除法人
                    
                    $isCurrent = ($level == $userLevel);
                    $boxClass = $isCurrent ? 'org-box current' : 'org-box';
                    $employeeCount = isset($employeesByLevel[$level]) ? count($employeesByLevel[$level]) : 0;
                    
                    echo '<div class="org-level">';
                    // 新增 onclick 屬性，點擊開啟員工列表
                    echo '<div class="' . $boxClass . '" onclick="showEmployeeModal(' . $level . ', \'' . $title . '\')">';
                    echo '<div class="org-level-num">Level ' . $level . '</div>';
                    echo '<div class="org-level-title">' . $title . '</div>';
                    
                    echo '<div class="org-employee-count">';
                    echo '在職人數 <span class="count-badge">' . $employeeCount . '</span>';
                    if ($isCurrent) {
                        echo ' <span class="current-marker">您</span>';
                    }
                    echo '</div>';
                    
                    echo '</div>';
                    // 只有非最低職級才顯示向下箭頭
                    if ($level > min(array_keys($levels))) {
                        echo '<div class="org-arrow"><i class="fas fa-arrow-down"></i></div>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        
    </div> <div class="footer" style="grid-column: 1 / -1;">
        <div>© 2024 誠訊科技股份有限公司 版權所有 | 系統版本 1.1.0</div>
        <div class="footer-links">
            <a href="javascript:alert('使用說明開發中')">使用說明</a> |
            <a href="javascript:alert('隱私權政策開發中')">隱私權政策</a> |
            <a href="javascript:alert('聯絡我們開發中')">聯絡我們</a>
        </div>
    </div>
</div>

<div id="employeeModal" class="employee-modal">
    <div class="modal-content">
        <div class="modal-header">
            <div id="modalTitle" class="modal-title">職級員工列表</div>
            <button class="modal-close" onclick="closeEmployeeModal()">&times;</button>
        </div>
        <div id="modalBody" class="modal-body">
            </div>
    </div>
</div>

<script>
// PHP 資料轉移到 JavaScript
const salaryData = <?php echo json_encode($salary_projection); ?>;
const allEmployeesData = <?php echo $employeesJson; ?>;
const currentEmployeeId = '<?php echo $user['employee_id']; ?>';
const levelNames = <?php echo json_encode($levels); ?>;

// --- 輔助函式 ---

// 取得 IP 位置資訊
function fetchIpInfo() {
    fetch('https://api.ipify.org?format=json')
        .then(response => response.json())
        .then(data => {
            document.getElementById('ip-info').innerHTML = '<i class="fas fa-network-wired"></i> IP: ' + data.ip;
        })
        .catch(error => {
            document.getElementById('ip-info').innerHTML = '<i class="fas fa-network-wired"></i> IP: 無法取得';
        });
}

// 員工列表彈窗
function showEmployeeModal(level, title) {
    const modal = document.getElementById('employeeModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalBody = document.getElementById('modalBody');
    
    modalTitle.textContent = title + ' (Level ' + level + ') 員工列表';
    modalBody.innerHTML = ''; // 清空內容
    
    const employees = allEmployeesData[level] || [];
    if (employees.length === 0) {
        modalBody.innerHTML = '<p style="text-align: center; color: #999; padding: 20px;">此職級目前沒有在職人員。</p>';
    } else {
        employees.forEach(emp => {
            // 計算員工在職天數
            const hireDate = new Date(emp.hire_date);
            const today = new Date();
            const timeDiff = today.getTime() - hireDate.getTime();
            const daysWorked = Math.floor(timeDiff / (1000 * 3600 * 24));
            
            const isCurrentUser = emp.employee_id === currentEmployeeId;
            const itemClass = 'employee-item' + (isCurrentUser ? ' current-user' : '');
            
            const html = `
                <div class="${itemClass}">
                    <div class="emp-details">
                        <div class="emp-name">${emp.name}${isCurrentUser ? '<span class="current-marker">您</span>' : ''}</div>
                        <div class="emp-info"><strong>E-mail:</strong> ${emp.email}</div>
                        <div class="emp-info"><strong>分機:</strong> ${emp.phone || '無'}</div>
                    </div>
                    <div class="emp-id-date">
                        員工編號: ${emp.employee_id}<br>
                        到職: ${emp.hire_date}<br>
                        在職: ${daysWorked} 天
                    </div>
                </div>
            `;
            modalBody.insertAdjacentHTML('beforeend', html);
        });
    }
    
    modal.classList.add('show');
}

function closeEmployeeModal() {
    document.getElementById('employeeModal').classList.remove('show');
}

// --- 頁面載入時執行 ---
document.addEventListener('DOMContentLoaded', function() {
    // 1. 載入 IP 資訊
    fetchIpInfo();

    // 2. 薪資圖表初始化
    const ctx = document.getElementById('salaryChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: salaryData.map(d => d.days + '天'),
            datasets: [
                {
                    label: '累積總薪資',
                    data: salaryData.map(d => parseFloat(d.total.toFixed(2))),
                    borderColor: 'var(--primary-color)',
                    backgroundColor: 'rgba(44, 90, 160, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: 'var(--primary-color)'
                },
                {
                    label: '基本薪資',
                    data: salaryData.map(d => parseFloat(d.base.toFixed(2))),
                    borderColor: '#999',
                    backgroundColor: 'transparent',
                    borderWidth: 1,
                    fill: false,
                    tension: 0.3,
                    pointRadius: 0,
                    borderDash: [5, 5]
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: '未來一年累積薪資成長預測 (以30天為間隔)',
                    font: { size: 14, family: "'Microsoft JhengHei', Arial" },
                    color: 'var(--text-color)'
                },
                legend: {
                    position: 'top',
                    labels: {
                        font: { family: "'Microsoft JhengHei', Arial" }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += 'NT$ ' + context.parsed.y.toFixed(2);
                            return label;
                        },
                        footer: function(tooltipItems) {
                            const index = tooltipItems[0].dataIndex;
                            const data = salaryData[index];
                            const bonusRateMultiplier = Math.floor(data.days / 100);
                            return [
                                '在職天數: ' + data.days + ' 天',
                                '獎金率: ' + (bonusRateMultiplier * 1) + '%'
                            ];
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: '累積金額 (NT$)', font: { family: "'Microsoft JhengHei', Arial" } },
                    ticks: {
                        callback: function(value) {
                            return 'NT$' + value.toFixed(0);
                        }
                    }
                },
                x: {
                    title: { display: true, text: '在職天數', font: { family: "'Microsoft JhengHei', Arial" } },
                    grid: { display: false }
                }
            }
        }
    });
});
</script>

</body>
</html>