<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "./components/head.php"; ?>
	<title>Home | Brighter Days Mental Healthcare</title>
	<link rel="stylesheet" href="style/doctor.css">
</head>
<body>
	<?php
		$logged_in = false;
		include "./components/header.php";
	?>
	<main>
		<article class="doctor-details">
			<img src="/img/doctor.png" alt="Doctor">
			<div>
				<hgroup>
					<h1>พ.ญ. เพชรกัญญา มีญาณทิพย์</h1>
					<p>Petkanya Meeyantip, M.D.</p>
				</hgroup>
				<hr>
				<p>ภาษา ไทย, อังกฤษ</p>
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
						<td>
							<div class="timeline">
								09:00-12:00
							</div>
							<div class="timeline"></div>
						</td>
						<td>
							<div class="timeline">
								09:00-12:00
							</div>
							<div class="timeline">
								13:00-16:00
							</div>
						</td>
						<td>
							<div class="timeline"></div>
							<div class="timeline"></div>
						</td>
						<td>
							<div class="timeline">
								09:00-12:00
							</div>
							<div class="timeline">
								13:00-16:00
							</div>
						</td>
						<td>
							<div class="timeline"></div>
							<div class="timeline"></div>
						</td>
						<td>
							<div class="timeline"></div>
							<div class="timeline"></div>
						</td>
						<td>
							<div class="timeline"></div>
							<div class="timeline">
								13:00-16:00
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="separated">
			<a href="/appointment.html" class="button big text-center margin-center">ทำนัด</a>
		</div>
	</main>
	<?php include "./components/footer.php"; ?>
</body>
</html>