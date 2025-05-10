function showDeleteConfirmBox() {
  const username = document.getElementById("username").value || "unknown";
  document.getElementById("deleteUserID").textContent = username;
  document.getElementById("deleteConfirmBox").style.display = "flex";
}

function hideDeleteConfirmBox() {
  document.getElementById("deleteConfirmBox").style.display = "none";
}

document.addEventListener("DOMContentLoaded", () => {
  const deleteButton = document.querySelector(".deleteButton");
  const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");

  deleteButton.addEventListener("click", (e) => {
    e.preventDefault();
    showDeleteConfirmBox();
  });

  confirmDeleteBtn.addEventListener("click", () => {
    const username = document.getElementById("username").value.trim();
    const adminPassword = document.getElementById("admin-password").value.trim();

    if (!username || !adminPassword) {
      alert("Please enter both username and admin password.");
      return;
    }

    fetch("../../deleteUser.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ username, adminPassword }),
      credentials: "include"
    })
      .then((res) => {
        if (!res.ok) throw new Error("Deletion failed");
        return res.json();
      })
      .then((data) => {
        if (data.success) {
          alert("User deleted successfully.");
          hideDeleteConfirmBox();
        } else {
          alert("Error: " + data.error);
        }
      })
      .catch((err) => {
        console.error(err);
        alert("An error occurred while deleting the user.");
      });
  });
});
