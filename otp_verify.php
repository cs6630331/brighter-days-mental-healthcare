<?php
session_start();

// ตรวจสอบว่ามี OTP ใน session หรือไม่
if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_email'])) {
    header("Location: otp_email.php");
    exit();
}

// ตรวจสอบว่า OTP หมดอายุหรือไม่
if (time() > $_SESSION['otp_expire']) {
    unset($_SESSION['otp']);
    unset($_SESSION['otp_email']);
    unset($_SESSION['otp_expire']);
    $_SESSION['error'] = 'รหัส OTP หมดอายุแล้ว โปรดขอใหม่';
    header("Location: otp_email.php");
    exit();
}

$email = $_SESSION['otp_email'];
$remaining_time = $_SESSION['otp_expire'] - time();

// ประมวลผล OTP ที่ส่งมา
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp_input = str_replace(' ', '', $_POST['otp']);
    
    if ($otp_input == $_SESSION['otp']) {
        // OTP ถูกต้อง เตรียมไปหน้า register
        $_SESSION['otp_verified'] = true;
        $_SESSION['verified_email'] = $email;
        unset($_SESSION['otp']);
        header("Location: register.php");
        exit();
    } else {
        $_SESSION['otp_error'] = 'รหัส OTP ไม่ถูกต้อง โปรดลองใหม่';
    }
}

// ลบข้อความแจ้งเตือน
$error = isset($_SESSION['otp_error']) ? $_SESSION['otp_error'] : '';
unset($_SESSION['otp_error']);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยืนยัน OTP - Brighter Days</title>
    <link rel="stylesheet" href="style/otp_verify.css">
</head>
<body>
    <main class="container">
        <header class="logo">
            <h1>🌟 Brighter Days</h1>
            <p>Mental Healthcare</p>
        </header>

        <section class="form-section">
            <div class="success-icon">📧</div>
            <h2>ยืนยันรหัส OTP</h2>
            <div class="email-display">กรอก OTP ที่ได้รับจาก<br><?php echo htmlspecialchars($email); ?></div>

            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="otp">รหัส OTP (6 หลัก)</label>
                    <input 
                        type="text" 
                        name="otp" 
                        id="otp" 
                        maxlength="6"
                        placeholder="000000"
                        inputmode="numeric"
                        required
                        autofocus
                    >
                </div>

                <button type="submit">ยืนยัน</button>

                <div class="timer" id="timer">
                    เวลาคงเหลือ: <span id="countdown">10:00</span>
                </div>
            </form>

            <div class="resend">
                <p>ไม่ได้รับรหัส? <a href="otp_email.php">ขอรหัสใหม่</a></p>
            </div>
        </section>

        <footer class="footer-text">
            มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a>
        </footer>
    </main>

    <script>
        // OTP input format (เว้นวรรค)
        document.getElementById('otp').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 6) {
                value = value.slice(0, 6);
            }
            e.target.value = value;
        });

        // Timer countdown
        let remaining = <?php echo $remaining_time; ?>;
        
        function updateTimer() {
            if (remaining <= 0) {
                document.getElementById('countdown').textContent = '00:00';
                document.querySelector('button').disabled = true;
                document.getElementById('timer').classList.add('warning');
                document.getElementById('timer').innerHTML = 'รหัส OTP หมดอายุแล้ว <a href="otp_email.php">ขอรหัสใหม่</a>';
                return;
            }

            let minutes = Math.floor(remaining / 60);
            let seconds = remaining % 60;
            document.getElementById('countdown').textContent = 
                String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

            if (remaining <= 120) {
                document.getElementById('timer').classList.add('warning');
            }

            remaining--;
            setTimeout(updateTimer, 1000);
        }

        updateTimer();
    </script>
</body>
</html>