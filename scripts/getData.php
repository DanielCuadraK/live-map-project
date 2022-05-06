<?php
require_once ('connection.php');

/*Function that calculates distance between two points in the map
Arguments:
    Float lat1 - latitud value from point 1
    Float lon1 - longitude value from point 1
    Float lat2 - latitud value from point 2
    Float lon2 - longitude value from point 2
    String unit - unit of measure either K for Kilometers or M for miles
*/

function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
    if (($lat1 == $lat2) && ($lon1 == $lon2))
    {
        return 0;
    }
    else
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K")
        {
            return ($miles * 1.609344);
        }
        else if ($unit == "N")
        {
            return ($miles * 0.8684);
        }
        else
        {
            return $miles;
        }
    }
}
//Function that obtains current position for the vessels from database
function getVesselsLocations()
{
    global $pdo;

    //Gets all information on active vessels from the database
    $result = $pdo->prepare("SELECT * FROM vesselTrip INNER JOIN vessel ON vesselTrip.MMSI = vessel.MMSI WHERE vessel.status = 1");
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    $rows = array();
    $i = 0;
    //Sets previous lat and lon to 99.99 to make sure that this is the first vessel
    $previousVesselLat = 99.99;
    $previousVesselLon = 99.99;

    //Iterate through all rows from the query
    while ($r = $result->fetch())
    {
        $rows[] = $r;

        //Cast date stored as string to time format
        $time = strtotime($r['recordDate']);

        //Creates a datetime with the correct format for the application
        $dt = new DateTime();
        $dt->setTimezone(new DateTimeZone('UTC'));
        $dt->setTimestamp($time);

        $rows[$i]['recordDate'] = $dt->format('m-d-Y H:i') . " UTC";

        $time = strtotime($r['eta']);

        $dt->setTimestamp($time);

        $rows[$i]['eta'] = $dt->format('m-d-Y H:i') . " UTC";

        //Validates that COG parameter is not null, in case of true sets it to 0 as a business rule
        if (is_null($r['cog'])) $rows[$i]['cog'] = 0;

        //Validates that SOG parameter is not null, in case of true sets it to 0 as a business rule
        if (is_null($r['sog'])) $rows[$i]['sog'] = 0;

        //Calculate lat/lon distance between current vessel and last drawn vessel to determine if the placement has to be displaced to avoid overlapping
        $lat_dif = abs(abs($r['lat']) - abs($previousVesselLat));
        $lon_dif = abs(abs($r['lon']) - abs($previousVesselLon));

        //initializes displacement to 0
        $rows[$i]['displacement'] = 0;

        //validates if lat and lon dif between last vessek and current vessel are less than 0.1 miles, if true sets a displacement of 0.1 lon for the current vessel
        if ($lat_dif < 0.1 && $lon_dif < 0.1)
        {
            $rows[$i]['lon'] = $r['lon'] + 0.1;
            $rows[$i]['displacement'] = 0.1;
        }

        //Checks on destination text code to replace it with full name according to business rule
        switch (trim($r['destination'], " "))
        {
            case 'USPME':
                $rows[$i]['destination'] = 'PORT MANATEE';
            break;
            case 'MXTAM>USPME':
                $rows[$i]['destination'] = 'PORT MANATEE';
            break;
            case 'MXTUX>USPME':
                $rows[$i]['destination'] = 'PORT MANATEE';
            break;
            case 'MXCOA>USPME':
                $rows[$i]['destination'] = 'PORT MANATEE';
            break;
            case 'MXTAM':
                $rows[$i]['destination'] = 'TAMPICO';
            break;
            case 'USPME>MXTAM':
                $rows[$i]['destination'] = 'TAMPICO';
            break;
            case 'MXTUX>MXTAM':
                $rows[$i]['destination'] = 'TAMPICO';
            break;
            case 'MXTUX':
                $rows[$i]['destination'] = 'TUXPAN';
            break;
            case 'USPME>MXTUX':
                $rows[$i]['destination'] = 'TUXPAN';
            break;
            case 'MXCOA':
                $rows[$i]['destination'] = 'COATZACOALCOS';
            break;
            default:
                $rows[$i]['destination'] = $r['destination'];

        }
        $i++;

        //Set previous lat and lon equals with the current vessel to be used for comparison with the next iteration
        $previousVesselLat = $r['lat'];
        $previousVesselLon = $r['lon'];
    }
    echo json_encode($rows);
}

//Function that gets the route for each vessel from the database

function getVesselRoute()
{
    global $pdo;
    $mmsi = $_POST['mmsi'];
    //Gets trip log from database using mmsi identification
    $result = $pdo->prepare("SELECT * FROM vesselTripLog where mmsi = :mmsi order by insertDate desc");
    $result->bindparam(':mmsi', $mmsi);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    $rows = array();

    //initializes previousLat and previousLon to 0 to indicate that this is the first iteration
    $previousLat = 0;
    $previousLon = 0;
    //initializes previousDestination to empty since it is the first iteration
    $previousDestination = "";
    $i = 0;
    while ($r = $result->fetch())
    {
        //Calculates traveled distance between previous point and current point
        $traveledDistance = distance($previousLat, $previousLon, $r['lat'], $r['lon'], "M");

        //Checks that both previous destination and current destination are the same to be considered the same trip
        if ($r['destination'] == $previousDestination || $previousDestination == "")
        {
            //Checks that the distance between previous and current location is greater than 10 miles to be taken into consideration for drawing
            if ($traveledDistance > 10)
            {
                //Sets destination and location variables equals to current record
                $previousLat = $r['lat'];
                $previousLon = $r['lon'];
                $previousDestination = $r['destination'];
                $rows[$i]['lat'] = $r['lat'];
                $rows[$i]['lon'] = $r['lon'];

                //Validates that COG parameter is not null, in case of true sets it to 0 as a business rule
                if (is_null($r['cog'])) $rows[$i]['cog'] = 0;
                else $rows[$i]['cog'] = $r['cog'];

                //Validates that SOG parameter is not null, in case of true sets it to 0 as a business rule
                if (is_null($r['sog'])) $rows[$i]['sog'] = 0;
                else $rows[$i]['sog'] = $r['sog'];

                $rows[$i]['name'] = $r['name'];

                $time = strtotime($r['recordDate']);
                $dt = new DateTime();
                $dt->setTimezone(new DateTimeZone('UTC'));
                $dt->setTimestamp($time);

                $rows[$i]['recordDate'] = $dt->format('m-d-Y H:i') . " UTC";
                $i++;
            }
        }
        else break;
    }
    echo json_encode($rows);
}

switch ($_POST['action'])
{
    case 'location':
        getVesselsLocations();
    break;
        //OBTIENE Y DIBUJA LA RUTA RECORRIDA DEL BARCO
        
    case 'route':
        getVesselRoute();
    break;
    default:
    break;
}

?>
