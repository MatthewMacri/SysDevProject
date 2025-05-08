document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  const twofaModal = document.getElementById("twofaModal");
  const cancel2faBtn = document.getElementById("cancel2faBtn");
  const confirm2faBtn = document.getElementById("confirm2faBtn");
  let twofaSecret = ""; // Store the secret here

  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();

    const isValidUser =
      (username === "admin" && password === "12") ||
      (username === "user" && password === "userpass");

    if (!isValidUser) {
      alert("Invalid username or password.");
    } else {
      // Show the 2FA modal
      twofaModal.style.display = "flex";

      // Fetch QR code and secret from backend
      const qrCodeContainer = document.getElementById("qrcode");
      qrCodeContainer.innerHTML = "";

      fetch("http://localhost:3000/2fa/setup")
        .then(res => res.json())
        .then(data => {
          qrCodeContainer.innerHTML = `<img src="${data.qr}" alt="Scan QR code" />`;
          twofaSecret = data.secret; // Store the secret for verification
        })
        .catch(err => {
          console.error("QR code fetch failed", err);
          qrCodeContainer.innerHTML = "<p>Failed to load QR code.</p>";
        });
    }
  });

  cancel2faBtn.addEventListener("click", () => {
    twofaModal.style.display = "none";
  });

  confirm2faBtn.addEventListener("click", () => {
    const twofaCode = document.getElementById("twofaCode").value.trim();

    fetch("http://localhost:3000/2fa/verify", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ token: twofaCode, secret: twofaSecret }),
    })
      .then(res => {
        if (res.ok) {
          document.cookie = "auth=true; path=/;";
          window.location.href = "../views/home.html";
        } else {
          alert("Invalid 2FA code.");
        }
      })
      .catch(err => {
        console.error("2FA verification failed", err);
        alert("An error occurred during verification.");
      });
  });
});