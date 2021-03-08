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
array("Home","../eFOCI_CTD_logs/index.php",0),
array("CTD Records","#",1),
array("Cruise Maps","../eFOCI_CTD_logs/cruisemaps.php",2),
array("List of Cruises","../eFOCI_CTD_logs/cruises.php",2),
array("Cruise Data Status (google sheet)","https://docs.google.com/spreadsheets/d/10DyJxc1-hMvtEzVSbN4Vupv_pRHcvImyAuRRgvya5Mc/edit?usp=sharing",3),

array("Historical Lines","#",1),
array("Location Tables of Historical Lines","../eFOCI_CTD_logs/historical_lines.php",0),
array("Bering Sea 70m Line","../eFOCI_CTD_logs/IconicLines/bering_70m_iconic_lines/bering_70m_iconic_lines_map.png",2),
array("Aleutian Islands","../eFOCI_CTD_logs/IconicLines/Aleutian_iconic_lines/Aleutian_iconic_lines_map.png",2),
array("Arctic","../eFOCI_CTD_logs/IconicLines/Arctic_iconic_lines/Arctic_iconic_lines_map.png",2),
array("ArcticEIS","../eFOCI_CTD_logs/IconicLines/arcticeis_iconic_lines/arcticeis_iconic_lines_map.png",2),
array("Unimak Box","../eFOCI_CTD_logs/IconicLines/Unimak_Box_iconic_lines/Unimak_Box_iconic_lines_map.png",3),
array("Vessels","../eFOCI_CTD_logs/vessels.php",0),
array("EPIC_Keys","../eFOCI_CTD_logs/epic_keys.php",0),
array("News","../eFOCI_CTD_logs/system_updates.php",0),
array("Quick Entry Links","#",1),
array("Add Cruise Log","../eFOCI_CTD_logs/ctdrecords.php",3)
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