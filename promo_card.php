<?php
// --- PHP 資料設定區 ---
$p_title_main = "金融旅遊 x 東洋旅行社";
$p_title_sub = "環球無限卡 World Elite";
$p_slogan = "世界再大，<br>也能一手掌握。";
$p_desc = "符合國際標準規格，內建感應功能，暢行全球百大景點。";
$p_btn_text = "立即申辦享首刷禮";
$p_link = "#";

// 優惠特色
$p_features = [
    ["icon" => "✈️", "title" => "機票優惠", "desc" => "你先代墊 <b class='h-txt'>9折</b> 起"],
    ["icon" => "🌍", "title" => "海外回饋", "desc" => "你回饋我 <b class='h-txt'>3.5%</b>"],
    ["icon" => "🛋️", "title" => "機場貴賓", "desc" => "先讓給我"],
    ["icon" => "🎁", "title" => "首刷好禮", "desc" => "目前沒有"]
];

// 警語
$p_legal = "謹慎理財 信用至上 | 循環信用利率：5.68%~15.00% | 預借現金手續費：每筆預借金額 x 3.5% + NT$100";
?>

<style>
    /* Reset & Container */
    .card-v4-wrap * { box-sizing: border-box; }
    .card-v4-wrap {
        position: relative;
        width: 100%; max-width: 1100px;
        margin: 40px auto;
        /* 背景：極簡白灰漸層 */
        background: radial-gradient(circle at 0% 0%, #ffffff, #f0f2f5);
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.06);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        color: #2c3e50;
        overflow: hidden;
        border: 1px solid #fff;
    }

    /* 強調色 */
    .h-txt { color: #b88a44; } /* 霧金 */

    /* 佈局 Main Layout */
    .v4-layout {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 50px 60px;
        gap: 40px;
    }

    /* 左側文字 Text Column */
    .v4-txt-col { flex: 1; max-width: 500px; position: relative; z-index: 2; }
    
    .v4-badge {
        background: rgba(184, 138, 68, 0.1); color: #b88a44;
        padding: 6px 14px; font-size: 0.85rem; font-weight: 700;
        border-radius: 4px; display: inline-block; margin-bottom: 20px;
        letter-spacing: 1px;
    }
    
    .v4-title {
        font-size: 2.6rem; font-weight: 800; line-height: 1.2;
        margin-bottom: 20px; color: #1a2a6c;
    }
    
    .v4-desc { font-size: 1.05rem; color: #647385; margin-bottom: 35px; line-height: 1.6; }

    .v4-btn {
        text-decoration: none;
        background: #1a2a6c; color: #fff;
        padding: 15px 40px; border-radius: 6px;
        font-weight: 600; font-size: 1rem;
        transition: 0.3s;
        box-shadow: 0 10px 20px rgba(26, 42, 108, 0.2);
    }
    .v4-btn:hover { background: #2a3e8c; transform: translateY(-2px); }

    /* 右側卡片展示 Card Column */
    .v4-card-col { flex: 1; display: flex; justify-content: center; position: relative; }

    /* --- 標準信用卡 CSS 繪製 (ISO/IEC 7810 ID-1) --- */
    .standard-card {
        width: 360px;
        height: 227px; /* 360 / 1.586 = 227 */
        border-radius: 14px; /* 標準圓角半徑約 3.18mm */
        position: relative;
        /* 卡面設計：深藍旅遊風 */
        background: linear-gradient(105deg, #091c38 0%, #16325c 50%, #2a5298 100%);
        box-shadow: 0 20px 40px -5px rgba(0,0,0,0.4);
        color: #fff;
        transition: transform 0.4s ease;
        overflow: hidden; /* 裁切超出範圍的裝飾 */
    }

    .v4-card-col:hover .standard-card { transform: translateY(-10px); }

    /* 卡面紋理層 (世界地圖 & 符號) */
    .sc-texture {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        /* 點狀經緯線 */
        background-image: 
            radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px),
            radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px);
        background-size: 20px 20px;
        background-position: 0 0, 10px 10px;
        z-index: 0;
    }

    /* 浮水印圖騰 (絕對定位調整位置) */
    .sc-watermark {
        position: absolute; pointer-events: none; opacity: 0.15;
        font-family: "Segoe UI Emoji", sans-serif; /* 確保 Emoji 顯示 */
        z-index: 0;
    }
    .wm-plane { top: 10%; right: 8%; font-size: 40px; transform: rotate(-20deg); }
    .wm-statue { bottom: -10%; left: 35%; font-size: 90px; filter: grayscale(100%); opacity: 0.1; } /* 自由女神 */
    .wm-tower { top: -10%; right: 30%; font-size: 80px; transform: rotate(10deg); filter: grayscale(100%); opacity: 0.1; } /* 鐵塔 */
    
    /* 地球弧線裝飾 */
    .sc-globe-arc {
        position: absolute; bottom: -80%; right: -20%;
        width: 100%; height: 100%;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.1);
        box-shadow: 0 0 20px rgba(0,198,255,0.1);
        z-index: 0;
    }

    /* --- 標準元件位置 (ISO Layout) --- */
    
    /* 1. 晶片 (Chip) - 標準位置 */
    .sc-chip {
        position: absolute;
        top: 36%; /* 垂直置中偏上 */
        left: 10%; /* 左側邊距 */
        width: 45px; height: 34px;
        background: linear-gradient(135deg, #e3c472 0%, #bf953f 100%);
        border-radius: 6px;
        z-index: 2;
        /* 模擬晶片紋路 */
        border: 1px solid rgba(0,0,0,0.1);
        display: flex; flex-wrap: wrap;
    }
    .chip-line { width: 33%; height: 50%; border: 1px solid rgba(0,0,0,0.15); box-sizing: border-box; }

    /* 2. 感應符號 (Contactless/NFC) */
    .sc-nfc {
        position: absolute;
        top: 38%; right: 10%; /* 放在右側比較平衡，或放在晶片旁 */
        font-size: 24px;
        transform: rotate(90deg); /* 轉成橫向波紋 */
        opacity: 0.8;
        z-index: 2;
    }

    /* 3. 卡號 (Card Number) */
    .sc-number {
        position: absolute;
        top: 60%; left: 10%; width: 80%;
        font-family: 'Courier New', monospace;
        font-size: 22px;
        letter-spacing: 2px;
        color: #e0e0e0;
        text-shadow: 0 1px 2px rgba(0,0,0,0.8);
        z-index: 2;
        display: flex; justify-content: space-between;
    }

    /* 4. 持卡人資訊 (Holder & Date) */
    .sc-info {
        position: absolute;
        bottom: 10%; left: 10%;
        z-index: 2;
        text-transform: uppercase;
    }
    .sc-label { font-size: 8px; color: #aaa; display: block; margin-bottom: 2px; }
    .sc-name { font-size: 14px; letter-spacing: 1px; color: #fff; }
    .sc-date { 
        position: absolute; bottom: 0; left: 180px; 
        font-size: 14px; letter-spacing: 1px; 
    }
    .sc-date span { font-size: 8px; color: #aaa; margin-right: 5px; }

    /* 5. Logo (Visa/Master) - 右下角 */
    .sc-logo {
        position: absolute;
        bottom: 8%; right: 8%;
        font-size: 24px; font-weight: bold; font-style: italic;
        color: #fff; z-index: 2;
    }
    /* 銀行 Logo - 左上角 */
    .sc-bank {
        position: absolute;
        top: 10%; left: 10%;
        font-size: 16px; font-weight: bold; letter-spacing: 1px;
        opacity: 0.9; z-index: 2;
        font-style: italic;
    }

    /* 下方特色欄 */
    .v4-feat-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        border-top: 1px solid #eee;
        background: #fafbfc;
    }
    .v4-feat-item {
        padding: 25px 15px;
        text-align: center;
        border-right: 1px solid #eee;
    }
    .v4-feat-item:last-child { border-right: none; }
    .fi-icon { font-size: 1.8rem; margin-bottom: 10px; display: block; }
    .fi-title { font-weight: 700; font-size: 0.95rem; display: block; margin-bottom: 5px; color: #333; }
    .fi-desc { font-size: 0.85rem; color: #777; }

    /* 警語 */
    .v4-legal {
        background: #f0f2f5; color: #999;
        font-size: 0.7rem; text-align: center;
        padding: 10px 20px;
    }
    .warn { color: #d93025; font-weight: bold; }

    /* RWD */
    @media (max-width: 900px) {
        .v4-layout { flex-direction: column-reverse; text-align: center; padding: 40px 20px; }
        .v4-txt-col { max-width: 100%; }
        .v4-feat-row { grid-template-columns: 1fr 1fr; }
        .v4-feat-item { border-bottom: 1px solid #eee; }
        .standard-card { width: 300px; height: 189px; } /* 等比例縮小 */
        .sc-number { font-size: 18px; top: 58%; }
        .sc-chip { top: 34%; }
    }
</style>

<div class="card-v4-wrap">
    
    <div class="v4-layout">
        <div class="v4-txt-col">
            <span class="v4-badge"><?php echo $p_title_sub; ?></span>
            <h2 class="v4-title"><?php echo $p_slogan; ?></h2>
            <p class="v4-desc"><?php echo $p_desc; ?></p>
            <a href="<?php echo $p_link; ?>" class="v4-btn"><?php echo $p_btn_text; ?></a>
        </div>

        <div class="v4-card-col">
            <div class="standard-card">
                <div class="sc-bank">TOYO TRAVEL</div>

                <div class="sc-chip">
                    <div class="chip-line"></div><div class="chip-line"></div><div class="chip-line"></div>
                    <div class="chip-line"></div><div class="chip-line"></div><div class="chip-line"></div>
                </div>

                <div class="sc-nfc">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" opacity="0"/>
                        <path d="M12 6c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" opacity="0.3"/>
                        <path d="M4.54 9.13C5.62 7.05 7.66 5.5 10.05 5.06v2.05C8.42 7.5 7.14 8.64 6.56 10.15L4.54 9.13zM19.46 9.13l-2.02 1.02c-.58-1.51-1.86-2.65-3.49-3.04V5.06c2.39.44 4.43 1.99 5.51 4.07z"/> 
                        <path d="M12 2C9.24 2 6.74 3.12 4.93 4.93l1.41 1.41C7.79 4.9 9.79 4 12 4s4.21.9 5.66 2.34l1.41-1.41C17.26 3.12 14.76 2 12 2z"/>
                        <path d="M12 6c-1.66 0-3.16.68-4.24 1.76l1.41 1.41C9.9 8.45 10.9 8 12 8s2.1.45 2.83 1.17l1.41-1.41C15.16 6.68 13.66 6 12 6z"/>
                    </svg>
                </div>

                <div class="sc-texture"></div>
                <div class="sc-globe-arc"></div>
                
                <div class="sc-watermark wm-plane">✈️</div>
                <div class="sc-watermark wm-statue">🗽</div>
                <div class="sc-watermark wm-tower">🗼</div>

                <div class="sc-number">
                    <span>4000</span><span>****</span><span>5678</span><span>****</span>
                </div>

                <div class="sc-info">
                    <div style="display:flex; gap: 20px;">
                        <div>
                            <span class="sc-label">VALID THRU</span>
                            <span class="sc-name" style="font-size:12px;">12/30</span>
                        </div>
                        <div>
                            <span class="sc-label">CARDHOLDER</span>
                            <span class="sc-name">LI XUO moving</span>
                        </div>
                    </div>
                </div>

                <div class="sc-logo">VICA</div>
            </div>
        </div>
    </div>

    <div class="v4-feat-row">
        <?php foreach ($p_features as $f): ?>
        <div class="v4-feat-item">
            <span class="fi-icon"><?php echo $f['icon']; ?></span>
            <span class="fi-title"><?php echo $f['title']; ?></span>
            <span class="fi-desc"><?php echo $f['desc']; ?></span>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="v4-legal">
        <span class="warn">謹慎理財 信用至上</span> <?php echo str_replace("謹慎理財 信用至上 | ", "", $p_legal); ?>
    </div>

</div>