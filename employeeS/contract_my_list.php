<?php
session_start();
require 'db.php';

// 1. 安全檢查
if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

// 2. 讀取目前登入者的所有提案 (按時間倒序)
$sql = "SELECT * FROM documents WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$my_docs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>我的提案紀錄</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Microsoft JhengHei', sans-serif; background: #f0f2f5; padding: 20px; }
        .container { max-width: 1100px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        
        /* 標題區塊 */
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        .btn-new { background: #007bff; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-weight: bold; transition: 0.3s; }
        .btn-new:hover { background: #0056b3; box-shadow: 0 2px 5px rgba(0,123,255,0.3); }
        .btn-home { color: #666; text-decoration: none; margin-left: 15px; }
        .btn-home:hover { color: #333; }

        /* 表格樣式 */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #343a40; color: white; padding: 12px; text-align: left; border-radius: 4px 4px 0 0; }
        td { padding: 15px 12px; border-bottom: 1px solid #eee; vertical-align: middle; color: #444; }
        tr:hover { background-color: #f8f9fa; }

        /* 狀態標籤 */
        .badge { padding: 5px 10px; border-radius: 15px; font-size: 0.85em; font-weight: bold; display: inline-block; }
        .status-pending { background: #fff3cd; color: #856404; }   /* 黃色：簽核中 */
        .status-approved { background: #d4edda; color: #155724; }  /* 綠色：已結案 */
        .status-rejected { background: #f8d7da; color: #721c24; }  /* 紅色：被退回 */

        /* 連結樣式 */
        .doc-title { color: #007bff; text-decoration: none; font-weight: bold; font-size: 1.05em; }
        .doc-title:hover { text-decoration: underline; }
        .btn-pdf { color: #dc3545; border: 1px solid #dc3545; padding: 3px 8px; border-radius: 4px; text-decoration: none; font-size: 0.85em; transition: 0.2s; }
        .btn-pdf:hover { background: #dc3545; color: white; }

        /* 歷史紀錄文字 */
        .history-text { font-size: 0.85em; color: #666; max-height: 80px; overflow-y: auto; display: block; line-height: 1.4; background: #fafafa; padding: 5px; border-radius: 4px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div>
            <h2 style="margin:0; color:#333;"><i class="fas fa-folder-open"></i> 我的送審紀錄</h2>
            <span style="color:#777; font-size:0.9em;">查看您所有提案的簽核進度</span>
        </div>
        <div>
            <a href="contract_upload.php" class="btn-new"><i class="fas fa-plus"></i> 新增簽核提案</a>
            <a href="interface.php" class="btn-home"><i class="fas fa-home"></i> 回首頁</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="10%">日期</th>
                <th width="20%">文件標題</th>
                <th width="15%">目前關卡</th>
                <th width="12%">狀態</th>
                <th width="33%">簽核歷程 (最新的在下)</th>
                <th width="10%">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($my_docs as $row): ?>
            <tr>
                <td><?php echo date('Y/m/d', strtotime($row['created_at'])); ?></td>
                
                <td>
                    <a href="<?php echo htmlspecialchars($row['file_path']); ?>" target="_blank" class="doc-title">
                        <?php echo htmlspecialchars($row['title']); ?>
                    </a>
                    <div style="font-size:0.8em; color:#888; margin-top:4px;">
                        <?php echo mb_substr(htmlspecialchars($row['description']), 0, 20, 'utf-8') . '...'; ?>
                    </div>
                </td>

                <td>
                    <?php if($row['status'] == 'approved'): ?>
                        <span style="color:#28a745; font-weight:bold;">歸檔 (結束)</span>
                    <?php elseif($row['status'] == 'rejected'): ?>
                        <span style="color:#dc3545; font-weight:bold;">停止</span>
                    <?php else: ?>
                        <span style="color:#e0a800; font-weight:bold;">
                            <i class="fas fa-user-clock"></i> <?php echo $row['current_level']; ?>
                        </span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php 
                        if ($row['status'] == 'approved') {
                            echo '<span class="badge status-approved"><i class="fas fa-check"></i> 已通過</span>';
                        } elseif ($row['status'] == 'rejected') {
                            echo '<span class="badge status-rejected"><i class="fas fa-times"></i> 被退回</span>';
                        } else {
                            echo '<span class="badge status-pending"><i class="fas fa-spinner fa-spin"></i> 簽核中</span>';
                        }
                    ?>
                </td>

                <td>
                    <small class="history-text">
                        <?php echo nl2br(htmlspecialchars($row['sign_history'])); ?>
                    </small>
                </td>

                <td>
                    <a href="contract_print.php?id=<?php echo $row['id']; ?>" target="_blank" class="btn-pdf">
                        <i class="fas fa-file-pdf"></i> 下載卷函
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>

            <?php if (count($my_docs) === 0): ?>
            <tr>
                <td colspan="6" style="text-align:center; padding: 40px; color: #999;">
                    <i class="fas fa-inbox" style="font-size: 3em; margin-bottom: 10px;"></i><br>
                    目前沒有任何送審紀錄，請點擊右上方「新增簽核提案」。
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>