<?php
$files = scandir('./shows/normal_people/');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="Amin Developer!" />

    <title>Untitled 1</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        select {
            width: 150px;
            margin-bottom: 10px;
            border-radius: 0px;
        }

        video {
            width: 65%;
        }

        .video_header {
            width: 65%;
            display: flex;
            flex-direction: row-reverse;
            justify-content: space-between;
        }

        .current_episode {
            display: flex;
            flex-direction: row;
        }

        #selectedVideo {
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <h3>Normal people</h3>
    <div class="video_header">
        <select id="videoSelector">
            <option value="" selected disabled>Select episode</option>
        <?php
            for($i = 0; $i < count($files); $i++) {
                if ($files[$i] === '.' || $files[$i] === '..' || $files[$i] === '.DS_Store') {
                    continue;
                }
        ?>

                <option value="./shows/normal_people/<?php echo$files[$i]?>">Episode <?php echo $i-2 ?></option>

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
