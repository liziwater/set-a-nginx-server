<?php
session_start();
require 'db.php';

// 1. 安全檢查：確認已登入
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

// 取得使用者資料
$stmt = $pdo->prepare("SELECT username, position, department FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// 2. 定義職位階層 (由低到高)
$levels = ['部長', '協理', '副總經理', '總經理', '董事長'];
$my_level_index = array_search($user['position'], $levels);

// 3. 處理表單送出
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // --- [A] 檔案上傳處理區塊 ---
    $file_path = ""; // 預設空字串
    
    // 檢查是否有選擇檔案且無錯誤
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/'; // 設定存檔資料夾
        
        // 如果資料夾不存在，自動建立
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // 檔名處理：加上時間戳記防止重複 (例如: 17163055_contract.pdf)
        $file_name = time() . '_' . basename($_FILES['file']['name']);
        $target_file = $upload_dir . $file_name;

        // 移動檔案到伺服器
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            $file_path = $target_file;
        } else {
            echo "<script>alert('檔案上傳失敗，請檢查目錄權限。'); history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('請選擇要上傳的附件檔案。'); history.back();</script>";
        exit;
    }

    // --- [B] 自動簽核與關卡判斷邏輯 ---
    $sign_history = "";
    
    // 迴圈：自動核決自己與下屬層級
    for ($i = 0; $i <= $my_level_index; $i++) {
        $role_name = $levels[$i];
        $timestamp = date("Y-m-d H:i");
        
        if ($i < $my_level_index) {
            $sign_history .= "[$timestamp] $role_name (系統) : 自動核決 (提案人職等較高，依規略過)\n";
        } else {
            $sign_history .= "[$timestamp] $role_name {$user['username']} : 提案送出 (自動核決)\n";
        }
    }

    // 設定下一關
    $next_index = $my_level_index + 1;

    if ($next_index < count($levels)) {
        // 還有上司 -> 送審
        $current_level = $levels[$next_index]; 
        $status = 'pending';
    } else {
        // 我是最大權限 -> 直接結案
        $current_level = '歸檔';
        $status = 'approved';
        $sign_history .= "[" . date("Y-m-d H:i") . "] 系統 : 提案人為最高權限，流程結束。\n";
    }

    // --- [C] 寫入資料庫 ---
    $sql = "INSERT INTO documents 
            (user_id, uploader_name, department, title, description, file_path, current_level, status, sign_history, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_SESSION['user_id'], 
        $user['username'], 
        $user['department'], 
        $title, 
        $description, 
        $file_path,     // 儲存剛才上傳的路徑
        $current_level, 
        $status, 
        $sign_history
    ]);

    echo "<script>alert('提案已送出！'); window.location.href='contract_my_list.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>新增簽核提案</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Microsoft JhengHei', sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .form-container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input[type="text"], textarea, input[type="file"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 1rem; }
        textarea { resize: vertical; height: 100px; }
        
        .btn-submit { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 5px; font-size: 1.1rem; cursor: pointer; transition: 0.3s; }
        .btn-submit:hover { background: #0056b3; }
        .btn-cancel { display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none; }
        
        .info-box { background: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-size: 0.9em; color: #495057; }
    </style>
</head>
<body>

<div class="form-container">
    <h2><i class="fas fa-file-upload"></i> 新增簽核提案</h2>
    
    <div class="info-box">
        提案人：<strong><?php echo htmlspecialchars($user['username']); ?></strong><br>
        目前職位：<strong><?php echo htmlspecialchars($user['position']); ?></strong><br>
        <span style="color: #dc3545; font-size: 0.9em;">
            <i class="fas fa-info-circle"></i> 系統將自動核決您的職位(含)以下的所有層級。
        </span>
    </div>

    <form method="POST" enctype="multipart/form-data">
        
        <div class="form-group">
            <label>文件標題</label>
            <input type="text" name="title" required placeholder="例如：2025年度設備採購案">
        </div>

        <div class="form-group">
            <label>內容說明</label>
            <textarea name="description" required placeholder="請簡述提案目的與內容..."></textarea>
        </div>

        <div class="form-group">
            <label>附件檔案 (PDF / Word / 圖片)</label>
            <input type="file" name="file" required>
            <small style="color:#888;">請上傳相關證明文件或詳細計畫書。</small>
        </div>

        <button type="submit" class="btn-submit">確認送出並開始簽核</button>
        <a href="contract_my_list.php" class="btn-cancel">取消返回</a>
    </form>
</div>

</body>
</html>