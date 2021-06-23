<?php

include('php_routines/cruise_php_routines.php');

$Vessel = htmlspecialchars($_GET['Vessel']);
$CruiseID = htmlspecialchars($_GET['CruiseID']);
$Project_Leg = htmlspecialchars($_GET['Project_Leg']);
$Project = htmlspecialchars($_GET['Project']);
$UniqueCruiseID = htmlspecialchars($_GET['UniqueCruiseID']);
$FileName = htmlspecialchars($_GET['FileName']);
$StationNo_altname = htmlspecialchars($_GET['StationNo_altname']);
$ConsecutiveCastNo = htmlspecialchars($_GET['ConsecutiveCastNo']);
$LatitudeDeg = htmlspecialchars($_GET['LatitudeDeg']);
$LatitudeMin = htmlspecialchars($_GET['LatitudeMin']);
$LongitudeDeg = htmlspecialchars($_GET['LongitudeDeg']);
$LongitudeMin = htmlspecialchars($_GET['LongitudeMin']);
$GMTDay = htmlspecialchars($_GET['GMTDay']);
$GMTMonth = htmlspecialchars($_GET['GMTMonth']);
$GMTYear = htmlspecialchars($_GET['GMTYear']);
$GMTTime = htmlspecialchars($_GET['GMTTime']);
$DryBulb = htmlspecialchars($_GET['DryBulb']);
$RelativeHumidity = htmlspecialchars($_GET['RelativeHumidity']);
$WetBulb = htmlspecialchars($_GET['WetBulb']);
$Pressure = htmlspecialchars($_GET['Pressure']);
$SeaState = htmlspecialchars($_GET['SeaState']);
$Visibility = htmlspecialchars($_GET['Visibility']);
$WindDir = htmlspecialchars($_GET['WindDir']);
$WindSpd = htmlspecialchars($_GET['WindSpd']);
$CloudAmt = htmlspecialchars($_GET['CloudAmt']);
$CloudType = htmlspecialchars($_GET['CloudType']);
$Weather = htmlspecialchars($_GET['Weather']);
$SurfaceTemp = htmlspecialchars($_GET['SurfaceTemp']);
$BottomDepth = htmlspecialchars($_GET['BottomDepth']);
$StationNameID = htmlspecialchars($_GET['StationNameID']);
$MaxDepth = htmlspecialchars($_GET['MaxDepth']);
$InstrumentSerialNos = htmlspecialchars($_GET['InstrumentSerialNos']);
$Notes = htmlspecialchars($_GET['Notes']);
$isMooringProfileCast = htmlspecialchars($_GET['isMooringProfileCast']);
$MooringID = htmlspecialchars($_GET['MooringID']);
$NutrientBtlNiskinNo = htmlspecialchars($_GET['NutrientBtlNiskinNo']);
$NutrientBtlNumbers = htmlspecialchars($_GET['NutrientBtlNumbers']);  
$SalinityBtlNiskinNo = htmlspecialchars($_GET['SalinityBtlNiskinNo']);
$SalinityBtlNumbers = htmlspecialchars($_GET['SalinityBtlNumbers']);
$OxygenBtlNiskinNo = htmlspecialchars($_GET['OxygenBtlNiskinNo']);
$OxygenBtlNumbers = htmlspecialchars($_GET['OxygenBtlNumbers']);
$ChlorophyllBtlNiskinNo = htmlspecialchars($_GET['ChlorophyllBtlNiskinNo']);
$ChlorophyllBtlVolumes = htmlspecialchars($_GET['ChlorophyllBtlVolumes']);
$WaterMassCode = htmlspecialchars($_GET['WaterMassCode']);
$InstrumentType = htmlspecialchars($_GET['InstrumentType']);

//Connect to DB
$con = dbConnection('../db_configs/db_config_cruisecastlogs.php');


//SQL input
$sql = "INSERT INTO `CruiseCastLogs` (Vessel, CruiseID, Project_Leg, Project, UniqueCruiseID, FileName, 
    StationNo_altname, ConsecutiveCastNo, LatitudeDeg, LatitudeMin, LongitudeDeg, LongitudeMin,
    GMTDay, GMTMonth, GMTYear, GMTTime, DryBulb, RelativeHumidity, WetBulb, Pressure, SeaState,
    Visibility, WindDir, WindSpd, CloudAmt, CloudType, Weather, SurfaceTemp, BottomDepth,
    StationNameID, MaxDepth, InstrumentSerialNos, Notes, isMooringProfileCast,
    MooringID, NutrientBtlNiskinNo, NutrientBtlNumbers, OxygenBtlNiskinNo, OxygenBtlNumbers, 
    SalinityBtlNiskinNo, SalinityBtlNumbers, ChlorophyllBtlNiskinNo, ChlorophyllBtlVolumes,
    WaterMassCode, InstrumentType) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
    ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

//Prepare insert statements
if ( !$stmt = $con->prepare($sql)) {
   echo "Prepare Error: ($con->errno) $con->error".PHP_EOL;
}
if ( !$stmt->bind_param("ssssssssididisisdidissidsssdisissssssssssssss",$Vessel,$CruiseID,$Project_Leg,$Project,$UniqueCruiseID,$FileName,$StationNo_altname,$ConsecutiveCastNo,$LatitudeDeg,$LatitudeMin,$LongitudeDeg,$LongitudeMin,$GMTDay,$GMTMonth,$GMTYear,$GMTTime,$DryBulb,$RelativeHumidity,$WetBulb,$Pressure,$SeaState,$Visibility,$WindDir,$WindSpd,$CloudAmt,$CloudType,$Weather,$SurfaceTemp,$BottomDepth,$StationNameID,$MaxDepth,$InstrumentSerialNos,$Notes,$isMooringProfileCast,$MooringID,$NutrientBtlNiskinNo,$NutrientBtlNumbers,$OxygenBtlNiskinNo,$OxygenBtlNumbers,$SalinityBtlNiskinNo,$SalinityBtlNumbers,$ChlorophyllBtlNiskinNo,$ChlorophyllBtlVolumes,$WaterMassCode,$InstrumentType)) {
  echo "Binding Parameter Error: ($con->errno) $con->error".PHP_EOL;
}
if ( !$stmt->execute()) {
  echo "Execute Error: ($con->errno) $con->error".PHP_EOL;
}

if ($stmt->affected_rows === 0) {
 echo 'No rows updated'.PHP_EOL;
} else {  
 echo "Cast ".$ConsecutiveCastNo." Insert Success!!! <br>";
 echo '___'.date('Y-m-d G:i:s T').'___   '.PHP_EOL;
}

$stmt->close();
mysqli_close($con);


?>

