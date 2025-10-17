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
	<?php
		$logged_in = true;
		include "../components/header.php";
	?>
	<main>
		<?php include "../components/account-nav.php" ?>
		<h1>ข้อมูลของฉัน</h1>
		<section>
			<form class="account-details">
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
				<div class="separated">
					<button type="submit" class="big">ยืนยัน</button>
				</div>
			</form>
		</section>
	</main>
	<?php include "../components/footer.php"; ?>
</body>
</html>