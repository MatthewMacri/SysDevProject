<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #ffffff;
    }

    .top-left-link {
      position: absolute;
      top: 20px;
      left: 30px;
      font-size: 14px;
      color: #F68A30;
      text-decoration: none;
      font-weight: bold;
    }

    .top-left-link:hover {
      text-decoration: underline;
    }

    .form-container {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 100px 20px 60px;
    }

    .form-box {
      background-color: #f9f9f9;
      padding: 60px;
      border-radius: 16px;
      box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 800px;
      text-align: center;
    }

    .form-box h2 {
      font-size: 26px;
      margin-bottom: 30px;
      color: #333;
    }

    label {
      display: block;
      margin-top: 20px;
      font-size: 14px;
      color: #333;
      text-align: left;
    }

    input[type="email"] {
      width: 100%;
      padding: 12px;
      margin-top: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    button {
      margin-top: 30px;
      background-color: #F68A30;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 12px 20px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }

    button:hover {
      background-color: #e66700;
    }
  </style>
</head>
<body>
  <a class="top-left-link" href="login.html">← Back to Login</a>
  <div class="form-container">
    <form class="form-box" action="../../controllers/authController.php?action=sendResetLink" method="POST">
      <h2>Reset Your Password</h2>
      <label for="email">Email Address</label>
      <input type="email" name="email" required />
      <button type="submit">Send Reset Link</button>
    </form>
  </div>
</body>
</html>