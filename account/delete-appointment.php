<?php
include "../connect.php";
session_start();

if (!isset($_SESSION["user_id"])) {
	header("Location: /login.php");
	die();
}

$stmt = $pdo->prepare("DELETE FROM `_appointment` WHERE appointment_id = ?");
$stmt->bindParam(1, $_SESSION["user_appointment"]["id"]);

if ($stmt->execute()) {
	$_SESSION["user_appointment"] = [];
	setcookie("notice", "ยกเลิกการนัดเรียบร้อย");
}
else
	setcookie("notice", "เกิดข้อผิดพลาดระหว่างยกเลิกการนัด");

header("Location: /account/my-appointment.php");