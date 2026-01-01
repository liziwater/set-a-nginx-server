<?php
// PDF 文件路徑
$pdf_path = 'pdf/result.pdf';
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>嵌入 PDF</title>
</head>
<body>
    <h1>嵌入 PDF 文件</h1>
    <object data="<?php echo $pdf_path; ?>" type="application/pdf" width="100%" height="600px">
        <p>您的瀏覽器不支持 PDF 顯示。您可以 <a href="<?php echo $pdf_path; ?>">下載 PDF 文件</a>。</p>
    </object>
</body>
</html>
