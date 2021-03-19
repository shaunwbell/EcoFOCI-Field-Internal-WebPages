<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>McKeever@pavlof IceProfiler Database</title>
<link rel="stylesheet" type="text/css" id="node_modules/bootstrap.css" href="../node_modules/bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />

</head>

<body>

<?php include('../ecofoci_images/header.php'); 
include('php_routines/iceprofiler_php_reports.php');
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

<h2>Ice Profiler Status Page:</h2>

<p>Use the tabs above to view individual instruments or to add new information or 
check out the <a href="readme.md">README</a> for details.</p>   


<h3 style="padding-left:25px;">Calibration Report</h3>
<?php cal_report(); ?>

<h3 style="padding-left:25px;">Location Report</h3>
<?php location_report(); ?>


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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../scripts/jquery.backstretch.js"></script>
<script>
    $.backstretch(["../ecofoci_images/backgrounds/peggy_buoy.jpg"]);
</script>

</body>
</html>
