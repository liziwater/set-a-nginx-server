<?php
include 'headfooter/header3.php';
?>
<?php
$apiUrl = "https://script.google.com/macros/s/AKfycbycWC-a2NUFchZ4Skd8SSYyArZ_IXTPVGyjXDzjSjBuxVS_Bg9kcAzNvHYerLVWeFqrKw/exec";
$announcements = json_decode(file_get_contents($apiUrl), true);

// 取得篩選單位
$filterUnit = isset($_GET['unit']) ? $_GET['unit'] : '全部';

// 篩選公告
$filteredAnnouncements = [];
foreach($announcements as $a){
    if($filterUnit === '全部' || $a['發送單位'] === $filterUnit){
        $filteredAnnouncements[] = $a;
    }
}

// 按日期排序，最新在前
usort($filteredAnnouncements, function($a, $b){
    return strtotime($b['時間']) - strtotime($a['時間']);
});

// 用於顯示摘要的字數
$summaryLength = 100;
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>公司公告牆</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body { 
    background: #f8f9fa;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Microsoft JhengHei", Arial, sans-serif;
    min-height: 100vh;
    padding: 0;
    color: #2c3e50;
}

.header {
    background: white;
    border-bottom: 1px solid #e1e4e8;
    padding: 32px 20px;
    margin-bottom: 40px;
}

.header-inner {
    max-width: 1100px;
    margin: 0 auto;
}

.header h1 {
    font-size: 2em;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
}

.header p {
    font-size: 0.95em;
    color: #6c757d;
}

.container { 
    max-width: 1100px; 
    margin: 0 auto; 
    padding: 0 20px 60px 20px; 
}

/* 篩選區域 */
.filter-section {
    background: white;
    padding: 20px 24px;
    border-radius: 8px;
    border: 1px solid #e1e4e8;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
}

.filter-section label {
    font-size: 0.95em;
    font-weight: 500;
    color: #1a1a1a;
}

.filter-section select {
    flex: 1;
    max-width: 280px;
    padding: 10px 16px;
    font-size: 0.95em;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background: white;
    color: #1a1a1a;
    cursor: pointer;
    transition: all 0.2s ease;
}

.filter-section select:hover {
    border-color: #9ca3af;
}

.filter-section select:focus {
    outline: none;
    border-color: #6b7280;
    box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.1);
}

/* 公告卡片 */
.announcement-card {
    background: white;
    border: 1px solid #e1e4e8;
    border-radius: 8px;
    margin-bottom: 16px;
    overflow: hidden;
    transition: all 0.2s ease;
}

.announcement-card:hover {
    border-color: #d1d5db;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.card-header {
    padding: 20px 24px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    border-bottom: 1px solid transparent;
    transition: all 0.2s ease;
}

.card-header:hover {
    background: #f8f9fa;
}

.card-header.active {
    background: #f8f9fa;
    border-bottom-color: #e1e4e8;
}

.card-title {
    font-size: 1.1em;
    font-weight: 600;
    color: #1a1a1a;
    flex: 1;
    letter-spacing: -0.3px;
}

.toggle-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    transition: all 0.2s ease;
    font-size: 0.75em;
}

.card-header.active .toggle-icon {
    transform: rotate(90deg);
    color: #1a1a1a;
}

.card-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background: white;
}

.card-content-inner {
    padding: 24px;
    padding-top: 20px;
}

.info-row {
    display: inline-flex;
    align-items: center;
    margin-right: 24px;
    margin-bottom: 16px;
    font-size: 0.9em;
}

.info-label {
    color: #6c757d;
    margin-right: 8px;
    font-weight: 500;
}

.info-value {
    color: #1a1a1a;
}

.content-text {
    padding: 18px 0;
    line-height: 1.7;
    color: #374151;
    font-size: 0.95em;
    border-top: 1px solid #f3f4f6;
    margin-top: 4px;
}

.note-section {
    background: #fefce8;
    border-left: 3px solid #eab308;
    padding: 16px 18px;
    border-radius: 4px;
    margin-top: 16px;
}

.note-section strong {
    color: #713f12;
    display: block;
    margin-bottom: 6px;
    font-size: 0.9em;
    font-weight: 600;
}

.note-section p {
    color: #854d0e;
    line-height: 1.6;
    margin: 0;
    font-size: 0.9em;
}

/* 展開按鈕 */
.expand-btn {
    display: inline-block;
    margin-top: 12px;
    padding: 6px 14px;
    background: #f3f4f6;
    color: #374151;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
    font-size: 0.85em;
    transition: all 0.2s ease;
    border: 1px solid #e5e7eb;
}

.expand-btn:hover {
    background: #e5e7eb;
    border-color: #d1d5db;
}

