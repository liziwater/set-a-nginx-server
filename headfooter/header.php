<!DOCTYPE html>
<html lang="zh-Hant">
<head>
<meta name="google-site-verification" content="AQFWfsOdE-x_ibCuhlxZvJ0G_XgX0LFvkU0dpvW7hJc" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>誠訊e-IMS[李子杰創辦]</title>
  <link rel="stylesheet" href="css/head6.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
  <header>
      <!-- 公司 Logo -->
      <div class="logo">
          <img src="image/GIF.gif" alt="Company Logo">
      </div>
    
      <!-- 導覽列 -->
      <nav>
          <ul class="navbar">
              <li><a href="home.php" class="btn primary"><i class="fas fa-home"></i> 首頁</a></li>
              <li><a href="announcements.php" class="btn secondary"><i class="fas fa-bullhorn"></i> 公告</a></li>
              <li><a href="videos.php" class="btn success"><i class="fab fa-youtube"></i> 影片</a></li>
              <li><a href="404error.php" class="btn success"><i class="fab fa-youtube"></i> 代辦申請</a></li>
              <li><a href="404error.php" class="btn warning"><i class="fas fa-plane"></i> 金融旅遊</a></li>
              <li><a href="National Travel Congress.php" class="btn warning"><i class="fas fa-plane"></i> 國旅大會NCT</a></li>
              <li><a href="404error.php" class="btn danger"><i class="fas fa-user"></i> 員工專區</a></li>
              
              <li class="dropdown">
                  <a href="#" class="btn more"><i class="fas fa-ellipsis-h"></i> 更多服務</a>
                  <ul class="dropdown-menu">
                      <li><a href="addannounce.php" class="btn"><i class="fas fa-comments"></i>高級管理</a></li>
                      <li><a href="404error.php" class="btn"><i class="fas fa-headset"></i> 誠訊行通</a></li>
                      <li><a href="404error.php" class="btn"><i class="fas fa-calendar-alt"></i> 學校</a></li>
                      <li><a href="404error.php" class="btn"><i class="fas fa-book"></i> 客服</a></li>
                      <li><a href="404error.php" class="btn"><i class="fas fa-handshake"></i> 合作</a></li>
                  </ul>
              </li>
              <li><a href="about.php" class="btn info"><i class="fas fa-info-circle"></i> 關於我們</a></li>
          </ul>
      </nav>
  </header>
  
  <!-- 主要內容區 -->
  <main>
      
  </main>
  
  <!-- JavaScript 控制下拉選單 -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 找到「更多服務」按鈕
        const moreBtn = document.querySelector('.more');
        // 找到對應的下拉選單
        const dropdownMenu = document.querySelector('.dropdown-menu');

        // 點擊按鈕切換下拉選單的顯示狀態
        moreBtn.addEventListener('click', function(e) {
            e.preventDefault(); // 阻止連結的預設行為
            dropdownMenu.classList.toggle('show');
        });

        // 點擊頁面其他區域時關閉下拉選單
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                dropdownMenu.classList.remove('show');
            }
        });
    });
  </script>
</body>
</html>
