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

function enumDropdown($table_name, $column_name, $default, $echo = false)
{
   $con = dbConnection('../db_configs/db_config.php');

   $selectDropdown = "<select class=\"form-control\" name=\"$column_name\" >";
   $query = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS  WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'";

   $result = $con->query($query) or die($con->error.__LINE__);

   while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

    $enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
   }
    

    foreach($enumList as $value) {
        if ($value == $default) {
            $selectDropdown .= "<option selected=\"selected\" value=\"".$value."\">".$value."</option>";
        } else {
            $selectDropdown .= "<option value=\"".$value."\">".$value."</option>";            
        }
    }

    $selectDropdown .= "</select>".PHP_EOL;


    if ($echo)
        echo $selectDropdown;

    closeID($con);

    return $selectDropdown;
}

//------------------------------------//

function mooringid_to_year($mooringid) {
        if (substr($mooringid,0,2) <= 80) {
            $year = 2000 + substr($mooringid,0,2);
        } else {
            $year = 1900 + substr($mooringid,0,2);
        }
    return $year;
}

function update_record_select() {

    echo '<form class="form-horizontal" id="mooringlogupdate" action="mooring_record_update.php" method="get">
    <fieldset>
    <legend>Update Mooring Records (Last 3 Seasons)</legend>   
    <div class="form-group">'.PHP_EOL;

    //Get Current Year
    $max_year = date("y") + 1;
    $min_year = date("y") - 2;
    
    $con = dbConnection('../db_configs/db_config.php');

    //Get MooringID
    $query = "SELECT * FROM MooringDeploymentLogs WHERE `MooringID` BETWEEN ".$min_year." AND ".$max_year." ORDER BY `MooringID` DESC";
    $MooringID = $con->query($query) or die($con->error.__LINE__);
    
    echo '<label for="mooringupdate_id" class="col-xs-4 control-label">MooringID</label>
            <div class="col-xs-4">
            <select class="form-control" name="mooringupdate_id">'.PHP_EOL;
            
    while($row = $MooringID->fetch_array(MYSQLI_BOTH)) {
        echo "    <option value=" . $row['MooringID'] . ">". $row['MooringID'] . "</option>". PHP_EOL;
        }

    closeID($con);
    
    
    echo '</select><br>
    </div><div>
    <input type="submit" class="btn btn-primary btn-sm" value="Submit MooringID" id="mooringlogupdate">
    </fieldset>
    </form>';
}

function view_record_select($max_year,$min_year) {

    echo '<form role="form" class="form-horizontal" id="mooringlogview" action="mooring_record_view.php" method="get">
    <fieldset>
    <legend>View Mooring Records (All Archived Deployments)</legend>   
    <div class="form-group">'.PHP_EOL;


    $con = dbConnection('../db_configs/db_config.php');

    //Get MooringID
    $query = "SELECT * FROM MooringDeploymentLogs WHERE `MooringID` BETWEEN ".$min_year." AND ".$max_year." ORDER BY `MooringID` DESC";


    $MooringID = $con->query($query) or die($con->error.__LINE__);
    
    echo '<label for="mooringview_id" class="col-xs-4 control-label">MooringID</label>
            <div class="col-xs-4">
            <select class="form-control " name="mooringview_id">'.PHP_EOL;
    
    while($row = $MooringID->fetch_array(MYSQLI_BOTH)) {
        echo "    <option value=" . $row['MooringID'] . ">". $row['MooringID'] . "</option>". PHP_EOL;
        }

    closeID($con);
    
    
    echo '</select><br>
    </div><div>
    <input type="submit" class="btn btn-primary btn-sm" value="Submit MooringID" id="mooringlogview">
    </fieldset>
    </form>';
}

