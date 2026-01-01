<?php
session_start();
require 'db.php';

// 1. 安全與職位檢查
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

// 取得目前使用者的資料
$stmt = $pdo->prepare("SELECT username, position, department FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$manager = $stmt->fetch();

// 定義職位階層 (由低到高)
$levels = ['部長', '協理', '副總經理', '總經理', '董事長'];
$my_position = $manager['position'];

// 如果不是這些職位之一，踢回首頁
if (!in_array($my_position, $levels)) {
    echo "<script>alert('您沒有權限進入簽核後台'); window.location.href='interface.php';</script>";
    exit;
}

// 2. 處理簽核動作
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doc_id = $_POST['doc_id'];
    $action = $_POST['action'];
    $comment = $_POST['comment'];
    
    // 二度驗證
    $checkStmt = $pdo->prepare("SELECT current_level, department, sign_history FROM documents WHERE id = ?");
    $checkStmt->execute([$doc_id]);
    $targetDoc = $checkStmt->fetch();

    // 權限防護網
    if ($targetDoc['current_level'] !== $my_position) {
        die("錯誤：目前並非您的簽核關卡，無法執行操作。");
    }
    // 部長級別防護
    if ($my_position === '部長' && $targetDoc['department'] !== $manager['department']) {
        die("錯誤：您無法簽核其他部門的文件。");
    }

    // --- 執行更新邏輯 ---
    $timestamp = date("Y-m-d H:i");
    $new_log = $targetDoc['sign_history'] . "[$timestamp] $my_position {$manager['username']} : " . ($action=='approve'?'核准':'退回') . " (意見:$comment)\n";

    if ($action === 'reject') {
        // 退回
        $sql = "UPDATE documents SET status='rejected', sign_history=? WHERE id=?";
        $pdo->prepare($sql)->execute([$new_log, $doc_id]);
    } else {
        // 核准 -> 找下一關
        $current_index = array_search($my_position, $levels);
        
        if ($current_index === count($levels) - 1) {
            // 董事長 -> 結案
            $sql = "UPDATE documents SET status='approved', current_level='歸檔', sign_history=? WHERE id=?";
            $pdo->prepare($sql)->execute([$new_log, $doc_id]);
        } else {
            // 送往下一階
            $next_level = $levels[$current_index + 1];
            $sql = "UPDATE documents SET current_level=?, sign_history=? WHERE id=?";
            $pdo->prepare($sql)->execute([$next_level, $new_log, $doc_id]);
        }
    }
    // 重新整理頁面
    header("Location: contract_approval.php");
    exit;
}

