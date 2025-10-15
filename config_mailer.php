<?php
/**
 * ตั้งค่า Email Mailer
 * สำหรับส่ง OTP ไปยัง Email ของผู้ใช้
 */

// ===== ตั้งค่า SMTP =====
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_SECURE', 'tls');

// ===== ตั้งค่า Email Gmail =====
// ⚠️ ใส่ email ของคุณ ที่ต้องการส่ง email จาก
define('SMTP_USER', 'bpluem011@gmail.com'); // เปลี่ยนเป็น email ของคุณ

// ⚠️ ใส่ App Password (ไม่ใช่รหัสผ่าน Gmail ธรรมดา)
// วิธีสร้าง App Password:
// 1. ไปที่ https://myaccount.google.com/apppasswords
// 2. เลือก Mail และ Windows Computer
// 3. Google จะให้รหัส 16 ตัวอักษร (ไม่มีช่องว่าง)
define('SMTP_PASS', 'ncji bxvt ygso jnvd'); // เปลี่ยนเป็น app password ของคุณ

// ===== ตั้งค่าชื่อผู้ส่ง =====
define('MAIL_FROM_ADDRESS', 'bpluem011@gmail.com'); // เปลี่ยนเป็น email ของคุณ
define('MAIL_FROM_NAME', 'Brighter Days Mental Healthcare');

// ===== ตั้งค่าอื่นๆ =====
define('DEBUG_MODE', true); // เปลี่ยนเป็น false เมื่อ production

?>