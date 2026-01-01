<?php
include 'headfooter/header1.php';
?>

<link rel="stylesheet" href="css/about-us0.css">
<script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Noto Sans TC', sans-serif;
    overflow-x: hidden;
    background: #0a0a0a;
}

/* 進度條 */
.progress-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: rgba(255, 255, 255, 0.1);
    z-index: 9999;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #ff0080, #7928ca, #00d4ff);
    width: 0%;
    transition: width 0.3s ease;
    box-shadow: 0 0 20px rgba(255, 0, 128, 0.8);
}

/* 頁面指示器 */
.page-indicator {
    position: fixed;
    right: 40px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.page-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.page-dot::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    transition: all 0.3s ease;
}

.page-dot:hover::before {
    width: 24px;
    height: 24px;
}

.page-dot.active {
    background: linear-gradient(135deg, #ff0080, #7928ca);
    box-shadow: 0 0 20px rgba(255, 0, 128, 0.6);
    transform: scale(1.3);
}

/* 翻頁容器 */
.flipbook-container {
    width: 100%;
    min-height: 100vh;
    position: relative;
}

.page-section {
    width: 100%;
    min-height: 100vh;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: translateY(100px);
    transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
}

.page-section.active {
    opacity: 1;
    transform: translateY(0);
}

/* 首頁 - 介紹頁 */
.intro-page {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    overflow: hidden;
}

.intro-content {
    max-width: 1400px;
    width: 90%;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}

.big-title {
    font-size: 8rem;
    font-weight: 900;
    line-height: 1;
    color: #fff;
    text-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: floatTitle 6s ease-in-out infinite;
}

@keyframes floatTitle {
    0%, 100% { transform: translateY(0) rotate(-2deg); }
    50% { transform: translateY(-20px) rotate(2deg); }
}

.intro-text {
    color: #fff;
}

.intro-text h2 {
    font-size: 3rem;
    margin-bottom: 30px;
    opacity: 0;
    animation: fadeInUp 1s ease forwards 0.3s;
}

.intro-text p {
    font-size: 1.3rem;
    line-height: 2;
    opacity: 0;
    animation: fadeInUp 1s ease forwards 0.6s;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
    from {
        opacity: 0;
        transform: translateY(30px);
    }
}

/* 領導團隊頁 */
.team-page {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    padding: 100px 0;
}

.team-grid {
    max-width: 1400px;
    width: 90%;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 40px;
}

.page-title {
    position: absolute;
    top: 80px;
    left: 80px;
    font-size: 5rem;
    font-weight: 900;
    color: rgba(255, 255, 255, 0.15);
    z-index: 1;
    animation: floatSlow 8s ease-in-out infinite;
}

@keyframes floatSlow {
    0%, 100% { transform: translateX(0); }
    50% { transform: translateX(30px); }
}

/* 人物卡片 */
.leader-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 30px;
    overflow: hidden;
    position: relative;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    animation: cardFloat 3s ease-in-out infinite;
}

.leader-card:nth-child(even) {
    animation-delay: 1.5s;
}

@keyframes cardFloat {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(1deg); }
}

.leader-card:hover {
    transform: translateY(-20px) scale(1.05) rotate(0deg) !important;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
    animation: none;
}

.leader-photo-container {
    position: relative;
    height: 350px;
    overflow: hidden;
}

.leader-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.leader-card:hover .leader-photo {
    transform: scale(1.15) rotate(3deg);
}

.vacancy-label {
    position: absolute;
    top: 20px;
    right: 0;
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    color: #fff;
    padding: 10px 25px;
    font-size: 0.9rem;
    font-weight: 700;
    border-radius: 30px 0 0 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.leader-info {
    padding: 30px;
}

.leader-name {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
}

.leader-role {
    color: #f5576c;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 20px;
}

.read-more {
    display: inline-block;
    color: #667eea;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    padding-bottom: 5px;
}

.read-more::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transition: width 0.3s ease;
}

.read-more:hover::after {
    width: 100%;
}

.leader-bio {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s ease;
    margin-top: 15px;
}

.leader-bio p {
    color: #666;
    line-height: 1.8;
    margin-bottom: 15px;
}

.leader-bio-toggle.active .leader-bio {
    max-height: 1000px;
}

/* 職缺頁 */
.vacancy-page {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.vacancy-content {
    max-width: 1200px;
    width: 90%;
    text-align: center;
    color: #fff;
}

.vacancy-content h2 {
    font-size: 4rem;
    margin-bottom: 40px;
    animation: fadeInUp 1s ease;
}

.vacancy-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 60px;
}

.vacancy-item {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 40px;
    transition: all 0.4s ease;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.vacancy-item:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.3);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.vacancy-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* 導航按鈕 */
.nav-buttons {
    position: fixed;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 20px;
    z-index: 1000;
}

.nav-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    font-size: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.nav-btn:hover {
    background: rgba(255, 255, 255, 0.4);
    transform: scale(1.1);
}

.nav-btn:disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

/* 響應式 */
@media (max-width: 1024px) {
    .intro-content {
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
    }
    
    .big-title {
        font-size: 5rem;
    }
    
    .page-title {
        font-size: 3rem;
        top: 40px;
        left: 40px;
    }
}

