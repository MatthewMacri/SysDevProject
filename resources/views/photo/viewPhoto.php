<h2>All Uploaded Photos</h2>
<a href="?controller=photo&action=uploadForm">Upload New Photo</a>
<ul>
    <?php foreach ($photos as $photo): ?>
        <li>
            <strong><?= htmlspecialchars($photo['caption']) ?></strong><br>
            <img src="<?= htmlspecialchars($photo['photo_url']) ?>" width="200"><br>
            Format: <?= $photo['format'] ?> | Uploaded: <?= $photo['upload_time'] ?>
        </li>
    <?php endforeach; ?>
</ul>
