<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Find Nearest CTD Cast Results</title>
<!-- Bootstrap theme -->
<link rel="stylesheet" type="text/css" id="bootstrap.css" href="../bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
</head>

<body>


<!-- local php includes
================================================== -->
<?php 
include('../ecofoci_images/header.php'); 

include('php_routines/nav_header.php');
include('php_routines/mooring_ctd_routines.php');
include('php_routines/haversine.php');
?>

<!-- local php form entries
================================================== -->
<?php
$mooringid = htmlspecialchars($_GET['mooringid']);
$StartYear = htmlspecialchars($_GET['StartYear']);
$EndYear = htmlspecialchars($_GET['EndYear']);
$distance = htmlspecialchars($_GET['distance']);
?>

<!-- Bootstrap - Static navbar
================================================== -->
<div class="container">


<!-- Static navbar -->
<?php build_navbar("Utilities") ?>

<!-- End Navigation
================================================== -->



<div class="col-md-12 center-block" style="padding:20px;">

<div class="jumbotron" data-toggle="collapse" data-target="#ctdcasts">Click to see comprehensive station list, and click again to collapse.

<div id="ctdcasts" class="collapse">
<?php list ($lat_m,$lon_m) = mooring_location($mooringid); ?>
<?php $ctd_reports = ctd_location($StartYear,$EndYear); ?>
<?php 
foreach ($ctd_reports as &$cast) {
    $distance_away = sphered($lat_m,$lon_m,$cast['LatitudeDeg']+$cast['LatitudeMin'] /60,$cast['LongitudeDeg']+$cast['LongitudeMin'] /60,'K'); 
    if ($distance_away <= $distance) {
        echo 'CTD: '.$cast['UniqueCruiseID'].' '.$cast['ConsecutiveCastNo'].' is '.$distance_away.' km away <br>';
    }
}
?>
</div>
</div>
<br>


<!-- leaflet Maps
================================================== -->
<!-- Leaflet map -->



<script type="text/javascript" src="../scripts/leaflet/leaflet.js"></script>
<script type="text/javascript" src="../scripts/leaflet/leaflet.ajax.min.js"></script>
<script type="text/javascript" src="http://maps.stamen.com/js/tile.stamen.js?v1.3.0"></script>
<div id="leaflet_map" style="width: 100%; height: 600px"></div>
<script>

    var Esri_OceanBasemap = new L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/Ocean_Basemap/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Sources: GEBCO, NOAA, CHS, OSU, UNH, CSUMB, National Geographic, DeLorme, NAVTEQ, and Esri',
        maxZoom: 13
    });
    //http://maps.ngdc.noaa.gov/arcgis/rest/services/web_mercator/gebco08_contours/MapServer/tile/{z}/{y}/{x}
    // replace "toner" here with "terrain" or "watercolor"
    //var layer = new L.StamenTileLayer("toner");
    var mymap = new L.Map("leaflet_map", {
        center: new L.LatLng(56.8,-164), 
        zoom: 4
    });
    mymap.addLayer(Esri_OceanBasemap);    
    <?php 
    echo "var circle = L.circle([".$lat_m.",".(-1*$lon_m)."], ".($distance*1000).", {color: 'black', fillColor: '#00ffcc', fillOpacity: 0.25}).addTo(mymap);".PHP_EOL;
    foreach ($ctd_reports as &$cast) {
        $distance_away = sphered($lat_m,$lon_m,$cast['LatitudeDeg']+$cast['LatitudeMin'] /60,$cast['LongitudeDeg']+$cast['LongitudeMin'] /60,'K'); 
        if ($distance_away <= $distance) {
            echo "var circle = L.circle([".($cast['LatitudeDeg']+$cast['LatitudeMin'] /60).",".(($cast['LongitudeDeg']+$cast['LongitudeMin'] / 60)*-1)."], 1000, {color: 'black', fillColor: '#f03', fillOpacity: 0.5}).addTo(mymap);  circle.bindPopup('".$cast['UniqueCruiseID']." ".$cast['ConsecutiveCastNo']."');".PHP_EOL;
        }
    }
    ?>
    

</script>




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