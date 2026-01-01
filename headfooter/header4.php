<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>誠訊Studio</title>
  <meta name="description" content="誠訊集團提供專業合約查詢系統與企業數位服務,協助客戶快速查詢、管理與追蹤合約資訊。">
  <link rel="icon" href="image/LOGO.png" type="image/png" />
  
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

  <style>
    :root {
      --primary-color: #003d79;
      --primary-light: #0066cc;
      --text-dark: #2c3e50;
      --text-gray: #5f6368;
      --bg-light: #f8f9fa;
      --nav-height: 72px;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: "Microsoft JhengHei", "PingFang TC", "Segoe UI", sans-serif;
      background: #f0f2f5;
      min-height: 100vh;
      color: var(--text-dark);
    }

    /* 頂部裝飾條 (更細緻的漸層) */
    .gov-stripe {
      height: 4px;
      background: linear-gradient(90deg, var(--primary-color) 0%, #00a0e9 50%, var(--primary-color) 100%);
    }

    /* 頂部工具列 */
    .top-bar {
      background: #ffffff;
      border-bottom: 1px solid #eaeaea;
      padding: 0.4rem 0;
      font-size: 0.85rem;
    }

    .top-bar-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1.5rem;
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 1.5rem;
    }

    .top-bar-item {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      color: var(--text-gray);
      text-decoration: none;
      transition: color 0.2s;
    }

    .top-bar-item i {
      font-size: 1rem;
      color: var(--primary-light);
    }

    .top-bar-item:hover {
      color: var(--primary-color);
    }

    /* 語言切換器 (優化版) */
    .lang-switcher {
      display: flex;
      align-items: center;
      gap: 0.25rem;
      background: #f1f3f4;
      padding: 3px;
      border-radius: 20px; /* 藥丸形狀 */
    }

    .lang-btn {
      background: none;
      border: none;
      padding: 0.2rem 0.8rem;
      cursor: pointer;
      font-size: 0.8rem;
      color: var(--text-gray);
      font-weight: 600;
      border-radius: 16px;
      transition: all 0.3s ease;
      font-family: inherit;
    }

    .lang-btn.active {
      background: white;
      color: var(--primary-color);
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .lang-btn:hover:not(.active) {
      color: var(--primary-color);
    }

    /* 主導覽列 (加入毛玻璃效果) */
    nav {
      background: rgba(255, 255, 255, 0.95); /* 輕微透明 */
      backdrop-filter: blur(10px); /* 毛玻璃模糊 */
      -webkit-backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(0, 61, 121, 0.1);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      position: sticky;
      top: 0;
      z-index: 1000;
      height: var(--nav-height);
    }

    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1.5rem;
      height: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* Logo區域 */
    .logo {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      text-decoration: none;
    }

    .logo img {
      height: 42px;
      width: auto;
      transition: transform 0.3s ease;
    }

    .logo:hover img {
      transform: scale(1.05);
    }

    .logo-text-container {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .logo-text {
      font-weight: 800;
      font-size: 1.4rem;
      color: var(--primary-color);
      letter-spacing: 1px;
      line-height: 1.1;
    }

    .logo-subtitle {
      font-size: 0.7rem;
      color: var(--text-gray);
      letter-spacing: 1.5px;
      text-transform: uppercase;
      font-weight: 500;
    }

    /* 電腦版選單 */
    .menu {
      list-style: none;
      display: flex;
      gap: 0.5rem;
      align-items: center;
      height: 100%;
    }

    .menu li {
      height: 100%;
      display: flex;
      align-items: center;
    }

    .menu li a {
      text-decoration: none;
      color: var(--text-dark);
      font-weight: 500;
      font-size: 0.95rem;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      position: relative;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    /* 選單 Hover 動畫 - 底部線條 */
    .menu li a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: var(--primary-color);
      transition: all 0.3s ease;
      transform: translateX(-50%);
      opacity: 0;
    }

    .menu li a:hover {
      color: var(--primary-color);
      background: rgba(0, 61, 121, 0.04);
    }

    .menu li a:hover::after {
      width: 80%;
      opacity: 1;
      bottom: 5px; /* 線條稍微上移 */
    }

    /* 漢堡選單按鈕 */
    .hamburger {
      display: none;
      flex-direction: column;
      justify-content: center;
      gap: 5px;
      cursor: pointer;
      width: 40px;
      height: 40px;
      padding: 8px;
      border-radius: 50%;
      transition: background 0.3s;
    }

    .hamburger:hover {
      background: rgba(0,0,0,0.05);
    }

    .hamburger span {
      width: 22px;
      height: 2px;
      background: var(--primary-color);
      border-radius: 2px;
      transition: all 0.3s ease;
      align-self: center;
    }

    .hamburger.active span:nth-child(1) {
      transform: translateY(7px) rotate(45deg);
    }
    .hamburger.active span:nth-child(2) {
      opacity: 0;
    }
    .hamburger.active span:nth-child(3) {
      transform: translateY(-7px) rotate(-45deg);
    }

    /* 響應式設計 */
    @media (max-width: 900px) {
      .top-bar-container {
        justify-content: space-between; /* 手機版讓語言切換與聯絡分開 */
      }
      
      .top-bar-item span {
        display: none; /* 手機版只顯示圖示 */
      }
      
      .top-bar-item i {
        font-size: 1.2rem; /* 手機版圖示放大 */
      }

      .hamburger {
        display: flex;
      }

      /* 手機版選單 - 下拉式動畫 */
      .menu {
        position: absolute;
        top: var(--nav-height);
        left: 0;
        width: 100%;
        background: white;
        flex-direction: column;
        height: auto;
        /* 動畫屬性 */
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-top: 1px solid #eee;
      }

      .menu.active {
        max-height: 500px; /* 足夠容納所有選項的高度 */
      }

      .menu li {
        width: 100%;
        height: auto;
        border-bottom: 1px solid #f5f5f5;
        opacity: 0; /* 初始隱藏，用於進場動畫 */
        transform: translateY(-10px);
        transition: opacity 0.3s ease, transform 0.3s ease;
      }

      /* 讓選單項目依序出現 */
      .menu.active li {
        opacity: 1;
        transform: translateY(0);
      }
      
      /* 透過 delay 創造階梯效果 */
      .menu.active li:nth-child(1) { transition-delay: 0.1s; }
      .menu.active li:nth-child(2) { transition-delay: 0.15s; }
      .menu.active li:nth-child(3) { transition-delay: 0.2s; }
      .menu.active li:nth-child(4) { transition-delay: 0.25s; }
      .menu.active li:nth-child(5) { transition-delay: 0.3s; }
      .menu.active li:nth-child(6) { transition-delay: 0.35s; }
      .menu.active li:nth-child(7) { transition-delay: 0.4s; }

      .menu li a {
        padding: 1rem 1.5rem;
        width: 100%;
        justify-content: flex-start;
      }
      
      .menu li a:hover {
        background: #f8f9fa;
        color: var(--primary-color);
        padding-left: 2rem; /* Hover 時向右滑動一點 */
      }
      
      .menu li a::after {
        display: none; /* 手機版不顯示底部線條 */
      }
    }

    /* 內容區塊示例 (讓您看效果用) */
    .hero-section {
      padding: 4rem 1.5rem;
      text-align: center;
      max-width: 800px;
      margin: 2rem auto;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>

  <div class="gov-stripe"></div>
  
  <div class="top-bar">
    <div class="top-bar-container">
      <div style="display:flex; gap:1.5rem;">
        <a href="#" class="top-bar-item" title="聯絡我們">
          <i class="ri-phone-line"></i>
          <span>聯絡我們</span>
        </a>
        <a href="#" class="top-bar-item" title="常見問題">
          <i class="ri-question-line"></i>
          <span>常見問題</span>
        </a>
      </div>
      
      <div class="lang-switcher">
        <button class="lang-btn active" data-lang="zh">繁中</button>
        <button class="lang-btn" data-lang="en">EN</button>
      </div>
    </div>
  </div>

  <nav>
    <div class="nav-container">
      <a href="index.php" class="logo">
        <img src="image/LOGO.png" alt="誠訊集團 Logo" onerror="this.style.display='none'"/>
        <div class="logo-text-container">
          <span class="logo-text" data-zh="誠訊工作室" data-en="Chengxun Studio">誠訊工作室</span>
          <span class="logo-subtitle" data-zh="CHENGXUN GROUP" data-en="CHENGXUN GROUP">CHENGXUN GROUP</span>
        </div>
      </a>

      <div class="hamburger" id="hamburger">
        <span></span><span></span><span></span>
      </div>

      <ul class="menu" id="menu">
        <li><a href="index.php" data-zh="產品服務" data-en="Products"><i class="ri-box-3-line"></i> 產品服務</a></li>
        <li><a href="announcement.php" data-zh="官方公告" data-en="Announcements"><i class="ri-notification-3-line"></i> 官方公告</a></li>
        <li><a href="travel.php" data-zh="金融旅遊" data-en="Finance & Travel"><i class="ri-plane-line"></i> 金融旅遊</a></li>
        <li><a href="National Travel Congress.php" data-zh="國旅大會" data-en="NCT Congress"><i class="ri-flag-line"></i> 國旅大會</a></li>
        <li><a href="/employeeS/index.php" data-zh="部門專區" data-en="Internal"><i class="ri-lock-2-line"></i> 部門專區</a></li>
        <li><a href="about us.php" data-zh="關於團隊" data-en="About Us"><i class="ri-team-line"></i> 關於團隊</a></li>
        <li><a href="http://chengxun.ddns.net:3000/aidisclution" data-zh="AI 服務" data-en="AI Services"><i class="ri-openai-line"></i> AI 服務</a></li>
      </ul>
    </div>
  </nav>

 

  <script>
    // 漢堡選單邏輯
    const hamburger = document.getElementById("hamburger");
    const menu = document.getElementById("menu");

    hamburger.addEventListener("click", (e) => {
      e.stopPropagation(); // 防止冒泡
      menu.classList.toggle("active");
      hamburger.classList.toggle("active");
    });

    // 點擊頁面其他地方關閉選單
    document.addEventListener("click", (e) => {
      if (!menu.contains(e.target) && !hamburger.contains(e.target)) {
        menu.classList.remove("active");
        hamburger.classList.remove("active");
      }
    });

    // 視窗變大時自動重置
    window.addEventListener("resize", () => {
      if (window.innerWidth > 900) {
        menu.classList.remove("active");
        hamburger.classList.remove("active");
      }
    });

    // 語言切換邏輯
    const langBtns = document.querySelectorAll('.lang-btn');
    const translatableElements = document.querySelectorAll('[data-zh][data-en]');

    function switchLanguage(lang) {
      // 1. 更新按鈕樣式
      langBtns.forEach(btn => {
        if (btn.dataset.lang === lang) {
          btn.classList.add('active');
        } else {
          btn.classList.remove('active');
        }
      });

      // 2. 更新文字內容 (加入簡單的淡入效果)
      translatableElements.forEach(el => {
        el.style.opacity = '0.5';
        setTimeout(() => {
          // 只替換文字節點，保留圖標 (<i> tag)
          // 這裡我們需要小心處理，因為裡面可能有圖標
          const icon = el.querySelector('i');
          const textZh = el.dataset.zh;
          const textEn = el.dataset.en;
          
          if (icon) {
            // 如果有圖標，保留圖標並更新後面的文字
            el.innerHTML = '';
            el.appendChild(icon);
            el.append(lang === 'zh' ? ' ' + textZh : ' ' + textEn);
          } else {
            // 純文字
            el.textContent = lang === 'zh' ? textZh : textEn;
          }
          el.style.opacity = '1';
        }, 150);
      });

      document.documentElement.lang = lang === 'zh' ? 'zh-Hant' : 'en';
    }

    langBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        switchLanguage(btn.dataset.lang);
      });
    });
  </script>
</body>
</html>