// generate table of mooring physical gear records (cages, floats, etc)
function view_gear_records() {

    //Get Current Year
    $max_year = new DateTime();
    $max_year = $max_year->format('Y-m-d');
    $min_year = new DateTime("-2 year");
    $min_year = $min_year->format('Y-m-d');
    
    $con = dbConnection('../db_configs/db_config_inst.php');

    //Get MooringID
    $query = "SELECT * FROM hardware_and_cages WHERE `Date` BETWEEN '".$min_year."' AND '".$max_year."' ORDER BY `gear_type` DESC";

    $result = $con->query($query) or die($con->error.__LINE__);
    
    echo '<div class="table-responsive" ><table id="" class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th>Date of Record</th>
      <th>Gear Type</th>
      <th>Shackle Size</th>
      <th>Status</th>
      <th>Gear Count</th>
      <th>Gear Action</th>
      <th>Notes</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

        echo '<tr>
                  <td>'.$row['Date'].'</td>
                  <td>'.$row['gear_type'].'</td>
                  <td>'.$row['shackle_size'].'</a></td>
                  <td>'.$row['gear_status'].'</td>
                  <td>'.$row['gear_count'].'</td>
                  <td>'.$row['gear_action'].'</td>
                  <td>'.$row['PreDeploymentNotes'].'</td></tr>'.PHP_EOL;
    }
    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con);
}

//populate and provide ability to create instruments on loan
function mooring_phyiscal_gear_input_form_new() {

    echo '<form role="form" class="form-horizontal" name="mooring_gear_input" action="AddNewMooringGear.php" method="post">
   
    <legend>Mooring Gear Entry</legend>   
    <fieldset>'.PHP_EOL;

   
    
    $con = dbConnection('../db_configs/db_config_inst.php');
    //$query = "SHOW FULL COLUMNS FROM CruiseCastLogs ";
    $query = "SHOW FULL COLUMNS FROM hardware_and_cages";
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        if ( $row['Field'] == 'id') { continue; }
        elseif ( $row['Field'] == 'Date') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" value="'.date('Y-m-d').'">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
            continue; }
        elseif ( $row['Field'] == 'PreDeploymentNotes') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<input type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="any notes?">   '.PHP_EOL;
            echo '</div>';
            echo '</div>';
            continue; }
        elseif ( $row['Field'] !== 'gear_count') { 
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

// generate table of deployed instruments from previous 4 years
function view_instrument_select() {

    //Get Current Year
    $max_year = date("y") + 1;
    $min_year = date("y") - 3;
    
    $con = dbConnection('../db_configs/db_config.php');

    //Get MooringID
    $query = "SELECT * FROM MooringDeployedInstruments WHERE `MooringID` BETWEEN ".$min_year." AND ".$max_year." ORDER BY `MooringID` DESC";

    $result = $con->query($query) or die($con->error.__LINE__);
    
    echo '<div class="table-responsive" ><table id="" class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th>MooringID</th>
      <th>ID and Serial Number</th>
      <th>Notes</th>
      <th>PostDeployment Notes</th>
      <th>Data Status</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

        echo '<tr><td>'.$row['MooringID'].'</td>
                  <td><a href="operations_update.php?id='.$row['id'].'">'.$row['InstType'].' '.$row['SerialNo'].'</a></td>
                  <td>'.$row['PreDeploymentNotes'].'</td><td>'.$row['PostDeploymentNotes'].'</td><td>'.$row['DataStatus'].'</td></tr>'.PHP_EOL;
    }
    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con);
}

// generate table of loaned instruments
function view_loan_select() {

    
    $con = dbConnection('../db_configs/db_config.php');

    //Get MooringID
    $query = "SELECT * FROM InstrumentsOnLoan_OnRepair ORDER BY `DateDeployed` DESC";

    $result = $con->query($query) or die($con->error.__LINE__);
    
    echo '<div class="table-responsive" ><table id="" class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th>InstrumentID</th>
      <th>Destination</th>
      <th>Date Deployed</th>
      <th>Date Received</th>
      <th>Comments</th>
      <th>PostDeployment Notes</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

        echo '<tr><td><a href="onloan_update.php?id='.$row['id'].'">'.$row['InstID'].'</a></td>
                  <td>'.$row['Location'].'</td>
                  <td>'.$row['DateDeployed'].'</td>
                  <td>'.$row['DateReceived'].'</td>
                  <td>'.$row['Comments'].'</td>
                  <td>'.$row['PostDeploymentNotes'].'</td></tr>'.PHP_EOL;
    }
    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con);
}

