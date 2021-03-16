<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Find Nearest CTD Cast</title>
<!-- Bootstrap theme -->
<link rel="stylesheet" type="text/css" id="node_modules/bootstrap.css" href="../bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />

</head>

<body>

<!-- local php includes
================================================== -->
<?php 
include('../ecofoci_images/header.php'); 

include('php_routines/nav_header.php');
include('php_routines/mooring_ctd_routines.php');
?>

<!-- Bootstrap - Static navbar
================================================== -->
<div class="container">


<!-- Static navbar -->
<?php build_navbar("Utilities") ?>

<!-- End Navigation
================================================== -->



<div class="col-md-12 center-block" style="padding:20px;">


<?php findnearestctd_select() ?>

<p><strong>Note:</strong> This routine works by filtering all known casts within the specified distance away
from a designated mooring site during a specified period.  The returned results may be outside 
the range of the measurement period of the mooring.  Additionally, these close proximity casts should, but
may not always coincide with the actual calibration casts (where extra water samples would have been taken)  </p>

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