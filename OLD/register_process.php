<?php
/*
 * 檔案：register_process.php
 * 說明：處理員工註冊的後端邏輯
 */

// 1. 引入資料庫連線設定檔
include 'db_config.php';

// 2. 獲取表單提交的資料 (使用 POST 方法)
$employee_id = $_POST['employee_id'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$department = $_POST['department'];
$position = $_POST['position'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// 3. 伺服器端驗證
if (empty($employee_id) || empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
    die("錯誤：所有欄位（*）都是必填的。");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("錯誤：電子郵件格式不正確。");
}

if (strlen($password) < 6) {
    die("錯誤：密碼長度至少需要 6 個字元。");
}

if ($password !== $confirm_password) {
    die("錯誤：兩次輸入的密碼不一致。");
}

// 4. (極重要) 密碼加密
// 絕對不儲存明文密碼！使用 PHP 內建的 password_hash()
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 5. (安全性) 檢查員工編號或 Email 是否已被註冊
// 使用 Prepared Statements (預備陳述式) 來防止 SQL 隱碼攻擊
$stmt_check = $conn->prepare("SELECT id FROM employees WHERE employee_id = ? OR email = ?");
$stmt_check->bind_param("ss", $employee_id, $email);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    die("錯誤：此員工編號或電子郵件已被註冊。");
}
$stmt_check->close();


// 6. (安全性) 將資料寫入資料庫
// 同樣使用 Prepared Statements
$stmt_insert = $conn->prepare("INSERT INTO employees (employee_id, full_name, email, department, position, password, status) VALUES (?, ?, ?, ?, ?, ?, 'active')");

// "ssssss" 代表 6 個參數都是字串 (string)
$stmt_insert->bind_param("ssssss", 
    $employee_id, 
    $full_name, 
    $email, 
    $department, 
    $position, 
    $hashed_password
);

// 7. 執行並給予回饋
if ($stmt_insert->execute()) {
    echo "註冊成功！您現在可以登入了。";
    // 實務上，您可以在這裡將使用者導向登入頁面
    // header('Location: login.html');
} else {
    echo "註冊失敗，請聯繫系統管理員: " . $stmt_insert->error;
}

// 8. 關閉連線
$stmt_insert->close();
$conn->close();

?>