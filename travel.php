<?php include 'promo_card.php'; ?>
<?php
// --- 數據資料：企業端 (清新風格) ---
$introText = "金融旅遊，名字源自2018年的一次商業員工旅遊，由東洋與誠訊兩大集團董事長共同提出。數年後擴大規模，成為國內知名旅行聯盟。";

// 歷史資料 (精簡版以節省空間，您的原始資料都在)
$historyData = [
    '2018' => ['title' => '冒險萌芽', 'content' => '金融旅遊橫空出世。大崗山單車遊、台江迷航、308高地挑戰。'],
    '2021' => ['title' => '轉生新紀元', 'content' => '燕巢雞冠山最後單車行。開啟機車旅遊模式。'],
    '2022' => ['title' => '極樂淨土', 'content' => '屏東潮州、花東行、劍湖山，創下參與人數新高。']
];

// 組織
$orgStructure = [
    '行政機關' => '交由兩公司各自職掌所負責的業務。',
    '立法機關' => '成立「國民旅遊大會 (NTC)」，確保高度傾聽民意。'
];

// --- 數據資料：日本恐怖企劃 ---
$upcomingTrip = [
    'title' => '2026 冥界鉅獻：日本如月車站',
    'subtitle' => '青木原樹海 X 舊犬鳴隧道 X 廢棄神社',
    'price' => '魂 44,444 起',
    'features' => ['保證入住人偶飯店', '全程無購物(僅供品)', '舊符咒折 $3,000', '陰陽師隨行']
];
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>金融旅遊 Financial Travel | 探索無界</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;700;900&family=Shippori+Mincho:wght@400;800&display=swap" rel="stylesheet">

    <style>
        /* --- Reset & Base --- */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Noto Sans TC', sans-serif; background-color: #f4f7f6; color: #333; overflow-x: hidden; line-height: 1.6; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        
        /* 變數 */
        :root { --blood: #b71c1c; --gold: #c5a059; --night: #0a0a0a; }

        /* =======================================
           1. HERO SECTION: 聯名卡 (時尚置頂)
           ======================================= */
        .hero-section {
            background: linear-gradient(135deg, #e0f7fa 0%, #fff 100%);
            padding: 100px 0 60px; position: relative; overflow: hidden;
        }
        .hero-layout { display: flex; align-items: center; justify-content: space-between; gap: 50px; }
        .hero-text { flex: 1; z-index: 2; }
        .hero-title { font-size: 3.5rem; font-weight: 900; color: #2c3e50; line-height: 1.2; margin-bottom: 20px; }
        .hero-visual { flex: 1; display: flex; justify-content: center; position: relative; z-index: 2; }
        
        /* 時尚卡面 */
        .fashion-card {
            width: 360px; height: 220px;
            background: linear-gradient(120deg, #89f7fe 0%, #66a6ff 100%);
            border-radius: 20px; position: relative;
            box-shadow: 0 20px 50px rgba(102, 166, 255, 0.4);
            color: #fff; padding: 25px; font-family: 'Noto Sans TC';
            overflow: hidden; transform-style: preserve-3d;
            animation: floatCard 6s ease-in-out infinite;
        }
        .fashion-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/World_map_blank_without_borders.svg/2000px-World_map_blank_without_borders.svg.png');
            background-size: cover; opacity: 0.15; mix-blend-mode: overlay;
        }
        @keyframes floatCard { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px) rotate(2deg); } }
        
        /* RWD */
        @media (max-width: 768px) {
            .hero-layout { flex-direction: column-reverse; text-align: center; }
            .hero-title { font-size: 2.5rem; }
            .fashion-card { width: 300px; height: 180px; }
        }

        /* =======================================
           2. COMPANY INFO (清新簡約)
           ======================================= */
        .intro-section { padding: 60px 0; text-align: center; background: #fff; }
        .service-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px; margin-top: 40px; }
        .service-box { padding: 20px; background: #f8f9fa; border-radius: 12px; text-align: center; }
        
        /* =======================================
           3. 警告帶
           ======================================= */
        .tape-container {
            background: #111; padding: 15px 0; overflow: hidden; transform: skewY(-2deg); margin: 50px 0 -30px; position: relative; z-index: 5; border-top: 5px solid #ff0000; border-bottom: 5px solid #ff0000;
        }
        .tape-text { color: #ffde00; font-weight: 900; font-size: 1.5rem; letter-spacing: 5px; animation: marquee 10s linear infinite; white-space: nowrap; }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        /* =======================================
           4. HORROR WORLD (祭典遊戲區)
           ======================================= */
        #horror-world {
            background-color: var(--night); color: #ddd;
            font-family: 'Shippori Mincho', serif;
            padding: 80px 0; position: relative;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.05'/%3E%3C/svg%3E");
        }

        /* 遊戲通用的攤位樣式 */
        .stall-container {
            border: 4px solid #5d4037; background: #222; margin-bottom: 50px;
            position: relative; overflow: hidden; box-shadow: 0 10px 30px #000;
        }
        .stall-header {
            background: var(--blood); color: #fff; padding: 10px; text-align: center;
            font-size: 1.5rem; font-weight: bold; letter-spacing: 3px; border-bottom: 4px solid #5d4037;
        }

        /* --- Game A: 移動射擊 (Shooting) --- */
        .shooting-gallery { height: 300px; position: relative; background: #1a1a1a; cursor: crosshair; }
        .shelf-track {
            position: absolute; width: 100%; height: 80px; border-bottom: 2px solid #444;
            display: flex; align-items: center;
        }
        .track-1 { top: 40px; }
        .track-2 { top: 140px; }
        
        .moving-target {
            width: 60px; height: 80px; background: #fff; color: #000;
            position: absolute; display: flex; align-items: center; justify-content: center;
            font-weight: bold; border: 2px solid #ccc; transition: 0.1s;
        }
        .moving-target.shot { transform: rotateX(90deg); opacity: 0; pointer-events: none; }
        
        /* 動畫：左右移動 */
        @keyframes moveLeft { 0% { left: 100%; } 100% { left: -100px; } }
        @keyframes moveRight { 0% { left: -100px; } 100% { left: 100%; } }
        
        .t-fast { animation: moveLeft 4s linear infinite; }
        .t-slow { animation: moveRight 6s linear infinite; }

        /* --- Game B: 撈金魚 (Goldfish) --- */
        .goldfish-pool {
            height: 250px; background: radial-gradient(circle, #0d47a1 0%, #000 90%);
            position: relative; overflow: hidden; cursor: url('https://cdn-icons-png.flaticon.com/32/660/660604.png'), auto; /* 網子游標模擬 */
        }
        .fish {
            position: absolute; font-size: 2rem; color: #ff9800; opacity: 0.8;
            filter: drop-shadow(0 0 5px #ff9800); transition: 0.2s; cursor: pointer;
        }
        .fish:active { transform: scale(1.5); opacity: 0; } /* 點擊捕捉 */
        
        @keyframes swim1 { 0% { left: -50px; top: 20%; transform: scaleX(1); } 50% { top: 60%; } 100% { left: 100%; top: 30%; transform: scaleX(1); } }
        @keyframes swim2 { 0% { left: 100%; top: 70%; transform: scaleX(-1); } 50% { top: 10%; } 100% { left: -50px; top: 80%; transform: scaleX(-1); } }
        
        .f1 { animation: swim1 8s linear infinite; }
        .f2 { animation: swim2 12s linear infinite; animation-delay: 2s; color: #e91e63; }
        .f3 { animation: swim1 6s linear infinite; animation-delay: 4s; color: #fff; }

        /* --- Game C: 抽籤 (Omikuji) --- */
        .omikuji-box {
            text-align: center; padding: 40px; background: #222;
        }
        .shaker {
            font-size: 4rem; color: #c5a059; cursor: pointer; transition: 0.3s; display: inline-block;
        }
        .shaker:hover { transform: rotate(10deg); color: #fff; }
        .shaker.shake-anim { animation: shake 0.5s infinite; }
        @keyframes shake { 0% { transform: rotate(0deg); } 25% { transform: rotate(10deg); } 50% { transform: rotate(0deg); } 75% { transform: rotate(-10deg); } 100% { transform: rotate(0deg); } }
        
        .result-slip {
            margin-top: 20px; border: 1px solid #fff; padding: 20px; width: 150px; height: 250px;
            margin: 20px auto; background: #fff; color: #000; writing-mode: vertical-rl;
            font-size: 1.5rem; font-weight: bold; display: none; /* 預設隱藏 */
            box-shadow: 0 0 20px #fff;
        }

        /* 行程卡 (簡化版) */
        .horror-card {
            display: flex; flex-wrap: wrap; border: 1px solid #333; background: #0a0a0a; margin-bottom: 50px;
        }
        .horror-img { flex: 1 1 400px; min-height: 300px; background: url('https://images.unsplash.com/photo-1542051841857-5f90071e7989?ixlib=rb-1.2.1') center/cover; filter: grayscale(80%); }
        .horror-content { flex: 1 1 300px; padding: 30px; }

    </style>
</head>
<body>

    <section class="intro-section">
        <div class="container">
            <h2 data-aos="fade-up">關於我們</h2>
            <p style="color:#666; max-width:800px; margin:0 auto;"><?php echo $introText; ?></p>
            <div class="service-grid">
                <div class="service-box"><i class="fas fa-utensils" style="font-size:2rem; color:#00b4db;"></i><br>極致饗宴</div>
                <div class="service-box"><i class="fas fa-plane" style="font-size:2rem; color:#00b4db;"></i><br>安全接駁</div>
                <div class="service-box"><i class="fas fa-hotel" style="font-size:2rem; color:#00b4db;"></i><br>舒適休憩</div>
                <div class="service-box"><i class="fas fa-masks-theater" style="font-size:2rem; color:#00b4db;"></i><br>獨家體驗</div>
            </div>
        </div>
    </section>

    <div class="tape-container">
        <div class="tape-text">WARNING ⚠️ 進入冥界祭典商店街 ⚠️ CAUTION ⚠️ 膽小者慎入 ⚠️</div>
    </div>

    <section id="horror-world">
        <div class="container">
            
            <div style="text-align: center; margin-bottom: 50px;">
                <h2 style="font-size: 2.5rem; color: var(--blood); font-weight: 900; text-shadow: 0 0 10px var(--blood);">
                    冥界．如月車站
                </h2>
                <p style="color: var(--gold);">一年一度的百鬼夜行祭典開始了...</p>
            </div>

            <div class="horror-card" data-aos="zoom-in">
                <div class="horror-img"></div>
                <div class="horror-content">
                    <h3 style="color: #fff; margin-bottom: 10px;"><?php echo $upcomingTrip['title']; ?></h3>
                    <p style="color: var(--gold);"><?php echo $upcomingTrip['subtitle']; ?></p>
                    <div style="font-size: 2rem; color: var(--blood); font-family: 'Courier New'; font-weight: bold; margin-top:20px;">
                        <?php echo $upcomingTrip['price']; ?>
                    </div>
                    <button style="border:1px solid var(--blood); color:var(--blood); background:none; padding:10px 30px; margin-top:20px; cursor:pointer;" onclick="alert('契約成立')">立即簽約</button>
                </div>
            </div>

            <div class="stall-container" data-aos="fade-up">
                <div class="stall-header">🎯 除魔射的屋</div>
                <div class="shooting-gallery" id="shootingGame">
                    <div style="position: absolute; top:10px; left:10px; color:#fff;">得分: <span id="shootScore">0</span></div>
                    <div class="shelf-track track-1">
                        <div class="moving-target t-fast" onclick="hitTarget(this)">窮神</div>
                        <div class="moving-target t-fast" style="animation-delay: 2s;" onclick="hitTarget(this)">加班</div>
                    </div>
                    <div class="shelf-track track-2">
                        <div class="moving-target t-slow" onclick="hitTarget(this)">水逆</div>
                        <div class="moving-target t-slow" style="animation-delay: 3s;" onclick="hitTarget(this)">爛桃花</div>
                        <div class="moving-target t-slow" style="animation-delay: 1s;" onclick="hitTarget(this)">肥胖</div>
                    </div>
                    <div style="position:absolute; bottom:10px; width:100%; text-align:center; color:#888;">(點擊移動的目標進行除靈)</div>
                </div>
            </div>

            <div class="stall-container" data-aos="fade-up">
                <div class="stall-header">🐟 黃泉撈金魚</div>
                <div class="goldfish-pool" id="fishPool">
                    <div style="position: absolute; top:10px; left:10px; color:#fff;">收穫: <span id="fishScore">0</span></div>
                    <i class="fas fa-fish fish f1" onclick="catchFish(this)"></i>
                    <i class="fas fa-fish fish f2" onclick="catchFish(this)"></i>
                    <i class="fas fa-fish fish f3" onclick="catchFish(this)"></i>
                    <div style="position:absolute; bottom:10px; width:100%; text-align:center; color:rgba(255,255,255,0.5); pointer-events:none;">(點擊金魚撈取靈魂)</div>
                </div>
            </div>

            <div class="stall-container" data-aos="fade-up">
                <div class="stall-header">⛩️ 運命吉凶</div>
                <div class="omikuji-box">
                    <p style="color:#aaa; margin-bottom:20px;">搖動籤筒，預測您的旅途運勢</p>
                    <div class="shaker" onclick="drawOmikuji(this)">
                        <i class="fas fa-dice-d20"></i>
                    </div>
                    <div id="omikujiResult" class="result-slip"></div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 50px; color: #666; font-size: 0.8rem;">
                &copy; 2026 金融旅遊 Financial Travel (東洋 X 誠訊)
            </div>

        </div>
    </section>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        // --- Game 1: 射擊邏輯 ---
        let sScore = 0;
        function hitTarget(el) {
            if(el.style.opacity === '0') return;
            el.classList.add('shot');
            sScore++;
            document.getElementById('shootScore').innerText = sScore;
            
            // 復活機制 (為了讓遊戲可以一直玩)
            setTimeout(() => {
                el.classList.remove('shot');
            }, 3000);
        }

        // --- Game 2: 撈金魚邏輯 ---
        let fScore = 0;
        function catchFish(el) {
            el.style.opacity = '0';
            el.style.transform = 'scale(0)';
            fScore++;
            document.getElementById('fishScore').innerText = fScore;

            // 金魚重生
            setTimeout(() => {
                el.style.opacity = '0.8';
                el.style.transform = 'scale(1)';
            }, 4000);
        }

        // --- Game 3: 抽籤邏輯 ---
        const fortunes = [
            { type: "大吉", color: "red", text: "旅途平安\n豔遇不斷" },
            { type: "中吉", color: "black", text: "適合購物\n注意荷包" },
            { type: "小吉", color: "black", text: "今日宜\n宅在家中" },
            { type: "凶", color: "blue", text: "路況不熟\n鬼打牆" },
            { type: "大凶", color: "purple", text: "背後有人\n不要回頭" }
        ];

        function drawOmikuji(el) {
            const resBox = document.getElementById('omikujiResult');
            resBox.style.display = 'none';
            el.classList.add('shake-anim');
            
            setTimeout(() => {
                el.classList.remove('shake-anim');
                const result = fortunes[Math.floor(Math.random() * fortunes.length)];
                
                resBox.innerHTML = `<span style="color:${result.color}; font-size:2rem;">${result.type}</span><br><br>${result.text}`;
                resBox.style.display = 'block';
                resBox.style.borderColor = result.color;
            }, 1000);
        }
    </script>
</body>
</html>