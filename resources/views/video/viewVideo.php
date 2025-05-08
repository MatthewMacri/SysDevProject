<h2>All Uploaded Videos</h2>
<a href="?controller=video&action=uploadForm">Upload New Video</a>
<ul>
    <?php foreach ($videos as $video): ?>
        <li>
            <video height="200" controls>
                <source src="<?= htmlspecialchars($video->getVideoUrl()) ?>" type="video/<?= htmlspecialchars($video->getFormat()) ?>">
                Your browser does not support the video tag.
            </video>
            <br>
            Duration: <?= $video->getDuration() ?> seconds | Uploaded: <?= $video->getUploadTime()?>
            <a href="?controller=video&action=delete&id=<?= $video->getVideoId() ?>" onclick="return confirm('Delete this video?')">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>