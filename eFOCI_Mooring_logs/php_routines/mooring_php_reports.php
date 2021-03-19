<?php

include('utilities.php');

//database functions
function dbConnection($source_conf){
    include($source_conf);
    $con = new mysqli($host,$user,$password, $db);

    if (mysqli_connect_errno()) {
        echo "Database connection failed ";
        exit();
    } 
    return $con;
    }

function closeID($con){
    mysqli_close($con);
    }
    
// retrieves instruments that have been deployed/recovered
function deployment_report($deployed,$recovered){

    $con = dbConnection('../db_configs/db_config.php');
    
    $query = "SELECT MooringID, InstType, SerialNo, Prepped, PreDeploymentNotes from `MooringDeployedInstruments` 
        WHERE `Recovered`='".$recovered."' AND `Deployed`='".$deployed."'
        ORDER BY `MooringID` Desc";
            
    $result = $con->query($query) or die($con->error.__LINE__);
    

    echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
    <thead>
      <tr>
        <th>ID</th>
        <th>Serial Number</th>
        <th>Last Known Mooring ID</th>
        <th>Prepped</th>
        <th>PreDeployment Notes</th>
      </tr>
    </thead>
    <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

    echo '<tr><td>'.$row['InstType'].'</td><td>'.$row['SerialNo'].'</td>
          <td><a href="mooring_record_update.php?mooringupdate_id='.$row['MooringID'].'">'.$row['MooringID'].'</td><td>'.$row['Prepped'].'</td><td>'.$row['PreDeploymentNotes'].'</td></tr>'.PHP_EOL;
    }    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con); // returns array of ice profilers instruments with unique serial numbers 
    }

// Mooring Location Summary
function mooring_location_summary($table, $status=''){
    echo $table;
    $con = dbConnection('../db_configs/db_config.php');
    
    $query = "Select a.MooringID, a.Latitude, a.Longitude, a.DeploymentStatus, a.DeploymentDateTimeGMT,
    a.DeploymentDepth, c.RecoveryDateTimeGMT 
    FROM `ecofoci`.`mooringdeploymentlogs` a
    LEFT OUTER JOIN `ecofoci`.`mooringrecoverylogs` c on
    a.MooringID = c.MooringID WHERE DeploymentStatus LIKE '".$status."%' 
    order by MooringID desc";  

    $result = $con->query($query) or die($con->error.__LINE__);
    

    echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
    <thead>
      <tr>
        <th>Mooring ID</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Deployment Depth (m)</th>
        <th>Deployment Date</th>
        <th>Recovery Date</th>
      </tr>
    </thead>
    <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

    if (substr($row['MooringID'],0,2) == substr(date("Y"),2,2)) { //highlight this year as info
        echo '<tr class=info><td><a href="mooring_record_view.php?mooringview_id='.$row['MooringID'].'">'.$row['MooringID'].'</a></td><td>'.$row['Latitude'].'</td>
              <td>'.$row['Longitude'].'</td><td>'.$row['DeploymentDepth'].'</td><td>'.$row['DeploymentDateTimeGMT'].'</td><td>'.$row['RecoveryDateTimeGMT'].'</td></tr>'.PHP_EOL;
    } elseif (substr($row['MooringID'],0,2) == substr(date("Y")-1,2,2)) { //highlight last year as warning
        echo '<tr class=warning><td><a href="mooring_record_view.php?mooringview_id='.$row['MooringID'].'">'.$row['MooringID'].'</a></td><td>'.$row['Latitude'].'</td>
              <td>'.$row['Longitude'].'</td><td>'.$row['DeploymentDepth'].'</td><td>'.$row['DeploymentDateTimeGMT'].'</td><td>'.$row['RecoveryDateTimeGMT'].'</td></tr>'.PHP_EOL;
    } else {
        echo '<tr><td><a href="mooring_record_view.php?mooringview_id='.$row['MooringID'].'">'.$row['MooringID'].'</a></td><td>'.$row['Latitude'].'</td>
              <td>'.$row['Longitude'].'</td><td>'.$row['DeploymentDepth'].'</td><td>'.$row['DeploymentDateTimeGMT'].'</td><td>'.$row['RecoveryDateTimeGMT'].'</td></tr>'.PHP_EOL;
    }
    }    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con); 
    }
    
