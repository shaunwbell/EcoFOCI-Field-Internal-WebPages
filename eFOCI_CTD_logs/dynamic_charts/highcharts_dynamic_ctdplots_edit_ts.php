<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>CTD Quicklook Plots</title>

<script src="../../scripts/jquery/jquery.min.js"></script>
<script src="../../scripts/Highcharts/js/highcharts.js"></script>
<script src="../../scripts/Highcharts/js/modules/exporting.js"></script>
<script src="../../scripts/Highcharts/js/modules/data.js"></script>
<script src="../../scripts/highcharts_plugins/draggable.js"></script>
<script src="../../scripts/highcharts_plugins/export-csv-profile.js"></script>
<!--<script src="http://highcharts.github.io/export-csv/export-csv.js"></script>-->

    </head>
    <body>


<div id="container" style="width: 80%; height: 1000px"></div>
<div id="container2" style="width: 50%; height: 200px"></div>
<div id="drag"></div>
<div id="drop"></div>

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


?>
<script type="text/javascript">
$(function () {
    $('#container').highcharts({

  chart: {
      zoomType: 'xy'
  },

  title: {
    text: 'Edit CTD Temperature/Salinity'
  },

  xAxis: [{
    title: {
      enabled: true,
      text: 'Temperature (C)'
    },
    startOnTick: true,
    endOnTick: true,
    showLastLabel: true
  }, {
    title: {
      enabled: true,
      text: 'O2 Conc'
    },
    startOnTick: true,
    endOnTick: true,
    showLastLabel: true
  }, {
    title: {
      enabled: true,
      text: 'O2 Sat '
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
    align: 'center',
    verticalAlign: 'bottom',
    floating: false,
    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
	borderWidth: 0
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
      }
  },
      series: {
          point: {
              events: {

                  drag: function (e) {
                      // Returning false stops the drag and drops. Example:
                      /*
                      if (e.newY > 300) {
                          this.y = 300;
                          return false;
                      }
                      */

                      $('#drag').html(
                          'Dragging <b>' + this.series.name + '</b> to <b>[' + Highcharts.numberFormat(e.newX, 2)  + ', ' + Highcharts.numberFormat(e.newY, 2) + ']</b>');;
                  },
                  drop: function () {
                      $('#drop').html(
                          'Dropped <b>' + this.series.name + '</b> at <b>[' + Highcharts.numberFormat(this.x, 2)  + ', ' + Highcharts.numberFormat(this.y, 2) + ']</b>');
                  }
              }
          },
          stickyTracking: false
      },

  },

  tooltip: {
      yDecimals: 2,
	  xDecimals: 4
  },


  series: [{
    type: 'scatter',
    cursor: 'move',
    draggableX: true,
    draggableY: false,
    name: 'PrimaryTemperatureData',
    color: 'red',
    xAxis: 0,
    data: [<?php foreach($data_temp as $key=>$value) { echo $value;} ?>],

  },{
    type: 'scatter',
    cursor: 'move',
    draggableX: true,
    draggableY: false,
    name: 'SecondaryTemperatureData',
    color: 'rgba(150, 83, 83, .5)',
    xAxis: 0,
    visible: true,
    data: [<?php foreach($data_temp2 as $key=>$value) { echo $value;} ?>],

  },{
    type: 'scatter',
    cursor: 'move',
    draggableX: true,
    draggableY: false,
    name: 'PrimarySalinityData',
    xAxis: 1,
    data: [<?php foreach($data_sal as $key=>$value) { echo $value;} ?>],

  },{
    type: 'scatter',
    cursor: 'move',
    draggableX: true,
    draggableY: false,
    name: 'SecondarySalinityData',
    xAxis: 1,
    visible: true,
    data: [<?php foreach($data_sal2 as $key=>$value) { echo $value;} ?>],
  }]


  });


});



</script>

    </body>
</html>
