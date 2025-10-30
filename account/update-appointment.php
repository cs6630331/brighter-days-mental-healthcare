<?php
include "../connect.php";
session_start();

if (!isset($_SESSION["user_id"])) {
	header("Location: /login.php");
	die();
}


$stmt = $pdo->prepare("SELECT * FROM `_appointment` WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ?");
$stmt->bindParam(1, $_SESSION["user_appointment"]["doctor_id"]);
$stmt->bindParam(2, $_POST["date"]);
$stmt->bindParam(3, $_POST["time"]);

$stmt->execute();
$row = $stmt->fetch();

if ($row) {
	setcookie("notice", "หมอไม่ว่างในวันเวลาที่คุณเลือก (" . $_POST["date"] . ", " . $_POST["time"] . ") กรุณาเลือกวันเวลาอื่น");
	header("Location: /account/pospone-appointment.php");
	die();
}

$stmt2 = $pdo->prepare("UPDATE `_appointment` SET appointment_date = ?, appointment_time = ? WHERE appointment_id = ?");
$stmt2->bindParam(1, $_POST["date"]);
$stmt2->bindParam(2, $_POST["time"]);
$stmt2->bindParam(3, $_SESSION["user_appointment"]["id"]);

if ($stmt2->execute()) {
	$_SESSION["user_appointment"]["date"] = $_POST["date"];
	$_SESSION["user_appointment"]["time"] = $_POST["time"];
	setcookie("notice", "เลื่อนเวลานัดสำเร็จ");
}
else {
	setcookie("notice", "เลื่อนเวลานัดไม่สำเร็จ ขออภัยในความไม่สะดวก");
}

header("Location: /account/my-appointment.php");