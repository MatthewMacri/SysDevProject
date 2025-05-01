<h2>Upload Video</h2>
<form method="post" action="?controller=video&action=upload">
    <input type="text" name="project_id" placeholder="Project ID" required><br>
    <input type="text" id="video_url" name="video_url" placeholder="Video URL" required><br>
    <input type="text" name="format" placeholder="Format (mp4)" required><br>

    <!-- gets the durration of video and hides it -->
    <input type="hidden" id="duration" name="duration">

    <button type="submit">Upload</button>
</form>

<script>

    //gets the video url and 
document.getElementById('video_url').addEventListener('blur', function () {

    //creates a video tag which will be used to extract the duration
    // and it olny extracts the metadata about the video
    const tempVideo = document.createElement('video');
    tempVideo.preload = 'metadata';

    // set the source of the vide
    tempVideo.src = this.value;

    //when the metadata is loaded you set the duration value to the duration of the video
    tempVideo.onloadedmetadata = () => {
        document.getElementById('duration').value = tempVideo.duration;
    };
});
</script>