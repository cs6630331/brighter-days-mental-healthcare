<?php
session_start();

// ตรวจสอบว่าได้รับคำขอ POST หรือไม่
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: otp_email.php");
    exit();
}

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// ตรวจสอบความถูกต้องของอีเมล
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'อีเมลไม่ถูกต้อง';
    header("Location: otp_email.php");
    exit();
}

// สุ่ม OTP 6 หลัก
$otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

// เก็บ OTP ใน session พร้อมเวลาหมดอายุ (10 นาที)
$_SESSION['otp'] = $otp;
$_SESSION['otp_email'] = $email;
$_SESSION['otp_created_time'] = time();
$_SESSION['otp_expire'] = time() + 600; // 10 นาที

// ===== บันทึก OTP ลงไฟล์ log =====
$log_file = 'otp_log.txt';
$log_message = date('Y-m-d H:i:s') . " | Email: $email | OTP: $otp\n";
@file_put_contents($log_file, $log_message, FILE_APPEND);

// เก็บข้อมูลสำหรับการทดสอบ
$_SESSION['debug_otp'] = $otp;

// ===== ลองส่ง Email ผ่าน PHPMailer (ถ้ามี) =====
$email_sent = false;

if (file_exists('vendor/autoload.php')) {
    try {
        require 'vendor/autoload.php';
        
        // ถ้า PHPMailer ไม่เคยใช้ มาก่อน
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            throw new Exception('PHPMailer not found');
        }

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        // ⚠️ ⚠️ ⚠️ แก้ไข Email และ Password ที่นี่ ⚠️ ⚠️ ⚠️
        $gmail_address = 'bpluem011@gmail.com'; // ⚠️ เปลี่ยนเป็น email ของคุณ
        $gmail_password = 'ncji bxvt ygso jnvd';  // ⚠️ เปลี่ยนเป็น App Password ของคุณ

        // ตั้งค่า SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $gmail_address;          
        $mail->Password = $gmail_password;  
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';
        $mail->Timeout = 10;

        // ตั้งค่าผู้ส่ง
        $mail->setFrom($gmail_address, 'Brighter Days'); 
        $mail->addAddress($email);

        // ตั้งค่าอีเมล
        $mail->isHTML(true);
        $mail->Subject = 'รหัส OTP ยืนยันการสมัครสมาชิก - Brighter Days';
        $mail->Body = getEmailHTML($otp);
        $mail->AltBody = "รหัส OTP ของคุณคือ: $otp (หมดอายุใน 10 นาที)";

        // ส่งอีเมล
        if ($mail->send()) {
            $email_sent = true;
        }

    } catch (Exception $e) {
        // ถ้าเกิดข้อผิดพลาด ก็ไม่ส่งจริง แต่ยังไป otp_verify.php ได้
        error_log("Email Error: " . $e->getMessage());
    }
}

// ไปหน้า OTP verify
header("Location: otp_verify.php");
exit();

/**
 * สร้าง HTML สำหรับอีเมล
 */
function getEmailHTML($otp) {
    return "
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { 
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: #f5f5f5;
                margin: 0;
                padding: 0;
            }
            .email-container { 
                max-width: 600px; 
                margin: 0 auto; 
                padding: 20px; 
            }
            .header { 
                background: linear-gradient(135deg, #94c9ff 0%, #54d2fcff 100%); 
                color: white; 
                padding: 30px 20px; 
                border-radius: 10px 10px 0 0; 
                text-align: center; 
            }
            .header h1 {
                margin: 0;
                font-size: 28px;
                font-weight: 600;
            }
            .header p {
                margin: 5px 0 0 0;
                font-size: 14px;
                opacity: 0.9;
            }
            .content { 
                background: white; 
                padding: 40px 30px; 
                text-align: center; 
            }
            .content h2 {
                color: #333;
                font-size: 24px;
                margin-bottom: 20px;
            }
            .content p {
                color: #666;
                font-size: 15px;
                line-height: 1.6;
                margin: 10px 0;
            }
            .otp-code { 
                font-size: 48px; 
                font-weight: bold; 
                color: #667eea; 
                letter-spacing: 8px; 
                margin: 30px 0; 
                background: #f9f9f9; 
                padding: 25px; 
                border-radius: 8px; 
                border: 2px dashed #667eea;
                font-family: 'Courier New', monospace;
            }
            .expire-text {
                color: #e74c3c;
                font-size: 13px;
                font-weight: 600;
                margin-top: 20px;
            }
            .footer { 
                background: #f5f5f5;
                text-align: center; 
                color: #999; 
                font-size: 12px; 
                padding: 20px;
                border-radius: 0 0 10px 10px;
            }
            .divider {
                border-top: 1px solid #eee;
                margin: 20px 0;
            }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='header'>
                <h1>🌟 Brighter Days</h1>
                <p>Mental Healthcare</p>
            </div>
            <div class='content'>
                <h2>ยืนยันการสมัครสมาชิก</h2>
                <p>สวัสดีค่ะ/ครับ</p>
                <p>ขอบคุณที่สมัครสมาชิก Brighter Days Mental Healthcare</p>
                
                <p style='margin-top: 30px; font-weight: 600;'>รหัส OTP ของคุณคือ:</p>
                <div class='otp-code'>$otp</div>
                
                <p>นำรหัส OTP ไปยังแบบฟอร์มเพื่อยืนยันบัญชีของคุณ</p>
                <div class='expire-text'>⏰ รหัส OTP จะหมดอายุใน 10 นาที</div>
                
                <div class='divider'></div>
                
                <p><strong>⚠️ สำคัญ:</strong></p>
                <p>หากคุณไม่ได้ขอการสมัครสมาชิก โปรดข้ามอีเมลนี้และติดต่อฝ่ายสนับสนุนของเรา</p>
            </div>
            <div class='footer'>
                <p>© 2025 Brighter Days Mental Healthcare. ทุกสิทธิ์สงวน</p>
                <p>หากมีปัญหาใด ๆ โปรดติดต่อเรา support@brighterdays.com</p>
            </div>
        </div>
    </body>
    </html>
    ";
}
?>