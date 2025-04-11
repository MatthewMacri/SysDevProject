function showConfirmBox() {
    const username = document.getElementById("username").value || "unknown";
    document.getElementById("userID").textContent = username;
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
    activateButton.addEventListener("click", function (e) {
      e.preventDefault();
      showConfirmBox();
    }); 
  });

  document.addEventListener("DOMContentLoaded", () => {
    const deactivateButton = document.querySelector(".deactivateButton");
    deactivateButton.addEventListener("click", function (e) {
      e.preventDefault();
      showConfirmBox();
    });
  });
  