// 3. 讀取清單
if ($my_position === '部長') {
    // 部長：看到「自己部門」的所有文件
    $sql = "SELECT * FROM documents WHERE department = ? ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$manager['department']]);
} else {
    // 協理以上：看到「全公司」的所有文件
    $sql = "SELECT * FROM documents ORDER BY created_at DESC";
    $stmt = $pdo->query($sql);
}
$tasks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>主管簽核監控台</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Microsoft JhengHei', sans-serif; background: #eef2f7; padding: 20px; }
        .container { max-width: 1100px; margin: 0 auto; }
        
        /* 卡片樣式 */
        .card { background: white; padding: 25px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); position: relative; border-left: 6px solid #ccc; transition: 0.3s; }
        
        /* 狀態顏色 */
        .card.status-active { border-left-color: #28a745; box-shadow: 0 0 15px rgba(40, 167, 69, 0.2); } /* 輪到我 */
        .card.status-waiting { border-left-color: #ffc107; } /* 等待下屬 */
        .card.status-passed { border-left-color: #17a2b8; opacity: 0.8; } /* 我已簽過 */
        .card.status-done { border-left-color: #6c757d; opacity: 0.6; } /* 結案/退回 */

        .header-row { display: flex; justify-content: space-between; align-items: flex-start; }
        .title { font-size: 1.4em; font-weight: bold; color: #333; margin: 0; display: flex; align-items: center; flex-wrap: wrap; }
        .info { color: #666; font-size: 0.95em; margin-top: 5px; }
        
        .status-badge { display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 0.85em; font-weight: bold; }
        .badge-green { background: #d4edda; color: #155724; }
        .badge-yellow { background: #fff3cd; color: #856404; }
        .badge-gray { background: #e2e3e5; color: #383d41; }
        
        .actions { margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee; }
        textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: vertical; }
        .btn { padding: 8px 20px; border: none; border-radius: 4px; cursor: pointer; color: white; margin-left: 10px; font-size: 1rem; }
        .btn-approve { background: #28a745; }
        .btn-reject { background: #dc3545; }
        
        .waiting-msg { background: #f8f9fa; color: #666; padding: 10px; border-radius: 4px; text-align: center; font-style: italic; margin-top: 15px;}
    </style>
</head>
<body>

<div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <div>
            <h2 style="margin:0;"><i class="fas fa-tasks"></i> 簽核監控中心</h2>
            <span style="color:#666;">目前身分：<?php echo $my_position; ?> (<?php echo $manager['username']; ?>)</span>
        </div>
        <a href="interface.php" style="text-decoration:none; background:white; padding:10px 15px; border-radius:5px; color:#333; box-shadow:0 2px 4px rgba(0,0,0,0.1);">回首頁</a>
    </div>

    <?php foreach ($tasks as $doc): ?>
        <?php 
            $is_my_turn = ($doc['current_level'] === $my_position && $doc['status'] === 'pending');
            if ($my_position === '部長' && $doc['department'] !== $manager['department']) {
                $is_my_turn = false;
            }

            $cardClass = 'status-waiting'; 
            if ($is_my_turn) {
                $cardClass = 'status-active';
            } elseif ($doc['status'] !== 'pending') {
                $cardClass = 'status-done';
            } 
        ?>

        <div class="card <?php echo $cardClass; ?>">
            <div class="header-row">
                <div>
                    <h3 class="title">
                        <?php echo htmlspecialchars($doc['title']); ?>
                        
                        <a href="<?php echo $doc['file_path']; ?>" target="_blank" style="font-size:0.6em; color:#007bff; margin-left:10px; text-decoration:none;">
                            <i class="fas fa-paperclip"></i> 查看附件
                        </a>

                        <a href="contract_print.php?id=<?php echo $doc['id']; ?>" target="_blank" style="font-size:0.6em; color:#6610f2; margin-left:10px; border: 1px solid #6610f2; padding: 2px 8px; border-radius: 4px; text-decoration:none;">
                            <i class="fas fa-print"></i> 下載卷函
                        </a>
                    </h3>

                    <div class="info">
                        部門：<span style="color:#000; font-weight:bold;"><?php echo htmlspecialchars($doc['department']); ?></span> | 
                        申請人：<?php echo htmlspecialchars($doc['uploader_name']); ?> | 
                        時間：<?php echo date('m/d H:i', strtotime($doc['created_at'])); ?>
                    </div>
                    <div style="margin-top:10px; color:#555;">
                        備註：<?php echo htmlspecialchars($doc['description']); ?>
                    </div>
                </div>
                
                <div style="text-align:right;">
                    <?php if ($doc['status'] == 'pending'): ?>
                        <span class="status-badge badge-yellow">
                            <i class="fas fa-spinner fa-spin"></i> 等待：<?php echo $doc['current_level']; ?>
                        </span>
                    <?php elseif ($doc['status'] == 'approved'): ?>
                        <span class="status-badge badge-green">
                            <i class="fas fa-check-circle"></i> 已歸檔
                        </span>
                    <?php else: ?>
                        <span class="status-badge badge-gray">
                            <i class="fas fa-times-circle"></i> 已退回
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div style="background:#f8f9fa; padding:10px; border-radius:5px; margin-top:15px; font-size:0.85em; color:#666;">
                <strong><i class="fas fa-history"></i> 簽核軌跡：</strong><br>
                <?php echo nl2br(htmlspecialchars($doc['sign_history'] ?? '尚未開始')); ?>
            </div>

            <?php if ($is_my_turn): ?>
                <form method="POST" class="actions">
                    <input type="hidden" name="doc_id" value="<?php echo $doc['id']; ?>">
                    <div style="display:flex; align-items:flex-end;">
                        <textarea name="comment" rows="1" placeholder="輸入簽核意見..." style="flex:1;"></textarea>
                        <button type="submit" name="action" value="reject" class="btn btn-reject" onclick="return confirm('確定退回此文件？');">退回</button>
                        <button type="submit" name="action" value="approve" class="btn btn-approve">批准簽核</button>
                    </div>
                </form>
            <?php elseif ($doc['status'] === 'pending'): ?>
                <div class="waiting-msg">
                    <i class="fas fa-hourglass-half"></i> 
                    目前文件位於 <strong><?php echo $doc['current_level']; ?></strong> 審核中，請稍候。
                </div>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>
    
    <?php if (count($tasks) == 0): ?>
        <p style="text-align:center; color:#999; margin-top:50px;">目前沒有任何文件記錄。</p>
    <?php endif; ?>
</div>

</body>
</html>