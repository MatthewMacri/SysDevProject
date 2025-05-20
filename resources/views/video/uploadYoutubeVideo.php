<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role'])) {
    header("Location: ../login/loginview.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo _('Upload YouTube Video'); ?></title>
    <link rel="stylesheet" href="../../css/form.css">
    <script src="https://www.youtube.com/iframe_api"></script>
</head>

<body>

<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/SysDevProject/config/config.php';
use App\Http\Controllers\core\DatabaseController;
use App\Http\Controllers\mediaControllers\VideoController;

require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 3) . '/bootstrap/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once app_path('Http/Controllers/core/databaseController.php');
    require_once app_path('Http/Controllers/mediaControllers/videocontroller.php');
    $db = DatabaseController::getInstance();
    $videoController = new VideoController($db);

    if (empty($_POST['duration']) || !is_numeric($_POST['duration'])) {
        exit;
    }

    $_POST['duration'] = (int) $_POST['duration'];
    $videoController->upload($_POST);
}
?>

<section class="section">
    <h2><?php echo _('Upload YouTube Video'); ?></h2>
    <form id="uploadForm" method="post" action="">
        <input type="text" name="project_id" placeholder="Project ID" required><br><br>
        <input type="text" id="video_url" name="video_url" placeholder="YouTube Video URL" required><br>
        <input type="hidden" name="format" value="youtube">
        <input type="hidden" id="duration" name="duration">
        <br>
        <button type="button" onclick="startProcess()"><?php echo _('Upload'); ?></button>
    </form>

    <!-- Hidden YouTube Player -->
    <div id="player" style="display:none;"></div>
</section>

<script>
let player;

// this extracts YouTube video ID from a URL
function extractVideoId(url) {
    // using regrex to get the video id 
    const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([a-zA-Z0-9_-]{11})/);
    return match ? match[1] : null; 
}


// required function for the youtube ifram to work properly 
function onYouTubeIframeAPIReady() {
}

//this load the youtube player to get duration
function loadYouTubePlayer(videoId) {
    if (player && player.destroy) {
        player.destroy();
    }

    player = new YT.Player('player', {
        height: '0',
        width: '0',
        videoId: videoId,
        events: {
            'onReady': onPlayerReady
        }
    });
}

function onPlayerReady(event) {

    const duration = player.getDuration();
    if (duration > 0) {
        document.getElementById("duration").value = duration;
        document.getElementById("uploadForm").submit();
    } else {
        // if duration is nto gotten yet wait some more time
        setTimeout(onPlayerReady, 500);
    }
}

//this is the fucntion which calls two other funtions to extarct teh youtube id and load the duration
function startProcess() {
    const videoUrl = document.getElementById("video_url").value.trim();
    const videoId = extractVideoId(videoUrl);

    if (!videoId) {
        alert("Invalid YouTube URL.");
        return;
    }

    loadYouTubePlayer(videoId);
}
</script>

</body>
</html>
