<?php
	if (empty($_GET["doctor-id"]) || empty($_GET["date"])) {
		http_response_code(404);
		die();
	}

	// เขียนไว้ชั่วคราว รอให้ระบบหยิบข้อมูลจาก database ได้ก่อน
	$doctor_id = $_GET["doctor-id"];

	$morning_shift = true; 		// เลือก morning_shift จาก database เข้ามาใส่ที่นี่
	$afternoon_shift = true; 	// เลือก afternoon_shift จาก database เข้ามาใส่ที่นี่
	// ---

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