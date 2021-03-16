<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 
Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>Update Mooring Records</title>
</head>

<!-- php includes -->
<?php

include('php_routines/mooring_php_routines.php');

?>

<?php
//AddNewRecords
/* Databases are opened and closed each entry: this is redundant but in preparation of 
    conversion of routines into functions */

/*------------------------------------------------------------------------------------*/
//Deployment DB add
/*
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MooringID` varchar(10) NOT NULL,
  `Latitude` text,
  `Longitude` text,
  `DeploymentDepth` int(5) DEFAULT NULL,
  `CruiseNumber` text,
  `DeploymentDate` varchar(40) DEFAULT '' COMMENT 'local',
  `TimeofRelease` text COMMENT 'JD - GMT',
  `CTDcastNo` varchar(20) DEFAULT 'CTD000',
  `Timekeeper` text,
  `ChiefScientist` text,
  `Project` text,
  `DeploymentShip` varchar(20) DEFAULT NULL,
  `MagneticVariation` text,
  `PreLatitude` text,
  `PreLongitude` text,
  `PreDeploymentDepth` int(5) DEFAULT NULL,
*/

$MooringID = htmlspecialchars($_POST['MooringID']);
$CruiseNumber = htmlspecialchars($_POST['DeploymentCruiseNumber']);
$DeploymentDateTimeGMT = htmlspecialchars($_POST['DeploymentDateTimeGMT']);
if (empty($DeploymentDateTimeGMT)) { $DeploymentDateTimeGMT=stripslashes('null'); } else {$DeploymentDateTimeGMT="'".$DeploymentDateTimeGMT."'";}
//$TimeofRelease = htmlspecialchars($_POST['DeploymentToR']); now part of DateTimeGMT
$Latitude = htmlspecialchars($_POST['DeploymentLatitude']);
$Longitude = htmlspecialchars($_POST['DeploymentLongitude']);
$CTDcastNo = htmlspecialchars($_POST['DeploymentCTDcastNo']);
$DeploymentDepth = htmlspecialchars($_POST['DeploymentDepth']);
$DeploymentTimekeeper = htmlspecialchars($_POST['DeploymentTimekeeper']);
$ChiefScientist = htmlspecialchars($_POST['DeploymentChiefScientist']);
$PreLatitude = htmlspecialchars($_POST['PreDeploymentLatitude']);
$PreLongitude = htmlspecialchars($_POST['PreDeploymentLongitude']);
$EstimatedDepth = htmlspecialchars($_POST['EstimatedDepth']);
$DeploymentStatus = htmlspecialchars($_POST['DeploymentStatus']);
$EstimatedRecoveryDate = htmlspecialchars($_POST['EstimatedRecoveryDate']);
echo $EstimatedRecoveryDate.PHP_EOL;
if (empty($EstimatedRecoveryDate)) { $EstimatedRecoveryDate=stripslashes('null');} else {$EstimatedRecoveryDate="'".$EstimatedRecoveryDate."'";}

//Connect to DB
$con = dbConnection('../db_configs/db_config.php');


//check for existance of MooringID and kill if found

$insert = "UPDATE `MooringDeploymentLogs` SET MooringID = '".$MooringID."', CruiseNumber = '".$CruiseNumber."',
     DeploymentDateTimeGMT = ".$DeploymentDateTimeGMT.", 
     Latitude = '".$Latitude."', Longitude = '".$Longitude."', CTDcastNo = '".$CTDcastNo."',
     DeploymentDepth = '".$DeploymentDepth."', Timekeeper = '".$DeploymentTimekeeper."', 
     ChiefScientist = '".$ChiefScientist."',
     PreLatitude = '".$PreLatitude."', PreLongitude = '".$PreLongitude."',
     EstimatedDepth = '".$EstimatedDepth."',
     DeploymentStatus = '".$DeploymentStatus."',
     EstimatedRecoveryDate = ".$EstimatedRecoveryDate." WHERE `MooringID`='".$MooringID."'";
     
$Depresult = $con->query($insert) or die($con->error.__LINE__);
echo $insert;

echo "Deployment Insert Success!!! <br>";
      
closeID($con);

/*------------------------------------------------------------------------------------*/
//Recovery DB add
/*
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CruiseNumber` text,
  `MooringID` varchar(10) NOT NULL DEFAULT 'unknown',
  `RecoveryDate` text COMMENT 'local',
  `DeploymentDepth` int(5) DEFAULT NULL,
  `TimeofRelease` text COMMENT 'JD - GMT',
  `Latitude` text,
  `Longitude` text,
  `CTDcastNo` varchar(20) DEFAULT '',
  `Timekeeper` text,
  `ChiefScientist` text,
  `RecoveryShip` varchar(20) DEFAULT NULL,
*/

