function showConfirmBox() {
  const username = document.getElementById("username").value || "unknown";
  document.getElementById("activateUserID").textContent = username;
  document.getElementById("confirmBox").style.display = "flex";
}

function hideConfirmBox() {
  document.getElementById("confirmBox").style.display = "none";
}

function showDeactivateConfirmBox() {
  const username = document.getElementById("username").value || "unknown";
  document.getElementById("deactivateUserID").textContent = username;
  document.getElementById("deactivateConfirmBox").style.display = "flex";
}

function hideDeactivateConfirmBox() {
  document.getElementById("deactivateConfirmBox").style.display = "none";
}

document.addEventListener("DOMContentLoaded", () => {
  const activateButton = document.querySelector(".activateButton");
  const deactivateButton = document.querySelector(".deactivateButton");

  activateButton.addEventListener("click", (e) => {
    e.preventDefault();
    showConfirmBox();
  });

  deactivateButton.addEventListener("click", (e) => {
    e.preventDefault();
    showDeactivateConfirmBox();
  });
});
