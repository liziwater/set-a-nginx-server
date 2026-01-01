<?php
// 設定資料庫連線
$servername = "localhost"; // MariaDB 伺服器位址
$username = "lizi"; // MariaDB 使用者名稱
$password = "123"; // MariaDB 密碼
$dbname = "eims"; // 資料庫名稱

// 建立資料庫連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線是否成功
if ($conn->connect_error) {
  die("連線失敗: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // 取得表單資料
  $title = $_POST['title'];
  $message = $_POST['message'];

  // 防止 SQL 注入
  $title = $conn->real_escape_string($title);
  $message = $conn->real_escape_string($message);

  // 插入公告資料
  $sql = "INSERT INTO announcements (title, message) VALUES ('$title', '$message')";
  if ($conn->query($sql) === TRUE) {
    echo "公告新增成功！";
  } else {
    echo "錯誤: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新增公告</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <header>
    <h1>新增公告</h1>
  </header>

  <section class="add-announcement">
    <form action="add_announcement.php" method="POST">
      <label for="title">公告標題：</label>
      <input type="text" name="title" id="title" required>
      
      <label for="content">公告內容：</label>
      <textarea name="content" id="content" rows="5" required></textarea>

      <button type="submit">新增公告</button>
    </form>
  </section>

  <footer>
    <p>&copy; 2025 誠訊e-ims</p>
  </footer>

  <?php $conn->close(); // 關閉資料庫連線 ?>

</body>
</html>
