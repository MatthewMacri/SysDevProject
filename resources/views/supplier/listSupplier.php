<h2>All Suppliers</h2>
<a href="?controller=supplier&action=createForm">Create New Supplier</a>
<ul>
    <?php foreach ($suppliers as $supplier): ?>
        <li>
            <strong><?= htmlspecialchars($supplier['supplier_name']) ?></strong><br>
            Company: <?= htmlspecialchars($supplier['company_name']) ?><br>
            Email: <?= htmlspecialchars($supplier['supplier_email']) ?><br>
            Phone: <?= htmlspecialchars($supplier['supplier_phone_number']) ?>
        </li>
    <?php endforeach; ?>
</ul>