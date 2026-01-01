<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $birthday = $_POST["birthday"];

    // 大頭貼上傳處理
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

    // 自動生成員工編號
    $today = date("Ymd");
    $sql_count = "SELECT COUNT(*) AS count FROM employees WHERE emp_id LIKE '$today%'";
    $result = $conn->query($sql_count);
    $row = $result->fetch_assoc();
    $count = str_pad($row['count'] + 1, 3, '0', STR_PAD_LEFT);
    $emp_id = $today . $count;

    $sql = "INSERT INTO employees (emp_id, name, phone, email, password, birthday, photo)
            VALUES ('$emp_id', '$name', '$phone', '$email', '$password', '$birthday', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('註冊成功！您的員工編號是 $emp_id'); window.location='login.php';</script>";
    } else {
        echo "錯誤：" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>員工註冊</title>
</head>
<body>
<h2>員工註冊</h2>
<form method="post" enctype="multipart/form-data">
    姓名：<input type="text" name="name" required><br><br>
    電話：<input type="text" name="phone" required><br><br>
    電子郵件：<input type="email" name="email" required><br><br>
    密碼：<input type="password" name="password" required><br><br>
    生日：<input type="date" name="birthday" required><br><br>
    大頭貼：<input type="file" name="photo" accept="image/*" required><br><br>
    <button type="submit">註冊</button>
</form>
</body>
</html>
