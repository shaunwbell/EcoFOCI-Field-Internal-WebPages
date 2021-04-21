<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Instrument Inventory and Status (All)</title>
<!-- Bootstrap theme -->
<link rel="stylesheet" type="text/css" id="bootstrap.css" href="../node_modules/bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />

</head>

<body>

<!-- local php includes
================================================== -->
<?php 
include('../ecofoci_images/header.php'); 
include('php_routines/mooring_php_reports.php');
include('php_routines/nav_header.php');
?>

<!-- Bootstrap - Static navbar
================================================== -->
<div class="container">


<!-- Static navbar -->
<?php build_navbar("InstrumentStatus") ?>

<!-- End Navigation
================================================== -->


<div class="col-md-12 center-block" style="padding:20px;">

<h4>Legend</h4>
<p> <em style="color: grey;">Grey</em> values have no cal history in the database (or have mismatching serial no) </p>
<p> <em style="color: red;">Red</em> values are not active equipment (lost/destroyed/not recovered/etc). </p>
<p> <em style="color: blue;">Blue</em> values have calibrations that are 3 years old or older from today </p>
<p> <em style="color: yellow;">Yellow</em> values are currently deployed instruments based on the deployment log sheets </p>

<p>To view all <a href="lastknownoperations.php">all EcoFOCI</a> instruments</p>



<h4> Seabird Instruments (CTD)</h4>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#AAA" data-toggle="tab">Temperature (SBE-3)</a></li>
    <li><a href="#AAB" data-toggle="tab">Conductivity (SBE-4)</a></li>
    <li><a href="#AAC" data-toggle="tab">DO (SBE-43)</a></li>
    <li><a href="#AAD" data-toggle="tab">CTD (911 / 9p11)</a></li>
    <li><a href="#AAE" data-toggle="tab">CTD (Prawler)</a></li>
    <li><a href="#AAF" data-toggle="tab">Seacat Profiler (SBE-19)</a></li>
    <li><a href="#AAG" data-toggle="tab">Pumps</a></li>
    <li><a href="#AAH" data-toggle="tab">Transmissometers</a></li>
  </ul>
  <div class="tabbable">
    <div class="tab-content">
      <div class="tab-pane active" id="AAA">
        <p><?php last_operations_report('inst_sbe3','cal_sbe3','False'); ?></p>
      </div>
      <div class="tab-pane" id="AAB">
        <p><?php last_operations_report('inst_sbe4','cal_sbe4','False'); ?></p>
      </div>
      <div class="tab-pane" id="AAC">
        <p><?php last_operations_report('inst_sbe43','cal_sbe43','False'); ?></p>
      </div>
      <div class="tab-pane" id="AAD">
        <p><?php last_operations_report('inst_sbe9','cal_sbe9','False'); ?></p>        
      </div>
      <div class="tab-pane" id="AAE">
        <p><?php last_operations_report('inst_sbeprawler','cal_sbeprawler','False'); ?></p>        
      </div>      
      <div class="tab-pane" id="AAF">
        <p><?php last_operations_report('inst_sbe19','cal_sbe19','False'); ?></p>        
      </div>
      <div class="tab-pane" id="AAG">
        <p><?php last_operations_report('inst_sbe5','cal_sbe5','False'); ?></p>        
      </div>
      <div class="tab-pane" id="AAH">
        <p><?php last_operations_report('inst_trans','cal_trans','False'); ?></p>        
      </div>
    </div>
  </div> <!-- /tabbable -->

<h4> Seabird Instruments </h4>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#AA" data-toggle="tab">MicroCATSs (SBE-37)</a></li>
    <li><a href="#AB" data-toggle="tab">SeaCATs (SBE-16)</a></li>
    <li><a href="#AC" data-toggle="tab">FastCATs (SBE-49)</a></li>
    <li><a href="#AD" data-toggle="tab">Temperature (SBE-39)</a></li>
    <li><a href="#AE" data-toggle="tab">Temperature (SBE-56)</a></li>
    <li><a href="#AF" data-toggle="tab">Wave/Tide (SBE-26)</a></li>
  </ul>
  <div class="tabbable">
    <div class="tab-content">
      <div class="tab-pane active" id="AA">
        <p><?php last_operations_report_wpressure('inst_sbe37','cal_sbe37','False'); ?></p>
      </div>
      <div class="tab-pane" id="AB">
        <p><?php last_operations_report_wpressure('inst_sbe16','cal_sbe16','False'); ?></p>
      </div>
      <div class="tab-pane" id="AC">
        <p><?php last_operations_report('inst_sbe49','cal_sbe49','False'); ?></p>
      </div>
      <div class="tab-pane" id="AD">
        <p><?php last_operations_report_wpressure('inst_sbe39','cal_sbe39','False'); ?></p>
      </div>
      <div class="tab-pane" id="AE">
        <p><?php last_operations_report('inst_sbe56','cal_sbe56','False'); ?></p>
      </div>
      <div class="tab-pane" id="AF">
        <p><?php last_operations_report('inst_sbe26','cal_sbe26','False'); ?></p>
      </div>
    </div>
  </div> <!-- /tabbable -->
  

