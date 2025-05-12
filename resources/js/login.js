// LOGIN & 2FA VERIFICATION
document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  const twofaModal = document.getElementById("twofaModal");
  const cancel2faBtn = document.getElementById("cancel2faBtn");
  const confirm2faBtn = document.getElementById("confirm2faBtn");
  const qrCodeContainer = document.getElementById("qrcode");
  let twofaSecret = ""; // Will hold secret from backend

  // 🔹 Step 1: Handle username/password login
  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();

    fetch("/SysDevProject/login.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      credentials: "include",
      body: JSON.stringify({ username, password }),
    })
      .then(res => res.text()) // Capture raw response (includes possible warnings)
      .then(text => {
        const jsonStart = text.indexOf("{");
        const cleanText = text.slice(jsonStart); // Strip out anything before JSON

        try {
          const data = JSON.parse(cleanText);

          // If 2FA is required
          if (data.success && data.qr && data.secret) {
            qrCodeContainer.innerHTML = `<img class="qrcode-img" src="${data.qr}" alt="QR Code" />`;
            twofaSecret = data.secret;
            twofaModal.style.display = "flex";
          } else {
            throw new Error("Invalid login response");
          }
        } catch (err) {
          console.error("JSON parse error:", err);
          console.log("Raw response:", text);
          alert("Unexpected response from server.");
        }
      })
      .catch(err => {
        console.error("Login fetch error:", err);
        alert("Invalid username or password.");
      });
  });

  // 🔹 Step 2: Allow canceling 2FA modal
  cancel2faBtn.addEventListener("click", () => {
    twofaModal.style.display = "none";
  });

  // 🔹 Step 3: Submit and verify 2FA code
  confirm2faBtn.addEventListener("click", () => {
    const twofaCode = document.getElementById("twofaCode").value.trim();

    fetch("../../../verify.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      credentials: "include",
      body: JSON.stringify({ token: twofaCode, secret: twofaSecret }),
    })
      .then(res => {
        if (!res.ok) throw new Error("2FA verification failed");
        return res.json();
      })
      .then(data => {
        if (data.success) {
          window.location.href = "/SysDevProject/resources/views/home.php"; // ✅ Redirect to homepage
        } else {
          throw new Error("Invalid 2FA code");
        }
      })
      .catch(err => {
        console.error("2FA error:", err);
        alert("Invalid 2FA code.");
      });
  });
});


// FORGOT PASSWORD HANDLER
document.addEventListener("DOMContentLoaded", () => {
  const forgotLink = document.querySelector(".forgot-password a");
  const forgotModal = document.getElementById("forgotPasswordModal");
  const cancelBtn = document.getElementById("cancelForgotBtn");
  const confirmBtn = document.getElementById("confirmForgotBtn");
  const usernameInput = document.getElementById("forgotUsername");

  // 🔹 Open the "Forgot Password" modal
  forgotLink.addEventListener("click", (e) => {
    e.preventDefault();
    forgotModal.style.display = "flex";
  });

  // 🔹 Close modal without submitting
  cancelBtn.addEventListener("click", () => {
    forgotModal.style.display = "none";
  });

  // 🔹 Confirm password reset request
  confirmBtn.addEventListener("click", () => {
    const username = usernameInput.value.trim();
    if (!username) return alert("Please enter your username.");

    fetch("/SysDevProject/api/request_password_reset.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ username }),
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert("Reset request sent to admin.");
          forgotModal.style.display = "none";
        } else {
          alert(data.message || "Failed to send reset request.");
        }
      })
      .catch(err => {
        console.error("Forgot password error:", err);
        alert("Something went wrong. Try again.");
      });
  });
});