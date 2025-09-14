<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "./components/head.php"; ?>
	<title>Login | Brighter Days Mental Healthcare</title>
	<link rel="stylesheet" href="/style/login.css">
</head>
<body>
	<?php include "./components/header.php"; ?>
	<main>
		<h1>ข้อมูลผู้ใช้</h1>
		<form class="login-card">
			<label for="email">
				Email
				<input required type="email" name="email" id="email">
			</label>
			<label for="password">
				Password
				<input required type="password" name="password" id="password">
			</label>
			<div class="separated">
				<button type="submit" class="big margin-center">ยืนยัน</button>
			</div>
		</form>
		<div class="separated">
			<p class="text-center">Don't have an account? <a href="/register.php">Register Now</a></p>
		</div>
	</main>
</body>
</html>