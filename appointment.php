<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "./components/head.php"; ?>
	<title>Make Appointment | Brighter Days Mental Healthcare</title>
	<link rel="stylesheet" href="/style/appointment.css">
	<script src="/script/appointment.js"></script>
</head>
<body>
	<?php
		$logged_in = true;
		include "./components/header.php";
	?>
	<main>
		<ol class="steps">
			<li>เริ่ม</li>
			<li aria-current="true">ข้อมูลการนัด</li>
			<li>ข้อมูลผู้ป่วย</li>
			<li>ยืนยันข้อมูล</li>
		</ol>
		<hr>
		<form action="#">
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
					<p id="date-err-msg" class="text-center"></p>
					<div id="time-selector"></div>
				</fieldset>
				<fieldset>
					<legend>ข้อมูลผู้ป่วย</legend>
					<label for="symptom">
						สิ่งที่ต้องการปรึกษา
						<textarea required name="symptom" id="symptom" rows="5"></textarea>
					</label>
				</fieldset>
				<section>
					<article class="appointment">
						<h2 class="text-center">พ.ญ. เพชรกัญญา มีญาณทิพย์</h2>
						<p class="text-center">
							<time datetime="NaN" id="time-summary"></time>
						</p>
						<h3>สิ่งที่ต้องการปรึกษา</h3>
						<p id="symptom-summary"></p>
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