<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 
Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>Add New Records</title>
</head>

<!-- php includes -->
<?php

include('php_routines/mooring_php_routines.php');

?>

<?php
//AddNewRecords
/* Databases are opened and closed each entry: this is redundant but in preparation of 
    conversion of routines into functions */

/*------------------------------------------------------------------------------------*/
//Deployment DB add
/*
  `CruiseNumber` text,
  `DeploymentDate` date NOT NULL DEFAULT '0000-00-00' COMMENT 'local',
  `TimeofRelease` text COMMENT 'JD - GMT',
  `Latitude` float DEFAULT NULL,
  `Longitude` float DEFAULT NULL,
  `CTDcastNo` int(4) DEFAULT NULL,
  `DeploymentDepth` int(5) DEFAULT NULL,
  `Timekeeper` text,
  `MooringID` varchar(8) NOT NULL DEFAULT '',
*/

$MooringID = htmlspecialchars($_POST['MooringID']);
$CruiseNumber = htmlspecialchars($_POST['DeploymentCruiseNumber']);
$DeploymentDateTimeGMT = htmlspecialchars($_POST['DeploymentDateTimeGMT']);
if (empty($DeploymentDateTimeGMT)) { $DeploymentDateTimeGMT=NULL; }
$Latitude = htmlspecialchars($_POST['DeploymentLatitude']);
$Longitude = htmlspecialchars($_POST['DeploymentLongitude']);
$CTDcastNo = htmlspecialchars($_POST['DeploymentCTDcastNo']);
$DeploymentDepth = htmlspecialchars($_POST['DeploymentDepth']);
$DeploymentTimekeeper = htmlspecialchars($_POST['DeploymentTimekeeper']);
$ChiefScientist = htmlspecialchars($_POST['DeploymentChiefScientist']);
$Project = htmlspecialchars($_POST['Project']);
$PreLatitude = htmlspecialchars($_POST['PreLatitude']);
$PreLongitude = htmlspecialchars($_POST['PreLongitude']);
$EstimatedDepth = htmlspecialchars($_POST['EstimatedDepth']);
$EstimatedRecoveryDate = htmlspecialchars($_POST['EstimatedRecoveryDate']);
if (empty($EstimatedRecoveryDate)) { $EstimatedRecoveryDate=NULL; }


//Connect to DB
$con = dbConnection('../db_configs/db_config.php');

$sql = "INSERT INTO `MooringDeploymentLogs` (MooringID, CruiseNumber, DeploymentDateTimeGMT, 
    Latitude, Longitude, CTDcastNo, DeploymentDepth, Timekeeper, ChiefScientist, Project, PreLatitude,
    PreLongitude, EstimatedDepth, EstimatedRecoveryDate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
//Prepare insert statements
if ( !$stmt = $con->prepare($sql)) {
   echo "Prepare Error: ($con->errno) $con->error".PHP_EOL;
}
if ( !$stmt->bind_param('ssssssdsssssds',$MooringID,$CruiseNumber,$DeploymentDateTimeGMT,$Latitude,$Longitude,$CTDcastNo,$DeploymentDepth,$DeploymentTimekeeper,$ChiefScientist,$Project,$PreLatitude,$PreLongitude,$EstimatedDepth,$EstimatedRecoveryDate)) {
  echo "Binding Parameter Error: ($con->errno) $con->error".PHP_EOL;
}
if ( !$stmt->execute()) {
  echo "Execute Error: ($con->errno) $con->error".PHP_EOL;
}

if ($stmt->affected_rows === 0) {
 echo 'No rows updated'.PHP_EOL;
} else {  
 echo "Mooring Deployment Creation Success!!! <br>";
 echo '___'.date('Y-m-d G:i:s T').'___   '.PHP_EOL;
}

$stmt->close();
closeID($con);


/*------------------------------------------------------------------------------------*/
//Recovery DB add
/*
  `CruiseNumber` text,
  `DeploymentDate` date NOT NULL DEFAULT '0000-00-00' COMMENT 'local',
  `TimeofRelease` text COMMENT 'JD - GMT',
  `Latitude` float DEFAULT NULL,
  `Longitude` float DEFAULT NULL,
  `CTDcastNo` int(4) DEFAULT NULL,
  `DeploymentDepth` int(5) DEFAULT NULL,
  `Timekeeper` text,
  `MooringID` varchar(8) NOT NULL DEFAULT ''
*/

