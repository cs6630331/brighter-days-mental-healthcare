function appointment() {
	const doctorId = new URL(location.href).searchParams.get("doctor-id") || 1;

	const appointmentDate = document.getElementById("date");
	const dateErrMsg = document.getElementById("date-err-msg");
	
	const form = document.forms[0];

	const fieldsets = document.querySelectorAll("#appointment-form > *");

	const stepsList = document.querySelectorAll(".steps li:not(:first-child)");

	const prevBtn = document.getElementById("prev-btn");
	const nextBtn = document.getElementById("next-btn");

	const timeSelector = document.getElementById("time-selector");
	
	let activeFieldset = 0;
	let isFetchingDate = false;
	
	changeActiveFieldset();

	if (appointmentDate.value)
		validateDate();
	
	appointmentDate.addEventListener("change", validateDate);
	
	prevBtn.addEventListener("click", function() {
		// ถ้าอยู่ขั้นตอนที่ 2 ให้กลับไปหน้าเลือกหมอ
		if (activeFieldset === 0) {
			location.href = "/";
			return;
		}

		// เปลี่ยน field
		activeFieldset = Math.max(0, activeFieldset - 1);
		
		if (activeFieldset !== 2) { // ถ้ายังไม่ใช่ช่องสุดท้าย ต้องแน่ใจว่าปุ่มเป็นปุ่มเปลี่ยน field ถัดไป ไม่ใช่ปุ่มส่ง
			nextBtn.type = "button";
			nextBtn.innerText = "ต่อไป";
		}

		changeActiveFieldset();
	});

	nextBtn.addEventListener("click", function(event) {
		// ถ้าถึงขั้นตอนส่ง ไม่ต้องเปลี่ยน field
		if (nextBtn.type === "submit")
			return;

		// ถ้าอยู่ขั้นตอนที่ 2 และยังไม่ได้รับวันที่ อย่าเพิ่งทำขั้นตอนถัดไป
		if (activeFieldset === 0 && isFetchingDate)
			return;

		// ตรวจสอบความถูกต้องของฟอร์ม
		let invalidForm = false;

		const inputs = fieldsets[activeFieldset].querySelectorAll("input, select, textarea");
		for (let input of inputs) {
			if (!input.reportValidity()) {
				invalidForm = true;
				break;
			}
		}

		if (invalidForm) // ถ้าฟอร์มไม่ถูกต้อง อย่าเพิ่งทำขั้นตอนถัดไป
			return;

		event.preventDefault();

		// เปลี่ยน field
		activeFieldset = Math.min(activeFieldset + 1, 2);
		
		if (activeFieldset === 2) { // ถ้า field เป็นสรุป ให้เปลี่ยนปุ่มถัดไป เป็นปุ่มส่งฟอร์ม
			nextBtn.type = "submit";
			nextBtn.innerText = "เสร็จสิ้น";
		}

		changeActiveFieldset();
	});

	window.addEventListener("resize", function() {
		console.log(window.innerHeight < form.offsetTop + 633);
		
		fieldsets.forEach((fieldset, i) => modifyFieldsetHeight(fieldset, i));
	});

	function changeActiveFieldset() {
		window.scrollTo({ top: 0 }); // เลื่อนไปบนสุดของหน้า

		// เปลี่ยนสีของปุ่มขั้นตอนด้านบน (1,2,3,4)
		stepsList.forEach((step, i) => {
			if (i === activeFieldset)
				step.ariaCurrent = "true";
			else
				step.removeAttribute("aria-current");
		});

		// เปลี่ยน field ให้ field ก่อนหน้าเยื้องอยู่ด้านซ้าย ส่วน field ถัดไปให้เยื้องด้านขวา
		fieldsets.forEach((fieldset, i) => {
			modifyFieldsetHeight(fieldset, i);

			fieldset.style.transform = `translate(${Math.sign(i - activeFieldset) * 3}rem)`;
			fieldset.style.opacity = Number(i === activeFieldset);	// ซ่อนโดยใช้ opacity เพื่อ transition ที่สวยงาม
			fieldset.style.zIndex = Number(i === activeFieldset);	// นำ field ที่เลือกอยู่มาไว้ข้างหน้าให้ผู้ใช้กดได้
		});

		// ถ้าอยู่ field สุดท้าย (สรุป) ให้ update ผลสรุป
		if (activeFieldset === 2) {
			const timeSummary = document.getElementById("time-summary");
			const symptomSummary = document.getElementById("symptom-summary");

			const symptom = document.getElementById("symptom");
			const time = document.forms[0]["time"];

			const days = ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"];
			const months = [
				"ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.",
				"พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.",
				"ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
			];

			const appointmentDateValue = new Date(appointmentDate.value);

			timeSummary.innerText =
				`วัน${days[appointmentDateValue.getDay()]}ที่ `     +
				appointmentDateValue.getDate()             + " " +
				months[appointmentDateValue.getMonth()]    + " " +
				(appointmentDateValue.getFullYear() + 543) + " " +
				time.value                                + " น.";
			timeSummary.setAttribute("datetime",
				appointmentDateValue.getFullYear() + "-" +
				(appointmentDateValue.getMonth() + 1).toString().padStart(2, "0") + "-" +
				appointmentDateValue.getDate().toString().padStart(2, "0")
			);
			
			symptomSummary.innerText = symptom.value ? symptom.value : "-";
		}
	}

	function modifyFieldsetHeight(fieldset, i) {
		if (window.innerWidth <= 480 || window.innerHeight < form.offsetTop + 633) {
			if (i === activeFieldset)
				fieldset.style.height = "";
			else {
				setTimeout(function() {
					fieldset.style.height = "0px";
				}, 300)
			}
		}
		else {
			fieldset.style.height = "";
		}
	}

	function validateDate() {
		timeSelector.innerHTML = null;

		if (appointmentDate.checkValidity()) {
			dateErrMsg.innerText = null;
			createTimeSelectors();
		}
		else {
			dateErrMsg.innerText = "คุณสามารถนัดล่วงหน้าได้แค่ 1-14 วันเท่านั้น ไม่สามารถนัดวันนี้ วันก่อนหน้า หรือวันที่เลย 14 วันไปแล้วได้";
		}
	}

	function createTimeSelectors() {
		const xhr = new XMLHttpRequest();
		xhr.responseType = "json";
		
		xhr.addEventListener("load", function(event) {
			isFetchingDate = false;
			timeSelector.innerHTML = null;

			const response = event.target.response;

			for (const data of response) {
				const div = document.createElement("div");

				const input = document.createElement("input");
				input.type = "radio";
				input.name = "time";
				input.id = data.id;
				input.required = true;
				input.value = data.time;

				const label = document.createElement("label");
				label.htmlFor = data.id;
				label.innerText = data.time;
				
				div.appendChild(input);
				div.appendChild(label);

				timeSelector.appendChild(div);
			}
		});

		xhr.open("GET", `appointment-time.php?doctor-id=${doctorId}&date=${appointmentDate.value}`);
		xhr.send();

		isFetchingDate = true;
		timeSelector.innerText = "Loading...";
	}
}

window.addEventListener("load", appointment);