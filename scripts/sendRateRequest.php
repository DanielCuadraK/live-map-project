<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>WORLD DIRECT SHIPPING</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="assets/css/Header-Blue.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="css/style.css" />
    <!--<link rel="stylesheet" href="css/styles.css" />-->
    <link href='https://fonts.googleapis.com/css?family=Mukta' rel='stylesheet'>
</head>

<body>
<?php
$to      = 'daniel.cuadra@gmail.com';
$subject = 'Rate Request '.$_POST['company-name'];
$message = '
RATE REQUEST FORM

Contact Name: '.$_POST['contact-name'].\n.
'Company Name: '.$_POST['company-name'].\n.
'Email: '.$_POST['email'].'\n'.
'Phone Number: '.$_POST['phone-number'].\n.
'Street Address: '.$_POST['street-address'].\n.
'City: '.$_POST['city'].\n.
'State: '.$_POST['state'].\n.
'Zip Code: '.$_POST['zip-code'].\n.
'Country: '.$_POST['country'].\n.
'Origin: '.$_POST['origin'].\n.
'Destination: '.$_POST['destination'].\n.
'Port of Loading: '.$_POST['port-of-loading'].\n.
'Port of Discharge: '.$_POST['port-of-discharge'].\n.
'Commodity: '.$_POST['commodity'].\n.
'Container Type: '.$_POST['container-type'].\n.
'Expected Weekly Volume: '.$_POST['expected-weekly-volume'];






$emailfrom = $_POST['email'];
$fromname = 'Rate Request Webform';

$replyto = $_POST['email'];
$headers = 
	'Return-Path: ' . $emailfrom . "\r\n" . 
	'From: ' . $fromname . ' <' . $emailfrom . '>' . "\r\n" . 
	'X-Priority: 3' . "\r\n" . 
	'X-Mailer: PHP ' . phpversion() .  "\r\n" . 
	'Reply-To: ' . $fromname . ' <' . $replyto . '>' . "\r\n" .
	'MIME-Version: 1.0' . "\r\n" . 
	'Content-Transfer-Encoding: 8bit' . "\r\n" . 
	'Content-Type: text/plain; charset=UTF-8' . "\r\n".
	'Bcc: info@elterreno.com.mx' . "\r\n" ;
$params = '-f ' . $emailfrom;
//$test = mail($emailto, $subject, $messagebody, $headers, $params);
    //
    
    

mail($to, $subject, $message, $headers,"-f daniel.cuadra@gmail.com" );

?>

    <?php
        require_once 'templates.php';
        createHeader();
    ?>
    <div class="container">
    <div class="text-center">
    <h1>REQUEST RATE</h1>
    </div>
    Thank you, we will reply to your request shortly.
    </div>
    <?php
        createFooter();
    ?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
    <script src="assets/js/Simple-Slider.js"></script>
</body>

</html>

