import sys
import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from datetime import datetime

def send_login_email(to_email, name, employee_id):
    smtp_server = "smtp.gmail.com"
    smtp_port = 587
    sender_email = "chengxun.llc@gmail.com"
    sender_password = "uqaw pchp jfmh mxdt"  # Gmail App Password

    msg = MIMEMultipart("alternative")
    msg["Subject"] = f"誠訊職員安全登入提醒 - 員工: {name}"
    msg["From"] = "誠訊計算機安全系統 <chengxun.llc@gmail.com>"
    msg["To"] = to_email

    now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    # 純文字版本
    text = f"""
您好 {name}，

您的帳號（員工ID: {employee_id}）於 {now} 成功登入。

若不是您本人操作，請立即聯絡管理員。

誠訊計算機安全系統
"""

    # HTML 版本
    html = f"""
<html>
  <head>
    <style>
      body {{
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f4f7;
        margin: 0;
        padding: 0;
      }}
      .container {{
        max-width: 600px;
        margin: 40px auto;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        padding: 30px;
      }}
      .header {{
        text-align: center;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 20px;
        margin-bottom: 20px;
      }}
      .header img {{
        max-height: 60px;
      }}
      .content p {{
        line-height: 1.6;
        color: #333333;
      }}
      .button {{
        display: inline-block;
        margin-top: 20px;
        padding: 12px 24px;
        background-color: #007bff;
        color: #ffffff !important;
        text-decoration: none;
        border-radius: 5px;
      }}
      .footer {{
        margin-top: 30px;
        font-size: 12px;
        color: #888888;
        text-align: center;
        border-top: 1px solid #e0e0e0;
        padding-top: 15px;
      }}
    </style>
  </head>
  <body>
    <div class="container">
      <div class="header">
        <img src="https://chengxun.ddns.net/image/LOGO.png" alt="公司Logo">
        <h2>登入通知</h2>
      </div>
      <div class="content">
        <p>您好 {name}，</p>
        <p>您的帳號（員工ID: <b>{employee_id}</b>）於 <b>{now}</b> 成功登入。</p>
        <p>若不是您本人操作，請立即聯絡管理員。</p>
        <a href="https://chengxun.ddns.net/home.php" class="button">立即查看登入紀錄</a>
      </div>
      <div class="footer">
        誠訊計算機安全系統<br>
        © 2025 ChengXun Company. All rights reserved.
      </div>
    </div>
  </body>
</html>
"""

    # 將文字與 HTML 加入信件
    msg.attach(MIMEText(text, "plain"))
    msg.attach(MIMEText(html, "html"))

    # 寄信
    with smtplib.SMTP(smtp_server, smtp_port) as server:
        server.starttls()
        server.login(sender_email, sender_password)
        server.sendmail(sender_email, to_email, msg.as_string())
        print(f"Email 已寄送至 {to_email}")

if __name__ == "__main__":
    if len(sys.argv) != 4:
        print("Usage: python send_email.py to_email name employee_id")
    else:
        send_login_email(sys.argv[1], sys.argv[2], sys.argv[3])
