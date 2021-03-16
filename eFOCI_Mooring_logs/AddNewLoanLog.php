<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 
Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>Update Loan/Repair Records</title>
</head>

<?php

include('php_routines/mooring_php_routines.php');


//AddNewRecords
/* Databases are opened and closed each entry: this is redundant but in preparation of 
    conversion of routines into functions */

/*------------------------------------------------------------------------------------*/
// Calibration Records Add - not all fields are added from the form
/*
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `InstID` varchar(30) NOT NULL,
  `Instrument` varchar(20) NOT NULL DEFAULT '',
  `SerialNo` varchar(10) NOT NULL DEFAULT '',
  `Comments` text,
  `Location` varchar(40) NOT NULL DEFAULT '',
  `DateDeployed` date NOT NULL DEFAULT '0000-00-00',
  `DateReceived` date NOT NULL DEFAULT '0000-00-00',
  `Model` varchar(40) DEFAULT NULL,
*/


$InstID = htmlspecialchars($_POST['InstID']);
$Instrument = htmlspecialchars($_POST['Instrument']);
$SerialNo = htmlspecialchars($_POST['SerialNo']);
$Comments = htmlspecialchars($_POST['Comments']);
$Location = htmlspecialchars($_POST['Location']);
$DateDeployed = htmlspecialchars($_POST['DateDeployed']);
$DateReceived = htmlspecialchars($_POST['DateReceived']);
$Model = htmlspecialchars($_POST['Model']);
$POCemail = htmlspecialchars($_POST['POCemail']);


//Connect to DB

$con = dbConnection('../db_configs/db_config.php');

$insert = "INSERT INTO `InstrumentsOnLoan_OnRepair` (InstID, Instrument, SerialNo, Comments, 
          Location, DateDeployed, DateReceived, Model, POCemail) VALUES ('".$InstID."','".$Instrument.
          "','".$SerialNo."','".$Comments."','".$Location."','".$DateDeployed."','".$DateReceived.
          "','".$Model."','".$POCemail."')";
echo $insert;
$result = $con->query($insert) or die($con->error.__LINE__);

echo "Instrument Log Insert Success!!! <br>";

closeID($con);


?>


<a href="equipment_out.php">Modify Another Record</a>

</body>
</html>