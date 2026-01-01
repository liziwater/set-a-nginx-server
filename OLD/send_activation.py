
import sys
import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

# 從命令列接收參數
to_email = sys.argv[1]
employee_name = sys.argv[2]
employee_id = sys.argv[3]

smtp_server = "smtp.gmail.com"
smtp_port = 587
sender_email = "chengxun.llc@gmail.com"  # 你的 Gmail
sender_password = "uqaw pchp jfmh mxdt"  # Gmail App Password

msg = MIMEMultipart("alternative")
msg["Subject"] = f"誠訊職員開通提醒 - 員工ID: {employee_id}"
msg["From"] = f"誠訊計算機安全系統 <{sender_email}>"
msg["To"] = to_email

# 郵件內容
text = f"""\
您好，

員工 {employee_name} (ID: {employee_id}) 的帳號尚未開通。
請您在後台確認並開通。

謝謝！
"""
part = MIMEText(text, "plain")
msg.attach(part)

try:
    server = smtplib.SMTP(smtp_server, smtp_port)
    server.starttls()
    server.login(sender_email, sender_password)
    server.sendmail(sender_email, to_email, msg.as_string())
    server.quit()
    print(f"郵件已寄給 {to_email}")
except Exception as e:
    print(f"郵件寄送失敗: {e}")