$MooringID = htmlspecialchars($_POST['MooringID']);
$CruiseNumber = htmlspecialchars($_POST['RecoveryCruiseNumber']);
$RecoveryDateTimeGMT = htmlspecialchars($_POST['RecoveryDateTimeGMT']);
if (empty($RecoveryDateTimeGMT)) { $RecoveryDateTimeGMT=NULL; }
$Latitude = htmlspecialchars($_POST['RecoveryLatitude']);
$Longitude = htmlspecialchars($_POST['RecoveryLongitude']);
$CTDcastNo = htmlspecialchars($_POST['RecoveryCTDcastNo']);
$DeploymentDepth = htmlspecialchars($_POST['DeploymentDepth']);
$RecoveryTimekeeper = htmlspecialchars($_POST['RecoveryTimekeeper']);
$ChiefScientist = htmlspecialchars($_POST['RecoveryChiefScientist']);

//Connect to DB
$con = dbConnection('../db_configs/db_config.php');

$sql = "INSERT INTO `MooringRecoveryLogs` (MooringID, CruiseNumber, RecoveryDateTimeGMT,
    Latitude, Longitude, CTDcastNo, DeploymentDepth, Timekeeper, ChiefScientist) VALUES (?,?,?,?,?,?,?,?,?)";
//Prepare insert statements
if ( !$stmt = $con->prepare($sql)) {
   echo "Prepare Error: ($con->errno) $con->error".PHP_EOL;
}
if ( !$stmt->bind_param('ssssssdss',$MooringID,$CruiseNumber,$RecoveryDateTimeGMT,$Latitude,$Longitude,$CTDcastNo,$DeploymentDepth,$RecoveryTimekeeper,$ChiefScientist)) {
  echo "Binding Parameter Error: ($con->errno) $con->error".PHP_EOL;
}
if ( !$stmt->execute()) {
  echo "Execute Error: ($con->errno) $con->error".PHP_EOL;
}

if ($stmt->affected_rows === 0) {
 echo 'No rows updated'.PHP_EOL;
} else {  
 echo "Mooring Recovery Creation Success!!! <br>";
 echo '___'.date('Y-m-d G:i:s T').'___   '.PHP_EOL;
}

$stmt->close();
closeID($con);
/*------------------------------------------------------------------------------------*/
//Mooring Notes DB add
/*
  `MooringID` varchar(8) NOT NULL DEFAULT '',
  `Comments` text,
  `ReleaseBattNew` varchar(1) DEFAULT 'y' COMMENT 'y/n',
  `ReleaseBattMonths` int(3) DEFAULT '0',
  `UserSignature` text
*/

$MooringID = htmlspecialchars($_POST['MooringID']);
$Comments = htmlspecialchars($_POST['Comments']);
$Release = htmlspecialchars($_POST['Release']);
$ReleaseBattMonths = htmlspecialchars($_POST['release_batt']);
$UserSignature = htmlspecialchars($_POST['Recorder']);

//Connect to DB
$con = dbConnection('../db_configs/db_config.php');

$sql = "INSERT INTO `mooringdeploymentnotes` (MooringID, Comments, ReleaseBattNew, ReleaseBattMonths,
    UserSignature) VALUES (?,?,?,?,?)";
//Prepare insert statements
if ( !$stmt = $con->prepare($sql)) {
   echo "Prepare Error: ($con->errno) $con->error".PHP_EOL;
}
if ( !$stmt->bind_param('sssis',$MooringID,$Comments,$Release,$ReleaseBattMonths,$UserSignature)) {
  echo "Binding Parameter Error: ($con->errno) $con->error".PHP_EOL;
}
if ( !$stmt->execute()) {
  echo "Execute Error: ($con->errno) $con->error".PHP_EOL;
}

if ($stmt->affected_rows === 0) {
 echo 'No rows updated'.PHP_EOL;
} else {  
 echo "Mooring Comments Creation Success!!! <br>";
 echo '___'.date('Y-m-d G:i:s T').'___   '.PHP_EOL;
}

$stmt->close();
closeID($con);

