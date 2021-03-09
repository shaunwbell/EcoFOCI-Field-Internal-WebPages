<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Drifter Landing Page</title>
<!-- Bootstrap theme -->
<link rel="stylesheet" type="text/css" id="bootstrap.css" href="../bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />

<!-- when using the dataTables javascript plugin, jquery and dataTables must be at top of page -->
<!-- dataTables seems to only work well with a single table on a page-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../scripts/jquery_1.11.0/jquery.min.js"></script>
</head>

<body>

<?php include('../ecofoci_images/header.php'); 
include('php_routines/drifter_php_routines.php');
include('php_routines/nav_header.php');

?>

<!-- Bootstrap - Static navbar
================================================== -->
<div class="container">


<!-- Static navbar -->
<?php build_navbar("Drifter Quicklooks") ?>

<!-- End Navigation
================================================== -->

<div class="col-md-12 center-block" style="padding:20px;">

<h4>Choose a year below: (will display all drifters that stopped reporting during that year)</h4>

<div class="table-responsive" ><table id="" class="table ">
<thead>
<tr>
  <th><h2>Quicklooks<h2></th>
  <th><h2>Gallery<h2></th>
</tr>
</thead>
<tbody>
<tr><th>

<?php 
foreach (range(2019, 2018, -1) as $year) {
    echo "<h3><a href ='DrifterQuicklooks_erddap.php?DrifterYear=".$year."'>".$year." ERDDAP</a></h3>";
}
?>
<?php 
foreach (range(2019, 1986, -1) as $year) {
    echo "<h3><a href ='DrifterQuicklooks.php?DrifterYear=".$year."'>".$year."</a></h3>";
}
?>

</th><th>
<?php 
foreach (range(2019, 2014, -1) as $year) {
    echo "<h3><a href ='DrifterGallery.php?DrifterYear=".$year."'>".$year."</a></h3>";
}

foreach (range(2013, 1986, -1) as $year) {
    echo "<h3><a href ='DrifterGalleryHistoric.php?DrifterYear=".$year."'>".$year."</a></h3>";
}
?>

</th></tr>
</tbody>
</table>
</div>
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