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
            $sql = "SELECT user_id, user_name, user_surname, user_tel, citizen_id, email, password, is_admin FROM _user WHERE email = :email";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user) {
                // ตรวจสอบรหัสผ่าน
                if (password_verify($password, $user['password'])) {
                    // สร้าง Session ID ใหม่ ป้องกัน Session Fixation
                    session_regenerate_id();

                    // ล็อกอินสำเร็จ
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_detail'] = [
                        "name" => $user['user_name'],
                        "surname" => $user['user_surname'],
                        "phone_number" => $user['user_tel'],
                        "citizen_id" => $user['citizen_id']
                    ];
                    $_SESSION['is_admin'] = $user['is_admin'];
                    $_SESSION['login_time'] = time();

                    // เก็บรายละเอียดการนัดด้วย
                    $sql2 = "
                        SELECT appointment_id, appointment_date, appointment_time, notes, CONCAT(doctor_name, ' ', doctor_surname) AS doctor_fullname FROM `_appointment`
                        JOIN `_doctor` ON `_doctor`.doctor_id = `_appointment`.doctor_id
                        WHERE user_id = ? AND status = 'confirmed'
                    ";

                    $stmt2 = $pdo->prepare($sql2);
                    $stmt2->bindParam(1, $user['user_id']);
                    $stmt2->execute();
                    $appmt = $stmt2->fetch();

                    if ($appmt) {
                        $_SESSION['user_appointment'] = [
                            "id" => $appmt["appointment_id"],
                            "date" => $appmt["appointment_date"],
                            "time" => $appmt["appointment_time"],
                            "notes" => $appmt["notes"],
                            "doctor_fullname" => $appmt["doctor_fullname"]
                        ];
                    }
                    else {
                        $_SESSION['user_appointment'] = [];
                    }

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
        <a href="/" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
            </svg>
        </a>
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