@media (max-width: 768px) {
    .big-title {
        font-size: 3.5rem;
    }
    
    .intro-text h2 {
        font-size: 2rem;
    }
    
    .intro-text p {
        font-size: 1.1rem;
    }
    
    .team-grid {
        grid-template-columns: 1fr;
    }
    
    .page-indicator {
        right: 20px;
    }
    
    .nav-buttons {
        bottom: 20px;
    }
}
</style>

<!-- 進度條 -->
<div class="progress-container">
    <div class="progress-bar" id="progressBar"></div>
</div>

<!-- 頁面指示器 -->
<div class="page-indicator" id="pageIndicator"></div>

<!-- 翻頁容器 -->
<div class="flipbook-container" id="flipbook">
    
    <!-- 第一頁：介紹 -->
    <section class="page-section intro-page active" data-page="0">
        <div class="intro-content">
            <div class="big-title">
                誠訊<br>集團
            </div>
            <div class="intro-text">
                <h2><span id="typed-title"></span></h2>
                <p id="typed-description"></p>
            </div>
        </div>
    </section>

    <!-- 第二頁：核心領導 -->
    <section class="page-section team-page" data-page="1">
        <div class="page-title">LEADERSHIP</div>
        <div class="team-grid">
            <div class="leader-card" data-aos="fade-up">
                <div class="leader-photo-container">
                    <img src="image/李子杰.PNG" alt="李子杰" class="leader-photo">
                    <div class="vacancy-label">董事會換組</div>
                </div>
                <div class="leader-info">
                    <h3 class="leader-name">李子杰</h3>
                    <p class="leader-role">創辦人、法人、東洋副總經理</p>
                    <div class="leader-bio-toggle">
                        <span class="read-more">查看簡介 ▼</span>
                        <div class="leader-bio">
                            <p>李子杰先生擁有豐富的科技研發與企業管理經驗,以獨到的視野與前瞻思維引領業界。他於2016年創立誠訊集團,以創新精神和市場洞察力推動企業在數位科技領域穩健成長。</p>
                            <p>畢業於南臺科技大學電子工程系,並持續進修數位科技相關領域,提升專業實力。前任東洋全方位最高執行長,現任東洋副總經理。</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="leader-card" data-aos="fade-up" data-aos-delay="100">
                <div class="leader-photo-container">
                    <img src="image/陳柏蓁.PNG" alt="陳柏蓁" class="leader-photo">
                </div>
                <div class="leader-info">
                    <h3 class="leader-name">陳柏蓁</h3>
                    <p class="leader-role">副總經理</p>
                    <div class="leader-bio-toggle">
                        <span class="read-more">查看簡介 ▼</span>
                        <div class="leader-bio">
                            <p>陳柏蓁先生現任誠訊集團副總經理,並擔任東洋全方位董事最高執行長,擁有豐富的計畫研究與管理經驗。在策略規劃與業務拓展方面展現卓越的領導能力。</p>
                            <p>畢業於國立嘉義大學森林系,曾擔任東洋唱片製作執行人,精通行程安排、交通規劃與旅遊產業運營。</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="leader-card" data-aos="fade-up" data-aos-delay="200">
                <div class="leader-photo-container">
                    <img src="image/呂晉瑋.PNG" alt="呂晉瑋" class="leader-photo">
                </div>
                <div class="leader-info">
                    <h3 class="leader-name">呂晉瑋</h3>
                    <p class="leader-role">副總經理、處長</p>
                    <div class="leader-bio-toggle">
                        <span class="read-more">查看簡介 ▼</span>
                        <div class="leader-bio">
                            <p>呂晉瑋先生現任誠訊集團副總經理兼協理,擁有卓越的國際視野與市場洞察力。曾於高鐵嘉義站擔任站務人員,以全國統測餐旅群第四名的成績錄取國立高雄餐旅大學。</p>
                            <p>憑藉出色的外語能力,負責國際貿易事務,專注於東亞市場發展,特別是動漫產業領域。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 第三頁：部門主管 -->
    <section class="page-section team-page" data-page="2">
        <div class="page-title">MANAGEMENT</div>
        <div class="team-grid">
            <div class="leader-card" data-aos="fade-up">
                <div class="leader-photo-container">
                    <img src="image/李映葳.PNG" alt="李映葳" class="leader-photo">
                </div>
                <div class="leader-info">
                    <h3 class="leader-name">李映葳</h3>
                    <p class="leader-role">協理、營運部長</p>
                    <div class="leader-bio-toggle">
                        <span class="read-more">查看簡介 ▼</span>
                        <div class="leader-bio">
                            <p>李映葳小姐現任誠訊集團協理兼營運總部長,畢業於國立台中科技大學國際貿易與經營系。擁有獨到的市場洞察力與卓越的經營智慧。</p>
                            <p>身為招商能手,擅長精準掌握市場趨勢,成功打造自有品牌,並促成多項商業合作。</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="leader-card" data-aos="fade-up" data-aos-delay="100">
                <div class="leader-photo-container">
                    <img src="image/王芷琳.jpg" alt="王芷琳" class="leader-photo">
                    <div class="vacancy-label">侯任10月1日</div>
                </div>
                <div class="leader-info">
                    <h3 class="leader-name">王芷琳</h3>
                    <p class="leader-role">社群部長</p>
                    <div class="leader-bio-toggle">
                        <span class="read-more">查看簡介 ▼</span>
                        <div class="leader-bio">
                            <p>王芷琳目前擔任誠訊集團社群部長,曾就讀於國立成功大學,目前於義守大學物理治療學系持續進修,兼具醫學背景與數位思維。</p>
                            <p>擁有獨到的觀察力與精準的市場判斷能力,能迅速掌握網路流量變化與趨勢,成功為公司開拓多元曝光與穩定成長的流量來源。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 第四頁:職缺 -->
    <section class="page-section vacancy-page" data-page="3">
        <div class="vacancy-content">
            <h2>加入我們的團隊</h2>
            <p style="font-size: 1.3rem; margin-bottom: 20px;">我們正在尋找優秀的人才</p>
            
            <div class="vacancy-grid">
                <div class="vacancy-item">
                    <div class="vacancy-icon">📚</div>
                    <h3 style="font-size: 2rem; margin-bottom: 15px;">學術部長</h3>
                    <p>負責學術研究與發展規劃</p>
                </div>
                
                <div class="vacancy-item">
                    <div class="vacancy-icon">⚖️</div>
                    <h3 style="font-size: 2rem; margin-bottom: 15px;">法務部長</h3>
                    <p>負責法律事務與合規管理</p>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- 導航按鈕 -->
