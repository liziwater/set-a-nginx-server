
<?php
include 'headfooter/header4.php';
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>誠訊團隊-about us</title>

  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Ma+Shan+Zheng&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root{
      --bg: #f5f7fa;
      --card-bg: #ffffff;
      --text: #2c3e50;
      --muted: #5d6d7e;
      --accent: #154360;
      --accent-2: #960000;
      --line: #e9eef2;
      --shadow: 0 18px 40px rgba(17,24,39,0.06);
      --radius: 12px;
      --gap: 24px;
      --modal-bg: rgba(10,12,16,0.6);
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family:"Noto Sans TC","Microsoft JhengHei",system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial;
      background:
        radial-gradient(800px 400px at 0% 0%, rgba(21,67,96,0.03), transparent 40%),
        radial-gradient(700px 350px at 100% 10%, rgba(150,0,0,0.02), transparent 45%),
        var(--bg);
      color:var(--text);
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      line-height:1.6;
    }

    .container{
      max-width:1200px;
      margin:0 auto;
      padding:36px 20px 80px;
    }

    header{
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:16px;
      margin-bottom:18px;
    }
    .brand{
      display:flex;
      gap:14px;
      align-items:center;
    }
    .logo{
      width:44px;height:44px;border-radius:8px;
      background:linear-gradient(135deg,var(--accent),#2b87ff);
      box-shadow:var(--shadow);
      flex:0 0 44px;
    }
    h1{margin:0;font-size:20px;letter-spacing:.02em}
    .subtitle{margin:4px 0 0;color:var(--muted);font-size:13px}

    .founder{
      background:var(--card-bg);
      border:1px solid var(--line);
      border-radius:12px;
      padding:18px;
      box-shadow:var(--shadow);
      margin-bottom:24px;
    }
    .founder h2{margin:0;font-family:'Playfair Display',serif;font-size:20px;color:var(--text)}
    .founder p{margin:12px 0;color:var(--muted);font-size:14px;text-align:justify;line-height:1.8;font-weight:300}
    .founder .sign{display:flex;flex-direction:column;align-items:flex-end;margin-top:12px}
    .sign .name{font-family:'Ma Shan Zheng',cursive;font-size:26px;color:var(--text);transform:rotate(-2deg);margin-bottom:6px}
    .sign .info{font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.08em}

    .group-title{font-size:16px;font-weight:700;margin:18px 0 12px;color:var(--text)}
    .id-grid{
      display:grid;
      grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
      gap:var(--gap);
    }

    /* 新增加的樣式：用於並排顯示協理與部長群 
    */
    .split-group-container {
      display: grid;
      /* 定義兩欄：左側稍微窄一點(適合放一張卡)，右側自動填滿 */
      grid-template-columns: 280px 1fr; 
      gap: 32px;
      margin-top: 28px;
      align-items: start; /* 讓內容靠上對齊 */
    }

    /* 當螢幕變窄時（如手機、平板直立），自動變回上下堆疊 */
    @media (max-width: 960px) {
      .split-group-container {
        grid-template-columns: 1fr;
      }
    }

    .id-card{
      perspective:1400px;
      height:480px;
      position:relative;
      border-radius:12px;
      transition:box-shadow .18s ease, transform .12s ease;
    }
    .id-card:hover{transform:translateY(-6px);box-shadow:0 30px 60px rgba(0,0,0,0.08)}
    .id-inner{
      width:100%;height:100%;position:relative;transition:transform .7s;transform-style:preserve-3d;border-radius:var(--radius);overflow:hidden;border:1px solid var(--line);background:var(--card-bg);
    }
    .side{position:absolute;inset:0;backface-visibility:hidden;display:flex;flex-direction:column}
    .front .topbar{height:10px;background:linear-gradient(90deg,var(--accent),#2b87ff)}
    .front .header{display:flex;justify-content:space-between;align-items:center;padding:12px 14px}
    .company{font-weight:700;font-size:12px;letter-spacing:.08em;text-transform:uppercase}
    .photo{width:140px;height:180px;margin:14px auto;border-radius:6px;overflow:hidden;border:1px solid rgba(0,0,0,0.06);background:#f0f0f0}
    .photo img{width:100%;height:100%;object-fit:cover;display:block}
    .info{padding:10px 14px 8px;text-align:left;flex:0 0 auto}
    .label{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;display:block}
    .name{font-size:18px;font-weight:700;color:var(--text);margin-bottom:6px;border-bottom:2px solid var(--accent);display:inline-block;padding-bottom:6px}
    .position{font-size:13px;color:var(--accent);font-weight:700;margin-bottom:6px}
    .eid{font-family:monospace;font-size:12px;color:#7f8c8d}
    .footer{margin-top:auto;padding:10px;background:linear-gradient(180deg,#fafafa,#fff);border-top:1px solid var(--line);display:flex;align-items:center;justify-content:center;gap:12px}
    .barcode{height:22px;width:60%;background-image:repeating-linear-gradient(90deg,#333 0 1px,transparent 1px 3px);opacity:.45}

    .rank-badge{position:absolute;top:12px;left:12px;background:var(--accent);color:#fff;padding:6px 8px;border-radius:8px;font-size:12px;font-weight:700;box-shadow:0 6px 18px rgba(21,67,96,0.08)}

    .modal {
      position:fixed; inset:0; display:none; align-items:center; justify-content:center;
      background:var(--modal-bg); z-index:1200; padding:24px;
    }
    .modal.open { display:flex; }
    .modal-card {
      width:100%; max-width:920px; background:var(--card-bg); border-radius:14px; box-shadow:0 30px 80px rgba(0,0,0,0.45);
      overflow:hidden; display:grid; grid-template-columns: 320px 1fr; gap:0;
    }
    .modal-left {
      padding:22px; background:linear-gradient(180deg, rgba(21,67,96,0.04), rgba(43,135,255,0.02));
      display:flex; flex-direction:column; align-items:center; gap:12px;
    }
    .modal-left .photo { width:260px; height:340px; border-radius:8px; margin:0; }
    .modal-left .photo img { width:100%; height:100%; object-fit:cover; display:block; }
    .modal-left .meta { text-align:center; margin-top:6px; }
    .modal-left .meta .m-name { font-size:20px; font-weight:700; color:var(--text); }
    .modal-left .meta .m-role { font-size:14px; color:var(--accent); font-weight:700; margin-top:6px; }
    .modal-left .meta .m-id { font-family:monospace; color:#6b7280; margin-top:6px; }

    .modal-right { padding:22px 24px; overflow:auto; max-height:80vh; }
    .modal-right h3 { margin:0 0 8px 0; font-size:20px; }
    .modal-right .subtitle { color:var(--muted); font-size:13px; margin-bottom:12px; }
    .modal-right .section { margin-bottom:14px; }
    .modal-right .section .label { font-weight:700; color:var(--accent); font-size:12px; text-transform:uppercase; letter-spacing:.08em; margin-bottom:6px; display:block; }
    .modal-right .section p { margin:0; color:var(--muted); line-height:1.7; }

    .modal-actions { display:flex; gap:10px; margin-top:16px; }
    .btn { appearance:none; border:0; padding:8px 12px; border-radius:8px; cursor:pointer; font-weight:600; }
    .btn-close { background:#ef4444; color:#fff; }
    .btn-secondary { background:#f3f4f6; color:var(--text); }

    @media (max-width:880px){
      .modal-card { grid-template-columns: 1fr; max-width:720px; }
      .modal-left { order:2; padding:16px; }
      .modal-left .photo { width:100%; height:260px; }
      .modal-right { order:1; padding:16px; }
    }

    @media (max-width:900px){
      .photo{width:120px;height:160px}
      .id-card{height:520px}
    }
    @media (max-width:640px){
      header{flex-direction:column;align-items:flex-start}
      .founder{padding:16px}
      .photo{width:110px;height:150px}
      .id-card{height:560px}
    }

    .highlight { box-shadow: 0 0 0 4px rgba(43,135,255,0.08) inset; border-color: var(--accent); }
  </style>
</head>
<body>
  <div class="container">

    <header>
      <div class="brand">
        <div class="logo" aria-hidden="true"></div>
        <div>
          <h1>誠訊團隊</h1>
          <div class="subtitle">團隊成員與專任領域</div>
        </div>
      </div>
      <div style="display:flex;gap:12px;align-items:center">
        <div style="display:inline-flex;align-items:center;gap:8px;background:var(--accent);color:#fff;padding:6px 10px;border-radius:20px;font-size:13px;box-shadow:0 6px 18px rgba(21,67,96,0.12)">
          <i class="fa-solid fa-id-badge"></i> 全部展開
        </div>
      </div>
    </header>

    <section class="founder" aria-labelledby="founder-title">
      <div style="display:flex;justify-content:space-between;align-items:center">
        <div>
          <div class="kicker" style="color:var(--accent-2);font-weight:700;letter-spacing:.12em;text-transform:uppercase;font-size:12px">FOUNDER'S MESSAGE</div>
          <h2 id="founder-title">創辦人致詞</h2>
        </div>
      </div>

      <div class="letter">
        <p>好作品值得被人欣賞與借鑒，期望大家能夠在成長過程中，持續鼓勵與進步。透過成立「誠訊工作室」維繫羈絆，期待未來能逐步發展成「誠訊集團」。</p>
        <p>一路上，跨領域夥伴的支持讓我們不斷成長。感謝大家的陪伴，也期許大家都能在專業領域發光發熱，持續以品質與創新為社會創造價值。</p>
      </div>

      <div class="sign">
        <div class="name">李子杰</div>
        <div class="info">Founder &amp; CEO — ChengXun Group</div>
      </div>
    </section>

    <div>
      <div class="group-title">長官群</div>
      <div class="id-grid" role="list">

        <div class="id-card" role="listitem" tabindex="0"
             data-name="李子杰" data-position="創辦人／董事長" data-eid="CX-0001"
             data-photo="image/李子杰.PNG"
             data-specialty="專任資訊整合與創意研發專家"
             data-intro="專任資訊整合與創意研發，帶領技術與創意團隊推動系統整合與創新專案。"
             data-contact="個人辦公室：總部線上雲端辦公室 10 樓（分機 101）"
             onclick="openModal(this)">
          <div class="rank-badge">董事長</div>
          <div class="id-inner">
            <div class="side front">
              <div class="topbar"></div>
              <div class="header"><div class="company">CHENGXUN GROUP</div></div>
              <div class="photo"><img src="image/李子杰.PNG" alt="李子杰" onerror="this.src='https://placehold.co/300x400?text=No+Photo'"></div>
              <div class="info">
                <span class="label">Name</span><div class="name">李子杰</div>
                <span class="label">Position</span><div class="position">創辦人／董事長</div>
                <span class="label">Employee ID</span><div class="eid">CX-0001</div>
              </div>
              <div class="footer"><div class="barcode" aria-hidden="true"></div></div>
            </div>
          </div>
        </div>

        <div class="id-card" role="listitem" tabindex="0"
             data-name="李映葳" data-position="總經理" data-eid="CX-1001"
             data-photo="image/李映葳.PNG"
             data-specialty="專任行銷財經專家"
             data-intro="專任行銷與財經專家，擅長市場策略、品牌經營與財務規劃。"
             data-contact="個人辦公室：總部線上雲端辦公室 8 樓（分機 201）"
             onclick="openModal(this)">
          <div class="rank-badge" style="background:#2b87ff">總經理</div>
          <div class="id-inner">
            <div class="side front">
              <div class="topbar"></div>
              <div class="header"><div class="company">CHENGXUN GROUP</div></div>
              <div class="photo"><img src="image/李映葳.PNG" alt="李映葳" onerror="this.src='https://placehold.co/300x400?text=No+Photo'"></div>
              <div class="info">
                <span class="label">Name</span><div class="name">李映葳</div>
                <span class="label">Position</span><div class="position">總經理</div>
                <span class="label">Employee ID</span><div class="eid">CX-1001</div>
              </div>
              <div class="footer"><div class="barcode" aria-hidden="true"></div></div>
            </div>
          </div>
        </div>

        <div class="id-card" role="listitem" tabindex="0"
             data-name="陳柏蓁" data-position="副總經理" data-eid="CX-2001"
             data-photo="image/陳柏蓁.PNG"
             data-specialty="專任永續發展目標專家"
             data-intro="專任永續發展目標專家，推動企業永續策略與 ESG 專案。"
             data-contact="個人辦公室：總部線上雲端辦公室 3 樓（分機 302）"
             onclick="openModal(this)">
          <div class="rank-badge" style="background:#ff8a65">副總經理</div>
          <div class="id-inner">
            <div class="side front">
              <div class="topbar"></div>
              <div class="header"><div class="company">CHENGXUN GROUP</div></div>
              <div class="photo"><img src="image/陳柏蓁.PNG" alt="陳柏蓁" onerror="this.src='https://placehold.co/300x400?text=No+Photo'"></div>
              <div class="info">
                <span class="label">Name</span><div class="name">陳柏蓁</div>
                <span class="label">Position</span><div class="position">副總經理</div>
                <span class="label">Employee ID</span><div class="eid">CX-2001</div>
              </div>
              <div class="footer"><div class="barcode" aria-hidden="true"></div></div>
            </div>
          </div>
        </div>

        <div class="id-card" role="listitem" tabindex="0"
             data-name="呂晉瑋" data-position="副總經理" data-eid="CX-2002"
             data-photo="image/呂晉瑋.PNG"
             data-specialty="專任服務架構外商專家"
             data-intro="專任服務架構與外商合作專家，擅長跨國專案協調與服務設計。"
             data-contact="個人辦公室：總部線上雲端辦公室 5 樓（分機 405）"
             onclick="openModal(this)">
          <div class="rank-badge" style="background:#ff8a65">副總經理</div>
          <div class="id-inner">
            <div class="side front">
              <div class="topbar"></div>
              <div class="header"><div class="company">CHENGXUN GROUP</div></div>
              <div class="photo"><img src="image/呂晉瑋.PNG" alt="呂晉瑋" onerror="this.src='https://placehold.co/300x400?text=No+Photo'"></div>
              <div class="info">
                <span class="label">Name</span><div class="name">呂晉瑋</div>
                <span class="label">Position</span><div class="position">副總經理</div>
                <span class="label">Employee ID</span><div class="eid">CX-2002</div>
              </div>
              <div class="footer"><div class="barcode" aria-hidden="true"></div></div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="split-group-container">
      
      <div>
        <div class="group-title">附屬長官群 / 中層主管</div>
        <div class="id-grid" role="list" style="grid-template-columns: 1fr;"> <div class="id-card" role="listitem" tabindex="0"
               data-name="謝秉棋" data-position="營運事業群協理" data-eid="CX-0201"
               data-photo="image/XIE.jpg"
               data-specialty="專任資訊架構整合服務專家"
               data-intro="專任資訊架構整合與服務專家，負責系統整合與營運流程優化。"
               data-contact="個人辦公室：總部線上雲端辦公室 4 樓（分機 412）"
               onclick="openModal(this)">
            <div class="rank-badge" style="background:#7fb3ff">群協理</div>
            <div class="id-inner">
              <div class="side front">
                <div class="topbar"></div>
                <div class="header"><div class="company">CHENGXUN GROUP</div></div>
                <div class="photo"><img src="image/XIE.jpg" alt="謝秉棋" onerror="this.src='https://placehold.co/300x400?text=No+Photo'"></div>
                <div class="info">
                  <span class="label">Name</span><div class="name">謝秉棋</div>
                  <span class="label">Position</span><div class="position">營運事業群協理</div>
                  <span class="label">Employee ID</span><div class="eid">CX-0201</div>
                </div>
                <div class="footer"><div class="barcode" aria-hidden="true"></div></div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div>
        <div class="group-title">部長群</div>
        <div class="id-grid" role="list">

          <div class="id-card" role="listitem" tabindex="0"
               data-name="王芷琳" data-position="廣告宣傳部部長" data-eid="CX-3001"
               data-photo="image/王芷琳.jpg"
               data-specialty="專任媒體娛樂企劃專家"
               data-intro="專任媒體與娛樂企劃專家，擅長內容策略與多平台曝光規劃。"
               data-contact="個人辦公室：總部線上雲端辦公室 6 樓（分機 621）"
               onclick="openModal(this)">
            <div class="rank-badge" style="background:#9be7d1">部長</div>
            <div class="id-inner">
              <div class="side front">
                <div class="topbar"></div>
                <div class="header"><div class="company">CHENGXUN GROUP</div></div>
                <div class="photo"><img src="image/王芷琳.jpg" alt="王芷琳" onerror="this.src='https://placehold.co/300x400?text=No+Photo'"></div>
                <div class="info">
                  <span class="label">Name</span><div class="name">王芷琳</div>
                  <span class="label">Position</span><div class="position">廣告宣傳部部長</div>
                  <span class="label">Employee ID</span><div class="eid">CX-3001</div>
                </div>
                <div class="footer"><div class="barcode" aria-hidden="true"></div></div>
              </div>
            </div>
          </div>

          <div class="id-card" role="listitem" tabindex="0"
               data-name="馬梓晉" data-position="技術部部長" data-eid="CX-4001"
               data-photo="image/馬梓晉.png"
               data-specialty="專任技術整合含機電專家"
               data-intro="專任技術整合（含機電）專家，負責技術架構與研發整合。"
               data-contact="個人辦公室：總部線上雲端辦公室 7 樓（分機 731）"
               onclick="openModal(this)">
            <div class="rank-badge" style="background:#9be7d1">部長</div>
            <div class="id-inner">
              <div class="side front">
                <div class="topbar"></div>
                <div class="header"><div class="company">CHENGXUN GROUP</div></div>
                <div class="photo"><img src="image/馬梓晉.png" alt="馬梓晉" onerror="this.src='https://placehold.co/300x400?text=No+Photo'"></div>
                <div class="info">
                  <span class="label">Name</span><div class="name">馬梓晉</div>
                  <span class="label">Position</span><div class="position">技術部部長</div>
                  <span class="label">Employee ID</span><div class="eid">CX-4001</div>
                </div>
                <div class="footer"><div class="barcode" aria-hidden="true"></div></div>
              </div>
            </div>
          </div>

          <div class="id-card" role="listitem" tabindex="0"
               data-name="陳振輝" data-position="法務部部長" data-eid="CX-5001"
               data-photo="image/陳振輝.png"
               data-specialty="專任法律與公關安全處理專家"
               data-intro="專任法律與公關安全處理專家，負責合規、契約與危機應對。"
               data-contact="個人辦公室：總部線上雲端辦公室 2 樓（分機 221）"
               onclick="openModal(this)">
            <div class="rank-badge" style="background:#9be7d1">部長</div>
            <div class="id-inner">
              <div class="side front">
                <div class="topbar"></div>
                <div class="header"><div class="company">CHENGXUN GROUP</div></div>
                <div class="photo"><img src="image/陳振輝.png" alt="陳振輝" onerror="this.src='https://placehold.co/300x400?text=No+Photo'"></div>
                <div class="info">
                  <span class="label">Name</span><div class="name">陳振輝</div>
                  <span class="label">Position</span><div class="position">法務部部長</div>
                  <span class="label">Employee ID</span><div class="eid">CX-5001</div>
                </div>
                <div class="footer"><div class="barcode" aria-hidden="true"></div></div>
              </div>
            </div>
          </div>

        </div>
      </div>
      
    </div>
    <footer style="margin-top:36px;color:var(--muted);font-size:13px;text-align:center">
      © 2025 誠訊。以專業與創新，持續打造長久價值。
    </footer>
  </div>

  <div id="personModal" class="modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="modalTitle">
    <div class="modal-card" role="document">
      <div class="modal-left">
        <div class="photo"><img id="modalPhoto" src="https://placehold.co/600x800?text=No+Photo" alt=""></div>
        <div class="meta">
          <div class="m-name" id="modalName">姓名</div>
          <div class="m-role" id="modalRole">職稱</div>
          <div class="m-id" id="modalEid">ID</div>
        </div>
      </div>

      <div class="modal-right">
        <h3 id="modalTitle">姓名</h3>
        <div class="subtitle" id="modalSubtitle">專任領域</div>

        <div class="section">
          <span class="label">專任領域</span>
          <p id="modalSpecialty">專任內容</p>
        </div>

        <div class="section">
          <span class="label">個人介紹</span>
          <p id="modalIntro">個人介紹文字</p>
        </div>

        <div class="section">
          <span class="label">個人辦公室</span>
          <p id="modalContact">個人辦公室資訊</p>
        </div>

        <div class="modal-actions">
          <button class="btn btn-close" id="modalCloseBtn" aria-label="關閉視窗">關閉</button>
          <button class="btn btn-secondary" id="modalCloseBg" aria-label="返回">返回</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const modal = document.getElementById('personModal');
    const modalPhoto = document.getElementById('modalPhoto');
    const modalName = document.getElementById('modalName');
    const modalRole = document.getElementById('modalRole');
    const modalEid = document.getElementById('modalEid');
    const modalTitle = document.getElementById('modalTitle');
    const modalSubtitle = document.getElementById('modalSubtitle');
    const modalSpecialty = document.getElementById('modalSpecialty');
    const modalIntro = document.getElementById('modalIntro');
    const modalContact = document.getElementById('modalContact');
    const modalCloseBtn = document.getElementById('modalCloseBtn');
    const modalCloseBg = document.getElementById('modalCloseBg');

    function openModal(cardEl){
      if(!cardEl) return;
      const name = cardEl.getAttribute('data-name') || '';
      const position = cardEl.getAttribute('data-position') || '';
      const eid = cardEl.getAttribute('data-eid') || '';
      const photo = cardEl.getAttribute('data-photo') || ('image/' + name + '.png');
      const specialty = cardEl.getAttribute('data-specialty') || '';
      const intro = cardEl.getAttribute('data-intro') || '';
      const contact = cardEl.getAttribute('data-contact') || ('個人辦公室：' + position);

      modalPhoto.src = photo;
      modalPhoto.alt = name;
      modalName.textContent = name;
      modalRole.textContent = position;
      modalEid.textContent = eid;
      modalTitle.textContent = name;
      modalSubtitle.textContent = specialty;
      modalSpecialty.textContent = specialty;
      modalIntro.textContent = intro;
      modalContact.textContent = contact;

      modal.classList.add('open');
      modal.setAttribute('aria-hidden', 'false');

      lastFocused = document.activeElement;
      modalCloseBtn.focus();
      document.body.style.overflow = 'hidden';
    }

    function closeModal(){
      modal.classList.remove('open');
      modal.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
      if(lastFocused) lastFocused.focus();
    }

    modal.addEventListener('click', function(e){
      if(e.target === modal || e.target === modalCloseBg){
        closeModal();
      }
    });

    modalCloseBtn.addEventListener('click', closeModal);

    document.addEventListener('keydown', function(e){
      if(e.key === 'Escape' && modal.classList.contains('open')){
        closeModal();
      }
    });

    document.querySelectorAll('.photo img').forEach(function(img){
      img.addEventListener('error', function(){
        this.src = 'https://placehold.co/600x800?text=No+Photo';
      });
    });

    document.querySelectorAll('.id-card').forEach(function(card){
      card.addEventListener('keydown', function(e){
        if(e.key === 'Enter' || e.key === ' '){
          e.preventDefault();
          openModal(card);
        }
      });
      card.addEventListener('click', function(e){
        const tag = e.target.tagName.toLowerCase();
        if(tag === 'a' || e.target.closest('a')) return;
        openModal(card);
      });
    });

    let lastFocused = null;
  </script>
</body>
</html>
