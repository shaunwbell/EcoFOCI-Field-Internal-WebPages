<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 
Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" type="text/css" href="css/reports.css" />
<title>Form Input Data</title>
</head>

<!-- php includes -->
<?php

include('php_routines/mooring_php_routines.php');

//mooring_record_update.php

$MooringID = htmlspecialchars($_GET['mooringupdate_id']);
//Connect to DB
$con = dbConnection('../db_configs/db_config.php');


$query = "SELECT * FROM `MooringDeploymentLogs` WHERE `MooringID`='".$MooringID."'";
$depresult = $con->query($query) or die($con->error.__LINE__);
/* associative array */
$deploy = $depresult->fetch_array(MYSQLI_BOTH);

$query = "SELECT * FROM `MooringRecoveryLogs` WHERE `MooringID`='".$MooringID."'";
$recresult = $con->query($query) or die($con->error.__LINE__);
/* associative array */
$recovery = $recresult->fetch_array(MYSQLI_BOTH);

$query = "SELECT * FROM `MooringDeploymentNotes` WHERE `MooringID`='".$MooringID."'";
$PreDeploymentNotesresult = $con->query($query) or die($con->error.__LINE__);
/* associative array */
$PreDeploymentNotes = $PreDeploymentNotesresult->fetch_array(MYSQLI_BOTH);

$query = "SELECT * FROM `MooringDeployedInstruments` WHERE `MooringID`='".$MooringID."' ORDER BY `Depth`";
$result = $con->query($query) or die($con->error.__LINE__);
/* associative array */
$instrument = array();
while($row = $result->fetch_array(MYSQLI_BOTH)) {
    $instrument[] = $row;
    }
closeID($con);
?>

<body>


<div id="container-wrap">
<div id="content-wrap">
    <div id="container">

    <form method="post" action="UpdateMooringRecords.php" id="usrinput">
    
    <div id="header"> <h3>Records for Mooring: <?php echo $MooringID ?> </h3>
    <h4>alternate name:<?php echo $deploy["HistoricMooringID"] ?> </h4></div>
    <input type="hidden" name="MooringID" id="hiddenField" value="<?php echo $MooringID ?>" />
    
    <!-- start form -->
    <div id="MooringDetails"> 
    <div id="Deployment" > <h4 class="uline">Deployment </h4><br> 
    Cruise Number: <input type="text" name="DeploymentCruiseNumber" size="15"  value="<?php echo $deploy["CruiseNumber"] ?>" class="right"> <br><br>
    Deployment Date/Time (GMT):<input type="text" name="DeploymentDateTimeGMT" size="15" value="<?php echo $deploy["DeploymentDateTimeGMT"] ?>" class="right"> <br><br>
    GPS latitude:<input type="text" name="DeploymentLatitude" size="15" value="<?php echo $deploy["Latitude"] ?>" class="right"> <br><br>
    GPS longitude:<input type="text" name="DeploymentLongitude" size="15" value="<?php echo $deploy["Longitude"] ?>" class="right"> <br><br> 
    CTD cast no:<input type="text" name="DeploymentCTDcastNo" size="15" value="<?php echo $deploy["CTDcastNo"] ?>" class="right"> <br><br> 
    Actual Deployment depth:<input type="text" name="DeploymentDepth" size="15" value="<?php echo $deploy["DeploymentDepth"] ?>" class="right"> <br><br>
    Timekeeper:<input type="text" name="DeploymentTimekeeper" size="15" value="<?php echo $deploy["Timekeeper"] ?>" class="right"><br><br>
    Chief Scientist:<input type="text" name="DeploymentChiefScientist" size="15" class="right" value="<?php echo $deploy["ChiefScientist"] ?>" class="right"> <br><br></p></div>
    
    <div id="Recovery"> <h4  class="uline">Recovery </h4><br>
    Cruise Number: <input type="text" name="RecoveryCruiseNumber" size="15" value="<?php echo $recovery["CruiseNumber"] ?>" class="right"> <br><br>
    Recovery Date/Time (GMT):<input type="text" name="RecoveryDateTimeGMT" size="15" value="<?php echo $recovery["RecoveryDateTimeGMT"] ?>" class="right"> <br><br>
    GPS latitude:<input type="text" name="RecoveryLatitude" size="15" value="<?php echo $recovery["Latitude"] ?>" class="right"> <br><br>
    GPS longitude:<input type="text" name="RecoveryLongitude" size="15" value="<?php echo $recovery["Longitude"] ?>" class="right"> <br><br> 
    CTD cast no:<input type="text" name="RecoveryCTDcastNo" size="15" value="<?php echo $recovery["CTDcastNo"] ?>" class="right"> <br><br> 
    <br><br>
    Timekeeper:<input type="text" name="RecoveryTimekeeper" size="15" value="<?php echo $recovery["Timekeeper"] ?>" class="right"><br><br>
    Chief Scientist:<input type="text" name="RecoveryChiefScientist" size="15" class="right" value="<?php echo $recovery["ChiefScientist"] ?>" class="right"> <br><br></p></div>
    
    <div id="clear"></div>
    </div>
    
    <div id="PreDeployment"> <h4  class="uline">Pre-Deployment </h4><br>
    <p>Estimated latitude (N):<input type="text" name="PreDeploymentLatitude" size="15" value="<?php echo $deploy["PreLatitude"] ?>" class="right"> <br><br>
    Estimated longitude (W):<input type="text" name="PreDeploymentLongitude" size="15" value="<?php echo $deploy["PreLongitude"] ?>" class="right"> <br><br> 
    Estimated Deployment depth:<input type="text" name="EstimatedDepth" size="15" value="<?php echo $deploy["EstimatedDepth"] ?>" class="right"> <br><br>
    Estimated Recovery Date:<input type="text" name="EstimatedRecoveryDate" size="15" value="<?php echo $deploy["EstimatedRecoveryDate"] ?>" class="right" > <br><br></p>
    </div>  
        
    <div id="Comments"><h4>Records for Mooring: <?php echo $MooringID ?></h4><br> Comments: <br><br> <textarea form="usrinput" name="Comments" 
        rows="10" cols="80"><?php echo $PreDeploymentNotes["Comments"] ?></textarea></div>
    <!-- complex table for all instrument details ARG!!!-->
    <div id="InstrumentDetails"> 
    <table>
    <tr>
    <th> Est. Depth </th>
    <th> Actual Depth </th>
    <th> Instrument </th>
    <th> Serial No. </th>
    <th> PreDeployment Notes</th>
    <th> PostDeployment Notes</th>
    <th> Prepped </th>
    <th> Dep. </th>
    <th> Rec. </th>
    </tr>