$MooringID = htmlspecialchars($_POST['MooringID']);
$CruiseNumber = htmlspecialchars($_POST['RecoveryCruiseNumber']);
$RecoveryDateTimeGMT = htmlspecialchars($_POST['RecoveryDateTimeGMT']);
if ($RecoveryDateTimeGMT == '') { $RecoveryDateTimeGMT=stripslashes('null');} else {$RecoveryDateTimeGMT="'".$RecoveryDateTimeGMT."'";}
$Latitude = htmlspecialchars($_POST['RecoveryLatitude']);
$Longitude = htmlspecialchars($_POST['RecoveryLongitude']);
$CTDcastNo = htmlspecialchars($_POST['RecoveryCTDcastNo']);
//$DeploymentDepth = htmlspecialchars($_POST['RecoveryDepth']); deployment depth and estimated deployment depth now only parameters kept
$Timekeeper = htmlspecialchars($_POST['RecoveryTimekeeper']);
$ChiefScientist = htmlspecialchars($_POST['RecoveryChiefScientist']);

//Connect to DB
$con = dbConnection('../db_configs/db_config.php');


$insert = "UPDATE `MooringRecoveryLogs` SET MooringID = '".$MooringID."', CruiseNumber = '".$CruiseNumber."',
     RecoveryDateTimeGMT = ".$RecoveryDateTimeGMT.", 
     Latitude = '".$Latitude."', Longitude = '".$Longitude."', CTDcastNo = '".$CTDcastNo."',
     DeploymentDepth = '".$DeploymentDepth."', Timekeeper = '".$Timekeeper."', 
     ChiefScientist = '".$ChiefScientist."' WHERE `MooringID`='".$MooringID."'";
echo $insert;

$Recresult = $con->query($insert) or die($con->error.__LINE__);

echo "Recovery Insert Success!!! <br>";
      
closeID($con);

/*------------------------------------------------------------------------------------*/
//Mooring Notes DB add
/*
  `MooringID` varchar(8) NOT NULL DEFAULT '',
  `Comments` text,
  `ReleaseBattNew` varchar(1) DEFAULT 'y' COMMENT 'y/n',
  `ReleaseBattMonths` int(3) DEFAULT '0',
  `UserSignature` text
*/



//Connect to DB
$con = new mysqli("localhost","pythonuser","e43mqS4fusEaGJLE", 'EcoFOCI');

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//Get posted variables
$MooringID = htmlspecialchars($_POST['MooringID']);
$Comments = mysqli_real_escape_string($con, $_POST['Comments'] );
$Release = htmlspecialchars($_POST['Release']);
$ReleaseBattMonths = htmlspecialchars($_POST['release_batt']);
$UserSignature = htmlspecialchars($_POST['Recorder']);

$insert = "UPDATE `MooringDeploymentNotes` SET MooringID = '".$MooringID."', Comments = '".$Comments."',
    ReleaseBattNew = '".$Release."', ReleaseBattMonths = '".$ReleaseBattMonths."',
    UserSignature = '".$UserSignature."' WHERE `MooringID`='".$MooringID."'";

$PreDeploymentNotesresult = $con->query($insert) or die($con->error.__LINE__);

echo "Comments Insert Success!!! <br>";

closeID($con);


/*------------------------------------------------------------------------------------*/
//Instrument Package DB add
/*
  `Depth` int(4) DEFAULT NULL COMMENT 'In meters - use -999 for N/A',
  `InstType` text,
  `SerialNo` varchar(15) DEFAULT NULL,
  `Deployed` varchar(1) DEFAULT 'T',
  `Recovered` varchar(1) DEFAULT 'T',
  `Notes` text DEFAULT NULL,
  `TimeOnJD` int(3) DEFAULT NULL,
  `TimeOffJD` int(3) DEFAULT NULL,
  `TimeOnGMT` time DEFAULT '00:00:00',
  `TimeOffGMT` time DEFAULT '00:00:00',
  `MooringID` varchar(8) NOT NULL DEFAULT '',
  `RecordAdded` timestamp NULL DEFAULT NULL,
*/

//Connect to DB
$con = dbConnection('../db_configs/db_config.php');


/* an unknown number of instruments can be passed (but I max it out at 10) */
$MooringID = htmlspecialchars($_POST['MooringID']);

//Loop through possible entries
$inst = ($_POST['inst']);

