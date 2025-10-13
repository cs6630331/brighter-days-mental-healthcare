<?php
session_start();
require 'connect.php';

// ตรวจสอบว่าผ่านการยืนยัน OTP แล้วหรือไม่
if (!isset($_SESSION['otp_verified']) || !isset($_SESSION['verified_email'])) {
    header("Location: otp_email.php");
    exit();
}

$verified_email = $_SESSION['verified_email'];
$error = '';
$success = '';

// ประมวลผล form register
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $tel = trim($_POST['phone-number'] ?? '');
    $citizen_id = trim($_POST['thai-id'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm-password'] ?? '';

    // ตรวจสอบความถูกต้อง
    if (empty($name)) $error = 'กรุณากรอกชื่อ';
    elseif (empty($surname)) $error = 'กรุณากรอกนามสกุล';
    elseif (empty($tel)) $error = 'กรุณากรอกเบอร์โทรศัพท์';
    elseif (empty($citizen_id)) $error = 'กรุณากรอกรหัสบัตรประชาชน';
    elseif (strlen($citizen_id) != 13) $error = 'รหัสบัตรประชาชนต้อง 13 หลัก';
    elseif (strlen($password) < 6) $error = 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร';
    elseif ($password !== $confirm_password) $error = 'รหัสผ่านไม่ตรงกัน';
    else {
        // ตรวจสอบว่าอีเมลมีอยู่ในระบบแล้วหรือไม่
        $check_sql = "SELECT user_id FROM _user WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        if (!$check_stmt) {
            $error = "ข้อผิดพลาด: " . $conn->error;
        } else {
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            
            if ($result->num_rows > 0) {
                $error = 'อีเมลนี้ถูกใช้ไปแล้ว';
            } else {
                // บันทึกข้อมูล
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $insert_sql = "INSERT INTO _user (user_name, user_surname, email, user_tel, citizen_id, password, is_admin) 
                               VALUES (?, ?, ?, ?, ?, ?, 0)";
                $insert_stmt = $conn->prepare($insert_sql);
                
                if (!$insert_stmt) {
                    $error = "ข้อผิดพลาด: " . $conn->error;
                } else {
                    $insert_stmt->bind_param("ssssss", $name, $surname, $email, $tel, $citizen_id, $hashed_password);
                    
                    if ($insert_stmt->execute()) {
                        // ล้าง session OTP
                        unset($_SESSION['otp_verified']);
                        unset($_SESSION['verified_email']);
                        
                        $success = 'ลงทะเบียนสำเร็จ! กำลังเปลี่ยนไปยังหน้าเข้าสู่ระบบ...';
                        echo "<script>
                            setTimeout(function() {
                                window.location.href = 'login.php';
                            }, 2000);
                        </script>";
                    } else {
                        $error = 'เกิดข้อผิดพลาดในการลงทะเบียน: ' . $insert_stmt->error;
                    }
                    $insert_stmt->close();
                }
            }
            $check_stmt->close();
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Brighter Days</title>
    <link rel="stylesheet" href="style/registering.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>🌟 Brighter Days</h1>
            <p>Mental Healthcare</p>
        </div>

        <h2>กรอกข้อมูลส่วนตัว</h2>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <div class="email-display">
            ✓ อีเมล: <?php echo htmlspecialchars($verified_email); ?>
        </div>

        <form method="POST" id="registerForm">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($verified_email); ?>">

            <div class="form-row">
                <div class="form-group">
                    <label for="name">ชื่อ *</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        required
                        value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                    >
                </div>
                <div class="form-group">
                    <label for="surname">นามสกุล *</label>
                    <input 
                        type="text" 
                        name="surname" 
                        id="surname" 
                        required
                        value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>"
                    >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone-number">เบอร์โทรศัพท์ *</label>
                    <input 
                        type="tel" 
                        name="phone-number" 
                        id="phone-number" 
                        pattern="[0-9]{10}"
                        placeholder="0xxxxxxxxx"
                        required
                        value="<?php echo isset($_POST['phone-number']) ? htmlspecialchars($_POST['phone-number']) : ''; ?>"
                    >
                </div>
                <div class="form-group">
                    <label for="thai-id">รหัสบัตรประชาชน *</label>
                    <input 
                        type="text" 
                        name="thai-id" 
                        id="thai-id" 
                        pattern="[0-9]{13}"
                        placeholder="0000000000000"
                        maxlength="13"
                        required
                        value="<?php echo isset($_POST['thai-id']) ? htmlspecialchars($_POST['thai-id']) : ''; ?>"
                    >
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label for="password">รหัสผ่าน *</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="อย่างน้อย 6 ตัวอักษร"
                        required
                    >
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label for="confirm-password">ยืนยันรหัสผ่าน *</label>
                    <input 
                        type="password" 
                        name="confirm-password" 
                        id="confirm-password" 
                        placeholder="กรอกรหัสผ่านอีกครั้ง"
                        required
                    >
                </div>
            </div>

            <button type="submit">สมัครสมาชิก</button>
        </form>

        <div class="footer-text">
            มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a>
        </div>
    </div>

    <script>
        // ตรวจสอบเบอร์โทร
        document.getElementById('phone-number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });

        // ตรวจสอบรหัสประชาชน
        document.getElementById('thai-id').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });

        // ตรวจสอบรหัสผ่านตรงกัน
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('รหัสผ่านไม่ตรงกัน โปรดตรวจสอบอีกครั้ง');
            }
        });
    </script>
</body>
</html>
