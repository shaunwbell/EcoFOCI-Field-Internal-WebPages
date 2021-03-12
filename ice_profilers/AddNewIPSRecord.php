<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 
Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>New IPS-5 Deployment/Recovery Record</title>
</head>

<?php

include('php_routines/iceprofiler_php_routines.php');


//AddNewRecords


$IPSSerialNo = htmlspecialchars($_POST['IPSSerialNo']);
$DeployMooringID = htmlspecialchars($_POST['DeployMooringID']);
$ProposedDepth = htmlspecialchars($_POST['ProposedDepth']);
$FirmwareVersion = htmlspecialchars($_POST['FirmwareVersion']);
$NewBattPack = htmlspecialchars($_POST['NewBattPack']);
$BattSerialNo = htmlspecialchars($_POST['BattSerialNo']);
$BattManDate = htmlspecialchars($_POST['BattManDate']);
$BattMainVolt = htmlspecialchars($_POST['BattMainVolt']);
$BattTxVolt = htmlspecialchars($_POST['BattTxVolt']);
$FourPinConn = htmlspecialchars($_POST['FourPinConn']);
$GroundWireConn = htmlspecialchars($_POST['GroundWireConn']);
$Dessicant = htmlspecialchars($_POST['Dessicant']);
$NewWatchBatt = htmlspecialchars($_POST['NewWatchBatt']);
$NewMemoryCard = htmlspecialchars($_POST['NewMemoryCard']);
$MemBrand = htmlspecialchars($_POST['MemBrand']);
$MemSize = htmlspecialchars($_POST['MemSize']);
$MemFormattedByInst = htmlspecialchars($_POST['MemFormattedByInst']);
$RealTimeClockSet = htmlspecialchars($_POST['RealTimeClockSet']);
$SetTime = htmlspecialchars($_POST['SetTime']);
$SetDate = htmlspecialchars($_POST['SetDate']);
$DeploymentFileUploaded = htmlspecialchars($_POST['DeploymentFileUploaded']);
$DeploymentFileName = htmlspecialchars($_POST['DeploymentFileName']);
$NewORings = htmlspecialchars($_POST['NewORings']);
$TopBoltsSecured = htmlspecialchars($_POST['TopBoltsSecured']);
$PurgePlugSecured = htmlspecialchars($_POST['PurgePlugSecured']);
$SacrificialZincsDeploy = htmlspecialchars($_POST['SacrificialZincsDeploy']);
$ZincTransducerHeadDeploy = htmlspecialchars($_POST['ZincTransducerHeadDeploy']);
$ZincBottomDeploy = htmlspecialchars($_POST['ZincBottomDeploy']);
$ZincConductDeploy = htmlspecialchars($_POST['ZincConductDeploy']);
$PressInletOil = htmlspecialchars($_POST['PressInletOil']);
$InstrumSetDeploy = htmlspecialchars($_POST['InstrumSetDeploy']);
$InstrumDateSet = htmlspecialchars($_POST['InstrumDateSet']);
$DummyPlugDeploy = htmlspecialchars($_POST['DummyPlugDeploy']);
$SetupPersonInitials = htmlspecialchars($_POST['SetupPersonInitials']);
$RecoveryMooringID = htmlspecialchars($_POST['RecoveryMooringID']);
$ActualDepth = htmlspecialchars($_POST['ActualDepth']);
$PurgePlugRelease = htmlspecialchars($_POST['PurgePlugRelease']);
$PurgePlugReleasePressurized = htmlspecialchars($_POST['PurgePlugReleasePressurized']);
$RecBattCheck = htmlspecialchars($_POST['RecBattCheck']);
$RecBattCheckMainVolt = htmlspecialchars($_POST['RecBattCheckMainVolt']);
$RecBattCheckTxVolt = htmlspecialchars($_POST['RecBattCheckTxVolt']);
$RecMemCardCheck = htmlspecialchars($_POST['RecMemCardCheck']);
$RecMemCardUsed = htmlspecialchars($_POST['RecMemCardUsed']);
$RealTimeClockCheck = htmlspecialchars($_POST['RealTimeClockCheck']);
$InstrCheckTimeDate = htmlspecialchars($_POST['InstrCheckTimeDate']);
$ActualCheckTimeDate = htmlspecialchars($_POST['ActualCheckTimeDate']);
$DataDownloaded = htmlspecialchars($_POST['DataDownloaded']);
$DateDownloaded = htmlspecialchars($_POST['DateDownloaded']);
$DataDateRange = htmlspecialchars($_POST['DataDateRange']);
$SacrificialZincsRecovery = htmlspecialchars($_POST['SacrificialZincsRecovery']);
$ZincTransducerHeadRecovery = htmlspecialchars($_POST['ZincTransducerHeadRecovery']);
$ZincBottomRecovery = htmlspecialchars($_POST['ZincBottomRecovery']);
$DummyPlugRecovery = htmlspecialchars($_POST['DummyPlugRecovery']);
$RecoveryPersonInitials = htmlspecialchars($_POST['RecoveryPersonInitials']);
$Comments = htmlspecialchars($_POST['Comments']);

