<?php

//database functions
function dbConnection($configfile){
    include($configfile);
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
    
function get_IP_inst(){

    $con = dbConnection('../db_configs/db_config.php');
    
    $query = "SELECT DISTINCT SerialNo FROM inst_iceprof ";
    $result = $con->query($query) or die($con->error.__LINE__);
    
    $array_vals = [];
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        foreach ($row as $columnName => $columnData) {
            $array_vals[] = $columnData;
        }
    }
    
    return $array_vals;

    closeID($con); // returns array of ice profilers instruments with unique serial numbers 
    }
    


// result table generators
function get_IP_insttable(){

    $con = dbConnection('../db_configs/db_config.php');
    
    $query = "SELECT * FROM inst_iceprof ";
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

function get_cal_records() {

    $con = dbConnection('../db_configs/db_config.php');
    
    $query = "SELECT * FROM cal_iceprof ";
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

//all records as markdown style table
function get_operation_records() {

    $con = dbConnection('../db_configs/db_config.php');
    
    $query = "SELECT * FROM operations_iceprof ";
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

// only deployment notes
function get_operation_records_deployed() {

    $con = dbConnection('../db_configs/db_config.php');
    
    $query = "SELECT SerialNo, isdeployed, DeployDate, MooringID, CruiseID, 
        DeploymentShipName, Latitude, Longitude FROM operations_iceprof ";
    $result = $con->query($query) or die($con->error.__LINE__);
    
    echo '<div style="padding-left:40px;"><table class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th> SerialNo</th>
      <th> isdeployed</th>
      <th> DeployDate</th>
      <th> MooringID</th>
      <th> CruiseID</th>
      <th> DeploymentShipName</th>
      <th> Latitude</th>
      <th> Longitude</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

    echo '<tr><td>'.$row['SerialNo'].'</td><td>'.$row['isdeployed'].'</td>
          <td>'.$row['DeployDate'].'</td><td>'.$row['MooringID'].'</td>
          <td>'.$row['CruiseID'].'</td><td>'.$row['DeploymentShipName'].'</td>
          <td>'.$row['Latitude'].'</td><td>'.$row['Longitude'].'</td></tr>'.PHP_EOL;
    }
    echo '</tbody></table></div>'.PHP_EOL;
    
    closeID($con); // echos table markdown table format of all instruments

}

// only recovery notes
function get_operation_records_recovered() {

    $con = dbConnection('../db_configs/db_config.php');
    
    $query = "SELECT SerialNo, isrecovered, RecoveryDate, 
        RecoveryShipName, InstrumentDepth, BottomDepth FROM operations_iceprof ";
    $result = $con->query($query) or die($con->error.__LINE__);
    
    echo '<div style="padding-left:40px;"><table class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th> SerialNo</th>
      <th> isrecovered</th>
      <th> RecoveryDate</th>
      <th> RecoveryShipName</th>
      <th> InstrumentDepth</th>
      <th> BottomDepth</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

    echo '<tr><td>'.$row['SerialNo'].'</td><td>'.$row['isrecovered'].'</td>
          <td>'.$row['RecoveryDate'].'</td><td>'.$row['RecoveryShipName'].'</td>
          <td>'.$row['InstrumentDepth'].'</td><td>'.$row['BottomDepth'].'</td></tr>'.PHP_EOL;
    }
    echo '</tbody></table></div>'.PHP_EOL;
    
    closeID($con); // echos table markdown table format of all instruments

}

// only data notes
function get_operation_records_data() {

    $con = dbConnection('../db_configs/db_config.php');
    
    $query = "SELECT SerialNo, RecordType, DataFileName, NumberofPhases, 
        DateofRecord, TimeOn, TimeOff, notes FROM operations_iceprof ";
    $result = $con->query($query) or die($con->error.__LINE__);
    
    echo '<div style="padding-left:40px;"><table class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th> SerialNo</th>
      <th> DateofRecord</th>
      <th> RecordType</th>
      <th> DataFileName</th>
      <th> NumberofPhases</th>
      <th> TimeOn</th>
      <th> TimeOff</th>
      <th> notes</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

    echo '<tr><td>'.$row['SerialNo'].'</td><td>'.$row['DateofRecord'].'</td>
          <td>'.$row['RecordType'].'</td><td>'.$row['DataFileName'].'</td>
          <td>'.$row['NumberofPhases'].'</td><td>'.$row['TimeOn'].'</td>
          <td>'.$row['TimeOff'].'</td><td>'.$row['notes'].'</td></tr>'.PHP_EOL;
    }
    echo '</tbody></table></div>'.PHP_EOL;
    
    closeID($con); // echos table markdown table format of all instruments

}

function calibrations_form_format() {

    echo '<form class="form-horizontal" name="calibration_input" action="insert_calibrations.php" method="post">
    <legend>Calibration Entry</legend>   '.PHP_EOL;

    $con = dbConnection('../db_configs/db_config.php');
    $query = "SHOW FULL COLUMNS FROM cal_iceprof ";
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    if ( $row['Default'] == NULL) {
        if ( $row['Field'] == 'id') { continue; }
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="'.$row['Comment'].'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
    } elseif ( $row['Default'] == "") {
        if ( $row['Field'] == 'id') { continue; }
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="'.$row['Comment'].'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
    } else {
        if ( $row['Field'] == 'id') { continue; }
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" value="'.$row['Default'].'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
    
    }
    
    }    
    
    closeID($con); 
    
    echo '
    <input type="submit" value="Submit">
    </form>';
}

function instrument_form_format() {

    echo '<form class="form-horizontal" name="instrument_input" action="insert_instruments.php" method="post">
    <legend>Instrument Spec. Entry</legend>   '.PHP_EOL;

    $con = dbConnection('../db_configs/db_config.php');
    $query = "SHOW FULL COLUMNS FROM inst_iceprof ";
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    if ( $row['Default'] == NULL) {
        if ( $row['Field'] == 'id') { continue; }
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="'.$row['Comment'].'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
    } elseif ( $row['Default'] == "") {
        if ( $row['Field'] == 'id') { continue; }
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="'.$row['Comment'].'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
    } else {
        if ( $row['Field'] == 'id') { continue; }
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" value="'.$row['Default'].'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
    
    }
    
    }    
    
    closeID($con); 
    
    echo '
    <input type="submit" value="Submit">
    </form>';
}

function operations_form_format() {

    echo '<form class="form-horizontal" name="operations_input" action="insert_operations.php" method="post">
    <legend>Operations Entry</legend>   '.PHP_EOL;

    $con = dbConnection('../db_configs/db_config.php');
    $query = "SHOW FULL COLUMNS FROM operations_iceprof ";
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    if ( $row['Default'] == NULL) {
        if ( $row['Field'] == 'id') { continue; }
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="'.$row['Comment'].'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
    } elseif ( $row['Default'] == "") {
        if ( $row['Field'] == 'id') { continue; }
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="'.$row['Comment'].'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
    } else {
        if ( $row['Field'] == 'id') { continue; }
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" value="'.$row['Default'].'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
    
    }
    
    }    
    
    closeID($con); 
    
    echo '
    <input type="submit" value="Submit">
    </form>';
}


?>