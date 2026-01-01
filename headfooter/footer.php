<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Footer 範例</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Footer 自訂樣式 */
    footer {
      background-color: #343a40; /* 深灰背景 */
      color: #f8f9fa; /* 淺色文字 */
      padding: 20px 0;
    }
    footer p {
      margin: 0;
    }
    footer a {
      color: #f8f9fa;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    footer a:hover {
      color: #adb5bd;
    }
  </style>
</head>
<body>
  <!-- 內容區塊可以放在這裡 -->

  <!-- Footer 區塊 -->
  <footer class="py-4">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start">
          <p class="mb-0">&copy; 2025 CHENGXUN 誠訊. 保留所有權利。</p>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <ul class="list-inline mb-0">
            <li class="list-inline-item"><a href="#">隱私政策</a></li>
            <li class="list-inline-item"><a href="#">使用條款</a></li>
            <li class="list-inline-item"><a href="#">聯絡我們(+886)0938932852</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
