<?php

include "../connect.php";
session_start();

if (!isset($_SESSION["user_id"])) {
	header("Location: /login.php");
	die();
}

if (empty($_POST)) {
	header("Location: my-info.php");
	die();
}

$stmt = $pdo->prepare("UPDATE `_user` SET user_name = ?, user_surname = ?, user_tel = ?, citizen_id = ? WHERE user_id = ?");
$stmt->bindParam(1, $_POST["name"]);
$stmt->bindParam(2, $_POST["surname"]);
$stmt->bindParam(3, $_POST["phone-number"]);
$stmt->bindParam(4, $_POST["thai-id"]);
$stmt->bindParam(5, $_SESSION["user_id"]);

if ($stmt->execute()) {
	$_SESSION['user_detail'] = [
		"name" => $_POST["name"],
		"surname" => $_POST["surname"],
		"phone_number" => $_POST["phone-number"],
		"citizen_id" => $_POST["thai-id"]
	];

	header("Location: my-info.php");
	setcookie("notice", "อัพเดตข้อมูลสำเร็จ");
}
else {
	echo "เกิดข้อผิดพลาดระหว่างอัพเดตข้อมูล";
}