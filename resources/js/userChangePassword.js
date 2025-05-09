document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("changePasswordForm");
  const modal = document.getElementById("changePasswordPopup");
  const cancelBtn = document.getElementById("cancelChange");
  const confirmBtn = document.getElementById("confirmChange");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (newPassword !== confirmPassword) {
      alert("New password and confirm password do not match.");
      return;
    }

    modal.style.display = "flex";
  });

  cancelBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  confirmBtn.addEventListener("click", () => {
    modal.style.display = "none";
    document.getElementById("changePasswordForm").submit();
  });
});
