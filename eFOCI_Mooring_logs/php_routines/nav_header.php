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
array("Home","../eFOCI_Mooring_logs/index.php",0),
array("Status","#",1),
array("Mooring Instrument Status","../eFOCI_Mooring_logs/status.php",2),
array("Instrument Deployment Timelines","../eFOCI_Mooring_logs/inst_timelines.php",3),
array("Instrumentation","#",1),
array("Instrument Database","../eFOCI_Mooring_logs/lastknownoperations_activeonly.php",2),
array("Instrument Event Builder","../eFOCI_Mooring_logs/eventrecord_builder.php",2),
array("Optodes and Fluor Availability","../eFOCI_Mooring_logs/optode_fluor_availability.php",2),
array("Instrument Maintenance Status","../eFOCI_Mooring_logs/instrument_maintenance.php",2),
array("OnLoan or Repair","../eFOCI_Mooring_logs/equipment_out.php",3),
array("Mooring Deployments","#",1),
array("Mooring Log Sheets","../eFOCI_Mooring_logs/mooring_landing.php",2),
array("Mooring Name Generator (google sheet)","https://docs.google.com/spreadsheets/d/1LbfEu7XOGR3BwJmvDEeVFPBelU_o9JvZNOa5JRiSYc0/edit?usp=sharing",2),
array("Mooring Reports","",4),
array("Current Mooring Location Summary","../eFOCI_Mooring_logs/mooring_deployed_location_summary.php",2),
array("Historical Mooring Location Summary","../eFOCI_Mooring_logs/mooring_location_summary.php",2),
array("Mooring Deployment Stats and Summary","../eFOCI_Mooring_logs/mooring_deployment_stats.php",2),
array("Mooring Deployment Timeline Summary","../Instrument_timeseries_charts/all_mooring_swimlane_js.php",2),
array("Bering Deployment Timeline Summary","../Instrument_timeseries_charts/BeringMooring_swimlane_js.php",2),
array("Chukchi Deployment Timeline Summary","../Instrument_timeseries_charts/ChukchiMooring_swimlane_js.php",2),
array("Complete Table of Mooring Deployments","../eFOCI_Mooring_logs/mooring_table.php",2),
array("Table of Mooring Official Locations (External)","https://www.pmel.noaa.gov/foci/foci_moorings/mooring_info/mooring_location_info.html",2),
array("RealTime Mooring Data","",4),
array("Dynamic M2 (Peggy) Plots Current","../dynamic_data/ArgosMooring/2021_peggybuoy.php",2),
array("Dynamic M2 (Peggy) Plots 2020","../dynamic_data/ArgosMooring/2020_peggybuoy.php",2),
array("Dynamic M2 (Peggy) Plots 2019","../dynamic_data/ArgosMooring/2019_peggybuoy.php",2),
array("Dynamic M2 (Peggy) Plots 2018","../dynamic_data/ArgosMooring/2018_peggybuoy.php",2),
array("Dynamic M2 (Peggy) Plots 2017","../dynamic_data/ArgosMooring/2017_peggybuoy.php",2),
array("Dynamic M2 (Peggy) Plots 2016","../dynamic_data/ArgosMooring/2016_peggybuoy.php",2),
array("Dynamic Met. Plots 2015","../dynamic_data/ArgosMooring/028882y2015_norangeselector.html",2),
array("Dynamic Met. Plots 2014","../dynamic_data/ArgosMooring/028882y2014_norangeselector.html",2),
array("Dynamic Met. Plots 2013","../dynamic_data/ArgosMooring/028882y2013_norangeselector.html",2),
array("Dynamic Met. Plots 2012","../dynamic_data/ArgosMooring/028882y2012_norangeselector.html",2),
array("Dynamic Met. Plots 2011","../dynamic_data/ArgosMooring/028882y2011_norangeselector.html",3),
array("Utilities","#",1),
array("Demo Mooring Quick Looks","../eFOCI_Mooring_logs/php_routines/MooringQuicklooks.php",2),
array("Mooring Status Summary","../eFOCI_Mooring_logs/utilities_summary_mooringdatastatus.php",2),
array("Mooring Instrument Data Status","../eFOCI_Mooring_logs/utilities_mooringdatastatus.php",2),
array("Find Nearest CTD","../eFOCI_Mooring_logs/findnearestctd.php",2),
array("Mooring Instrument IDs","../eFOCI_Mooring_logs/mooring_gear_ids.php",2),
array("EPIC KEY information","../eFOCI_Mooring_logs/epic_keys.php",3),
array("Quick Entry Links","#",1),
array("Update Moorings","../eFOCI_Mooring_logs/mooring_landing.php",2),
array("Update Deployed Instrument (Non-Mooring)","../eFOCI_Mooring_logs/equipment_out.php",2),
array("Add Calibration Record","../eFOCI_Mooring_logs/calibration_select.php",3),
array("News","../eFOCI_Mooring_logs/system_updates.php",0),
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