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

//populate and provide ability to instatiate new drifter id
function argos_drifter_id_new() {

    echo '<form role="form" class="form-horizontal" role="form name="argos_id_input" action="AddNewArgosID.php" method="get">
   
    <legend>Mooring Gear Entry</legend>   
    <fieldset>'.PHP_EOL;

   
    
    $con = dbConnection('../db_configs/db_config_drifters.php');
    $query = "SHOW FULL COLUMNS FROM drifter_ids";
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        if ( $row['Field'] == 'id') { continue; }
        elseif ( $row['Field'] == 'LastKnownTransmission') { continue; }
        elseif ( $row['Field'] == 'ReleaseDate') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" value="'.date('Y-m-d').'">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
            continue; }
        elseif ( $row['Field'] == 'RecoveryDate') { continue; }
        elseif ( $row['Field'] == 'Comments') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
        continue; } 
        elseif ( $row['Field'] == 'CruiseID') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="eg. DY1504">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
        continue; } 
            elseif ( $row['Field'] == 'ReleaseLat') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="hh dd.ddd +N/-S">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
        continue; }
        elseif ( $row['Field'] == 'ReleaseLon') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="hh dd.ddd +W/-E">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
        continue; }
        elseif ( $row['Field'] == 'DrogueDepth') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="number" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="eg. 20">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
        continue; } 
        elseif ( $row['Field'] !== 'ArgosNumber') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<select name="'.$row['Field'].'">';
            
            // populate drop down menus with enum options
            if (strpos('enum', $row['Type']) !== true) {
                $gear_options = explode("','",substr($row['Type'],6,-2));

                foreach ($gear_options as $val) {
                    echo $val;
                    echo '<option id="'.$row['Field'].'" value="'.$val.'">'.$val.'</option>'.PHP_EOL;
                }
            }
            echo '</select>';
            echo '</div>';
            echo '</div>';
        } else {
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-3">';
        echo '<input type="number" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="number eg. 1,2..100">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
        }
    }     
    
    closeID($con); 
    
    echo '
    <input type="submit" class="btn btn-primary" value="Submit Entry">
    </fieldset>
    </form>';
}

//populate and provide ability to update drifter id information
function argos_drifter_id_update() {

    echo '<form role="form" class="form-horizontal" role="form name="argos_id_update" action="UpdateArgosID.php" method="get">
   
    <legend>Mooring Gear Entry</legend>   
    <fieldset>'.PHP_EOL;

   
    
    $con = dbConnection('../db_configs/db_config_drifters.php');
    $query = "SHOW FULL COLUMNS FROM drifter_ids";
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        if ( $row['Field'] == 'id') { continue; }
        elseif ( $row['Field'] == 'LastKnownTransmission') { continue; }
        elseif ( $row['Field'] == 'ReleaseDate') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" value="'.date('Y-m-d').'">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
            continue; }
        elseif ( $row['Field'] == 'RecoveryDate') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" value="'.date('Y-m-d').'">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
            continue; }
        elseif ( $row['Field'] == 'ReleaseLat') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="hh dd.ddd +N/-S">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
        continue; }
        elseif ( $row['Field'] == 'ReleaseLon') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="hh dd.ddd +W/-E">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
        continue; }        
        elseif ( $row['Field'] == 'Comments') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
        continue; } 
        elseif ( $row['Field'] == 'CruiseID') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="eg. DY1504">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
        continue; } 
        elseif ( $row['Field'] == 'DrogueDepth') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="number" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="eg. DY1504">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
        continue; } 
            elseif ( $row['Field'] !== 'ArgosNumber') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<select name="'.$row['Field'].'">';
            
            // populate drop down menus with enum options
            if (strpos('enum', $row['Type']) !== true) {
                $gear_options = explode("','",substr($row['Type'],6,-2));

                foreach ($gear_options as $val) {
                    echo $val;
                    echo '<option id="'.$row['Field'].'" value="'.$val.'">'.$val.'</option>'.PHP_EOL;
                }
            }
            echo '</select>';
            echo '</div>';
            echo '</div>';
        } else {
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-3">';
        echo '<input type="number" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="number eg. 1,2..100">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
        }
    }     
    
    closeID($con); 
    
    echo '
    <input type="submit" class="btn btn-primary" value="Submit Update">
    </fieldset>
    </form>';
}

