import smtplib
import sys
import datetime
from email.mime.text import MIMEText
from email.header import Header

# ================= 設定區 =================
SMTP_SERVER = "smtp.gmail.com"
SMTP_PORT = 465
# 你的 Gmail
SENDER_EMAIL = "chengxun.llc@gmail.com"  
# 你的應用程式專用密碼
SENDER_PASSWORD = "wfpd zloz gqor heeh" 
# =========================================

def send_welcome_email(receiver_email, username, user_code):
    current_time = datetime.datetime.now().strftime("%Y-%m-%d %H:%M")
    
    subject = f"【誠訊工作室】歡迎加入！您的註冊已成功"
    
    # 精美的歡迎信 HTML 模板
    content = f"""
    <!DOCTYPE html>
    <html>
    <head>
    <style>
        body {{ font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }}
        .container {{ max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }}
        .header {{ background-color: #28a745; padding: 30px; text-align: center; color: white; }}
        .header h1 {{ margin: 0; font-size: 24px; }}
        .content {{ padding: 30px; color: #333; line-height: 1.6; }}
        .info-box {{ background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 5px solid #28a745; }}
        .info-item {{ margin-bottom: 10px; }}
        .btn {{ display: inline-block; padding: 12px 25px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; font-weight: bold; }}
        .footer {{ text-align: center; padding: 20px; font-size: 12px; color: #888; background-color: #eee; }}
    </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>🎉 歡迎加入誠訊工作室！</h1>
            </div>
            <div class="content">
                <p>親愛的 <b>{username}</b> 您好，</p>
                <p>恭喜您已成功註冊員工帳號。我們很高興能有您的加入！</p>
                
                <p>以下是您的帳號資訊，請妥善保存：</p>
                
                <div class="info-box">
                    <div class="info-item"><b>員工編號：</b> {user_code}</div>
                    <div class="info-item"><b>登入信箱：</b> {receiver_email}</div>
                    <div class="info-item"><b>註冊時間：</b> {current_time}</div>
                </div>
                
                <p>現在，您可以點擊下方按鈕登入系統開始工作：</p>
                
                <center>
                    <a href="https://chengxun.ddns.net/employeeS/login.php" class="btn">前往員工專區</a>
                </center>
            </div>
            <div class="footer">
                &copy; 2025 Chengxun Studio. All rights reserved.
            </div>
        </div>
    </body>
    </html>
    """

    msg = MIMEText(content, 'html', 'utf-8')
    msg['From'] = Header("誠訊工作室 HR 系統", 'utf-8')
    msg['To'] = receiver_email
    msg['Subject'] = Header(subject, 'utf-8')

    try:
        server = smtplib.SMTP_SSL(SMTP_SERVER, SMTP_PORT)
        server.login(SENDER_EMAIL, SENDER_PASSWORD)
        server.sendmail(SENDER_EMAIL, receiver_email, msg.as_string())
        server.quit()
        # 寫入 Log 方便除錯
        with open("email_register_log.txt", "a", encoding="utf-8") as f:
            f.write(f"[{current_time}] 歡迎信已發送至 {receiver_email}\n")
    except Exception as e:
        with open("email_register_log.txt", "a", encoding="utf-8") as f:
            f.write(f"[{current_time}] 發送失敗: {str(e)}\n")

if __name__ == "__main__":
    # 接收參數: [1]Email, [2]姓名, [3]員工編號
    if len(sys.argv) >= 4:
        send_welcome_email(sys.argv[1], sys.argv[2], sys.argv[3])