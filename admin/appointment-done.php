<?php
	include "../connect.php";

	if (!isset($_GET["appointment-id"]) || empty($_GET["appointment-id"])) {
		http_response_code(400);
		die();
	}

	$stmt = $pdo->prepare("UPDATE `_appointment` SET `status` = 'completed' WHERE `appointment_id` = ?");
	$stmt->bindParam(1, $_GET["appointment-id"]);
	
	if ($stmt->execute()) {
		header("Location: appointments.php");
		die();
	}
	else
		echo "Error.";
?>