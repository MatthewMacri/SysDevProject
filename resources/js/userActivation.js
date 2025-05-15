console.log("userActivation.js loaded!");

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


//add event listender for activating and deactiavting users
document.addEventListener("DOMContentLoaded", () => {
    const activateButton = document.querySelector(".activateButton");
    const deactivateButton = document.querySelector(".deactivateButton");
    const activateConfirm = document.getElementById("confirmActivate");
    const deactivateConfirm = document.getElementById("confirmDeactivate");
    const cancelActivate = document.getElementById("cancelActivate");
    const cancelDeactivate = document.getElementById("cancelDeactivate");

    // Show confirmation popups
    activateButton?.addEventListener("click", (e) => {
        e.preventDefault();
        showConfirmBox();
    });

    deactivateButton?.addEventListener("click", (e) => {
        e.preventDefault();
        showDeactivateConfirmBox();
    });

    activateConfirm?.addEventListener("click", () => {
        updateUserStatus(false); 
        hideConfirmBox();
    });

    deactivateConfirm?.addEventListener("click", () => {
        updateUserStatus(true); 
        hideDeactivateConfirmBox();
    });

    cancelActivate?.addEventListener("click", hideConfirmBox);
    cancelDeactivate?.addEventListener("click", hideDeactivateConfirmBox);
});



function updateUserStatus(deactivate) {
    const username = document.getElementById("username").value.trim();
    const adminPassword = document.getElementById("admin-password").value.trim();

    if (!username || !adminPassword) {
        alert("Please enter both the username and admin password.");
        return;
    }

  fetch("/SysDevProject/resources/api/userActivation.php", {
    method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            username,adminPassword, deactivated: deactivate ? 1 : 0 
        }),
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            location.reload();
        }
    })
    .catch(() => {
        alert("Error processing the request.");
    });
}
