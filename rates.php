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
    <script src="assets/libraries/jquery/jquery.min.js"></script>
</head>

<body>
    <?php
        require_once 'templates.php';
        createHeader();
    ?>
    <div class="container">
    <div class="text-center">
    <h1>REQUEST RATE</h1>
    </div>
    <form action="scripts/sendRateRequest.php" method="post" id="rateRequestForm">
    <div class="row form-group">
        <div class="col">
        <input type="text" class="form-control required" placeholder="Contact Name *" name='contact-name'>
        </div>
        <div class="col">
        <input type="text" class="form-control required" placeholder="Company Name *" name='company-name'>
        </div>
    </div>
    <div class="row form-group">
        <div class="col">
        <input type="text" class="form-control required" placeholder="Email *" name='email'>
        </div>
        <div class="col">
        <input type="text" class="form-control" placeholder="Phone Number" name='phone-number'>
        </div>
    </div>
    <div class="row form-group">
        <div class="col">
        <input type="text" class="form-control" placeholder="Street Address" name='street-address'>
        </div>
        <div class="col">
        <input type="text" class="form-control required" placeholder="City *" name='city'>
        </div>
    </div>
    <div class="row form-group">
        <div class="col">
        <input type="text" class="form-control required" placeholder="State *" name='state'>
        </div>
        <div class="col">
        <input type="text" class="form-control" placeholder="Zip Code" name='zip-code'>
        </div>
        <div class="col">
        <input type="text" class="form-control required" placeholder="Country *" name='country'>
        </div>
    </div>
    <div class="row form-group">
        <div class="col">
        <input type="text" class="form-control required" placeholder="Origin *" name='origin'>
        </div>
        <div class="col">
        <input type="text" class="form-control required" placeholder="Destination *" name='destination'>
        </div>
    </div>
    <div class="row form-group">
        <div class="col">
        <select class="form-control" placeholder="Port of Loading" id ='port-of-loading' name='port-of-loading'>
        <option selected disabled>Port of Loading</option>
        <option>COATZACOALCOS</option>
        <option>PORT MANATEE</option>
        <option>TAMPICO</option>
        <option>TUXPAN</option>
        </select>
        </div>
        <div class="col">
        <select class="form-control" placeholder="Port of Discharge" id='port-of-discharge' name='port-of-discharge'>
        <option selected disabled>Port of Discharge</option>
        <option>COATZACOALCOS</option>
        <option>PORT MANATEE</option>
        <option>TAMPICO</option>
        <option>TUXPAN</option>
        </select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col">
        <input type="text" class="form-control required" placeholder="Commodity *" name='commodity'>
        </div>
        <div class="col">
        <select class="form-control required" id='container-type' name ='container-type'>
        <option selected disabled>Container Type *</option>
        <option>40' Dry High Cube Container</option>
        <option>53' Dry High Cube Container</option>
        <option>40' Refrigerated High Cube Container</option>
        <option>40' Flat Rack</option>
        </select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col">
        <input type="text" class="form-control" placeholder="Expected Weekly Volume" name='expected-weekly-volume'>
        </div>
    </div>
            * Required Fields
    <div class="form-group text-center">
    <button type="button" onclick="validateFields1()" class="btn-lg btn-primary">Send</button>
    </div>
    </form>
    </div>
    <?php
        createFooter();
    ?>
    <script src="assets/libraries/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/rates-form.js"></script>
</body>

</html>