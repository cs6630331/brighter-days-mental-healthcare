<?php
session_start();
require 'connect.php'; //โหลดไฟล์ที่เชื่อม database

if (!empty($_SESSION["user_id"])) {
    header("Location: /account/my-info.php");
    die();
}

$error = ''; //เก็บข้อความ error
$email = '';

// ประมวลผล login
if ($_SERVER["REQUEST_METHOD"] == "POST") {   //เช็คว่ากดยืนยันใช่มั้ย
    $email = trim($_POST['email'] ?? '');  //trim คือลบช่องว่างด้านหน้าออก  ถ้าไม่มีค่าให้ใช้ string ว่าง
    $password = $_POST['password'] ?? '';

    // ตรวจสอบว่าว่างมั้ย
    if (empty($email)) {
        $error = 'กรุณากรอกอีเมล';
    } 
    else if (empty($password)) {
        $error = 'กรุณากรอกรหัสผ่าน';
    } 
    else {
        try {
            $sql = "SELECT user_id, user_name, email, password, is_admin FROM _user WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user) {
                // ตรวจสอบรหัสผ่าน
                if (password_verify($password, $user['password'])) {
                    // ล็อกอินสำเร็จ
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_name'] = $user['user_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['is_admin'] = $user['is_admin'];
                    $_SESSION['login_time'] = time();

                    // เปลี่ยนไปหน้าแรก
                    header("Location: index.php");
                    exit();
                } else {
                    $error = 'รหัสผ่านไม่ถูกต้อง';
                }
            } 
            else {
                $error = 'ไม่พบอีเมลนี้ในระบบ';
            }
        } 
        catch (PDOException $e) {
            $error = "ข้อผิดพลาด: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Brighter Days</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>🌟 Brighter Days</h1>
            <p>Mental Healthcare</p>
        </div>

        <div class="login-icon">🔐</div>
        <h2>เข้าสู่ระบบ</h2>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
            <div class="form-group">
                <label for="email">อีเมล</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="example@gmail.com"
                    required
                    value="<?php echo htmlspecialchars($email); ?>"
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">รหัสผ่าน</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="••••••••"
                    required
                >
            </div>

            <div class="forgot-password">
                <a href="#">ลืมรหัสผ่าน?</a>
            </div>

            <button type="submit">ยืนยัน</button>
        </form>

        <div class="footer-links">
            <div class="footer-text">
                ยังไม่มีบัญชี? <a href="otp_email.php">สมัครสมาชิก</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (email.trim() === '' || password.trim() === '') {
                e.preventDefault();
                alert('กรุณากรอกอีเมลและรหัสผ่าน');
            }
        });
    </script>
</body>
</html>