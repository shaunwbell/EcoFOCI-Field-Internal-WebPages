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
    
function instsummary_select() {

    echo '<div class="well bs-component">
    <form class="form-horizontal" id="instsummary" action="utilities_instsummary.php" method="get">
    <fieldset>
    <legend>Provide information stats and summary of deployed instruments for date range</legend>   
    <div class="form-group">'.PHP_EOL;


    
    echo '</div><br>
    <div class="form-group">
    <label for="StartYear" class="col-xs-5 control-label">Start Year</label>
    <input name="StartYear" type="date" value="2015-08-31"><br><br>
    <label for="EndYear" class="col-xs-5 control-label">End Year</label>
    <input name="EndYear" type="date" value="2016-08-31"><br><br><br>
    </div>
    <div class="form-group">
    <div class="col-xs-5">
    <input type="submit" class="btn btn-primary btn-sm" value="Show" id="instsummary">
    </div></div>
    </fieldset>
    </form>
    </div>';
    

}

//table of operations summary from chosen date window
function instrument_operations_summary($startyear,$endyear,$recovered,$mooring_sum){

    $con = dbConnection('../db_configs/db_config_inst.php');
    
    if ($mooring_sum == 'n') {
    if ($recovered == 'current') {
     $query = "SELECT  count(*), c.DeploymentDateTimeGMT, c.MooringID, c.InstType, c.Deployed From (SELECT b.DeploymentDateTimeGMT, a.InstType, a.Deployed, a.MooringID
            FROM `ecofoci`.`mooringdeployedinstruments` a
            LEFT JOIN `ecofoci`.`mooringdeploymentlogs` b on
            a.MooringID = b.MooringID where a.Deployed = 'y' AND a.Recovered = '') as c group by InstType";
    } elseif ($recovered == '') {
     $query = "SELECT  count(*), c.DeploymentDateTimeGMT, c.MooringID, c.InstType, c.Deployed From (SELECT b.DeploymentDateTimeGMT, a.InstType, a.Deployed, a.MooringID
            FROM `ecofoci`.`mooringdeployedinstruments` a
            LEFT JOIN `ecofoci`.`mooringdeploymentlogs` b on
            a.MooringID = b.MooringID where b.DeploymentDateTimeGMT BETWEEN '".$startyear."' AND '".$endyear."' AND a.Deployed = 'y' ) as c group by InstType";
    } else {
     $query = "SELECT  count(*), c.RecoveryDateTimeGMT, c.MooringID, c.InstType, c.Deployed From (SELECT b.RecoveryDateTimeGMT, a.InstType, a.Deployed, a.Recovered, a.MooringID
            FROM `ecofoci`.`mooringdeployedinstruments` a
            LEFT JOIN `ecofoci`.`mooringrecoverylogs` b on
            a.MooringID = b.MooringID where b.RecoveryDateTimeGMT >= '".$startyear."' AND a.Recovered = '".$recovered."' ) as c 
        LEFT JOIN `ecofoci`.`mooringrecoverylogs` d on 
        c.MooringID = d.MooringID WHERE d.RecoveryDateTimeGMT <= '".$endyear."' group by InstType";
    }
    $result = $con->query($query) or die($con->error.__LINE__);
  
    echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
    <thead>
      <tr>
        <th>Instrument Type</th>
        <th>Number Deployed/Recovered/Lost</th>
      </tr>
    </thead>
    <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {


        echo '<tr>
              <td>'.$row['InstType'].'</td>        
              <td>'.$row['count(*)'].'</td></tr>'.PHP_EOL;        
        
    }

    echo '</tbody></table></div>'.PHP_EOL;
    }

    if ($mooring_sum == 'n') {
    if ($recovered == 'current') {
     $query = "SELECT c.DeploymentDateTimeGMT, c.MooringID, c.InstType, c.Deployed From (SELECT b.DeploymentDateTimeGMT, a.InstType, a.Deployed, a.MooringID
            FROM `ecofoci`.`mooringdeployedinstruments` a
            LEFT JOIN `ecofoci`.`mooringdeploymentlogs` b on
            a.MooringID = b.MooringID where a.Deployed = 'y' and a.Recovered = '') as c group by MooringID";
    } elseif ($recovered == '') {
     $query = "SELECT c.DeploymentDateTimeGMT, c.MooringID, c.InstType, c.Deployed From (SELECT b.DeploymentDateTimeGMT, a.InstType, a.Deployed, a.MooringID
            FROM `ecofoci`.`mooringdeployedinstruments` a
            LEFT JOIN `ecofoci`.`mooringdeploymentlogs` b on
            a.MooringID = b.MooringID where b.DeploymentDateTimeGMT BETWEEN '".$startyear."' AND '".$endyear."' AND a.Deployed = 'y' ) as c group by MooringID";
    } else {
     $query = "SELECT c.RecoveryDateTimeGMT, c.MooringID, c.InstType, c.Deployed From (SELECT b.RecoveryDateTimeGMT, a.InstType, a.Deployed, a.Recovered, a.MooringID
            FROM `ecofoci`.`mooringdeployedinstruments` a
            LEFT JOIN `ecofoci`.`mooringrecoverylogs` b on
            a.MooringID = b.MooringID where b.RecoveryDateTimeGMT >= '".$startyear."' AND a.Recovered = '".$recovered."' ) as c 
        LEFT JOIN `ecofoci`.`mooringrecoverylogs` d on 
        c.MooringID = d.MooringID WHERE d.RecoveryDateTimeGMT <= '".$endyear."' group by MooringID";
    }
    $result = $con->query($query) or die($con->error.__LINE__);
  
    echo '<h4>From these Moorings:</h4>'.PHP_EOL;
    echo '<ul>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

        echo '<li>'.$row['MooringID'].'</li>'.PHP_EOL;        
        
    }

    echo '</ul>'.PHP_EOL;
    }

    closeID($con); 
    }


