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
//software DB add
/*
  `software_version` varchar(11) NOT NULL DEFAULT '',
  `firmware_version` varchar(11) NOT NULL DEFAULT '',
  `DateUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `notes` text,
*/

$software_version = htmlspecialchars($_POST['software_version']);
$firmware_version = htmlspecialchars($_POST['firmware_version']);
$DateUpdated = htmlspecialchars($_POST['DateUpdated']);
$notes = htmlspecialchars($_POST['notes']);


//Connect to DB
$con = dbConnection();

//check for existance of MooringID and kill if found

$insert = "INSERT INTO `software_iceprof` (software_version, firmware_version, DateUpdated, notes 
    ) VALUES ('".$software_version."','".$firmware_version."','".$DateUpdated."','".$notes."')";

$Depresult = $con->query($insert) or die($con->error.__LINE__);

closeID($con);

echo "Software Insert Success!!! <br>";

echo '<a href="newrecord.php">Back to input forms</a>';      

?>

</body>
</html>