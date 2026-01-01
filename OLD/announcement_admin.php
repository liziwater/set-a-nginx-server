<?php
$apiUrl = "https://script.google.com/macros/s/AKfycbycWC-a2NUFchZ4Skd8SSYyArZ_IXTPVGyjXDzjSjBuxVS_Bg9kcAzNvHYerLVWeFqrKw/exec";
$announcements = json_decode(file_get_contents($apiUrl), true);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>公告管理</title>
<style>
body { background: #fff; font-family: Arial, sans-serif; color: #333; }
.container { max-width: 800px; margin: 50px auto; }
.card { border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);}
h2 { margin: 0 0 10px; }
p { margin: 5px 0; }
button { padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
.add-btn { background-color: #007BFF; color: #fff; }
.delete-btn { background-color: #FF4136; color: #fff; }
form { margin-top: 10px; }
input[type="text"], input[type="date"], select { padding: 8px; width: 100%; margin-bottom: 10px; border-radius:5px; border:1px solid #ccc; box-sizing:border-box; }
label { font-weight: bold; display:block; margin-top:10px; }
</style>
</head>
<body>
<div class="container">
<h1>公告管理</h1>

<!-- 顯示公告列表 -->
<?php foreach($announcements as $a): ?>
<div class="card">
  <h2><?php echo htmlspecialchars($a['標題']); ?></h2>
  <p>時間: <?php echo htmlspecialchars($a['時間']); ?></p>
  <p>單位: <?php echo htmlspecialchars($a['發送單位']); ?></p>
  <p>內容: <?php echo htmlspecialchars($a['內容']); ?></p>
  <p>附註: <?php echo htmlspecialchars($a['附註']); ?></p>
  <form method="post" style="display:inline;">
    <input type="hidden" name="delete_title" value="<?php echo htmlspecialchars($a['標題']); ?>">
    <button type="submit" class="delete-btn">刪除</button>
  </form>
</div>
<?php endforeach; ?>

<!-- 新增公告表單 -->
<h2>新增公告</h2>
<form method="post">
  <label>標題</label>
  <input type="text" name="標題" placeholder="標題" required>
  
  <label>公告日期</label>
  <input type="date" name="時間" required>
  
  <label>發送單位</label>
  <select name="發送單位" required>
    <option value="不分區協理以上">不分區協理以上</option>
    <option value="人資部">人資部</option>
    <option value="資訊部">資訊部</option>
    <option value="營運部">營運部</option>
  </select>
  
  <label>內容</label>
  <input type="text" name="內容" placeholder="內容" required>
  
  <label>附註</label>
  <input type="text" name="附註" placeholder="附註">
  
  <button type="submit" class="add-btn">新增公告</button>
</form>
</div>

<?php
// 處理新增或刪除公告
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    if (isset($_POST['delete_title'])) {
        $data = ['action'=>'delete','標題'=>$_POST['delete_title']];
    } else {
        $data = [
            'action'=>'add',
            '標題'=>$_POST['標題'],
            '時間'=>$_POST['時間'],
            '發送單位'=>$_POST['發送單位'],
            '內容'=>$_POST['內容'],
            '附註'=>$_POST['附註']
        ];
    }

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
?>
</body>
</html>
