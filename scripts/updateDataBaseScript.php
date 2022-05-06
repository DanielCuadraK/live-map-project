<?php
require_once ("connection.php");
require_once("APIrequest.php");

//Creates an entry on the log file for validating that the process was executed
$action = date_create()->format('Y-m-d H:i:s') . " | CronJob Started";
file_put_contents("log.txt", $action . PHP_EOL, FILE_APPEND | LOCK_EX);

/*Function that validates that lan and lon values are not 0 as defined in business rules
    ARGUMENTS:
        voyage - Array containg lat and log values for the RECORD
*/
function validateLatLon($voyage)
{
    $isValid = true;
    if (is_null($voyage['lat']) || $voyage['lat'] == 0 || is_null($voyage['lon']) || $voyage['lon'] == 0) $isValid = false;
    return $isValid;
}

/*Function that validates if the entry is duplicate
    ARGUMENTS:
        recordDate - date from the RECORD
        mmsi - identification for the VESSEL
*/
function validateDuplicate($recordDate, $mmsi)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT count(id) FROM vesselTrip WHERE recordDate = :recordDate AND mmsi = :mmsi');
    $stmt->bindValue(':recordDate', $recordDate);
    $stmt->bindValue(':mmsi', $mmsi);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row[0];
}

//Function that deletes previous voyages from the vessel trip table that is used to draw current location
function deletePreviousVoyage($voyage)
{
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM vesselTrip WHERE mmsi = :mmsi');
    $stmt->bindValue(':mmsi', $voyage['mmsi']);
    $stmt->execute();
    $action = date_create()->format('Y-m-d H:i:s') . " | DELETED TRIP FOR SHIP=" . $voyage['name'];
    file_put_contents("log.txt", $action . PHP_EOL, FILE_APPEND | LOCK_EX);
}

