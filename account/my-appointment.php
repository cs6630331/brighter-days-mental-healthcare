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
	<title>My Appointment | Brighter Days Mental Healthcare</title>
	<link rel="stylesheet" href="/style/account.css">
</head>
<body>
	<?php include "../components/header.php"; ?>
	<main>
		<?php include "../components/account-nav.php" ?>
		<h1>นัดหมายของฉัน</h1>
		<section>
			<article class="appointment">
				<h2 class="text-center">พ.ญ. เพชรกัญญา มีญาณทิพย์</h2>
				<p class="text-center">
					<time datetime="2025-08-11">
						วันจันทร์ที่ 11 ส.ค. 2568 13:00 น.
					</time>
				</p>
				<h3>สิ่งที่ต้องการปรึกษา</h3>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati qui ab deserunt aut iusto? Magni officia repudiandae temporibus possimus. Nulla a repudiandae necessitatibus vero natus maxime aperiam nemo, itaque id.</p>
				<p style="text-align: right;"><a href="#" type="submit">ยกเลิกเวลานัด</a></p>
			</article>
		</section>
	</main>
	<?php include "../components/footer.php"; ?>
</body>
</html>