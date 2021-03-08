<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cruise Records</title>
<!-- Bootstrap theme -->
<link rel="stylesheet" type="text/css" id="bootstrap.css" href="../bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/bootstrap_datatables/bootstrap_datatables.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v1.0.1/leaflet.css" />


<!-- js calendar
================================================== -->
<script type="text/javascript" src="../scripts/d3/d3.min.js"></script>
<script type="text/javascript" src="../scripts/cal-heatmap/cal-heatmap.min.js"></script>
<link rel="stylesheet" type="text/css"  href="../scripts/cal-heatmap/cal-heatmap.css" />

<!-- when using the dataTables javascript plugin, jquery and dataTables must be at top of page -->
<!-- dataTables seems to only work well with a single table on a page-->

<!-- DataTables -->
<script src="../scripts/jquery_1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="../scripts/DataTables-1.10.12/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../scripts/bootstrap_datatables/dataTables.bootstrap.js"></script>
<script>
    $(document).ready(function() {
        $('table.table').dataTable( {
        "iDisplayLength": 5
        } );
    } );
</script>


</head>

<body>


<!-- local php includes
================================================== -->
<?php 
include('../ecofoci_images/header.php'); 
include('php_routines/nav_header.php');
include('php_routines/casts2json.php');
include('php_routines/cruise_php_routines.php');

$CruiseID = htmlspecialchars($_GET['CruiseID']);
?>

<!-- Bootstrap - Static navbar
================================================== -->
<div class="container">


<!-- Static navbar -->
<?php build_navbar("Home") ?>

<!-- End Navigation
================================================== -->


<div class="col-md-12 center-block" style="padding:20px;">

<!-- Content
================================================== -->
<div class="container" id="summary">
<div class="col-md-4">
<strong>Cruise Summary:</strong><br>
<?php list($startdate,$enddate) = cruiselogs_table_cruiseheader("cruises",$CruiseID); ?>
</div>
<div class="col-md-4">
<strong>Operations Summary:</strong><br>
<?php cruiselogs_table_summaryheader("cruises",$CruiseID); ?>
</div>
</div>
<!-- Column 1 
================================================== -->
<div class="container" id="maps">
<h3>Cruise Map</h3>
<div class="col-md-4">
(Click for bigger view)
<br>
<?php echo '<a href="../dynamic_data/EcoFOCI_CTDCasts/CTDCruiseMaps/'.$CruiseID.'/'.$CruiseID.'_map.png"><img src="../dynamic_data/EcoFOCI_CTDCasts/CTDCruiseMaps/'.$CruiseID.'/'.$CruiseID.'_map.png" alt="'.$CruiseID.' Map" height="90%" width="90%"></a>'.PHP_EOL; ?>


</div>


<!-- Column 2 
================================================== -->
<div class="col-sm-7">