<div class="nav-buttons">
    <button class="nav-btn" id="prevBtn" onclick="prevPage()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="nav-btn" id="nextBtn" onclick="nextPage()">
        <i class="fas fa-chevron-right"></i>
    </button>
</div>

<script>
let currentPage = 0;
const pages = document.querySelectorAll('.page-section');
const totalPages = pages.length;
const progressBar = document.getElementById('progressBar');
const pageIndicator = document.getElementById('pageIndicator');

// 初始化頁面指示器
for (let i = 0; i < totalPages; i++) {
    const dot = document.createElement('div');
    dot.className = 'page-dot' + (i === 0 ? ' active' : '');
    dot.onclick = () => goToPage(i);
    pageIndicator.appendChild(dot);
}

// 打字效果
document.addEventListener('DOMContentLoaded', function() {
    new Typed('#typed-title', {
        strings: ['跨領域系聯名', '創新科技領航者'],
        typeSpeed: 60,
        backSpeed: 40,
        backDelay: 2000,
        startDelay: 500,
        loop: true,
        showCursor: true,
        cursorChar: '|'
    });
    
    setTimeout(function() {
        new Typed('#typed-description', {
            strings: ['誠訊成立於2016年,感謝所有合作夥伴與客戶的支持,讓我們持續成長與進步。我們致力於創新科技與優質服務,為客戶創造最大價值。'],
            typeSpeed: 30,
            startDelay: 500,
            showCursor: false,
            loop: false
        });
    }, 1500);
});

// 翻頁功能
function goToPage(pageNum) {
    if (pageNum < 0 || pageNum >= totalPages) return;
    
    pages[currentPage].classList.remove('active');
    document.querySelectorAll('.page-dot')[currentPage].classList.remove('active');
    
    currentPage = pageNum;
    
    pages[currentPage].classList.add('active');
    document.querySelectorAll('.page-dot')[currentPage].classList.add('active');
    
    updateProgress();
    updateButtons();
}

function nextPage() {
    if (currentPage < totalPages - 1) {
        goToPage(currentPage + 1);
    }
}

function prevPage() {
    if (currentPage > 0) {
        goToPage(currentPage - 1);
    }
}

function updateProgress() {
    const progress = ((currentPage + 1) / totalPages) * 100;
    progressBar.style.width = progress + '%';
}

function updateButtons() {
    document.getElementById('prevBtn').disabled = currentPage === 0;
    document.getElementById('nextBtn').disabled = currentPage === totalPages - 1;
}

// 鍵盤導航
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
        nextPage();
    } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
        prevPage();
    }
});

// 滑鼠滾輪導航
let isScrolling = false;
document.addEventListener('wheel', function(e) {
    if (isScrolling) return;
    
    isScrolling = true;
    setTimeout(() => isScrolling = false, 800);
    
    if (e.deltaY > 0) {
        nextPage();
    } else {
        prevPage();
    }
});

// 簡介展開/收合
document.querySelectorAll('.read-more').forEach(function(button) {
    button.addEventListener('click', function(e) {
        e.stopPropagation();
        const toggle = this.closest('.leader-bio-toggle');
        const isActive = toggle.classList.contains('active');
        
        if (isActive) {
            toggle.classList.remove('active');
            this.innerHTML = '查看簡介 ▼';
        } else {
            toggle.classList.add('active');
            this.innerHTML = '收起 ▲';
        }
    });
});

// 初始化
updateProgress();
updateButtons();
</script>

<?php
include 'include/history.php';
include 'headfooter/footer.php';
?>