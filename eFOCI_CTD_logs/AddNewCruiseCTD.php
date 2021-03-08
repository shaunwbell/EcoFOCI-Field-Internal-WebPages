<?php

include('php_routines/cruise_php_routines.php');


//AddNewRecords

/*------------------------------------------------------------------------------------*/
//Cast DB add
/* DB structure
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Vessel` text NOT NULL COMMENT 'Full Name (e.g.Dyson)',
  `CruiseID` varchar(8) NOT NULL DEFAULT '' COMMENT 'ssYY-MM',
  `Project_Leg` text COMMENT 'leg1/leg2',
  `Project` text COMMENT 'project name',
  `StationNo_altname` text,
  `ConsecutiveCastNo` varchar(6) NOT NULL DEFAULT '' COMMENT 'CTD001',
  `LatitudeDeg` varchar(4) NOT NULL DEFAULT '' COMMENT '(+/N , -/S)',
  `LatitudeMin` float NOT NULL COMMENT 'decimal seconds',
  `LongitudeDeg` int(3) NOT NULL COMMENT '(+/W, -/E)',
  `LongitudeMin` float NOT NULL COMMENT 'decimal seconds',
  `GMTDay` int(2) NOT NULL COMMENT '0-31',
  `GMTMonth` int(2) NOT NULL COMMENT '0-12',
  `GMTYear` int(4) NOT NULL COMMENT 'yyyy',
  `GMTTime` time NOT NULL DEFAULT '00:00:00' COMMENT 'hh:mm:ss',
  `DryBulb` float NOT NULL COMMENT 'xx.xx',
  `RelativeHumidity` float NOT NULL COMMENT 'xxx %',
  `WetBulb` float NOT NULL COMMENT 'yy.yy',
  `Pressure` int(4) DEFAULT NULL COMMENT 'mb',
  `SeaState` varchar(4) DEFAULT NULL COMMENT 'not required',
  `Visibility` varchar(4) DEFAULT NULL COMMENT 'not required',
  `WindDir` int(3) NOT NULL DEFAULT '-999' COMMENT 'xxx (degrees)',
  `WindSpd` int(2) NOT NULL DEFAULT '-99' COMMENT 'xx (knots)',
  `CloudAmt` varchar(4) DEFAULT NULL COMMENT 'not required',
  `Type` varchar(4) DEFAULT NULL COMMENT 'not required',
  `Weather` varchar(4) DEFAULT NULL COMMENT 'not required',
  `BottomDepth` int(4) NOT NULL DEFAULT '-9999' COMMENT 'xxxx (meters)',
  `StationNameID` varchar(12) DEFAULT NULL COMMENT '5 characters usually',
  `MaxDepth` int(4) NOT NULL DEFAULT '-9999' COMMENT 'meters',
  `InstrumentSerialNos` text COMMENT 'id->SN - Press SN = 9tSN0772,',
  `Notes` text,
  `isMooringProfileCast` varchar(1) NOT NULL DEFAULT 'n' COMMENT 'y/n ',
  `FileName` text,
  `MooringID` varchar(12) DEFAULT NULL COMMENT 'mooringID if calibration cast',
  `NutrientBtlDepths` text,
  `OxygenBtlDepths` text,  
  `SalinityBtlDepths` text,
  `ChlorophyllBtlDepths` text  
  `WaterMassCode` varchar(1) NOT NULL DEFAULT 'G' COMMENT '(A)rctic, (G)ulf of Alaska, (B)ering Sea,\\n				  (S)helikof Strait, (P)uget Sound, (V)ents',
  `InstrumentType` varchar(20) NOT NULL DEFAULT 'SBE911plus' COMMENT 'CTD-DeckUnit Model',
*/


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
$con = dbConnection('../../db_config_cruisecastlogs.php');


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

