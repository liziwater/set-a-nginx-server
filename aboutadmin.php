<?php
session_start();
include 'db.php';

// 處理致詞更新
if (isset($_POST['update_settings'])) {
    foreach ($_POST['settings'] as $key => $value) {
        $stmt = $conn->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
        $stmt->bind_param("ss", $value, $key);
        $stmt->execute();
    }
    echo "<script>alert('致詞更新成功！');window.location.href='admin_team.php';</script>";
}

// 處理新增成員
if (isset($_POST['add_member'])) {
    $target_dir = "image/";
    $image_name = basename($_FILES["image"]["name"]);
    // 如果沒上傳圖片，使用預設
    if(empty($image_name)) {
        $image_path = "image/default.PNG"; 
    } else {
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_path = "image/" . $image_name;
    }

    $stmt = $conn->prepare("INSERT INTO team_members (name, eng_name, position, emp_id, category, rank_color, image, bio, contact_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $_POST['name'], $_POST['eng_name'], $_POST['position'], $_POST['emp_id'], $_POST['category'], $_POST['rank_color'], $image_path, $_POST['bio'], $_POST['contact_info']);
    $stmt->execute();
    echo "<script>alert('成員新增成功！');window.location.href='admin_team.php';</script>";
}

// 處理刪除成員
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM team_members WHERE id=$id");
    header("Location: admin_team.php");
}

// 撈取現有資料
$settings_result = $conn->query("SELECT * FROM site_settings");
$settings = [];
while ($row = $settings_result->fetch_assoc()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>網頁內容後臺管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
    <h1 class="mb-4">網頁內容管理系統</h1>

    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white">編輯創辦人致詞</div>
        <div class="card-body">
            <form method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>主標題</label>
                        <input type="text" name="settings[founder_title]" class="form-control" value="<?php echo $settings['founder_title']; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>副標題 (英文)</label>
                        <input type="text" name="settings[founder_subtitle]" class="form-control" value="<?php echo $settings['founder_subtitle']; ?>">
                    </div>
                    <div class="col-12 mb-3">
                        <label>致詞內容</label>
                        <textarea name="settings[founder_content]" class="form-control" rows="5"><?php echo $settings['founder_content']; ?></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>簽名 (中文)</label>
                        <input type="text" name="settings[founder_name]" class="form-control" value="<?php echo $settings['founder_name']; ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>簽名 (英文)</label>
                        <input type="text" name="settings[founder_eng_name]" class="form-control" value="<?php echo $settings['founder_eng_name']; ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>頭銜</label>
                        <input type="text" name="settings[founder_position]" class="form-control" value="<?php echo $settings['founder_position']; ?>">
                    </div>
                </div>
                <button type="submit" name="update_settings" class="btn btn-primary">更新致詞設定</button>
            </form>
        </div>
    </div>

    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-success text-white">新增團隊成員</div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label>姓名</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>英文名</label>
                        <input type="text" name="eng_name" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>職位</label>
                        <input type="text" name="position" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>員工編號</label>
                        <input type="text" name="emp_id" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>分類</label>
                        <select name="category" class="form-select">
                            <option value="executive">長官群 (Executives)</option>
                            <option value="minister">部長群 (Ministers)</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>卡片顏色</label>
                        <select name="rank_color" class="form-select">
                            <option value="rank-red">紅色 (高層)</option>
                            <option value="rank-orange">橘色 (總經理)</option>
                            <option value="rank-blue">藍色 (副總)</option>
                            <option value="rank-green">綠色 (部長)</option>
                            <option value="rank-gray">灰色 (缺額)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>聯絡資訊/部門 (背面)</label>
                        <input type="text" name="contact_info" class="form-control">
                    </div>
                    <div class="col-12 mb-3">
                        <label>個人簡介</label>
                        <textarea name="bio" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label>上傳照片 (PNG/JPG)</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <button type="submit" name="add_member" class="btn btn-success">新增成員</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">現有成員列表</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>照片</th>
                        <th>姓名</th>
                        <th>職位</th>
                        <th>分類</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM team_members ORDER BY category, id");
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><img src='".$row['image']."' style='width:50px;'></td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['position']."</td>";
                        echo "<td>".($row['category']=='executive'?'長官群':'部長群')."</td>";
                        echo "<td><a href='admin_team.php?delete=".$row['id']."' class='btn btn-danger btn-sm' onclick='return confirm(\"確定刪除嗎？\")'>刪除</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>