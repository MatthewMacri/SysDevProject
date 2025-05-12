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
            credentials: "include",
        })
            .then((res) => res.text()) // Get raw text response instead of auto-JSON
            .then((text) => {
                const jsonStart = text.indexOf("{"); // find start of JSON
                const cleanText = text.slice(jsonStart); // remove warnings before it

                try {
                    const data = JSON.parse(cleanText); // safely parse cleaned JSON

                    if (data.success && data.qr && data.secret) {
                        qrCodeContainer.innerHTML = `<img class="qrcode-img" src="${data.qr}" alt="QR Code" />`;
                        twofaSecret = data.secret;
                        twofaModal.style.display = "flex";
                    } else {
                        throw new Error("Invalid login response");
                    }
                } catch (err) {
                    console.error("JSON parse error:", err);
                    console.log("Raw response from server:", text);
                    alert("Unexpected response from server. Check debug logs.");
                }
            })
            .catch((err) => {
                console.error("Fetch error:", err);
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

        fetch("../../../verify.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ token: twofaCode, secret: twofaSecret }),
            credentials: "include",
        })
            .then((res) => {
                if (!res.ok) throw new Error("2FA failed");
                return res.json();
            })
            .then((data) => {
                if (data.success) {
                    // ✅ Successful login → redirect
                    window.location.href = "/SysDevProject/resources/views/home.php";
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
document.addEventListener("DOMContentLoaded", () => {
    const forgotLink = document.querySelector(".forgot-password a");
    const forgotModal = document.getElementById("forgotPasswordModal");
    const cancelBtn = document.getElementById("cancelForgotBtn");
    const confirmBtn = document.getElementById("confirmForgotBtn");
    const usernameInput = document.getElementById("forgotUsername");

    // Open modal
    forgotLink.addEventListener("click", (e) => {
        e.preventDefault();
        forgotModal.style.display = "flex";
    });

    // Close modal
    cancelBtn.addEventListener("click", () => {
        forgotModal.style.display = "none";
    });

    // Submit reset request
    confirmBtn.addEventListener("click", () => {
        const username = usernameInput.value.trim();
        if (!username) return alert("Please enter your username.");

        fetch("/SysDevProject/api/request_password_reset.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ username }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    alert("Reset request sent to admin.");
                    forgotModal.style.display = "none";
                } else {
                    alert(data.message || "Failed to send request.");
                }
            })
            .catch((err) => {
                console.error(err);
                alert("Something went wrong.");
            });
    });
});
