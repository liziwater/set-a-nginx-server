<?php
include 'headfooter/header1.php'; // 導入 header
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>代辦申請</title>
  <!-- 引入 Google 字型：Noto Sans TC 適用於中文排版 -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Noto Sans TC', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 1000px;
      margin: 0 auto;
    }
    .iframe-container {
      margin-bottom: 40px;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .iframe-container h2 {
      margin-bottom: 15px;
      text-align: center;
      color: #007bff;
    }
    iframe {
      width: 100%;
      border: none;
      display: block;
    }
    /* 響應式調整 */
    @media (max-width: 768px) {
      body {
        padding: 10px;
      }
      .iframe-container {
        padding: 15px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- 第一個申請表單 -->
    <div class="iframe-container">
      <h2>代辦申請表單 1</h2>
      <iframe src="https://docs.google.com/forms/d/e/1FAIpQLScKvp4DJ1ebGL57OlIfNiwkJiz_t4Jcpiya5Kq51LbWQLoMVw/viewform?embedded=true" height="1680">載入中…</iframe>
    </div>
    <!-- 第二個申請表單 -->
    <div class="iframe-container">
      <h2>代辦申請表單 2</h2>
      <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeX-JF9S-egEkLknX99we2XB0ngUjXezdQ6GSGFQ6QQdFVh7g/viewform?embedded=true" height="800">載入中…</iframe>
    </div>
  </div>
</body>
</html>
<?php
include 'headfooter/footer.php'; // 導入 footer
?>
