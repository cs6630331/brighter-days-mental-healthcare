function appointment() {
	const appointmentDate = document.getElementById("date");
	const dateErrMsg = document.getElementById("date-err-msg");
	
	const form = document.forms[0];

	const fieldsets = document.querySelectorAll("#appointment-form > *");

	const stepsList = document.querySelectorAll(".steps li:not(:first-child)");

	const prevBtn = document.getElementById("prev-btn");
	const nextBtn = document.getElementById("next-btn");

	const timeSelector = document.getElementById("time-selector");
	
	let activeFieldset = 0;
	
	changeActiveFieldset();

	if (appointmentDate.value)
		validateDate();
	
	appointmentDate.addEventListener("change", validateDate);
	
	prevBtn.addEventListener("click", function() {
		if (activeFieldset === 0) {
			location.href = "/";
			return;
		}

		activeFieldset = Math.max(0, activeFieldset - 1);
		
		if (activeFieldset !== 2) {
			nextBtn.type = "button";
			nextBtn.innerText = "ต่อไป";
		}

		changeActiveFieldset();
	});

	nextBtn.addEventListener("click", function(event) {
		if (nextBtn.type === "submit")
			return;

		let invalidForm = false;

		const inputs = fieldsets[activeFieldset].querySelectorAll("input");
		for (let input of inputs) {
			if (!input.reportValidity()) {
				invalidForm = true;
				break;
			}
		}

		if (invalidForm)
			return;

		event.preventDefault();

		activeFieldset = Math.min(activeFieldset + 1, 2);
		
		if (activeFieldset === 2) {
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
		window.scrollTo({ top: 0 });

		stepsList.forEach((step, i) => {
			if (i === activeFieldset)
				step.ariaCurrent = "true";
			else
				step.removeAttribute("aria-current");
		});

		fieldsets.forEach((fieldset, i) => {
			modifyFieldsetHeight(fieldset, i);

			fieldset.style.transform = `translate(${Math.sign(i - activeFieldset) * 3}rem)`;
			fieldset.style.opacity = Number(i === activeFieldset);
			fieldset.style.zIndex = Number(i === activeFieldset);
		});

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
		const time = new Date();
		time.setHours(9);
		time.setMinutes(0);
		time.setSeconds(0);
		time.setMilliseconds(0);

		do {
			if (time.getHours() === 12) {
				time.setMinutes(time.getMinutes() + 30)
				continue;
			}

			const timeString = time.getHours() + ":" + time.getMinutes().toString().padStart(2, "0");
			const timeId = "time-" + time.getHours() + time.getMinutes().toString().padStart(2, "0");

			const div = document.createElement("div");

			const input = document.createElement("input");
			input.type = "radio";
			input.name = "time";
			input.id = timeId;
			input.required = true;
			input.value = timeString;

			const label = document.createElement("label");
			label.htmlFor = timeId;
			label.innerText = timeString;
			
			div.appendChild(input);
			div.appendChild(label);

			time.setMinutes(time.getMinutes() + 30);
			timeSelector.appendChild(div);

		} while (time.getHours() < 16);
	}
}

window.addEventListener("load", appointment);