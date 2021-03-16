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
    
function findnearestctd_select() {

    echo '<div class="well bs-component">
    <form class="form-horizontal" id="findnearestctd" action="utilities_findnearestctd.php" method="get">
    <fieldset>
    <legend>Find Nearest CTD to chosen Mooring Site for years and distance range</legend>   
    <div class="form-group">'.PHP_EOL;

   
    $con = dbConnection('../db_configs/db_config.php');

    //Get MooringID
    $query = "SELECT * FROM MooringDeploymentLogs ORDER BY `MooringID` DESC";
    $MooringID = $con->query($query) or die($con->error.__LINE__);
    
    echo '<label for="mooringid" class="col-xs-4 control-label">MooringID</label>
            <div class="col-xs-4">
            <select class="form-control" name="mooringid">'.PHP_EOL;
            
    while($row = $MooringID->fetch_array(MYSQLI_BOTH)) {
        echo "    <option value=" . $row['MooringID'] . ">". $row['MooringID'] . "</option>". PHP_EOL;
        }

    closeID($con);
    
    
    echo '</select></div></div><br>
    <div class="form-group">
    <label for="StartYear" class="col-xs-5 control-label">Start Year</label>
    <input type="number" name="StartYear" size="15" value=""><br><br>
    <label for="EndYear" class="col-xs-5 control-label">End Year</label>
    <input type="number" name="EndYear" size="15" value=""><br><br><br>
    <label for="distance" class="col-xs-5 control-label">Max Distance (km)</label>
    <input type="number" name="distance" size="15" value=""><br><br><br>
    </div>
    <div class="form-group">
    <div class="col-xs-5">
    <input type="submit" class="btn btn-primary btn-sm" value="Calculate" id="findnearestctd">
    </div></div>
    </fieldset>
    </form>
    </div>';
    

}

function mooring_location($mooringid) {
    $con = dbConnection('../db_configs/db_config.php');
    
    $query = "SELECT `Latitude`,`Longitude` from `mooringdeploymentlogs` 
        WHERE `MooringID`='".$mooringid."'";
            
    $result = $con->query($query) or die($con->error.__LINE__);
    
    $row = $result->fetch_array(MYSQLI_ASSOC); 
    $latdd = explode(" ",$row['Latitude'])[0] + explode(" ",$row['Latitude'])[1] / 60;
    $londd = explode(" ",$row['Longitude'])[0] + explode(" ",$row['Longitude'])[1] / 60;
    
    return array ($latdd,$londd);
}


function ctd_location($StartYear,$EndYear) {
    $con = dbConnection('../db_configs/db_config_cruisecastlogs.php');
    
    $query = "SELECT `UniqueCruiseID`,`ConsecutiveCastNo`,`LatitudeDeg`,`LongitudeDeg`,
    `LatitudeMin`,`LongitudeMin` from `cruisecastlogs` WHERE `GMTYear`>='".$StartYear.
    "' and `GMTYear`<='".$EndYear."'"; 
    
    $result = $con->query($query) or die($con->error.__LINE__);
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) { 
        $ctd_reports[] = $row;
    }
    return $ctd_reports;
}

?>