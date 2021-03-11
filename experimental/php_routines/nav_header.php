<?php
//bootstrap V3 Navigation Header
/* Populate the associative arrays with the desired pages */

function nav_labels() {

// Nav Label - column 1
// Nav link - column 2
// top level pages (0) should have their relative path, dropdown menus (1) should use '#' and
// labels with dropdown menus (2) should use ''
// pages should be in the order of the navigation with descriptions from dropdowns following
// the dropdown top level link


// Nav Heirarch - column3
// Navbar toplevel is 0, dropdowns are 1, dropdown links are 2
//  the last link in a dropdown is 3, and subheadings in dropdowns are 4

$nav_array = array(
array("Home","../experimental/index.php",0)
);



return $nav_array;

}

function build_navbar($isactive_label) {

    $nav_array = nav_labels();
    echo '      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://www.ecofoci.noaa.gov">EcoFOCI</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">'.PHP_EOL;

foreach ($nav_array as $key=>$value) {
    
    if ($value[2] == 0) { // top level
        if ($value[0] == $isactive_label) {
            echo '<li class="active"><a href="'.$value[1].'">'.$value[0].'</a></li>'.PHP_EOL;
        } else {
            echo '<li><a href="'.$value[1].'">'.$value[0].'</a></li>'.PHP_EOL;
        }        
    } elseif ($value[2] == 1) { //dropdown option
        echo '<li class="dropdown">
        <a href="'.$value[1].'" class="dropdown-toggle" data-toggle="dropdown">'.$value[0].' <b class="caret"></b></a>
        <ul class="dropdown-menu">'.PHP_EOL;
    } elseif ($value[2] == 2) { //dropdown link
        if ($value[0]  == $isactive_label) {
            echo '<li class="active"><a href="'.$value[1].'">'.$value[0].'</a></li>'.PHP_EOL;
        } else {
            echo '<li><a href="'.$value[1].'">'.$value[0].'</a></li>'.PHP_EOL;
        }        
    } elseif ($value[2] == 3) { //dropdown link last
        if ($value[0] == $isactive_label) {
            echo '<li class="active"><a href="'.$value[1].'">'.$value[0].'</a></li>
            </ul>
            </li>'.PHP_EOL;
        } else {
            echo '<li><a href="'.$value[1].'">'.$value[0].'</a></li>
            </ul>
            </li>'.PHP_EOL;
        }
    } elseif ($value[2] == 4) { //dropdown divider label
        echo '  <li class="divider"></li>
          <li class="dropdown-header">'.$value[0].'</li>'.PHP_EOL;    
    }
    } //end foreach

    echo '            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>'.PHP_EOL;


} //end build_navbar
?>