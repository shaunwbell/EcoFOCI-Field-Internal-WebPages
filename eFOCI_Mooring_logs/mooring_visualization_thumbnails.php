<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mooring Deployment Plots</title>
<link rel="stylesheet" type="text/css" id="node_modules/bootstrap.css" href="../bootstrap/dist/css/bootstrap.css.spacelab.V3.css" />
<link rel="stylesheet" type="text/css" id="custom.css" href="../scripts/css/custom.css" />

</head>

<body>

<?php

$Year = htmlspecialchars($_GET['Year']);
$MooringID = htmlspecialchars($_GET['MooringID']);

$dirname = "../dynamic_data/EcoFOCI_Moorings/MooringVisualizations/$Year/$MooringID/";
$images = glob($dirname."*.png");
$colcounter=0;

foreach($images as $image) {
	if (($colcounter %3)  == 0) {
		$imagelist.= '<div class="row">';
		$imagelist.= '<div class="col-xs-3 col-md-3 col-lg-3 col-xl"><a href="'.$image.'" class="thumbnail"><img src="'.$image.'" ></a></div>'.PHP_EOL;
  	}
	elseif (($colcounter %3)  == 2) {
		$imagelist.= '<div class="col-xs-3 col-md-3 col-lg-3 col-xl"><a href="'.$image.'" class="thumbnail"><img src="'.$image.'" ></a></div>'.PHP_EOL;
		$imagelist.= '</div>'.PHP_EOL;
  	}
  	else {  	
	$imagelist.= '<div class="col-xs-3 col-md-3 col-lg-3 col-xl"><a href="'.$image.'" class="thumbnail"><img src="'.$image.'" ></a></div>'.PHP_EOL;
	}
	$colcounter+=1;
}
if (($colcounter %3)  != 0) {$imagelist.= '</div>'.PHP_EOL;}

echo "<h3>Multi-Instrument Overlays</h3>".PHP_EOL;
echo $imagelist; //<<<<<
$imagelist='';
?>

<?php
$dirname = "../dynamic_data/EcoFOCI_Moorings/MooringVisualizations/$Year/$MooringID/ctd_cals/";
$images = glob($dirname."*.png");
$colcounter=0;

foreach($images as $image) {
	if (($colcounter %3)  == 0) {
		$imagelist.= '<div class="row">';
		$imagelist.= '<div class="col-xs-3 col-md-3 col-lg-3 col-xl"><a href="'.$image.'" class="thumbnail"><img src="'.$image.'" ></a></div>'.PHP_EOL;
  	}
	elseif (($colcounter %3)  == 2) {
		$imagelist.= '<div class="col-xs-3 col-md-3 col-lg-3 col-xl"><a href="'.$image.'" class="thumbnail"><img src="'.$image.'" ></a></div>'.PHP_EOL;
		$imagelist.= '</div>'.PHP_EOL;
  	}
  	else {  	
	$imagelist.= '<div class="col-xs-3 col-md-3 col-lg-3 col-xl"><a href="'.$image.'" class="thumbnail"><img src="'.$image.'" ></a></div>'.PHP_EOL;
	}
	$colcounter+=1;
}
if (($colcounter %3)  != 0) {$imagelist.= '</div>'.PHP_EOL;}

$dirname = "../dynamic_data/EcoFOCI_Moorings/MooringVisualizations/$Year/$MooringID/ctd_cal/";
$images = glob($dirname."*.png");
$colcounter=0;

foreach($images as $image) {
	if (($colcounter %3)  == 0) {
		$imagelist.= '<div class="row">';
		$imagelist.= '<div class="col-xs-3 col-md-3 col-lg-3 col-xl"><a href="'.$image.'" class="thumbnail"><img src="'.$image.'" ></a></div>'.PHP_EOL;
  	}
	elseif (($colcounter %3)  == 2) {
		$imagelist.= '<div class="col-xs-3 col-md-3 col-lg-3 col-xl"><a href="'.$image.'" class="thumbnail"><img src="'.$image.'" ></a></div>'.PHP_EOL;
		$imagelist.= '</div>'.PHP_EOL;
  	}
  	else {  	
	$imagelist.= '<div class="col-xs-3 col-md-3 col-lg-3 col-xl"><a href="'.$image.'" class="thumbnail"><img src="'.$image.'" ></a></div>'.PHP_EOL;
	}
	$colcounter+=1;
}
if (($colcounter %3)  != 0) {$imagelist.= '</div>'.PHP_EOL;}



echo "<h3>CTD Calibration Cast Overlays</h3>".PHP_EOL;
echo $imagelist; //<<<<<
$imagelist='';
?>

<?php
$dirname = "../dynamic_data/EcoFOCI_Moorings/MooringVisualizations/$Year/$MooringID/adcp/";
$images = glob($dirname."*.png");
$colcounter=0;

foreach($images as $image) {
	if (($colcounter %3)  == 0) {
		$imagelist.= '<div class="row">';
		$imagelist.= '<div class="col-xs-3 col-md-3 col-lg-3 col-xl"><a href="'.$image.'" class="thumbnail"><img src="'.$image.'" ></a></div>'.PHP_EOL;
  	}
	elseif (($colcounter %3)  == 2) {
		$imagelist.= '<div class="col-xs-3 col-md-3 col-lg-3 col-xl"><a href="'.$image.'" class="thumbnail"><img src="'.$image.'" ></a></div>'.PHP_EOL;
		$imagelist.= '</div>'.PHP_EOL;
  	}
  	else {  	
	$imagelist.= '<div class="col-xs-3 col-md-3 col-lg-3 col-xl"><a href="'.$image.'" class="thumbnail"><img src="'.$image.'" ></a></div>'.PHP_EOL;
	}
	$colcounter+=1;
}
if (($colcounter %3)  != 0) {$imagelist.= '</div>'.PHP_EOL;}



echo "<h3>ADCP Images</h3>".PHP_EOL;
echo $imagelist; //<<<<<
$imagelist='';
?>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../scripts/jquery_1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>