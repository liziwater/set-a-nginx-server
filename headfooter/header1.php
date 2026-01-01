<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>誠訊集團 - 官方通知平台</title>
      <meta name="description" content="誠訊集團提供專業合約查詢系統與企業數位服務，協助客戶快速查詢、管理與追蹤合約資訊。">
    <meta name="keywords" content="誠訊集團, 合約查詢, 企業服務, 系統開發, 數位轉型">
    <meta name="author" content="誠訊集團 chengxun Group">
    <link rel="canonical" href="https://chengxun.ddns.net/">
  <link rel="icon" href="image/LOGO.png" type="image/png" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    nav {
      background-color: #f8f9fa;
      border-bottom: 1px solid #e9ecef;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      position: relative;
      z-index: 1000;
    }

    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
      height: 65px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo img {
      height: 40px;
    }

    .logo-text {
      font-weight: bold;
      font-size: 1.3rem;
      color: #2c3e50;
    }

    .menu {
      list-style: none;
      display: flex;
      gap: 1rem;
    }

    .menu li a {
      text-decoration: none;
      color: #495057;
      font-weight: 500;
      padding: 10px 16px;
      border-radius: 6px;
      transition: 0.3s;
      display: block;
    }

    .menu li a:hover {
      background-color: #e9ecef;
    }

    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
    }

    .hamburger span {
      width: 25px;
      height: 3px;
      background: #2c3e50;
      transition: 0.3s;
    }

    /* Mobile */
    @media (max-width: 768px) {
      .hamburger {
        display: flex;
      }

      .menu {
        position: absolute;
        top: 65px;
        left: 0;
        right: 0;
        background: white;
        flex-direction: column;
        display: none;
        border-top: 1px solid #e9ecef;
      }

      .menu.active {
        display: flex;
      }

      .menu li a {
        text-align: center;
        padding: 14px;
      }
    }
  </style>
</head>
<body>
  <nav>
    <div class="nav-container">
      <div class="logo">
        <img src="image/LOGO.png" alt="logo" />
        <span class="logo-text">誠訊集團</span>
      </div>

      <!-- 漢堡按鈕 -->
      <div class="hamburger" id="hamburger">
        <span></span><span></span><span></span>
      </div>

      <!-- 導覽選單 -->
      <ul class="menu" id="menu">
        <li><a href="home.php">fast path</a></li>
        <li><a href="notify.php">公告</a></li>
        <li><a href="index.php">合約查詢</a></li>
        <li><a href="404error.php">金融旅遊</a></li>
        <li><a href="National Travel Congress.php">國旅大會NCT</a></li>
        <li><a href="login.php">部門專區</a></li>
        <li><a href="about1.php">關於我們</a></li>
      </ul>
    </div>
  </nav>

  <script>
    const hamburger = document.getElementById("hamburger");
    const menu = document.getElementById("menu");

    hamburger.addEventListener("click", () => {
      menu.classList.toggle("active");
    });

    // 點擊外部關閉
    document.addEventListener("click", (e) => {
      if (!e.target.closest("nav")) {
        menu.classList.remove("active");
      }
    });

    // 縮放關閉
    window.addEventListener("resize", () => {
      if (window.innerWidth > 768) {
        menu.classList.remove("active");
      }
    });
  </script>
</body>
</html>