/*------------------------------------------------------------------------------------*/
//Instrument Package DB add
/*
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MooringID` varchar(20) NOT NULL DEFAULT '',
  `Depth` float NOT NULL COMMENT 'In meters - use -999 for N/A',
  `InstType` varchar(30) DEFAULT '',
  `SerialNo` varchar(20) DEFAULT NULL,
  `InstID` varchar(50) DEFAULT NULL COMMENT 'Instrument + SerialNo',
  `Notes` varchar(80) DEFAULT '',
  `Deployed` varchar(1) DEFAULT '',
  `Recovered` varchar(1) DEFAULT '',
  `DateTimeOnGMT` datetime DEFAULT NULL COMMENT 'start of logging',
  `DateTimeOffGMT` datetime DEFAULT NULL COMMENT 'inst time when turned off',
  `GPSTimeOnGMT` datetime DEFAULT NULL COMMENT 'time when inst synched to gps',
  `GPSTimeOffGMT` datetime DEFAULT NULL COMMENT 'gps time when inst turned off',
  `InstTimeCheck` time DEFAULT NULL COMMENT 'To Nearest Minute',
  `GPSTimeCheck` time DEFAULT NULL COMMENT 'To Nearest Minute',
  `SetupPerson` varchar(40) DEFAULT '',
  `RetrievalPerson` varchar(40) DEFAULT '',
  `DataFile` text,
  `NumberDataRecords` int(11) DEFAULT NULL,
  `DeployedBatteryVoltage` float DEFAULT NULL,
  `RecoveredBatteryVoltage` float DEFAULT NULL,
  `TimeOnJD` int(3) DEFAULT NULL COMMENT '(depricated 06/2014)',
  `TimeOffJD` int(3) DEFAULT NULL COMMENT '(depricated 06/2014)',
  `TimeOnGMT` time DEFAULT NULL COMMENT '(depricated 06/2014)',
  `TimeOffGMT` time DEFAULT NULL COMMENT '(depricated 06/2014)',
*/

//Connect to DB
$con = dbConnection('../db_configs/db_config.php');

/* an unknown number of instruments can be passed (but I max it out at 10) */
$MooringID = htmlspecialchars($_POST['MooringID']);

//Loop through possible entries
$inst = ($_POST['inst']);


foreach($inst as $row => $innerArray){
    if (!empty($innerArray['InstType'])) {
        
        $Depth = htmlspecialchars($innerArray['depth']);
        $InstType = htmlspecialchars($innerArray['InstType']);
        $PreDeploymentNotes = htmlspecialchars($innerArray['PreDeploymentNotes']);
        $SerialNo = htmlspecialchars($innerArray['serialnum']);
        $Prepped = htmlspecialchars('n');
        $Deployed = htmlspecialchars($innerArray['deployed']);
        $Recovered = htmlspecialchars($innerArray['recovered']);
        $DateTimeOnGMT = htmlspecialchars($innerArray['DateTimeGMT_on']);
        if (empty($DateTimeOnGMT)) { $DateTimeOnGMT=NULL; }
        $InstID = $InstType." ".$SerialNo;


        $sql = "INSERT INTO `mooringdeployedinstruments` (MooringID, Depth, InstType, PreDeploymentNotes, SerialNo, InstID, Prepped, Deployed, Recovered, DateTimeOnGMT) VALUES (?,?,?,?,?,?,?,?,?,?)";

        //Prepare insert statements
        if ( !$stmt = $con->prepare($sql)) {
           echo "Prepare Error: ($con->errno) $con->error".PHP_EOL;
        } else { echo "success stage 1"; }

        if ( !$stmt->bind_param('sdssssssss',$MooringID,$Depth,$InstType,$PreDeploymentNotes,$SerialNo,$InstID,$Prepped,$Deployed,$Recovered,$DateTimeOnGMT)) {
          echo "Binding Parameter Error: ($con->errno) $con->error".PHP_EOL;
        }
        if ( !$stmt->execute()) {
          echo "Execute Error: ($con->errno) $con->error".PHP_EOL;
        }

        if ($stmt->affected_rows === 0) {
         echo 'No rows updated'.PHP_EOL;
        } else {  
         echo "Instrument ".$innerArray['InstType']." Creation Success!!! <br>";
         echo '___'.date('Y-m-d G:i:s T').'___   '.PHP_EOL;
        }

        $stmt->close();

        echo "Instrument ".$innerArray['InstType']." Insert Success!!! <br>";
    }
}

mysqli_close($con);

?>

<a href="mooring_landing.php">Main Records</a>

</body>
</html>