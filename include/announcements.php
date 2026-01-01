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

// 取得公告資料
$sql = "SELECT * FROM announcements ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>公告系統</title>
  <!-- 引入 Google 字型：Noto Sans TC 適用於中文排版 -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&display=swap" rel="stylesheet">
  <style>
    /* Reset 一些預設樣式 */
   
   
    
    .announcements {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      padding: 20px;
    }
    
    .announcements h2 {
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #007bff;
    }
    
    .announcements ul {
      list-style: none;
    }
    
    .announcements li {
      padding: 15px 0;
      border-bottom: 1px solid #eee;
    }
    
    .announcements li:last-child {
      border-bottom: none;
    }
    
    .announcements h3 {
      color: #007bff;
      margin-bottom: 10px;
    }
    
    .announcements p {
      margin-bottom: 10px;
    }
    
    .announcements p small {
      color: #666;
    }
    
    /* 響應式調整 */
    @media (max-width: 768px) {
      body {
        padding: 10px;
      }
      
      header, .announcements {
        padding: 15px;
      }
    }
  </style>
</head>
<body>


  <section class="announcements">
    <h2>最新公告</h2>
    
    <?php if ($result->num_rows > 0): ?>
      <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
          <li>
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
            <p><small>發布時間: <?php echo $row['created_at']; ?></small></p>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p>目前沒有公告。</p>
    <?php endif; ?>
  </section>

  <?php $conn->close(); // 關閉資料庫連線 ?>
</body>
</html>
