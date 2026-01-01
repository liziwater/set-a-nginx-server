<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>員工主頁</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <img src="<?php echo $_SESSION['avatar']; ?>" width="100" height="100" style="border-radius:50%;"><br>
    <h2>👋 歡迎，<?php echo $_SESSION['name']; ?>（<?php echo $_SESSION['position']; ?>）</h2>
    <form action="checkin.php" method="POST">
        <button type="submit">📅 今日報到</button>
    </form>
    <a href="logout.php">登出</a>
</div>
</body>
</html>
