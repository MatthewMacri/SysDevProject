<h2>Upload Photo</h2>
<form method="post" action="?controller=photo&action=upload">
    <input type="text" name="project_id" placeholder="Project ID" required><br>
    <input type="text" name="photo_url" placeholder="Photo URL" required><br>
    <input type="text" name="format" placeholder="Format (jpg/png)" required><br>
    <input type="text" name="caption" placeholder="Caption"><br>
    <button type="submit">Upload</button>
</form>
