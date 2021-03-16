<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Deployed Mooring Location Summary</title>
<!-- Bootstrap theme -->
<link rel="stylesheet" type="text/css" id="node_modules/bootstrap.css" href="../bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/bootstrap_datatables/bootstrap_datatables.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />
<link rel="stylesheet" href="../node_modules/leaflet/dist/leaflet.css" />

</head>

<body>

<!-- local php includes
================================================== -->
<?php 
include('../ecofoci_images/header.php'); 
include('php_routines/mooring_php_reports.php');
include('php_routines/nav_header.php');
?>

<!-- Bootstrap - Static navbar
================================================== -->
<div class="container-fluid">


<!-- Static navbar -->
<?php build_navbar("Mooring Location Summary"); ?>

<!-- End Navigation
================================================== -->



<div class="col-md-12 center-block" style="padding:20px;">


<h3>Currently Deployed Mooring Location Summary</h3>   

<div class="container">
<div class="col-lg-8 col-md-10 col-sm-12 hidden-xs center-block">

<!-- leaflet Maps
================================================== -->
<!-- Leaflet map -->
<script type="text/javascript" src="../node_modules/leaflet/dist/leaflet.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.1.0/leaflet.ajax.js"></script>
<script type="text/javascript" src="http://maps.stamen.com/js/tile.stamen.js?v1.3.0"></script>
<div id="leaflet_map" style="width: 100%; height: 400px"></div>
<script>

    var Esri_OceanBasemap = new L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/Ocean_Basemap/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Sources: GEBCO, NOAA, CHS, OSU, UNH, CSUMB, National Geographic, DeLorme, NAVTEQ, and Esri',
        maxZoom: 13
    });

    //http://maps.ngdc.noaa.gov/arcgis/rest/services/web_mercator/gebco08_contours/MapServer/tile/{z}/{y}/{x}
    // replace "toner" here with "terrain" or "watercolor"
    //var layer = new L.StamenTileLayer("toner");
    var mymap = new L.Map("leaflet_map", {
        center: new L.LatLng(60.0, -160),
        zoom: 3
    });
    mymap.addLayer(Esri_OceanBasemap);    

    var geojsonMarkerOptions = {
        radius: 4,
        fillColor: "#D54339",
        color: "#ffffff",
        weight: .2,
        opacity: 1,
        fillOpacity: 0.8
    };
    var geojsonLayer = new L.GeoJSON.AJAX("<?php echo '../dynamic_data/EcoFOCI_Moorings/maps_visualizations/Current_Moorings.geojson'?>", {
        pointToLayer: function (feature, latlng) {
            return L.circleMarker(latlng, geojsonMarkerOptions);
        },
        onEachFeature: function (feature, layer) {
        layer.bindPopup(feature.properties.MooringID);
        }
    });  

    geojsonLayer.addTo(mymap);


</script>
<!-- End Leaflet map -->



<p>
<br><a href="../dynamic_data/EcoFOCI_Moorings/maps_visualizations/Current_Moorings.geojson">Grab the .geojson file for the above graphic here with comprehensive mooring information at each site </a>
<br>Cut and paste the file into the following page for a dynamic view of the sites <a href="http://geojson.io/#map=2/20.0/0.0">geojson.io</a>
</p>
</div>
</div>


<?php mooring_location_summary('MooringDeploymentLogs','DEPLOYED'); ?>


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