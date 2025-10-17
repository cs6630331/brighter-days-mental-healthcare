<?php
	include "../init.php";

	if (!$_SESSION["is_admin"]) {
		header("Location: /");
		die();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "../components/head.php"; ?>
	<title>Stats | Admin</title>
	<link rel="stylesheet" href="../style/admin.css">
</head>
<body>
	<?php include "../components/header.php"; ?>
	<main>
		<h1>สถิติ</h1>
		<!-- <form action="stats.php" id="doctor-filter">
			<label for="doctor">
				จิตแพทย์ที่ต้องการ
				<select name="doctor" id="doctor">
					<option value="-1">-----</option>
					<?php for ($i = 0; $i < 9; $i++): ?>
						<option value="1">เพชรกัญญา มีญาณทิพย์</option>
					<?php endfor; ?>
				</select>
			</label>
			<button type="submit" class="big">เลือก</button>
		</form> -->
		<div class="allow-overscroll">
			<table class="stats">
				<?php
					include "../connect.php";

					$current_month = date("Y-m%");
					$stmt = $pdo->prepare("
						SELECT 
							`_appointment`.`appointment_id`,
						    `_appointment`.`appointment_date`,
						    `_appointment`.`appointment_time`,
						    CONCAT(`_user`.`user_name`, ' ', `_user`.`user_surname`) AS patient_fullname,
						    CONCAT(`_doctor`.`doctor_name`, ' ', `_doctor`.`doctor_surname`) AS doctor_fullname,
						    `_appointment`.`notes`
						FROM 
						    `_appointment`
						JOIN `_doctor` ON `_doctor`.`doctor_id` = `_appointment`.`doctor_id`
						JOIN `_user` ON `_user`.`user_id` = `_appointment`.`user_id`
						WHERE 
						    `_appointment`.`appointment_date` LIKE ? AND
						    `_appointment`.`status` = 'completed'
						ORDER BY 
						    `_appointment`.`appointment_date`, `_appointment`.`appointment_time`
					");
					$stmt->bindParam(1, $current_month);
					$stmt->execute();
				?>
				<thead>
					<tr>
						<th>วันนัด</th>
						<th>เวลานัด</th>
						<th>ผู้ป่วย</th>
						<th>จิตแพทย์</th>
						<th>สิ่งที่ต้องการปรึกษา</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($row = $stmt->fetch()): ?>
						<tr>
							<td><?=$row["appointment_date"]?></td>
							<td><?=$row["appointment_time"]?></td>
							<td><?=$row["patient_fullname"]?></td>
							<td><?=$row["doctor_fullname"]?></td>
							<td><?=$row["notes"]?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</main>
	<?php include "../components/footer.php"; ?>
</body>
</html>