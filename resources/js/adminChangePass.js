// Handle popup confirmation logic (e.g., submit form or call API)
function confirmPasswordChange() {
  // Option 1: Submit a form
  const form = document.getElementById("changePasswordForm");
  if (form) {
    form.submit();
  }

  // Option 2: Send AJAX request instead
  // fetch('/change-password', { method: 'POST', body: ... });
  
  hideChangePasswordPopup();
}

document.addEventListener("DOMContentLoaded", () => {
  const confirmBtn = document.getElementById("confirmChange");
  const cancelBtn = document.getElementById("cancelChange");

  if (confirmBtn) {
    confirmBtn.addEventListener("click", confirmPasswordChange);
  }

  if (cancelBtn) {
    cancelBtn.addEventListener("click", hideChangePasswordPopup);
  }
});