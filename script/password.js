function verifyPassword(passVal, confirmVal) {
	const password = document.getElementById(passVal);
	const confirmPassword = document.getElementById(confirmVal);
	const result = document.getElementById("password-result");

	password.addEventListener("change", showResult);
	confirmPassword.addEventListener("change", showResult);

	function showResult() {
		if (confirmPassword.value === "")
			result.style.display = "none";
		else if (password.value !== confirmPassword.value && password.value !== "")
			result.style.block = "block";
		else
			result.style.display = "none";
	}
}