// generate table of drifter attributes from database
function argos_drifter_status($tablename) {

    $con = dbConnection('../db_configs/db_config_drifters.php');

    //Get MooringID
    $query = "SELECT * FROM $tablename ORDER BY `ArgosNumber` DESC";

    $result = $con->query($query) or die($con->error.__LINE__);
    
    echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
  <thead><tr>'.PHP_EOL;

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

// generate table of images for drifters
function argos_drifter_quicklooks($DrifterYear) {

    //Get Current day
    date_default_timezone_set('America/Los_Angeles');
    $transdate_today = new DateTime();
    $transdate_today->modify('-0 day');
    $transdate_today = $transdate_today->format('Y-m-d');

    $con = dbConnection('../db_configs/db_config_drifters.php');

    //Get MooringID
    $query = "Select * from (SELECT * FROM drifter_ids WHERE `LastKnownTransmission` <= '".($DrifterYear+1)."-01-01' AND `LastKnownTransmission` > '".($DrifterYear)."-01-01' ORDER BY `ArgosNumber` DESC limit 1000) as grp Group By ArgosNumber";
    
    $result = $con->query($query) or die($con->error.__LINE__);
    print $query;
    echo '<div class="table-responsive" ><table id="" class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th>Argos Number</th>
      <th>Wide View (contoured by temperature)</th>
      <th>Zoomed View (contoured by julian date)</th>
      <th>Google Earth File</th>
      <th>Last Known Reported Data</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        if (strtotime($transdate_today) - strtotime($row['LastKnownTransmission']) <= 2*86400) {
        $status = 'info';
        } elseif ((strtotime($transdate_today) - strtotime($row['LastKnownTransmission']) > 2*86400) and (strtotime($transdate_today) - strtotime($row['LastKnownTransmission']) < 7*86400)) {
        $status = 'warning';
        } else {
        $status = 'danger';
        }
        echo '<tr class='.$status.'>
                  <td style="width:50px"><a href="DrifterQuicklooks_dygraph.php?DrifterID='.$row['ArgosNumber'].'">'.$row['ArgosNumber'].'</a></td>
                  <td><a href="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$row['ArgosNumber'].'_wide_drifter.png"><img src="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$row['ArgosNumber'].'_wide_drifter.png" height="20%" width="95%"></a></td>
                  <td><a href="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$row['ArgosNumber'].'_zoom_drifter.png"><img src="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$row['ArgosNumber'].'_zoom_drifter.png" height="20%" width="95%"></a></td>
                  <td style="width:50px"><a href="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$row['ArgosNumber'].'_drifter.kml">Google Earth kml file</a></dtd>
                  <td style="width:50px">'.$row['LastKnownTransmission'].'</td>'.PHP_EOL;
    }
    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con);

}

// generate table of images for drifters from erddap plots
function argos_drifter_quicklooks_erddap($DrifterYear) {

    //Get Current day
    date_default_timezone_set('America/Los_Angeles');
    $transdate_today = new DateTime();
    $transdate_today->modify('-0 day');
    $transdate_today = $transdate_today->format('Y-m-d');

    $con = dbConnection('../db_configs/db_config_drifters.php');

    //Get MooringID
    $query = "Select * from (SELECT * FROM drifter_ids WHERE `LastKnownTransmission` <= '".($DrifterYear+1)."-01-01' AND `LastKnownTransmission` > '".($DrifterYear)."-01-01' ORDER BY `ArgosNumber` DESC limit 1000) as grp Group By ArgosNumber";
    
    $result = $con->query($query) or die($con->error.__LINE__);
    print $query;
    echo '<div class="table-responsive" ><table id="" class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th>Argos Number</th>
      <th>Wide View (contoured by temperature)</th>
      <th>Zoomed View (contoured by julian date)</th>
      <th>Google Earth File</th>
      <th>Last Known Reported Data</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        if (strtotime($transdate_today) - strtotime($row['LastKnownTransmission']) <= 2*86400) {
        $status = 'info';
        } elseif ((strtotime($transdate_today) - strtotime($row['LastKnownTransmission']) > 2*86400) and (strtotime($transdate_today) - strtotime($row['LastKnownTransmission']) < 7*86400)) {
        $status = 'warning';
        } else {
        $status = 'danger';
        }
        echo '<tr class='.$status.'>
                  <td style="width:50px"><a href="DrifterQuicklooks_dygraph_erddap.php?DrifterID='.$row['ArgosNumber'].'&DrifterYear='.$DrifterYear.'">'.$row['ArgosNumber'].'</a></td>
                  <td><a href="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$row['ArgosNumber'].'_sst.png"><img src="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$row['ArgosNumber'].'_sst.png" height="20%" width="95%"></a></td>
                  <td><a href="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$row['ArgosNumber'].'_doy.png"><img src="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$row['ArgosNumber'].'_doy.png" height="20%" width="95%"></a></td>
                  <td style="width:50px"><a href="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$row['ArgosNumber'].'_drifter.kml">Google Earth kml file</a></dtd>
                  <td style="width:50px">'.$row['LastKnownTransmission'].'</td>'.PHP_EOL;
    }
    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con);

}


