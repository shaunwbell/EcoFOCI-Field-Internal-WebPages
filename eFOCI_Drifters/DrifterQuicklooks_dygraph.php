<html>
<head>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
<script type="text/javascript"  src="../scripts/dygraph-combined.js"></script>
<script type="text/javascript"  src="../scripts/dygraphs-master/src/extras/synchronizer.js"></script>
<script type="text/javascript"  src="../scripts/leaflet/leaflet.js"></script>
<script type="text/javascript"  src="../scripts/jquery/jquery.min.js"></script>
<script type="text/javascript"  src="http://maps.stamen.com/js/tile.stamen.js?v1.3.0"></script>
</head>
<body>

<?php include('postgis_leaflet/php/getData.php'); ?>

<?php 
$DrifterID = htmlspecialchars($_GET['DrifterID']);
?>

<div id="SSTdiv" style="width: 90%; height:200"></div><br>

<script type="text/javascript">
  var g1 = new Dygraph(

    // containing div
    document.getElementById("SSTdiv"),

    // CSV or path to a CSV file.
    <?php echo '"../dynamic_data/EcoFOCI_Drifters/Drifter_CSV/'.$DrifterID.'_temp.csv"';?>,
          {
            title: 'SST Test',
            ylabel: 'SST (C)',
            legend: 'always',
            strokeWidth: 0.5,
            drawPoints: true,
            showRoller: true,
            rollPeriod: 1
          }
  );

</script>

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
            maxZoom: 13
        });
        //http://maps.ngdc.noaa.gov/arcgis/rest/services/web_mercator/gebco08_contours/MapServer/tile/{z}/{y}/{x}
        // replace "toner" here with "terrain" or "watercolor"
        //var layer = new L.StamenTileLayer("toner");
        var mymap = new L.Map("mapid", {
            center: new L.LatLng(55.5, -178.3),
            zoom: 4
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
        var data = [<?php echo postgres_data_singleid($DrifterID) ?>]

        //L.geoJson(data).addTo(mymap);

        var geojsonLayer = new L.GeoJSON.AJAX("<?php echo 'data/'.$DrifterID.'.geojson'?>", {
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, geojsonMarkerOptions_bs);
            },
            onEachFeature: function (feature, layer) {
            layer.bindPopup('GPS Signal Quality:'+feature.properties.quality+'<br>'+
                'Date:'+feature.properties.datetime);

            }
        geojsonLayer.addTo(mymap);

        var popup = L.popup();

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("You clicked the map at " + e.latlng.toString())
                .openOn(mymap);
        }

        mymap.on('click', onMapClick);

    </script>
</body>
</html>