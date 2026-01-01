<?php
// 保持原有的 header 引用
include 'headfooter/header4.php';
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>誠訊集團｜跨域數位轉型專家</title>
    <meta name="description" content="誠訊集團專注於跨領域數位轉型，提供企業解決方案、系統開發、雲端服務與 AI 應用。">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            /* 核心色系：沈穩專業 */
            --primary-bg: #ffffff;
            --secondary-bg: #f5f5f7;
            --text-main: #1d1d1f;
            --text-sub: #86868b;
            --accent-blue: #0071e3;
            --accent-hover: #0077ED;
            
            /* 各領域代表色 */
            --c-info: #007aff;
            --c-business: #ff9500;
            --c-eco: #34c759;
            --c-customer: #af52de;
            --c-marketing: #ff3b30;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: var(--text-main);
            background-color: var(--primary-bg);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden; /* 防止橫向卷軸 */
        }
        
        /* 鎖定 Body 捲動 (用於 Intro 顯示時) */
        body.locked { overflow: hidden; }

        /* --- 通用樣式 --- */
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .section { padding: 120px 0; }
        .text-center { text-align: center; }

        /* 按鈕樣式 */
        .btn {
            display: inline-block;
            padding: 14px 30px;
            border-radius: 980px;
            font-weight: 600;
            font-size: 17px;
            transition: all 0.3s cubic-bezier(0.25, 0.1, 0.25, 1);
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: var(--text-main);
            color: white;
            border: 1px solid var(--text-main);
        }
        .btn-primary:hover {
            background: #333;
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .btn-outline {
            background: transparent;
            color: var(--accent-blue);
            border: 1px solid var(--accent-blue);
        }
        .btn-outline:hover { background: rgba(0, 113, 227, 0.1); }

        /* --- 1. 動畫門面 (Intro Overlay) - 新增功能 --- */
        #intro-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, #000000 0%, #1d1d1f 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: transform 0.8s cubic-bezier(0.77, 0, 0.175, 1);
            color: white;
        }
        #intro-overlay.hide { transform: translateY(-100%); }

        .intro-content h1 {
            font-size: clamp(2rem, 5vw, 4rem);
            margin-bottom: 30px;
            overflow: hidden;
            border-right: .15em solid var(--accent-blue);
            white-space: nowrap;
            animation: typing 2.5s steps(40, end), blink-caret .75s step-end infinite;
        }
        .intro-btn {
            padding: 15px 50px;
            font-size: 1.2rem;
            background: var(--accent-blue);
            color: white;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            opacity: 0;
            animation: fadeIn 1s ease 2.5s forwards; /* 文字打完後才顯示按鈕 */
            transition: transform 0.2s, background 0.2s;
        }
        .intro-btn:hover { transform: scale(1.05); background: var(--accent-hover); }

        /* --- Hero 區塊 --- */
        .hero {
            height: 100vh;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: radial-gradient(circle at 50% 0%, #fbfbfd 0%, #ffffff 100%);
            position: relative;
        }
        .hero-content {
            z-index: 2;
            opacity: 0;
            animation: fadeInUp 1s ease 0.8s forwards; /* 延遲動畫配合 Intro */
            max-width: 800px;
            padding: 0 20px;
        }
        .hero-badge {
            font-size: 14px; font-weight: 600; letter-spacing: 0.1em;
            color: var(--text-sub); text-transform: uppercase;
            margin-bottom: 16px; display: block;
        }
        .hero h1 {
            font-size: clamp(3rem, 6vw, 5rem);
            font-weight: 800; line-height: 1.05; letter-spacing: -0.015em;
            margin-bottom: 24px; color: var(--text-main);
        }
        .gradient-text {
            background: linear-gradient(90deg, #0071e3 0%, #34c759 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero p {
            font-size: 1.3rem; color: var(--text-sub);
            max-width: 600px; margin: 0 auto 40px; font-weight: 400;
        }
        .hero-btns { display: flex; gap: 16px; justify-content: center; }
        .scroll-hint {
            position: absolute; bottom: 40px; left: 50%;
            transform: translateX(-50%); animation: bounce 2s infinite; opacity: 0.5;
        }

        /* --- 2. 互動儀表板 (Weather & Game) - 新增功能 --- */
        .dashboard-section { background: var(--secondary-bg); padding: 80px 0; }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }
        .dash-card {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            overflow: hidden;
            position: relative;
        }
        .dash-card:hover { transform: translateY(-5px); }
        .dash-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .dash-header h3 { font-size: 1.5rem; font-weight: 700; }
        .location-tag { background: var(--accent-blue); color: white; padding: 4px 12px; border-radius: 12px; font-size: 0.8rem; }
        
        /* 天氣樣式 */
        .weather-info { text-align: center; }
        .weather-icon { font-size: 4rem; margin: 10px 0; animation: float 3s ease-in-out infinite; }
        .temp-display { font-size: 2.5rem; font-weight: 700; color: var(--text-main); }
        .weather-detail { color: var(--text-sub); font-size: 1.1rem; margin-top: 5px; }
        .weather-meta { display: flex; justify-content: center; gap: 20px; margin-top: 20px; font-size: 0.9rem; color: #666; }

        /* 遊戲樣式 */
        #game-container { position: relative; width: 100%; height: 200px; background: #87CEEB; border-radius: 12px; overflow: hidden; cursor: pointer; }
        canvas { width: 100%; height: 100%; display: block; }
        .game-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4); display: flex; flex-direction: column;
            align-items: center; justify-content: center; color: white;
            transition: opacity 0.3s;
        }
        .game-overlay.playing { opacity: 0; pointer-events: none; }
        .game-msg { font-size: 1.2rem; font-weight: bold; margin-bottom: 10px; }
        .score-board { position: absolute; top: 10px; right: 10px; color: white; font-weight: bold; font-size: 1.2rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5); }

        /* --- 價值主張區塊 --- */
        .features { background-color: var(--primary-bg); }
        .section-header { margin-bottom: 60px; text-align: center; }
        .section-header h2 { font-size: 2.5rem; font-weight: 700; margin-bottom: 16px; }
        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; }
        .feature-card {
            background: var(--secondary-bg); padding: 40px; border-radius: 24px;
            transition: transform 0.3s; opacity: 0; transform: translateY(30px);
        }
        .feature-card.visible { opacity: 1; transform: translateY(0); }
        .feature-card:hover { transform: translateY(-10px); background: #f0f0f2; }
        .f-icon { font-size: 3rem; margin-bottom: 24px; display: inline-block; }

        /* --- 服務氣泡 --- */
        .services-section { background: var(--secondary-bg); }
        .bubble-container { display: flex; flex-wrap: wrap; justify-content: center; gap: 40px; max-width: 1000px; margin: 60px auto 0; }
        .bubble {
            width: 160px; height: 160px; border-radius: 50%; background: white;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(0,0,0,0.05);
        }
        .bubble:hover { transform: scale(1.1); box-shadow: 0 15px 35px rgba(0,0,0,0.1); z-index: 10; }
        /* 氣泡顏色 */
        .bubble[data-type="info"]:hover { color: var(--c-info); border-color: var(--c-info); }
        .bubble[data-type="business"]:hover { color: var(--c-business); border-color: var(--c-business); }
        .bubble[data-type="eco"]:hover { color: var(--c-eco); border-color: var(--c-eco); }
        .bubble[data-type="customer"]:hover { color: var(--c-customer); border-color: var(--c-customer); }
        .bubble[data-type="marketing"]:hover { color: var(--c-marketing); border-color: var(--c-marketing); }
        .bubble-icon { font-size: 2.5rem; margin-bottom: 8px; }
        .bubble-text { font-size: 1rem; font-weight: 600; }

        /* --- 聯絡區塊 & Footer --- */
        .contact-section { background: #1d1d1f; color: white; padding: 100px 20px; text-align: center; }
        .contact-grid { display: flex; justify-content: center; gap: 40px; margin: 40px 0; flex-wrap: wrap; }
        .contact-item { background: rgba(255,255,255,0.1); padding: 20px 40px; border-radius: 12px; backdrop-filter: blur(10px); }
        .contact-item a { color: white; font-weight: 600; font-size: 1.1rem; }
        footer { background: #1d1d1f; color: #86868b; padding: 40px 0; text-align: center; border-top: 1px solid #333; font-size: 0.9rem; }

        /* --- Modal --- */
        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.4); backdrop-filter: blur(8px);
            z-index: 1000; display: flex; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: all 0.3s ease;
        }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        .modal-card {
            background: white; width: 90%; max-width: 600px; padding: 50px;
            border-radius: 24px; box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            transform: scale(0.9); transition: transform 0.3s; position: relative;
        }
        .modal-overlay.active .modal-card { transform: scale(1); }
        .close-modal { position: absolute; top: 20px; right: 20px; width: 36px; height: 36px; background: #f5f5f7; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s; }
        .close-modal:hover { background: #e5e5e5; }
        .modal-title { font-size: 2rem; font-weight: 700; margin-bottom: 16px; color: var(--text-main); }
        .modal-tags { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }
        .tag { padding: 6px 14px; background: var(--secondary-bg); border-radius: 6px; font-size: 0.85rem; color: var(--text-main); }

        /* Animations */
        @keyframes typing { from { width: 0 } to { width: 100% } }
        @keyframes blink-caret { from, to { border-color: transparent } 50% { border-color: var(--accent-blue) } }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes bounce { 0%, 20%, 50%, 80%, 100% {transform: translate(-50%, 0);} 40% {transform: translate(-50%, -10px);} 60% {transform: translate(-50%, -5px);} }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0px); } }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .section { padding: 80px 0; }
            .feature-grid, .dashboard-grid { grid-template-columns: 1fr; }
            .intro-content h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body class="locked">

    <div id="intro-overlay">
        <div class="intro-content">
            <h1>ChengXun Studio Innovation</h1>
            <h1>誠訊工作室</h1>
        </div>
        <button class="intro-btn" onclick="enterSite()">進入系統</button>
    </div>

    <header class="hero">
        <div class="hero-content">
            <span class="hero-badge">誠訊集團 ChengXun Group</span>
            <h1>數位轉型 <br><span class="gradient-text">跨域整合專家</span></h1>
            <p>我們不只是系統開發商，更是您的商業策略夥伴。從資訊架構到永續生態，為企業打造全方位的成長引擎。</p>
            <div class="hero-btns">
                <a href="#dashboard" class="btn btn-primary">體驗功能</a>
                <a href="#contact" class="btn btn-outline">聯繫我們</a>
            </div>
        </div>
        <div class="scroll-hint">↓</div>
    </header>

    <main>
        <section id="dashboard" class="dashboard-section">
            <div class="container">
                <div class="section-header">
                    <h2>實時資訊與互動</h2>
                    <p>結合 CWA 氣象資料串接與 HTML5 Canvas 技術展示</p>
                </div>
                <div class="dashboard-grid">
                    <div class="dash-card">
                        <div class="dash-header">
                            <h3>🌤️ 城市天氣</h3>
                            <span class="location-tag">臺南市</span>
                        </div>
                        <div class="weather-info" id="weather-box">
                            <div class="weather-icon" id="w-icon">⌛</div>
                            <div class="temp-display" id="w-temp">--°C</div>
                            <div class="weather-detail" id="w-desc">正在連線氣象局 API...</div>
                            <div class="weather-meta">
                                <span id="w-pop">💧 降雨: --%</span>
                            </div>
                        </div>
                        <div style="text-align: center; margin-top: 15px;">
                             <small style="color: #ccc; font-size: 0.7rem;">Data Source: CWA OpenData</small>
                        </div>
                    </div>

                    <div class="dash-card">
                        <div class="dash-header">
                            <h3>🎮 晴天娃娃大冒險</h3>
                            <span class="location-tag" style="background:#ff9500;">Mini Game</span>
                        </div>
                        <p style="margin-bottom:10px; color:#666; font-size:0.9rem;">點擊畫面跳躍，躲避烏雲！</p>
                        <div id="game-container" onclick="handleGameClick()">
                            <canvas id="game-canvas" width="400" height="200"></canvas>
                            <div id="game-overlay" class="game-overlay">
                                <div class="game-msg" id="game-start-msg">點擊開始遊戲</div>
                                <div class="btn btn-primary" style="font-size:0.8rem; padding: 8px 16px;">Start</div>
                            </div>
                            <div class="score-board">Score: <span id="score">0</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section features">
            <div class="container">
                <div class="section-header">
                    <h2>化繁為簡的專業力量</h2>
                    <p>我們整合三大核心能力，協助您在複雜的市場中脫穎而出</p>
                </div>
                <div class="feature-grid">
                    <div class="feature-card">
                        <span class="f-icon">🚀</span>
                        <h3>技術驅動</h3>
                        <p>運用 PHP, Python 與雲端技術，建構穩定且可擴充的數位系統。</p>
                    </div>
                    <div class="feature-card">
                        <span class="f-icon">💡</span>
                        <h3>策略思維</h3>
                        <p>結合財務分析與商業邏輯，確保每一項技術投資都能帶來實質獲利。</p>
                    </div>
                    <div class="feature-card">
                        <span class="f-icon">🌿</span>
                        <h3>永續共榮</h3>
                        <p>將生態保育理念融入商業模式，協助企業進行綠色轉型。</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="services" class="services-section section">
            <div class="container text-center">
                <div class="section-header">
                    <h2>全方位解決方案</h2>
                    <p>點擊下方圖標，探索我們的五大服務領域</p>
                </div>
                <div class="bubble-container">
                    <div class="bubble" data-type="info" onclick="openModal('info')">
                        <span class="bubble-icon">💻</span>
                        <span class="bubble-text">資訊整合</span>
                    </div>
                    <div class="bubble" data-type="business" onclick="openModal('business')">
                        <span class="bubble-icon">📊</span>
                        <span class="bubble-text">商業指導</span>
                    </div>
                    <div class="bubble" data-type="eco" onclick="openModal('eco')">
                        <span class="bubble-icon">🌱</span>
                        <span class="bubble-text">生態保育</span>
                    </div>
                    <div class="bubble" data-type="customer" onclick="openModal('customer')">
                        <span class="bubble-icon">🎧</span>
                        <span class="bubble-text">客服需求</span>
                    </div>
                    <div class="bubble" data-type="marketing" onclick="openModal('marketing')">
                        <span class="bubble-icon">📈</span>
                        <span class="bubble-text">流量行銷</span>
                    </div>
                </div>
                <div style="margin-top: 30px; color: #999; font-size: 0.8rem;">由誠訊控股提供技術支持</div>
            </div>
        </section>

        <section id="contact" class="contact-section">
            <div class="container">
                <h2>準備好開始轉型了嗎？</h2>
                <p>無論您的需求是系統開發、商業諮詢還是行銷推廣，誠訊團隊隨時準備為您服務。</p>
                <div class="contact-grid">
                    <div class="contact-item">
                        <span style="display:block; font-size:0.9rem; color:#86868b; margin-bottom:5px;">Email Us</span>
                        <a href="mailto:chengxun.llc@gmail.com">chengxun.llc@gmail.com</a>
                    </div>
                    <div class="contact-item">
                        <span style="display:block; font-size:0.9rem; color:#86868b; margin-bottom:5px;">Visit Website</span>
                        <a href="https://chengxun.ddns.net/" target="_blank">chengxun.ddns.net</a>
                    </div>
                </div>
                <a href="mailto:chengxun.llc@gmail.com" class="btn btn-primary" style="background: white; color: #1d1d1f; border:none;">立即專案諮詢</a>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 誠訊集團 ChengXun Group. All Rights Reserved.</p>
        </div>
    </footer>

    <div class="modal-overlay" id="serviceModal">
        <div class="modal-card">
            <div class="close-modal" onclick="closeModal()">×</div>
            <h3 class="modal-title" id="m-title">標題</h3>
            <p style="line-height:1.6; color:var(--text-sub); margin-bottom:20px;" id="m-desc">內容描述...</p>
            <div class="modal-tags" id="m-tags"></div>
            <div style="margin-top: 30px; text-align: right;">
                <a href="#contact" onclick="closeModal()" class="btn btn-primary" style="font-size: 0.9rem; padding: 10px 24px;">諮詢此服務</a>
            </div>
        </div>
    </div>

    <script>
        // --- 1. 門面動畫邏輯 ---
        function enterSite() {
            const overlay = document.getElementById('intro-overlay');
            overlay.classList.add('hide');
            document.body.classList.remove('locked');
            
            // 進入後觸發天氣載入
            fetchWeather();
        }

        // --- 2. CWA 氣象資料串接 (臺南市) ---
        const API_KEY = 'CWA-164022DC-DCCC-4921-9B36-1B0AD3D95BF9';
        const API_URL = `https://opendata.cwa.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=${API_KEY}&locationName=臺南市&format=JSON`;

        async function fetchWeather() {
            try {
                const response = await fetch(API_URL);
                const data = await response.json();
                
                const locationData = data.records.location[0];
                const weatherElements = locationData.weatherElement;

                // 解析資料 (Wx:現象, PoP:降雨機率, MinT:最低溫, MaxT:最高溫)
                const wx = weatherElements.find(e => e.elementName === 'Wx').time[0].parameter.parameterName;
                const pop = weatherElements.find(e => e.elementName === 'PoP').time[0].parameter.parameterName;
                const minT = weatherElements.find(e => e.elementName === 'MinT').time[0].parameter.parameterName;
                const maxT = weatherElements.find(e => e.elementName === 'MaxT').time[0].parameter.parameterName;

                // 更新 DOM
                document.getElementById('w-desc').innerText = wx;
                document.getElementById('w-pop').innerText = `💧 降雨機率: ${pop}%`;
                document.getElementById('w-temp').innerText = `${minT}°C - ${maxT}°C`;

                // 圖示判斷
                const iconDiv = document.getElementById('w-icon');
                if (wx.includes('晴')) iconDiv.innerText = '☀️';
                else if (wx.includes('雨')) iconDiv.innerText = '🌧️';
                else if (wx.includes('雲') || wx.includes('陰')) iconDiv.innerText = '☁️';
                else iconDiv.innerText = '🌤️';

            } catch (error) {
                console.error('API Error:', error);
                document.getElementById('w-desc').innerText = "暫時無法取得天氣";
            }
        }

        // --- 3. 小遊戲邏輯 (Canvas) ---
        const canvas = document.getElementById('game-canvas');
        const ctx = canvas.getContext('2d');
        const overlay = document.getElementById('game-overlay');
        const scoreEl = document.getElementById('score');

        let isPlaying = false;
        let gameLoopId;
        let score = 0;
        let frame = 0;

        // 遊戲參數
        const player = { x: 50, y: 150, width: 30, height: 30, dy: 0, jumpPower: -8, gravity: 0.4, grounded: true };
        let obstacles = [];

        function handleGameClick() {
            if (!isPlaying) {
                startGame();
            } else {
                jump();
            }
        }

        function startGame() {
            isPlaying = true;
            score = 0;
            obstacles = [];
            player.y = 150;
            player.dy = 0;
            overlay.classList.add('playing');
            scoreEl.innerText = score;
            gameLoop();
        }

        function jump() {
            if (player.grounded) {
                player.dy = player.jumpPower;
                player.grounded = false;
            }
        }

        function gameLoop() {
            if (!isPlaying) return;

            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // 地板
            ctx.fillStyle = "#654321";
            ctx.fillRect(0, 180, canvas.width, 20);

            // 玩家 (晴天娃娃)
            player.dy += player.gravity;
            player.y += player.dy;

            if (player.y > 150) { // 地板高度
                player.y = 150;
                player.grounded = true;
                player.dy = 0;
            }

            ctx.font = "30px Arial";
            ctx.fillText("🌞", player.x, player.y + 25);

            // 障礙物 (烏雲)
            if (frame % 100 === 0 || Math.random() < 0.005) {
               if(obstacles.length === 0 || canvas.width - obstacles[obstacles.length-1].x > 150) {
                   obstacles.push({ x: canvas.width, y: 155, width: 30, height: 25 });
               }
            }

            obstacles.forEach((obs, index) => {
                obs.x -= 3 + (score * 0.05); // 隨分數變快
                ctx.fillText("☁️", obs.x, obs.y + 25);

                // 碰撞判定 (簡單矩形)
                if (player.x < obs.x + obs.width &&
                    player.x + player.width > obs.x &&
                    player.y < obs.y + obs.height &&
                    player.y + player.height > obs.y) {
                    endGame();
                }

                if (obs.x + obs.width < 0) {
                    obstacles.splice(index, 1);
                    score++;
                    scoreEl.innerText = score;
                }
            });

            frame++;
            gameLoopId = requestAnimationFrame(gameLoop);
        }

        function endGame() {
            isPlaying = false;
            cancelAnimationFrame(gameLoopId);
            overlay.classList.remove('playing');
            document.getElementById('game-start-msg').innerText = `Game Over! Score: ${score}`;
            document.querySelector('#game-overlay .btn').innerText = "Try Again";
        }

        // --- 4. Modal & 捲動特效 (原有功能) ---
        const servicesData = {
            info: {
                title: "資訊整合與系統開發",
                desc: "我們提供端到端的軟體開發服務，從基礎的網站建置到複雜的企業資源規劃(ERP)系統。專精於 PHP 後端開發與雲端架構部署。",
                tags: ["網站全端開發", "系統整合", "雲端伺服器架設", "API 串接"]
            },
            business: {
                title: "商業指導與財務顧問",
                desc: "透過專業的財務分析與風險評估，協助新創與中小企業建立健全的會計制度，優化營運流程。",
                tags: ["財務風險評估", "營運策略優化", "會計制度建立", "商業模式診斷"]
            },
            eco: {
                title: "生態保育與永續方案",
                desc: "致力於推動企業 ESG 轉型，提供生態友善的技術解決方案，達成環境永續。",
                tags: ["綠色轉型諮詢", "ESG 策略規劃", "生態監測技術"]
            },
            customer: {
                title: "專業客服體系建置",
                desc: "提供客服系統導入、流程標準化設計以及人員培訓建議，將客訴轉化為品牌忠誠度。",
                tags: ["客服系統導入", "SOP 流程設計", "CRM 管理"]
            },
            marketing: {
                title: "流量行銷與數據增長",
                desc: "運用數據驅動的行銷策略，從 SEO 到社群媒體經營，為您的品牌帶來實質的流量與轉換。",
                tags: ["SEO 優化", "數位廣告投放", "社群經營"]
            }
        };

        const modal = document.getElementById('serviceModal');
        const mTitle = document.getElementById('m-title');
        const mDesc = document.getElementById('m-desc');
        const mTags = document.getElementById('m-tags');

        function openModal(type) {
            const data = servicesData[type];
            if(!data) return;
            mTitle.innerText = data.title;
            mTitle.style.color = getComputedStyle(document.documentElement).getPropertyValue(`--c-${type}`);
            mDesc.innerText = data.desc;
            mTags.innerHTML = data.tags.map(tag => `<span class="tag">${tag}</span>`).join('');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.feature-card').forEach(card => observer.observe(card));
    </script>
</body>
</html>