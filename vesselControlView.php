<!--ADD PASSWORD VALIDATION-->

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
    <link rel="stylesheet" href="assets/libraries/spectrum/spectrum.css">
</head>

<body>
    <!-- Modal -->
<div id="vesselDetails" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <form action="/action_page.php">
               <div class="form-group">
                  <label>Id:</label>
                  <input type="text" class="form-control" id="vessel-id" readonly>
               </div>
               <div class="form-group">
                  <label>Name:</label>
                  <input type="text" class="form-control" id="vessel-name">
               </div>
               <div class="form-group">
                  <label>IMO:</label>
                  <input type="text" class="form-control" id="vessel-imo">
               </div>
               <div class="form-group">
                  <label>MMSI:</label>
                  <input type="text" class="form-control" id="vessel-mmsi">
               </div>
               <div class="form-group">
                  <label>Media Folder:</label>
                  <input type="text" class="form-control" id="vessel-media-folder">
               </div>
               <div class="form-group">
                  <label>Route Color:</label>
                  <input type="text" class="form-control" id="vessel-color">
                  <input type="color" id="html5colorpicker" onchange="clickColor(0, -1, -1, 5)" value="#ff0000" style="width:85%;">
               </div>
               <div class="checkbox">
                  <label><input type="checkbox" id="vessel-status"> Active</label>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button class="btn btn-primary" id="btn-update-vessel" onclick="updateVessel('updateVessel')">Update</button>
            <button class="btn btn-primary" id="btn-create-vessel" onclick="updateVessel('createVessel')">Create</button>
            <button class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

    <!-- Modal HELP -->
    <div id="helpModal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
         <ol>
            <li>To add a new vessel please click "Add New Vessel" button and complete all fields</li>
            <li>To edit a vessel's information please click Edit button on the table and complete all fields</li>
            <li>When changes are made, Update Web Service button should be pressed to send all information to OrbComm Server</li>
            </ol>
            <span>Field explanation:</span>
            <ul>
            <li>ID: Internal identificator of the vessel inside database, it's filled automatically</li>
            <li>Name: Name of the vessel</li>
            <li>IMO: The International Maritime Organization (IMO) number is a unique identifier for the vessel.</li>
            <li>MMSI:A Maritime Mobile Service Identity (MMSI) is a series of nine digits which are sent in digital form over a radio frequency channel in order to uniquely identify ship stations, ship earth stations, coast stations, coast earth stations, and group calls</li>
            <li>Media Folder: local folder where all images/videos from the Vessel are stored</li>
            <li>Route Color: Color to be used when drawing the vessel's route on the map</li>
            <li>Active: sets whether the vessel has to be considered for data retreiving from orbcomm and drawing it on the map</li>
            </ul>
         </div>
         <div class="modal-footer">

            <button class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>


    <div class="container">
            <div class="row justify-content-center">
                <div class="col-auto text-center">
                    <h2>Vessel Control</h2>
                    <div id="vessel-table" class="table table-responsive"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: center;">
                    <button class="btn btn-primary" id="btn-new-vessel" onclick="newVessel()">Add New Vessel</button>
                    <button class="btn btn-success" id="btn-new-vessel" onclick="updateWebService()">Update Web Service</button>
                    <button class="btn btn-warning" onclick="$('#helpModal').modal()">Help</button>
                </div>
            </div>
    </div>
    <script src="assets/libraries/jquery/jquery.min.js"></script>
    <script src="assets/libraries/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/libraries/spectrum/spectrum.js"></script>
    <script src="assets/js/vesselControl.js"></script>
</body>
</html>