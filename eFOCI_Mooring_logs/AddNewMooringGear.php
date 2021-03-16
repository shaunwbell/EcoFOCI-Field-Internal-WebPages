<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 
Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>New Physical Mooring Gear</title>
</head>

<?php

include('php_routines/mooring_php_routines.php');


//AddNewRecords



$Date = htmlspecialchars($_POST['Date']);
$shackle_size = htmlspecialchars($_POST['shackle_size']);
$gear_type = htmlspecialchars($_POST['gear_type']);
$gear_status = htmlspecialchars($_POST['gear_status']);
$gear_count = htmlspecialchars($_POST['gear_count']);
$gear_action = htmlspecialchars($_POST['gear_action']);
$PreDeploymentNotes = htmlspecialchars($_POST['PreDeploymentNotes']);


//Connect to DB

$con = dbConnection('../db_configs/db_config_inst.php');

$insert = "INSERT INTO `hardware_and_cages` (Date, shackle_size, gear_type, gear_status, 
          gear_count, gear_action, Notes) VALUES ('".$Date."','".$shackle_size.
          "','".$gear_type."','".$gear_status."','".$gear_count."','".$gear_action."','".$PreDeploymentNotes."')";
echo $insert;
$result = $con->query($insert) or die($con->error.__LINE__);

echo "Mooring Gear Update Insert Success!!! <br>";

closeID($con);


?>


<a href="equipment_out.php">Modify Another Record</a>

</body>
</html>