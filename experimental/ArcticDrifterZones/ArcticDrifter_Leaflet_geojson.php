<html>
<head>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v1.0.1/leaflet.css" />
<script type="text/javascript"  src="../../scripts/leaflet/leaflet.js"></script>
<script type="text/javascript"  src="../../scripts/leaflet/leaflet.ajax.min.js"></script>
<script type="text/javascript"  src="../../scripts/jquery/jquery.min.js"></script>
<script type="text/javascript"  src="http://maps.stamen.com/js/tile.stamen.js?v1.3.0"></script>
</head>
<body>

<?php include('../../eFOCI_Drifters/postgis_leaflet/php/getData.php'); ?>

<?php 
$DrifterID = htmlspecialchars($_GET['DrifterID']);
?>

<div id="mapid" style="width: 100%; height: 100%"></div>

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


        var geojsonLayer = new L.GeoJSON.AJAX("<?php echo $DrifterID.'.geojson'?>", {
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, geojsonMarkerOptions);
            },
            onEachFeature: function (feature, layer) {
            layer.bindPopup(feature.properties.datetime);
            }
        }); 

        geojsonLayer.addTo(mymap);


        var geojsonLayer = new L.GeoJSON.AJAX("<?php echo 'ArcticDrifterLinesV2.geojson'?>", {
            onEachFeature: function (feature, layer) {
            layer.bindPopup(feature.geometry.type);
            }
        });  

        geojsonLayer.addTo(mymap);

    </script>
</body>
</html>