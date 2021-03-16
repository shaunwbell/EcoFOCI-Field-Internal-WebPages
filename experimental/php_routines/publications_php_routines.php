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

// generate table of publications
function view_publications() {

    $con = dbConnection('db_config_publications.php');

    //Get MooringID
    $query = "SELECT * FROM publications  ORDER BY `year` DESC";

    $result = $con->query($query) or die($con->error.__LINE__);
    
    echo '<div class="table-responsive" ><table id="" class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th>Year</th>
      <th>Author</th>
      <th>Title</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

        echo '<tr><td>'.$row['year'].'</td>
                  <td>'.$row['pri_author_lastname'].'</td>
                  <td>'.$row['title'].'</td></tr>'.PHP_EOL;
    }
    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con);
}

// generate publications as pannels with collapsable content
function view_publications_collapse() {

    $con = dbConnection('db_config_publications.php');

    //Get MooringID
    $query = "SELECT * FROM publications  ORDER BY `year` DESC";

    $result = $con->query($query) or die($con->error.__LINE__);
    
   
    echo '<div class="panel-group" id="accordion">'.PHP_EOL;

    $count=0;
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {

        echo '<div class="panel-group" id="accordion">
             <div class="panel panel-default" id="panel"'.$count.'>
             <div class="panel-heading">
             <h4 class="panel-title"><a data-toggle="collapse" data-target="#collapse'.$count.'" href="#collapse'.$count.'">'.$row['year'].', '.$row['pri_author_lastname'].'</a></h4>'.PHP_EOL;
        echo '<div id="collapse'.$count.'" class="panel-collapse collapse">
              <div class="panel-body">'.PHP_EOL;
        echo $row['year'].', '.$row['pri_author_lastname'].', '.$row['title'];
        echo '</div>
                        </div>
                    </div>
                </div>';
    $count+=1;
    }
    
    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con);
}

//populate and provide ability to instatiate new publication id
function publications_new() {

    echo '<form role="form" class="form-horizontal" role="form name="publications_input" action="AddNewPublications.php" method="get">
   
    <legend>Mooring Gear Entry</legend>   
    <fieldset>'.PHP_EOL;

   
    
    $con = dbConnection('db_config_publications.php');
    $query = "SHOW FULL COLUMNS FROM publications";
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        if ( $row['Field'] == 'id') { continue; }
        else {
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

//populate and provide ability to update publication id information
function publications_update() {

    echo '<form role="form" class="form-horizontal" role="form name="publications_update" action="UpdatePublications.php" method="get">
   
    <legend>Publications Update Existing Entry</legend>   
    <fieldset>'.PHP_EOL;

    $con = dbConnection('db_config_publications.php');
    $query = "SHOW FULL COLUMNS FROM publications";
    $result = $con->query($query) or die($con->error.__LINE__);

    //Get fieldnames and comments from database 
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        if ( $row['Field'] == 'id') { continue; }
        else {
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


?>