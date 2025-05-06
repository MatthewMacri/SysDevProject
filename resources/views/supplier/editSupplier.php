<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Supplier</title>
  <link rel="stylesheet" href="../../../css/home.css">
  <link rel="stylesheet" href="../../../css/navbar.css">
  <link rel="stylesheet" href="../../../css/form.css">
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
</head>
<body>

<!-- Navbar -->
<div w3-include-html="../../../views/navbar.html"></div>

<section class="section">
  <h2>Edit Supplier</h2>
  <form method="post" action="?controller=supplier&action=update&id=<?= $supplier['supplier_id'] ?>">
      <input type="text" name="supplier_name" value="<?= htmlspecialchars($supplier['supplier_name']) ?>" required><br>
      <input type="text" name="company_name" value="<?= htmlspecialchars($supplier['company_name']) ?>" required><br>
      <input type="email" name="supplier_email" value="<?= htmlspecialchars($supplier['supplier_email']) ?>" required><br>
      <input type="text" name="supplier_phone_number" value="<?= htmlspecialchars($supplier['supplier_phone_number']) ?>" required><br>
      <button type="submit">Update Supplier</button>
  </form>
</section>

<script>w3IncludeHTML();</script>
</body>
</html>