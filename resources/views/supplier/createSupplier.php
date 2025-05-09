<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create New Supplier</title>
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/form.css">
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
</head>
<body>

<!-- Navbar -->
<div w3-include-html="../../components/navbar.php"></div>

<section class="section">
  <h2>Create New Supplier</h2>
  <form method="post" action="?controller=supplier&action=store">
      <input type="text" name="supplier_name" placeholder="Supplier Name" required><br>
      <input type="text" name="company_name" placeholder="Company Name" required><br>
      <input type="email" name="supplier_email" placeholder="Email" required><br>
      <input type="text" name="supplier_phone_number" placeholder="Phone Number" required><br>
      <button type="submit">Add Supplier</button>
  </form>
</section>

<script>w3IncludeHTML();</script>
</body>
</html>