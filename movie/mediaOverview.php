<?php
$files = scandir('./media/');
?>

<!DOCTYPE>
<html lang="en">

<head>
    <link rel="stylesheet" href="video.css">
    <title>Overview</title>
</head>
<body>
<h3>Overview</h3>
<i>select title</i>
<div class="overview_body">
    <form id="overviewForm" action="videoPlayer.php" method="post">
        <input type="hidden" name="showName">
        <?php
        for($i = 0; $i < count($files); $i++) {
            if ($files[$i] === '.' || $files[$i] === '..' || $files[$i] === '.DS_Store') {
                continue;
            }
            ?>
            <a class="a_media_title" onclick="submitForm('<?php echo $files[$i]?>')">- <?php echo ucwords(str_replace('_', ' ', $files[$i])) ?></a>
            <?php
        }
        ?>
    </form>
</div>
</body>
<script>
    function submitForm(showName) {
        let form = document.getElementById("overviewForm")
        form['showName'].value = showName
        form.submit()
    }
</script>
</html>
