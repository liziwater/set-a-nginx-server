<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$doc_id = $_GET['id'] ?? null;

if (!$doc_id) {
    header("Location: dashboardTEST.php");
    exit;
}

// 處理簽核動作
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action']; // 'approve' or 'reject'
    $new_status = ($action === 'approve') ? 'approved' : 'rejected';

    $stmt = $pdo->prepare("UPDATE documents SET status = ? WHERE id = ? AND assigned_to_id = ?");
    $stmt->execute([$new_status, $doc_id, $user['employee_id']]);

    header("Location: dashboard.php");
    exit;
}

// 獲取文件詳細資訊
$stmt = $pdo->prepare(
    "SELECT d.*, p.name as proposer_name, a.name as assignee_name
     FROM documents d
     JOIN employees p ON d.proposer_id = p.employee_id
     JOIN employees a ON d.assigned_to_id = a.employee_id
     WHERE d.id = ? AND d.assigned_to_id = ?"
);
$stmt->execute([$doc_id, $user['employee_id']]);
$document = $stmt->fetch();

// 如果找不到文件或文件不屬於該使用者，導回主控台
if (!$document || $document['status'] !== 'pending') {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>文件簽核 - <?php echo htmlspecialchars($document['title']); ?></title>
<style>
    body { font-family: "微軟正黑體", sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
    .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 20px 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
    .header h1 { margin: 0; font-size: 24px; color: #333; }
    .header a { background: #555; color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; font-size: 14px; transition: background 0.3s; }
    .header a:hover { background: #333; }
    .doc-details { margin-bottom: 25px; }
    .doc-details h2 { margin-top: 0; color: #333; }
    .doc-details p { white-space: pre-wrap; line-height: 1.6; color: #555; background: #f9f9f9; padding: 15px; border-radius: 5px; border: 1px solid #eee; }
    .doc-meta { color: #777; font-size: 14px; margin-bottom: 20px; }
    .action-buttons { text-align: center; }
    .action-buttons button { padding: 12px 25px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: all 0.3s; margin: 0 10px; }
    .approve-btn { background-color: #2ecc71; color: white; }
    .approve-btn:hover { background-color: #27ae60; }
    .reject-btn { background-color: #e74c3c; color: white; }
    .reject-btn:hover { background-color: #c0392b; }
</style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>文件簽核</h1>
        <a href="dashboardTEST.php">返回主控台</a>
    </div>

    <div class="doc-details">
        <h2><?php echo htmlspecialchars($document['title']); ?></h2>
        <div class="doc-meta">
            <strong>提案人:</strong> <?php echo htmlspecialchars($document['proposer_name']); ?><br>
            <strong>提案時間:</strong> <?php echo date('Y-m-d H:i', strtotime($document['created_at'])); ?>
        </div>
        <p><?php echo htmlspecialchars($document['content']); ?></p>
    </div>

    <div class="action-buttons">
        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="approve">
            <button type="submit" class="approve-btn">批准文件</button>
        </form>
        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="reject">
            <button type="submit" class="reject-btn">駁回文件</button>
        </form>
    </div>
</div>

</body>
</html>
