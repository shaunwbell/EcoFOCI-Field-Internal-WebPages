<?php

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

//table of cruise cast logs   
function cruiselogs_table($table) {


    //Get Current Year
    $max_year = date("Y") + 1;

    $min_year = date("Y") - 2;

    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    
    $query = "SELECT * from `".$table."` WHERE `GMTYear` BETWEEN ".$min_year." AND ".$max_year." ORDER BY `id` DESC"; 
            
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
            if ($columnName == 'CruiseID') {
            echo '<td><a href="cruise_reports.php?CruiseID='.$row['CruiseID'].'">'.$row['CruiseID'].'</a></td>'.PHP_EOL;
            } else {
            echo '<td>'.$columnData.'</td>'.PHP_EOL;
            }
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con); 
    }

// table of cruises by year for cruise maps links with modal window for png map display
function cruise_maps() {

    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');

    //Get CruiseID
    $query = "SELECT CruiseID, CruiseYear, StartDate FROM `cruises` ORDER BY `StartDate` desc";

    $result = $con->query($query) or die($con->error.__LINE__);
    
    echo '<div class="table-responsive" ><table id="" class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th>Cruise ID</th>
      <th>Year - StartDate</th>
      <th>Cruise Maps</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo '<tr><td><a href="cruise_reports.php?CruiseID='.$row['CruiseID'].'">'.$row['CruiseID'].'</a></td>
                  <td>'.$row['CruiseYear'].' : '.$row['StartDate'].'</td>
                  <td width=150px><a href="../dynamic_data/EcoFOCI_CTDCasts/CTDCruiseMaps/'.$row['CruiseID'].'/'.$row['CruiseID'].'_map.png">png, </a>
                    <a href="../dynamic_data/EcoFOCI_CTDCasts/CTDCruiseMaps/'.$row['CruiseID'].'/'.$row['CruiseID'].'.kml">kml file, </a>
                    <a href="../dynamic_data/EcoFOCI_CTDCasts/CTDCruiseMaps/'.$row['CruiseID'].'/'.$row['CruiseID'].'.geo.json">geojson file</a></td></tr>'.PHP_EOL;
    }
    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con);
}

function cruise_map_gallery() {

    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');

    //Get CruiseID
    $query = "SELECT CruiseID, CruiseYear, StartDate FROM `cruises` ORDER BY `StartDate` desc";

    $result = $con->query($query) or die($con->error.__LINE__);

    echo'<div <!-- Page Content -->

        <div class="row">'.PHP_EOL;

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo '<div class="col-lg-3 col-md-4 col-xs-6 thumb well well-sm">
                <a class="thumbnail" href="../dynamic_data/EcoFOCI_CTDCasts/CTDCruiseMaps/'.$row['CruiseID'].'/'.$row['CruiseID'].'_map.png">
                    <img class="img-responsive" src="../dynamic_data/EcoFOCI_CTDCasts/CTDCruiseMaps/'.$row['CruiseID'].'/'.$row['CruiseID'].'_map.png" alt="" style="min-height:50px;height:250px;">
                </a>
                <div class="caption"><a href="cruise_reports.php?CruiseID='.$row['CruiseID'].'">CruiseID '.$row['CruiseID'].'</a></div><p></p>
            </div>'.PHP_EOL;
    }
        echo '</div>'.PHP_EOL;http://pavlof.pmel.noaa.gov/bell/eFOCI_CTD_logs/cruise_reports.php?CruiseID=OS1701L3
}

// generate table of deployed instruments from previous 3 years
function ctdrecord_cruise_view() {

    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');

    //Get MooringID
    $query = "SELECT * FROM cruises ORDER BY `CruiseID` DESC";

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

            if ($columnName == 'CruiseID') {
            echo '<td><a href="cruise_reports.php?CruiseID='.$row['CruiseID'].'">'.$row['CruiseID'].'</a></td>'.PHP_EOL;
            } else {
            echo '<td>'.$columnData.'</td>'.PHP_EOL;
            }
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>'.PHP_EOL;
    closeID($con); 
}

