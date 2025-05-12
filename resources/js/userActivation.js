// Show the activate confirmation popup
function showConfirmBox() {
  const username = document.getElementById("username").value || "unknown";
  document.getElementById("activateUserID").textContent = username;
  document.getElementById("confirmBox").style.display = "flex";
}

// Hide the activate confirmation popup
function hideConfirmBox() {
  document.getElementById("confirmBox").style.display = "none";
}

// Show the deactivate confirmation popup
function showDeactivateConfirmBox() {
  const username = document.getElementById("username").value || "unknown";
  document.getElementById("deactivateUserID").textContent = username;
  document.getElementById("deactivateConfirmBox").style.display = "flex";
}

// Hide the deactivate confirmation popup
function hideDeactivateConfirmBox() {
  document.getElementById("deactivateConfirmBox").style.display = "none";
}

// Wait until the page is fully loaded
document.addEventListener("DOMContentLoaded", () => {
  // Get the activate and deactivate buttons
  const activateButton = document.querySelector(".activateButton");
  const deactivateButton = document.querySelector(".deactivateButton");

  // When the activate button is clicked, show the confirmation box
  activateButton.addEventListener("click", (e) => {
    e.preventDefault();
    showConfirmBox();
  });

  // When the deactivate button is clicked, show the confirmation box
  deactivateButton.addEventListener("click", (e) => {
    e.preventDefault();
    showDeactivateConfirmBox();
  });
});