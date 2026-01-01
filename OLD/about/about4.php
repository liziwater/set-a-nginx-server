<?php
include 'headfooter/header1.php';
?>

<!-- ================== 動畫進度條 About Us ================== -->
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.3/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.3/ScrollTrigger.min.js"></script>
<link rel="stylesheet" href="css/about-us-animate.css">

<div class="about-wrapper">
  <!-- 左側大字報 + 進度條 -->
  <aside class="progress-sidebar">
    <div class="logo-title">誠訊集團</div>
    <div class="progress-track">
      <div class="progress-bar"></div>
    </div>
  </aside>

  <!-- 主內容 -->
  <section class="about-content-area">
    <header class="section-header" data-aos="fade-up">
      <h1 class="big-title">關於誠訊 Chengxun Group</h1>
      <p class="subtitle">跨領域整合 × 智慧科技 × 未來創新</p>
    </header>

    <!-- 模擬段落1 -->
    <div class="content-block" data-aos="zoom-in" data-aos-delay="200">
      <h2>創立願景</h2>
      <p>誠訊集團成立於2016年，專注於跨界科技應用與產業整合。公司秉持創新精神，結合AI、IoT、智慧製造等技術，為各產業提供數位化轉型解決方案。</p>
    </div>

    <!-- 模擬段落2 -->
    <div class="content-block" data-aos="fade-up" data-aos-delay="400">
      <h2>核心價值</h2>
      <p>誠訊以「專業」、「創新」、「信任」為企業基石，致力於打造高品質品牌形象與永續發展。</p>
    </div>

    <!-- 模擬段落3 -->
    <div class="content-block scale-on-scroll" data-aos="fade-up" data-aos-delay="600">
      <h2>行政架構</h2>
      <p>下方將展示公司主要幹部與組織配置，可自行補入人物資料與動態卡片內容。</p>
    </div>

    <!-- 模擬段落4 -->
    <div class="content-block" data-aos="fade-up" data-aos-delay="800">
      <h2>未來展望</h2>
      <p>我們將持續拓展國際市場，深化AI研發與智能應用，推動企業成為數位產業的核心引擎。</p>
    </div>
  </section>
</div>

<!-- ================== JS 動畫區 ================== -->
<script>
AOS.init({
  duration: 1000,
  once: false
});

// 進度條動畫
window.addEventListener('scroll', () => {
  const scrollTop = window.scrollY;
  const docHeight = document.documentElement.scrollHeight - window.innerHeight;
  const scrollPercent = (scrollTop / docHeight) * 100;
  document.querySelector('.progress-bar').style.height = scrollPercent + '%';
});

// 滑動放大縮小
gsap.utils.toArray(".scale-on-scroll").forEach((el) => {
  gsap.fromTo(el,
    { scale: 0.9, opacity: 0 },
    {
      scale: 1,
      opacity: 1,
      scrollTrigger: {
        trigger: el,
        start: "top 80%",
        end: "bottom 60%",
        scrub: true
      }
    });
});
</script>

<!-- ================== CSS ================== -->
<style>
body {
  margin: 0;
  font-family: 'Noto Sans TC', sans-serif;
  overflow-x: hidden;
  background: #fdfdfd;
}

.about-wrapper {
  display: flex;
  min-height: 100vh;
}

/* 左側進度條 */
.progress-sidebar {
  position: fixed;
  left: 0;
  top: 0;
  width: 160px;
  height: 100vh;
  background: #111;
  color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  z-index: 50;
  text-align: center;
}

.logo-title {
  font-size: 2rem;
  font-weight: 700;
  letter-spacing: 0.2em;
  margin-bottom: 40px;
  writing-mode: vertical-rl;
  text-orientation: mixed;
  transform: rotate(180deg);
  animation: float 3s ease-in-out infinite;
}

/* 浮動效果 */
@keyframes float {
  0%,100% { transform: translateY(0) rotate(180deg); }
  50% { transform: translateY(-10px) rotate(180deg); }
}

/* 進度條 */
.progress-track {
  width: 6px;
  height: 70%;
  background: rgba(255,255,255,0.1);
  border-radius: 3px;
  position: relative;
  overflow: hidden;
}

.progress-bar {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 0;
  background: linear-gradient(180deg, #9c27b0, #673ab7);
  transition: height 0.3s ease-out;
}

/* 主內容 */
.about-content-area {
  margin-left: 160px;
  padding: 100px 80px;
  flex: 1;
}

.section-header {
  text-align: center;
  margin-bottom: 100px;
}

.big-title {
  font-size: 3rem;
  color: #4a148c;
  font-weight: 700;
  letter-spacing: 1px;
  text-shadow: 0 2px 10px rgba(156, 39, 176, 0.2);
  animation: fadeInDown 1.5s ease;
}

.subtitle {
  font-size: 1.2rem;
  color: #555;
  margin-top: 10px;
}

/* 內容卡區 */
.content-block {
  background: #fff;
  padding: 60px;
  margin-bottom: 80px;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.05);
  transform-origin: center;
  transition: transform 0.5s, box-shadow 0.5s;
}

.content-block:hover {
  transform: scale(1.02);
  box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.content-block h2 {
  font-size: 2rem;
  color: #6a1b9a;
  margin-bottom: 20px;
}

.content-block p {
  font-size: 1.1rem;
  color: #444;
  line-height: 1.8;
}

@keyframes fadeInDown {
  from { opacity: 0; transform: translateY(-30px); }
  to { opacity: 1; transform: translateY(0); }
}

/* 響應式 */
@media (max-width: 768px) {
  .progress-sidebar {
    display: none;
  }
  .about-content-area {
    margin-left: 0;
    padding: 60px 20px;
  }
}
</style>

<?php
include 'include/history.php';
include 'headfooter/footer.php';
?>
