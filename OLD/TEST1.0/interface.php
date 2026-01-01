<?php
session_start();
include 'db.php';

if (!isset($_SESSION["emp_id"])) {
    header("Location: login.php");
    exit;
}

$emp_id = $_SESSION["emp_id"];
$sql = "SELECT * FROM employees WHERE emp_id='$emp_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>員工主頁</title>
</head>
<body>
<h2>歡迎回來，<?php echo $row["name"]; ?>！</h2>
<p>員工編號：<?php echo $row["emp_id"]; ?></p>
<p>電話：<?php echo $row["phone"]; ?></p>
<p>電子郵件：<?php echo $row["email"]; ?></p>
<p>生日：<?php echo $row["birthday"]; ?></p>
<p><img src="<?php echo $row["photo"]; ?>" width="120" height="120" style="border-radius:50%;"></p>
<a href="logout.php">登出</a>
</body>
</html>
