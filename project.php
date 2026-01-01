<?php
include 'headfooter/header3.php';

/**
 * 專業版 PHP 作品集網站 + 滑入動畫效果 + 多媒體翻頁功能
 */

$projects = [
    [
        'title' => '樹梅派網頁前端與後端伺服器架設',
        'tech'  => 'Linux 伺服器架設、Apache、PHP、MySQL、HTML、CSS、前後端整合、網頁安全與資料庫管理',
        'media' => ['image/自架網頁5.png', 'image/自架網頁1.png', 'image/自架網頁2.png', 'image/自架網頁3.png'],
        'desc'  => '以樹莓派與 Apache PHP 搭建個人動態網站，建立前端介面與後端資料庫連接，實作簡易管理後台，學會完整網頁架構部署、資料庫設計與操作並主鍵、前後端互動以及伺服器維護。'
    ],
    [
        'title' => '車禍與車牌偵測通知LINE系統',
        'tech'  => 'Python、YOLO、OpenCV、影像辨識、深度學習模型、API整合、即時通知系統',
        'media' => ['image/車牌辨識V.mp4', 'image/車牌辨識2.png', 'image/車牌辨識3.png'],
        'desc'  => '使用 YOLO 模型與 OpenCV 對影片進行車牌偵測與辨識，整合 LINE API 發送即時通知。學會影像前處理、AI 模型應用、資料串接與自動化通知流程。'
    ],
    [
        'title' => '自動光學瑕疵辨識系統',
        'tech'  => 'C#、Windows Form、影像處理、二值化、濾波與特徵比對、工業檢測應用',
        'media' => ['image/光學辨識1.png', 'image/光學辨識2.png'],
        'desc'  => '開發自動光學檢測系統，對影像進行二值化與濾波處理，再進行特徵比對以檢測晶片瑕疵。熟悉工業影像處理流程、瑕疵檢測演算法及 Windows 桌面程式開發。'
    ],
    [
        'title' => 'NODE購物專案網頁',
        'tech'  => 'Node.js、Express、MySQL、PHP、Session管理、電子商務流程設計、前後端整合',
        'media' => [ 'image/購物網站2.png', 'image/購物網站3.png', 'image/購物網站4.png'],
        'desc'  => '設計線上購物平台，提供商品瀏覽、購物車、會員登入及訂單管理功能，使用 Session 控制購物流程。學會動態網頁開發、後端伺服器運作、資料庫操作、使用者驗證與完整電子商務系統實作。'
    ],
];
?>


