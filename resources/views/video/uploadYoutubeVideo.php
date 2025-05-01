<h2>Upload YouTube Video</h2>
<form method="post" action="?controller=video&action=upload">
    <input type="text" name="project_id" placeholder="Project ID" required><br>
    <input type="text" id="video_url" name="video_url" placeholder="YouTube Video URL" required><br>
    <input type="text" name="format" value="youtube" readonly><br>

    <!-- Automatically filled with video duration in seconds -->
    <input type="hidden" id="duration" name="duration">

    <button type="submit">Upload</button>
</form>

<!-- Hidden YouTube player -->
<div id="player" style="width:0; height:0;"></div>

<!-- the  YouTube IFrame Player API which is used to get duration-->
<script src="https://www.youtube.com/iframe_api"></script>

<script>
    let player;

    // Triggered when YouTube IFrame API is ready
    function onYouTubeIframeAPIReady() {

        //get the youtibe video url
        const urlInput = document.getElementById('video_url');

        //when the user entered the url fully 
        urlInput.addEventListener('blur', function () {
            const url = this.value.trim();
            const videoId = extractVideoId(url);


            // Remove the old player
            if (player) player.destroy();

            // Create new hidden player to load metadata
            player = new YT.Player('player', {
                height: '0',
                width: '0',
                videoId: videoId,
                events: {
                    'onReady': (event) => {
                        //this gets the duration of the youtube video and sets it to duration
                        const duration = event.target.getDuration();
                        document.getElementById('duration').value = duration;
                    }
                }
            });
        });
    }

    // gets the video id which is used in the youtube player 
    function extractVideoId(url) {
        const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([a-zA-Z0-9_-]{11})/);
        // retruns olny the id of the video and not teh whole url
        return match[1];
    }
</script>