// generate table of deployed instruments from previous 3 years
function ctdrecord_cruises_view() {

    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');

    //Get MooringID
    $query = "SELECT * FROM cruises ORDER BY `CruiseYear` DESC";

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

//table of general cruise characteristics
function cruiselogs_table_cruiseheader($table, $CruiseID) {


    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    $query = "SELECT * from `".$table."` WHERE `CruiseID` = '".$CruiseID."' "; 
    $result = $con->query($query) or die($con->error.__LINE__);
    $row = $result->fetch_array(MYSQLI_ASSOC);    
    closeID($con); 
    
    echo "Cruise: <strong>".$row['CruiseID']."</strong></br>".PHP_EOL;
    echo "Alternate Cruise Names: <strong>".$row['CruiseID_Historic'].",".$row['CruiseID_Alternates']."</strong></br>".PHP_EOL;
    echo "Start Dates: <strong>".$row['StartDate']."</strong></br>".PHP_EOL;
    echo "End Date: <strong>".$row['EndDate']."</strong></br>".PHP_EOL;
    echo "Chief Scientist: <strong>".$row['ChiefScientist']."</strong></br>".PHP_EOL;
 
    return array($row['StartDate'],$row['EndDate']);}

//table of general cruise characteristics
function cruiselogs_table_summaryheader($table, $CruiseID) {


    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    $query = "SELECT * from `".$table."` WHERE `CruiseID` = '".$CruiseID."' "; 
    $result = $con->query($query) or die($con->error.__LINE__);
    $row = $result->fetch_array(MYSQLI_ASSOC);    
    closeID($con); 
    

    echo "Cruise Cast Logs (if available): <strong><a href=\"../dynamic_data/EcoFOCI_CTDCasts/ctd_cruise_logs/".$row['CruiseYear']."/".$row['CruiseID']."/".$row['ctdlogs_pdf_name']."\">CTD Logs</a></strong></br>".PHP_EOL;

    }

//table of cruise cast logs for specific cruise
function cruiselogs_table_cruise($table, $CruiseID) {


    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    $query = "SELECT * from `".$table."` WHERE `UniqueCruiseID` = '".$CruiseID."' ORDER BY `ConsecutiveCastNo` DESC"; 
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
        if ($columnName == 'ConsecutiveCastNo') {
        echo '<td>Phys. and Bio. <a href="dynamic_charts/highcharts_dynamic_ctdplots_physbio.php?ConsecutiveCastNo='.$columnData.'&CruiseID='.$CruiseID.'">'.$columnData.'</a><br>'.PHP_EOL;
        echo 'Phys. and Oxy. <a href="dynamic_charts/highcharts_dynamic_ctdplots_physoxy.php?ConsecutiveCastNo='.$columnData.'&CruiseID='.$CruiseID.'">'.$columnData.'</a><br>'.PHP_EOL;
        echo 'Bio. and Oxy. <a href="dynamic_charts/highcharts_dynamic_ctdplots_biooxy.php?ConsecutiveCastNo='.$columnData.'&CruiseID='.$CruiseID.'">'.$columnData.'</a></td>'.PHP_EOL;
        } else {
        echo '<td>'.$columnData.'</td>'.PHP_EOL;
        }
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>'.PHP_EOL;
    closeID($con); 
    }

//table of cruise cast logs for specific cruise with just basic information
function cruiselogs_table_cruise_simple($table, $CruiseID) {
    $params ="`StationNo_altname`,`ConsecutiveCastNo`,`LatitudeDeg`,`LatitudeMin`,`LongitudeDeg`,`LongitudeMin`,
    `GMTDay`,`GMTMonth`,`GMTYear`,`BottomDepth`,`MaxDepth`";

    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    $query = "SELECT ".$params." from `".$table."` WHERE `UniqueCruiseID` = '".$CruiseID."' ORDER BY `ConsecutiveCastNo` DESC"; 
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
        if ($columnName == 'ConsecutiveCastNo') {
        echo '<td><a href="dynamic_charts/highcharts_dynamic_ctdplots.php?ConsecutiveCastNo='.$columnData.'&CruiseID='.$CruiseID.'">'.$columnData.'</a></td>'.PHP_EOL;
        } else {
        echo '<td>'.$columnData.'</td>'.PHP_EOL;
        }
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>'.PHP_EOL;
    closeID($con); 
    }

//table of cruise cast logs for specific cruise
function cruiselogs_table_cruise_summary($table, $CruiseID) {


    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    $query = "SELECT ConsecutiveCastNo, LatitudeDeg, LatitudeMin, LongitudeDeg, LongitudeMin, StationNameID, StationNo_altname, Notes from `".$table."` WHERE `UniqueCruiseID` = '".$CruiseID."' ORDER BY `ConsecutiveCastNo` ASC"; 
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

//table of sal/nut/O2 bottles from cruise cast logs
function cruiselogs_table_cruise_btl_summary($table, $CruiseID) {


    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    $query = "SELECT ConsecutiveCastNo, NutrientBtlNiskinNo, NutrientBtlNumbers, OxygenBtlNiskinNo, OxygenBtlNumbers, SalinityBtlNiskinNo, SalinityBtlNumbers, Notes from `".$table."` WHERE `UniqueCruiseID` = '".$CruiseID."' ORDER BY `ConsecutiveCastNo` ASC"; 
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

//table of sal
function cruiselogs_table_cruise_btl_salts($table, $CruiseID) {


    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    $query = "SELECT ConsecutiveCastNo, SalinityBtlNiskinNo, SalinityBtlNumbers, NutrientBtlNiskinNo, Notes from `".$table."` WHERE `UniqueCruiseID` = '".$CruiseID."' ORDER BY `ConsecutiveCastNo` ASC"; 
    $result = $con->query($query) or die($con->error.__LINE__);

    echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>'.PHP_EOL;

    echo '<th>BottleID</th>'.PHP_EOL;
    echo '</tr>
    </thead>
    <tbody>'.PHP_EOL;
    
    // get all data
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    
        echo '<tr>';
        foreach ($row as $columnName => $columnData) {

            if ($columnName == 'NutrientBtlNiskinNo') {
            $NoBottles = end(explode(';', $columnData));
                if ($NoBottles <=1) {$NoBottles=1;}
            } elseif ($columnName == 'ConsecutiveCastNo') {
            $cast = $columnData;
            } elseif ($columnName == 'SalinityBtlNiskinNo') {
            $salbottleNiskin = $columnData;
            } elseif ($columnName == 'SalinityBtlNumbers') {
            $salbottleID = $columnData;
            }
            
            $output = $salbottleID.":".$salbottleNiskin.":".$cast;
        }
        for ($x=1; $x<=$NoBottles; $x++) {
            echo '<td>'.$output.'</td>'.PHP_EOL;
        echo '</tr>';
        }
    }
    echo '</tbody></table></div>'.PHP_EOL;
    closeID($con); 
    }

//table of sal/nut/O2 bottles from cruise cast logs
function cruiselogs_table_cruise_btl_oxygen($table, $CruiseID) {


    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    $query = "SELECT ConsecutiveCastNo, OxygenBtlNiskinNo, OxygenBtlNumbers, NutrientBtlNiskinNo, Notes from `".$table."` WHERE `UniqueCruiseID` = '".$CruiseID."' ORDER BY `ConsecutiveCastNo` ASC"; 
    $result = $con->query($query) or die($con->error.__LINE__);

    echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>'.PHP_EOL;

    echo '<th>BottleID</th><th>NiskinNo</th>'.PHP_EOL;
    echo '</tr>
    </thead>
    <tbody>'.PHP_EOL;
    
    // get all data
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    
        echo '<tr>';
        foreach ($row as $columnName => $columnData) {

            if ($columnName == 'NutrientBtlNiskinNo') {
            $NoBottles = end(explode(';', $columnData));
            } elseif ($columnName == 'ConsecutiveCastNo') {
            $cast = $columnData;
            } elseif ($columnName == 'OxygenBtlNiskinNo') {
            $salbottleNiskin = $columnData;
            } elseif ($columnName == 'OxygenBtlNumbers') {
            $salbottleID = $columnData;
            }
            
            $output = $salbottleID.":".$salbottleNiskin.":".$cast;
        }
        for ($x=1; $x<=$NoBottles; $x++) {
            echo '<td>'.$output.'</td><td>'.$salbottleNiskin.'</td>'.PHP_EOL;
        echo '</tr>';
        }
    }
    echo '</tbody></table></div>'.PHP_EOL;
    closeID($con); 
    }
    
function ctdrecord_initial_input_form() {

    echo '<form role="form" class="form-horizontal" name="castlog_initial_input" action="AddNewCruiseCTD.php" method="get">
    <legend>Operations Entry</legend>   '.PHP_EOL;

    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    $query = "SHOW FULL COLUMNS FROM CruiseCastLogs ";
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
    <input type="submit" value="Submit CastLog Info">
    </form>';
}

function ctdrecord_cruise_form() {

    echo '<form role="form" class="form-horizontal" name="ctdrecord_cruise_form" action="AddNewCruise.php" method="get">
    <legend>Operations Entry</legend>   '.PHP_EOL;

    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    $query = "SHOW FULL COLUMNS FROM Cruises ";
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
    <input type="submit" value="Submit CastLog Info">
    </form>';
}

function ctdrecord_add_input_form() {

    echo '<form role="form" class="form-horizontal" name="ctdrecord_add_input" action="AddNewCruiseCTD.php" method="post">
    <legend>Operations Entry</legend>   '.PHP_EOL;

    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    //$query = "SHOW FULL COLUMNS FROM CruiseCastLogs ";
    $query = "SELECT * FROM CruiseCastLogs ORDER BY id DESC LIMIT 1"; //get most recent entry
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

    foreach($row as $key => $val) {
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$key.'" class="col-md-3 control-label">'.$key.'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" name="'.$key.'" id="'.$key.'" value="'.$val.'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
    }

    
    }    
    
    closeID($con); 
    
    echo '
    <input type="submit" value="Submit CastLog Info">
    </form>';
}



