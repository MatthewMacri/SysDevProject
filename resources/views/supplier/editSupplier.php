<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo _('Edit Supplier'); ?></title>

  <!-- Include basic styles for layout and form -->
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/form.css">
</head>

<body>

  <!-- Load the shared navbar -->
  <?php
  require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
  $app = require_once dirname(__DIR__,3) . '/bootstrap/app.php';

  require resource_path('components/navbar.php');
  ?>

  <!-- Main section for editing supplier -->
  <section class="section">
    <h2><?php echo _('Edit Supplier'); ?></h2>

    <!-- Form is pre-filled with the supplier's current information -->
    <form method="post" action=" /SysDevProject/supplier/update/<?= htmlspecialchars($supplier['supplier_id']) ?>">

      <!-- Supplier Name input -->
      <input type="text" name="supplier_name" value="<?= htmlspecialchars($supplier['supplier_name']) ?>" required><br>

      <!-- Company Name input -->
      <input type="text" name="company_name" value="<?= htmlspecialchars($supplier['company_name']) ?>" required><br>

      <!-- Email input -->
      <input type="email" name="supplier_email" value="<?= htmlspecialchars($supplier['supplier_email']) ?>" required><br>

      <!-- Phone Number input -->
      <input type="text" name="supplier_phone_number" value="<?= htmlspecialchars($supplier['supplier_phone_number']) ?>" required><br>

      <!-- Button to update supplier info -->
      <button type="submit"><?php echo _('Update Supplier'); ?></button>
    </form>
  </section>

</body>
</html>