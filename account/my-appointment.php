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
	<script>
		function confirmCancel() {
			if (confirm("คุณแน่ใจหรือไม่ว่าจะยกเลิกการนัด?"))
				location.href = "/account/delete-appointment.php";
		}
	</script>
</head>
<body>
	<?php include "../components/header.php"; ?>
	<main>
		<?php include "../components/account-nav.php" ?>
		<h1>นัดหมายของฉัน</h1>
		<section>
			<?php include "../components/notice-box.php"; ?>
			<article class="appointment">
				<?php if ($_SESSION["user_appointment"]): ?>
					<h2 class="text-center"><?=$_SESSION["user_appointment"]["doctor_fullname"]?></h2>
					<p class="text-center">
						<?php
							$appmt_time = $_SESSION["user_appointment"]["date"] . "T" . $_SESSION["user_appointment"]["time"];
							$appmt_year = date("Y", strtotime($appmt_time)) + 543;
							$appmt_month = date("m", strtotime($appmt_time));
							$appmt_date = date("d", strtotime($appmt_time));
							$appmt_dayofweek = date("w", strtotime($appmt_time));
							$appmt_time = date("H:i", strtotime($appmt_time));

							$th_day_arr = ["อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์"];
							$th_month_arr = ["","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."];

							$appmt_dayofweek = $th_day_arr[$appmt_dayofweek];
							$appmt_month = $th_month_arr[$appmt_month];
						?>
						<time datetime="<?=$appmt_time?>">
							วัน<?=$appmt_dayofweek?>ที่ <?=$appmt_date?> <?=$appmt_month?> <?=$appmt_year?> เวลา <?=$appmt_time?> น.
						</time>
					</p>
					<h3>สิ่งที่ต้องการปรึกษา</h3>
					<p><?=$_SESSION["user_appointment"]["notes"]?></p>
					<div style="text-align: right;">
						<a class="button" href="pospone-appointment.php">เลื่อนนัดหมาย</a>
						<a class="button" href="javascript:confirmCancel()">ยกเลิกนัดหมาย</a>
					</div>
				<?php else: ?>
					<h2 class="text-center">ไม่พบนัดหมาย</h2>
					<a href="/" class="button big margin-center text-center">ทำนัด</a>
				<?php endif; ?>
			</article>
		</section>
	</main>
	<?php include "../components/footer.php"; ?>
</body>
</html>