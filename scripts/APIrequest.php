<?php
require_once ("connection.php");

/*Function that clear all the vessels contained in the list using the API*/

function clearVesselList()
{

    $url = 'https://globalais2.orbcomm.net/api/v2/vessellist/clear';
    $ch = curl_init($url);
    $data['api_key'] = "5328E1A9-DD14-4AD6-91D4-578C2109882C";
    $data['listName'] = "default";
    //$data['lookBack'] = "45";
    $payload = json_encode($data);

    // Attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    // Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'Content-Type:application/json'
    ));

    // Return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //curl_setopt($ch, CURLOPT_PORT, 9053);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

    curl_setopt($ch, CURLOPT_SSLVERSION, 6); //Force requsts to use TLS 1.2
    // Execute the POST request
    $result = curl_exec($ch);

    if (curl_errno($ch))
    {
        $error_msg = curl_error($ch);
        echo $error_msg;
    }

    $resultados = json_decode($result, true);

    // Close cURL resource
    curl_close($ch);

    return $resultados;

}

/*Function to call API that add a list of vessels to the list
    Arguments: 
    mmsi_list: contains an array of mmsi (Maritime Mobile Service Identifier) for the vessels to be added
*/

function addVessels($mmsi_list)
{
    // API URL
    $url = 'https://globalais2.orbcomm.net/api/v2/vessellist/add';

    // Create a new cURL resource
    $ch = curl_init($url);

    $data['api_key'] = "5328E1A9-DD14-4AD6-91D4-578C2109882C";
    $data['listName'] = "default";
    $data['mmsi_list'] = $mmsi_list;
    $data['imo_list'] = "";
    $payload = json_encode($data);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

    // Attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    // Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'Content-Type:application/json'
    ));

    // Return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //curl_setopt($ch, CURLOPT_PORT, 9053);
    //
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

    curl_setopt($ch, CURLOPT_SSLVERSION, 6); //Force requsts to use TLS 1.2
    // Execute the POST request
    $result = curl_exec($ch);

    if (curl_errno($ch))
    {
        $error_msg = curl_error($ch);
        echo $error_msg;
    }

    $resultados = json_decode($result, true);

    // Close cURL resource
    curl_close($ch);

    echo $resultados['nbrVessels'];

}
/* Function to get all vessels from the list using the vendor API */

function getVesselList()
{
    // API URL
    $url = 'https://globalais2.orbcomm.net/api/v2/vessellist/getVessels';

    // Create a new cURL resource
    $ch = curl_init($url);

    $data['api_key'] = "5328E1A9-DD14-4AD6-91D4-578C2109882C";
    $data['listName'] = "default";
    //$data['lookBack'] = "45";
    $payload = json_encode($data);

    // Attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    // Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'Content-Type:application/json'
    ));

    // Return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //curl_setopt($ch, CURLOPT_PORT, 9053);
    //
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

    curl_setopt($ch, CURLOPT_SSLVERSION, 6); //Force requsts to use TLS 1.2
    // Execute the POST request
    $result = curl_exec($ch);

    if (curl_errno($ch))
    {
        $error_msg = curl_error($ch);
        echo $error_msg;
    }

    $resultados = json_decode($result, true);

    // Close cURL resource
    curl_close($ch);

    //
    $vessels;
    foreach ($resultados as $item)
    {
        $vessels .= ", " . $item['static']['name'];
    }
    echo $vessels;

}

/* Function to get all vessels from the list using the vendor API returning an array*/
function connectToService()
{
    // API URL
    $url = 'https://globalais2.orbcomm.net/api/v2/vessellist/getVessels';

    // Create a new cURL resource
    $ch = curl_init($url);

    $data['api_key'] = "5328E1A9-DD14-4AD6-91D4-578C2109882C";
    $data['listName'] = "default";
    $data['lookBack'] = "1440";

    $payload = json_encode($data);

    // Attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    // Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'Content-Type:application/json'
    ));

    // Return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //curl_setopt($ch, CURLOPT_PORT, 9053);
    

    //
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    curl_setopt($ch, CURLOPT_SSLVERSION, 6); //Force requsts to use TLS 1.2
    // Execute the POST request
    $result = curl_exec($ch);

    if (curl_errno($ch))
    {
        $error_msg = curl_error($ch);
        echo $error_msg;
    }

    $resultados = json_decode($result, true);

    // Close cURL resource
    curl_close($ch);

    return $resultados;

}
?>
