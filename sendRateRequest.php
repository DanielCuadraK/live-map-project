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
    <?php
    $mailSuccess = false;

    if (isset($_POST['email'])) {

    $destinatario = "sales@worlddirectshipping.com"; 
    $asunto = "New Rate Request from " . $_POST['company-name']; 
    $cuerpo = ' 
    <html> 
    <head> 
       <title>Rate Request</title> 
    </head> 
    <body> 
    <h1>New Rate Request</h1> 
    <list>
    <ul>Name: '.$_POST['contact-name'].'</ul>
    <ul>Company Name: '.$_POST['company-name'].'</ul>
    <ul>Email: '.$_POST['email'].'</ul>
    <ul>Phone Number: '.$_POST['phone-number'].'</ul>
    <ul>Street Address: '.$_POST['street-address'].'</ul>
    <ul>City: '.$_POST['city'].'</ul>
    <ul>State: '.$_POST['state'].'</ul>
    <ul>Country: '.$_POST['country'].'</ul>
    <ul>Origin: '.$_POST['origin'].'</ul>
    <ul>Destination: '.$_POST['destination'].'</ul>
    <ul>Port of Loading: '.$_POST['port-of-loading'].'</ul>
    <ul>Port of Discharge: '.$_POST['port-of-discharge'].'</ul>
    <ul>Commodity: '.$_POST['commodity'].'</ul>
    <ul>Container Type: '.$_POST['container-type'].'</ul>
    <ul>Expected Weekly Volume: '.$_POST['expected-weekly-volume'].'</ul>
    </body> 
    </html> 
    '; 
    
    //para el envío en formato HTML 
    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
    
    //dirección del remitente 
    $headers .= "From: Web Contact Form <sales@worlddirectshipping.com>\r\n"; 
    
    //dirección de respuesta, si queremos que sea distinta que la del remitente 
    $headers .= "Reply-To: ".$_POST['email']."\r\n"; 
    
    //ruta del mensaje desde origen a destino 
    $headers .= "Return-path: sales@worlddirectshipping.com\r\n"; 
    
    //direcciones que recibián copia 
    //$headers .= "Cc: \r\n"; 
    
    //direcciones que recibirán copia oculta 
    //$headers .= "Bcc: \r\n"; 
    
    $mailSuccess = mail($destinatario,$asunto,$cuerpo,$headers);
}
    if($mailSuccess) {
        echo 'Thank you for your rate request. We will reply as soon as possible.';

    }
    else
        echo 'There was an error, please try again.';
?>
        </div>
    </div><br><br>
    <?php
    createFooter();
    ?>
    <script src="assets/libraries/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

