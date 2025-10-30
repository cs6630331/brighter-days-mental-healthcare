function posponeAppointment(doctorId) {
	const appointmentDate = document.getElementById("date");
	const timeSelector = document.getElementById("time-selector");
    const dateErrMsg = document.getElementById("date-err-msg");

    appointmentDate.addEventListener("change", createTimeSelectors);

    function createTimeSelectors() {
        if (!appointmentDate.checkValidity()) {
            dateErrMsg.style.display = "block";
            timeSelector.innerHTML = null;
            return;
        }
        else {
            dateErrMsg.style.display = "none";
        }

		const xhr = new XMLHttpRequest();
		
		xhr.addEventListener("load", function(event) {
			isFetchingDate = false;
			timeSelector.innerHTML = null;

			const response = JSON.parse(xhr.responseText);

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

		xhr.open("GET", `../appointment-time.php?doctor-id=${doctorId}&date=${appointmentDate.value}`);
		xhr.send();

		isFetchingDate = true;
		timeSelector.innerText = "Loading...";
	}
}