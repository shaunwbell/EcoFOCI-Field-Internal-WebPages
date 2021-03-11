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
//cal_prof DB add
/*
  `inst_id` varchar(11) NOT NULL DEFAULT 'IPS-5' COMMENT 'IPS-5',
  `serial_number` varchar(11) DEFAULT NULL COMMENT 'cannot be empty',
  `caltype` varchar(11) DEFAULT NULL COMMENT 'calcheck/calnew',
  `DateofRecord` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'yyyy-mm-dd hh:mm:ss UTC',
  `notes` text,
*/

$inst_id = htmlspecialchars($_POST['InstID']);
$serial_number = htmlspecialchars($_POST['SerialNo']);
$caltype = htmlspecialchars($_POST['caltype']);
$DateofRecord = htmlspecialchars($_POST['CalDate']);
$notes = htmlspecialchars($_POST['comments']);
$calfactors = htmlspecialchars($_POST['calfactors']);


//Connect to DB
$con = dbConnection();

//check for existance of MooringID and kill if found

$insert = "INSERT INTO `cal_iceprof` (InstID, SerialNo, caltype, CalDate, 
    comments, calfactors) VALUES ('".$inst_id."','".$serial_number."','".$caltype."','".$DateofRecord."',
    '".$notes."','".$calfactors."')";

$Depresult = $con->query($insert) or die($con->error.__LINE__);

closeID($con);

echo "Calibration Insert Success!!! <br>";

echo '<a href="newrecord.php">Back to input forms</a>';      

?>

</body>
</html>