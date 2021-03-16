<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mooring Instrument Deployment Timelines</title>
<link rel="stylesheet" type="text/css" id="bootstrap.css" href="../bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
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
<?php build_navbar("Status") ?>

<!-- End Navigation
================================================== -->



<div class="col-md-12 center-block" style="padding:20px;">

<h3>Mooring Instrument Timelines Page:</h3>

<p>Choose the appropriate instrument suite below to see a timeline of instrument activity</p>

<h4> Seabird Instruments (CTD)</h4>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#AAA" data-toggle="tab">Temperature (SBE-3)</a></li>
    <li><a href="#AAB" data-toggle="tab">Conductivity (SBE-4)</a></li>
    <li><a href="#AAC" data-toggle="tab">DO (SBE-43)</a></li>
    <li><a href="#AAD" data-toggle="tab">CTD (911 / 9p11)</a></li>
  </ul>
  <div class="tabbable">
    <div class="tab-content">
      <div class="tab-pane active" id="AAA">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_sbe3swimlane_active.html">Active SBE3 (temp)</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_sbe3swimlane.html">All SBE3 (temp)</a></li>
        </p>
      </div>
      <div class="tab-pane" id="AAB">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_sbe4swimlane_active.html">Active SBE4 (cond)</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_sbe4swimlane.html">All SBE4 (cond)</a></li>
        </p>
      </div>
      <div class="tab-pane" id="AAC">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_sbe43swimlane_active.html">Active SBE43</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_sbe43swimlane.html">All SBE43</a></li>
        </p>
      </div>
      <div class="tab-pane" id="AAD">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_sbe9swimlane_active.html">Active SBE9 (CTD)</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_sbe9swimlane.html">All SBE9 (CTD)</a></li>
        </p>
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
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_sbe37swimlane_active.html">Active SBE37 (Microcats)</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_sbe37swimlane.html">All SBE37 (Microcats)</a></li>
        </p>
      </div>
      <div class="tab-pane" id="AB">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_sbe16swimlane_active.html">Active SBE16 (SeaCats)</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_sbe16swimlane.html">All SBE16 (SeaCats)</a></li>
        </p>
      </div>
      <div class="tab-pane" id="AC">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_sbe49swimlane_active.html">Active SBE49</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_sbe49swimlane.html">All SBE49</a></li>
        </p>
      </div>
      <div class="tab-pane" id="AD">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_sbe39swimlane_active.html">Active SBE39</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_sbe39swimlane.html">All SBE39</a></li>
        </p>
      </div>
      <div class="tab-pane" id="AE">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_sbe56swimlane_active.html">Active SBE56</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_sbe56swimlane.html">All SBE56</a></li>
        </p>
      </div>
      <div class="tab-pane" id="AF">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_sbe26swimlane_active.html">Active SBE26</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_sbe26swimlane.html">All SBE26</a></li>
        </p>
      </div>
    </div>
  </div> <!-- /tabbable -->
  
  
<h4> Mooring Instruments </h4>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#BA" data-toggle="tab">Micro Temperature Recorders (MTR)</a></li>
    <li><a href="#BB" data-toggle="tab">PhotoSynth Activ. Rad. (PAR)</a></li>
    <li><a href="#BC" data-toggle="tab">Nitrates</a></li>
    <li><a href="#BD" data-toggle="tab">Flourometers</a></li>
  </ul>
  <div class="tabbable">
    <div class="tab-content">
      <div class="tab-pane active" id="BA">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_mtrswimlane_active.html">Active MTRs</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_mtrswimlane.html">All MTRs</a></li>
        </p>
      </div>
      <div class="tab-pane" id="BB">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_parswimlane_active.html">Active PARs</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_parswimlane.html">All PARs</a></li>
        </p>
      </div>
      <div class="tab-pane" id="BC">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_nitratesswimlane_active.html">Active Nitrates</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_nitratesswimlane.html">All Nitrates</a></li>
        </p>
      </div>
      <div class="tab-pane" id="BD">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_wetstarfluorswimlane_active.html">Active WetSTARs</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_wetstarfluorswimlane.html">All WetSTARs</a></li>
        </p>
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_ecofluorswimlane_active.html">Active EcoFluorometers</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_ecofluorswimlane.html">All EcoFluorometers</a></li>
        </p>
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
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_eppleyswimlane_active.html">Active Eppley Pyranometers</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_eppleyswimlane.html">All Eppley Pyranometers</a></li>
        </p>
      </div>
      <div class="tab-pane" id="CB">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_spn1swimlane_active.html">Active SPN1</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_spn1swimlane.html">All SPN1</a></li>
        </p>
      </div>
      <div class="tab-pane" id="CC">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_wxsensorsswimlane_active.html">Active Wx Sensors</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_wxsensorsswimlane.html">All Wx Sensors</a></li>
        </p>
      </div>
      <div class="tab-pane" id="CD">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_windsensorsswimlane_active.html">Active Wind Sensors</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_windsensorsswimlane.html">All Wind Sensors</a></li>
        </p>      
        </div>
    </div>
  </div> <!-- /tabbable -->
  
<h4> Other Instruments </h4>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#DA" data-toggle="tab">ADCP</a></li>
    <li><a href="#DB" data-toggle="tab">Ice Profilers</a></li>
    <li><a href="#DC" data-toggle="tab">Current meters</a></li>
  </ul>
  <div class="tabbable">
    <div class="tab-content">
      <div class="tab-pane active" id="DA">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_adcpswimlane_active.html">Active ADCP</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_adcpswimlane.html">All ADCP</a></li>
        </p>      </div>
      <div class="tab-pane" id="DB">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_iceprofswimlane_active.html">Active IPS-5 Iceprofilers</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_iceprofswimlane.html">All IPS-5 Iceprofilers</a></li>
        </p>      </div>
      <div class="tab-pane" id="DC">
        <p>
           <li><a href="../Instrument_timeseries_charts/inst_rcmswimlane_active.html">Active RCM 7/9/11's</a></li>
           <li><a href="../Instrument_timeseries_charts/inst_rcmswimlane.html">All RCM 7/9/11's</a></li>
        </p>      
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
<script src="../bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../scripts/jquery.backstretch.js"></script>
<script>
    $.backstretch(["../ecofoci_images/backgrounds/peggy_buoy.jpg"]);
</script>

</body>
</html>