<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>作品集展示</title>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css" />
    <style>
        :root {
            --bg: linear-gradient(135deg, #e0ecff 0%, #f8faff 100%);
            --card-bg: rgba(255,255,255,0.8);
            --accent: #2563eb;
            --shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        body { margin: 0; font-family: 'Poppins', 'Noto Sans TC', sans-serif; background: var(--bg); color: #111; overflow-x: hidden; }
        header { text-align: center; padding: 60px 20px 20px; background: rgba(255,255,255,0.5); backdrop-filter: blur(12px); box-shadow: var(--shadow); animation: fadeDown 1s ease both; }
        @keyframes fadeDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }
        header h1 { font-size: 2.6rem; margin:0; font-weight:700; color:#1e3a8a; }
        header p { color:#444; font-size:1.1rem; }
        .container { max-width:1300px; margin:0 auto; padding:40px 20px; }
        .grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(320px, 1fr)); gap:30px; }
        .card { background: var(--card-bg); border-radius:20px; overflow:hidden; box-shadow: var(--shadow); backdrop-filter: blur(16px); transition: transform 0.4s ease, box-shadow 0.4s ease; }
        .card:hover { transform: scale(1.05); box-shadow:0 25px 50px rgba(0,0,0,0.15); }
        .card-body { padding:20px; }
        .card-body strong { font-size:1.4rem; color:#1e40af; }
        .tech { font-size:0.95rem; color:#555; margin-top:6px; display:block; }
        .desc { font-size:1rem; line-height:1.6; color:#333; margin-top:10px; }
        .btn { display:inline-block; margin-top:15px; padding:10px 18px; background:var(--accent); color:#fff; border-radius:12px; text-decoration:none; font-weight:600; transition:background 0.25s ease; }
        .btn:hover { background:#1d4ed8; }
        footer { text-align:center; padding:40px 20px; color:#555; font-size:0.95rem; }
        .modal { position: fixed; inset:0; background: rgba(0,0,0,0.5); display:none; align-items:center; justify-content:center; padding:20px; z-index:10; }
        .modal.show { display:flex; }
        .modal-card { background:#fff; border-radius:16px; max-width:800px; width:100%; overflow:hidden; box-shadow: var(--shadow); animation: pop 0.4s ease; }
        @keyframes pop { from { transform:scale(0.9); opacity:0; } to { transform:scale(1); opacity:1; } }
        .modal-head { display:flex; justify-content:space-between; align-items:center; padding:16px 24px; border-bottom:1px solid #eee; }
        .modal-body { padding:24px; }
        .swiper { width:100%; height:400px; border-radius:12px; overflow:hidden; }
        .swiper-slide img, .swiper-slide video { width:100%; height:100%; object-fit:cover; }
    </style>
</head>
<body>

<header data-aos="fade-down">
    <h1>李子杰的作品集</h1>
</header>

<div class="container">
    <section class="grid">
        <?php foreach($projects as $i => $p): ?>
        <article class="card" data-aos="fade-up" data-aos-delay="<?= $i*100 ?>">
            <div class="card-body">
                <strong><?= htmlspecialchars($p['title']) ?></strong>
                <span class="tech">技術：<?= htmlspecialchars($p['tech']) ?></span>
                <p class="desc"><?= htmlspecialchars($p['desc']) ?></p>
                <a href="#" class="btn" onclick="openModal(<?= $i ?>);return false;">查看詳細內容</a>
            </div>
        </article>
        <?php endforeach; ?>
    </section>
</div>

<footer data-aos="fade-up">
    © <?= date('Y') ?> 子杰 李 — PHP 專業作品集展示頁面
</footer>

<!-- Modal -->
<div id="modal" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-card">
        <div class="modal-head">
            <strong id="modal-title"></strong>
            <button onclick="closeModal()" style="border:none;background:none;font-size:22px;cursor:pointer">✕</button>
        </div>
        <div class="modal-body">
            <div class="swiper modal-swiper">
                <div class="swiper-wrapper" id="modal-media-wrapper">
                    <!-- 動態填充圖片或影片 -->
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="https://unpkg.com/swiper@9/swiper-bundle.min.js"></script>
<script>
AOS.init({ duration:900, offset:100, once:true });

const projects = <?php echo json_encode($projects, JSON_UNESCAPED_UNICODE); ?>;
let swiper;

function openModal(i){
    const p = projects[i];
    document.getElementById('modal-title').innerText = p.title;
    const wrapper = document.getElementById('modal-media-wrapper');
    wrapper.innerHTML = '';
    p.media.forEach(m => {
        let ext = m.split('.').pop().toLowerCase();
        let slide;
        if(['mp4','webm','ogg'].includes(ext)) {
            slide = `<div class="swiper-slide"><video src='${m}' controls></video></div>`;
        } else {
            slide = `<div class="swiper-slide"><img src='${m}'></div>`;
        }
        wrapper.innerHTML += slide;
    });

    document.getElementById('modal').classList.add('show');
    document.getElementById('modal').setAttribute('aria-hidden','false');

    if(swiper) swiper.destroy();
    swiper = new Swiper('.modal-swiper', {
        loop:true,
        navigation: { nextEl:'.swiper-button-next', prevEl:'.swiper-button-prev' },
        pagination: { el:'.swiper-pagination', clickable:true }
    });
}

function closeModal(){
    document.getElementById('modal').classList.remove('show');
    document.getElementById('modal').setAttribute('aria-hidden','true');
}

document.getElementById('modal').addEventListener('click', e=>{ if(e.target===e.currentTarget) closeModal(); });
</script>

</body>
</html>
