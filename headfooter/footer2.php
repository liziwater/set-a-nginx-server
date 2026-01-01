<!-- footer.php -->
<footer>
  <div class="footer-container">
    <div class="footer-section">
      <div class="footer-logo">
        <img src="image/LOGO.png" alt="誠訊國際" style="height: 40px;">
      </div>
      <p style="color: #666; margin-top: 12px;"></p>
    </div>

    <div class="footer-columns">
      <div class="footer-col">
        <h4>快速連結</h4>
        <ul class="footer-links">
          <li><a href="home.php"><i class="fas fa-chevron-right"></i>系統首頁</a></li>
          <!-- 其他連結保持不變 -->
        </ul>
      </div>

      <div class="footer-col">
        <h4>聯絡資訊</h4>
        <ul class="footer-links">
          <li><i class="fas fa-phone"></i>0938932852</li>
          <li><i class="fas fa-envelope"></i>chengxun.llc@gmail.com</li>
          <li><i class="fas fa-map-marker-alt"></i>台灣台南市</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="copyright">
    <p>&copy; <?php echo date('Y'); ?> 誠訊股份有限公司</p>
    <p>建議使用最新版Chrome瀏覽器</p>
  </div>
</footer>

<style>
  /* Footer 樣式 */
  footer {
    background: #fff;
    border-top: 1px solid #f5f5f5;
    padding: 48px 24px 24px;
    margin-top: 80px;
  }

  .footer-container {
    max-width: 1280px;
    margin: 0 auto;
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
  }

  .footer-columns {
    flex: 1;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 40px;
  }

  .footer-col h4 {
    color: #444;
    font-size: 1.1em;
    margin-bottom: 20px;
    padding-bottom: 8px;
    border-bottom: 1px solid #eee;
  }

  .footer-links {
    list-style: none;
  }

  .footer-links li {
    margin-bottom: 12px;
  }

  .footer-links a, .footer-links i {
    color: #666;
    text-decoration: none;
    transition: color 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .footer-links a:hover {
    color: #2c3e50;
  }

  .copyright {
    text-align: center;
    margin-top: 40px;
    padding-top: 24px;
    border-top: 1px solid #f5f5f5;
    color: #888;
    font-size: 0.9em;
  }

  @media (max-width: 768px) {
    .footer-container {
      flex-direction: column;
      gap: 32px;
    }
    
    .footer-columns {
      grid-template-columns: 1fr;
    }
  }
</style>
</body>
</html>