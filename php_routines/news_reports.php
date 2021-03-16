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
    

function get_news($config) {
    $con = dbConnection($config);
    
    $query = "SELECT * from `News_Updates` ORDER BY `DateTime` DESC"; 
    
    $result = $con->query($query) or die($con->error.__LINE__);
    

    while($row = $result->fetch_array(MYSQLI_ASSOC)) { 
        echo "<p><strong>Updates and Notes: ".$row['DateTime']."</strong><br >";
        echo $row['Notes']."</p>";
    }
    
}


function get_news_bootstrap($config) {
    $con = dbConnection($config);
    
    $query = "SELECT * from `News_Updates` ORDER BY `DateTime` DESC"; 
    
    $result = $con->query($query) or die($con->error.__LINE__);
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) { 
        echo '<div class="col-sm-6">';
        echo "<p><strong>Updates and Notes: ".$row['DateTime']."</strong><br >";
        echo '</div>';
        echo '<div class="col-sm-6">';
        echo $row['Notes']."</p>";
        echo '</div>';
    }
    
}
?>