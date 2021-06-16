<?php

include('php_routines/drifter_php_routines.php');


$ArgosNumber = htmlspecialchars($_GET['ArgosNumber']);
$ReleaseDate = htmlspecialchars($_GET['ReleaseDate']);
$IsActive = htmlspecialchars($_GET['IsActive']);
$IsMooring = htmlspecialchars($_GET['IsMooring']);
$DeploymentWaters = htmlspecialchars($_GET['DeploymentWaters']);
$ReleaseLat = htmlspecialchars($_GET['ReleaseLat']);
$ReleaseLon = htmlspecialchars($_GET['ReleaseLon']);
$Comments = htmlspecialchars($_GET['Comments']);
$CruiseID = htmlspecialchars($_GET['CruiseID']);
$DrogueDepth = htmlspecialchars($_GET['DrogueDepth']);

//Connect to DB
$con = dbConnection('../db_configs/db_config_drifters.php');

$insert = "INSERT INTO `drifter_ids` (ArgosNumber, ReleaseDate, IsActive, IsMooring, DeploymentWaters, 
    ReleaseLat, ReleaseLon, Comments, CruiseID, DrogueDepth) VALUES ('".$ArgosNumber."',
    '".$ReleaseDate."','".$IsActive."','".$IsMooring."','".$DeploymentWaters."','".$ReleaseLat."',
    '".$ReleaseLon."','".$Comments."','".$CruiseID."','".$DrogueDepth."')";


$DrifterResult = $con->query($insert) or die($con->error.__LINE__);

echo "Insert Success!!! <br>";
echo '___'.date('Y-m-d G:i:s T').'___   '.PHP_EOL;

mysqli_close($con);


?>

