function verifyPassword(passVal, confirmVal) {
	const password = document.getElementById(passVal);
	const confirmPassword = document.getElementById(confirmVal);
	const result = document.getElementById("password-result");

	password.addEventListener("change", showResult);
	confirmPassword.addEventListener("change", showResult);

	function showResult() {
		if (confirmPassword.value === "")
			result.innerText = "";

		if (password.value !== confirmPassword.value && password.value !== "") {
			result.innerText = "รหัสผ่านไม่ตรงกัน";
		}
		else {
			result.innerText = "";
		}
	}
}