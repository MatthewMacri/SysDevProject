<h2>All Uploaded YouTube Videos</h2>
<ul id="video-list">
    <?php foreach ($videos as $index => $video): ?>
        <li>
            <!-- the videos will be put her in the player -->
            <div id="player-<?= $index ?>" data-url="<?= htmlspecialchars($video->getVideoUrl()) ?>"></div>

            Uploaded: <?= htmlspecialchars($video->getUploadTime()) ?><br>

            <a href="?controller=video&action=delete&id=<?= $video->getVideoId() ?>"
               onclick="return confirm('Delete this video?')">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>

<!-- using YouTube IFrame Player API to play videos -->
<script src="https://www.youtube.com/iframe_api"></script>

<script>
    // gets the video id which is used in the youtube player 
    function extractVideoId(url) {
        const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([a-zA-Z0-9_-]{11})/);
        // retruns olny the id of the video and not teh whole url
        return match[1];
    }

    // when the YouTube API when it's ready it dose the following
    function onYouTubeIframeAPIReady() {
        document.querySelectorAll('[id^="player-"]').forEach(el => {
            //gets the url of the video and get the video id based on it
            const videoUrl = el.getAttribute('data-url');
            const videoId = extractVideoId(videoUrl);

            // makes a new youtube player which will play teh given video
            new YT.Player(el.id, {
                width: '200',
                videoId: videoId
            });
        });
    }
</script>