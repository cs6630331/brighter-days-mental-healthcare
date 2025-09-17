<!DOCTYPE html>
<html lang="th">
<head>
	<?php include "../components/head.php"; ?>
	<title>Appointments | Admin</title>
	<link rel="stylesheet" href="../style/admin.css">
</head>
<body>
	<?php
		$logged_in = true;
		include "../components/header.php";
	?>
	<main>
		<h1>ค้นหานัดหมาย</h1>
		<form id="search">
			<label for="name">
				Name:
				<input type="text" name="name" id="name">
			</label>
			<label for="surname">
				Surname:
				<input type="text" name="surname" id="surname">
			</label>
		</form>
		<?php for ($i = 0; $i < 10; $i++): ?>
			<hr>
			<article class="appointment">
				<hgroup>
					<h2>รักชาติ บุญยิ่งใหญ่</h2>
					<p>ต้องพบกับจิตแพทย์ เพชรกัญญา มีญาณทิพย์</p>
				</hgroup>
				<div>
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
							<path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
							<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
						</svg>
						<time datetime="2025-08-11T13:00">11 ส.ค. 2568, 13:00 น.</time>
					</div>
					<a href="#" class="button big text-center">เสร็จสิ้น</a>
				</div>
			</article>
		<?php endfor; ?>
	</main>
	<?php include "../components/footer.php"; ?>
</body>
</html>