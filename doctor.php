<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "./components/head.php"; ?>
	<title>Home | Brighter Days Mental Healthcare</title>
	<link rel="stylesheet" href="style/doctor.css">
</head>
<body>
	<?php include "./components/header.php"; ?>
	<?php
		include "connect.php";

		if (!isset($_GET["id"]) || empty($_GET["id"])) {
			echo "ไม่พบจิตแพทย์ดังกล่าว";
			die();
		}

		$stmt = $pdo->prepare("SELECT * FROM `_doctor` WHERE doctor_id = ?");
		$stmt->bindParam(1, $_GET["id"]);
		$stmt->execute();
		$row = $stmt->fetch();
		
		if (!$row) {
			echo "ไม่พบจิตแพทย์ดังกล่าว";
			die();
		}
	?>
	<main>
		<article class="doctor-details">
			<img src="/img/doctor.png" alt="Doctor">
			<div>
				<hgroup>
					<h1><?=$row["doctor_name"]?> <?=$row["doctor_surname"]?></h1>
				</hgroup>
				<hr>
				<p><?=$row["doctor_education"]?></p>
			</div>
		</article>
		<h2 class="text-center">ตารางออกตรวจ</h2>
		<div class="allow-overscroll">
			<table>
				<thead>
					<tr>
						<th>จ.</th>
						<th>อ.</th>
						<th>พ.</th>
						<th>พฤ.</th>
						<th>ศ.</th>
						<th>ส.</th>
						<th>อา.</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php for ($i = 0; $i < 7; ++$i): ?>
							<td>
								<div class="timeline"><?php if ($row["morning_shift"] == 1): ?>09:00-12:00<?php endif; ?></div>
								<div class="timeline"><?php if ($row["afternoon_shift"] == 1): ?>13:00-16:00<?php endif; ?></div>
							</td>
						<?php endfor; ?>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="separated">
			<a href="/appointment.php?id=<?=$row["doctor_id"]?>" class="button big text-center margin-center">ทำนัด</a>
		</div>
	</main>
	<?php include "./components/footer.php"; ?>
</body>
</html>