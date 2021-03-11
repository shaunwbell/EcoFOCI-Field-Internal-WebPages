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
//timecheck_prof DB add
/*
  `inst_id` varchar(11) NOT NULL DEFAULT 'IPS-5' COMMENT 'IPS-5',
  `serial_number` varchar(11) DEFAULT NULL COMMENT 'cannot be empty',
  `gps_time` time NOT NULL DEFAULT '00:00:00' COMMENT '00:00:00 gmt',
  `inst_time` time NOT NULL DEFAULT '00:00:00' COMMENT '00:00:00 gmt',
  `DateofRecord` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'yyyy-mm-dd 00:00:00 gmt',
  `notes` text,
*/

$inst_id = htmlspecialchars($_POST['inst_id']); 
$serial_number = htmlspecialchars($_POST['serial_number']);
$gps_time = htmlspecialchars($_POST['gps_time']);
$inst_time = htmlspecialchars($_POST['inst_time']);
$DateofRecord = htmlspecialchars($_POST['DateofRecord']);
$notes = htmlspecialchars($_POST['notes']);


//Connect to DB
$con = dbConnection();

//check for existance of MooringID and kill if found

$insert = "INSERT INTO `timecheck_iceprof` (inst_id, serial_number, gps_time, inst_time, 
    DateofRecord, notes) VALUES ('".$inst_id."','".$serial_number."','".$gps_time."','".$inst_time."',
    '".$DateofRecord."','".$notes."')";

$Depresult = $con->query($insert) or die($con->error.__LINE__);

closeID($con);

echo "Timecheck Insert Success!!! <br>";

echo '<a href="newrecord.php">Back to input forms</a>';      

?>

</body>
</html>