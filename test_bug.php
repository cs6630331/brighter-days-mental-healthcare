<?php
echo "<h1> ทดสอบ PHPMailer</h1>";
echo "<hr>";

// ตรวจสอบ vendor/autoload.php
if (!file_exists('vendor/autoload.php')) {
    echo "<h2 style='color:red;'>❌ Error: vendor/autoload.php ไม่พบ</h2>";
    die();
}

require 'vendor/autoload.php';

// ตรวจสอบ PHPMailer class
if (!class_exists('\PHPMailer\PHPMailer\PHPMailer')) {
    echo "<h2 style='color:red;'>❌ Error: PHPMailer class not found</h2>";
    die();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "<h2>✓ PHPMailer loaded successfully</h2>";
echo "<hr>";

$mail = new PHPMailer(true);

// ตั้งค่า Gmail
$gmail_user = 'bpluem011@gmail.com';
$gmail_pass = 'lelp jxpq qofu thta';

echo "<h3>กำลังทดสอบการเชื่อมต่อ SMTP...</h3>";
echo "<pre style='background:#f0f0f0; padding:10px; border-radius:5px;'>";

try {
    // ตั้งค่า SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $gmail_user;
    $mail->Password = $gmail_pass;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Timeout = 15;
    $mail->CharSet = 'UTF-8';

    echo "Host: smtp.gmail.com\n";
    echo "Port: 587\n";
    echo "Username: $gmail_user\n";
    echo "Security: TLS\n";
    echo "\n";

    // ตั้งค่าผู้ส่ง
    $mail->setFrom($gmail_user, 'Test PHPMailer');
    $mail->addAddress($gmail_user); // ส่งให้ตัวเอง

    // ตั้งค่าอีเมล
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body = '<h2>Testing PHPMailer</h2><p>This is a test email.</p>';
    $mail->AltBody = 'This is a test email.';

    echo "From: $gmail_user\n";
    echo "To: $gmail_user\n";
    echo "Subject: Test Email from PHPMailer\n";
    echo "\nกำลังส่ง...\n";

    echo "</pre>";

    if ($mail->send()) {
        echo "<h2 style='color:green;'>✓ ส่ง Email สำเร็จ!</h2>";
        echo "<p>ตรวจสอบ Gmail Inbox ของคุณ</p>";
    } else {
        echo "<h2 style='color:red;'>❌ ส่ง Email ไม่สำเร็จ</h2>";
        echo "<p>Error: " . $mail->ErrorInfo . "</p>";
    }

} catch (Exception $e) {
    echo "<h2 style='color:red;'>❌ Exception Error</h2>";
    echo "<p>Message: " . $e->getMessage() . "</p>";
    echo "<p>PHPMailer Error: " . $mail->ErrorInfo . "</p>";
} catch (Throwable $e) {
    echo "<h2 style='color:red;'>❌ Fatal Error</h2>";
    echo "<pre>";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString();
    echo "</pre>";
}

echo "<hr>";
echo "<h3>📋 ข้อมูลระบบ:</h3>";
echo "<pre style='background:#f9f9f9; padding:10px; border-radius:5px;'>";
echo "PHP Version: " . phpversion() . "\n";
echo "PHPMailer: " . (class_exists('\PHPMailer\PHPMailer\PHPMailer') ? 'Yes' : 'No') . "\n";
echo "OpenSSL: " . (extension_loaded('openssl') ? 'Yes' : 'No') . "\n";
echo "</pre>";
?>