//populate and provide ability to create instruments on loan
function onloan_input_form($db_id) {

    echo '<form role="form" class="form-horizontal" name="loanlog_input" action="UpdateLoanLog.php" method="post">
   
    <legend>Loan/Repair Entry</legend>   
    <fieldset>'.PHP_EOL;

    $con = dbConnection('../db_configs/db_config.php');
    //$query = "SHOW FULL COLUMNS FROM CruiseCastLogs ";
    $query = "SELECT * FROM InstrumentsOnLoan_OnRepair WHERE `id`='".$db_id."'";
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

//populate and provide ability to create instruments on loan
function onloan_input_form_new() {

    echo '<form role="form" class="form-horizontal" name="loanlog_input" action="AddNewLoanLog.php" method="post">
   
    <legend>Loan/Repair Entry</legend>   
    <fieldset>'.PHP_EOL;

    // get possible instruments from DB
    $con = dbConnection('../db_configs/db_config_inst.php');
    $query = "SELECT `InstID` FROM `all_instID` ORDER BY `InstID` ASC";
    $result = $con->query($query) or die($con->error.__LINE__);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
       $InstrumentOptions[] = $row['InstID'];
    }
    closeID($con); 
    
    
    $con = dbConnection('../db_configs/db_config.php');
    //$query = "SHOW FULL COLUMNS FROM CruiseCastLogs ";
    $query = "SHOW FULL COLUMNS FROM InstrumentsOnLoan_OnRepair";
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        if ( $row['Field'] == 'id') { continue; }
        elseif ( $row['Field'] == 'InstID') { 
            echo ' <div class="form-group">'.PHP_EOL;
            echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
            echo '<div class="col-md-6">';
            echo '<select name="'.$row['Field'].'">';
            foreach($InstrumentOptions as $key => $val) {
                echo '<option id="'.$row['Field'].'" value="'.$val.'">'.$val.'</option>'.PHP_EOL;
            }
            echo '</select>';
            echo '</div>';
            echo '</div>';
        } else {
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
    <input type="submit" class="btn btn-primary" value="Submit Update">
    </fieldset>
    </form>';
}

//populate and provide ability to choose instrument type for calibration records
function calibration_input_select($isactive='y') {

    echo '<form role="form" class="form-horizontal" name="calrecord_select" action="calibration_new.php" method="get">
   
    <legend>Calibration Record Entry</legend>   
    <fieldset>'.PHP_EOL;

    // get possible instruments from DB
    $con = dbConnection('../db_configs/db_config_inst.php');
    $query = "SELECT InstID, InstType, instrument_table, calibration_table 
                FROM (
                    select  InstID, InstType, 'inst_adcp' as instrument_table, 'cal_adcp' as calibration_table FROM inst_adcp
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_ecofluor' as instrument_table, 'cal_ecofluor' as calibration_table FROM inst_ecofluor
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_eppley' as instrument_table, 'cal_eppley' as calibration_table FROM inst_eppley
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_iceprof' as instrument_table, 'cal_iceprof' as calibration_table FROM inst_iceprof
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_licor' as instrument_table, 'cal_licor' as calibration_table FROM inst_licor
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_mtr' as instrument_table, 'cal_mtr' as instrument_table  FROM inst_mtr
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_nitrates' as instrument_table, 'cal_nitrates' as calibration_table FROM inst_nitrates
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_par' as instrument_table, 'cal_par' as instrument_table  FROM inst_par
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_pdim' as instrument_table, 'cal_pdim' as calibration_table FROM inst_pdim
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_rcm' as instrument_table, 'cal_rcm' as instrument_table  FROM inst_rcm
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_rcm_ancillary' as instrument_table, 'cal_rcm_ancillary' as calibration_table FROM inst_rcm_ancillary
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe16' as instrument_table, 'cal_sbe16' as calibration_table FROM inst_sbe16
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe19' as instrument_table, 'cal_sbe19' as calibration_table FROM inst_sbe19
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe26' as instrument_table, 'cal_sbe26' as calibration_table FROM inst_sbe26
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe3' as instrument_table, 'cal_sbe3' as calibration_table FROM inst_sbe3
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe37' as instrument_table, 'cal_sbe37' as calibration_table FROM inst_sbe37
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe38' as instrument_table, 'cal_sbe38' as calibration_table FROM inst_sbe38
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe39' as instrument_table, 'cal_sbe39' as calibration_table FROM inst_sbe39
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe4' as instrument_table, 'cal_sbe4' as calibration_table FROM inst_sbe4
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe43' as instrument_table, 'cal_sbe43' as calibration_table FROM inst_sbe43
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe49' as instrument_table, 'cal_sbe49' as calibration_table FROM inst_sbe49
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe5' as instrument_table, 'cal_sbe5' as calibration_table FROM inst_sbe5
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe56' as instrument_table, 'cal_sbe56' as calibration_table FROM inst_sbe56
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe49' as instrument_table, 'cal_sbe49' as calibration_table FROM inst_sbe49
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe56' as instrument_table, 'cal_sbe56' as calibration_table FROM inst_sbe56
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe9' as instrument_table, 'cal_sbe9' as calibration_table FROM inst_sbe9
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_spn1' as instrument_table, 'cal_spn1' as calibration_table FROM inst_spn1
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_wetstarfluor' as instrument_table, 'cal_wetstarfluor' as calibration_table FROM inst_wetstarfluor
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_windsensors' as instrument_table, 'cal_windsensors' as calibration_table FROM inst_windsensors
                    where IsActive LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_wxsensors' as instrument_table, 'cal_wxsensors' as calibration_table FROM inst_wxsensors
                    where IsActive LIKE '%$isactive%'
                    )t";
    $result = $con->query($query) or die($con->error.__LINE__);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
       $InstrumentOptions[] = $row['InstID'];
    }
    closeID($con); 
    
    echo ' <div class="form-group">'.PHP_EOL;
    echo '<div class="col-md-6">';
    echo '<select name="InstID">';
    foreach($InstrumentOptions as $key => $val) {
        echo '<option id="InstID" value="'.$val.'">'.$val.'</option>'.PHP_EOL;
    }
    echo '</select>';
    echo '</div>';
    echo '</div>';

    echo '
    <input type="submit" class="btn btn-primary" value="Submit Instrument">
    </fieldset>
    </form>';
}

