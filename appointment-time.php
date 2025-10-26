<?php
	include "connect.php";

	if (empty($_GET["doctor-id"]) || empty($_GET["date"])) {
		http_response_code(404);
		die();
	}

	$doctor_id = $_GET["doctor-id"];

	$stmt = $pdo->prepare("SELECT morning_shift, afternoon_shift FROM `_doctor` WHERE doctor_id = ?");
	$stmt->bindParam(1, $doctor_id);
	$stmt->execute();
	$row = $stmt->fetch();

	$morning_shift = $row["morning_shift"]; 		// เลือก morning_shift จาก database เข้ามาใส่ที่นี่
	$afternoon_shift = $row["afternoon_shift"]; 	// เลือก afternoon_shift จาก database เข้ามาใส่ที่นี่

	class AppointmentTimeData {
		public $time;
		public $id;

		public function __construct($datetime) {
			$this->time = $datetime->format("H:i");
			$this->id = "time-" . $datetime->format("Hi");
		}
	}

	$data = [];
	$datetime = new DateTime("09:00:00");

	if ($morning_shift) {
		do {
			array_push($data, new AppointmentTimeData($datetime));
			$datetime->modify("+30 minute");
		}
		while ($datetime->format("H") != "12");
	}
	
	if ($afternoon_shift) {
		$datetime->modify("+1 hour");

		do {
			array_push($data, new AppointmentTimeData($datetime));
			$datetime->modify("+30 minute");
		}
		while ($datetime->format("H") != "16");
	}

	header("Content-Type: application/json; charset=utf8");

	echo json_encode($data);
?>