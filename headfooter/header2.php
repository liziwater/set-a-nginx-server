<?php
$pageTitle = "誠訊e-IMS[李子杰ims]";
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link rel="icon" href="image/LOGO.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', system-ui, sans-serif;
      background: #fff;
    }

    header {
      background: #fff;
      border-bottom: 1px solid #f0f0f0;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .header-container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 12px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .logo img {
      height: 40px;
      transition: transform 0.2s ease;
    }

    .logo:hover img {
      transform: scale(1.05);
    }

    /* 桌面導航 */
    .desktop-nav {
      display: flex;
      align-items: center;
    }

    .nav-list {
      display: flex;
      gap: 20px;
      list-style: none;
    }

    .nav-link {
      color: #444;
      text-decoration: none;
      font-weight: 500;
      padding: 8px 4px;
      position: relative;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s ease;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: #3498db;
      transition: width 0.3s ease;
    }

    .nav-link:hover::after {
      width: 100%;
    }

    .nav-link i {
      font-size: 1.1em;
      color: #666;
      transition: color 0.2s ease;
    }

    .nav-link:hover i {
      color: #3498db;
    }

    /* 下拉選單 */
    .dropdown {
      position: relative;
    }

    .dropdown-menu {
      position: absolute;
      top: 100%;
      left: 0;
      background: #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      border-radius: 6px;
      min-width: 200px;
      opacity: 0;
      visibility: hidden;
      transition: all 0.2s ease;
      z-index: 1000;
    }

    .dropdown:hover .dropdown-menu {
      opacity: 1;
      visibility: visible;
      transform: translateY(4px);
    }

    .dropdown-item {
      padding: 12px 16px;
      color: #444;
      display: block;
      transition: all 0.2s ease;
      position: relative;
    }

    .dropdown-item::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 16px;
      width: calc(100% - 32px);
      height: 1px;
      background: #f0f0f0;
    }

    .dropdown-item:last-child::after {
      display: none;
    }

    .dropdown-item:hover {
      background: #f8f8f8;
      padding-left: 20px;
    }

    /* 手機版選單 */
    .hamburger {
      display: none;
      background: none;
      border: none;
      padding: 8px;
      cursor: pointer;
      color: #444;
      z-index: 1001;
    }

    .mobile-menu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      padding: 12px 0;
    }

    .mobile-menu.show {
      display: block;
    }

    .mobile-nav-list {
      list-style: none;
    }

    .mobile-nav-item {
      border-bottom: 1px solid #f0f0f0;
    }

    .mobile-nav-link {
      padding: 14px 24px;
      color: #444;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 12px;
      transition: background 0.2s ease;
    }

    .mobile-nav-link i {
      width: 20px;
      text-align: center;
    }

    .mobile-nav-link:hover {
      background: #f8f8f8;
    }

    .mobile-dropdown-menu {
      display: none;
      background: #f8f8f8;
      padding-left: 20px;
    }

    .mobile-dropdown-menu.show {
      display: block;
    }

    @media (max-width: 1024px) {
      .nav-list {
        gap: 15px;
      }
    }

    @media (max-width: 768px) {
      .desktop-nav {
        display: none;
      }

      .hamburger {
        display: block;
      }

      .logo img {
        height: 36px;
      }

      .nav-link {
        padding: 8px 12px;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="header-container">
      <a href="home.php" class="logo">
        <img src="image/LOGO.png" alt="誠訊國際">
      </a>

      <nav class="desktop-nav">
        <ul class="nav-list">
          <li><a href="home.php" class="nav-link"><i class="fas fa-home"></i>首頁</a></li>
          <li><a href="404error.php" class="nav-link"><i class="fas fa-bullhorn"></i>公告</a></li>
          <li><a href="product.php" class="nav-link"><i class="fas fa-book"></i>產品</a></li>
          <li><a href="videos.php" class="nav-link"><i class="fa-brands fa-youtube"></i>MCX</a></li>
          <li><a href="National Travel Congress.php" class="nav-link"><i class="fa-brands fa-nfc-symbol"></i>NTC</a></li>
          <li><a href="about1.php" class="nav-link"><i class="fa-brands fa-nfc-symbol"></i>關於我們</a></li>
          <li class="dropdown">
            <a href="search.php" class="nav-link"><i class="fa-regular fa-credit-card"></i>代辦申請</a>
          </li>
          <li class="dropdown">
            <a href="#" class="nav-link"><i class="fas fa-ellipsis-h"></i>更多服務</a>
            <ul class="dropdown-menu">
              <li><a href="upload1.php" class="dropdown-item"><i class="fa-brands fa-creative-commons-pd"></i> 檔案管理系統</a></li>
              <li><a href="404error.php" class="dropdown-item"><i class="fas fa-phone"></i> 誠訊行通</a></li>
              <li><a href="404error.php" class="dropdown-item"><i class="fas fa-calendar-alt"></i> 學校</a></li>
              <li><a href="contract.php" class="dropdown-item"><i class="fas fa-book"></i> 客服</a></li>
              <li><a href="404error.php" class="dropdown-item"><i class="fas fa-handshake"></i> 合作</a></li>
            </ul>
          </li>
        </ul>
      </nav>

      <button class="hamburger"><i class="fas fa-bars"></i></button>
    </div>

    <!-- 手機版選單 -->
    <div class="mobile-menu">
      <ul class="mobile-nav-list">
        <li class="mobile-nav-item">
          <a href="home.php" class="mobile-nav-link"><i class="fas fa-home"></i>首頁</a>
        </li>
        <li class="mobile-nav-item">
          <a href="404error.php" class="mobile-nav-link"><i class="fas fa-bullhorn"></i>公告</a>
        </li>
        <li><a href="product.php" class="nav-link"><i class="fas fa-book"></i>產品</a></li>
        <li class="mobile-nav-item">
          <a href="videos.php" class="mobile-nav-link"><i class="fa-brands fa-youtube"></i>MCX</a>
        </li>
        <li class="mobile-nav-item">
          <a href="National Travel Congress.php" class="mobile-nav-link"><i class="fa-brands fa-nfc-symbol"></i>NTC</a>
        </li>
        <li><a href="about1.php" class="nav-link"><i class="fa-brands fa-nfc-symbol"></i>關於我們</a></li>
        <li class="mobile-nav-item">
          <a href="search.php" class="mobile-nav-link"><i class="fa-regular fa-credit-card"></i>代辦申請</a>
        </li>
        <li class="dropdown">
            <a href="#" class="nav-link"><i class="fas fa-ellipsis-h"></i>更多服務</a>
            <ul class="dropdown-menu">
              <li><a href="upload1.php" class="dropdown-item"><i class="fa-brands fa-creative-commons-pd"></i> 檔案管理系統</a></li>
              <li><a href="404error.php" class="dropdown-item"><i class="fas fa-phone"></i> 誠訊行通</a></li>
              <li><a href="404error.php" class="dropdown-item"><i class="fas fa-calendar-alt"></i> 學校</a></li>
              <li><a href="contract.php" class="dropdown-item"><i class="fas fa-book"></i> 客服</a></li>
              <li><a href="404error.php" class="dropdown-item"><i class="fas fa-handshake"></i> 合作</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </header>

  <script>
    // 手機選單切換
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    const mobileDropdowns = document.querySelectorAll('.mobile-nav-item.dropdown');

    hamburger.addEventListener('click', () => {
      mobileMenu.classList.toggle('show');
      hamburger.classList.toggle('active');
    });

    // 手機版下拉選單
    mobileDropdowns.forEach(item => {
      const link = item.querySelector('.mobile-nav-link');
      const menu = item.querySelector('.mobile-dropdown-menu');

      link.addEventListener('click', (e) => {
        e.preventDefault();
        menu.classList.toggle('show');
      });
    });

    // 點擊外部關閉選單
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.header-container')) {
        mobileMenu.classList.remove('show');
        hamburger.classList.remove('active');
        document.querySelectorAll('.mobile-dropdown-menu').forEach(menu => {
          menu.classList.remove('show');
        });
      }
    });
  </script>
</body>
</html>