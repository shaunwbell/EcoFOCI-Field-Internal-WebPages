<?php

function dbConnection(){
    include('db_config_meta.php');
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
    
function get_MooringCode(){

    $con = dbConnection();
    
    $query = "SELECT DISTINCT Mooring_Code FROM Mooring_MetaInformation ";
    $result = $con->query($query) or die($con->error.__LINE__);
    
    $array_vals = [];
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        foreach ($row as $columnName => $columnData) {
            $array_vals[] = $columnData;
        }
    }
    closeID($con); // returns array of unique MooringID's from mooring datafiles
    
    return $array_vals;

    }
    
function get_MooringName($array_vals){

    $con = dbConnection();
    
    $query = "SELECT * FROM MooringSite_Basic ";
    $result = $con->query($query) or die($con->error.__LINE__);
    
    $id2name = array();
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $id2name[$row['Mooring_Code']] = ($row['Name']);
    }    

    closeID($con);

    return($id2name); //returns array MooringCode => Full Name (based on detailed database)
}

function get_MooringYear($input){

    $con = dbConnection();
    
    $query = "SELECT * FROM Mooring_MetaInformation WHERE `Mooring_Code`='".$input."'";
    $result = $con->query($query) or die($con->error.__LINE__);
    
    $id2name = array();
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $id2year[$row['Year']] = ($row['Mooring_Code']);
    }    

    closeID($con);

    return($id2year); //returns array year => Mooring_Code (2digit) (based on detailed database)
}

function get_MooringLongCode($MID, $YEAR){

    $con = dbConnection();
    
    $query = "SELECT * FROM Mooring_MetaInformation WHERE `Mooring_Code`='".$MID."' AND `Year`='".$YEAR."'";
    $result = $con->query($query) or die($con->error.__LINE__);
    
    $id2name = array();
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $mooringPath[$row['Mooring_ID']] = ($row['Year']);
    }    

    closeID($con);

    return($mooringPath); //returns array full MooringID => location code
}

function get_MooringBasicTable(){

    $con = dbConnection();
    
    $query = "SELECT * FROM MooringSite_Basic ";
    $result = $con->query($query) or die($con->error.__LINE__);
    




    //Get headers from database column names
    $row = $result->fetch_array(MYSQLI_ASSOC);
    foreach ($row as $columnName => $columnData) {
        echo "|$columnName";
    }
    echo "|   ".PHP_EOL;
    foreach ($row as $columnName => $columnData) {
        echo "|-----";
    }
    echo "|   ".PHP_EOL;

    // get all data
    mysqli_data_seek($result,0);
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        foreach ($row as $columnName => $columnData) {
            echo "|$columnData";
    }
    echo "|   ".PHP_EOL;
    }

    closeID($con);


}
?>