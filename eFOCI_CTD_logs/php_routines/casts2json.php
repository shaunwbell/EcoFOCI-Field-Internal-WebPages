<?php
function casts2json($UniqueCruiseID) {
    $host = "localhost";
    $user = "pythonuser";
    $password = "e43mqS4fusEaGJLE";
    $db = "EcoFOCI_Cruises";

    $con = new mysqli($host,$user,$password, $db);

    if (mysqli_connect_errno()) {
        echo "Database connection failed ";
        exit();
    } 


    $query = "SELECT * from `cruisecastlogs` WHERE `UniqueCruiseID` = '".$UniqueCruiseID."' ORDER BY `ConsecutiveCastNo`;"; 
        
    $result = $con->query($query) or die($con->error.__LINE__);

    echo "{";

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo '"'.strtotime($row['GMTDay'].' '.$row['GMTMonth'].' '.$row['GMTYear'].' '.$row['GMTTime']).'":1,';
    }
    echo "}".PHP_EOL;

}


function casts2json_mindate($UniqueCruiseID) {

    $host = "localhost";
    $user = "pythonuser";
    $password = "e43mqS4fusEaGJLE";
    $db = "EcoFOCI_Cruises";

    $con = new mysqli($host,$user,$password, $db);

    if (mysqli_connect_errno()) {
        echo "Database connection failed ";
        exit();
    } 


    $query = "SELECT * from `cruisecastlogs` WHERE `UniqueCruiseID` = '".$UniqueCruiseID."' limit 1;"; 
        
    $result = $con->query($query) or die($con->error.__LINE__);

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo $row['GMTYear'];
    }
}

// retrieve met observations from cruise logs for plotting
function casts2json_met($UniqueCruiseID) {
    $host = "localhost";
    $user = "pythonuser";
    $password = "e43mqS4fusEaGJLE";
    $db = "EcoFOCI_Cruises";

    $con = new mysqli($host,$user,$password, $db);

    if (mysqli_connect_errno()) {
        echo "Database connection failed ";
        exit();
    } 


    $query = "SELECT * from `cruisecastlogs` WHERE `UniqueCruiseID` = '".$UniqueCruiseID."'ORDER BY `ConsecutiveCastNo`;"; 
        
    $result = $con->query($query) or die($con->error.__LINE__);

    echo "{";

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        echo '"'.strtotime($row['GMTDay'].' '.$row['GMTMonth'].' '.$row['GMTYear'].' '.$row['GMTTime']).'":'.$row['DryBulb'].',';
    }
    echo "}".PHP_EOL;

}

// retrieve met observations from cruise logs for plotting
function casts2csv_met($UniqueCruiseID, $param) {
    $host = "localhost";
    $user = "pythonuser";
    $password = "e43mqS4fusEaGJLE";
    $db = "EcoFOCI_Cruises";

    $con = new mysqli($host,$user,$password, $db);

    if (mysqli_connect_errno()) {
        echo "Database connection failed ";
        exit();
    } 


    $query = "SELECT * from `cruisecastlogs` WHERE `UniqueCruiseID` = '".$UniqueCruiseID."' AND `Pressure` != '-9999' ORDER BY `ConsecutiveCastNo` ASC;"; 
        
    $result = $con->query($query) or die($con->error.__LINE__);

    echo "[";

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $timestamp = explode( ':', $row['GMTTime'] );
        echo '[Date.UTC('.$row['GMTYear'].','.(Date('m', strtotime($row['GMTDay'].' '.$row['GMTMonth'].' '.$row['GMTYear']))-1).','.$row['GMTDay'].', '.$timestamp[0].', '.$timestamp[1].', '.$timestamp[2].'),'.$row[$param].'],'.PHP_EOL;
    }
    echo "]".PHP_EOL;

}

// retrieve met observations from cruise logs for plotting
function casts2csv_wind($UniqueCruiseID, $param1, $param2) {
    $host = "localhost";
    $user = "pythonuser";
    $password = "e43mqS4fusEaGJLE";
    $db = "EcoFOCI_Cruises";

    $con = new mysqli($host,$user,$password, $db);

    if (mysqli_connect_errno()) {
        echo "Database connection failed ";
        exit();
    } 


    $query = "SELECT * from `cruisecastlogs` WHERE `UniqueCruiseID` = '".$UniqueCruiseID."' AND `WindSpd` != '-99' ORDER BY `ConsecutiveCastNo` ASC;"; 
        
    $result = $con->query($query) or die($con->error.__LINE__);

    echo "[";

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $timestamp = explode( ':', $row['GMTTime'] );
        echo '[Date.UTC('.$row['GMTYear'].','.(Date('m', strtotime($row['GMTDay'].' '.$row['GMTMonth'].' '.$row['GMTYear']))-1).','.$row['GMTDay'].', '.$timestamp[0].', '.$timestamp[1].'),'.$row[$param1].','.$row[$param2].'],'.PHP_EOL;
    }
    echo "]".PHP_EOL;

}
?>