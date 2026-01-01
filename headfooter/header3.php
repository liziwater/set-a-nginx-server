<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>誠訊集團 - 官方通知平台</title>
  <meta name="description" content="誠訊集團提供專業合約查詢系統與企業數位服務,協助客戶快速查詢、管理與追蹤合約資訊。">
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
      background: #f8f9fa;
      min-height: 100vh;
    }

    nav {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px) saturate(180%);
      -webkit-backdrop-filter: blur(20px) saturate(180%);
      border-bottom: 1px solid rgba(0, 0, 0, 0.08);
      box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .nav-container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 2rem;
      height: 72px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 14px;
      cursor: pointer;
      transition: opacity 0.2s ease;
    }

    .logo:hover {
      opacity: 0.8;
    }

    .logo img {
      height: 44px;
      filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
      transition: transform 0.3s ease;
    }

    .logo:hover img {
      transform: scale(1.05);
    }

    .logo-text {
      font-weight: 700;
      font-size: 1.4rem;
      color: #1a1a1a;
      letter-spacing: 0.5px;
    }

    .menu {
      list-style: none;
      display: flex;
      gap: 0.5rem;
    }

    .menu li {
      position: relative;
    }

    .menu li a {
      text-decoration: none;
      color: #2c3e50;
      font-weight: 600;
      font-size: 0.94rem;
      padding: 10px 18px;
      border-radius: 8px;
      transition: all 0.25s ease;
      display: block;
      position: relative;
      overflow: hidden;
      background: transparent;
      letter-spacing: 0.3px;
    }

    /* 滑動底線效果 */
    .menu li a::before {
      content: '';
      position: absolute;
      bottom: 6px;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 2px;
      background: #2563eb;
      transition: width 0.3s ease;
    }

    /* 背景填充效果 */
    .menu li a::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, #f0f4ff 0%, #e8efff 100%);
      opacity: 0;
      transition: opacity 0.25s ease;
      z-index: -1;
      border-radius: 8px;
    }

    .menu li a:hover::before {
      width: 60%;
    }

    .menu li a:hover::after {
      opacity: 1;
    }

    .menu li a:hover {
      color: #1e40af;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.12);
    }

    .menu li a:active {
      transform: translateY(0);
      box-shadow: 0 2px 6px rgba(37, 99, 235, 0.15);
    }

    /* 點擊脈衝效果 */
    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4);
      }
      70% {
        box-shadow: 0 0 0 8px rgba(37, 99, 235, 0);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
      }
    }

    .menu li a:active::after {
      animation: pulse 0.5s ease-out;
    }

    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      padding: 10px;
      background: transparent;
      border-radius: 6px;
      border: 1px solid #e5e7eb;
      transition: all 0.25s ease;
    }

    .hamburger:hover {
      background: #f3f4f6;
      border-color: #d1d5db;
    }

    .hamburger:active {
      background: #e5e7eb;
    }

    .hamburger span {
      width: 24px;
      height: 2.5px;
      background: #374151;
      border-radius: 2px;
      transition: all 0.3s ease;
    }

    .hamburger.active span:nth-child(1) {
      transform: rotate(45deg) translate(6px, 6px);
    }

    .hamburger.active span:nth-child(2) {
      opacity: 0;
      transform: translateX(-10px);
    }

    .hamburger.active span:nth-child(3) {
      transform: rotate(-45deg) translate(6px, -6px);
    }

    /* Mobile */
    @media (max-width: 768px) {
      .nav-container {
        padding: 0 1.5rem;
      }

      .hamburger {
        display: flex;
      }

      .menu {
        position: absolute;
        top: 72px;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        flex-direction: column;
        display: none;
        border-top: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        animation: slideDown 0.3s ease-out;
      }

      .menu.active {
        display: flex;
      }

      .menu li {
        opacity: 0;
        animation: slideDown 0.3s ease-out forwards;
      }

      .menu li:nth-child(1) { animation-delay: 0.03s; }
      .menu li:nth-child(2) { animation-delay: 0.06s; }
      .menu li:nth-child(3) { animation-delay: 0.09s; }
      .menu li:nth-child(4) { animation-delay: 0.12s; }
      .menu li:nth-child(5) { animation-delay: 0.15s; }
      .menu li:nth-child(6) { animation-delay: 0.18s; }
      .menu li:nth-child(7) { animation-delay: 0.21s; }

      .menu li a {
        text-align: center;
        padding: 16px;
        margin: 0.3rem 1rem;
      }
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Demo content */
    .demo-content {
      max-width: 1280px;
      margin: 5rem auto;
      padding: 3rem;
      text-align: center;
    }

    .demo-content h1 {
      font-size: 3rem;
      margin-bottom: 1rem;
      color: #1a1a1a;
      font-weight: 700;
      letter-spacing: -0.5px;
    }

    .demo-content p {
      font-size: 1.2rem;
      color: #4b5563;
      font-weight: 400;
    }

    /* 專業感的裝飾元素 */
    .demo-content::before {
      content: '';
      position: absolute;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, #2563eb, #3b82f6);
      border-radius: 2px;
      margin-top: -2rem;
    }
  </style>
</head>
<body>
  <nav>
    <div class="nav-container">
      <div class="logo">
        <img src="image/LOGO.png" alt="logo" />
        <span class="logo-text">誠訊工作室</span>
      </div>

      <div class="hamburger" id="hamburger">
        <span></span><span></span><span></span>
      </div>

      <ul class="menu" id="menu">
        <li><a href="index.php">產品</a></li>
        <li><a href="announcement.php">公告</a></li>
        <li><a href="404error.php">金融旅遊</a></li>
        <li><a href="National Travel Congress.php">國旅大會NCT</a></li>
        <li><a href="login.html">部門專區</a></li>
        <li><a href="about02.php">行政團隊</a></li>
        <li><a href="http://chengxun.ddns.net:3000/aidisclution">AI</a></li>
      </ul>
    </div>
  </nav>

 

  <script>
    const hamburger = document.getElementById("hamburger");
    const menu = document.getElementById("menu");

    hamburger.addEventListener("click", () => {
      menu.classList.toggle("active");
      hamburger.classList.toggle("active");
    });

    document.addEventListener("click", (e) => {
      if (!e.target.closest("nav")) {
        menu.classList.remove("active");
        hamburger.classList.remove("active");
      }
    });

    window.addEventListener("resize", () => {
      if (window.innerWidth > 768) {
        menu.classList.remove("active");
        hamburger.classList.remove("active");
      }
    });
  </script>
</body>
</html>