function instrument_datastatus(){
    $con = dbConnection('../db_configs/db_config.php');

    //Read Instrument status from Database
    //SQL input
    $query = "SELECT mdi.MooringID,mdi.id,Depth,ActualDepth,InstID,PostDeploymentNotes,DataStatus,Deployed,Recovered FROM `mooringdeployedinstruments` as mdi
            LEFT JOIN `mooringdeploymentlogs` as md on
            md.MooringID = mdi.MooringID WHERE md.`DeploymentDateTimeGMT` >'2013-01-01' ORDER BY md.`DeploymentDateTimeGMT` DESC ";

    //Prepare insert statements
    $result = $con->query($query) or die($con->error.__LINE__);

    echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
    <thead>
      <tr>
        <th>Mooring ID</th>
        <th>Instrument ID</th>
        <th>Est. Depth</th>
        <th>Depth</th>
        <th>Data Status</th>
        <th>Notes</th>
        <th>Deployed</th>
        <th>Recovered</th>
      </tr>
    </thead>
    <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

        if ($row['Deployed'] === 'n') {
        $row_class='strikeout';
        } elseif ($row['Deployed'] === 'y' and $row['Recovered'] === 'n'){
        $row_class='strikeout red';
        } elseif ($row['Deployed'] === 'y' and $row['Recovered'] === 'y' and $row['DataStatus'] === 'no data'){
        $row_class='strikeout red';
        } elseif ($row['Deployed'] === 'y' and $row['Recovered'] === 'y' and $row['DataStatus'] === 'final'){
        $row_class='green';
        } elseif ($row['Deployed'] === 'y' and $row['Recovered'] === 'y' and $row['DataStatus'] === 'downloaded'){
        $row_class='blue';
        } elseif ($row['Deployed'] === 'y' and $row['Recovered'] === 'y' and $row['DataStatus'] === 'unqcd'){
        $row_class='blue';
        } elseif ($row['DataStatus'] === 'n/a'){
        $row_class='hidden';
        } else {
        $row_class='';
        }

        echo '<tr class="'.$row_class.'">
              <td>'.$row['MooringID'].'</td>
              <td><a href="operations_update.php?id='.$row['id'].'">'.$row['InstID'].'</a></td>
              <td>'.$row['Depth'].'</td>
              <td>'.$row['ActualDepth'].'</td>
              <td>'.$row['DataStatus'].'</td>        
              <td>'.$row['PostDeploymentNotes'].'</td>
              <td>'.$row['Deployed'].'</td>
              <td>'.$row['Recovered'].'</td>
              </tr>'.PHP_EOL;        
        
    
    }

    echo '</tbody></table></div>'.PHP_EOL;

    closeID($con); 

}

