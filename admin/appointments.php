<?php
	include "../init.php";

	if (!$_SESSION["is_admin"]) {
		header("Location: /");
		die();
	}
?>

<!DOCTYPE html>
<html lang="th">
<head>
	<?php include "../components/head.php"; ?>
	<title>Appointments | Admin</title>
	<link rel="stylesheet" href="../style/admin.css">
	<script>
		function confirmComplete(id, patientName) {
			if (window.confirm(`คุณต้องการยืนยันว่าการนัดของ ${patientName} เสร็จสิ้นแล้วหรือไม่`)) {
				location.href = "appointment-done.php?appointment-id=" + id;
			}
		}
	</script>
</head>
<body>
	<?php
		$logged_in = true;
		include "../components/header.php";
	?>
	<main>
		<h1>ค้นหานัดหมาย</h1>
		<form id="search">
			<label for="q">
				Name:
				<input
					type="text"
					name="q"
					id="q"
					<?php if (isset($_GET["q"])): ?>value="<?=$_GET["q"]?>"<?php endif; ?>
				>
			</label>
			<button type="submit">Search</button>
		</form>
		<?php
			include "../connect.php";

			if (isset($_GET["q"]) && !empty($_GET["q"])) {
				$stmt = $pdo->prepare("
					SELECT
					    `_appointment`.`appointment_id`,
					    CONCAT(`_user`.`user_name`, ' ', `_user`.`user_surname`) AS patient_fullname,
					    CONCAT(`_doctor`.`doctor_name`, ' ', `_doctor`.`doctor_surname`) AS doctor_fullname,
					    `_appointment`.`appointment_date`,
					    `_appointment`.`appointment_time`
					FROM
					    `_appointment`
					JOIN `_doctor` ON `_doctor`.`doctor_id` = `_appointment`.`doctor_id`
					JOIN `_user` ON `_user`.`user_id` = `_appointment`.`user_id`
					WHERE `_appointment`.`status` = 'confirmed'
					GROUP BY
						`_appointment`.`appointment_id`
					HAVING
						patient_fullname LIKE ?;
				");
				$q = $_GET["q"] . "%";

				$stmt->bindParam(1, $q);
			}
			else {
				$stmt = $pdo->prepare("
					SELECT
					    `_appointment`.`appointment_id`,
					    CONCAT(`_user`.`user_name`, ' ', `_user`.`user_surname`) AS patient_fullname,
					    CONCAT(`_doctor`.`doctor_name`, ' ', `_doctor`.`doctor_surname`) AS doctor_fullname,
					    `_appointment`.`appointment_date`,
					    `_appointment`.`appointment_time`
					FROM
					    `_appointment`
					JOIN `_doctor` ON `_doctor`.`doctor_id` = `_appointment`.`doctor_id`
					JOIN `_user` ON `_user`.`user_id` = `_appointment`.`user_id`
					WHERE `_appointment`.`status` = 'confirmed'
					GROUP BY
					    `_appointment`.`appointment_id`;
				");
			}
			$stmt->execute();
		?>
		<?php while ($row = $stmt->fetch()): ?>
			<hr>
			<article class="appointment">
				<hgroup>
					<h2><?=$row["patient_fullname"]?></h2>
					<p>ต้องพบกับจิตแพทย์ <?=$row["doctor_fullname"]?></p>
				</hgroup>
				<div>
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
							<path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
							<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
						</svg>
						<time datetime="2025-08-11T13:00"><?=$row["appointment_date"]?>, <?=$row["appointment_time"]?></time>
					</div>
					<button onclick="confirmComplete(<?=$row['appointment_id']?>, '<?=$row['patient_fullname']?>')" class="big text-center">เสร็จสิ้น</button>
				</div>
			</article>
		<?php endwhile; ?>
	</main>
	<?php include "../components/footer.php"; ?>
</body>
</html>