<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
if (!isset($_GET['id'])) { die("錯誤：未指定文件 ID"); }

$doc_id = $_GET['id'];

// 1. 讀取文件資料
$stmt = $pdo->prepare("SELECT * FROM documents WHERE id = ?");
$stmt->execute([$doc_id]);
$doc = $stmt->fetch();

if (!$doc) { die("找不到此文件"); }

// 產生文件編號 (模擬)
$doc_no = "CX-" . date("Ymd", strtotime($doc['created_at'])) . "-" . str_pad($doc['id'], 3, "0", STR_PAD_LEFT);

// 2. 解析簽核歷程
// 支援關鍵字： '核准', '自動核決' => 通過
$roles_map = ['董事長', '總經理', '副總經理', '協理', '部長'];
$sign_data = [];

// 初始化
foreach ($roles_map as $r) {
    $sign_data[$r] = ['status' => '', 'date' => '', 'name' => '', 'comment' => ''];
}

$history_lines = explode("\n", $doc['sign_history']);
foreach ($history_lines as $line) {
    foreach ($roles_map as $role) {
        // 判斷這一行屬於哪個職位
        if (strpos($line, " $role ") !== false) {
            // 解析日期
            preg_match('/\[(.*?)\]/', $line, $matches);
            $date = isset($matches[1]) ? date('Y/m/d H:i', strtotime($matches[1])) : '-';
            
            // 解析狀態
            $is_pass = (strpos($line, '核准') !== false || strpos($line, '自動核決') !== false || strpos($line, '通過') !== false);
            $is_reject = (strpos($line, '退回') !== false);
            
            $status_text = '';
            if ($is_pass) $status_text = '✅ 核准';
            if ($is_reject) $status_text = '❌ 退回';

            // 解析姓名 (簡單抓取職稱後面的名字)
            // 假設格式: [時間] 職稱 姓名 : 動作
            $parts = explode(" : ", $line);
            $name_part = explode(" ", $parts[0] ?? ''); 
            $signer_name = end($name_part); // 抓最後一個字串通常是名字

            // 存入資料
            $sign_data[$role] = [
                'status' => $status_text,
                'date' => $date,
                'name' => $signer_name
            ];
        }
    }
}

