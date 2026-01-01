<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>誠訊e-IMS[李子杰ims]</title>
    <link rel="icon" href="image/LOGO.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* 基本重置 */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Noto Sans TC', sans-serif; background-color: #f8f9fa; color: #333; } /* 使用更友好的字體和背景色 */

        header { background: #fff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); } /* 添加陰影效果 */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }
        .logo img { max-height: 60px; } /* 稍微放大 logo */
        nav .nav-list {
            list-style: none;
            display: flex;
            align-items: center;
        }
        nav .nav-list li { margin-left: 15px; position: relative; }
        nav .nav-list li a {
            text-decoration: none;
            color: #333;
            padding: 10px 15px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        nav .nav-list li a:hover {
            background-color: #e9ecef;
            transform: translateY(-2px); /* 輕微上移效果 */
        }
        nav .nav-list li a i { margin-right: 5px; } /* 圖標與文字間距 */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #fff;
            list-style: none;
            min-width: 180px;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            border-radius: 5px;
        }
        .dropdown:hover .dropdown-menu { display: block; }
        .dropdown-menu li a { padding: 12px 18px; }

        .hamburger { display: none; font-size: 24px; cursor: pointer; color: #333; }
        .mobile-menu { display: none; background: #fff; }
        .mobile-menu.show { display: block; }
        .mobile-menu .mobile-logo { text-align: center; padding: 15px 0; }
        .mobile-menu .mobile-logo img { max-height: 60px; }
        .mobile-nav-list { list-style: none; }
        .mobile-nav-list li { border-bottom: 1px solid #f0f0f0; }
        .mobile-nav-list li a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s ease;
        }
        .mobile-nav-list li a:hover { background-color: #e9ecef; }
        .mobile-nav-list .dropdown .dropdown-menu { display: none; background: #f9f9f9; }
        .mobile-nav-list .dropdown.active .dropdown-menu { display: block; }

        @media (max-width: 768px) {
            nav, .logo { display: none; }
            .hamburger { display: block; padding: 15px 20px; }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="image/LOGO.png" alt="Company Logo">
            </div>
            <nav>
                <ul class="nav-list">
                    <li><a href="home.php"><i class="fas fa-home"></i> 首頁</a></li>
                    <li><a href="404error.php"><i class="fas fa-bullhorn"></i> 公告</a></li>
                    <li><a href="videos.php"><i class="fa-brands fa-youtube"></i> MCX</a></li>
                    <li><a href="National Travel Congress.php"><i class="fa-brands fa-nfc-symbol"></i> NTC</a></li>
                    <li><a href="search.php"><i class="fa-regular fa-credit-card"></i> 代辦申請</a></li>
                    <li><a href="404error.php"><i class="fas fa-plane"></i> 金融旅遊</a></li>
                    <li><a href="404error.php"><i class="fas fa-user"></i> 員工專區</a></li>
                    <li><a href="https://you-are-ugly.webnode.tw/#"><i class="fa-solid fa-handshake"></i> 東洋全方位</a></li>
                    <li><a href="about1.php"><i class="fas fa-info-circle"></i> 關於誠訊</a></li>
                    <li class="dropdown">
                        <a href="#" class="more"><i class="fas fa-ellipsis-h"></i> 更多服務 <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="404errer.php"><i class="fa-brands fa-creative-commons-pd"></i> 高級管理</a></li>
                            <li><a href="404error.php"><i class="fas fa-phone"></i> 誠訊行通</a></li>
                            <li><a href="404error.php"><i class="fas fa-calendar-alt"></i> 學校</a></li>
                            <li><a href="contract.php"><i class="fas fa-book"></i> 客服</a></li>
                            <li><a href="404error.php"><i class="fas fa-handshake"></i> 合作</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div class="hamburger"><i class="fas fa-bars"></i></div>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <div class="mobile-logo">
                <img src="image/GIF.gif" alt="Company Logo">
            </div>
            <ul class="mobile-nav-list">
                <li><a href="home.php"><i class="fas fa-home"></i> 首頁</a></li>
                <li><a href="404error.php"><i class="fas fa-bullhorn"></i> 公告</a></li>
                <li><a href="videos.php"><i class="fa-brands fa-youtube"></i> MCX</a></li>
                <li><a href="National Travel Congress.php"><i class="fa-brands fa-nfc-symbol"></i> NTC</a></li>
                <li><a href="search.php"><i class="fa-regular fa-credit-card"></i> 代辦申請</a></li>
                <li><a href="404error.php"><i class="fas fa-plane"></i> 金融旅遊</a></li>
                <li><a href="404error.php"><i class="fa-brands fa-stripe-s"></i> 產品</a></li>
                <li><a href="https://you-are-ugly.webnode.tw/#"><i class="fa-solid fa-handshake"></i> 東洋全方位</a></li>
                <li class="dropdown">
                <a href="#" class="more"><i class="fas fa-ellipsis-h"></i> 更多服務 <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="404error.php"><i class="fa-brands fa-creative-commons-pd"></i> 高級管理</a></li>
                        <li><a href="404error.php"><i class="fas fa-headset"></i> 誠訊行通</a></li>
                        <li><a href="404error.php"><i class="fas fa-calendar-alt"></i> 學校</a></li>
                        <li><a href="404error.php"><i class="fas fa-book"></i> 客服</a></li>
                        <li><a href="404error.php"><i class="fas fa-handshake"></i> 合作</a></li>
                    </ul>
                </li>
                <li><a href="about1.php"><i class="fas fa-info-circle"></i> 關於誠訊</a></li>
            </ul>
        </div>
    </header>

    <main>
        </main>

    <script>
        // 漢堡點擊切換手機下拉選單
        const hamburger = document.querySelector('.hamburger');
        const mobileMenu = document.getElementById('mobileMenu');
        hamburger.addEventListener('click', () => {
            mobileMenu.classList.toggle('show');
        });

        // 手機版「更多服務」點擊展開下拉
        const mobileDropdown = mobileMenu.querySelector('.dropdown');
        const mobileDropdownLink = mobileDropdown.querySelector('.more');
        mobileDropdownLink.addEventListener('click', (e) => {
            e.preventDefault();
            mobileDropdown.classList.toggle('active');
        });
    </script>
</body>
</html>