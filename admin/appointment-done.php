<?php

session_start();

if (!$_SESSION["is_admin"]) {
	header("Location: /");
	die();
}

include "../connect.php";

if (!isset($_GET["appointment-id"]) || empty($_GET["appointment-id"])) {
	http_response_code(400);
	die();
}

$stmt = $pdo->prepare("UPDATE `_appointment` SET `status` = 'completed' WHERE `appointment_id` = ?");
$stmt->bindParam(1, $_GET["appointment-id"]);

if ($stmt->execute()) {
	setcookie("notice", "ทำนัดหมาย #" . $_GET["appointment-id"] . " เสร็จสิ้นเรียบร้อยแล้ว");

	header("Location: appointments.php");
	die();
}
else
	echo "Error.";