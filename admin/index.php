<?php
	session_start();

	if ($_SESSION["is_admin"])
		header("Location: /admin/appointments.php");
	else
		header("Location: /");

	die();
?>