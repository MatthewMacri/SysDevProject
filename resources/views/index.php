<!-- Admin List Title -->
<h2>Admin List</h2>

<!-- Link to create a new admin -->
<a href="/SysDevProject/admin/create/">Add Admin</a>

<!-- Display list of all admins -->
<ul>
    <?php foreach ($admins as $admin): ?>
        <!-- Display each admin's username and email -->
        <li><?= htmlspecialchars($admin['admin_name']) ?> (<?= htmlspecialchars($admin['email']) ?>)</li>
    <?php endforeach; ?>
</ul>