<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>專業導覽列</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* 主要導覽列容器 */
        .navbar-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* 導覽列內容 */
        .navbar {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            height: 70px;
        }

        /* Logo 區域 */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo img {
            height: 45px;
            width: auto;
            border-radius: 8px;
        }

        .logo-text {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        /* 導覽選單 */
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            align-items: center;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        /* 英文簡稱樣式 */
        .nav-abbr {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 700;
            color: white;
            margin-right: 8px;
        }

        /* 下拉選單 */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            min-width: 200px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            margin-top: 10px;
            padding: 8px 0;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            margin-top: 5px;
        }

        .dropdown-menu li {
            list-style: none;
        }

        .dropdown-menu .nav-link {
            color: #333;
            padding: 12px 20px;
            font-weight: 500;
            border-radius: 0;
        }

        .dropdown-menu .nav-link:hover {
            background: #f8f9fa;
            color: #667eea;
            transform: none;
        }

        .dropdown-menu .nav-abbr {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        /* 下拉箭頭 */
        .dropdown-arrow {
            font-size: 0.8rem;
            margin-left: 4px;
            transition: transform 0.3s ease;
        }

        .dropdown:hover .dropdown-arrow {
            transform: rotate(180deg);
        }

        /* 手機版選單按鈕 */
        .mobile-menu-btn {
            display: none;
            flex-direction: column;
            gap: 4px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }

        .mobile-menu-btn span {
            width: 25px;
            height: 3px;
            background: white;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* 響應式設計 */
        @media (max-width: 1024px) {
            .navbar {
                padding: 0 1rem;
            }
            
            .nav-menu {
                gap: 0.2rem;
            }
            
            .nav-link {
                padding: 10px 16px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: flex;
            }

            .nav-menu {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: rgba(102, 126, 234, 0.98);
                backdrop-filter: blur(10px);
                flex-direction: column;
                gap: 0;
                padding: 1rem 0;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-20px);
                transition: all 0.3s ease;
            }

            .nav-menu.active {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            .nav-item {
                width: 100%;
            }

            .nav-link {
                justify-content: center;
                padding: 15px 20px;
                margin: 0 1rem;
                border-radius: 8px;
            }

            .dropdown-menu {
                position: static;
                transform: none;
                box-shadow: none;
                background: rgba(255, 255, 255, 0.1);
                margin: 0;
                border-radius: 8px;
                margin-top: 8px;
            }

            .dropdown-menu .nav-link {
                color: rgba(255, 255, 255, 0.9);
                padding-left: 40px;
            }

            .dropdown-menu .nav-abbr {
                background: rgba(255, 255, 255, 0.2);
                color: white;
            }
        }
    </style>
</head>
<body>
    <!-- 專業導覽列 -->
    <nav class="navbar-container">
        <div class="navbar">
            <!-- Logo 區域 -->
            <div class="logo">
                <img src="image/GIF.gif" alt="Company Logo">
                <span class="logo-text">公司名稱</span>
            </div>

            <!-- 導覽選單 -->
            <ul class="nav-menu" id="navMenu">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <span class="nav-abbr">H</span>
                        <span>首頁</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="404error.php" class="nav-link">
                        <span class="nav-abbr">N</span>
                        <span>公告</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="youtube.php" class="nav-link">
                        <span class="nav-abbr">A</span>
                        <span>代辦申請</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="National Travel Congress.php" class="nav-link">
                        <span class="nav-abbr">F</span>
                        <span>金融旅遊</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="National Travel Congress.php" class="nav-link">
                        <span class="nav-abbr">NTC</span>
                        <span>國旅大會NCT</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="login.php" class="nav-link">
                        <span class="nav-abbr">E</span>
                        <span>員工專區</span>
                    </a>
                </li>
                
                <!-- 下拉選單 -->
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link">
                        <span class="nav-abbr">M</span>
                        <span>更多服務</span>
                        <span class="dropdown-arrow">▼</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="chatroom.php" class="nav-link">
                            <span class="nav-abbr">C</span> 討論區
                        </a></li>
                        <li><a href="customer_service.php" class="nav-link">
                            <span class="nav-abbr">CS</span> 客服中心
                        </a></li>
                        <li><a href="latest_events.php" class="nav-link">
                            <span class="nav-abbr">E</span> 最新活動
                        </a></li>
                        <li><a href="case_studies.php" class="nav-link">
                            <span class="nav-abbr">SC</span> 成功案例
                        </a></li>
                        <li><a href="partners.php" class="nav-link">
                            <span class="nav-abbr">P</span> 合作夥伴
                        </a></li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a href="about.php" class="nav-link">
                        <span class="nav-abbr">AB</span>
                        <span>關於我們</span>
                    </a>
                </li>
            </ul>

            <!-- 手機版選單按鈕 -->
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <script>
        // 手機版選單切換
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navMenu = document.getElementById('navMenu');

        mobileMenuBtn.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            
            // 動畫效果
            const spans = mobileMenuBtn.querySelectorAll('span');
            if (navMenu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(6px, 6px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(6px, -6px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        // 點擊外部關閉手機版選單
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.navbar')) {
                navMenu.classList.remove('active');
                const spans = mobileMenuBtn.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        // 視窗大小改變時處理選單
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                navMenu.classList.remove('active');
                const spans = mobileMenuBtn.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        // 防止下拉選單點擊時跳轉
        document.querySelector('.dropdown > .nav-link').addEventListener('click', function(e) {
            e.preventDefault();
        });
    </script>
</body>
</html>