// 判斷是否顯示大紅印章
$show_final_stamp = ($doc['status'] === 'approved');
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>公文 - <?php echo htmlspecialchars($doc['title']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+TC:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* --- 核心設定 --- */
        :root {
            --primary-black: #2c2c2c;
            --stamp-red: #d93025;
            --border-color: #888;
        }

        body {
            background: #525659;
            font-family: 'Noto Serif TC', '標楷體', 'BiauKai', serif; /* 專業公文字體 */
            margin: 0;
            padding: 40px 0;
            display: flex;
            justify-content: center;
            color: var(--primary-black);
        }

        /* --- A4 紙張模擬 --- */
        .page {
            background: white;
            width: 210mm;
            min-height: 297mm;
            padding: 20mm 25mm; /* 標準公文邊距 */
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            box-sizing: border-box;
            position: relative;
            overflow: hidden; /* 防止浮水印溢出 */
        }

        /* --- 浮水印 --- */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 8rem;
            color: rgba(0, 0, 0, 0.03);
            font-weight: bold;
            pointer-events: none;
            z-index: 0;
            white-space: nowrap;
        }

        /* --- 排版樣式 --- */
        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            z-index: 2;
        }
        .header h1 {
            font-size: 28px;
            margin: 0;
            letter-spacing: 5px;
            border-bottom: 3px double var(--primary-black);
            display: inline-block;
            padding-bottom: 10px;
        }
        .doc-meta {
            text-align: right;
            font-size: 12px;
            color: #555;
            margin-top: 10px;
        }

        /* 公文表格 */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            z-index: 2;
            position: relative;
        }
        .info-table th, .info-table td {
            border: 1px solid var(--border-color);
            padding: 12px;
        }
        .info-table th {
            background: #f8f9fa;
            width: 120px;
            text-align: center;
            font-weight: bold;
        }
        .info-table td {
            vertical-align: top;
        }

        .content-box {
            min-height: 200px;
            white-space: pre-wrap;
            line-height: 1.8;
            font-size: 16px;
        }

        /* --- 簽核矩陣 --- */
        .sign-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .sign-title {
            font-size: 14px;
            margin-bottom: 5px;
            border-left: 4px solid var(--primary-black);
            padding-left: 8px;
            font-weight: bold;
        }
        .sign-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid var(--primary-black);
        }
        .sign-table th {
            border: 1px solid var(--border-color);
            background: #f4f4f4;
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }
        .sign-table td {
            border: 1px solid var(--border-color);
            padding: 5px;
            text-align: center;
            height: 70px; /* 預留蓋章空間 */
            vertical-align: middle;
            position: relative;
        }

        /* --- 電子簽章樣式 --- */
        .digital-stamp {
            display: inline-block;
            border: 2px solid var(--stamp-red);
            color: var(--stamp-red);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            transform: rotate(-5deg); /* 稍微傾斜更有真實感 */
            background: rgba(255, 255, 255, 0.9);
        }
        .sign-date {
            display: block;
            font-size: 10px;
            color: #666;
            margin-top: 4px;
        }

        /* --- 最終核准大印章 --- */
        .final-stamp {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 120px;
            height: 120px;
            border: 5px double var(--stamp-red);
            border-radius: 50%;
            color: var(--stamp-red);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-weight: bold;
            font-size: 24px;
            transform: rotate(-15deg);
            opacity: 0.8;
            z-index: 10;
            background: rgba(255, 255, 255, 0.1);
            pointer-events: none;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.8) inset;
        }
        .final-stamp span { font-size: 14px; margin-top: 5px; }

        /* --- 按鈕與列印 --- */
        .btn-print {
            position: fixed; top: 20px; right: 20px; 
            padding: 12px 24px; background: #007bff; color: white; 
            border: none; border-radius: 50px; cursor: pointer; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.2); 
            font-weight: bold; z-index: 100;
            transition: 0.3s;
        }
        .btn-print:hover { background: #0056b3; transform: translateY(-2px); }

        @media print {
            body { background: white; padding: 0; }
            .page { width: 100%; box-shadow: none; margin: 0; padding: 10mm; }
            .btn-print { display: none; }
            @page { size: A4; margin: 0; }
        }
    </style>
</head>
<body>

<button onclick="window.print()" class="btn-print">🖨️ 列印 / 存為 PDF</button>

<div class="page">
    <div class="watermark">誠訊工作室</div>

    <?php if ($show_final_stamp): ?>
        <div class="final-stamp">
            已決行
            <span>APPROVED</span>
        </div>
    <?php endif; ?>

    <div class="header">
        <h1>誠訊工作室 電子簽核函</h1>
        <div class="doc-meta">
            <div>文件編號：<?php echo $doc_no; ?></div>
            <div>列印日期：<?php echo date("Y/m/d H:i"); ?></div>
        </div>
    </div>

    <table class="info-table">
        <tr>
            <th>提案部門</th>
            <td><?php echo htmlspecialchars($doc['department']); ?></td>
            <th>提案人員</th>
            <td><?php echo htmlspecialchars($doc['uploader_name']); ?></td>
        </tr>
        <tr>
            <th>發文日期</th>
            <td colspan="3">中華民國 <?php echo date("Y", strtotime($doc['created_at'])) - 1911; ?> 年 <?php echo date("m", strtotime($doc['created_at'])); ?> 月 <?php echo date("d", strtotime($doc['created_at'])); ?> 日</td>
        </tr>
        <tr>
            <th>主　　旨</th>
            <td colspan="3" style="font-weight: bold; font-size: 18px;"><?php echo htmlspecialchars($doc['title']); ?></td>
        </tr>
        <tr>
            <th>說　　明</th>
            <td colspan="3">
                <div class="content-box"><?php echo htmlspecialchars($doc['description']); ?></div>
            </td>
        </tr>
        <tr>
            <th>附　　件</th>
            <td colspan="3">
                <?php if(!empty($doc['file_path'])): ?>
                    已檢附相關檔案 (<a href="<?php echo htmlspecialchars($doc['file_path']); ?>" target="_blank" style="color:black; text-decoration:underline;">檔案連結</a>)
                <?php else: ?>
                    無
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <div class="sign-section">
        <div class="sign-title">會簽核決紀錄：</div>
        <table class="sign-table">
            <thead>
                <tr>
                    <th width="10%">職稱</th>
                    <?php foreach ($roles_map as $role): ?>
                        <th><?php echo $role; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="background:#f8f9fa; font-weight:bold;">簽章</td>
                    <?php foreach ($roles_map as $role): ?>
                        <td>
                            <?php 
                                $data = $sign_data[$role];
                                if (!empty($data['status'])) {
                                    // 顯示模擬電子印章
                                    echo "<div class='digital-stamp'>{$data['name']}<br>{$data['status']}</div>";
                                    echo "<span class='sign-date'>{$data['date']}</span>";
                                } else {
                                    echo "<span style='color:#ccc; font-size:12px;'>未簽核</span>";
                                }
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 40px; border-top: 1px solid #ccc; padding-top: 10px; text-align: center; font-size: 10px; color: #888;">
        本文件由 誠訊工作室 數位管理系統自動生成 • 此電子副本具同等效力 • 驗證碼: <?php echo substr(md5($doc_id . $doc['created_at']), 0, 8); ?>
    </div>

</div>

</body>
</html>