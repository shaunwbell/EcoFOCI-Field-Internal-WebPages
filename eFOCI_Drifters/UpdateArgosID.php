<?php

include('php_routines/drifter_php_routines.php');


$ArgosNumber = htmlspecialchars($_GET['ArgosNumber']);
$ReleaseDate = htmlspecialchars($_GET['ReleaseDate']);
$IsActive = htmlspecialchars($_GET['IsActive']);
$IsMooring = htmlspecialchars($_GET['IsMooring']);
$RecoveryDate = htmlspecialchars($_GET['RecoveryDate']);
$ReleaseLat = htmlspecialchars($_GET['ReleaseLat']);
$ReleaseLon = htmlspecialchars($_GET['ReleaseLon']);
$Comments = htmlspecialchars($_GET['Comments']);
$CruiseID = htmlspecialchars($_GET['CruiseID']);
$DrogueDepth = htmlspecialchars($_GET['DrogueDepth']);

//Connect to DB
$con = dbConnection('../db_config/db_config_drifters.php');


$insert = "UPDATE `drifter_ids` SET ReleaseDate='".$ReleaseDate."', RecoveryDate='".$RecoveryDate.
    "', IsActive='".$IsActive."', IsMooring='".$IsMooring."', ReleaseLat='".$ReleaseLat.
    "', ReleaseLon='".$ReleaseLon."', Comments='".$Comments."', CruiseID='".$CruiseID.
    "', DrogueDepth='".$DrogueDepth."'"' WHERE `ArgosNumber`='".$ArgosNumber."'";

$DrifterResult = $con->query($insert) or die($con->error.__LINE__);

echo "Update Success!!! <br>";
echo '___'.date('Y-m-d G:i:s T').'___   '.PHP_EOL;

mysqli_close($con);


?>

