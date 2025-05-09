<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Photo</title>
  <link rel="stylesheet" href="../../css/home.css">
  <link rel="stylesheet" href="../../css/navbar.css">
  <link rel="stylesheet" href="../../css/form.css">
  <script src="https://www.w3schools.com/lib/w3data.js"></script>
</head>
<body>

<!-- Navbar -->
<div w3-include-html="../..//components/navbar.php"></div>

<section class="section">
  <h2>Upload Photo</h2>
  <form method="post" action="?controller=photo&action=upload">
      <input type="text" name="project_id" placeholder="Project ID" required><br>
      <input type="text" name="photo_url" placeholder="Photo URL" required><br>
      <input type="text" name="format" placeholder="Format (jpg/png)" required><br>
      <input type="text" name="caption" placeholder="Caption"><br>
      <button type="submit">Upload</button>
  </form>
</section>

<script>w3IncludeHTML();</script>
</body>
</html>