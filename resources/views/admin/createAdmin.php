<h2>Create New Admin</h2>
<form method="post" action="?controller=admin&action=store">
    <input name="admin_name" placeholder="Username" required>
    <input name="first_name" placeholder="First Name" required>
    <input name="last_name" placeholder="Last Name" required>
    <input name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Create</button>
</form>