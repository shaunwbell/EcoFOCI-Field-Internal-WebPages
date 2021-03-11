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
//inst_prof DB add
/*
  `inst_id` varchar(11) NOT NULL DEFAULT 'IPS-5' COMMENT 'IPS-5',
  `serial_number` varchar(11) NOT NULL DEFAULT '' COMMENT 'Cannot be empty',
  `original_firmware_version` varchar(11) DEFAULT NULL COMMENT 'Vx.x',
  `purchase_date` date NOT NULL DEFAULT '0000-00-00' COMMENT 'yyyy-mm-dd',
  `notes` text,
  `isactive` varchar(1) NOT NULL DEFAULT 'y' COMMENT 'y/n',
*/

$inst_id = htmlspecialchars($_POST['InstID']); 
$serial_number = htmlspecialchars($_POST['SerialNo']); 
$original_firmware_version = htmlspecialchars($_POST['original_firmware_version']);
$purchase_date = htmlspecialchars($_POST['purchase_date']);
$notes = htmlspecialchars($_POST['comments']);
$isactive = htmlspecialchars($_POST['isactive']);


//Connect to DB
$con = dbConnection();

//check for existance of MooringID and kill if found

$insert = "INSERT INTO `inst_iceprof` (InstID, SerialNo, original_firmware_version, purchase_date, 
    comments, isactive) VALUES ('".$inst_id."','".$serial_number."','".$original_firmware_version."','".$purchase_date."',
    '".$notes."','".$isactive."')";

echo $insert;

$Depresult = $con->query($insert) or die($con->error.__LINE__);

closeID($con);

echo "Instrument Insert Success!!! <br>";

echo '<a href="newrecord.php">Back to input forms</a>';      

?>

</body>
</html>