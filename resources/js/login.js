document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  const twofaModal = document.getElementById("twofaModal");
  const cancel2faBtn = document.getElementById("cancel2faBtn");
  const confirm2faBtn = document.getElementById("confirm2faBtn");
  const qrCodeContainer = document.getElementById("qrcode");
  let twofaSecret = "";

  // Step 1: Handle username/password login
  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();

    fetch("/SysDevProject/login.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ username, password }),
    })
      .then((res) => {
        if (!res.ok) throw new Error("Login failed");
        return res.json();
      })
      .then((data) => {
        if (data.success && data.qr && data.secret) {
          qrCodeContainer.innerHTML = `<img src="${data.qr}" alt="QR Code" />`;
          twofaSecret = data.secret;
          twofaModal.style.display = "flex";
        } else {
          throw new Error("Invalid login response");
        }
      })
      .catch((err) => {
        console.error(err);
        alert("Invalid username or password");
      });
  });

  // Step 2: Allow canceling 2FA modal
  cancel2faBtn.addEventListener("click", () => {
    twofaModal.style.display = "none";
  });

  // Step 3: Confirm 2FA token
  confirm2faBtn.addEventListener("click", () => {
    const twofaCode = document.getElementById("twofaCode").value.trim();

    fetch("/SysDevProject/verify.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ token: twofaCode, secret: twofaSecret }),
    })
      .then((res) => {
        if (!res.ok) throw new Error("2FA failed");
        return res.json();
      })
      .then((data) => {
        if (data.success) {
          // ✅ Successful login → redirect
          window.location.href = "/resources/views/home.php";
        } else {
          throw new Error("2FA code incorrect");
        }
      })
      .catch((err) => {
        console.error(err);
        alert("Invalid 2FA code");
      });
  });
});