function summary_mooring_datastatus (){
    //Get Current Year
    $max_year = date("y") + 1;
    $min_year = 1;
    
    $con = dbConnection('../db_configs/db_config.php');

    //Get MooringID
    $query = "SELECT * FROM MooringDeploymentLogs WHERE `MooringID` BETWEEN ".$min_year." AND ".$max_year." ORDER BY `MooringID` DESC";

    $MooringID = $con->query($query) or die($con->error.__LINE__);

    echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
    <thead>
      <tr>
        <th>Mooring ID</th>
        <th># deployed</th>
        <th># recovered</th>
        <th># downloaded</th>
        <th># unqcd</th>
        <th># final</th>
        <th># n/a</th>
      </tr>
    </thead>
    <tbody>'.PHP_EOL;

 

    while($row = $MooringID->fetch_array(MYSQLI_BOTH)) {
        echo '<tr>
          <td>'.$row['MooringID'].'</td>'.PHP_EOL;

        // count all listed as deployed
        $query = "SELECT COUNT(*) FROM mooringdeployedinstruments WHERE `MooringID` LIKE '".$row['MooringID']."' and `Deployed` LIKE 'y'";
        $count = $con->query($query) or die($con->error.__LINE__);
        $innerrow = $count->fetch_array(MYSQLI_BOTH);
        echo '
          <td>'.$innerrow[0].'</td>'.PHP_EOL;

        // count all listed as recovered
        $query = "SELECT COUNT(*) FROM mooringdeployedinstruments WHERE `MooringID` LIKE '".$row['MooringID']."' and `Recovered` LIKE 'y'";
        $count = $con->query($query) or die($con->error.__LINE__);
        $innerrow = $count->fetch_array(MYSQLI_BOTH);
        echo '
          <td>'.$innerrow[0].'</td>'.PHP_EOL;

        // count all listed as downloaded
        $query = "SELECT COUNT(*) FROM mooringdeployedinstruments WHERE `MooringID` LIKE '".$row['MooringID']."' and `DataStatus` LIKE 'downloaded'";
        $count = $con->query($query) or die($con->error.__LINE__);
        $innerrow = $count->fetch_array(MYSQLI_BOTH);
        echo '
          <td>'.$innerrow[0].'</td>'.PHP_EOL; 

        // count all listed as unqcd
        $query = "SELECT COUNT(*) FROM mooringdeployedinstruments WHERE `MooringID` LIKE '".$row['MooringID']."' and `DataStatus` LIKE 'unqcd'";
        $count = $con->query($query) or die($con->error.__LINE__);
        $innerrow = $count->fetch_array(MYSQLI_BOTH);
        echo '
          <td>'.$innerrow[0].'</td>'.PHP_EOL; 

        // count all listed as final
        $query = "SELECT COUNT(*) FROM mooringdeployedinstruments WHERE `MooringID` LIKE '".$row['MooringID']."' and `DataStatus` LIKE 'final'";
        $count = $con->query($query) or die($con->error.__LINE__);
        $innerrow = $count->fetch_array(MYSQLI_BOTH);
        echo '
          <td>'.$innerrow[0].'</td>'.PHP_EOL; 

        // count all listed as final
        $query = "SELECT COUNT(*) FROM mooringdeployedinstruments WHERE `MooringID` LIKE '".$row['MooringID']."' and `DataStatus` LIKE 'n/a'";
        $count = $con->query($query) or die($con->error.__LINE__);
        $innerrow = $count->fetch_array(MYSQLI_BOTH);
        echo '
          <td>'.$innerrow[0].'</td>
          </tr>'.PHP_EOL; 
        }

    closeID($con); 
}
?>