//populate and provide ability to choose instrument type for calibration records
function event_input_select($isactive='GOOD') {

    echo '<form role="form" class="form-horizontal" name="eventrecord_select" action="eventrecord_new.php" method="get">
   
    <legend>Calibration Record Entry</legend>   
    <fieldset>'.PHP_EOL;

    // get possible instruments from DB
    $con = dbConnection('../db_configs/db_config_inst.php');
    $query = "SELECT InstID, InstType, instrument_table, calibration_table 
                FROM (
                    select  InstID, InstType, 'inst_adcp' as instrument_table, 'cal_adcp' as calibration_table FROM inst_adcp
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_ecofluor' as instrument_table, 'cal_ecofluor' as calibration_table FROM inst_ecofluor
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_eppley' as instrument_table, 'cal_eppley' as calibration_table FROM inst_eppley
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_iceprof' as instrument_table, 'cal_iceprof' as calibration_table FROM inst_iceprof
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_licor' as instrument_table, 'cal_licor' as calibration_table FROM inst_licor
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_mtr' as instrument_table, 'cal_mtr' as instrument_table  FROM inst_mtr
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_nitrates' as instrument_table, 'cal_nitrates' as calibration_table FROM inst_nitrates
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_par' as instrument_table, 'cal_par' as instrument_table  FROM inst_par
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_pdim' as instrument_table, 'cal_pdim' as calibration_table FROM inst_pdim
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_rcm' as instrument_table, 'cal_rcm' as instrument_table  FROM inst_rcm
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_rcm_ancillary' as instrument_table, 'cal_rcm_ancillary' as calibration_table FROM inst_rcm_ancillary
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe16' as instrument_table, 'cal_sbe16' as calibration_table FROM inst_sbe16
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe19' as instrument_table, 'cal_sbe19' as calibration_table FROM inst_sbe19
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe26' as instrument_table, 'cal_sbe26' as calibration_table FROM inst_sbe26
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe3' as instrument_table, 'cal_sbe3' as calibration_table FROM inst_sbe3
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe37' as instrument_table, 'cal_sbe37' as calibration_table FROM inst_sbe37
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe38' as instrument_table, 'cal_sbe38' as calibration_table FROM inst_sbe38
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe39' as instrument_table, 'cal_sbe39' as calibration_table FROM inst_sbe39
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe4' as instrument_table, 'cal_sbe4' as calibration_table FROM inst_sbe4
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe43' as instrument_table, 'cal_sbe43' as calibration_table FROM inst_sbe43
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe49' as instrument_table, 'cal_sbe49' as calibration_table FROM inst_sbe49
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe5' as instrument_table, 'cal_sbe5' as calibration_table FROM inst_sbe5
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe56' as instrument_table, 'cal_sbe56' as calibration_table FROM inst_sbe56
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe49' as instrument_table, 'cal_sbe49' as calibration_table FROM inst_sbe49
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe56' as instrument_table, 'cal_sbe56' as calibration_table FROM inst_sbe56
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_sbe9' as instrument_table, 'cal_sbe9' as calibration_table FROM inst_sbe9
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_spn1' as instrument_table, 'cal_spn1' as calibration_table FROM inst_spn1
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_wetstarfluor' as instrument_table, 'cal_wetstarfluor' as calibration_table FROM inst_wetstarfluor
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_windsensors' as instrument_table, 'cal_windsensors' as calibration_table FROM inst_windsensors
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_wxsensors' as instrument_table, 'cal_wxsensors' as calibration_table FROM inst_wxsensors
                    where ServiceStatus LIKE '%$isactive%'
                    union all
                    select  InstID, InstType, 'inst_wxsensors' as instrument_table, 'cal_sbeprawler' as calibration_table FROM inst_sbeprawler
                    where ServiceStatus LIKE '%$isactive%'
                    )t";
    $result = $con->query($query) or die($con->error.__LINE__);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
       $InstrumentOptions[] = $row['InstID'];
    }
    closeID($con); 
    
    echo ' <div class="form-group">'.PHP_EOL;
    echo '<div class="col-md-6">';
    echo '<select name="InstID">';
    foreach($InstrumentOptions as $key => $val) {
        echo '<option id="InstID" value="'.$val.'">'.$val.'</option>'.PHP_EOL;
    }
    echo '</select>';
    echo '</div>';
    echo '</div>';

    echo '
    <input type="submit" class="btn btn-primary" value="Submit Instrument">
    </fieldset>
    </form>';
}

