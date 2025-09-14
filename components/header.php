<header id="site-nav">
	<h1><a href="/">BDMH</a></h1>
	<input type="checkbox" id="menu-button">
	<label for="menu-button">Menu</label>
	<nav>
		<ul>
			<?php if (
				str_starts_with($_SERVER["REQUEST_URI"], "/login") or
				str_starts_with($_SERVER["REQUEST_URI"], "/register")):
			?>
				<li><a href="/">กลับหน้าหลัก</a></li>
			<?php else: ?>
				<li><a href="/">ทำนัด</a></li>
				<li><a href="#">การเดินทาง</a></li>
				<li><a href="#">คำถามที่พบบ่อย</a></li>
				<li><a href="#">เกี่ยวกับเรา</a></li>
				<?php if ($logged_in): ?>
					<li>
						<a href="/account" class="login">
							<span>
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
									<path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
									<path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
								</svg>
								<span>บัญชีผู้ใช้</span>
							</span>
						</a>
					</li>
				<?php else: ?>
					<li>
						<a href="/login.php" class="login">
							<span>
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
									<path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
									<path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
								</svg>
								<span>เข้าสู่ระบบ</span>
							</span>
						</a>
					</li>
				<?php endif; ?>
			<?php endif; ?>
		</ul>
	</nav>
</header>