//Connect to DB

$con = dbConnection('../db_configs/db_config.php');

$insert = "INSERT INTO `ips5_operations_checksheet` (IPSSerialNo, DeployMooringID, ProposedDepth, 
            FirmwareVersion, NewBattPack, BattSerialNo, BattManDate, BattMainVolt, BattTxVolt, 
            FourPinConn, GroundWireConn, Dessicant, NewWatchBatt, NewMemoryCard, MemBrand, MemSize, 
            MemFormattedByInst, RealTimeClockSet, SetTime, SetDate, DeploymentFileUploaded, 
            DeploymentFileName, NewORings, TopBoltsSecured, PurgePlugSecured, SacrificialZincsDeploy, 
            ZincTransducerHeadDeploy, ZincBottomDeploy, ZincConductDeploy, PressInletOil, 
            InstrumSetDeploy, InstrumDateSet, DummyPlugDeploy, SetupPersonInitials, RecoveryMooringID, 
            ActualDepth, PurgePlugRelease, PurgePlugReleasePressurized, RecBattCheck, 
            RecBattCheckMainVolt, RecBattCheckTxVolt, RecMemCardCheck, RecMemCardUsed, 
            RealTimeClockCheck, InstrCheckTimeDate, ActualCheckTimeDate, DataDownloaded, 
            DateDownloaded, DataDateRange, SacrificialZincsRecovery, ZincTransducerHeadRecovery, 
            ZincBottomRecovery, DummyPlugRecovery, RecoveryPersonInitials, Comments) VALUES 
            ('".$IPSSerialNo."', '".$DeployMooringID."', '".$ProposedDepth."', '".$FirmwareVersion."', 
            '".$NewBattPack."', '".$BattSerialNo."', '".$BattManDate."', '".$BattMainVolt."', 
            '".$BattTxVolt."', '".$FourPinConn."', '".$GroundWireConn."', '".$Dessicant."', 
            '".$NewWatchBatt."', '".$NewMemoryCard."', '".$MemBrand."', '".$MemSize."', 
            '".$MemFormattedByInst."', '".$RealTimeClockSet."', '".$SetTime."', '".$SetDate."', 
            '".$DeploymentFileUploaded."', '".$DeploymentFileName."', '".$NewORings."', 
            '".$TopBoltsSecured."', '".$PurgePlugSecured."', '".$SacrificialZincsDeploy."', 
            '".$ZincTransducerHeadDeploy."', '".$ZincBottomDeploy."', '".$ZincConductDeploy."', 
            '".$PressInletOil."', '".$InstrumSetDeploy."', '".$InstrumDateSet."', '".$DummyPlugDeploy."', 
            '".$SetupPersonInitials."', '".$RecoveryMooringID."', '".$ActualDepth."', 
            '".$PurgePlugRelease."', '".$PurgePlugReleasePressurized."', '".$RecBattCheck."', 
            '".$RecBattCheckMainVolt."', '".$RecBattCheckTxVolt."', '".$RecMemCardCheck."', 
            '".$RecMemCardUsed."', '".$RealTimeClockCheck."', '".$InstrCheckTimeDate."', 
            '".$ActualCheckTimeDate."', '".$DataDownloaded."', '".$DateDownloaded."', 
            '".$DataDateRange."', '".$SacrificialZincsRecovery."', '".$ZincTransducerHeadRecovery."', 
            '".$ZincBottomRecovery."', '".$DummyPlugRecovery."', '".$RecoveryPersonInitials."', 
            '".$Comments."')";
echo $insert;
$result = $con->query($insert) or die($con->error.__LINE__);

echo "IPS Record inserted in to Database Successfully!!! <br>";

closeID($con);


?>


<a href="IPSChecklistForm.html">Add Another Record</a>

</body>
</html>

