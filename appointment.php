<?php
	include "init.php";
	include "connect.php";

	# redirect ไปหน้า login ถ้าผู้ใช้ยังไม่ได้ login
	if (empty($_SESSION["user_id"])) {
		header("Location: /login.php");
		die();
	}
	
	# redirect ไปหน้า My Appointment ถ้าผู้ใช้ลงวันนัดไว้แล้ว
	if (!empty($_SESSION["user_appointment"])) {
		header("Location: /account/my-appointment.php");
		die();
	}

	if (!isset($_GET["id"]) || empty($_GET["id"])) {
		echo "ไม่พบจิตแพทย์ดังกล่าว";
		die();
	}

	$stmt = $pdo->prepare("SELECT CONCAT(doctor_name, ' ', doctor_surname) AS doctor_fullname FROM `_doctor` WHERE doctor_id = ?");
	$stmt->bindParam(1, $_GET["id"]);
	$stmt->execute();
	$row = $stmt->fetch();

	if (!$row) {
		echo "ไม่พบจิตแพทย์ดังกล่าว";
		die();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "./components/head.php"; ?>
	<title>Make Appointment | Brighter Days Mental Healthcare</title>
	<link rel="stylesheet" href="/style/appointment.css">
	<script src="/script/appointment.js"></script>
</head>
<body>
	<?php include "./components/header.php"; ?>
	<main>
		<ol class="steps">
			<li>เริ่ม</li>
			<li aria-current="true">ข้อมูลการนัด</li>
			<li>ข้อมูลผู้ป่วย</li>
			<li>ยืนยันข้อมูล</li>
		</ol>
		<hr>
		<?php include "components/notice-box.php" ?>
		<form action="add-appointment.php" method="post">
			<input type="hidden" name="doctor_id" value="<?=$_GET["id"]?>">
			<input type="hidden" name="doctor_fullname" value="<?=$row["doctor_fullname"]?>">
			<div id="appointment-form">
				<fieldset>
					<?php
						$iso_date_format = "Y-m-d";

						$tomorrow = new DateTime("tomorrow");

						$next14days = new DateTime();
						$next14days->modify("+14 day");
					?>
					<legend>ข้อมูลการนัด</legend>
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
					<p id="date-err-msg" style="display: none;" class="text-center">คุณสามารถนัดล่วงหน้าได้แค่ 1-14 วันเท่านั้น ไม่สามารถนัดวันนี้ วันก่อนหน้า หรือวันที่เลย 14 วันไปแล้วได้</p>
					<div id="time-selector"></div>
				</fieldset>
				<fieldset>
					<legend>ข้อมูลผู้ป่วย</legend>
					<label for="notes">
						สิ่งที่ต้องการปรึกษา
						<textarea required name="notes" id="notes" rows="5"></textarea>
					</label>
				</fieldset>
				<section>
					<article class="appointment">
						<h2 class="text-center"><?=$row["doctor_fullname"]?></h2>
						<p class="text-center">
							<time datetime="NaN" id="time-summary"></time>
						</p>
						<h3>สิ่งที่ต้องการปรึกษา</h3>
						<p id="notes-summary"></p>
					</article>
				</section>
			</div>
			<menu class="separator">
				<li>
					<button type="button" class="big" id="prev-btn">กลับ</button>
				</li>
				<li>
					<button type="button" class="big" id="next-btn">ต่อไป</button>
				</li>
			</menu>
		</form>
	</main>
	<?php include "./components/footer.php"; ?>
</body>
</html>