<h4> Mooring Instruments </h4>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#BA" data-toggle="tab">Micro Temperature Recorders (MTR)</a></li>
    <li><a href="#BB" data-toggle="tab">PhotoSynth Activ. Rad. (PAR)</a></li>
    <li><a href="#BC" data-toggle="tab">Nitrates</a></li>
    <li><a href="#BD" data-toggle="tab">Flourometers</a></li>
    <li><a href="#BE" data-toggle="tab">Gas Tension</a></li>
  </ul>
  <div class="tabbable">
    <div class="tab-content">
      <div class="tab-pane active" id="BA">
        <p><?php last_operations_report('inst_mtr','cal_mtr','False'); ?></p>
      </div>
      <div class="tab-pane" id="BB">
        <p><?php last_operations_report('inst_par','cal_par','False'); ?></p>
      </div>
      <div class="tab-pane" id="BC">
        <p><?php last_operations_report('inst_nitrates','cal_nitrates','False'); ?></p>
      </div>
      <div class="tab-pane" id="BD">
        <p><?php last_operations_report('inst_wetstarfluor','cal_wetstarfluor','False'); ?></p>
        <p><?php last_operations_report('inst_ecofluor','cal_ecofluor','False'); ?></p>
      </div>    
      <div class="tab-pane" id="BE">
        <p><?php last_operations_report('inst_gastension','cal_gastension','False'); ?></p>
      </div>
      </div>
  </div> <!-- /tabbable -->
  
<h4> Surface Moorings </h4>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#CA" data-toggle="tab">Eppley</a></li>
    <li><a href="#CB" data-toggle="tab">Deltek SPN1</a></li>
    <li><a href="#CC" data-toggle="tab">Weather Sensors</a></li>
    <li><a href="#CD" data-toggle="tab">Wind Sensors</a></li>
  </ul>
  <div class="tabbable">
    <div class="tab-content">
      <div class="tab-pane active" id="CA">
        <p><?php last_operations_report('inst_eppley','cal_eppley','False'); ?></p>
      </div>
      <div class="tab-pane" id="CB">
        <p><?php last_operations_report('inst_spn1','cal_spn1','False'); ?></p>
      </div>
      <div class="tab-pane" id="CC">
        <p><?php last_operations_report('inst_wxsensors','cal_wxsensors','False'); ?></p>
      </div>
      <div class="tab-pane" id="CD">
        <p><?php last_operations_report('inst_windsensors','cal_windsensors','False'); ?></p>
      </div>
    </div>
  </div> <!-- /tabbable -->
  
<h4> Other Instruments </h4>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#DA" data-toggle="tab">ADCP</a></li>
    <li><a href="#DB" data-toggle="tab">Ice Profilers</a></li>
    <li><a href="#DC" data-toggle="tab">Current meters</a></li>
    <li><a href="#DD" data-toggle="tab">Current Meter Accessories (Oxy, Turb, Cond)</a></li>
  </ul>
  <div class="tabbable">
    <div class="tab-content">
      <div class="tab-pane active" id="DA">
        <p><?php last_operations_report('inst_adcp','cal_adcp','False'); ?></p>
      </div>
      <div class="tab-pane" id="DB">
        <p><?php last_operations_report('inst_iceprof','cal_iceprof','False'); ?></p>
      </div>
      <div class="tab-pane" id="DC">
        <p><?php last_operations_report('inst_rcm','cal_rcm','False'); ?></p>
      </div>
      <div class="tab-pane" id="DD">
        <p><?php last_operations_report('inst_rcm_ancillary','cal_rcm_ancillary','False'); ?></p>
      </div>      
    </div>
  </div> <!-- /tabbable -->
  

<!-- end content
================================================== -->


    <p class="text-muted"><?php include('../ecofoci_images/footer.php'); ?></p>
</div>

<!-- end footer
================================================== -->

</div>

<noscript><div >This Website requires your browser to be JavaScript enabled.</div></noscript>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../scripts/jquery_1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- sortable data tables -->
<script src="../node_modules/datatables/examples/resources/bootstrap/3/dataTables.bootstrap.js"></script>
<!-- jQuery backstretch for background responsive photos -->
<script src="../scripts/jquery.backstretch.js"></script>
<script>
    $.backstretch(["../ecofoci_images/backgrounds/peggy_buoy.jpg"]);
</script>

</body>
</html>