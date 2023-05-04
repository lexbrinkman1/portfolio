<?php
$files = scandir('./media/'.$_POST['showName']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Amin Developer!" />
<head>
    <link rel="stylesheet" href="video.css">
    <title>Video player</title>
</head>
<body>
<div>
    <a class="btn_go_back" href="mediaOverview.php">Go back</a>
</div>
<h3><?php echo ucwords(str_replace('_', ' ', $_POST['showName'])) ?></h3>
<div class="video_header">
    <select id="videoSelector">
        <option value="" selected disabled>Select episode</option>
        <?php
        for($i = 0; $i < count($files); $i++) {
            if ($files[$i] === '.' || $files[$i] === '..' || $files[$i] === '.DS_Store') {
                continue;
            }
            ?>

            <option value="./media/<?php echo $_POST['showName']?>/<?php echo$files[$i]?>">Episode <?php echo $i-2 ?></option>

            <?php
        }
        ?>
    </select>
    <div class="current_episode">
        <p>Selected episode: <p id="selectedVideo"></p></p>
    </div>
</div>

<video id="video"  type='video/mp4' controls></video>
</body>
<script>
    let episode = document.getElementById("videoSelector");
    let videoPlayer = document.getElementById('video');

    episode.addEventListener("change", function() {
        let currentEpisode = episode.value
        videoPlayer.src = currentEpisode
        let episodeName = episode.options[episode.selectedIndex].innerHTML;
        document.getElementById('selectedVideo').innerText = episodeName
    });

</script>

</html>
