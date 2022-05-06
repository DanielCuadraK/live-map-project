<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>WORLD DIRECT SHIPPING</title>
    <link rel="stylesheet" href="assets/libraries/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link href='https://fonts.googleapis.com/css?family=Mukta' rel='stylesheet'>
    <link rel="stylesheet" href="assets/libraries/leaflet/leaflet.css" />
    <link rel="stylesheet" href="assets/css/page-style.css" />
    <script src="assets/libraries/leaflet/leaflet.js"></script>
    <script src="assets/libraries/leaflet/leaflet.rotatedMarker.js"></script>
    <script src="assets/libraries/jquery/jquery.min.js"></script>
</head>

<body style="position:relative;">
    <?php
        require_once 'templates.php';
        createHeader();
    ?>
    <div id="mymodal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
              <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Confirm</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

    <div class="container-fluid" id="map-container">
        <div class="leaflet-bottom leaflet-right">
        <img src="assets/icons/legend-01.png">        
        </div>
    </div>
    <div class="container-fluid" style="padding-top:20px;padding-bottom:20px;">
    <h3 class="text-center"> SAILING SCHEDULE </h3>
    <div class="text-center"><img class="img-fluid" src="resources/SailingSchedule.png"/></div>
    <div class="text-center" style="padding-top:20px;"><a href="resources/SailingSchedule.png" target="_blank" class="btn btn-primary">Download Schedule</a></div>
</div>
    <?php
        createFooter();
    ?>
    <script src="assets/libraries/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/map-control.js"></script>
</body>

</html>