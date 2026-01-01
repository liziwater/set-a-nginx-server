<?php
session_start();
include 'db_config.php';

// 權限檢查函數 (複製 dashboard.php 的)
function is_manager_or_above($position) {
    $allowed_ranks = ['部長', '協理', '副總經理', '總經理', '董事長'];
    return in_array($position, $allowed_ranks);
}

// 1. (極重要) 檢查登入與權限
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.html');
    exit;
}
if (!is_manager_or_above($_SESSION['position'])) {
    // 如果權限不足，踢回 dashboard
    header('Location: dashboard.php');
    exit;
}

$current_user_id = $_SESSION['id'];

// 2. 抓取「待我簽核」的列表 (狀態為 pending，且提案人不是自己)
$stmt_pending = $conn->prepare("
    SELECT p.*, e.full_name AS submitter_name, e.department AS submitter_dept
    FROM proposals p
    JOIN employees e ON p.submitted_by_id = e.id
    WHERE p.status = 'pending' AND p.submitted_by_id != ?
    ORDER BY p.created_at DESC
");
$stmt_pending->bind_param("i", $current_user_id);
$stmt_pending->execute();
$pending_proposals = $stmt_pending->get_result();

// 3. 抓取「我已提交」的列表
$stmt_mine = $conn->prepare("
    SELECT p.*, e.full_name AS approver_name
    FROM proposals p
    LEFT JOIN employees e ON p.approved_by_id = e.id
    WHERE p.submitted_by_id = ?
    ORDER BY p.created_at DESC
");
$stmt_mine->bind_param("i", $current_user_id);
$stmt_mine->execute();
$my_proposals = $stmt_mine->get_result();

$stmt_pending->close();
$stmt_mine->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文件簽核系統</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        .header { background-color: #333; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { margin: 0; font-size: 1.5rem; }
        .header a { color: #fff; text-decoration: none; padding: 0.5rem 1rem; }
        .header a.logout { background-color: #dc3545; border-radius: 4px; }
        .header a.logout:hover { background-color: #c82333; }
        .content { max-width: 1100px; margin: 2rem auto; padding: 2rem; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .toolbar { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f0f0f0; padding-bottom: 1rem; }
        .btn-primary { background-color: #007bff; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .btn-primary:hover { background-color: #0056b3; }
        .proposal-section { margin-top: 2rem; }
        .proposal-section h3 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem 1rem; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f4f4f4; }
        .status-pending { color: #ffa500; font-weight: bold; }
        .status-approved { color: #28a745; font-weight: bold; }
        .status-rejected { color: #dc3545; font-weight: bold; }
        .action-form { display: inline-block; }
        .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.8rem; border: none; border-radius: 4px; cursor: pointer; }
        .btn-approve { background-color: #28a745; color: white; }
        .btn-reject { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>文件簽核系統</h1>
        <div>
            <a href="dashboard.php">返回後台</a>
            <a href="logout.php" class="logout">登出</a>
        </div>
    </div>

    <div class="content">
        <div class="toolbar">
            <h2><?php echo htmlspecialchars($_SESSION['full_name']); ?> (<?php echo htmlspecialchars($_SESSION['position']); ?>)</h2>
            <a href="submit_proposal.php" class="btn-primary">提出新提案</a>
        </div>

        <div class="proposal-section">
            <h3>待我簽核 (<?php echo $pending_proposals->num_rows; ?>)</h3>
            <table>
                <thead>
                    <tr>
                        <th>標題</th>
                        <th>提案人</th>
                        <th>部門</th>
                        <th>附件</th>
                        <th>內容預覽</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($pending_proposals->num_rows > 0): ?>
                        <?php while($row = $pending_proposals->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['submitter_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['submitter_dept']); ?></td>
                            <td>
                                <?php if (!empty($row['attachment_path'])): ?>
                                    <a href="<?php echo htmlspecialchars($row['attachment_path']); ?>" target="_blank">下載</a>
                                <?php else: ?>
                                    (無)
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars(mb_substr($row['content'], 0, 20) . '...'); ?></td>
                            <td>
                                <form action="process_approval.php" method="POST" class="action-form">
                                    <input type="hidden" name="proposal_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="action" value="approve" class="btn-sm btn-approve">核准</button>
                                    <button type="submit" name="action" value="reject" class="btn-sm btn-reject">駁回</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align:center;">目前沒有待簽核的文件。</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="proposal-section">
            <h3>我已提交的提案 (<?php echo $my_proposals->num_rows; ?>)</h3>
            <table>
                <thead>
                    <tr>
                        <th>標題</th>
                        <th>提交時間</th>
                        <th>狀態</th>
                        <th>簽核人</th>
                        <th>附件</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($my_proposals->num_rows > 0): ?>
                        <?php while($row = $my_proposals->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td>
                                <?php 
                                $status_text = '';
                                $status_class = '';
                                switch ($row['status']) {
                                    case 'pending':
                                        $status_text = '審核中';
                                        $status_class = 'status-pending';
                                        break;
                                    case 'approved':
                                        $status_text = '已核准';
                                        $status_class = 'status-approved';
                                        break;
                                    case 'rejected':
                                        $status_text = '已駁回';
                                        $status_class = 'status-rejected';
                                        break;
                                }
                                echo '<span class="' . $status_class . '">' . $status_text . '</span>';
                                ?>
                            </td>
                            <td><?php echo $row['approver_name'] ? htmlspecialchars($row['approver_name']) : '---'; ?></td>
                            <td>
                                <?php if (!empty($row['attachment_path'])): ?>
                                    <a href="<?php echo htmlspecialchars($row['attachment_path']); ?>" target="_blank">下載</a>
                                <?php else: ?>
                                    (無)
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center;">您尚未提交任何提案。</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>