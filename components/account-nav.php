<aside class="account-nav">
	<nav>
		<ul>
			<li><a href="/account/my-info.php">ข้อมูลของฉัน</a></li>
			<li><a href="/account/my-appointment.php">นัดหมายของฉัน</a></li>
			<li><a href="/account/change-password.php">เปลี่ยนรหัสผ่าน</a></li>
            <?php if ($_SESSION["is_admin"]): ?>
                <li><a href="http://202.44.40.193/~cs6630331/brighter-days-mental-healthcare/admin/appointments.php">ดูนัดหมายผู้ป่วย</a></li>
                <li><a href="http://202.44.40.193/~cs6630331/brighter-days-mental-healthcare/admin/stats.php">ดูสถิติ</a></li>
            <?php endif; ?>
			<li><a href="logout.php">ออกจากระบบ</a></li>
		</ul>
	</nav>
</aside>