<?php
include "connect.php";
session_start();

$stmt = $pdo->prepare("SELECT * FROM `_appointment` WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ?");
$stmt->bindParam(1, $_POST["doctor_id"]);
$stmt->bindParam(2, $_POST["date"]);
$stmt->bindParam(3, $_POST["time"]);

$stmt->execute();
$appointment_available = $stmt->fetch();

if ($appointment_available) {
	setcookie("notice", "หมอไม่ว่างในวันเวลาที่คุณเลือก (" . $_POST["date"] . ", " . $_POST["time"] . ") กรุณาเลือกวันเวลาอื่น");
	header("Location: /appointment.php?id=" . $_POST["doctor_id"]);
	die();
}

$stmt2 = $pdo->prepare("INSERT INTO `_appointment` (user_id, doctor_id, appointment_date, appointment_time, notes) VALUES (?, ?, ?, ?, ?)");
$stmt2->bindParam(1, $_SESSION["user_id"]);
$stmt2->bindParam(2, $_POST["doctor_id"]);
$stmt2->bindParam(3, $_POST["date"]);
$stmt2->bindParam(4, $_POST["time"]);
$stmt2->bindParam(5, $_POST["notes"]);

if ($stmt2->execute()) {
	$_SESSION['user_appointment'] = [
		"id" => $pdo->lastInsertId(),
		"date" => $_POST["date"],
		"time" => $_POST["time"],
		"notes" => $_POST["notes"],
		"doctor_id" => $_POST["doctor_id"],
		"doctor_fullname" => $_POST["doctor_fullname"]
	];
	header("Location: /account/my-appointment.php");
}
else {
	echo "ทำนัดไม่สำเร็จ ขออภัยในความไม่สะดวก";
	die();
}
