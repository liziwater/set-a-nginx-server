<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM employees WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["emp_id"] = $row["emp_id"];
            $_SESSION["name"] = $row["name"];
            header("Location: interface.php");
            exit;
        } else {
            echo "<script>alert('密碼錯誤');</script>";
        }
    } else {
        echo "<script>alert('查無此帳號');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>員工登入</title>
</head>
<body>
<h2>員工登入</h2>
<form method="post">
    電子郵件：<input type="email" name="email" required><br><br>
    密碼：<input type="password" name="password" required><br><br>
    <button type="submit">登入</button>
</form>
<p>還沒有帳號？<a href="register.php">點此註冊</a></p>
</body>
</html>