.summary { display: inline; }
.full { display: none; }

/* 空狀態 */
.empty-state {
    background: white;
    padding: 60px 30px;
    text-align: center;
    border-radius: 8px;
    border: 1px solid #e1e4e8;
}

.empty-state p {
    font-size: 1em;
    color: #6c757d;
}

/* 統計資訊 */
.stats {
    display: inline-block;
    background: #f8f9fa;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 0.85em;
    color: #6c757d;
    margin-left: 12px;
}

/* 響應式設計 */
@media (max-width: 768px) {
    .header h1 {
        font-size: 1.5em;
    }
    
    .filter-section {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-section select {
        max-width: none;
    }
    
    .card-header {
        padding: 16px 18px;
    }
    
    .card-title {
        font-size: 1em;
    }
    
    .card-content-inner {
        padding: 18px;
    }
    
    .info-row {
        display: flex;
        margin-right: 0;
        margin-bottom: 12px;
    }
}
</style>
</head>
<body>

<div class="header">
    <div class="header-inner">
        <h1>公告牆</h1>
        <p>Company Announcement Board</p>
    </div>
</div>

<div class="container">
    <!-- 篩選區 -->
    <div class="filter-section">
        <label>篩選單位</label>
        <form method="get" style="flex: 1; max-width: 280px;">
            <select name="unit" onchange="this.form.submit()">
                <option value="全部" <?php if($filterUnit==='全部') echo 'selected'; ?>>全部單位</option>
                <option value="不分區協理以上" <?php if($filterUnit==='不分區協理以上') echo 'selected'; ?>>不分區協理以上</option>
                <option value="人資部" <?php if($filterUnit==='人資部') echo 'selected'; ?>>人資部</option>
                <option value="資訊部" <?php if($filterUnit==='資訊部') echo 'selected'; ?>>資訊部</option>
                <option value="營運部" <?php if($filterUnit==='營運部') echo 'selected'; ?>>營運部</option>
            </select>
        </form>
        <span class="stats">共 <?php echo count($filteredAnnouncements); ?> 則公告</span>
    </div>

    <!-- 公告列表 -->
    <?php if(empty($filteredAnnouncements)): ?>
        <div class="empty-state">
            <p>目前沒有公告</p>
        </div>
    <?php else: ?>
        <?php foreach($filteredAnnouncements as $a): 
            $content = htmlspecialchars($a['內容']);
            $summary = mb_substr($content, 0, $summaryLength) . (mb_strlen($content) > $summaryLength ? "..." : "");
        ?>
        <div class="announcement-card">
            <div class="card-header">
                <span class="card-title"><?php echo htmlspecialchars($a['標題']); ?></span>
                <div class="toggle-icon">▸</div>
            </div>
            <div class="card-content">
                <div class="card-content-inner">
                    <div class="info-row">
                        <span class="info-label">發布時間</span>
                        <span class="info-value"><?php echo htmlspecialchars($a['時間']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">發送單位</span>
                        <span class="info-value"><?php echo htmlspecialchars($a['發送單位']); ?></span>
                    </div>
                    
                    <div class="content-text">
                        <span class="summary"><?php echo $summary; ?></span>
                        <span class="full"><?php echo nl2br($content); ?></span>
                        <?php if(mb_strlen($content) > $summaryLength): ?>
                            <br><button class="expand-btn">展開全文</button>
                        <?php endif; ?>
                    </div>
                    
                    <?php if(!empty($a['附註'])): ?>
                    <div class="note-section">
                        <strong>附註</strong>
                        <p><?php echo nl2br(htmlspecialchars($a['附註'])); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
document.querySelectorAll('.announcement-card').forEach(card => {
    const header = card.querySelector('.card-header');
    const content = card.querySelector('.card-content');
    const expandBtn = card.querySelector('.expand-btn');
    const summary = card.querySelector('.summary');
    const full = card.querySelector('.full');

    // 卡片展開/收合
    header.addEventListener('click', () => {
        const isActive = header.classList.contains('active');
        
        if(isActive) {
            header.classList.remove('active');
            content.style.maxHeight = null;
        } else {
            header.classList.add('active');
            content.style.maxHeight = content.scrollHeight + "px";
        }
    });

    // 展開全文
    if(expandBtn) {
        expandBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            
            if(full.style.display === "none" || full.style.display === "") {
                full.style.display = "inline";
                summary.style.display = "none";
                expandBtn.textContent = "收起內容";
                content.style.maxHeight = content.scrollHeight + "px";
            } else {
                full.style.display = "none";
                summary.style.display = "inline";
                expandBtn.textContent = "展開全文";
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }
});
</script>
</body>
</html>