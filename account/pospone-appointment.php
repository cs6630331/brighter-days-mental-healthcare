<?php include "../init.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "../components/head.php"; ?>
	<title>Change Appointment Time | Brighter Days Mental Healthcare</title>
	<link rel="stylesheet" href="/style/account.css">
</head>
<body>
	<?php include "../components/header.php"; ?>
	<main>
		<?php include "../components/account-nav.php" ?>
		<h1>เลื่อนนัดหมาย</h1>
		<section>
			<?php include "../components/notice-box.php"; ?>
			<form action="update-appointment.php" method="post" class="change appointment">
				<?php
					$iso_date_format = "Y-m-d";

					$tomorrow = new DateTime("tomorrow");

					$next14days = new DateTime();
					$next14days->modify("+14 day");
				?>
				<label for="date" class="margin-center">
					เลือกวันนัด:
					<input
						required
						type="date"
						name="date"
						id="date"
						min="<?=date_format($tomorrow, $iso_date_format)?>"
						max="<?=date_format($next14days, $iso_date_format)?>"
					>
				</label>
				<p hidden id="date-err-msg" class="text-center">คุณสามารถนัดล่วงหน้าได้แค่ 1-14 วันเท่านั้น ไม่สามารถนัดวันนี้ วันก่อนหน้า หรือวันที่เลย 14 วันไปแล้วได้</p>
				<div id="time-selector"></div>
				<button type="submit" class="big margin-center">เลื่อน</button>
			</form>
		</section>
	</main>
	<?php include "../components/footer.php"; ?>
	<script src="/script/pospone-appointment.js"></script>
	<script>
		window.addEventListener("load", function() {
			posponeAppointment(<?=$_SESSION["user_appointment"]["doctor_id"]?>)
		});
	</script>
</body>
</html>