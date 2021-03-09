<html>
<head>
<link rel="stylesheet" type="text/css" id="bootstrap.css" href="../bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v1.0.1/leaflet.css" />

<link rel="stylesheet" type="text/css" id="dygraph.css" href="../node_modules/dygraphs/dist/dygraph.css" />

<script type="text/javascript"  src="../node_modules/dygraphs/dist/dygraph.js"></script>
<script type="text/javascript"  src="../node_modules/dygraphs/src/extras/synchronizer.js"></script>

<style>#map { width: 800px; height: 500px; }
.info { padding: 6px 8px; font: 14px/16px Arial, Helvetica, sans-serif; background: white; background: rgba(255,255,255,0.8); box-shadow: 0 0 15px rgba(0,0,0,0.2); border-radius: 5px; } .info h4 { margin: 0 0 5px; color: #777; }
.legend { text-align: left; line-height: 18px; color: #555; } .legend i { width: 18px; height: 18px; float: left; margin-right: 8px; opacity: 0.7; }
</style>

<script type="text/javascript"  src="../scripts/leaflet/leaflet.js"></script>
<script type="text/javascript"  src="../scripts/leaflet/leaflet.ajax.min.js"></script>
<script type="text/javascript"  src="../scripts/jquery/jquery.min.js"></script>
<script type="text/javascript"  src="http://maps.stamen.com/js/tile.stamen.js?v1.3.0"></script>
</head>
<body>
<body>

<?php include('postgis_leaflet/php/getData.php'); ?>

<?php 
$DrifterID = htmlspecialchars($_GET['DrifterID']);
$DrifterYear = htmlspecialchars($_GET['DrifterYear']);
?>

<div id="SSTdiv" style="width: 90%; height:200"></div><br>
<div id="STRAINdiv" style="width: 90%; height:200"></div><br>
<div id="VOLTdiv" style="width: 90%; height:200"></div><br>

<script type="text/javascript">
  var g1 = new Dygraph(

    // containing div
    document.getElementById("SSTdiv"),


    // CSV or path to a CSV file.
    <?php echo '"../dynamic_data/EcoFOCI_Drifters/Drifter_CSV/'.$DrifterID.'_'.$DrifterYear.'.csv"';?>,
          {
            title: 'Temp',
            ylabel: 'Temperature (C)',
            legend: 'always',
            strokeWidth: 0.5,
            drawPoints: true,
            visibility: [false, false, false, false, false, false, true, false],
            rollPeriod: 1
          }
  ),
  g2 = new Dygraph(

    // containing div
    document.getElementById("STRAINdiv"),

    // CSV or path to a CSV file.
    // CSV or path to a CSV file.
    <?php echo '"../dynamic_data/EcoFOCI_Drifters/Drifter_CSV/'.$DrifterID.'_'.$DrifterYear.'.csv"';?>,
          {
            title: 'Strain',
            ylabel: 'percent',
            legend: 'always',
            strokeWidth: 0.5,
            drawPoints: true,
            visibility: [false, false, false, false, true, false, false, false],
            rollPeriod: 1
          }
  ),
  g3 = new Dygraph(

    // containing div
    document.getElementById("VOLTdiv"),

    // CSV or path to a CSV file.
    // CSV or path to a CSV file.
    <?php echo '"../dynamic_data/EcoFOCI_Drifters/Drifter_CSV/'.$DrifterID.'_'.$DrifterYear.'.csv"';?>,
          {
            title: 'Voltage',
            ylabel: 'Volts',
            legend: 'always',
            strokeWidth: 0.5,
            drawPoints: true,
            visibility: [false, false, false, false, false, true, false, false],
            rollPeriod: 1
          }
  );
  var sync = Dygraph.synchronize(g1, g2, g3, {
    selection: true,
    zoom: true,
    range: false
    });
    
</script>
</body>

<?php
echo '<table><tbody>
      <td><a href="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$DrifterID.'_wide_drifter.png"><img src="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$DrifterID.'_wide_drifter.png" height="20%" width="95%"></a></td>
      <td><a href="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$DrifterID.'_zoom_drifter.png"><img src="../dynamic_data/EcoFOCI_Drifters/Drifter_Maps/'.$DrifterID.'_zoom_drifter.png" height="20%" width="95%"></a></td>
      </tbody></table>'.PHP_EOL;
?>

<div id="mapid" style="width: 100%; height: 50%"></div>

    <script>


    var Esri_OceanBasemap = new L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/Ocean_Basemap/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Sources: GEBCO, NOAA, CHS, OSU, UNH, CSUMB, National Geographic, DeLorme, NAVTEQ, and Esri',
        maxZoom: 12
    });
    //http://maps.ngdc.noaa.gov/arcgis/rest/services/web_mercator/gebco08_contours/MapServer/tile/{z}/{y}/{x}
    // replace "toner" here with "terrain" or "watercolor"
    //var layer = new L.StamenTileLayer("toner");
    var mymap = new L.Map("mapid", {
        center: new L.LatLng(56.864, -164.066),
        zoom: 6
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

  
    var geojsonLayer = new L.GeoJSON.AJAX("<?php echo '../dynamic_data/EcoFOCI_Drifters/geojson/'.$DrifterID.'.geojson' ?>", {
        pointToLayer: function (feature, latlng) {
            return L.circleMarker(latlng, geojsonMarkerOptions);
        },
        onEachFeature: function (feature, layer) {
        layer.bindPopup('GPS Signal Quality:'+feature.properties.quality+'<br>'+
            'Date:'+feature.properties.datetime);

        }
    });  

    geojsonLayer.addTo(mymap);

    </script>
</body>
</html>