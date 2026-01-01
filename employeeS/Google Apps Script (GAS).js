// 設定 API 基本資料
var API_URL = "http://您的真實IP或網域/api.php?api_key=Chengxun2025Secret";

// 1. 測試：新增員工 (POST)
function apiCreateUser() {
  var payload = {
    "username": "GAS自動建立",
    "email": "gas_bot@example.com",
    "password": "secret_password",
    "phone": "0900111222"
  };

  var options = {
    "method": "post",
    "contentType": "application/json",
    "payload": JSON.stringify(payload)
  };

  var response = UrlFetchApp.fetch(API_URL, options);
  Logger.log(response.getContentText());
}

// 2. 測試：更新員工 (PUT)
function apiUpdateUser() {
  var payload = {
    "user_code": "20251211001", // 指定要改誰
    "phone": "0999888777",      // 改電話
    "status": 0                 // 停用帳號
  };

  var options = {
    "method": "put",
    "contentType": "application/json",
    "payload": JSON.stringify(payload)
  };

  var response = UrlFetchApp.fetch(API_URL, options);
  Logger.log(response.getContentText());
}