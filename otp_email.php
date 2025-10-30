<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Brighter Days</title>
    <link rel="stylesheet" href=" style/email_otp.css ">
</head>

<body>
    <main class="container">
        <header class="logo">
            <h1>🌟 Brighter Days</h1>
            <p>Mental Healthcare</p>
        </header>

        <section class="form-section">
            <h2>ลงทะเบียน</h2>

            <div class="error-message" id="errorMessage"></div>

            <form method="POST" action="send_otp.php" id="emailForm">
                <div class="form-group">
                    <label for="email">กรุณากรอกอีเมล</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        placeholder="example@gmail.com"
                        required
                    >
                </div>

                <button type="submit">ส่ง OTP</button>
            </form>
        </section>

        <footer class="footer-text">
            มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a>
        </footer>
    </main>

    <script>
        document.getElementById('emailForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                e.preventDefault();
                const errorMsg = document.getElementById('errorMessage');
                errorMsg.textContent = 'กรุณากรอกอีเมลที่ถูกต้อง';
                errorMsg.classList.add('show');
            }
        });
    </script>
</body>
</html>