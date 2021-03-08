<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>CTD Quicklook Plots</title>

<script src="../../scripts/jquery_1.11.0/jquery.min.js"></script>
<script src="../../scripts/Highcharts/js/highcharts.js"></script>
<script src="../../scripts/Highcharts/js/modules/exporting.js"></script>
<script src="../../scripts/Highcharts/js/modules/data.js"></script>

    </head>
    <body>


<div id="outer">

<div id="container" style="float: left; width: 50%; height: 1000px; margin: 0 auto"></div>
<div id="container2" style="float: right;width: 50%; height: 1000px; margin: 0 auto"></div>
<div style="clear:both;"></div></div>
<?php 

//$ConsecutiveCastNo = htmlspecialchars($_GET['ConsecutiveCastNo']);
//$CruiseID = htmlspecialchars($_GET['CruiseID']);
//$PlotParam = htmlspecialchars($_GET['PlotParam']);
include('get_data_ctd.php'); 
$CruiseID = htmlspecialchars($_GET['CruiseID']);
$ConsecutiveCastNo = htmlspecialchars($_GET['ConsecutiveCastNo']);
$CruiseID_table = $CruiseID.'_Oceanographic';
$DepthData = 'DepthData';

$data_temp = ctd_data($CruiseID_table,$ConsecutiveCastNo,'PrimaryTemperatureData',$DepthData);
$data_temp2 = ctd_data($CruiseID_table,$ConsecutiveCastNo,'SecondaryTemperatureData',$DepthData);
$data_sal = ctd_data($CruiseID_table,$ConsecutiveCastNo,'PrimarySalinityData',$DepthData);
$data_sal2 = ctd_data($CruiseID_table,$ConsecutiveCastNo,'SecondarySalinityData',$DepthData);
$data_dens = ctd_data($CruiseID_table,$ConsecutiveCastNo,'PrimaryDensityData',$DepthData);
$data_dens2 = ctd_data($CruiseID_table,$ConsecutiveCastNo,'SecondaryDensityData',$DepthData);
$data_trans = ctd_data($CruiseID_table,$ConsecutiveCastNo,'TransmissometerData',$DepthData);

$CruiseID_table = $CruiseID.'_Biologic';
$data_par = ctd_data($CruiseID_table,$ConsecutiveCastNo,'PrimaryPARData',$DepthData);
$data_chl = ctd_data($CruiseID_table,$ConsecutiveCastNo,'ChlorophyllAFluorometerData',$DepthData);
?>
<script type="text/javascript">
$(function () {
    $('#container').highcharts({

        chart: {
            zoomType: 'xy'
        },
        title: {
            text: 'T,S,SigmaT',
        },
        subtitle: {
        },
        xAxis: [{
            title: {
                enabled: true,
                text: 'Temperature (C)'
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true
        },{
            title: {
                enabled: true,
                text: 'Salinity (PSU)'
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true
        },{
            title: {
                enabled: true,
                text: 'Density (kg/m^3)'
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true
        }],
        yAxis: {
            reversed: true,
            title: {
                text: 'Depth (dBar)'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: 25,
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
            borderWidth: 1
        },
        plotOptions: {
            scatter: {
                lineWidth: 1,
                marker: {
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true,
                            lineColor: 'rgb(100,100,100)'
                        }
                    }
                },
                states: {
                    hover: {
                        marker: {
                            enabled: false
                        }
                    }
                }
            }
        },
        series: [{
            type: 'scatter',
            name: 'PrimaryTemperatureData',
            color: 'rgba(150, 83, 83, .5)',
            xAxis: 0,
            data: [<?php foreach($data_temp as $key=>$value) { echo $value;} ?>],
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} Deg C, {point.y} mBar'
            },
        },{
            type: 'scatter',
            name: 'SecondaryTemperatureData',
            color: 'rgba(150, 83, 83, .5)',
            xAxis: 0,
            visible: false,
            data: [<?php foreach($data_temp2 as $key=>$value) { echo $value;} ?>],
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} Deg C, {point.y} mBar'
            },
        },{
            type: 'scatter',
            name: 'PrimarySalinityData',
            xAxis: 1,
            data: [<?php foreach($data_sal as $key=>$value) { echo $value;} ?>],
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} Deg C, {point.y} mBar'
            },
        },{
            type: 'scatter',
            name: 'SecondarySalinityData',
            visible: false,
            xAxis: 1,
            data: [<?php foreach($data_sal2 as $key=>$value) { echo $value;} ?>],
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} Deg C, {point.y} mBar'
            },
        },{
            type: 'scatter',
            name: 'PrimaryDensityData',
            xAxis: 2,
            data: [<?php foreach($data_dens as $key=>$value) { echo $value;} ?>],
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} Deg C, {point.y} mBar'
            },
        },{
            type: 'scatter',
            name: 'SecondaryDensityData',
            xAxis: 2,
            visible: false,
            data: [<?php foreach($data_dens2 as $key=>$value) { echo $value;} ?>],
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} Deg C, {point.y} mBar'
            },
        }]
    });
});
$(function () {
    $('#container2').highcharts({

        chart: {
            zoomType: 'xy'
        },
        title: {
            text: 'Biological',
        },
        subtitle: {
        },
        xAxis: [{
            title: {
                enabled: true,
                text: 'Transmissometer (%)'
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true
        },{
            title: {
                enabled: true,
                text: 'PAR'
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true
        },{
            title: {
                enabled: true,
                text: 'ChlorophyllA'
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true
        }],
        yAxis: {
            reversed: true,
            title: {
                text: 'Depth (dBar)'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: 25,
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
            borderWidth: 1
        },
        plotOptions: {
            scatter: {
                lineWidth: 1,
                marker: {
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true,
                            lineColor: 'rgb(100,100,100)'
                        }
                    }
                },
                states: {
                    hover: {
                        marker: {
                            enabled: false
                        }
                    }
                }
            }
        },
        series: [{
            type: 'scatter',
            name: 'TransmissometerData',
            color: 'black',
            xAxis: 0,
            data: [<?php foreach($data_trans as $key=>$value) { echo $value;} ?>],
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} %, {point.y} mBar'
            },
        },{
            type: 'scatter',
            name: 'PrimaryPARData',
            color: 'yellow',
            xAxis: 1,
            visible: true,
            data: [<?php foreach($data_par as $key=>$value) { echo $value;} ?>],
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} Deg C, {point.y} mBar'
            },
        },{
            type: 'scatter',
            name: 'ChlorA',
            color: 'green',
            xAxis: 2,
            visible: true,
            data: [<?php foreach($data_chl as $key=>$value) { echo $value;} ?>],
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} Deg C, {point.y} mBar'
            },
        }]
    });
});

</script>

	</body>
</html>
