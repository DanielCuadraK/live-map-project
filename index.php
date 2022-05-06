<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>WORLD DIRECT SHIPPING</title>
    <link rel="stylesheet" href="assets/libraries/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link href='https://fonts.googleapis.com/css?family=Mukta' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/page-style.css" />
</head>

<body>
    <?php
        require_once 'templates.php';
        createHeader();
    ?>

    <div class="row">

	    <div class="col-sm-12">
	        <video id="bannerVideo" autoplay loop muted playsinline>
            	<source src="assets/video/video-banner-2.mp4" type="video/mp4">
        	</video>            
	    </div>

 	</div>
        <div class="row">
            <div class="col-sm-12 text-center" style="padding-top: 10px; padding-bottom: 10px;">
                <img class="img-fluid" src="assets/img/servicemap-wide.png"> 
            </div>
        </div>
    <?php
        createFooter();
    ?>
    <script src="assets/libraries/jquery/jquery.min.js"></script>
    <script src="assets/libraries/bootstrap/js/bootstrap.min.js"></script>
    <script>
Object.defineProperty(HTMLMediaElement.prototype, 'playing', {
    get: function () {
        return !!(this.currentTime > 0 && !this.paused && !this.ended && this.readyState > 2);
    }
});

jQuery('body').on('click touchstart', function () {
            const videoElement = document.getElementById('bannerVideo');
            if (videoElement.playing) {
            }
            else {
                videoElement.play();
            }
    });

</script>
</body>

</html>