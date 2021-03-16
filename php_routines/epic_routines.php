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

// generate table all vessels affiliated with EcoFOCI 
function epic_key_view() {

    $con = dbConnection('../db_configs/db_config_meta.php');

    //Get MooringID
    $query = "SELECT * FROM epic_keys ORDER BY `EPIC_KEY_Number`";

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