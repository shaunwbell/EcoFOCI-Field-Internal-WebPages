<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 
Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>Update Mooring Instrument Log Records</title>
</head>

<?php

include('php_routines/mooring_php_routines.php');


//AddNewRecords
/* Databases are opened and closed each entry: this is redundant but in preparation of 
    conversion of routines into functions */

/*------------------------------------------------------------------------------------*/
// Calibration Records Add - not all fields are added from the form
/*
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MooringID` varchar(20) NOT NULL DEFAULT '',
  `Depth` float NOT NULL COMMENT 'In meters - use -999 for N/A',
  `InstType` varchar(30) DEFAULT '',
  `SerialNo` varchar(20) DEFAULT NULL,
  `InstID` varchar(50) DEFAULT NULL COMMENT 'Instrument + SerialNo',
  `PreDeploymentNotes` text,
  `PostDeploymentNotes` text,
  `Deployed` enum('y','n') DEFAULT NULL,
  `Recovered` enum('y','n') DEFAULT NULL,
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
  `DataStatus` enum('final','unqcd','downloaded','no data','') NOT NULL DEFAULT '',
  `ActualDepth` float NOT NULL COMMENT 'Actual Depth (m)',
*/


$db_id = htmlspecialchars($_POST['id']);
$Depth = htmlspecialchars($_POST['Depth']);
$ActualDepth = htmlspecialchars($_POST['ActualDepth']);
$InstType = htmlspecialchars($_POST['InstType']);
$SerialNo = htmlspecialchars($_POST['SerialNo']);
$Deployed = htmlspecialchars($_POST['Deployed']);
$Recovered = htmlspecialchars($_POST['Recovered']);
$GPSTimeCheck = htmlspecialchars($_POST['GPSTimeCheck']);
if (empty($GPSTimeCheck)) { $GPSTimeCheck=NULL; }
$InstTimeCheck = htmlspecialchars($_POST['InstTimeCheck']);
if (empty($InstTimeCheck)) { $InstTimeCheck=NULL; }
$MooringID = htmlspecialchars($_POST['MooringID']);
$PreDeploymentNotes = htmlspecialchars($_POST['PreDeploymentNotes']);
$PostDeploymentNotes = htmlspecialchars($_POST['PostDeploymentNotes']);
$SetupPerson = htmlspecialchars($_POST['SetupPerson']);
$RetrievalPerson = htmlspecialchars($_POST['RetrievalPerson']);
$DataFile = htmlspecialchars($_POST['DataFile']);
$NumberDataRecords = htmlspecialchars($_POST['NumberDataRecords']);
$DeployedBatteryVoltage = htmlspecialchars($_POST['DeployedBatteryVoltage']);
$RecoveredBatteryVoltage = htmlspecialchars($_POST['RecoveredBatteryVoltage']);
$GPSTimeOnGMT = htmlspecialchars($_POST['GPSTimeOnGMT']);
if (empty($GPSTimeOnGMT)) { $GPSTimeOnGMT=NULL; }
$GPSTimeOffGMT = htmlspecialchars($_POST['GPSTimeOffGMT']);
if (empty($GPSTimeOffGMT)) { $GPSTimeOffGMT=NULL; }
$DateTimeOnGMT = htmlspecialchars($_POST['DateTimeOnGMT']);
if (empty($DateTimeOnGMT)) { $DateTimeOnGMT=NULL; }
$DateTimeOffGMT = htmlspecialchars($_POST['DateTimeOffGMT']);
if (empty($DateTimeOffGMT)) { $DateTimeOffGMT=NULL; }
$DataStatus = htmlspecialchars($_POST['DataStatus']);

//Connect to DB

$con = dbConnection('../db_configs/db_config.php');

$sql = "UPDATE `MooringDeployedInstruments` SET Depth= ?, ActualDepth=?, InstType=?, SerialNo=?, GPSTimeCheck=?, Deployed=?, Recovered=?, InstTimeCheck=?, MooringID=?, PreDeploymentNotes=?, PostDeploymentNotes=?, SetupPerson=?, RetrievalPerson=?, DataFile=?, NumberDataRecords=?, DeployedBatteryVoltage=?, RecoveredBatteryVoltage=?, GPSTimeOnGMT=?, GPSTimeOffGMT=?, DataStatus=?, DateTimeOnGMT=?, DateTimeOffGMT=? WHERE `id`=? ";
//Prepare insert statements
if ( !$stmt = $con->prepare($sql)) {
   echo "Prepare Error: ($con->errno) $con->error".PHP_EOL;
}
if ( !$stmt->bind_param('ddssssssssssssiddsssssi',$Depth,$ActualDepth,$InstType,$SerialNo,$GPSTimeCheck,$Deployed,$Recovered,$InstTimeCheck,$MooringID,$PreDeploymentNotes,$PostDeploymentNotes,$SetupPerson,$RetrievalPerson,$DataFile,$NumberDataRecords,$DeployedBatteryVoltage,$RecoveredBatteryVoltage,$GPSTimeOnGMT,$GPSTimeOffGMT,$DataStatus,$DateTimeOnGMT,$DateTimeOffGMT,$db_id)) {
  echo "Binding Parameter Error: ($con->errno) $con->error".PHP_EOL;
}
if ( !$stmt->execute()) {
  echo "Execute Error: ($con->errno) $con->error".PHP_EOL;
}

if ($stmt->affected_rows === 0) {
 echo 'No rows updated'.PHP_EOL;
} else {  
 echo "Instrument Log Update Success!!! <br>";
 echo '___'.date('Y-m-d G:i:s T').'___   '.PHP_EOL;
}

$stmt->close();
closeID($con);


?>


<a href="operations.php">Modify Another Record</a>

</body>
</html>