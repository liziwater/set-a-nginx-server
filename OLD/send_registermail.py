import sys
import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

def send_registration_email(to_email, name, employee_id):
    smtp_server = "smtp.gmail.com"
    smtp_port = 587
    sender_email = "chengxun.llc@gmail.com"        # 改成你的寄信信箱
    sender_password = "uqaw pchp jfmh mxdt"        # Gmail App Password

    msg = MIMEMultipart("alternative")
    msg["Subject"] = f"誠訊集團收取註冊成功通知 - 員工ID: {employee_id}"
    msg["From"] = "誠訊計算機安全系統"
    msg["To"] = to_email

    html_content = f"""
    <html>
        <body>
            <h2>親愛的 {name} 您好：</h2>
            <p>您的員工帳號已成功建立！</p>
            <p><b>員工ID：</b> {employee_id}</p>
            <p>帳號目前尚未開通，請等待管理員啟用。</p>
            <hr>
            <p style="font-size:12px;color:#555;">此信件由誠訊計算機安全系統自動發送，請勿回覆。</p>
        </body>
    </html>
    """

    msg.attach(MIMEText(html_content, "html"))

    try:
        server = smtplib.SMTP(smtp_server, smtp_port)
        server.starttls()
        server.login(sender_email, sender_password)
        server.sendmail(sender_email, to_email, msg.as_string())
        server.quit()
        print(f"Email 已寄送至 {to_email}")
    except Exception as e:
        print(f"Email 發送失敗: {e}")

if __name__ == "__main__":
    if len(sys.argv) != 4:
        print("Usage: python send_email.py <name> <email> <employee_id>")
        sys.exit(1)

    name = sys.argv[1]
    email = sys.argv[2]
    employee_id = sys.argv[3]
    send_registration_email(email, name, employee_id)
