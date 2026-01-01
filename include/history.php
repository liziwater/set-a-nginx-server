

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>

<style>
/* ===================
   時間軸＋翻書版面設計
   =================== */
body {
  background: linear-gradient(135deg, #f8f9fa, #e8efff);
  font-family: 'Poppins', sans-serif;
  overflow-x: hidden;
}

.container {
  max-width: 1100px;
  margin: 100px auto;
  position: relative;
  transition: all 0.8s ease;
}

/* 切換按鈕 */
.switch-mode {
  text-align: center;
  margin-bottom: 60px;
}
.switch-btn {
  background: #4f46e5;
  color: #fff;
  padding: 10px 25px;
  border-radius: 50px;
  border: none;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.4s ease;
}
.switch-btn:hover {
  background: #6366f1;
  transform: scale(1.08);
}

/* ======= 時間軸樣式 ======= */
.timeline {
  position: relative;
  margin: 80px 0;
}
.timeline::after {
  content: '';
  position: absolute;
  width: 6px;
  background: #6366f1;
  top: 0;
  bottom: 0;
  left: 50%;
  margin-left: -3px;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
}

.timeline-item {
  padding: 30px 40px;
  position: relative;
  background: #fff;
  border-radius: 20px;
  width: 45%;
  box-shadow: 0 5px 25px rgba(0,0,0,0.1);
  transition: all 0.6s ease;
  margin-bottom: 100px;
  overflow: hidden;
}

.timeline-item.left {
  left: 0;
}
.timeline-item.right {
  left: 55%;
}

/* 讓文字卡與時間線分開一點 */
.timeline-item::before {
  content: '';
  position: absolute;
  top: 40px;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: #6366f1;
  border: 4px solid #fff;
  box-shadow: 0 0 20px rgba(99,102,241,0.5);
}
.timeline-item.left::before {
  right: -60px;
}
.timeline-item.right::before {
  left: -60px;
}

/* 進場動畫 */
.timeline-item[data-aos] {
  transform: translateY(60px);
  opacity: 0;
}
.timeline-item[data-aos].aos-animate {
  transform: translateY(0);
  opacity: 1;
}

/* 卡片內容 */
.timeline-item h3 {
  color: #4f46e5;
  font-weight: 700;
  margin-bottom: 10px;
}
.timeline-item p {
  color: #333;
  line-height: 1.8;
}

/* ======= 翻書模式 ======= */
.book-mode {
  display: none;
  perspective: 1500px;
}
.book {
  width: 90%;
  margin: 0 auto;
  position: relative;
}
.page {
  width: 100%;
  background: white;
  padding: 50px;
  box-shadow: 0 5px 30px rgba(0,0,0,0.15);
  border-radius: 20px;
  transform-origin: left;
  transform-style: preserve-3d;
  transition: transform 1s ease, opacity 0.6s;
  position: absolute;
  top: 0;
  left: 0;
}
.page.flipped {
  transform: rotateY(-180deg);
  opacity: 0;
  z-index: 0;
}
.page-content h3 {
  color: #4f46e5;
  margin-bottom: 15px;
}
.page-content p {
  color: #444;
  line-height: 1.7;
}
.next-btn {
  position: absolute;
  right: 40px;
  bottom: 30px;
  background: #4f46e5;
  color: #fff;
  padding: 8px 18px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}
.next-btn:hover {
  background: #6366f1;
  transform: scale(1.05);
}
</style>

<div class="container">
  <div class="switch-mode">
    <button class="switch-btn" id="switchBtn">📖 翻書模式</button>
  </div>

  <!-- 時間軸模式 -->
  <div class="timeline" id="timelineMode">
    <div class="timeline-item left" data-aos="fade-right">
      <h3>🎓 學業經歷</h3>
      <p>修習程式設計、資料結構、嵌入式系統與AI應用課程，建立資訊系統與邏輯思維基礎。</p>
    </div>

    <div class="timeline-item right" data-aos="fade-left">
      <h3>💻 專題實作</h3>
      <p>以Raspberry Pi建置個人網站伺服器，整合Apache與MariaDB實現雲端資料管理。</p>
    </div>

    <div class="timeline-item left" data-aos="fade-right">
      <h3>🚗 AI 車種辨識</h3>
      <p>運用YOLO模型結合OpenCV實現車輛即時偵測與分類，提升影像辨識精準度。</p>
    </div>
  </div>

  <!-- 翻書模式 -->
  <div class="book-mode" id="bookMode">
    <div class="book">
      <div class="page page1">
        <div class="page-content">
          <h3>🎓 學業經歷</h3>
          <p>修習程式設計、資料結構、嵌入式系統與AI應用課程，建立資訊系統與邏輯思維基礎。</p>
        </div>
        <button class="next-btn">下一頁 ➜</button>
      </div>
      <div class="page page2">
        <div class="page-content">
          <h3>💻 專題實作</h3>
          <p>以Raspberry Pi建置個人網站伺服器，整合Apache與MariaDB實現雲端資料管理。</p>
        </div>
        <button class="next-btn">下一頁 ➜</button>
      </div>
      <div class="page page3">
        <div class="page-content">
          <h3>🚗 AI 車種辨識</h3>
          <p>運用YOLO模型結合OpenCV實現車輛即時偵測與分類，提升影像辨識精準度。</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
AOS.init({ duration: 1000, once: true });

const switchBtn = document.getElementById('switchBtn');
const timelineMode = document.getElementById('timelineMode');
const bookMode = document.getElementById('bookMode');
const pages = document.querySelectorAll('.page');

let currentPage = 0;
switchBtn.addEventListener('click', () => {
  if (timelineMode.style.display !== 'none') {
    timelineMode.style.display = 'none';
    bookMode.style.display = 'block';
    switchBtn.textContent = '⏳ 時間軸模式';
  } else {
    timelineMode.style.display = 'block';
    bookMode.style.display = 'none';
    switchBtn.textContent = '📖 翻書模式';
  }
});

// 翻書功能
document.querySelectorAll('.next-btn').forEach((btn, index) => {
  btn.addEventListener('click', () => {
    pages[index].classList.add('flipped');
    currentPage++;
  });
});
</script>
