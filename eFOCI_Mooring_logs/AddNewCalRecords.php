<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 
Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>Add New Calibration Records</title>
</head>

<!-- php includes -->
<?php

include('php_routines/mooring_php_routines.php');



//AddNewRecords
/* Databases are opened and closed each entry: this is redundant but in preparation of 
    conversion of routines into functions */

//Get values from post variable
foreach($_POST as $name => $value) {
    if ( $name == 'db_id') { $db_id = htmlspecialchars($value); }
    else { $data4db[$name] = '"'.$value.'"'; }
    if ( empty($value) ) {$data4db[$name]="NULL"; }
}
 


//Connect to DB
$con = dbConnection('../db_configs/db_config_inst.php');

$insert = sprintf(
    'INSERT INTO %s (`%s`) VALUES (%s)',
    $db_id,
    implode('`,`',array_keys($data4db)),
    implode(',',array_values($data4db))
);


$result = $con->query($insert) or die($con->error.__LINE__);

echo $insert.'<br><br>';
echo "Calibration Insert Success!!! <br>";
closeID($con);

?>

<a href="calibration_select.php">Insert another Record</a>

<br> or <br>

<a href="index.php">Main Records</a>

</body>
</html>