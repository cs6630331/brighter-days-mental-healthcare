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
		<h1>ข้อมูลของฉัน</h1>
		<section>
			<form class="account-details">
				<label for="name">
					ชื่อ
					<input required type="text" name="name" id="name" value="<?=$_SESSION["user_detail"]["name"]?>">
				</label>
				<label for="surname">
					นามสกุล
					<input required type="text" name="surname" id="surname" value="<?=$_SESSION["user_detail"]["surname"]?>">
				</label>
				<label for="phone-number">
					เบอร์โทรติดต่อ
					<input required type="text" name="phone-number" id="phone-number" value="<?=$_SESSION["user_detail"]["phone_number"]?>">
				</label>
				<label for="thai-id">
					รหัสบัตรประชาชน
					<input required type="text" name="thai-id" id="thai-id" pattern="\d{13}" value="<?=$_SESSION["user_detail"]["citizen_id"]?>">
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