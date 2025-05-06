<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Suppliers</title>
  <link rel="stylesheet" href="../../../css/home.css">
  <link rel="stylesheet" href="../../../css/navbar.css">
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
</head>
<body>

<!-- Navbar -->
<div w3-include-html="../../../views/navbar.html"></div>

<section class="section">
  <h2>All Suppliers</h2>
  <a class="view-button" href="?controller=supplier&action=createForm">Create New Supplier</a>
  <ul>
    <?php foreach ($suppliers as $supplier): ?>
      <li class="project-card">
        <strong><?= htmlspecialchars($supplier['supplier_name']) ?></strong><br>
        Company: <?= htmlspecialchars($supplier['company_name']) ?><br>
        Email: <?= htmlspecialchars($supplier['supplier_email']) ?><br>
        Phone: <?= htmlspecialchars($supplier['supplier_phone_number']) ?><br>
        <a href="?controller=supplier&action=edit&id=<?= $supplier['supplier_id'] ?>">Edit</a> |
        <a href="?controller=supplier&action=delete&id=<?= $supplier['supplier_id'] ?>" onclick="return confirm('Are you sure you want to delete this supplier?')">Delete</a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>

<script>w3IncludeHTML();</script>
</body>
</html>