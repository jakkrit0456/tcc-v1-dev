const loginForm = document.getElementById("loginForm");
const alertBox = document.getElementById("alertBox");
const loginBtn = document.getElementById("loginBtn");

function showAlert(message, type = "error") {
    alertBox.textContent = message;
    alertBox.className = `alert show ${type}`;
}

function hideAlert() {
    alertBox.textContent = "";
    alertBox.className = "alert";
}

loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    hideAlert();

    const formData = new FormData(loginForm);

    loginBtn.disabled = true;
    loginBtn.textContent = "กำลังเข้าสู่ระบบ...";

    try {
        const response = await fetch("../../api/auth/login.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (!result.success) {
            showAlert(result.message || "เข้าสู่ระบบไม่สำเร็จ", "error");
            return;
        }

        showAlert(result.message || "เข้าสู่ระบบสำเร็จ", "success");

        setTimeout(() => {
            window.location.href = result.redirect;
        }, 500);
    } catch (error) {
        showAlert("เกิดข้อผิดพลาดในการเชื่อมต่อระบบ", "error");
    } finally {
        loginBtn.disabled = false;
        loginBtn.textContent = "Login";
    }
});