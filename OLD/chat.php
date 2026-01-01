<?php
// ollama_api.php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// 處理 OPTIONS 請求
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Ollama 設定
define('OLLAMA_URL', 'http://192.168.0.126:11434');
define('MODEL_NAME', 'deepseek-r1:1.5b');

// 檢查 Ollama 連線
function checkOllamaConnection() {
    $ch = curl_init(OLLAMA_URL . '/api/tags');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return $httpCode === 200;
}

// 檢查模型是否存在
function checkModelExists() {
    $ch = curl_init(OLLAMA_URL . '/api/tags');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        return false;
    }
    
    $data = json_decode($response, true);
    $models = $data['models'] ?? [];
    
    foreach ($models as $model) {
        if (strpos($model['name'], 'deepseek-r1') !== false) {
            return true;
        }
    }
    
    return false;
}

// 聊天 API
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['REQUEST_URI'], '/api/chat') !== false) {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    $message = $data['message'] ?? '';
    $enableWebSearch = $data['enableWebSearch'] ?? false;
    
    // 驗證訊息
    if (empty(trim($message))) {
        http_response_code(400);
        echo json_encode([
            'error' => '請提供訊息內容',
            'type' => 'validation_error'
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    // 檢查 Ollama 連線
    if (!checkOllamaConnection()) {
        http_response_code(503);
        echo json_encode([
            'error' => 'Ollama 服務無法連接，請確認 Ollama 已啟動並運行在 ' . OLLAMA_URL,
            'type' => 'connection_error'
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    // 檢查模型
    if (!checkModelExists()) {
        http_response_code(404);
        echo json_encode([
            'error' => '模型 ' . MODEL_NAME . ' 不存在，請先下載模型：ollama pull ' . MODEL_NAME,
            'type' => 'model_error'
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    // 準備提示詞
    $prompt = $message;
    if ($enableWebSearch) {
        $prompt = "請回答以下問題，如果需要最新資訊請告知：" . $message;
    }
    
    // 呼叫 Ollama API
    $ch = curl_init(OLLAMA_URL . '/api/generate');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'model' => MODEL_NAME,
        'prompt' => $prompt,
        'stream' => false
    ]));
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($curlError) {
        http_response_code(503);
        echo json_encode([
            'error' => 'Ollama 服務無法連接：' . $curlError,
            'type' => 'connection_error'
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    if ($httpCode === 404) {
        http_response_code(404);
        echo json_encode([
            'error' => '模型不存在或 Ollama API 路徑錯誤',
            'type' => 'model_error'
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    $result = json_decode($response, true);
    
    if (isset($result['response'])) {
        echo json_encode([
            'response' => $result['response'],
            'model' => MODEL_NAME,
            'webSearchEnabled' => $enableWebSearch
        ], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(500);
        echo json_encode([
            'error' => '伺服器內部錯誤',
            'type' => 'server_error'
        ], JSON_UNESCAPED_UNICODE);
    }
    exit();
}

// 健康檢查 API
if ($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER['REQUEST_URI'], '/api/health') !== false) {
    $ollamaConnected = checkOllamaConnection();
    $modelExists = checkModelExists();
    
    echo json_encode([
        'server' => 'running',
        'ollama' => $ollamaConnected ? 'connected' : 'disconnected',
        'model' => $modelExists ? 'available' : 'not_found',
        'modelName' => MODEL_NAME
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

// 取得模型列表
if ($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER['REQUEST_URI'], '/api/models') !== false) {
    $ch = curl_init(OLLAMA_URL . '/api/tags');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        $models = $data['models'] ?? [];
        $modelNames = array_map(function($m) { return $m['name']; }, $models);
        
        echo json_encode([
            'models' => $modelNames
        ], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(503);
        echo json_encode([
            'error' => 'Ollama 服務無法連接',
            'models' => []
        ], JSON_UNESCAPED_UNICODE);
    }
    exit();
}

// 預設回應
http_response_code(404);
echo json_encode([
    'error' => 'API 端點不存在'
], JSON_UNESCAPED_UNICODE);