<?php
//eFOCIdbtools.php

function dbConnection(){
    include('../db_configs/db_config.php');
    $con = new mysqli($host,$user,$password, $db);

    if (mysqli_connect_errno()) {
        echo "Database connection failed ";
        exit();
    } 
    return $con;
    }
    
function passID(){
    $con = dbConnection();
    
    $query = "SELECT * FROM MooringDeploymentLogs ORDER BY `MooringID` DESC";
    $MooringID = $con->query($query) or die($con->error.__LINE__);
    
    return array ($MooringID, $con);
    }

    
function passIDcruise(){
    $con = dbConnection();

    $query = "SELECT DISTINCT CruiseID FROM CruiseCastLogs ORDER BY `CruiseID` DESC";
    $CruiseID = $con->query($query) or die($con->error.__LINE__);
    
    return array ($CruiseID, $con);
    }

function getIDinstr(){

    $con = dbConnection();

    $query = "SHOW TABLES";
    $result = $con->query($query) or die($con->error.__LINE__);

    $InstrID = array();

    while ( $row = $result->fetch_row() ){
        $table = $row[0];
        if (strpos($table,'inst_') !== false) {
            $tquery = "SELECT DISTINCT InstType FROM $table ORDER BY `InstType` DESC";
            $tresult = $con->query($tquery) or die($con->error.__LINE__);
            while($trow = $tresult->fetch_array(MYSQLI_BOTH)) {
                $InstrID[] = $trow;
                }
            }
    }
    return array ($InstrID, $con);
    }

function getcal2instmap($InstType){

    $con = dbConnection();

    $query = "SELECT * FROM `inst2calmap` WHERE `InstType` = '".$InstType."'";
    $result = $con->query($query) or die($con->error.__LINE__);

   
    while ( $row = $result->fetch_array(MYSQLI_BOTH) ) {
         $db_id = $row['cal_table_name'];;
    }
    return array ($db_id, $con);
    }

function cal_IDinstr(){

    $con = dbConnection();

    $query = "SELECT `InstType` FROM `inst2calmap` ORDER BY `InstType` ASC";
    $result = $con->query($query) or die($con->error.__LINE__);

    return array ($result, $con);
    }

function log_IDinstr(){

    $con = dbConnection();

    $query = "SELECT DISTINCT `Instrument` FROM `MooringDeployedInstruments` ORDER BY `Instrument` ASC";
    $result = $con->query($query) or die($con->error.__LINE__);

    return array ($result, $con);
    }    

function closeID($con){
    mysqli_close($con);
    }

?>