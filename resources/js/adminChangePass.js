function showChangePasswordPopup() {
    const username = document.getElementById("username").value || "unknown";
    document.getElementById("changeUserID").textContent = username;
    document.getElementById("changePasswordPopup").style.display = "flex";
  }
  
  function hideChangePasswordPopup() {
    document.getElementById("changePasswordPopup").style.display = "none";
  }
  
  document.addEventListener("DOMContentLoaded", () => {
    const changePasswordButton = document.querySelector(".changePasswordButton");
    changePasswordButton.addEventListener("click", (e) => {
      e.preventDefault();
      showChangePasswordPopup();
    });
  });
  