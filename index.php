<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "./components/head.php"; ?>
	<title>Home | Brighter Days Mental Healthcare</title>
	<link rel="stylesheet" href="/style/index.css">
</head>
<body>
	<?php
		$logged_in = false;
		include "./components/header.php";
	?>
	<main>
		<h2>เลือกจิตแพทย์</h2>
		<section class="doc-card-group">
			<?php for ($i = 0; $i < 9; $i++): ?>
				<article class="doc-card">
					<img src="/img/doctor.png" alt="รูปภาพของ พ.ญ. เพชรกัญญา มีญาณทิพย์">
					<p><b>พ.ญ. เพชรกัญญา มีญาณทิพย์</b></p>
					<div>
						<a class="button" class="button" href="/appointment.php">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
								<path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
								<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
							</svg>
							<span>ทำนัด</span>
						</a>
						<a class="button" class="button" href="/doctor.php">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
								<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
								<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
							</svg>
							<span>รายละเอียด</span>
						</a>
					</div>
				</article>
			<?php endfor; ?>
		</section>
	</main>
	<?php include "./components/footer.php"; ?>
</body>
</html>