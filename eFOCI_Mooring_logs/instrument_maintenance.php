<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Instrument Maintenance Status</title>
<!-- Bootstrap theme -->
<link rel="stylesheet" type="text/css" id="node_modules/bootstrap.css" href="../bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/bootstrap_datatables/bootstrap_datatables.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />

<!-- when using the dataTables javascript plugin, jquery and dataTables must be at top of page -->
<!-- dataTables seems to only work well with a single table on a page-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../scripts/jquery_1.11.0/jquery.min.js"></script>
<!-- DataTables -->
<script type="text/javascript" src="../node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../scripts/bootstrap_datatables/dataTables.bootstrap.js"></script>
<script>
    $(document).ready(function() {
        $('table.table').dataTable( {
        "iDisplayLength": 20
        } );
    } );
</script>
</head>

<body>

<!-- local php includes
================================================== -->
<?php 
include('../ecofoci_images/header.php'); 
include('php_routines/instrument_php_routines.php');
include('php_routines/nav_header.php');
?>

<!-- Bootstrap - Static navbar
================================================== -->
<div class="container">


<!-- Static navbar -->
<?php build_navbar("InstrumentStatus") ?>

<!-- End Navigation
================================================== -->

<!-- Start Content 
================================================== -->

<div class="col-md-12 center-block" style="padding:20px;">


<h3>Description:</h3>
<p>Instruments are given various status levels in the database records, here you can sort on a status and get a list of instruments with that level.
At the moment, this information is centralized with S.Bell.  Please send him information for Serial's and Status to be included on this form.<p>

<h4> Listed by Status </h4>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#AA" data-toggle="tab">Repair</a></li>
    <li><a href="#AB" data-toggle="tab">Unknown</a></li>
    <li><a href="#AC" data-toggle="tab">Retired</a></li>
    <li><a href="#AD" data-toggle="tab">Calibrate</a></li>
    <li><a href="#AE" data-toggle="tab">Other</a></li>
    <li><a href="#AF" data-toggle="tab">Good</a></li>
  </ul>
  <div class="tabbable">
    <div class="tab-content">
      <div class="tab-pane active" id="AA">
        <p><?php view_instrument_servicestatus('REPAIR'); ?></p>
      </div>
      <div class="tab-pane" id="AB">
        <p><?php view_instrument_servicestatus('UNKNOWN'); ?></p>
      </div>
      <div class="tab-pane" id="AC">
        <p><?php view_instrument_servicestatus('RETIRED'); ?></p>
      </div>
      <div class="tab-pane" id="AD">
        <p><?php view_instrument_servicestatus('CALIBRATE'); ?></p>
      </div>
      <div class="tab-pane" id="AE">
        <p><?php view_instrument_servicestatus('OTHER'); ?></p>
      </div>
      <div class="tab-pane" id="AF">
        <p><?php view_instrument_servicestatus('GOOD'); ?></p>
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
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../scripts/jquery.backstretch.js"></script>
<script>
    $.backstretch(["../ecofoci_images/backgrounds/peggy_buoy.jpg"]);
</script>

</body>
</html>