// List instruments in selected table and highlight inactive instruments
function simple_instrument_report($table){
    echo $table;
    $con = dbConnection('../db_configs/db_config_inst.php');
    
    $query = "SELECT InstType,SerialNo,Model,IsActive,Comments FROM `".$table."`";
            
    $result = $con->query($query) or die($con->error.__LINE__);
    

    echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
    <thead>
      <tr>
        <th>ID and Serial Number</th>
        <th>Model</th>
        <th>Comments</th>
      </tr>
    </thead>
    <tbody>'.PHP_EOL;
      
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

        if ($row['ServiceStatus'] == 'RETIRED') {
        echo '<tr class=danger><td>'.$row['InstType'].' '.$row['SerialNo'].'</td>
              <td>'.$row['Model'].'</td><td>'.$row['Comments'].'</td></tr>'.PHP_EOL;
        } else {    
        echo '<tr><td>'.$row['InstType'].' '.$row['SerialNo'].'</td>
              <td>'.$row['Model'].'</td><td>'.$row['Comments'].'</td></tr>'.PHP_EOL;
        }
    }
    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con); 
    }

// For specified instruments (Active or All) organizes by most recent activity and provides link to historical activity
//      Red highlighting for retired instruments/inactive instruments
//      Blue highlighting for instruments with no calibration in past 3 years
//      Yellow highlighting for currently deployed instruments
function last_operations_report($insttable,$caltable,$ActiveOnly){

    $con = dbConnection('../db_configs/db_config_inst.php');
    
    $query = "SELECT * FROM (SELECT f.MooringID, f.PostDeploymentNotes, f.deployed, f.recovered, f.InstID, f.ServiceStatus, f.Comments, d.CalDate, d.InstID as ID FROM (
                SELECT a.MooringID, a.PostDeploymentNotes, a.deployed, a.recovered, c.InstID, c.Comments, c.ServiceStatus 
                    FROM `ecofoci`.`mooringdeployedinstruments` a
                    RIGHT JOIN `ecofoci_instruments`.`".$insttable."` c ON
                    c.InstID = a.InstID WHERE `MooringID` NOT LIKE '9%' AND `MooringID` NOT LIKE 'F-' OR `MooringID` is NULL ORDER BY InstID, MooringID DESC limit 100000) AS f 
                left JOIN `ecofoci_instruments`.`".$caltable."` d ON
                f.InstID = d.InstID ORDER BY d.InstID, d.CalDate DESC limit 100000) as g group by InstID"   ;  

    $result = $con->query($query) or die($con->error.__LINE__);
  
    
    echo '<div class="table" ><table class="table table-condensed table-hover table-bordered ">
    <thead>
      <tr>
        <th>ID and Serial Number</th>
        <th>Last Deployment </th>
        <th>Last Cal Date</th>
        <th>Add New Cal Data</th>
        <th>Service Status</th>
        <th>Last Deployment Notes</th>
        <th>General Notes</th>
      </tr>
    </thead>
    <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

        if ($row['ServiceStatus'] == 'RETIRED' and $ActiveOnly == 'False'){
        $row_class='danger';
        } elseif ($row['ServiceStatus'] == 'OTHER' and $ActiveOnly == 'False'){
        $row_class='danger';        
        } elseif ($row['ServiceStatus'] == 'LOSTATSEA' and $ActiveOnly == 'False'){
        $row_class='danger';    
        } elseif ($row['ServiceStatus'] == 'RETIRED' and $ActiveOnly == 'True'){
        continue;
        } elseif ($row['ServiceStatus'] == 'OTHER' and $ActiveOnly == 'True'){
        continue;        
        } elseif ($row['ServiceStatus'] == 'LOSTATSEA' and $ActiveOnly == 'True'){
        continue;
        } elseif (($row['ServiceStatus'] != 'RETIRED') and ($row['CalDate'] == '')){
        $row_class='active';
        } elseif (($row['ServiceStatus'] != 'RETIRED') and (days_since_date($row['CalDate']) > 1095)) {
        $row_class='info';
        } else {
        $row_class='';
        }

        if (($row['ServiceStatus'] != 'RETIRED') and ($row['deployed'] == 'y') and ($row['recovered'] == '')) {
        $row_class='warning';
        }

        echo '<tr class='.$row_class.'>
              <td><a href="instrument_report.php?InstID='.$row['InstID'].'">'.$row['InstID'].'</td>
              <td><a href="mooring_record_view.php?mooringview_id='.$row['MooringID'].'">'.$row['MooringID'].'</td>
              <td><a href="calibration_report.php?InstID='.$row['InstID'].'&Caltable='.$caltable.'">'.$row['CalDate'].'</td>
              <td><a href="calibration_new.php?InstID='.$row['InstID'].'">Click Here</td>       
              <td>'.$row['ServiceStatus'].'</td>        
              <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['PostDeploymentNotes'].'</td>        
              <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['Comments'].'</td></tr>'.PHP_EOL;        
        
    
    }


    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con); 
    }    

