<html>
<head>
<script type="text/javascript"  src="../scripts/dygraph-combined.js"></script>
<script type="text/javascript"  src="../scripts/dygraphs-master/src/extras/synchronizer.js"></script>
</head>
<body>

<?php 
$MooringID = htmlspecialchars($_GET['MooringID']);
?>

<div id="tempdiv" style="width: 90%; height:200"></div><br>
<div id="salindiv" style="width: 90%; height:200"></div><br>
<div id="pressdiv" style="width: 90%; height:200"></div><br>
<div id="indexdiv" style="width: 90%; height:200"></div><br>


<script type="text/javascript">
  var g1 = new Dygraph(

    // containing div
    document.getElementById("tempdiv"),

    // CSV or path to a CSV file.
    <?php echo '"../dynamic_data/EcoFOCI_Moorings/Mooring_CSV/'.$MooringID.'.csv"';?>,
          {
            title: '',
            ylabel: '',
            legend: 'always',
            strokeWidth: 0.5,
            drawPoints: true,
            visibility: [false, true, false, false, false],
            showRoller: true,
            rollPeriod: 1,
           }
  ),
  g2 = new Dygraph(

    // containing div
    document.getElementById("salindiv"),

    // CSV or path to a CSV file.
    <?php echo '"../dynamic_data/EcoFOCI_Moorings/Mooring_CSV/'.$MooringID.'.csv"';?>,
          {
            title: '',
            ylabel: '',
            legend: 'always',
            strokeWidth: 0.5,
            drawPoints: true,
            visibility: [false, false, true, false, false],
            showRoller: true,
            rollPeriod: 1,
          }
  ),
  g3 = new Dygraph(

    // containing div
    document.getElementById("pressdiv"),

    // CSV or path to a CSV file.
    <?php echo '"../dynamic_data/EcoFOCI_Moorings/Mooring_CSV/'.$MooringID.'.csv"';?>,
          {
            title: '',
            ylabel: '',
            legend: 'always',
            strokeWidth: 0.5,
            drawPoints: true,
            visibility: [false, false, false, true, false],
            showRoller: true,
            rollPeriod: 1,
          }
  ),
  g4 = new Dygraph(

    // containing div
    document.getElementById("indexdiv"),

    // CSV or path to a CSV file.
    <?php echo '"../dynamic_data/EcoFOCI_Moorings/Mooring_CSV/'.$MooringID.'.csv"';?>,
          {
            title: '',
            ylabel: '',
            legend: 'always',
            strokeWidth: 0.5,
            drawPoints: true,
            visibility: [false, false, false, false, true],
            showRoller: true,
            rollPeriod: 1,
          }
  );  
  var sync = Dygraph.synchronize([g1, g2, g3, g4], {
    selection: true,
    zoom: true,
    range: false
    });
        
</script>
</body>
</html>