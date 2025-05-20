document.addEventListener("DOMContentLoaded", () => {
  const confirmBtn = document.getElementById("confirmChange");
  const cancelBtn = document.getElementById("cancelChange");
  const changeBtn = document.querySelector(".changePasswordButton");

  changeBtn.addEventListener("click", (e) => {
    e.preventDefault();
    const username = document.getElementById("username").value;
    document.getElementById("changeUserID").textContent = username;
    document.getElementById("changePasswordPopup").style.display = "flex";
  });

  if (cancelBtn) {
    cancelBtn.addEventListener("click", hideChangePasswordPopup);
  }

  if (confirmBtn) {
    confirmBtn.addEventListener("click", () => {
      const username = document.getElementById("username").value;
      const newPassword = document.getElementById("new-password").value;
      const adminPassword = document.getElementById("adminConfirmPassword").value;

      fetch("/SysDevProject/resources/api/adminchangeUserPassword.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, newPassword, adminPassword })
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.success) {
          hideChangePasswordPopup();
        }
      })
      .catch(err => {
        console.error("Request failed:", err);
        alert("Something went wrong. Please try again.");
      });
    });
  }
});

function hideChangePasswordPopup() {
  document.getElementById("changePasswordPopup").style.display = "none";
}
