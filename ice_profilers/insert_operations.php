<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 
Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>Add New Records</title>
</head>
<body>

<!-- php includes -->
<?php
include('php_routines/iceprofiler_php_routines.php');


?>

<?php
//AddNewRecords
/* Databases are opened and closed each entry: this is redundant but in preparation of 
    conversion of routines into functions */

/*------------------------------------------------------------------------------------*/
//operations_prof DB add
/*
  `InstID` varchar(11) NOT NULL DEFAULT 'IPS-5' COMMENT 'IPS-5',
  `SerialNo` varchar(11) NOT NULL COMMENT 'cannot be empty',
  `isdeployed` varchar(1) NOT NULL DEFAULT 'n' COMMENT 'y/n',
  `isrecovered` varchar(1) NOT NULL DEFAULT 'n' COMMENT 'y/n',
  `MooringID` varchar(11) DEFAULT NULL,
  `CruiseID` varchar(11) DEFAULT NULL,
  `DeploymentShipName` varchar(11) DEFAULT NULL,
  `Latitude` float DEFAULT NULL COMMENT 'dd.mm N',
  `Longitude` float DEFAULT NULL COMMENT '-ddd.mm W',
  `DeployDate` int(11) DEFAULT NULL COMMENT 'Julian Day',
  `RecoveryDate` int(11) DEFAULT NULL COMMENT 'Julian Day',
  `RecordType` int(11) DEFAULT NULL,
  `DataFileName` text,
  `notes` text,
  `RecoveryShipName` varchar(11) DEFAULT NULL,
  `NumberofPhases` int(3) DEFAULT NULL,
  `InstrumentDepth` float DEFAULT NULL COMMENT 'xxxx.xx',
  `BottomDepth` float DEFAULT NULL COMMENT 'xxxx.xx',

  `DateofRecord` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'yyyy-mm-dd hh:mm:ss UTC',
*/

$InstID = htmlspecialchars($_POST['InstID']);
$SerialNo = htmlspecialchars($_POST['SerialNo']);
$isdeployed = htmlspecialchars($_POST['isdeployed']);
$isrecovered = htmlspecialchars($_POST['isrecovered']);
$MooringID = htmlspecialchars($_POST['MooringID']);
$CruiseID = htmlspecialchars($_POST['CruiseID']);
$DeploymentShipName = htmlspecialchars($_POST['DeploymentShipName']);
$Latitude = htmlspecialchars($_POST['Latitude']);
$Longitude = htmlspecialchars($_POST['Longitude']);
$DeployDate = htmlspecialchars($_POST['DeployDate']);
$RecoveryDate = htmlspecialchars($_POST['RecoveryDate']);
$RecordType = htmlspecialchars($_POST['RecordType']);
$DataFileName = htmlspecialchars($_POST['DataFileName']);
$notes = htmlspecialchars($_POST['notes']);
$RecoveryShipName = htmlspecialchars($_POST['RecoveryShipName']);
$NumberofPhases = htmlspecialchars($_POST['NumberofPhases']);
$InstrumentDepth = htmlspecialchars($_POST['InstrumentDepth']);
$BottomDepth = htmlspecialchars($_POST['BottomDepth']);
$DateofRecord = htmlspecialchars($_POST['DateofRecord']);
$TimeOn = htmlspecialchars($_POST['TimeOn']);
$TimeOff = htmlspecialchars($_POST['TimeOff']);

//Connect to DB
$con = dbConnection();

//check for existance of MooringID and kill if found

$insert = "INSERT INTO `operations_iceprof` (InstID, SerialNo, isdeployed, isrecovered, 
    MooringID, CruiseID, DeploymentShipName, Latitude, Longitude, DeployDate, RecoveryDate,
    RecordType, DataFileName, notes, RecoveryShipName, NumberofPhases, InstrumentDepth, 
    BottomDepth, DateofRecord, TimeOn, TimeOff) VALUES ('".$InstID." ".$SerialNo."','".$SerialNo."','".$isdeployed."','".$isrecovered."',
    '".$MooringID."','".$CruiseID."','".$DeploymentShipName."','".$Latitude."','".$Longitude."',
    '".$DeployDate."','".$RecoveryDate."','".$RecordType."','".$DataFileName."','".$notes."',
    '".$RecoveryShipName."','".$NumberofPhases."','".$InstrumentDepth."','".$BottomDepth."',
    '".$DateofRecord."','".$TimeOn."','".$TimeOff."')";

$Depresult = $con->query($insert) or die($con->error.__LINE__);

closeID($con);

echo "Operations Insert Success!!! <br>";

echo '<a href="newrecord.php">Back to input forms</a>';      


?>

</body>
</html>