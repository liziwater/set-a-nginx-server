<?php
include 'dbTEST.php'; // 連線設定

function generateEmployeeID($pdo) {
    $datePrefix = date('Ymd'); 
    $stmt = $pdo->prepare("SELECT employee_id FROM employees WHERE employee_id LIKE ? ORDER BY employee_id DESC LIMIT 1");
    $stmt->execute(["{$datePrefix}%"]);
    $lastID = $stmt->fetchColumn();
    $serial = $lastID ? ((int)substr($lastID, -4) + 1) : 1;
    return $datePrefix . str_pad($serial, 4, '0', STR_PAD_LEFT);
}

// 呼叫 Python 寄信
function sendEmailWithPython($name, $email, $employee_id) {
    $python_script = escapeshellcmd("python3 send_registermail.py"); // Python 腳本路徑
    $command = "$python_script " . escapeshellarg($name) . " " . escapeshellarg($email) . " " . escapeshellarg($employee_id);
    shell_exec($command);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $birthday = $_POST['birthday'];

    if ($password !== $confirm) {
        die("<script>alert('兩次密碼不一致'); history.back();</script>");
    }

    // 檢查是否重複註冊
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM employees WHERE email=? OR phone=?");
    $stmt->execute([$email, $phone]);
    if ($stmt->fetchColumn() > 0) {
        die("<script>alert('此電話或電子郵件已被註冊'); history.back();</script>");
    }

    $employee_id = generateEmployeeID($pdo);
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $hire_date = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO employees (employee_id, name, hire_date, level, is_active, phone, email, password, birthday) VALUES (?, ?, ?, 1, 0, ?, ?, ?, ?)");
    $stmt->execute([$employee_id, $name, $hire_date, $phone, $email, $hash, $birthday]);

    // ===== 呼叫 Python 寄信 =====
    sendEmailWithPython($name, $email, $employee_id);

    echo "<script>alert('註冊成功！您的員工編號為：$employee_id,通知信已寄出'); window.location='loginTEST.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<title>員工註冊</title>
<style>
body {
    font-family: "微軟正黑體";
    background: linear-gradient(120deg, #84fab0, #8fd3f4);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
form {
    background: #fff;
    padding: 30px 40px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    width: 400px;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}
input {
    width: 100%;
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
}
button {
    width: 100%;
    padding: 10px;
    border: none;
    background: #4a90e2;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 15px;
}
button:hover { background: #357abd; }
</style>
</head>
<body>
<form method="POST">
    <h2>員工註冊</h2>
    <input type="text" name="name" placeholder="姓名" required>
    <input type="text" name="phone" placeholder="電話號碼" required>
    <input type="email" name="email" placeholder="電子郵件" required>
    <input type="date" name="birthday" required>
    <input type="password" name="password" placeholder="密碼" required>
    <input type="password" name="confirm" placeholder="再次輸入密碼" required>
    <button type="submit">註冊</button>
</form>
</body>
</html>
