<?php
// --- 開啟錯誤報告 ---
// 這些程式碼會強制顯示所有 PHP 錯誤，方便找出問題
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// --------------------

session_start();
include 'db.php';

// 檢查資料庫連線物件是否存在
if (!isset($pdo)) {
    die("<h3>錯誤</h3><p>資料庫連線物件 (\$pdo) 未被建立。</p><p>請確認 <strong>db.php</strong> 檔案存在，且內部的資料庫連線設定是正確的。</p>");
}

// 檢查使用者是否登入，若未登入則導向到登入頁面
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$message = '';
$message_type = ''; // 'success' or 'error'

// 處理表單提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $assignee_id = $_POST['assignee_id'] ?? '';

    if (!empty($title) && !empty($content) && !empty($assignee_id)) {
        try {
            // 將新文件插入資料庫，狀態預設為 'pending'
            $stmt = $pdo->prepare("INSERT INTO documents (title, content, assigned_to_id) VALUES (?, ?, ?)");
            $stmt->execute([$title, $content, $assignee_id]);
            
            $message = '文件提案已成功送出！';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = '提案失敗，資料庫發生錯誤。';
            $message_type = 'error';
            // 顯示詳細錯誤訊息（僅供偵錯用）
            $message .= '<br><small>' . $e->getMessage() . '</small>';
        }
    } else {
        $message = '標題、內容與指派對象皆不可為空。';
        $message_type = 'error';
    }
}


// 獲取所有員工列表以供指派
try {
    $stmt_employees = $pdo->query("SELECT id, name, employee_id FROM employees ORDER BY name ASC");
    $employees = $stmt_employees->fetchAll();
} catch (PDOException $e) {
    // 如果查詢失敗，則終止程式並顯示錯誤
    die("<h3>錯誤</h3><p>無法從 'employees' 資料表獲取員工列表。</p><p>請確認資料表存在且結構正確。</p><p>詳細錯誤訊息: " . $e->getMessage() . "</p>");
}


?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>新增文件提案 - 文件簽核系統</title>
<style>
    body {
        font-family: "微軟正黑體", sans-serif;
        background-color: #f4f7f6;
        margin: 0;
        padding: 20px;
    }
    .container {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    .header h1 {
        margin: 0;
        font-size: 24px;
        color: #333;
    }
    .header a {
        background: #555;
        color: white;
        text-decoration: none;
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 14px;
        transition: background 0.3s;
    }
    .header a:hover {
        background: #333;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }
    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        box-sizing: border-box;
        font-family: "微軟正黑體", sans-serif;
    }
    .form-group textarea {
        height: 150px;
        resize: vertical;
    }
    .submit-btn {
        background: #28a745;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .submit-btn:hover {
        background: #218838;
    }
    .message {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
        text-align: center;
    }
    .message.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .message.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>新增文件提案</h1>
        <a href="dashboard.php">返回主控台</a>
    </div>

    <?php if ($message): ?>
    <div class="message <?php echo $message_type; ?>">
        <?php echo $message; // 直接輸出，因為錯誤訊息可能包含HTML ?>
    </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="title">文件標題</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="content">文件內容</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <div class="form-group">
            <label for="assignee_id">指派簽核對象</label>
            <select id="assignee_id" name="assignee_id" required>
                <option value="">-- 請選擇指派對象 --</option>
                <?php foreach ($employees as $employee): ?>
                    <option value="<?php echo $employee['id']; ?>">
                        <?php echo htmlspecialchars($employee['name']) . ' (' . htmlspecialchars($employee['employee_id']) . ')'; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="submit-btn">送出提案</button>
    </form>
</div>

</body>
</html>

