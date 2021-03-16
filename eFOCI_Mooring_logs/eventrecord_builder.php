<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Event Record Text Builder</title>
<!-- Bootstrap theme -->
<link rel="stylesheet" type="text/css" id="node_modules/bootstrap.css" href="../bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />

</head>

<body>

<!-- local php includes
================================================== -->
<?php 
include('../ecofoci_images/header.php'); 
include('php_routines/mooring_php_routines.php');

include('php_routines/nav_header.php');
?>

<!-- Bootstrap - Static navbar
================================================== -->
<div class="container">


<!-- Static navbar -->
<?php build_navbar("Calibrations") ?>

<!-- End Navigation
================================================== -->



<div class="col-md-12 center-block" style="padding:20px;">


<h3>Select the Instrument you wish to build a record for</h3>  
<p>If the instrument you are looking for is not here, either contact Shaun.Bell (at) noaa.gov to put it in the database 
or find a similar instrument to follow the pattern making sure to change appropriate fields.  Innactive gear is not available in
the dropdown list below</p> 

<?php event_input_select($isactive='GOOD') ?>

<br><br>


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