<!-- leaflet Maps
================================================== -->
<!-- Leaflet map -->
<script type="text/javascript" src="../scripts/leaflet/leaflet.js"></script>
<script type="text/javascript" src="../scripts/leaflet/leaflet.ajax.min.js"></script>
<script type="text/javascript" src="http://maps.stamen.com/js/tile.stamen.js?v1.3.0"></script>
<div id="leaflet_map" style="width: 100%; height: 400px"></div>
<script>

    var Esri_OceanBasemap = new L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/Ocean_Basemap/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Sources: GEBCO, NOAA, CHS, OSU, UNH, CSUMB, National Geographic, DeLorme, NAVTEQ, and Esri',
        maxZoom: 13
    });
    var OpenMapSurfer_Roads = L.tileLayer('http://korona.geog.uni-heidelberg.de/tiles/roads/x={x}&y={y}&z={z}', {
    maxZoom: 20,
    attribution: 'Imagery from <a href="http://giscience.uni-hd.de/">GIScience Research Group @ University of Heidelberg</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
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
    var geojsonLayer = new L.GeoJSON.AJAX("<?php echo '../dynamic_data/EcoFOCI_CTDCasts/CTDCruiseMaps/'.$CruiseID.'/'.$CruiseID.'.geo.json'?>", {
        pointToLayer: function (feature, latlng) {
            return L.circleMarker(latlng, geojsonMarkerOptions);
        },
        onEachFeature: function (feature, layer) {
        layer.bindPopup(feature.properties.ConsecutiveCastNo);
        }
    });  

    geojsonLayer.addTo(mymap);


</script>



</div>
</div>
<br><br>

<!-- Content
================================================== -->
<div class="container" id="erddap">
<h3>Cruise Track</h3>

<?php echo '<img src="https://coastwatch.pfeg.noaa.gov/erddap/tabledap/fsuNoaaShipWTEP.png?longitude,latitude,time%26time%3E='.$startdate.'%26time%3C='.$enddate.'%26flag=~%22ZZZ.*%22%26.draw=markers%26.marker=3%7C5%26.color=0x000000%26.colorBar=%7C%7C%7C%7C%7C%26.bgColor=0xffccccff" alt="cruise_track" width=450px>
<br>
<a href="https://coastwatch.pfeg.noaa.gov/erddap/tabledap/fsuNoaaShipWTEP.graph?longitude,latitude,time%26time%3E='.$startdate.'%26time%3C='.$enddate.'%26flag=~%22ZZZ.*%22%26.draw=markers%26.marker=3%7C5%26.color=0x000000%26.colorBar=%7C%7C%7C%7C%7C%26.bgColor=0xffccccff">edit image / download data</a>'.PHP_EOL; ?>
<p>Cruise Track provided by FSU SAMOS - Quality Controlled Data<br>
Currently only available for Dyson Cruises</p>
</div>



<div class="container" id="met_plots">
<h3>Met obs from Cast Logs</h3>

<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script src="https://code.highcharts.com/modules/windbarb.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            zoomType: 'x'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                month: '%b',
                year: '%Y'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: [{ // left axis
            labels: {
                format: '{value}°C'
            },
            title: {
                text: 'T'
            },
            min: -5
            },{ // right axis
            labels: {
                format: '{value} mb'
            },
            title: { // rightaxis
                text: 'P'
            },
            opposite: true,
            min: 950,
            },{ // left secondary axis
            labels: {
                format: '{value} rh'
            },
            title: { // rightaxis
                text: 'RH'
            },
            max: 100,
        }],


        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },

        series: [{
            name: 'Air Temperature',
            data: <?php casts2csv_met($CruiseID,'DryBulb'); ?>
        }, {
            name: 'Pressure',
            yAxis: 1,
            data: <?php casts2csv_met($CruiseID,'Pressure'); ?>
        }, {
            name: 'RH',
            yAxis: 2,
            data: <?php casts2csv_met($CruiseID,'RelativeHumidity'); ?>
        },{
        type: 'windbarb',
        data: <?php casts2csv_wind($CruiseID,'WindSpd','WindDir'); ?>,
        name: 'Wind',
        color: Highcharts.getOptions().colors[1],
        showInLegend: false,
        tooltip: {
            valueSuffix: ' m/s'
        }
    }]
    });
});
</script>

<div id="container" style="height: 80%; width: 80%; margin: 0 0"></div>


</div>

<div class="container" id="cast_cal">
<br>
<h3>CTD Cast Timeline</h3>
<script type="text/javascript">

    var cal = new CalHeatMap();
    cal.init({
    itemSelector: "#cast_cal",
    domain: "month",
    data: <?php casts2json($CruiseID); ?>,
    start: new Date(<?php casts2json_mindate($CruiseID); ?>, 1, 1),
    });

</script>
</div>

<br>
<h3>CTD Meta Summary</h3>
<?php echo '<a href="cruise_cast_notes.php?CruiseID='.$CruiseID.'"> Cruise Summary</a>'; ?> can be copied and pasted into excel<br>
<?php echo '<a href="cruise_cast_btl_report.php?CruiseID='.$CruiseID.'"> Cruise Bottle Summary</a>'; ?> can be copied and pasted into excel<br>
<?php echo '<a href="cruise_cast_btl_salts_report.php?CruiseID='.$CruiseID.'"> Cruise Bottle Discreet Salts Summary</a>'; ?> can be copied and pasted into excel<br>
<?php echo '<a href="cruise_cast_btl_oxygen_report.php?CruiseID='.$CruiseID.'"> Cruise Bottle Discreet Oxygen Summary</a>'; ?> can be copied and pasted into excel<br>


<h3> CTD Meta Summary Table</h3>
<p>Cast Logs (use the slider at the bottom or click a row and use the arrow keys to navigate all columns)</p>
<?php cruiselogs_table_cruise("cruisecastlogs",$CruiseID); ?>

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
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../scripts/jquery.backstretch.js"></script>
<script>
    $.backstretch(["../ecofoci_images/backgrounds/peggy_buoy.jpg"]);
</script>

</body>
</html>