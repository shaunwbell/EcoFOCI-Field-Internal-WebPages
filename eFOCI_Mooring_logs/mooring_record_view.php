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

//view_mooring_record.php

$MooringID = htmlspecialchars($_GET['mooringview_id']);
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

$query = "SELECT * FROM `MooringDeployedInstruments` WHERE `MooringID`='".$MooringID."'  Order By `Depth` ASC";
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

   
    <div id="header"> <h3>Records for Mooring: <?php echo $MooringID ?> <h3>
                        <h4>alternate name:<?php echo $deploy["HistoricMooringID"] ?> </h4></div>
    
    <!-- start form -->
    <div id="MooringDetails"> 
    <div id="Deployment" > <h4 class="uline">Deployment </h4><br> 
    Cruise Number: <div class="phpoutput"><?php echo $deploy["CruiseNumber"] ?></div> <br><br>
    Deployment Date/Time (GMT):<div class="phpoutput"><?php echo $deploy["DeploymentDateTimeGMT"] ?></div> <br><br>
    GPS latitude:<div class="phpoutput"><?php echo $deploy["Latitude"] ?></div> <br><br>
    GPS longitude:<div class="phpoutput"><?php echo $deploy["Longitude"] ?></div> <br><br> 
    CTD cast no:<div class="phpoutput"><?php echo $deploy["CTDcastNo"] ?></div> <br><br> 
    Actual Deployment Depth (m):<div class="phpoutput"><?php echo $deploy["DeploymentDepth"] ?></div> <br><br>
    Timekeeper:<div class="phpoutput"><?php echo $deploy["Timekeeper"] ?></div><br><br>
    Chief Scientist:<div class="phpoutput"><?php echo $deploy["ChiefScientist"] ?></div><br><br></div>
    
    <div id="Recovery"> <h4  class="uline">Recovery </h4><br>
    Cruise Number: <div class="phpoutput"><?php echo $recovery["CruiseNumber"] ?></div> <br><br>
    Recovery Date/Time (GMT):<div class="phpoutput"><?php echo $recovery["RecoveryDateTimeGMT"] ?></div> <br><br>
    GPS latitude:<div class="phpoutput"><?php echo $recovery["Latitude"] ?></div> <br><br>
    GPS longitude:<div class="phpoutput"><?php echo $recovery["Longitude"] ?></div> <br><br> 
    CTD cast no:<div class="phpoutput"><?php echo $recovery["CTDcastNo"] ?></div> <br><br> 
    <br><br>
    Timekeeper:<div class="phpoutput"><?php echo $recovery["Timekeeper"] ?></div><br><br>
    Chief Scientist:<div class="phpoutput"><?php echo $recovery["ChiefScientist"] ?></div><br><br></div>
    
    <div id="clear"></div>
    </div>

    <div id="PreDeployment"> <h4  class="uline"><a href="<?php echo "../dynamic_data/EcoFOCI_Moorings/MooringDiagrams/"; echo mooringid_to_year($MooringID); echo "/".$MooringID.".pdf"; ?>">Pre-Deployment  - Mooring Diagram</a></h4>
    Estimated latitude (N):<div class="phpoutput"><?php echo $deploy["PreLatitude"] ?></div><br><br>

    Estimated longitude (W):<div class="phpoutput"><?php echo $deploy["PreLongitude"] ?></div><br><br> 
    Estimated Deployment depth:<div class="phpoutput"><?php echo $deploy["EstimatedDepth"] ?></div><br><br>
    Estimated Recovery Date:<div class="phpoutput"><?php echo $deploy["EstimatedRecoveryDate"] ?></div><br>
    </div>  
    
    <div id="Comments"><h4>Records for Mooring: <?php echo $MooringID ?></h4>  Comments: <br><br><br><br> <div class="commentblock"><p><?php echo $PreDeploymentNotes["Comments"] ?></p></div></div>
    <!-- complex table for all instrument details ARG!!!-->
    <div id="InstrumentDetails"> 
    <table >
    <tr>
    <th> Est. Depth </th>
    <th> Actual <br> Depth </th>
    <th> Instrument </th>
    <th> Serial No. </th>
    <th> PreDeployment <br> Notes</th>
    <th> PostDeployment <br> Notes </th>
    <th> Prep. </th>
    <th> Dep. </th>
    <th> Rec. </th>
    <th> Data <br> Status </th>
    </tr>

<?php 
$Year=explode("-",$deploy["DeploymentDateTimeGMT"])[0];
$MooringIDlower=strtolower(implode(explode("-",$MooringID)));
echo "<h3><a href='mooring_visualization_thumbnails.php?Year=$Year&MooringID=$MooringIDlower'>Deployed Instruments: $MooringID </a> <h3>";
?>

<?php
foreach($instrument as $row ){
if ($row["Deployed"] == 'n') { // strike through if not deployed
    echo '<tr class="strikeout">'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["Depth"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["ActualDepth"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock"><a href="operations_update.php?id='.$row['id'].'">'.$row['InstType'] .'</a></div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock"><a href="instrument_report.php?InstID='.$row['InstType'].' '.$row['SerialNo'].'">'. $row["SerialNo"] .'</a></div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["PreDeploymentNotes"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["PostDeploymentNotes"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["Prepped"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["Deployed"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["Recovered"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["DataStatus"] .'</div> </td>'.PHP_EOL;
    echo '</tr>';
} else {
    echo '<tr>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["Depth"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["ActualDepth"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock"><a href="operations_update.php?id='.$row['id'].'">'.$row['InstType'] .'</a></div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock"><a href="instrument_report.php?InstID='.$row['InstType'].' '.$row['SerialNo'].'">'. $row["SerialNo"] .'</a></div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["PreDeploymentNotes"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["PostDeploymentNotes"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["Prepped"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["Deployed"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["Recovered"] .'</div> </td>'.PHP_EOL;
    echo '<td> <div class="commentblock">'. $row["DataStatus"] .'</div> </td>'.PHP_EOL;
    echo '</tr>';
}
}
?>    

</table>
    
    <div id="battery">
    <?php
    if ($PreDeploymentNotes["ReleaseBattNew"] == 'y') {
    echo '&nbsp    <br><br>Does the release have new batteries?: <input type="radio" name="Release" value="y" checked>Yes<input type="radio" name="Release" value="n">No<br>';
    } elseif ($PreDeploymentNotes["ReleaseBattNew"] == 'n') {
    echo '&nbsp    <br><br>Does the release have new batteries?: <input type="radio" name="Release" value="y">Yes<input type="radio" name="Release" value="n" checked>No<br>';
    } else {
    echo '&nbsp    <br><br>Does the release have new batteries?: <input type="radio" name="Release" value="y">Yes<input type="radio" name="Release" value="n">No<br>';
    }
    ?>
    
    If not new, how many months were batteries used?  <?php echo $PreDeploymentNotes["ReleaseBattMonths"] ?>   months
    </div>

    <br><br><div class="commentblock"><?php echo $PreDeploymentNotes["UserSignature"] ?> </div></div>
    <div id="footer"> PMEL EcoFOCI</div>
    <div id="bottom"> </div>
    </div>
</div>
</div>
  
</body>
</html>