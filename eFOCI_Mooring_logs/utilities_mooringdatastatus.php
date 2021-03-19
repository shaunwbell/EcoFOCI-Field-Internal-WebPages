<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mooring: Data Processing Status</title>
<!-- Bootstrap theme -->
<link rel="stylesheet" type="text/css" id="bootstrap.css" href="../node_modules/bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
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


<!-- Bootstrap - Static navbar
================================================== -->
<div class="container">


<!-- Static navbar -->
<?php build_navbar("Utilities") ?>

<!-- End Navigation
================================================== -->



<div class="col-md-12 center-block" style="padding:20px;">


<?php instrument_datastatus() ?>

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
<script src="../scripts/jquery.backstretch.js"></script>
<script type="text/javascript" src="../scripts/DataTables-1.10.12/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../scripts/bootstrap_datatables/dataTables.bootstrap.js"></script>
<script>
    $(document).ready(function() {
        $('table.table').dataTable( {
        "iDisplayLength": 50,
        "order": [[ 0, "desc" ]]
        } );
    } );
</script>
<script>
    $.backstretch(["../ecofoci_images/backgrounds/peggy_buoy.jpg"]);
</script>

</body>
</html>