//populate and provide ability to create calibration records
function calibration_input_form_new($InstID) {

    echo '<form role="form" class="form-horizontal" name="calrecord_input" action="AddNewCalRecords.php" method="post">
   
    <legend>Calibration Record Entry</legend>   
    <fieldset>'.PHP_EOL;

    // get possible instruments from DB
    $con = dbConnection('../db_configs/db_config_inst.php');
    $query = "SELECT InstID, InstType, instrument_table, calibration_table 
                FROM (
                    select  InstID, InstType, 'inst_adcp' as instrument_table, 'cal_adcp' as calibration_table FROM inst_adcp
                    union all
                    select  InstID, InstType, 'inst_ecofluor' as instrument_table, 'cal_ecofluor' as calibration_table FROM inst_ecofluor
                    union all
                    select  InstID, InstType, 'inst_eppley' as instrument_table, 'cal_eppley' as calibration_table FROM inst_eppley
                    union all
                    select  InstID, InstType, 'inst_iceprof' as instrument_table, 'cal_iceprof' as calibration_table FROM inst_iceprof
                    union all
                    select  InstID, InstType, 'inst_licor' as instrument_table, 'cal_licor' as calibration_table FROM inst_licor
                    union all
                    select  InstID, InstType, 'inst_mtr' as instrument_table, 'cal_mtr' as instrument_table  FROM inst_mtr
                    union all
                    select  InstID, InstType, 'inst_nitrates' as instrument_table, 'cal_nitrates' as calibration_table FROM inst_nitrates
                    union all
                    select  InstID, InstType, 'inst_par' as instrument_table, 'cal_par' as instrument_table  FROM inst_par
                    union all
                    select  InstID, InstType, 'inst_pdim' as instrument_table, 'cal_pdim' as calibration_table FROM inst_pdim
                    union all
                    select  InstID, InstType, 'inst_rcm' as instrument_table, 'cal_rcm' as instrument_table  FROM inst_rcm
                    union all
                    select  InstID, InstType, 'inst_rcm_ancillary' as instrument_table, 'cal_rcm_ancillary' as calibration_table FROM inst_rcm_ancillary
                    union all
                    select  InstID, InstType, 'inst_sbe16' as instrument_table, 'cal_sbe16' as calibration_table FROM inst_sbe16
                    union all
                    select  InstID, InstType, 'inst_sbe19' as instrument_table, 'cal_sbe19' as calibration_table FROM inst_sbe19
                    union all
                    select  InstID, InstType, 'inst_sbe26' as instrument_table, 'cal_sbe26' as calibration_table FROM inst_sbe26
                    union all
                    select  InstID, InstType, 'inst_sbe3' as instrument_table, 'cal_sbe3' as calibration_table FROM inst_sbe3
                    union all
                    select  InstID, InstType, 'inst_sbe37' as instrument_table, 'cal_sbe37' as calibration_table FROM inst_sbe37
                    union all
                    select  InstID, InstType, 'inst_sbe38' as instrument_table, 'cal_sbe38' as calibration_table FROM inst_sbe38
                    union all
                    select  InstID, InstType, 'inst_sbe39' as instrument_table, 'cal_sbe39' as calibration_table FROM inst_sbe39
                    union all
                    select  InstID, InstType, 'inst_sbe4' as instrument_table, 'cal_sbe4' as calibration_table FROM inst_sbe4
                    union all
                    select  InstID, InstType, 'inst_sbe43' as instrument_table, 'cal_sbe43' as calibration_table FROM inst_sbe43
                    union all
                    select  InstID, InstType, 'inst_sbe49' as instrument_table, 'cal_sbe49' as calibration_table FROM inst_sbe49
                    union all
                    select  InstID, InstType, 'inst_sbe5' as instrument_table, 'cal_sbe5' as calibration_table FROM inst_sbe5
                    union all
                    select  InstID, InstType, 'inst_sbe56' as instrument_table, 'cal_sbe56' as calibration_table FROM inst_sbe56
                    union all
                    select  InstID, InstType, 'inst_sbe49' as instrument_table, 'cal_sbe49' as calibration_table FROM inst_sbe49
                    union all
                    select  InstID, InstType, 'inst_sbe56' as instrument_table, 'cal_sbe56' as calibration_table FROM inst_sbe56
                    union all
                    select  InstID, InstType, 'inst_sbe9' as instrument_table, 'cal_sbe9' as calibration_table FROM inst_sbe9
                    union all
                    select  InstID, InstType, 'inst_sbeprawler' as instrument_table, 'cal_sbeprawler' as calibration_table FROM inst_sbeprawler
                    union all
                    select  InstID, InstType, 'inst_spn1' as instrument_table, 'cal_spn1' as calibration_table FROM inst_spn1
                    union all
                    select  InstID, InstType, 'inst_wetstarfluor' as instrument_table, 'cal_wetstarfluor' as calibration_table FROM inst_wetstarfluor
                    union all
                    select  InstID, InstType, 'inst_windsensors' as instrument_table, 'cal_windsensors' as calibration_table FROM inst_windsensors
                    union all
                    select  InstID, InstType, 'inst_wxsensors' as instrument_table, 'cal_wxsensors' as calibration_table FROM inst_wxsensors
                    )t WHERE `InstID` = '".$InstID."'";
    $result = $con->query($query) or die($con->error.__LINE__);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
       $InstrumentOptions = $row;
    }

    //$query = "SHOW FULL COLUMNS FROM CruiseCastLogs ";
    $query = "SHOW FULL COLUMNS FROM ".$InstrumentOptions['calibration_table'];
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $inst_temp = explode(" ", $InstID);
        $SerialNo = array_pop($inst_temp);
        $InstType = implode(" ",$inst_temp);
        if ( $row['Field'] == 'id') { continue; }
        elseif ( $row['Field'] == 'InstID') { 
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input size="35" type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" value="'.$InstID.'" readonly>   '.PHP_EOL;
        echo '<input type="hidden" name="db_id" id="db_id" value="'.$InstrumentOptions['calibration_table'].'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
        } elseif ( $row['Field'] == 'InstType') { 
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input size="35" type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" value="'.$InstType.'" readonly>   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
        } elseif ( $row['Field'] == 'SerialNo') { 
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input size="35" type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" value="'.$SerialNo.'" readonly>   '.PHP_EOL;
        echo '</div>';
        echo '</div>';
        } else {
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$row['Field'].'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input size="35" type="text" name="'.$row['Field'].'" id="'.$row['Field'].'" placeholder="'.$row['Comment'].'">   '.PHP_EOL;
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

//populate and provide ability to create calibration records
function event_input_form_new($InstID) {

    echo '<form role="form" class="form-horizontal" name="event_input" action="ShowEventRecords.php" method="post" target="iframe_event">
   
    <legend>Event Record Builder</legend>   
    <fieldset>'.PHP_EOL;


    //Get fieldnames and comments from database 
    $inst_temp = explode(" ", $InstID);
    $SerialNo = array_pop($inst_temp);
    $InstType = implode(" ",$inst_temp);

    echo ' <div class="form-group">'.PHP_EOL;
    echo '<label for="InstID" class="col-md-3 control-label">InstID</label>   '.PHP_EOL;
    echo '<div class="col-md-6">';
    echo '<input size="35" type="text" name="InstID" id="InstID" value="'.$InstID.'" readonly>   '.PHP_EOL;
    echo '</div>';
    echo '</div>';
    echo ' <div class="form-group">'.PHP_EOL;
    echo '<label for="notes" class="col-md-3 control-label">notes</label>   '.PHP_EOL;
    echo '<div class="col-md-6">';
    echo '<input size="35" type="text" name="notes" id="notes" value="" >   '.PHP_EOL;
    echo '</div>';
    echo '</div>';
    echo ' <div class="form-group">'.PHP_EOL;
    echo '<label for="location" class="col-md-3 control-label">location</label>   '.PHP_EOL;
    echo '<div class="col-md-6">';
    echo '<input size="35" type="text" name="location" id="location" value="" >   '.PHP_EOL;
    echo '</div>';
    echo '</div>';    
    echo ' <div class="form-group">'.PHP_EOL;
    echo '<label for="current_use" class="col-md-3 control-label">current_use</label>   '.PHP_EOL;
    echo '<div class="col-md-6">';
    echo '<input size="35" type="text" name="current_use" id="current_use" value="" >   '.PHP_EOL;
    echo '</div>';
    echo '</div>'; 
    echo ' <div class="form-group">'.PHP_EOL;
    echo '<label for="recorder_email" class="col-md-3 control-label">recorder_email</label>   '.PHP_EOL;
    echo '<div class="col-md-6">';
    echo '<input size="35" type="email" name="recorder_email" id="recorder_email" value="" >   '.PHP_EOL;
    echo '</div>';
    echo '</div>';
    echo ' <div class="form-group">'.PHP_EOL;
    echo '<label for="entry_date" class="col-md-3 control-label">entry_date</label>   '.PHP_EOL;
    echo '<div class="col-md-6">';
    echo '<input size="35" type="date" name="entry_date" id="entry_date" value="" >   '.PHP_EOL;
    echo '</div>';
    echo '</div>';    
    echo '
    <input type="submit" class="btn btn-primary" value="Submit Update">
    </fieldset>
    </form>';

    echo '<hr>Resulting Message: (paste into an individual text file for github upload and add to following project: <a href="https://github.com/NOAA-PMEL/EcoFOCI_FieldOps_Documentation/tree/master/InstrumentEventRecords">Instrument Event Records </a><br>
    Use the following date/time as the filename: '.date("Y-m-d_H:i:s").'.csv';
    echo '<iframe seamless src="about:blank" width="100%" id="iframe_event" name="iframe_event"></iframe>';

}

//populate and provide ability to update instrument log based on id
function instrument_select_input_form($db_id) {

    echo '<form role="form" class="form-horizontal" name="instlog_input" action="UpdateInstrumentLog.php" method="post">
   
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
        } elseif ( $key == 'DateTimeOffGMT') { 
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$key.'" class="col-md-3 control-label">'.$key.'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" class="form-control" name="'.$key.'" id="'.$key.'" value="'.$val.'">   '.PHP_EOL;
        echo '</div>';
        echo '</div>'; 
        } elseif ( $key == 'Deployed') {
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$key.'</label>   '.PHP_EOL;
        echo '<div class="col-md-3">';
        echo enumDropdown('mooringdeployedinstruments', 'Deployed', $val, false); 
        echo '</div>';
        echo '</div>';
        } elseif ( $key == 'Recovered') {
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$key.'</label>   '.PHP_EOL;
        echo '<div class="col-md-3">';
        echo enumDropdown('mooringdeployedinstruments', 'Recovered',$val, false); 
        echo '</div>';
        echo '</div>';
        } elseif ( $key == 'DataStatus') {
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$row['Field'].'" class="col-md-3 control-label">'.$key.'</label>   '.PHP_EOL;
        echo '<div class="col-md-3">';
        echo enumDropdown('mooringdeployedinstruments', 'DataStatus',$val, false); 
        echo '</div>';
        echo '</div>';
        } else {
        echo ' <div class="form-group">'.PHP_EOL;
        echo '<label for="'.$key.'" class="col-md-3 control-label">'.$key.'</label>   '.PHP_EOL;
        echo '<div class="col-md-6">';
        echo '<input type="text" class="form-control" name="'.$key.'" id="'.$key.'" value="'.$val.'">   '.PHP_EOL;
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

//Modal input
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
		else {
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

function view_quicklook_select($path) {

    $files1 = scandir($path);

    echo '<div class="table-responsive" ><table id="" class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th>Instrument File</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
    echo $files;
    foreach ($files1 as $value) {

        echo '<tr><td><a href="MooringQuicklooks_dygraph.php?MooringID='.explode('.', $value, 2)[0].'">'.$value.'</a></td></tr>'.PHP_EOL;
    }
    
    echo '</tbody></table></div>'.PHP_EOL;
}
?>