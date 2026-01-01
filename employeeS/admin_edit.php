<?php
session_start();
require 'db.php';

// 1. 權限防護網
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$adminId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT position FROM users WHERE id = ?");
$stmt->execute([$adminId]);
$admin = $stmt->fetch();

$allowed_admins = ['法人', '總經理', '董事長'];

if (!in_array($admin['position'], $allowed_admins)) {
    echo "<script>alert('權限不足！'); window.location.href='admin.php';</script>";
    exit;
}

// 2. 處理資料更新
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_id = $_POST['target_id'];
    $new_pos = $_POST['position']; // 職位
    $new_date = $_POST['arrival_date'];

    // 取得部門：如果欄位被鎖定(disabled)，POST會收不到，所以要用 hidden 欄位或後端判斷
    // 這裡我們採用前端 CSS 鎖定 (pointer-events) 的方式，POST 依然會送出值
    $new_dept = $_POST['department']; 

    $sql = "UPDATE users SET department=?, position=?, arrival_date=? WHERE id=?";
    $updateStmt = $pdo->prepare($sql);
    
    if ($updateStmt->execute([$new_dept, $new_pos, $new_date, $target_id])) {
        echo "<script>alert('修改成功！'); window.location.href='admin.php';</script>";
        exit;
    } else {
        echo "<script>alert('修改失敗');</script>";
    }
}

// 3. 讀取目標資料
if (isset($_GET['id'])) {
    $target_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$target_id]);
    $targetUser = $stmt->fetch();
} else {
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>編輯員工資料</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Microsoft JhengHei', sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .edit-box { background: white; padding: 40px; border-radius: 10px; width: 100%; max-width: 450px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        select, input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 16px; background-color: #fff; }
        
        /* 鎖定狀態的樣式 */
        .locked-select {
            background-color: #e9ecef;
            pointer-events: none; /* 禁止點擊 */
            color: #6c757d;
        }

        .btn-submit { width: 100%; background: #007bff; color: white; border: none; padding: 12px; border-radius: 5px; font-size: 16px; cursor: pointer; transition: 0.3s; }
        .btn-submit:hover { background: #0056b3; }
        .btn-cancel { display:block; width: 100%; text-align: center; margin-top: 15px; color: #666; text-decoration: none; }
    </style>
</head>
<body>

<div class="edit-box">
    <h2><i class="fas fa-user-edit"></i> 資料修正</h2>
    
    <div style="background:#f8f9fa; padding:10px; margin-bottom:20px; border-radius:5px; text-align:center;">
        編輯對象：<strong><?php echo htmlspecialchars($targetUser['username']); ?></strong>
    </div>

    <form method="POST">
        <input type="hidden" name="target_id" value="<?php echo $targetUser['id']; ?>">

        <div class="form-group">
            <label>職務職等</label>
            <select name="position" id="roleSelect" required onchange="autoSetDepartment()">
                <option value="" disabled>請選擇職位...</option>
                
                <optgroup label="高階決策層 (自動綁定管理部/董事會)">
              <option value="法人" disabled <?php if($targetUser['position']=='法人') echo 'selected'; ?>>法人 (Lv 0)</option>
                    <option value="董事長" <?php if($targetUser['position']=='董事長') echo 'selected'; ?>>董事長 (Lv 5)</option>
                    <option value="總經理" <?php if($targetUser['position']=='總經理') echo 'selected'; ?>>總經理 (Lv 4)</option>
                    <option value="副總經理" <?php if($targetUser['position']=='行政副總經理') echo 'selected'; ?>>行政副總經理 (Lv 3)</option>
                    <option value="副總經理" <?php if($targetUser['position']=='營業副總經理') echo 'selected'; ?>>營業副總經理 (Lv 3)</option>
                    
                </optgroup>

                <optgroup label="中階主管">
                    <option value="協理" <?php if($targetUser['position']=='協理') echo 'selected'; ?>>協理 (Lv 2)</option>
                    <option value="部長" <?php if($targetUser['position']=='部長') echo 'selected'; ?>>部長 (Lv 1)</option>
                </optgroup>
                
                <optgroup label="一般職員">
                    <option value="專員" <?php if($targetUser['position']=='專員') echo 'selected'; ?>>專員</option>
                    <option value="助理" <?php if($targetUser['position']=='助理') echo 'selected'; ?>>助理</option>
                    <option value="實習生" <?php if($targetUser['position']=='實習生') echo 'selected'; ?>>實習生</option>
                </optgroup>
            </select>
        </div>

        <div class="form-group">
            <label>所屬部門</label>
            <select name="department" id="deptSelect" required>
                <option value="董事會" <?php if($targetUser['department']=='董事會') echo 'selected'; ?>>董事會</option>
                <option value="管理部" <?php if($targetUser['department']=='管理部') echo 'selected'; ?>>管理部 (高層通用)</option>

                <optgroup label="--- 營業群 ---">
                    <option value="專案開發部" <?php if($targetUser['department']=='專案開發部') echo 'selected'; ?>>專案開發部</option>
                    <option value="業務企劃部" <?php if($targetUser['department']=='業務企劃部') echo 'selected'; ?>>業務企劃部</option>
                    <option value="行銷部" <?php if($targetUser['department']=='行銷部') echo 'selected'; ?>>行銷部</option>
                </optgroup>
                <optgroup label="--- 行政群 ---">
                    <option value="財務部" <?php if($targetUser['department']=='財務部') echo 'selected'; ?>>財務部</option>
                    <option value="人資部" <?php if($targetUser['department']=='人資部') echo 'selected'; ?>>人資部</option>
                    <option value="總務部" <?php if($targetUser['department']=='總務部') echo 'selected'; ?>>總務部</option>
                </optgroup>
            </select>
            <div id="deptNote" style="font-size:12px; color:#007bff; display:none; margin-top:5px;">
                <i class="fas fa-info-circle"></i> 高階主管已自動鎖定部門。
            </div>
        </div>

        <div class="form-group">
            <label>到職日期</label>
            <input type="date" name="arrival_date" value="<?php echo htmlspecialchars($targetUser['arrival_date']); ?>" required>
        </div>

        <button type="submit" class="btn-submit">確認儲存</button>
        <a href="admin.php" class="btn-cancel">取消返回</a>
    </form>
</div>

<script>
    function autoSetDepartment() {
        const role = document.getElementById('roleSelect').value;
        const deptSelect = document.getElementById('deptSelect');
        const deptNote = document.getElementById('deptNote');

        // 定義哪些職位是高階主管 (不需要選部門)
        const highLevelRoles = ['總經理', '行政副總', '營業副總', '副總經理'];
        
        // 董事長特別處理 -> 董事會
        if (role === '董事長') {
            deptSelect.value = '董事會';
            lockDepartment(true);
        }
        // 其他高階主管 -> 管理部
        else if (highLevelRoles.includes(role)) {
            deptSelect.value = '管理部';
            lockDepartment(true);
        }
        // 一般員工 -> 解鎖讓使用者自己選
        else {
            lockDepartment(false);
        }
    }

    function lockDepartment(isLocked) {
        const deptSelect = document.getElementById('deptSelect');
        const deptNote = document.getElementById('deptNote');

        if (isLocked) {
            deptSelect.classList.add('locked-select'); // 加上灰色外觀並禁點
            deptNote.style.display = 'block';          // 顯示提示文字
        } else {
            deptSelect.classList.remove('locked-select'); // 回復正常
            deptNote.style.display = 'none';
        }
    }

    // 頁面載入時執行一次，確保狀態正確
    window.onload = autoSetDepartment;
</script>

</body>
</html>