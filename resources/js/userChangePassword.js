// Wait until the page has fully loaded
document.addEventListener("DOMContentLoaded", () => {
  // Get the form and popup elements
  const form = document.getElementById("changePasswordForm");
  const modal = document.getElementById("changePasswordPopup");
  const cancelBtn = document.getElementById("cancelChange");
  const confirmBtn = document.getElementById("confirmChange");

  // When the user submits the form
  form.addEventListener("submit", function (e) {
    e.preventDefault(); // Stop the form from submitting right away

    // Get the new password and confirmation password values
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    // Check if both passwords match
    if (newPassword !== confirmPassword) {
      alert("New password and confirm password do not match.");
      return;
    }

    // Show the confirmation popup if passwords match
    modal.style.display = "flex";
  });

  // If user cancels, close the popup
  cancelBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // If user confirms, submit the form
  confirmBtn.addEventListener("click", () => {
    modal.style.display = "none";
    document.getElementById("changePasswordForm").submit();
  });
});