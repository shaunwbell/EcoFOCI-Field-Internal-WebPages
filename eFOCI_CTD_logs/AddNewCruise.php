<?php

include('php_routines/cruise_php_routines.php');


//AddNewRecords

/*------------------------------------------------------------------------------------*/
//Cast DB add
/* DB structure
CREATE TABLE `cruises` (
  `CruiseID` varchar(12) NOT NULL DEFAULT '' COMMENT 'sidyymm - eg DY1309',
  `Project_Leg` varchar(3) DEFAULT NULL,
  `Vessel` varchar(40) NOT NULL DEFAULT '' COMMENT 'Full Ship Name',
  `ShipID` varchar(3) NOT NULL DEFAULT '' COMMENT 'Dyson - DY',
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `Project` varchar(40) DEFAULT NULL,
  `ChiefScientist` varchar(40) NOT NULL,
  `StartPort` varchar(40) DEFAULT NULL,
  `EndPort` varchar(40) DEFAULT NULL,
  `Description` text,
  PRIMARY KEY (`CruiseID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
*/


$CruiseID = htmlspecialchars($_GET['CruiseID']);
$Project_Leg = htmlspecialchars($_GET['Project_Leg']);
$Vessel = htmlspecialchars($_GET['Vessel']);
$ShipID = htmlspecialchars($_GET['ShipID']);
$StartDate = htmlspecialchars($_GET['StartDate']);
$EndDate = htmlspecialchars($_GET['EndDate']);
$Project = htmlspecialchars($_GET['Project']);
$ChiefScientist = htmlspecialchars($_GET['ChiefScientist']);
$StartPort = htmlspecialchars($_GET['StartPort']);
$EndPort = htmlspecialchars($_GET['EndPort']);
$Description = htmlspecialchars($_GET['Description']);
$CruiseYear = htmlspecialchars($_GET['CruiseYear']);
$ctdlogs_pdf_name = htmlspecialchars($_GET['ctdlogs_pdf_name']);

//Connect to DB
$con = dbConnection('../db_configs/db_config_cruisecastlogs.php');

//SQL input
$sql = "INSERT INTO `Cruises` (CruiseID, Project_Leg, Vessel, ShipID, StartDate, 
    EndDate, Project, ChiefScientist, StartPort, EndPort, Description, CruiseYear, ctdlogs_pdf_name) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

//Prepare insert statements
if ( !$stmt = $con->prepare($sql)) {
   echo "Prepare Error: ($con->errno) $con->error".PHP_EOL;
}
if ( !$stmt->bind_param("sssssssssssss",$CruiseID,$Project_Leg,$Vessel,$ShipID,$StartDate,$EndDate,$Project,$ChiefScientist,$StartPort,$EndPort,$Description,$CruiseYear,$ctdlogs_pdf_name)) {
  echo "Binding Parameter Error: ($con->errno) $con->error".PHP_EOL;
}
if ( !$stmt->execute()) {
  echo "Execute Error: ($con->errno) $con->error".PHP_EOL;
}

if ($stmt->affected_rows === 0) {
 echo 'No rows updated'.PHP_EOL;
} else {  
 echo "Cruise ".$CruiseID." Insert Success!!! <br>";
 echo '___'.date('Y-m-d G:i:s T').'___   '.PHP_EOL;
}

$stmt->close();
mysqli_close($con);


?>