//populate and provide ability to update instrument log based on id
function instrument_select_input_form($db_id) {

    echo '<form role="form" class="form-horizontal" role="form name="instlog_input" action="UpdateInstrumentLog.php" method="post">
   
    <legend>Operations Entry</legend>   
    <fieldset>'.PHP_EOL;

    $con = dbConnection('../db_configs/db_config.php');
    //$query = "SHOW FULL COLUMNS FROM CruiseCastLogs ";
    $query = "SELECT * FROM MooringDeployedInstruments WHERE `id`='".$db_id."'";
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

    foreach($row as $key => $val) {
        if ( $key == 'id') { 
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<input type="hidden" class="form-control" name="'.$key.'" id="'.$key.'" value="'.$val.'">   '.PHP_EOL;
        echo '</div>';
        } else {
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$key.'" class="col-md-3 control-label">'.$key.'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" name="'.$key.'" id="'.$key.'" value="'.$val.'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
        }
    }

    
    }    
    
    closeID($con); 
    
    echo '
    <input type="submit" class="btn btn-primary" value="Submit Update">
    </fieldset>
    </form>';
}

//Modal input for CTD Cast Logs
function modal_body_options($modal_label,$table,$script) {

echo '<a href="#" data-toggle="modal" data-target="#'.$table.'" id=myModalSelect>'.$modal_label.'</a>'.PHP_EOL;

echo '<div class="modal fade" id="'.$table.'" tabindex="-1" role="dialog" aria-labelledby="'.$table.'" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">'.$modal_label.'</h4>
      </div>
      <div class="modal-body">';
      
      modal_input_options_form($table,$script);

echo '</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button form="'.$table.'_input" class="btn btn-primary" type="submit">Save changes</button>
      </div>
    </div>
  </div>
</div>'.PHP_EOL;

}

