<html>
<head>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v1.0.1/leaflet.css" />

<style>#map { width: 800px; height: 500px; }
.info { padding: 6px 8px; font: 14px/16px Arial, Helvetica, sans-serif; background: white; background: rgba(255,255,255,0.8); box-shadow: 0 0 15px rgba(0,0,0,0.2); border-radius: 5px; } .info h4 { margin: 0 0 5px; color: #777; }
.legend { text-align: left; line-height: 18px; color: #555; } .legend i { width: 18px; height: 18px; float: left; margin-right: 8px; opacity: 0.7; }
</style>

<script type="text/javascript"  src="../../scripts/leaflet/leaflet.js"></script>
<script type="text/javascript"  src="../../scripts/leaflet/leaflet.ajax.min.js"></script>
<script type="text/javascript"  src="../../scripts/jquery/jquery.min.js"></script>
<script type="text/javascript"  src="http://maps.stamen.com/js/tile.stamen.js?v1.3.0"></script>
</head>
<body>

<div id="mapid" style="width: 100%; height: 100%"></div>

    <script>

        // get color depending on population density value
        function getColor(d) {
            return d == 'Moorings' ? '#009933' :
                    d == 'Floats'  ? '#0000ff' :
                    d == 'CTD/BON'  ? '#D54339' :
                    d == 'CTD'  ? '#660066' :
                    d == 'Calvets'   ? '#808080' :
                    d == 'DBO'   ? '#FFFF00' :
                                '#FFEDA0';
        }

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

        var geojsonLayer = new L.GeoJSON.AJAX("<?php echo 'DY1805.geojson'?>", {
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, geojsonMarkerOptions);
            },
            onEachFeature: function (feature, layer) {
            layer.bindPopup(feature.properties.FIELD1 + ' ' + feature.properties.FIELD2);
            }
        }); 

        geojsonLayer.addTo(mymap);

        var geojsonMarkerOptions_ctdonly = {
            radius: 4,
            fillColor: "#660066",
            color: "#ffffff",
            weight: .2,
            opacity: 1,
            fillOpacity: 0.8
        };

        var geojsonLayer = new L.GeoJSON.AJAX("<?php echo 'DY1805_ctdonly.geojson'?>", {
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, geojsonMarkerOptions_ctdonly);
            },
            onEachFeature: function (feature, layer) {
            layer.bindPopup(feature.properties.FIELD1 + ' ' + feature.properties.FIELD2);
            }
        });

        geojsonLayer.addTo(mymap);
        var geojsonMarkerOptions_float = {
            radius: 4,
            fillColor: "#0000ff",
            color: "#ffffff",
            weight: .2,
            opacity: 1,
            fillOpacity: 0.8
        };

        var geojsonLayer = new L.GeoJSON.AJAX("<?php echo 'DY1805_floats.geojson'?>", {
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, geojsonMarkerOptions_float);
            },
            onEachFeature: function (feature, layer) {
            layer.bindPopup(feature.properties.FIELD1 + ' ' + feature.properties.FIELD2);
            }
        });

        geojsonLayer.addTo(mymap);

        var geojsonMarkerOptions_mooring = {
            radius: 4,
            fillColor: "#009933",
            color: "#ffffff",
            weight: .2,
            opacity: 1,
            fillOpacity: 0.8
        };

        var geojsonLayer = new L.GeoJSON.AJAX("<?php echo 'DY1805_moorings.geojson'?>", {
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, geojsonMarkerOptions_mooring);
            },
            onEachFeature: function (feature, layer) {
            layer.bindPopup(feature.properties.FIELD1 + ' ' + feature.properties.FIELD2);
            }
        });

        geojsonLayer.addTo(mymap);



        var geojsonMarkerOptions_calvets = {
            radius: 4,
            fillColor: "#808080",
            color: "#ffffff",
            weight: .2,
            opacity: 1,
            fillOpacity: 0.8
        };

        var geojsonLayer = new L.GeoJSON.AJAX("<?php echo 'DY1805_calvets.geojson'?>", {
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, geojsonMarkerOptions_calvets);
            },
            onEachFeature: function (feature, layer) {
            layer.bindPopup(feature.properties.FIELD1 + ' ' + feature.properties.FIELD2);
            }
        });

        var geojsonMarkerOptions_dbo = {
            radius: 4,
            fillColor: "#FFFF00",
            color: "#ffffff",
            weight: .2,
            opacity: 1,
            fillOpacity: 0.8
        };

        var geojsonLayer = new L.GeoJSON.AJAX("<?php echo 'DY1805_DBO.geojson'?>", {
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, geojsonMarkerOptions_dbo);
            },
            onEachFeature: function (feature, layer) {
            layer.bindPopup(feature.properties.FIELD1 + ' ' + feature.properties.FIELD2);
            }
        });


        geojsonLayer.addTo(mymap);        

        var legend = L.control({position: 'bottomleft'});

        legend.onAdd = function (map) {

            var div = L.DomUtil.create('div', 'info legend'),
                categories = ['Moorings','Floats','CTD/BON','CTD','Calvets','DBO'];

            // loop through our density intervals and generate a label with a colored square for each interval
            for (var i = 0; i < categories.length; i++) {
                div.innerHTML +=
                    '<i style="background:' + getColor(categories[i]) + '"></i> ' +
                    (categories[i] ? categories[i ] + '<br>' : '+');
            }

            return div;
        };

        legend.addTo(mymap);

    </script>
</body>
</html>