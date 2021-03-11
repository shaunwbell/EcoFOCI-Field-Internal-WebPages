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
//upgrade_prof DB add
/*
  `inst_id` varchar(11) DEFAULT NULL COMMENT 'IPS-5',
  `serial_number` varchar(11) NOT NULL DEFAULT '' COMMENT 'cannot be empty',
  `FirmwareVersion` varchar(10) NOT NULL DEFAULT '' COMMENT 'Vx.x',
  `OtherUpgrades` text NOT NULL COMMENT 'explanation',
  `DateofRecord` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'localtime',
*/

$inst_id = htmlspecialchars($_POST['inst_id']); 
$serial_number = htmlspecialchars($_POST['serial_number']); 
$FirmwareVersion = htmlspecialchars($_POST['FirmwareVersion']); 
$OtherUpgrades = htmlspecialchars($_POST['OtherUpgrades']);
$DateofRecord = htmlspecialchars($_POST['DateofRecord']); 


//Connect to DB
$con = dbConnection();

//check for existance of MooringID and kill if found

$insert = "INSERT INTO `upgrade_iceprof` (inst_id, serial_number, FirmwareVersion, OtherUpgrades, 
    DateofRecord) VALUES ('".$inst_id."','".$serial_number."','".$FirmwareVersion."','".$OtherUpgrades."',
    '".$DateofRecord."')";

$Depresult = $con->query($insert) or die($con->error.__LINE__);

closeID($con);

echo "Upgrade Insert Success!!! <br>";

echo '<a href="newrecord.php">Back to input forms</a>';      

?>

</body>
</html>