function last_operations_report_wpressure($insttable,$caltable,$ActiveOnly){

    $con = dbConnection('../db_configs/db_config_inst.php');
    
    $query = "SELECT * FROM (SELECT f.MooringID, f.PostDeploymentNotes, f.deployed, f.recovered, f.InstID, f.Comments, f.PressureSensor, f.ServiceStatus, d.CalDate, d.InstID as ID FROM (
                SELECT a.MooringID, a.PostDeploymentNotes, a.deployed, a.recovered, c.InstID, c.Comments, c.PressureSensor, c.ServiceStatus 
                    FROM `ecofoci`.`mooringdeployedinstruments` a
                    RIGHT JOIN `ecofoci_instruments`.`".$insttable."` c ON
                    c.InstID = a.InstID WHERE `MooringID` NOT LIKE '9%' AND `MooringID` NOT LIKE 'F-' OR `MooringID` is NULL ORDER BY InstID, MooringID DESC limit 100000) AS f 
                left JOIN `ecofoci_instruments`.`".$caltable."` d ON
                f.InstID = d.InstID ORDER BY d.InstID, d.CalDate DESC limit 100000) as g group by InstID"   ;  

    $result = $con->query($query) or die($con->error.__LINE__);
  
    
    echo '<div class="table" ><table class="table table-condensed table-hover table-bordered ">
    <thead>
      <tr>
        <th>ID and Serial Number</th>
        <th>Last Deployment </th>
        <th>Last Cal Date</th>
        <th>Add New Cal Data</th>
        <th>Pressure Sensor</th>
        <th>Service Status</th>
        <th>Last Deployment Notes</th>
        <th>General Notes</th>
      </tr>
    </thead>
    <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

        if ($row['ServiceStatus'] == 'RETIRED' and $ActiveOnly == 'False'){
            $row_class='danger';
            } elseif ($row['ServiceStatus'] == 'OTHER' and $ActiveOnly == 'False'){
            $row_class='danger';        
            } elseif ($row['ServiceStatus'] == 'LOSTATSEA' and $ActiveOnly == 'False'){
            $row_class='danger';    
            } elseif ($row['ServiceStatus'] == 'RETIRED' and $ActiveOnly == 'True'){
            continue;
            } elseif ($row['ServiceStatus'] == 'OTHER' and $ActiveOnly == 'True'){
            continue;        
            } elseif ($row['ServiceStatus'] == 'LOSTATSEA' and $ActiveOnly == 'True'){
            continue;
            } elseif (($row['ServiceStatus'] != 'RETIRED') and ($row['CalDate'] == '')){
            $row_class='active';
            } elseif (($row['ServiceStatus'] != 'RETIRED') and (days_since_date($row['CalDate']) > 1095)) {
            $row_class='info';
            } else {
            $row_class='';
            }

        if (($row['ServiceStatus'] != 'RETIRED') and ($row['deployed'] == 'y') and ($row['recovered'] == '')) {
        $row_class='warning';
        }

        echo '<tr class='.$row_class.'>
              <td><a href="instrument_report.php?InstID='.$row['InstID'].'">'.$row['InstID'].'</td>
              <td><a href="mooring_record_view.php?mooringview_id='.$row['MooringID'].'">'.$row['MooringID'].'</td>
              <td><a href="calibration_report.php?InstID='.$row['InstID'].'&Caltable='.$caltable.'">'.$row['CalDate'].'</td>
              <td><a href="calibration_new.php?InstID='.$row['InstID'].'">Click Here</td>       
              <td>'.$row['PressureSensor'].'</td>        
              <td>'.$row['ServiceStatus'].'</td>        
              <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['PostDeploymentNotes'].'</td>        
              <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['Comments'].'</td></tr>'.PHP_EOL;        
       
    
    }

    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con); 
    }

    
