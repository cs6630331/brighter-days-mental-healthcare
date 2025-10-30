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
			<?php include "../components/notice-box.php" ?>
			<form class="account-details" action="update-info.php" method="POST">
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
					<input required type="text" name="phone-number" id="phone-number" value="0996584474" pattern="0\d{9}" title="เบอร์โทรต้องขึ้นต้นด้วยเลข 0 ตามด้วยเลข 9 หลัก">
				</label>
				<label for="thai-id">
					รหัสบัตรประชาชน
					<input required type="text" name="thai-id" id="thai-id" pattern="\d{13}" value="1209011111110" title="รหัสบัตรประชาชนต้องประกอบด้วยเลข 13 หลัก">
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