function argos_drifter_gallery($DrifterYear) {

    //Get Current day
    date_default_timezone_set('America/Los_Angeles');
    $transdate_today = new DateTime();
    $transdate_today->modify('-0 day');
    $transdate_today = $transdate_today->format('Y-m-d');

    $con = dbConnection('../db_configs/db_config_drifters.php');

    //Get MooringID
    $query = "SELECT * FROM (SELECT * FROM drifter_ids WHERE `LastKnownTransmission` <= '".($DrifterYear+1)."-01-01' AND `LastKnownTransmission` > '".($DrifterYear)."-01-01' ORDER BY `ArgosNumber` DESC LIMIT 1000) as grp group by ArgosNumber";
    
    $result = $con->query($query) or die($con->error.__LINE__);

    echo'<div <!-- Page Content -->

        <div class="row">

            <div class="col-lg-12">
                <h1 class="page-header">'.$DrifterYear.' Drifter Gallery</h1>
            </div>'.PHP_EOL;

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo '<div class="col-lg-3 col-md-4 col-xs-6 thumb well well-sm">
                <a class="thumbnail" href="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$row['ArgosNumber'].'_zoom_drifter.png">
                    <img class="img-responsive" src="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$row['ArgosNumber'].'_zoom_drifter.png" alt="" style="min-height:50px;height:250px;">
                </a>
                <div class="caption">Argos ID '.$row['ArgosNumber'].'</div><p></p>
            </div>'.PHP_EOL;
    }
        echo '</div>'.PHP_EOL;
}

function argos_drifter_gallery_historic($DrifterYear) {

    //Get Current day
    date_default_timezone_set('America/Los_Angeles');
    $transdate_today = new DateTime();
    $transdate_today->modify('-0 day');
    $transdate_today = $transdate_today->format('Y-m-d');

    $con = dbConnection('../db_configs/db_config_drifters.php');

    //Get MooringID
    $query = "SELECT * FROM drifter_ids_pre2015 WHERE `ReleaseDate` <= '".($DrifterYear+1)."-01-01' AND `ReleaseDate` > '".($DrifterYear)."-01-01' ORDER BY `ArgosNumber` DESC";
    
    $result = $con->query($query) or die($con->error.__LINE__);

    echo'<div <!-- Page Content -->

        <div class="row">

            <div class="col-lg-12">
                <h1 class="page-header">'.$DrifterYear.' Drifter Gallery</h1>
            </div>'.PHP_EOL;

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo '<div class="col-lg-3 col-md-4 col-xs-6 thumb well well-sm">
                <a class="thumbnail" href="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$DrifterYear.'/'.$row['ArgosNumber'].'_zoom_drifter.png">
                    <img class="img-responsive" src="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$DrifterYear.'/'.$row['ArgosNumber'].'_zoom_drifter.png" alt="" style="min-height:50px;height:250px;">
                </a>
                <div class="caption">Argos ID '.$row['ArgosNumber'].'</div><p></p>
            </div>'.PHP_EOL;
    }
        echo '</div>'.PHP_EOL;
}
?>