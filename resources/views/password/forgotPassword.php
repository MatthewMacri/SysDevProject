<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../../css/login.css">
  <link rel="stylesheet" href="../../css/forgotPassword.css">
</head>
<body>
  <a class="top-left-link" href="login.html">← Back to Login</a>
  <div class="form-container">
    <form id="reset-form" class="form-box">
  <h2>Reset Your Password</h2>
    <label for="email">Email Address</label>
      <input type="email" name="email" id="email-input" required />
    <button type="submit">Send Reset Link</button>
  </form>
<div id="feedback"></div>
  <script>
document.getElementById('reset-form').addEventListener('submit', function(e) {
  e.preventDefault(); // prevent page reload

  const email = document.getElementById('email-input').value;
  const feedback = document.getElementById('feedback');

  fetch('../../../app/Http/Controllers/core/authController.php?action=sendResetLink', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: new URLSearchParams({ email })
  })
  .then(res => res.text())
  .then(data => {
    feedback.innerHTML = data.includes('✅') ? `<p style="color: green;">${data}</p>` : `<p style="color: red;">${data}</p>`;
  })
  .catch(err => {
    feedback.innerHTML = `<p style="color: red;">Request failed.</p>`;
    console.error(err);
  });
});
</script>

</body>
</html>