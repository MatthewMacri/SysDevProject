<!DOCTYPE html>
<html>
<head><title>Create Admin</title></head>
<body>
<h2>Create New Admin</h2>
<form method="post" action="?controller=admin&action=store">
    <input type="text" name="admin_name" placeholder="Admin Username" required><br>
    <input type="text" name="first_name" placeholder="First Name" required><br>
    <input type="text" name="last_name" placeholder="Last Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Create Admin</button>
</form>
</body>
</html>