<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ice Profiler Operations Records</title>
<link rel="stylesheet" type="text/css" id="node_modules/bootstrap.css" href="../node_modules/bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />

</head>

<body>

<?php include('../ecofoci_images/header.php'); 
include('php_routines/iceprofiler_php_routines.php');
include('php_routines/nav_header.php');
?>

<!-- Bootstrap - Static navbar
================================================== -->
<div class="container">


<!-- Static navbar -->
<?php build_navbar("Operations") ?>

<!-- End Navigation
================================================== -->


<div class="col-md-12 center-block" style="padding:20px;">


<h4> Iceprofilers </h4>
  <ul class="nav nav-tabs">
    <li class="active"><a href="#AA" data-toggle="tab">Profiler Deployment</a></li>
    <li><a href="#AB" data-toggle="tab">Profiler Recovery</a></li>
    <li><a href="#AC" data-toggle="tab">Profiler Data Notes</a></li>
  </ul>
  <div class="tabbable">
    <div class="tab-content">
      <div class="tab-pane active" id="AA">
        <p><?php get_operation_records_deployed(); ?></p>
      </div>
      <div class="tab-pane" id="AB">
        <p><?php get_operation_records_recovered(); ?></p>
      </div>
      <div class="tab-pane" id="AC">
        <p><?php get_operation_records_data(); ?></p>
      </div>
    </div>
  </div> <!-- /tabbable -->


<!--all records as markdown table get_operation_records() -->


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