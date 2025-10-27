<?php
	include "../init.php";

	if (!isset($_SESSION["user_id"])) {
		header("Location: /login.php");
		die();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "../components/head.php"; ?>
	<title>My Info | Brighter Days Mental Healthcare</title>
	<link rel="stylesheet" href="/style/account.css">
</head>
<body>
	<?php include "../components/header.php"; ?>
	<main>
		<?php include "../components/account-nav.php" ?>
		<h1>เปลี่ยนรหัสผ่าน</h1>
		<section>
			<?php include "../components/notice-box.php" ?>
			<form class="account-details" action="update-password.php" method="POST">
				<label for="current-password">
					รหัสผ่านปัจจุบัน
					<input required type="password" name="current-password" id="current-password">
				</label>
				<label for="new-password">
					รหัสผ่านใหม่
					<input required type="password" name="new-password" id="new-password" pattern=".{8,}" title="อย่างน้อย 8 ตัวอักษร">
				</label>
				<label for="confirm-password">
					ยืนยันรหัสผ่าน
					<input required type="password" name="confirm-password" id="confirm-password" pattern=".{8,}" title="ค่าที่กรอกต้องเหมือนกับค่าที่กรอกไปในช่อง รหัสผ่านใหม่">
				</label>
				<div></div>
				<div id="password-result"></div>
				<div class="separated">
					<button class="big" type="submit">เปลี่ยนรหัสผ่าน</button>
				</div>
			</form>
		</section>
	</main>
	<?php include "../components/footer.php"; ?>
	<script src="/script/password.js"></script>
	<script>
		window.addEventListener("load", function() {
			verifyPassword("new-password", "confirm-password");
		});
	</script>
</body>
</html>