/*Function that creates a record on the vessel trip log containing all historical DATA
    ARGUMENTS:
        voyage - array containing all data from the voyage 
*/
function createHistoricalRecord($voyage)
{
    if (validateLatLon($voyage))
    {
        global $pdo;
        $stm = $pdo->prepare('INSERT INTO vesselTripLog (
        insertDate,
        recordDate,
        mmsi,
        stationType,
        navStatus,
        rot,
        sog,
        posAccuracy,
        lon,
        lat,
        cog,
        trueHeading,
        recordTimestamp,
        specialManoeuvre,
        raim,
        imo,
        name,
        callSign,
        type,
        antToBow,
        antToStern,
        antToPort,
        antToStarboard,
        elecPosDevice,
        maxDraught,
        destination,
        eta) 
    VALUES (
        :insertDate,
        :recordDate,
        :mmsi,
        :stationType,
        :navStatus,
        :rot,
        :sog,
        :posAccuracy,
        :lon,
        :lat,
        :cog,
        :trueHeading,
        :recordTimestamp,
        :specialManoeuvre,
        :raim,
        :imo,
        :name,
        :callSign,
        :type,
        :antToBow,
        :antToStern,
        :antToPort,
        :antToStarboard,
        :elecPosDevice,
        :maxDraught,
        :destination,
        :eta       
    )');
        $stm->bindValue(':insertDate', date_create()
            ->format('Y-m-d H:i:s'));
        $stm->bindValue(':recordDate', $voyage['recordDate']);
        $stm->bindValue(':mmsi', $voyage['mmsi']);
        $stm->bindValue(':stationType', $voyage['stationType']);
        $stm->bindValue(':navStatus', $voyage['navStatus']);
        $stm->bindValue(':rot', $voyage['rot']);
        $stm->bindValue(':sog', $voyage['sog']);
        $stm->bindValue(':posAccuracy', $voyage['posAccuracy']);
        $stm->bindValue(':lon', $voyage['lon']);
        $stm->bindValue(':lat', $voyage['lat']);
        $stm->bindValue(':cog', $voyage['cog']);
        $stm->bindValue(':trueHeading', $voyage['trueHeading']);
        $stm->bindValue(':recordTimestamp', $voyage['recordTimestamp']);
        $stm->bindValue(':specialManoeuvre', $voyage['specialManoeuvre']);
        $stm->bindValue(':raim', $voyage['raim']);
        $stm->bindValue(':imo', $voyage['imo']);
        $stm->bindValue(':name', $voyage['name']);
        $stm->bindValue(':callSign', $voyage['callSign']);
        $stm->bindValue(':type', $voyage['type']);
        $stm->bindValue(':antToBow', $voyage['antToBow']);
        $stm->bindValue(':antToStern', $voyage['antToStern']);
        $stm->bindValue(':antToPort', $voyage['antToPort']);
        $stm->bindValue(':antToStarboard', $voyage['antToStarboard']);
        $stm->bindValue(':elecPosDevice', $voyage['elecPosDevice']);
        $stm->bindValue(':maxDraught', $voyage['maxDraught']);
        $stm->bindValue(':destination', $voyage['destination']);
        $stm->bindValue(':eta', $voyage['eta']);
        $stm->execute();
        $action = date_create()->format('Y-m-d H:i:s') . " | CREATED TRIP IN LOG FOR SHIP=" . $voyage['name'] . " DATE= " . $voyage['recordDate'];
        file_put_contents("log.txt", $action . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

/*Function that creates a record on the vessel trip log containing all historical DATA
    ARGUMENTS:
        voyage - array containing all data from the voyage 
*/
function createCurrentRecord($voyage)
{
    if (validateLatLon($voyage))
    {
        global $pdo;
        $stm = $pdo->prepare('INSERT INTO vesselTrip (
        insertDate,
        recordDate,
        mmsi,
        stationType,
        navStatus,
        rot,
        sog,
        posAccuracy,
        lon,
        lat,
        cog,
        trueHeading,
        recordTimestamp,
        specialManoeuvre,
        raim,
        imo,
        name,
        callSign,
        type,
        antToBow,
        antToStern,
        antToPort,
        antToStarboard,
        elecPosDevice,
        maxDraught,
        destination,
        eta) 
    VALUES (
        :insertDate,
        :recordDate,
        :mmsi,
        :stationType,
        :navStatus,
        :rot,
        :sog,
        :posAccuracy,
        :lon,
        :lat,
        :cog,
        :trueHeading,
        :recordTimestamp,
        :specialManoeuvre,
        :raim,
        :imo,
        :name,
        :callSign,
        :type,
        :antToBow,
        :antToStern,
        :antToPort,
        :antToStarboard,
        :elecPosDevice,
        :maxDraught,
        :destination,
        :eta       
    )');
        $stm->bindValue(':insertDate', date_create()
            ->format('Y-m-d H:i:s'));
        $stm->bindValue(':recordDate', $voyage['recordDate']);
        $stm->bindValue(':mmsi', $voyage['mmsi']);
        $stm->bindValue(':stationType', $voyage['stationType']);
        $stm->bindValue(':navStatus', $voyage['navStatus']);
        $stm->bindValue(':rot', $voyage['rot']);
        $stm->bindValue(':sog', $voyage['sog']);
        $stm->bindValue(':posAccuracy', $voyage['posAccuracy']);
        $stm->bindValue(':lon', $voyage['lon']);
        $stm->bindValue(':lat', $voyage['lat']);
        $stm->bindValue(':cog', $voyage['cog']);
        $stm->bindValue(':trueHeading', $voyage['trueHeading']);
        $stm->bindValue(':recordTimestamp', $voyage['recordTimestamp']);
        $stm->bindValue(':specialManoeuvre', $voyage['specialManoeuvre']);
        $stm->bindValue(':raim', $voyage['raim']);
        $stm->bindValue(':imo', $voyage['imo']);
        $stm->bindValue(':name', $voyage['name']);
        $stm->bindValue(':callSign', $voyage['callSign']);
        $stm->bindValue(':type', $voyage['type']);
        $stm->bindValue(':antToBow', $voyage['antToBow']);
        $stm->bindValue(':antToStern', $voyage['antToStern']);
        $stm->bindValue(':antToPort', $voyage['antToPort']);
        $stm->bindValue(':antToStarboard', $voyage['antToStarboard']);
        $stm->bindValue(':elecPosDevice', $voyage['elecPosDevice']);
        $stm->bindValue(':maxDraught', $voyage['maxDraught']);
        $stm->bindValue(':destination', $voyage['destination']);
        $stm->bindValue(':eta', $voyage['eta']);
        $stm->execute();
        $action = date_create()->format('Y-m-d H:i:s') . " | CREATED TRIP FOR SHIP=" . $voyage['name'] . " DATE= " . $voyage['recordDate'];
        file_put_contents("log.txt", $action . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}



//GET RESULTS FROM ORBCOMM SERVICE
$resultados = connectToService();

//LOOPS THROUGH RESULTS
foreach ($resultados as $item)
{
    $voyage = array(
        'recordDate' => $item['dynamic']['date'],
        'mmsi' => $item['dynamic']['mmsi'],
        'stationType' => $item['dynamic']['stationType'],
        'navStatus' => $item['dynamic']['navStatus'],
        'rot' => $item['dynamic']['rot'],
        'sog' => $item['dynamic']['sog'],
        'posAccuracy' => $item['dynamic']['posAccuracy'],
        'lon' => $item['dynamic']['lon'],
        'lat' => $item['dynamic']['lat'],
        'cog' => $item['dynamic']['cog'],
        'trueHeading' => $item['dynamic']['trueHeading'],
        'recordTimestamp' => $item['dynamic']['timestamp'],
        'specialManoeuvre' => $item['dynamic']['specialManoeuvre'],
        'raim' => $item['dynamic']['raim'],
        'imo' => $item['static']['imo'],
        'name' => $item['static']['name'],
        'callSign' => $item['static']['callSign'],
        'type' => $item['static']['type'],
        'antToBow' => $item['static']['antToBow'],
        'antToStern' => $item['static']['antToStern'],
        'antToPort' => $item['static']['antToPort'],
        'antToStarboard' => $item['static']['antToStarboard'],
        'elecPosDevice' => $item['static']['elecPosDevice'],
        'maxDraught' => $item['voyage']['maxDraught'],
        'destination' => $item['voyage']['destination'],
        'eta' => $item['voyage']['eta']
    );

    //VALIDATE IF THE DATA IS ALREADY PRESENT ON DATABASE, IF TRUE THEN IT DOESN'T CREATE THE RECORDS, IF FALSE PROCEEDS TO DELETE CURRENT TRIP FROM THE VESSEL, ADD TRIP TO LOG AND TO CURRENT TRIPS
    if (validateDuplicate($voyage['recordDate'], $voyage['mmsi']) == 0)
    {
        deletePreviousVoyage($voyage);
        createHistoricalRecord($voyage);
        createCurrentRecord($voyage);
    }
}
$action = date_create()->format('Y-m-d H:i:s') . " | CronJob Finished";
file_put_contents("log.txt", $action . PHP_EOL, FILE_APPEND | LOCK_EX);
?>
