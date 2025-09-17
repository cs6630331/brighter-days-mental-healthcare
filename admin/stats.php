<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "../components/head.php"; ?>
	<title>Stats | Admin</title>
	<link rel="stylesheet" href="../style/admin.css">
</head>
<body>
	<?php
		$logged_in = true;
		include "../components/header.php";
	?>
	<main>
		<h1>สถิติ</h1>
		<form action="stats.php" id="doctor-filter">
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
		</form>
		<div class="allow-overscroll">
			<table class="stats">
				<thead>
					<tr>
						<th>เดือน/ปี</th>
						<th>จำนวนผู้ลงนัดหมาย</th>
						<th>จำนวนวันที่นัดหมาย</th>
					</tr>
				</thead>
				<tbody>
					<?php for ($i = 0; $i < 10; $i++): ?>
						<tr>
							<td>06/2025</td>
							<td>95</td>
							<td>10</td>
						</tr>
					<?php endfor; ?>
				</tbody>
			</table>
		</div>
	</main>
	<?php include "../components/footer.php"; ?>
</body>
</html>