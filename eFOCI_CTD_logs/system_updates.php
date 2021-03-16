<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mooring Deployment Database</title>
<link rel="stylesheet" type="text/css" id="node_modules/bootstrap.css" href="../bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />

</head>

<body>


<!-- local php includes
================================================== -->
<?php 
include('../ecofoci_images/header.php'); 
include('php_routines/carousel.php');
include('php_routines/nav_header.php');
?>

<!-- Bootstrap - Static navbar
================================================== -->
<div class="container">


<!-- Static navbar -->
<?php build_navbar("News") ?>

<!-- End Navigation
================================================== -->

<div class="col-md-12 center-block" style="padding:20px;">


<h2> System news and updates<h2>

<h3> News </h3>

<p><strong>Updates and Notes: (Oct 13, 2014)</strong>CTD/Cruise operations have been separated from Mooring/Instrument operations</p>

<p><strong>Updates and Notes: (Aug 14, 2014)</strong> Markdown driven pages have been removed from the Mooring Site.</p>

<p><strong>Updates and Notes: (July 30, 2014)</strong> Instrument timelines are now available under the status dropdown menu.  They 
are orgainzed by instrument type and display a timeseries of instrument/mooring.</p>

<p><strong>Updates and Notes: (June 03, 2014)</strong> Cruises which are actively being processed by me (S. Bell) now have
dedicated pages with results.  Many will be CTD processing activities and can be found in the `CTD Cast Records`</p>

<p><strong>Updates and Notes: (April 23, 2014)</strong> Pure HTML/PHP/Jscript pages are using bootstrap 3 whereas
pages that utilize markdown <em>(either through a .md ending using strapdown or in the content such as this
page via markdown_site webdocs)</em> are using Bootstrap 2.  Until these packages are updated, there may
be slight differences in visual asthetics for different pages.  The easiest way to determin this is
Bootstrap 3 pages have an image of the *Peggy Buoy* in the background.</p>

<p><strong>Updates and Notes: (April 4, 2014)</strong> Migrating to cleaner look and feel (similar to Ice Profiler Database.
This should keep code cleaner... provide more options for status updates, and simplify routines.</p>

<p><strong>Updates and Notes: (Feb 25, 2014)</strong> Ability to add/modify calibration records, and pre/post
deployment records.  Slowly adding historic data to database.</p>

<p><strong>Updates and Notes: (Feb 24, 2014)</strong> Ability to view Instrument Logs if model and serial
number is known.</p>

<p><strong>Updates and Notes: (Feb 17, 2014)</strong> Currently in development status.  Database entries and values are
subject to modification/deletion/updates.</p>


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