<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mooring Deployment Forms</title>
<!-- Bootstrap theme -->
<link rel="stylesheet" type="text/css" id="bootstrap.css" href="../bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />

</head>

<body>

<?php 
include('../ecofoci_images/header.php'); 
include('php_routines/mooring_php_routines.php');
include('php_routines/nav_header.php');
?>

<!-- Bootstrap - Static navbar
================================================== -->
<div class="container">


<!-- Static navbar -->
<?php build_navbar("Mooring Record Logs") ?>

<!-- End Navigation
================================================== -->

<div class="col-md-12 center-block" style="padding:20px;">

    <h3> Mooring Sites After 2000</h3>
    <?php 
    $max_year = date("y") + 1; 
    view_record_select($max_year,01); ?>

    <h3> Mooring Sites Prior to 2000</h3>
    <?php 
    $max_year = date("y") + 1; 
    view_record_select(00, 00); ?>

    <div style="text-align: center"><img src="../ecofoci_images/Dyson_Strausz.jpg" alt="Dyson" class="rounded mx-auto d-block" class="img-fluid" width = 90%></div>

    <br><br>


    <?php update_record_select(); ?>

    <fieldset>
    <legend>Create Mooring Record</legend>   

    <p><a href="mooring_record_create.html">Create a new mooring record</a></p>
    </fieldset>

    <p class="text-muted"><?php include('../ecofoci_images/footer.php'); ?></p>
<!-- end footer
================================================== -->
</div><!--/.center-block -->


</div><!--/.container -->

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