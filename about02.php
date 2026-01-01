<?php
include 'headfooter/header4.php';
?>

<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Ma+Shan+Zheng&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<style>
    /* =========================================
       全域設定
       ========================================= */
    :root {
        --bg-gray: #f5f7fa;           
        --text-main: #2c3e50;    
        --text-light: #5d6d7e;  
        --gold-accent: #960000ff;
        
        /* 職位顏色 */
        --rank-gold: #d4ac0d; 
        --rank-orange: #3d0061ff;      
        --rank-executive: #922b21;  
        --rank-manager: #154360;    
        --rank-staff: #145a32;      
        --rank-vacancy: #566573;    
    }

    body {
        background-color: var(--bg-gray);
        font-family: 'Noto Sans TC', sans-serif;
        margin: 0;
        overflow-x: hidden;
    }

    .cx-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px 80px; 
    }

    /* =========================================
       [優化版] 創辦人致詞 - 響應式調整
       ========================================= */
    .founder-letter-wrapper {
        background-color: #ffffff;
        width: 100vw; 
        margin-left: calc(-50vw + 50%); 
        margin-right: calc(-50vw + 50%);
        padding: 100px 0 120px; /* 電腦版維持大器留白 */
        margin-bottom: 80px;
        position: relative;
    }

    .letter-container {
        max-width: 800px; 
        margin: 0 auto;
        padding: 0 30px;
        position: relative;
    }

    /* 背景大引號 */
    .letter-bg-quote {
        position: absolute;
        top: -60px;
        left: -40px;
        font-family: 'Playfair Display', serif;
        font-size: 15rem;
        color: rgba(0,0,0,0.03);
        z-index: 0;
        pointer-events: none;
        line-height: 1;
    }

    /* 標題區 */
    .letter-header {
        text-align: center;
        margin-bottom: 50px;
        position: relative;
        z-index: 1;
    }

    .letter-subtitle {
        display: block;
        font-size: 0.85rem;
        letter-spacing: 4px;
        color: var(--gold-accent);
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .letter-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: var(--text-main);
        margin: 0;
        font-weight: 700;
    }
    
    .letter-title span {
        font-family: 'Noto Sans TC', sans-serif;
        font-weight: 400;
        font-size: 1.6rem;
        display: block;
        margin-top: 8px;
    }

    /* 內文區 */
    .letter-content {
        position: relative;
        z-index: 1;
        font-size: 1.15rem;
        line-height: 2.2;
        color: #4a5568; 
        text-align: justify; 
        text-justify: inter-ideograph;
        font-weight: 300;
    }

    .letter-content p {
        margin-bottom: 30px;
    }

    /* 首字下沉效果 */
    .letter-content p:first-child::first-letter {
        font-size: 3.5em;
        float: left;
        line-height: 0.8;
        margin-right: 12px;
        margin-top: -4px;
        color: var(--text-main);
        font-family: 'Playfair Display', serif;
    }

    /* 簽名區 */
    .letter-footer {
        margin-top: 50px;
        display: flex;
        flex-direction: column;
        align-items: flex-end; 
        padding-top: 30px;
        border-top: 1px solid rgba(0,0,0,0.05); 
    }

    .signature-img {
        font-family: 'Ma Shan Zheng', cursive;
        font-size: 3.5rem;
        color: var(--text-main);
        transform: rotate(-2deg);
        margin-bottom: 5px;
    }

    .signature-info {
        text-align: right;
    }

    .signature-name {
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 1px;
        color: var(--text-main);
        text-transform: uppercase;
    }

    .signature-title {
        font-size: 0.8rem;
        color: var(--text-light);
        letter-spacing: 1px;
        margin-top: 4px;
    }

    /* =========================================
       ★ 手機版特別優化 (Mobile Optimization) ★
       ========================================= */
    @media (max-width: 768px) {
        .founder-letter-wrapper {
            padding: 50px 0 60px; /* 大幅減少上下留白 */
            margin-bottom: 40px;
        }

        .letter-container {
            padding: 0 20px; /* 減少左右內距 */
        }

        .letter-bg-quote {
            display: none; /* 手機隱藏背景大引號，減少視覺干擾 */
        }

        .letter-header {
            margin-bottom: 30px;
        }

        .letter-title {
            font-size: 1.8rem; /* 標題縮小 */
        }

        .letter-title span {
            font-size: 1.3rem;
            margin-top: 5px;
        }

        .letter-content {
            font-size: 1rem; /* 字體縮小 */
            line-height: 1.75; /* 行高縮小，讓文章看起來不那麼長 */
            text-align: left; /* 手機靠左對齊較好閱讀 */
        }

        .letter-content p {
            margin-bottom: 20px; /* 段落間距縮小 */
        }
        
        .letter-footer {
            margin-top: 30px;
            padding-top: 20px;
        }
    }

    /* =========================================
       卡片區塊樣式
       ========================================= */
    .group-section {
        margin-bottom: 60px;
        position: relative;
    }

    .group-title {
        font-size: 1.8rem;
        color: var(--text-main);
        font-weight: 700;
        margin-bottom: 30px;
        padding-left: 20px;
        border-left: 5px solid var(--rank-manager);
        display: flex;
        align-items: center;
    }

    .group-title span {
        font-size: 1rem;
        color: #999;
        margin-left: 15px;
        font-weight: 400;
        letter-spacing: 1px;
    }

    /* Swiper 設定 */
    .swiper {
        width: 100%;
        padding-top: 20px;
        padding-bottom: 60px; /* 增加下方留白給分頁器 */
        padding-left: 10px;
        padding-right: 10px;
    }

    .swiper-slide {
        width: auto;
        display: flex;
        justify-content: center;
    }

    /* ★ 左右翻轉按鈕動畫加強 ★ */
    .swiper-button-next, .swiper-button-prev {
        background-color: var(--rank-manager); /* 改為深色實心背景 */
        color: white;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(21, 67, 96, 0.3); /* 明顯陰影 */
        transition: all 0.3s ease;
        opacity: 0.9;
    }

    /* 定義呼吸燈動畫 */
    @keyframes pulse-glow {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(21, 67, 96, 0.6); }
        70% { transform: scale(1.1); box-shadow: 0 0 0 12px rgba(21, 67, 96, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(21, 67, 96, 0); }
    }

    /* 套用動畫到按鈕 */
    .swiper-button-next, .swiper-button-prev {
        animation: pulse-glow 2s infinite; /* 無限循環呼吸效果 */
    }

    /* 按鈕圖標大小調整 */
    .swiper-button-next::after, .swiper-button-prev::after {
        font-size: 1.2rem;
        font-weight: bold;
    }

    /* 3D 卡片核心樣式 */
    .id-card-wrapper {
        width: 300px; height: 500px; perspective: 1500px; cursor: pointer; position: relative; -webkit-tap-highlight-color: transparent;
    }

    .id-card-inner {
        position: relative; width: 100%; height: 100%; text-align: center;
        transition: transform 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        transform-style: preserve-3d; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border-radius: 12px;
    }

    .id-card-wrapper.is-flipped .id-card-inner { transform: rotateY(180deg); }

    .id-card-front, .id-card-back {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        backface-visibility: hidden; border-radius: 12px; background: #ffffff; overflow: hidden;
        border: 1px solid rgba(0,0,0,0.08);
    }

    /* 正面細節 */
    .id-card-front { display: flex; flex-direction: column; z-index: 2; }
    .card-header-bar { height: 12px; width: 100%; background: var(--theme-color); }
    .card-header-row { padding: 20px 25px 10px; display: flex; justify-content: space-between; align-items: center; height: 60px; }
    .company-name { font-size: 0.85rem; font-weight: 700; letter-spacing: 1px; color: var(--text-main); text-transform: uppercase; }
    .company-logo { height: 40px; max-width: 100px; display: flex; align-items: center; justify-content: flex-end; }
    .company-logo img { height: 100%; width: auto; object-fit: contain; }

   /* .smart-chip {
        width: 40px; height: 28px;
        background: linear-gradient(135deg, #e6ce6a 0%, #b7950b 50%, #e6ce6a 100%);
        border-radius: 5px; border: 1px solid #997c00;
        position: absolute; top: 85px; left: 30px; z-index: 5;
    }
*/
    .photo-area {
        width: 150px; height: 190px;
        background: #f0f0f0; margin: 35px auto 20px;
        border-radius: 6px; overflow: hidden;
        border: 1px solid rgba(0,0,0,0.1);
        position: relative; box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .photo-area img { width: 100%; height: 100%; object-fit: cover; }

    .info-area { padding: 0 30px; text-align: left; }
    .label { font-size: 0.65rem; color: #95a5a6; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px; display: block; font-weight: 500; }
    .value-name { font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin-bottom: 12px; border-bottom: 2px solid var(--theme-color); padding-bottom: 5px; display: inline-block; width: 100%; line-height: 1.2; }
    .value-position { font-size: 0.95rem; color: var(--theme-color); font-weight: 700; margin-bottom: 5px; letter-spacing: 0.5px; }
    .value-id { font-family: 'Courier New', monospace; font-size: 0.85rem; color: #7f8c8d; letter-spacing: 1px; }

    .card-footer { margin-top: auto; padding: 12px; background: #fafafa; border-top: 1px solid #eee; display: flex; justify-content: center; align-items: center; position: relative; }
    .barcode { height: 25px; width: 60%; background-image: repeating-linear-gradient(90deg, #333 0px, #333 1px, transparent 1px, transparent 3px); opacity: 0.5; margin-right: auto; }
    
    /* ★ 卡片翻轉提示動畫 ★ */
    .click-hint-btn {
        font-size: 0.75rem; 
        color: white; 
        background: var(--theme-color);
        padding: 4px 10px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        animation: hint-bounce 2s infinite;
    }
    
    @keyframes hint-bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
        40% {transform: translateY(-3px);}
        60% {transform: translateY(-2px);}
    }

    /* 背面細節 */
    .id-card-back { transform: rotateY(180deg); background: #fdfdfd; text-align: left; display: flex; flex-direction: column; }
    .magnetic-strip { width: 100%; height: 45px; background: #2d3436; margin-top: 25px; margin-bottom: 25px; }
    .back-content { padding: 0 30px; flex-grow: 1; }
    .back-section-title { font-size: 0.75rem; font-weight: 700; color: var(--theme-color); text-transform: uppercase; letter-spacing: 1.5px; border-bottom: 1px solid #eee; padding-bottom: 8px; margin-bottom: 12px; }
    .back-bio-text { font-size: 0.9rem; line-height: 1.7; color: var(--text-light); margin-bottom: 25px; text-align: justify; }
    .signature-area { margin-top: 20px; border-bottom: 1px solid #ccc; font-family: 'Brush Script MT', cursive; font-size: 1.6rem; color: #555; padding-bottom: 5px; width: 80%; }
    .contact-list { margin-top: 20px; font-size: 0.85rem; color: #555; }
    .contact-row { margin-bottom: 8px; display: flex; align-items: center; }

    /* 主題色配置 */
    .rank-gold   { --theme-color: var(--rank-gold); }
    .rank-orange   { --theme-color: var(--rank-orange); }
    .rank-red    { --theme-color: var(--rank-executive); }
    .rank-blue   { --theme-color: var(--rank-manager); }
    .rank-green  { --theme-color: var(--rank-staff); }
    .rank-gray   { --theme-color: var(--rank-vacancy); }

    .rank-gold .id-card-inner { box-shadow: 0 20px 40px rgba(212, 172, 13, 0.15); border: 1px solid rgba(212, 172, 13, 0.2); }
</style>

<div class="cx-container">

    <section class="founder-letter-wrapper">
        <div class="letter-container" data-aos="fade-up" data-aos-duration="1200">
            <div class="letter-bg-quote">“</div>
            
            <div class="letter-header">
                <span class="letter-subtitle">FOUNDER'S MESSAGE</span>
                <h2 class="letter-title">
                    <span>創辦人致詞</span>
                </h2>
            </div>

            <div class="letter-content">
                <p>好作品值得被人欣賞與借鑒，期望大家能夠在成長過程中，持續鼓勵與進步。透過成立「誠訊工作室」維繫羈絆，期待未來能逐步發展成「誠訊集團」。</p>
                <p>一路上，跨領域夥伴的支持讓我們不斷成長。感謝大家的陪伴，也期許大家都能在專業領域發光發熱，持續以品質與創新為社會創造價值。</p>
            </div>

            <div class="letter-footer">
                <div class="signature-img">李子杰</div>
                <div class="signature-info">
                    <div class="signature-name">Li Zi Jie</div>
                    <div class="signature-title">Founder & CEO, ChengXun Group</div>
                </div>
            </div>
        </div>
    </section>

    <section class="group-section" data-aos="fade-up">
        <h3 class="group-title">長官群 <span>EXECUTIVES</span></h3>
        
        <div class="swiper mySwiper-exec">
            <div class="swiper-wrapper">
                
                <div class="swiper-slide">
                    <div class="id-card-wrapper rank-red" onclick="toggleFlip(this)">
                        <div class="id-card-inner">
                            <div class="id-card-front">
                                <div class="card-header-bar"></div>
                                <div class="card-header-row">
                                    <span class="company-name">CHENGXUN GROUP</span>
                                    <div class="company-logo"><img src="image/LOGO.png" alt="LOGO" onerror="this.style.opacity=0"></div>
                                </div>
                                <div class="smart-chip"></div>
                                <div class="photo-area">
                                    <img src="image/李子杰.PNG" alt="李子杰" onerror="this.src='https://placehold.co/300x400?text=Founder'">
                                </div>
                                <div class="info-area">
                                    <span class="label">Name</span>
                                    <span class="value-name">李子杰</span>
                                    <span class="label">Position</span>
                                    <div class="value-position">創辦人 / CEO</div>
                                    <span class="label">Employee ID</span>
                                    <div class="value-id">CX-0001</div>
                                </div>
                                <div class="card-footer">
                                    <div class="barcode"></div>
                                    <div class="click-hint-btn">
                                        <i class="fa-solid fa-rotate"></i> Flip
                                    </div>
                                </div>
                            </div>
                            <div class="id-card-back">
                                <div class="magnetic-strip"></div>
                                <div class="back-content">
                                    <div class="back-section-title">PROFILE</div>
                                    <div class="back-bio-text">
                                        誠訊集團創辦人。畢業於南臺科技大學電子工程系。以前瞻技術引領集團方向，專注於系統整合與創新商業模式開發。
                                    </div>
                                    <div class="back-section-title">PROJECTS</div>
                                    <div class="back-bio-text">
                                        <a href="/project.php" style="color:var(--theme-color);text-decoration:none;font-weight:bold;">查看個人專案集 &rarr;</a>
                                    </div>
                                    <div class="signature-area">Li Zi Jie</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="id-card-wrapper rank-orange" onclick="toggleFlip(this)">
                        <div class="id-card-inner">
                            <div class="id-card-front">
                                <div class="card-header-bar"></div>
                                <div class="card-header-row">
                                    <span class="company-name">CHENGXUN GROUP</span>
                                    <div class="company-logo"><img src="image/LOGO.png" alt="LOGO" onerror="this.style.opacity=0"></div>
                                </div>
                                <div class="smart-chip"></div>
                                <div class="photo-area">
                                    <img src="image/李映葳.PNG" alt="李映葳" onerror="this.src='https://placehold.co/300x400?text=GM'">
                                </div>
                                <div class="info-area">
                                    <span class="label">Name</span>
                                    <span class="value-name">李映葳</span>
                                    <span class="label">Position</span>
                                    <div class="value-position">總經理(兼代理行政副總)</div>
                                    <span class="label">Employee ID</span>
                                    <div class="value-id">CX-1001</div>
                                </div>
                                <div class="card-footer">
                                    <div class="barcode"></div>
                                    <div class="click-hint-btn">
                                        <i class="fa-solid fa-rotate"></i> Flip
                                    </div>
                                </div>
                            </div>
                            <div class="id-card-back">
                                <div class="magnetic-strip"></div>
                                <div class="back-content">
                                    <div class="back-section-title">EXPERTISE</div>
                                    <div class="back-bio-text">
                                        現任誠訊總經理。畢業於國立台中科技大學。擅長精準掌握市場趨勢，成功打造自有品牌，擁有卓越的商業談判能力。
                                    </div>
                                    <div class="contact-list">
                                        <div class="contact-row">📍 執行總經理</div>
                                    </div>
                                    <div class="signature-area">Li Ying Wei</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="id-card-wrapper rank-blue" onclick="toggleFlip(this)">
                        <div class="id-card-inner">
                            <div class="id-card-front">
                                <div class="card-header-bar"></div>
                                <div class="card-header-row">
                                    <span class="company-name">CHENGXUN GROUP</span>
                                    <div class="company-logo"><img src="image/LOGO.png" alt="LOGO" onerror="this.style.opacity=0"></div>
                                </div>
                                <div class="smart-chip"></div>
                                <div class="photo-area">
                                    <img src="image/陳柏蓁.PNG" alt="陳柏蓁" onerror="this.src='https://placehold.co/300x400?text=VGM'">
                                </div>
                                <div class="info-area">
                                    <span class="label">Name</span>
                                    <span class="value-name">陳柏蓁</span>
                                    <span class="label">Position</span>
                                    <div class="value-position">行政副總經理(留職服役)</div>
                                    <span class="label">Employee ID</span>
                                    <div class="value-id">CX-2001</div>
                                </div>
                                <div class="card-footer">
                                    <div class="barcode"></div>
                                    <div class="click-hint-btn">
                                        <i class="fa-solid fa-rotate"></i> Flip
                                    </div>
                                </div>
                            </div>
                            <div class="id-card-back">
                                <div class="magnetic-strip"></div>
                                <div class="back-content">
                                    <div class="back-section-title">EXPERTISE</div>
                                    <div class="back-bio-text">
                                        東洋全方位董事最高執行長。畢業於國立嘉義大學。具備卓越管理能力，精通旅遊產業運營與策略規劃。
                                    </div>
                                    <div class="contact-list">
                                        <div class="contact-row">📍 行政部</div>
                                    </div>
                                    <div class="signature-area">Chen Bo Zhen</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="id-card-wrapper rank-blue" onclick="toggleFlip(this)">
                        <div class="id-card-inner">
                            <div class="id-card-front">
                                <div class="card-header-bar"></div>
                                <div class="card-header-row">
                                    <span class="company-name">CHENGXUN GROUP</span>
                                    <div class="company-logo"><img src="image/LOGO.png" alt="LOGO" onerror="this.style.opacity=0"></div>
                                </div>
                                <div class="smart-chip"></div>
                                <div class="photo-area">
                                    <img src="image/呂晉瑋.PNG" alt="呂晉瑋" onerror="this.src='https://placehold.co/300x400?text=VGM'">
                                </div>
                                <div class="info-area">
                                    <span class="label">Name</span>
                                    <span class="value-name">呂晉瑋</span>
                                    <span class="label">Position</span>
                                    <div class="value-position">營運副總經理</div>
                                    <span class="label">Employee ID</span>
                                    <div class="value-id">CX-2002</div>
                                </div>
                                <div class="card-footer">
                                    <div class="barcode"></div>
                                    <div class="click-hint-btn">
                                        <i class="fa-solid fa-rotate"></i> Flip
                                    </div>
                                </div>
                            </div>
                            <div class="id-card-back">
                                <div class="magnetic-strip"></div>
                                <div class="back-content">
                                    <div class="back-section-title">EXPERTISE</div>
                                    <div class="back-bio-text">
                                        畢業於國立高雄餐旅大學。負責國際貿易事務，專注於東亞市場發展，擁有出色的外語溝通能力。
                                    </div>
                                    <div class="contact-list">
                                        <div class="contact-row">📍 營運部</div>
                                    </div>
                                    <div class="signature-area">Lu Jin Wei</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <section class="group-section" data-aos="fade-up">
        <h3 class="group-title">部長群 <span>MINISTERS</span></h3>

        <div class="swiper mySwiper-minister">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="id-card-wrapper rank-green" onclick="toggleFlip(this)">
                        <div class="id-card-inner">
                            <div class="id-card-front">
                                <div class="card-header-bar"></div>
                                <div class="card-header-row">
                                    <span class="company-name">CHENGXUN GROUP</span>
                                    <div class="company-logo"><img src="image/LOGO.png" alt="LOGO" onerror="this.style.opacity=0"></div>
                                </div>
                                <div class="smart-chip"></div>
                                <div class="photo-area">
                                    <img src="image/王芷琳.jpg" alt="王芷琳" onerror="this.src='https://placehold.co/300x400?text=Director'">
                                </div>
                                <div class="info-area">
                                    <span class="label">Name</span>
                                    <span class="value-name">王芷琳</span>
                                    <span class="label">Position</span>
                                    <div class="value-position">廣宣部部長</div>
                                    <span class="label">Employee ID</span>
                                    <div class="value-id">CX-3001</div>
                                </div>
                                <div class="card-footer">
                                    <div class="barcode"></div>
                                    <div class="click-hint-btn">
                                        <i class="fa-solid fa-rotate"></i> Flip
                                    </div>
                                </div>
                            </div>
                            <div class="id-card-back">
                                <div class="magnetic-strip"></div>
                                <div class="back-content">
                                    <div class="back-section-title">EXPERTISE</div>
                                    <div class="back-bio-text">
                                        現於義守大學進修。兼具醫學背景與數位行銷思維，能精準掌握流量趨勢，為公司開拓多元曝光管道。
                                    </div>
                                    <div class="contact-list">
                                        <div class="contact-row">
                                            <a href="https://chengxun.ddns.net/notify.php" style="color:var(--theme-color);text-decoration:none;">查看人事公告 &rarr;</a>
                                        </div>
                                    </div>
                                    <div class="signature-area">Wang Zhi Lin</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="id-card-wrapper rank-green" onclick="toggleFlip(this)">
                        <div class="id-card-inner">
                            <div class="id-card-front">
                                <div class="card-header-bar"></div>
                                <div class="card-header-row">
                                    <span class="company-name">CHENGXUN GROUP</span>
                                    <div class="company-logo"><img src="image/LOGO.png" alt="LOGO" onerror="this.style.opacity=0"></div>
                                </div>
                                <div class="smart-chip"></div>
                                <div class="photo-area" style="display:flex;align-items:center;justify-content:center;background:#eee;">
                                    <span style="font-size:3rem;color:#ccc;">?</span>
                                </div>
                                <div class="info-area">
                                    <span class="label">Name</span>
                                    <span class="value-name" style="color:#7f8c8d;">馬梓晉</span>
                                    <span class="label">Position</span>
                                    <div class="value-position">研發部長(侯任)</div>
                                    <span class="label">Status</span>
                                    <div class="value-id">侯任</div>
                                </div>
                                <div class="card-footer">
                                    <div class="barcode"></div>
                                    <div class="click-hint-btn">
                                        <i class="fa-solid fa-rotate"></i> Flip
                                    </div>
                                </div>
                            </div>
                            <div class="id-card-back">
                                <div class="magnetic-strip"></div>
                                <div class="back-content">
                                    <div class="back-section-title">JOIN US</div>
                                    <div class="back-bio-text">
                                        我們尋找熱愛技術研發與創新的夥伴，歡迎加入誠訊集團大家庭。
                                    </div>
                                    <div class="contact-list">
                                        <div class="contact-row">📧 hr@chengxun.com</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="id-card-wrapper rank-green" onclick="toggleFlip(this)">
                        <div class="id-card-inner">
                            <div class="id-card-front">
                                <div class="card-header-bar"></div>
                                <div class="card-header-row">
                                    <span class="company-name">CHENGXUN GROUP</span>
                                    <div class="company-logo"><img src="image/LOGO.png" alt="LOGO" onerror="this.style.opacity=0"></div>
                                </div>
                                <div class="smart-chip"></div>
                                <div class="photo-area" style="display:flex;align-items:center;justify-content:center;background:#eee;">
                                    <span style="font-size:3rem;color:#ccc;">?</span>
                                </div>
                                <div class="info-area">
                                    <span class="label">Name</span>
                                    <span class="value-name" style="color:#7f8c8d;">陳振輝</span>
                                    <span class="label">Position</span>
                                    <div class="value-position">法務部長(侯任)</div>
                                    <span class="label">Status</span>
                                    <div class="value-id">侯任</div>
                                </div>
                                <div class="card-footer">
                                    <div class="barcode"></div>
                                    <div class="click-hint-btn">
                                        <i class="fa-solid fa-rotate"></i> Flip
                                    </div>
                                </div>
                            </div>
                            <div class="id-card-back">
                                <div class="magnetic-strip"></div>
                                <div class="back-content">
                                    <div class="back-section-title">JOIN US</div>
                                    <div class="back-bio-text">
                                        需具備法律專業背景，協助處理公司法務相關事宜。期待您的加入。
                                    </div>
                                    <div class="contact-list">
                                        <div class="contact-row">📧 hr@chengxun.com</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

</div>

<script>
    // 初始化 AOS 動畫
    AOS.init({
        duration: 800,
        once: true
    });

    // 翻轉卡牌功能
    function toggleFlip(card) {
        card.classList.toggle('is-flipped');
    }

    // 初始化 Swiper
    const swiperOptions = {
        slidesPerView: 1, // 手機預設顯示 1 張
        spaceBetween: 20,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 3, // 一排顯示 3 張
                spaceBetween: 40,
            },
        },
    };

    // 分別初始化兩個區塊
    new Swiper(".mySwiper-exec", swiperOptions);
    new Swiper(".mySwiper-minister", swiperOptions);
</script>

<?php
include 'headfooter/footer.php';
?>