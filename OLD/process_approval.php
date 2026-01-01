<?php
session_start();
include 'db_config.php';

// 權限檢查函數
function is_manager_or_above($position) {
    $allowed_ranks = ['部長', '協理', '副總經理', '總經理', '董事長'];
    return in_array($position, $allowed_ranks);
}

// 1. (極重要) 檢查登入與權限
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    die("請先登入。");
}
if (!is_manager_or_above($_SESSION['position'])) {
    die("權限不足。");
}

// 2. 獲取資料
$proposal_id = $_POST['proposal_id'];
$action = $_POST['action']; // 'approve' 或 'reject'
$approver_id = $_SESSION['id'];

if (empty($proposal_id) || empty($action)) {
    die("無效的操作。");
}

// 3. (安全性) 檢查是否在簽核自己的提案
$stmt_check = $conn->prepare("SELECT submitted_by_id FROM proposals WHERE id = ?");
$stmt_check->bind_param("i", $proposal_id);
$stmt_check->execute();
$result = $stmt_check->get_result();
$proposal = $result->fetch_assoc();

if ($proposal && $proposal['submitted_by_id'] == $approver_id) {
    die("您不能簽核自己的提案。");
}
$stmt_check->close();

// 4. 根據動作決定新的狀態
$new_status = '';
if ($action == 'approve') {
    $new_status = 'approved';
} elseif ($action == 'reject') {
    $new_status = 'rejected';
} else {
    die("無效的動作。");
}

// 5. (安全性) 更新資料庫
// 加上 status = 'pending' 條件，避免重複簽核
$stmt = $conn->prepare("
    UPDATE proposals 
    SET status = ?, approved_by_id = ? 
    WHERE id = ? AND status = 'pending'
");
$stmt->bind_param("sii", $new_status, $approver_id, $proposal_id);

if ($stmt->execute()) {
    // 成功，轉跳回主頁
    header('Location: approval_system.php');
    exit;
} else {
    echo "簽核失敗: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>