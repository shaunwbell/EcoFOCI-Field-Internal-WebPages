<?php

include('utilities.php');

//database functions
function dbConnection(){
    include('../db_configs/db_config.php');
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

    $con = dbConnection();
    
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
    


// report generator routines

function cal_report(){

    $con = dbConnection();
    
    $query = "Select max(cal_iceprof.CalDate) as CalDate, inst_iceprof.SerialNo, inst_iceprof.InstID
            From `cal_iceprof`
            RIGHT JOIN `inst_iceprof`
            USING(SerialNo)
            GROUP BY inst_iceprof.SerialNo";
            
    $result = $con->query($query) or die($con->error.__LINE__);
    
    echo '<div style="padding-left:40px;"><table class="table table-condensed table-hover table-bordered">
  <thead>
    <tr>
      <th>ID and Serial Number</th>
      <th>Calibration Date</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            if ($row['CalDate'] == NULL) { 
            echo '<tr class="danger"><td>'.$row['InstID'].' '.$row['SerialNo'].'</td>
                  <td>No Calibration History</td></tr>'.PHP_EOL;
            } else {
            $DSC = days_since_date($row['CalDate']);
            if ($DSC > 365) {
            echo '<tr class="info"><td>'.$row['InstID'].' '.$row['SerialNo'].'</td>
                  <td>'.$row['CalDate'].'</td></tr>'.PHP_EOL;
                  } else {
            echo '<tr><td>'.$row['InstID'].' '.$row['SerialNo'].'</td>
                  <td>'.$row['CalDate'].'</td></tr>'.PHP_EOL;
                  }            
            }
    }
    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con); // returns array of ice profilers instruments with unique serial numbers 
    }

// Last Known location
function location_report(){

    $con = dbConnection();
    
    $query = "Select max(cal_iceprof.CalDate) as CalDatec, max(operations_iceprof.DeployDate) as DeployDate,
            max(operations_iceprof.RecoveryDate) as RecoveryDate, inst_iceprof.SerialNo, inst_iceprof.InstID
            From `inst_iceprof`
            LEFT JOIN `cal_iceprof`
            USING(SerialNo)
            LEFT JOIN `operations_iceprof`
            USING(SerialNo)
            GROUP BY inst_iceprof.SerialNo";
            
    $result = $con->query($query) or die($con->error.__LINE__);
    

    echo '<div style="padding-left:40px;"><table class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th>ID and Serial Number</th>
      <th>Location Date</th>
      <th>Last Known Operation</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tarray = array('a'=>$row['CalDatec'], 'b'=>$row['DeployDate'], 'c'=>$row['RecoveryDate']);
        $maxs = array_keys($tarray, max($tarray));

        if (empty(array_filter($tarray))) {
        echo '<tr class=warning><td>'.$row['InstID'].'</td>
              <td>'.$tarray[$maxs[0]].'</td><td> N/A </td></tr>'.PHP_EOL;
        } else {    
        if ($maxs[0] == 'a') { $deptype = 'Calibration'; }
        elseif ($maxs[0] == 'b') { $deptype = 'On Field Operation'; }
        elseif ($maxs[0] == 'c') { $deptype = 'Recovered From Field Operation'; }
        
        echo '<tr><td>'.$row['InstID'].' '.$row['SerialNo'].'</td>
              <td>'.$tarray[$maxs[0]].'</td><td>'.$deptype.'</td></tr>'.PHP_EOL;
        }
        $tarray = array();
    }
    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con); // returns array of ice profilers instruments with unique serial numbers 
    }

function software_report(){

    $con = dbConnection();
    
    $query = "Select max(upgrade_iceprof.`FirmwareVersion`) as ugfw, inst_iceprof.original_firmware_version as orfw, inst_iceprof.SerialNo, inst_iceprof.InstID
            From `inst_iceprof`
            left JOIN `upgrade_iceprof`
            USING(SerialNo)
            GROUP BY inst_iceprof.SerialNo";
            
    $result = $con->query($query) or die($con->error.__LINE__);
    

    $query = "SELECT max(`firmware_version`) AS maxfv FROM software_iceprof";
            
    $result2 = $con->query($query) or die($con->error.__LINE__);
    $curr_ver=mysqli_fetch_array($result2,MYSQLI_ASSOC);
    
    echo '<div style="padding-left:40px;"><table class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th>ID and Serial Number</th>
      <th>Required Firmware Version</th>
      <th>Current Firmware Version</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

    
        if ($curr_ver['maxfv'] == $row['ugfw']) { 
                echo '<tr><td>'.$row['InstID'].' '.$row['SerialNo'].'</td>
              <td>'.$curr_ver['maxfv'].'</td><td>'.$row['ugfw'].'</td></tr>'.PHP_EOL;
        } elseif ($curr_ver['maxfv'] == $row['orfw']) { 
                echo '<tr><td>'.$row['InstID'].' '.$row['SerialNo'].'</td>
              <td>'.$curr_ver['maxfv'].'</td><td>'.$row['orfw'].'</td></tr>'.PHP_EOL;
        } else {
            if ( $row['ugfw'] == "") { 
                echo '<tr  class=error><td>'.$row['InstID'].' '.$row['SerialNo'].'</td>
              <td>'.$curr_ver['maxfv'].'</td><td>'.$row['orfw'].'</td></tr>'.PHP_EOL;
            }
            else { 
                echo '<tr class=error><td>'.$row['InstID'].' '.$row['SerialNo'].'</td>
                    <td>'.$curr_ver['maxfv'].'</td><td>'.$row['ugfw'].'</td></tr>'.PHP_EOL;
            }

        }
    }
    
    echo '</tbody></table></div>'.PHP_EOL;

    closeID($con); // returns array of ice profilers instruments with unique serial numbers 
    }

?>