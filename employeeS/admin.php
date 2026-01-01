<?php
session_start();
require 'db.php';

// ==========================================
// 1. 基礎登入與權限檢查
// ==========================================
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 取得當前登入者資料
$stmt = $pdo->prepare("SELECT position, username FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$currentUser = $stmt->fetch();

// 定義允許進入後台的「高層名單」
$allowed_roles = ['法人', '總經理', '董事長'];

// 嚴格檢查：若職位不符，直接踢回前台
if (!in_array($currentUser['position'], $allowed_roles)) {
    echo "<script>
            alert('權限不足！此區域僅開放給 法人、總經理 與 董事長。');
            window.location.href = 'interface.php';
          </script>";
    exit;
}

// ==========================================
// 2. 讀取員工資料
// ==========================================
// 優化排序：先照「部門」排，再照「職位」排，最後照 ID
// 這樣列表看起來會比較整齊 (同一部門的人會聚在一起)
$sql = "SELECT * FROM users ORDER BY department ASC, id ASC";
$all_users = $pdo->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>企業後台管理系統</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Microsoft JhengHei', sans-serif; background-color: #f0f2f5; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        
        /* 標題區塊樣式 */
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 25px; }
        .header h2 { margin: 0; color: #333; }
        
        /* 表格樣式 */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #343a40; color: white; font-weight: normal; letter-spacing: 1px; }
        tr:hover { background-color: #f8f9fa; transition: 0.2s; }
        
        /* 按鈕樣式 */
        .btn { padding: 8px 15px; border-radius: 5px; text-decoration: none; color: white; font-size: 14px; display: inline-block; transition: 0.3s; border: none; cursor: pointer; }
        .btn:hover { opacity: 0.9; transform: translateY(-1px); }
        
        .btn-edit { background-color: #007bff; }  /* 藍色修改 */
        .btn-excel { background-color: #28a745; } /* 綠色匯出 */
        .btn-back { background-color: #6c757d; }  /* 灰色返回 */
        
        /* 職位標籤 */
        .badge { padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .badge-boss { background: #ffd700; color: #856404; } /* 老闆金 */
        .badge-vp { background: #17a2b8; color: white; }     /* 副總藍 */
        .badge-mgr { background: #e2e6ea; color: #333; }     /* 一般主管灰 */
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-users-cog"></i> 員工資料管理後台</h2>
        
        <div style="display: flex; gap: 10px; align-items: center;">
            <span style="margin-right: 10px; color: #666;">
                <i class="fas fa-user-shield"></i> 管理員：<strong><?php echo htmlspecialchars($currentUser['username']); ?></strong>
            </span>
            
            <a href="export_excel.php" class="btn btn-excel">
                <i class="fas fa-file-excel"></i> 匯出全體名單
            </a>
            
            <a href="interface.php" class="btn btn-back">
                <i class="fas fa-sign-out-alt"></i> 回前台
            </a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="10%">員工編號</th>
                <th width="15%">姓名</th>
                <th width="15%">部門</th>
                <th width="15%">職位</th>
                <th width="15%">到職日</th>
                <th width="10%">資料操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_users as $u): ?>
            <tr>
                <td><?php echo htmlspecialchars($u['emp_id'] ?? str_pad($u['id'], 3, '0', STR_PAD_LEFT)); ?></td>
                
                <td style="font-weight: bold; color: #333;"><?php echo htmlspecialchars($u['username']); ?></td>
                <td><?php echo htmlspecialchars($u['department']); ?></td>
                
                <td>
                    <?php 
                        // 根據職位給予不同顏色的標籤，視覺上更清晰
                        if (in_array($u['position'], ['董事長', '總經理', '法人'])) {
                            echo '<span class="badge badge-boss"><i class="fas fa-crown"></i> ' . htmlspecialchars($u['position']) . '</span>';
                        } elseif (strpos($u['position'], '副總') !== false) {
                            echo '<span class="badge badge-vp">' . htmlspecialchars($u['position']) . '</span>';
                        } else {
                            echo '<span class="badge badge-mgr">' . htmlspecialchars($u['position']) . '</span>';
                        }
                    ?>
                </td>
                
                <td><?php echo htmlspecialchars($u['arrival_date'] ?? '-'); ?></td>
                
                <td>
                    <a href="admin_edit.php?id=<?php echo $u['id']; ?>" class="btn btn-edit">
                        <i class="fas fa-edit"></i> 編輯
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div style="margin-top: 20px; color: #888; font-size: 0.9em; text-align: center;">
        共 <?php echo count($all_users); ?> 位員工資料
    </div>
</div>

</body>
</html>