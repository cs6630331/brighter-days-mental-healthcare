<?php

include "../connect.php";
session_start();

if (!isset($_SESSION["user_id"])) {
	header("Location: /login.php");
	die();
}

if (empty($_POST)) {
	header("Location: /account/change-password.php");
	die();
}

if ($_POST["new-password"] !== $_POST["confirm-password"]) {
	setcookie("notice", "รหัสผ่านใหม่ไม่ตรงกับค่ายืนยันรหัสผ่าน กรุณาตรวจสอบความเรียบร้อยก่อนส่ง");
	header("Location: /account/change-password.php");
	die();
}

$user_id = $_SESSION["user_id"];

// ตรวจสอบว่า password ปัจจุบันที่กรอกมาถูกต้องไหม
$stmt = $pdo->prepare("SELECT password FROM `_user` WHERE user_id = ?");
$stmt->bindParam(1, $user_id);
$stmt-> execute();
$row = $stmt->fetch();

if ($row && password_verify($_POST["current-password"], $row["password"])) { // ถ้าถูกต้อง
	$hashed_password = password_hash($_POST["new-password"], PASSWORD_DEFAULT);

	$stmt2 = $pdo->prepare("UPDATE `_user` SET password = ? WHERE user_id = ?");
	$stmt2->bindParam(1, $hashed_password);
	$stmt2->bindParam(2, $user_id);
	$success = $stmt2->execute();

	if ($success)
		setcookie("notice", "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว");
	else
		setcookie("notice", "เกิดข้อผิดพลาดระหว่างเปลี่ยนรหัสผ่าน");
}
else { // ถ้าไม่ถูก
	setcookie("notice", "รหัสผ่านปัจจุบันไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง");
}

header("Location: /account/change-password.php");