// Add Event Type / Cruise information via modal window
function modal_body($modal_label,$table,$script) {

echo '<a href="#" data-toggle="modal" data-target="#'.$table.'" id=myModalSelect>'.$modal_label.'</a>'.PHP_EOL;

echo '<div class="modal fade" id="'.$table.'" tabindex="-1" role="dialog" aria-labelledby="'.$table.'" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">'.$modal_label.'</h4>
      </div>
      <div class="modal-body">';
      
      modal_input_form($table,$script);

echo '</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button form="'.$table.'_input" class="btn btn-primary" type="submit">Save changes</button>
      </div>
    </div>
  </div>
</div>'.PHP_EOL;

}

function modal_input_form($table,$script) {

    echo '<form class="form-horizontal" id="'.$table.'_input" action="'.$script.'" method="get" target="iframe'.$table.'">
    '.PHP_EOL;

    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    $query = "SELECT * FROM `".$table."` ORDER BY id DESC LIMIT 1"; //get most recent entry
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

    foreach($row as $key => $val) {
		// following are hidden from display
		if (($key == 'SeaState') or
		($key == 'Visibility') or
		($key == 'CloudAmt') or
		($key == 'CloudType') or
		($key == 'WetBulb') or
		($key == 'Weather') or
		($key == 'id')) { echo '<input type="hidden" name="'.$key.'" id="'.$key.'" value="'.$val.'">   '.PHP_EOL;; }
        elseif ($key == 'InstrumentSerialNos') {
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$key.'" class="col-md-3 control-label">'.$key.'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<textarea rows="3" name="'.$key.'" id="'.$key.'" placeholder="comma seperated">'.$val.'</textarea>   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
        } elseif ($key == 'Notes') {
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$key.'" class="col-md-3 control-label">'.$key.'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<textarea rows="3" name="'.$key.'" id="'.$key.'" placeholder="comma seperated">'.$val.'</textarea>   '.PHP_EOL;
        echo '</div>';
        echo '</div>'; 
        } else {
		echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$key.'" class="col-md-3 control-label">'.$key.'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" name="'.$key.'" id="'.$key.'" value="'.$val.'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
		}
	}
	}
    closeID($con); 


    echo '
    </form>
    <hr>
    Resulting Message:<br>
    <iframe seamless src="about:blank" id="iframe'.$table.'" name="iframe'.$table.'"></iframe>';
}

//---------Historic Lines----------//


function historic_lines($table) {


    $con = dbConnection('../db_configs/db_config_data.php');
    $query = "SELECT * from `".$table."` "; 
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

//---------Vessel Information----------//


// generate table all vessels affiliated with EcoFOCI 
function ctdrecord_vessel_view() {

    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');

    //Get MooringID
    $query = "SELECT * FROM vessels ORDER BY `shipshort_ID` DESC";

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
?>