//update existing records
foreach($inst as $row => $innerArray){
    if (!empty($innerArray['id'])) {
        
        $id = htmlspecialchars($innerArray['id']);
        $Depth = htmlspecialchars($innerArray['depth']);
        $ActualDepth = htmlspecialchars($innerArray['ActualDepth']);
        $InstType = htmlspecialchars($innerArray['InstType']);
        $PreDeploymentNotes = htmlspecialchars($innerArray['PreDeploymentNotes']);
        $PostDeploymentNotes = htmlspecialchars($innerArray['PostDeploymentNotes']);
        $PreDeploymentNotes = htmlspecialchars($innerArray['PreDeploymentNotes']);
        $SerialNo = htmlspecialchars($innerArray['serialnum']);
        $Prepped = htmlspecialchars($innerArray['Prepped']);
        $Deployed = htmlspecialchars($innerArray['deployed']);
        $Recovered = htmlspecialchars($innerArray['recovered']);
        $DateTimeOnGMT = "'".htmlspecialchars($innerArray['DateTimeOnGMT'])."'";
        if (($innerArray['DateTimeOnGMT']) == '') { $DateTimeOnGMT=stripslashes('null'); }
        $DateTimeOffGMT = "'".htmlspecialchars($innerArray['DateTimeOffGMT'])."'";
        if (($innerArray['DateTimeOffGMT']) == '') { $DateTimeOffGMT=stripslashes('null'); }


        $insert = "UPDATE `MooringDeployedInstruments` SET MooringID = '".$MooringID."', Depth = '".$Depth."', 
                  ActualDepth = '".$ActualDepth."', InstType = '".$InstType."', Prepped = '".$Prepped."', Deployed = '".$Deployed."', PreDeploymentNotes = '".$PreDeploymentNotes."',
                  PostDeploymentNotes = '".$PostDeploymentNotes."', Recovered = '".$Recovered."', DateTimeOnGMT = ".$DateTimeOnGMT.",
                  DateTimeOffGMT = ".$DateTimeOffGMT.", InstID = '".$InstType.' '.$SerialNo."', SerialNo = '".$SerialNo."' 
                  WHERE `id`='".$id."'";
        echo $insert;
        $Instrumentresult = $con->query($insert) or die($con->error.__LINE__);

        echo "Instrument ".$innerArray['InstType']." Update Success!!! <br>";
    }

//Insert new records

    elseif ((!empty($innerArray['InstType'])) and empty($innerArray['id'])) {
        
        $Depth = htmlspecialchars($innerArray['depth']);
        $ActualDepth = htmlspecialchars($innerArray['ActualDepth']);
        $InstType = htmlspecialchars($innerArray['InstType']);
        $PreDeploymentNotes = htmlspecialchars($innerArray['PreDeploymentNotes']);
        $PostDeploymentNotes = htmlspecialchars($innerArray['PostDeploymentNotes']);
        $SerialNo = htmlspecialchars($innerArray['serialnum']);
        $Prepped = htmlspecialchars($innerArray['Prepped']);
        $Deployed = htmlspecialchars($innerArray['deployed']);
        $Recovered = htmlspecialchars($innerArray['recovered']);
        $DateTimeOnGMT =  "'".htmlspecialchars($innerArray['DateTimeOnGMT'])."'";
        if (($innerArray['DateTimeOnGMT']) == '') { $DateTimeOnGMT=stripslashes('null'); }
        $DateTimeOffGMT = "'".htmlspecialchars($innerArray['DateTimeOffGMT'])."'";
        if (($innerArray['DateTimeOffGMT']) == '') { $DateTimeOffGMT=stripslashes('null'); }


        $insert = "INSERT INTO `MooringDeployedInstruments` (MooringID, Depth, ActualDepth, InstType, PreDeploymentNotes, PostDeploymentNotes, SerialNo, Prepped, Deployed, Recovered,
            DateTimeOnGMT, DateTimeOffGMT, InstID) SELECT '".$MooringID."','".$Depth."','".$ActualDepth."','".$InstType."','".$PreDeploymentNotes."','".$PostDeploymentNotes."',
            '".$SerialNo."','".$Prepped."','".$Deployed."','".$Recovered."',".$DateTimeOnGMT.",".$DateTimeOffGMT.",
            '".$InstType.' '.$SerialNo."' FROM dual WHERE NOT EXISTS (SELECT * FROM `MooringDeployedInstruments` WHERE `MooringID`='".$MooringID."' AND `SerialNo` = '".$SerialNo."' AND `InstType`='".$InstType."'AND `Depth`='".$Depth."')";

        $Instrumentresult = $con->query($insert) or die($con->error.__LINE__);

        echo "Instrument ".$innerArray['InstType']." Insert Success!!! <br>";
    }
}
closeID($con);

?>

<a href="mooring_landing.php">Main Records</a>

</body>
</html>