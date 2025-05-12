// Show the confirmation box with username
function showDeleteConfirmBox() {
  const usernameInput = document.getElementById("username");
  const display = document.getElementById("deleteUserID");
  const popup = document.getElementById("deleteConfirmBox");

  const username = usernameInput ? usernameInput.value.trim() || "unknown" : "unknown";

  if (display && popup) {
    display.textContent = username;

    // Defer style change to next repaint
    requestAnimationFrame(() => {
      popup.offsetHeight;
      popup.classList.add("show");
    });
  } else {
    console.warn("Delete popup or user ID display not found.");
  }
}

// Hide the confirmation popup
function hideDeleteConfirmBox() {
  const popup = document.getElementById("deleteConfirmBox");
  if (popup) popup.classList.remove("show");
}

document.addEventListener("DOMContentLoaded", () => {
  const deleteButton = document.querySelector(".deleteButton");
  const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");

  if (!deleteButton || !confirmDeleteBtn) {
    console.warn("Delete buttons not found.");
    return;
  }

  deleteButton.addEventListener("click", (e) => {
    e.preventDefault();
    showDeleteConfirmBox();
  });

  confirmDeleteBtn.addEventListener("click", () => {
    const username = document.getElementById("username")?.value.trim();
    const adminPassword = document.getElementById("admin-password")?.value.trim();

    if (!username || !adminPassword) {
      alert("Please enter both username and admin password.");
      return;
    }

    // Perform delete via fetch
    fetch("../../deleteUser.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      credentials: "include",
      body: JSON.stringify({ username, adminPassword })
    })
      .then((res) => {
        if (!res.ok) throw new Error("Server returned an error");
        return res.json();
      })
      .then((data) => {
        if (data.success) {
          alert("User deleted successfully.");
          hideDeleteConfirmBox();
        } else {
          alert("Error: " + (data.error || "Unknown error"));
        }
      })
      .catch((err) => {
        console.error("Deletion error:", err);
        alert("An error occurred while deleting the user.");
      });
  });
});



// document.getElementById("deleteConfirmBox").style.display = "flex";