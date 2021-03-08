<?php 

include('php_routines/cruise_php_routines.php');

$CruiseID = htmlspecialchars($_GET['CruiseID']);

cruiselogs_table_cruise_btl_oxygen("cruisecastlogs",$CruiseID)

?>