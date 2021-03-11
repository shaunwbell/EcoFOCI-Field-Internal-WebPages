<?php

function carousel_images() {

//get list of images from backgrounds folder
$directory = '../ecofoci_images/saildrone/';
$scanned_directory = array_filter(scandir($directory), function($item) {
    return $item[0] !== '.';
});

$numpics = count($scanned_directory);

echo '<div id="carousel-foci" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-foci" data-slide-to="0" class="active"></li>'.PHP_EOL;
    
for ($imag_count=1; $imag_count<=$numpics; $imag_count++) {
    echo '    <li data-target="#carousel-foci" data-slide-to="'.$imag_count.'"></li>'.PHP_EOL;
}

echo '  </ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner">'.PHP_EOL;

$is_active = 0;  
foreach ($scanned_directory as $key => $value) {
    if ($is_active == 0) {
    echo '  <div class="item active">
          <img src="'.$directory.''.$value.'" alt="peggy">

        </div>'.PHP_EOL;
    $is_active = 1; 
    }
    else {
    echo '    <div class="item">
          <img src="'.$directory.''.$value.'" alt="'.$value.'">

        </div>'.PHP_EOL;
    }
}

echo '      </div>
      <!-- Controls -->
  <a class="left carousel-control" href="#carousel-foci" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-foci" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>'.PHP_EOL;

}

?>