<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Instrument Summary Results</title>
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
        "iDisplayLength": 50,
        "order": [[ 1, "desc" ]]
        } );
    } );
</script>
</head>
<body>


<!-- local php includes
================================================== -->
<?php 
include('../ecofoci_images/header.php'); 

include('php_routines/nav_header.php');
include('php_routines/mooring_dep_summary_routines.php');
include('php_routines/haversine.php');
?>

<!-- local php form entries
================================================== -->
<?php
$StartYear = htmlspecialchars($_GET['StartYear']);
$EndYear = htmlspecialchars($_GET['EndYear']);
?>

<!-- Bootstrap - Static navbar
================================================== -->
<div class="container">


<!-- Static navbar -->
<?php build_navbar("Utilities") ?>

<!-- End Navigation
================================================== -->



<div class="col-md-12 center-block" style="padding:20px;">

<ul class="nav nav-tabs">
  <li class="active"><a href="#A_A" data-toggle="tab">Currently Out (regardless of year)</a></li>
  <li><a href="#AA" data-toggle="tab">Deployed</a></li>
  <li><a href="#AB" data-toggle="tab">Recovered</a></li>
  <li><a href="#AC" data-toggle="tab">Lost</a></li>
</ul>
<div class="tabbable">
  <div class="tab-content">
    <div class="tab-pane active" id="A_A">
      <p><?php instrument_operations_summary($StartYear,$EndYear,'current','n'); ?></p>
      <p><?php instrument_operations_summary($StartYear,$EndYear,'current','y'); ?></p>
    </div>
    <div class="tab-pane" id="AA">
      <p><?php instrument_operations_summary($StartYear,$EndYear,'','n'); ?></p>
      <p><?php instrument_operations_summary($StartYear,$EndYear,'','y'); ?></p>
    </div>
    <div class="tab-pane" id="AB">
      <p><?php instrument_operations_summary($StartYear,$EndYear,'y','n'); ?></p>
      <p><?php instrument_operations_summary($StartYear,$EndYear,'y','y'); ?></p>
    </div>
    <div class="tab-pane" id="AC">
      <p><?php instrument_operations_summary($StartYear,$EndYear,'n','n'); ?></p>
      <p><?php instrument_operations_summary($StartYear,$EndYear,'n','y'); ?></p>
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