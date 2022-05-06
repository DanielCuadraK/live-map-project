<?php
require_once('connection.php');
require_once("APIrequest.php");

/*Function that creates a new vessel in the database
    Arguments: 
    vesselObject - an array containing all vessel parameters
 */

function createVessel($vesselObject){

    global $pdo;
    $name = $vesselObject['name'];
    $imo = $vesselObject['imo'];
    $mmsi = $vesselObject['mmsi'];
    $mediaFolder = $vesselObject['mediaFolder'];
    $routeColor = $vesselObject['routeColor'];
    if($vesselObject['status'] == "true") 
        $status = 1;
    else
        $status = 0;
    $lastUpdated = date_create()->format('Y-m-d H:i:s');
    $sql = "INSERT INTO vessel (name,imo,mmsi,routeColor,status,mediaFolder,lastUpdated) VALUES (:name,:imo,:mmsi,:routeColor,:status,:mediaFolder,:lastUpdated)";
    $query = $pdo->prepare($sql);
    $query->bindValue(':name', $name);
    $query->bindValue(':imo', $imo);
    $query->bindValue(':mmsi', $mmsi);
    $query->bindValue(':routeColor', $routeColor);
    $query->bindValue(':status', $status);
    $query->bindValue(':lastUpdated', $lastUpdated);
    $query->bindValue(':mediaFolder', $mediaFolder);
    $query->execute();
    if (!file_exists('../assets/img/'.$mediaFolder)) {
        mkdir('../assets/img/'.$mediaFolder, 0777, true);
    }
    echo "success";
}

/*Function that updates a vessel in the database
    Arguments: 
    vesselObject - an array containing all vessel parameters
 */

function updateVessel($vesselObject){
    global $pdo;
    $id = $vesselObject['id'];
    $name = $vesselObject['name'];
    $imo = $vesselObject['imo'];
    $mmsi = $vesselObject['mmsi'];
    $mediaFolder = $vesselObject['mediaFolder'];
    $routeColor = $vesselObject['routeColor'];
    if($vesselObject['status'] == "true") 
        $status = 1;
    else
        $status = 0;
    $lastUpdated = date_create()->format('Y-m-d H:i:s');
    //echo $id." ".$name." ".$imo." ".$mmsi." ".$routeColor." ".$status." ".$mediaFolder." ".$lastUpdated;
    $sql = "UPDATE vessel SET name=:name,imo=:imo,mmsi=:mmsi,routeColor=:routeColor,mediaFolder=:mediaFolder, status = :status, lastUpdated = :lastUpdated WHERE id=:id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id);
    $query->bindValue(':name', $name);
    $query->bindValue(':imo', $imo);
    $query->bindValue(':mmsi', $mmsi);
    $query->bindValue(':routeColor', $routeColor);
    $query->bindValue(':status', $status);
    $query->bindValue(':lastUpdated', $lastUpdated);
    $query->bindValue(':mediaFolder', $mediaFolder);
    $query->execute();
    if (!file_exists('../assets/img/'.$mediaFolder)) {
        mkdir('../assets/img/'.$mediaFolder, 0777, true);
    }
    echo "success";
}


/*Function that deletes a vessel from the database
    Arguments: 
    vesselObject - an array containing all vessel parameters
 */

function deleteVessel($vesselObject){
    global $pdo;
    $id = $vesselObject['id'];
    $sql = "DELETE FROM vessel WHERE id=:id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    echo "success";
}

/*Function that gets all vessels from the database
 */

function getVessels(){
    global $pdo;
    $rows = array();
    $result = $pdo->prepare("SELECT * FROM vessel ORDER BY id DESC");
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    while($row = $result->fetch()) { 
        $rows[] = $row;
    }
    echo json_encode($rows);

}

/*Function that gets a vessel by it's ID' from the database
    Arguments: 
    vesselObject - an array containing all vessel parameters
 */
function getVesselById($vesselObject){
    global $pdo;
    $id = $vesselObject['id'];
    $rows = array();
    $result = $pdo->prepare("SELECT * FROM vessel WHERE id = :id");
    $result->bindparam(':id', $id);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    while($row = $result->fetch()) { 
        $rows[] = $row;
    }
    echo json_encode($rows);
}

/*Function that calls vendor API to refresh vessel list from the server*/

function updateVesselsList(){
        $currentVessels = array();
        $i = 0;
        $result = $pdo->prepare("SELECT mmsi FROM vessel WHERE status = 1");
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        while($row = $result->fetch()) { 
            $currentVessels[$i] = $row['mmsi'];
            $i++;
        }
        clearVesselList();
        addVessels(json_encode($currentVessels));  
}

//Checks if $_POST variable is set

if(isset($_POST))
{
    isset($_POST['vesselId'])  ? $vesselObject['id'] = $_POST['vesselId'] : '';
    isset($_POST['vesselName'])  ? $vesselObject['name'] = $_POST['vesselName'] : '';
    isset($_POST['vesselIMO'])  ? $vesselObject['imo'] = $_POST['vesselIMO'] : '';
    isset($_POST['vesselMMSI'])  ? $vesselObject['mmsi'] = $_POST['vesselMMSI'] : '';
    isset($_POST['vesselMediaFolder'])  ? $vesselObject['mediaFolder'] = $_POST['vesselMediaFolder'] : '';
    isset($_POST['vesselColor'])  ? $vesselObject['routeColor'] = $_POST['vesselColor'] : '';
    isset($_POST['vesselStatus'])  ? $vesselObject['status'] = $_POST['vesselStatus'] : '';
}

//Case with all possible actions

switch ($_POST['action']) {

    case 'getVessels':
        getVessels();
    break;
    case 'createVessel':
        createVessel($vesselObject);
    break;
    case 'updateVessel':
        updateVessel($vesselObject);
    break;
    case 'updateVesselStatus':
        updateVesselStatus($vesselObject);
    break;
    case 'getVesselById':
        getVesselById($vesselObject);
    break;
    case 'deleteVessel':
        deleteVessel($vesselObject);
    break;
    case 'updateList':
        updateVesselsList();
    default:
    break;

}

?>