<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "./components/head.php"; ?>
	<title>Register | Brighter Days Mental Healthcare</title>
	<link rel="stylesheet" href="style/register.css">
</head>
<body>
	<?php include "./components/header.php"; ?>
	<main>
		<h1>ข้อมูลผู้ใช้</h1>
		<form class="register-card">
			<label for="name">
				ชื่อ
				<input required type="text" name="name" id="name">
			</label>
			<label for="surname">
				นามสกุล
				<input required type="text" name="surname" id="surname">
			</label>
			<label for="gender">
				เพศ
				<select name="gender" id="gender">
					<option value="male">ชาย</option>
					<option value="female">หญิง</option>
					<option value="other">อื่น ๆ</option>
					<option value="intersex">ไม่ทราบเพศ</option>
				</select>
			</label>
			<label for="birthdate">
				วันเดือนปีเกิด
				<input required type="date" name="birthdate" id="birthdate">
			</label>
			<label for="phone-number">
				เบอร์โทรติดต่อ
				<input required type="text" name="phone-number" id="phone-number">
			</label>
			<label for="email">
				อีเมลติดต่อ
				<input required type="email" name="email" id="email">
			</label>
			<label for="nationality">
				สัญชาติ
				<input required type="text" name="nationality" id="nationality">
			</label>
			<label for="thai-id">
				รหัสบัตรประชาชน
				<input required type="text" name="thai-id" id="thai-id" pattern="\d{13}">
			</label>
			<label for="password">
				Password
				<input required type="password" name="password" id="password">
			</label>
			<label for="confirm-password">
				Confirm Password
				<input required type="password" name="confirm-password" id="confirm-password">
			</label>
			<div class="separated">
				<button type="submit" class="big margin-center">ยืนยัน</button>
			</div>
		</form>
	</main>
</body>
</html>