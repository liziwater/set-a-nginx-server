import smtplib
import sys
import datetime
from email.mime.text import MIMEText
from email.header import Header

# ================= 設定區 =================
SMTP_SERVER = "smtp.gmail.com"
SMTP_PORT = 465
# 你的 Gmail 帳號
SENDER_EMAIL = "chengxun.llc@gmail.com"
# 你的應用程式專用密碼
SENDER_PASSWORD = "wfpd zloz gqor heeh" 
# =========================================

def send_alert_email(receiver_email, username, login_ip):
    # 格式化時間： 2025-10-26 15:30:00
    current_time = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    
    # 郵件標題：加上 [警示] 讓使用者第一眼注意到
    subject = f"【安全警示】您的帳號 {username} 有新的登入活動"
    
    # 專業 HTML 郵件內容 (內嵌 CSS)
    content = f"""
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <style>
        body {{ font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f6f9fc; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }}
        .container {{ width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-top: 40px; margin-bottom: 40px; }}
        .header {{ background-color: #2c3e50; padding: 30px 40px; text-align: center; }}
        .header h1 {{ color: #ffffff; margin: 0; font-size: 24px; letter-spacing: 1px; font-weight: 600; }}
        .content {{ padding: 40px; }}
        .alert-icon {{ text-align: center; margin-bottom: 20px; }}
        .alert-title {{ color: #2c3e50; font-size: 22px; margin-bottom: 10px; text-align: center; font-weight: bold; }}
        .alert-desc {{ color: #555555; font-size: 16px; line-height: 1.6; text-align: center; margin-bottom: 30px; }}
        .info-table {{ width: 100%; border-collapse: separate; border-spacing: 0; margin-bottom: 30px; border: 1px solid #eeeeee; border-radius: 6px; overflow: hidden; }}
        .info-table td {{ padding: 15px 20px; font-size: 15px; color: #333; border-bottom: 1px solid #eeeeee; }}
        .info-table tr:last-child td {{ border-bottom: none; }}
        .info-label {{ background-color: #f8f9fa; width: 120px; font-weight: 600; color: #666; }}
        .btn-box {{ text-align: center; margin-top: 30px; }}
        .btn {{ display: inline-block; padding: 12px 30px; background-color: #3498db; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; transition: background-color 0.3s; }}
        .btn:hover {{ background-color: #2980b9; }}
        .footer {{ background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #999999; border-top: 1px solid #eeeeee; }}
        .warning-text {{ color: #e74c3c; font-weight: bold; font-size: 14px; text-align: center; margin-top: 20px; }}
    </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>誠訊工作室</h1>
            </div>

            <div class="content">
                <div class="alert-icon">
                    <span style="font-size: 48px;">🛡️</span>
                </div>
                
                <h2 class="alert-title">偵測到新的登入</h2>
                
                <p class="alert-desc">
                    親愛的 <b>{username}</b> 您好，<br>
                    系統剛剛偵測到您的員工帳號有一筆新的登入紀錄。
                </p>

                <table class="info-table">
                    <tr>
                        <td class="info-label">登入帳號</td>
                        <td>{receiver_email}</td>
                    </tr>
                    <tr>
                        <td class="info-label">登入時間</td>
                        <td>{current_time}</td>
                    </tr>
                    <tr>
                        <td class="info-label">來源 IP</td>
                        <td>{login_ip}</td>
                    </tr>
                    <tr>
                        <td class="info-label">登入狀態</td>
                        <td style="color: #27ae60; font-weight: bold;">成功</td>
                    </tr>
                </table>

                <div class="btn-box">
                    <a href="http://your-website-url.com/interface.php" class="btn">前往系統後台</a>
                </div>

                <p class="warning-text">
                    ⚠️ 若此操作非您本人，請立即更換密碼並聯絡管理員。
                </p>
            </div>

            <div class="footer">
                <p>&copy; 2025 Chengxun Studio. All rights reserved.</p>
                <p>此信件由系統自動發送，請勿直接回覆。</p>
            </div>
        </div>
    </body>
    </html>
    """

    msg = MIMEText(content, 'html', 'utf-8')
    msg['From'] = Header("誠訊工作室資安中心", 'utf-8')
    msg['To'] = receiver_email
    msg['Subject'] = Header(subject, 'utf-8')

    try:
        server = smtplib.SMTP_SSL(SMTP_SERVER, SMTP_PORT)
        server.login(SENDER_EMAIL, SENDER_PASSWORD)
        server.sendmail(SENDER_EMAIL, receiver_email, msg.as_string())
        server.quit()
        
        # 寫入 log
        with open("email_log.txt", "a", encoding="utf-8") as f:
            f.write(f"[{current_time}] 成功發送至 {receiver_email} (IP: {login_ip})\n")
            
    except Exception as e:
        # 錯誤 log
        with open("email_log.txt", "a", encoding="utf-8") as f:
            f.write(f"[{current_time}] 發送失敗: {str(e)}\n")

if __name__ == "__main__":
    if len(sys.argv) >= 4:
        # sys.argv[1]=email, [2]=name, [3]=ip
        send_alert_email(sys.argv[1], sys.argv[2], sys.argv[3])