//table of mooring deployments/recoverys/notes    
function mooring_table($table) {
    $con = dbConnection('../db_configs/db_config.php');
    
    $query = "SELECT * from `".$table."` 
        ORDER BY `MooringID` Desc";
            
    $result = $con->query($query) or die($con->error.__LINE__);
    

    echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
   <thead>
    <tr>'.PHP_EOL;

    //Get headers from database column names
    $row = $result->fetch_array(MYSQLI_ASSOC); 

    foreach ($row as $columnName => $columnData) {
        echo '<th>'.$columnName.'</th>'.PHP_EOL;
    }
    echo '</tr>
    </thead>
    <tbody>'.PHP_EOL;
    
    // get all data
    mysqli_data_seek($result,0);
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    
        echo '<tr>';
        foreach ($row as $columnName => $columnData) {

        echo '<td>'.$columnData.'</td>'.PHP_EOL;
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con); 
    }

// Following subroutines generate history reports for individual instruments
//  This includes deployment/recovery/calibration/etc.  it is a tablular version of
//  the instrument timelines.

function indiv_inst_deploy($instID) {

    $con = dbConnection('../db_configs/db_config.php');
    
    $query = "SELECT * from `MooringDeployedInstruments` 
        WHERE `InstID`='".$instID."'
        ORDER BY `MooringID` Desc";
            
    $result = $con->query($query) or die($con->error.__LINE__);
    

    echo '<div class="table-responsive" ><table id="" class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th>Mooring ID</th>
      <th>Deployed Depth</th>
      <th>PreDeployment Notes</th>
      <th>PostDeployment Notes</th>
      <th>Deployed</th>
      <th>Recovered</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

        echo '<tr><td>'.$row['MooringID'].'</td><td>'.$row['Depth'].'</td>
              <td>'.$row['PreDeploymentNotes'].'</td><td>'.$row['PostDeploymentNotes'].'</td>
              <td>'.$row['Deployed'].'</td><td>'.$row['Recovered'].'</td></tr>'.PHP_EOL;
    }
    
    echo '</tbody></table></div>'.PHP_EOL;

    closeID($con);
}

function indiv_inst_calibrations($instID, $caltable) {

    $con = dbConnection('../db_configs/db_config_inst.php');
    
    $query = "SELECT * from `".$caltable."` WHERE `InstID`='".$instID."' ORDER By `CalDate` ";

    // columns to skip 
   $skip_columns = array( 'id' , 'InstType' , 'SerialNo');

    $result = $con->query($query) or die($con->error.__LINE__);
    
    echo '<div class="table-responsive" ><table id="" class="table table-condensed table-hover table-bordered">
    <thead>
    <tr>'.PHP_EOL;

    //Get headers from database column names
    $row = $result->fetch_array(MYSQLI_ASSOC); 

    foreach ($row as $columnName => $columnData) {
        if (!in_array($columnName, $skip_columns)) {
            echo '<th>'.$columnName.'</th>'.PHP_EOL;
        }
    }
    echo '</tr>
    </thead>'.PHP_EOL;
    
    //Set footers to the same
    echo '<tfoot>
    <tr>'.PHP_EOL;

    mysqli_data_seek($result,0);
   foreach ($row as $columnName => $columnData) {
        if (!in_array($columnName, $skip_columns)) {
            echo '<th>'.$columnName.'</th>'.PHP_EOL;
        }
    }
    echo '</tr>
    </tfoot>
    <tbody>'.PHP_EOL;
        
    // get all data
    mysqli_data_seek($result,0);
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
              
        echo '<tr>';
        foreach ($row as $columnName => $columnData) {
        if (!in_array($columnName, $skip_columns)) {
            if (strpos($columnName,'Coef') !== false) {
                $columnData = str_replace('>', '&gt;', $columnData);
                $columnData = str_replace('<', '&lt;', $columnData);
                echo '<td>'.$columnData.'</td>'.PHP_EOL;
            } else {
                echo '<td>'.$columnData.'</td>'.PHP_EOL;
            }
        }
        }
        echo '</tr>';
    }

    closeID($con);
}

function valid_instrument_names() {

    $con = dbConnection('../db_configs/db_config_inst.php');
    
    $query = "SELECT InstType from `ecofoci`.`mooringdeployedinstruments` group by InstType";  

    $result = $con->query($query) or die($con->error.__LINE__);
  
    echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
    <thead>
      <tr>
        <th>Instrument Type</th>
      </tr>
    </thead>
    <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {


        echo '<tr>
              <td>'.$row['InstType'].'</td></tr>'.PHP_EOL;        
        
    }

    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con);   
}
?>