<?php

    $index = 10;
foreach($instrument as $row ){
    echo '<tr>';
    echo '<input type="hidden" name="inst['.$index.'][id]" value="'.$row['id'].'">';
    echo '<td> <input type="text" name="inst['.$index.'][depth]" size="4" value="'.$row['Depth'].'"></td>';
    echo '<td> <input type="text" name="inst['.$index.'][ActualDepth]" size="4" value="'.$row['ActualDepth'].'"></td>';
    echo '<td> <input type="text" name="inst['.$index.'][InstType]" size="8" value="'.str_replace('"', '&quot;', $row['InstType']).'"></td>';
    echo '<td> <input type="text" name="inst['.$index.'][serialnum]" size="8" value="'.$row['SerialNo'].'"></td>';
    echo '<td> <input type="text" name="inst['.$index.'][PreDeploymentNotes]" value="'.$row['PreDeploymentNotes'].'"></td>';
    echo '<td> <input type="text" name="inst['.$index.'][PostDeploymentNotes]" value="'.$row['PostDeploymentNotes'].'"></td>';
    echo '<td> <input type="text" name="inst['.$index.'][Prepped]" size="3" value="'.$row['Prepped'].'"></td>';
    echo '<td> <input type="text" name="inst['.$index.'][deployed]" size="3" value="'.$row['Deployed'].'"></td>';
    echo '<td> <input type="text" name="inst['.$index.'][recovered]" size="3" value="'.$row['Recovered'].'"></td>';
    echo '</tr>';
    $index++;
    }
    
for ($index = 0; $index < 10; $index++) {
    echo '<tr>
    <td> <input type="text" name="inst['.$index.'][depth]" size="4" > </td>
    <td> <input type="text" name="inst['.$index.'][ActualDepth]" size="4" > </td>
    <td> <input type="text" name="inst['.$index.'][InstType]" size="8" > </td>
    <td> <input type="text" name="inst['.$index.'][serialnum]" size="8" > </td>
    <td> <input type="text" name="inst['.$index.'][PreDeploymentNotes]" size="8" > </td>
    <td> <input type="text" name="inst['.$index.'][PostDeploymentNotes]" size="8" > </td>
    <td> <input type="text" name="inst['.$index.'][Prepped]" placeholder="y/n" size="3"> </td>
    <td> <input type="text" name="inst['.$index.'][deployed]" placeholder="y/n" size="3"> </td>
    <td> <input type="text" name="inst['.$index.'][recovered]" placeholder="y/n" size="3"> </td>
    </tr>';
}    
?>    

    </table>
    <div class="row">

        <div class="column">
        <?php
        if ($PreDeploymentNotes["ReleaseBattNew"] == 'y') {
        echo '    <br><br>Does the release have new batteries?: <input type="radio" name="Release" value="y" checked>Yes<input type="radio" name="Release" value="n">No<br>';
        } elseif ($PreDeploymentNotes["ReleaseBattNew"] == 'n') {
        echo '    <br><br>Does the release have new batteries?: <input type="radio" name="Release" value="y">Yes<input type="radio" name="Release" value="n" checked>No<br>';
        } else {
        echo '    <br><br>Does the release have new batteries?: <input type="radio" name="Release" value="y">Yes<input type="radio" name="Release" value="n">No<br>';
        }
        ?>
        
        If not new, how many months were batteries used?<input type="text" name="release_batt" size="5" value="<?php echo $PreDeploymentNotes["ReleaseBattMonths"] ?>" >months
                
        <br><br>
        Recorder:  <input type="text" name="Recorder" size="20" value="<?php echo $PreDeploymentNotes["UserSignature"] ?>" >
        </div>

        <div class="column">
        Mooring Status:  <input type="text" name="DeploymentStatus" size="20" value="<?php echo $deploy["DeploymentStatus"] ?>" >
        </div>
 
    <input type="submit" name="submit" value="Submit"><br></div>
    </div>

    <div id="footer"> PMEL EcoFOCI</div>
    <div id="bottom"> </div>
    
    </div>
</div>
</div>
  
</body>
</html>