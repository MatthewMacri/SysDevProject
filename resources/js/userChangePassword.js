document.getElementById("changePasswordForm").addEventListener("submit", function (e) {
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
  
    if (newPassword !== confirmPassword) {
      alert("New password and confirm password do not match.");
      e.preventDefault();
    }
  });