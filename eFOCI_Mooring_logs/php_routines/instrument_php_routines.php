<?php

include('utilities.php');

//database functions
function dbConnection($source_conf){
    include($source_conf);
    $con = new mysqli($host,$user,$password, $db);

    if (mysqli_connect_errno()) {
        echo "Database connection failed ";
        exit();
    } 
    return $con;
    }

function closeID($con){
    mysqli_close($con);
    }
    
/// list instrument status options
function view_instrument_servicestatus($servicestatus) {


    $con = dbConnection('../db_configs/db_config_inst.php');
    

    // get possible instruments from DB
    $con = dbConnection('../db_configs/db_config_inst.php');
    $query = "SELECT InstID, InstType, ServiceStatus, instrument_table, calibration_table 
                FROM (
                    select  InstID, InstType, ServiceStatus, 'inst_adcp' as instrument_table, 'cal_adcp' as calibration_table FROM inst_adcp
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_ecofluor' as instrument_table, 'cal_ecofluor' as calibration_table FROM inst_ecofluor
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_eppley' as instrument_table, 'cal_eppley' as calibration_table FROM inst_eppley
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_iceprof' as instrument_table, 'cal_iceprof' as calibration_table FROM inst_iceprof
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_licor' as instrument_table, 'cal_licor' as calibration_table FROM inst_licor
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_mtr' as instrument_table, 'cal_mtr' as instrument_table  FROM inst_mtr
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_nitrates' as instrument_table, 'cal_nitrates' as calibration_table FROM inst_nitrates
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_par' as instrument_table, 'cal_par' as instrument_table  FROM inst_par
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_pdim' as instrument_table, 'cal_pdim' as calibration_table FROM inst_pdim
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_rcm' as instrument_table, 'cal_rcm' as instrument_table  FROM inst_rcm
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_rcm_ancillary' as instrument_table, 'cal_rcm_ancillary' as calibration_table FROM inst_rcm_ancillary
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe16' as instrument_table, 'cal_sbe16' as calibration_table FROM inst_sbe16
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe19' as instrument_table, 'cal_sbe19' as calibration_table FROM inst_sbe19
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe26' as instrument_table, 'cal_sbe26' as calibration_table FROM inst_sbe26
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe3' as instrument_table, 'cal_sbe3' as calibration_table FROM inst_sbe3
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe37' as instrument_table, 'cal_sbe37' as calibration_table FROM inst_sbe37
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe38' as instrument_table, 'cal_sbe38' as calibration_table FROM inst_sbe38
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe39' as instrument_table, 'cal_sbe39' as calibration_table FROM inst_sbe39
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe4' as instrument_table, 'cal_sbe4' as calibration_table FROM inst_sbe4
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe43' as instrument_table, 'cal_sbe43' as calibration_table FROM inst_sbe43
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe49' as instrument_table, 'cal_sbe49' as calibration_table FROM inst_sbe49
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe5' as instrument_table, 'cal_sbe5' as calibration_table FROM inst_sbe5
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe56' as instrument_table, 'cal_sbe56' as calibration_table FROM inst_sbe56
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe49' as instrument_table, 'cal_sbe49' as calibration_table FROM inst_sbe49
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe56' as instrument_table, 'cal_sbe56' as calibration_table FROM inst_sbe56
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbe9' as instrument_table, 'cal_sbe9' as calibration_table FROM inst_sbe9
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_spn1' as instrument_table, 'cal_spn1' as calibration_table FROM inst_spn1
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_wetstarfluor' as instrument_table, 'cal_wetstarfluor' as calibration_table FROM inst_wetstarfluor
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_windsensors' as instrument_table, 'cal_windsensors' as calibration_table FROM inst_windsensors
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_wxsensors' as instrument_table, 'cal_wxsensors' as calibration_table FROM inst_wxsensors
                    where ServiceStatus LIKE '%$servicestatus%'
                    union all
                    select  InstID, InstType, ServiceStatus, 'inst_sbeprawler' as instrument_table, 'cal_sbeprawler' as calibration_table FROM inst_sbeprawler
                    where ServiceStatus LIKE '%$servicestatus%'
                    )t";

    $result = $con->query($query) or die($con->error.__LINE__);
  
    
    echo '<div class="table" ><table class="table table-condensed table-hover table-bordered ">
    <thead>
      <tr>
        <th>ID and Serial Number</th>
      </tr>
    </thead>
    <tbody>'.PHP_EOL;
    
    while($row = $result->fetch_array(MYSQLI_ASSOC)) {



        echo '<tr>
              <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['InstID'].'</td>'.PHP_EOL;        
       
    
    }

    echo '</tbody></table></div>'.PHP_EOL;


    closeID($con); 
}


//list details of Eco's
function view_fluorometer_details() {


  $con = dbConnection('../db_configs/db_config_inst.php');
  
  $query = "SELECT * FROM (SELECT f.MooringID, f.PostDeploymentNotes, f.deployed, f.recovered, f.InstID, f.Comments, f.ServiceStatus, f.ChannelNumber, f.channel_1, f.channel_2, f.channel_3, d.CalDate, d.InstID as ID FROM (
              SELECT a.MooringID, a.PostDeploymentNotes, a.deployed, a.recovered, c.InstID, c.Comments, c.ServiceStatus, c.ChannelNumber, c.channel_1, c.channel_2, c.channel_3 
                  FROM `ecofoci`.`mooringdeployedinstruments` a
                  RIGHT JOIN `ecofoci_instruments`.`inst_ecofluor` c ON
                  c.InstID = a.InstID WHERE `MooringID` NOT LIKE '9%' AND `MooringID` NOT LIKE 'F-' OR `MooringID` is NULL ORDER BY InstID, MooringID DESC limit 100000) AS f 
              left JOIN `ecofoci_instruments`.`cal_ecofluor` d ON
              f.InstID = d.InstID ORDER BY d.InstID, d.CalDate DESC limit 100000) as g group by InstID"   ;  

  $result = $con->query($query) or die($con->error.__LINE__);

  
  echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
  <thead>
    <tr>
      <th>ID and Serial Number</th>
      <th>Last Deployment </th>
      <th>Last Cal Date</th>
      <th>Last Deployment Notes</th>
      <th>Number of Channels</th>
      <th>Channel 1</th>
      <th>Channel 2 (if avail.)</th>
      <th>Channel 3 (if avail.)</th>
      <th>General Notes</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
  

  while($row = $result->fetch_array(MYSQLI_ASSOC)) {

    if ($row['ServiceStatus'] == 'RETIRED'){
      $row_class='danger';
      } elseif ($row['ServiceStatus'] == 'OTHER'){
      $row_class='danger';        
      } elseif (($row['ServiceStatus'] != 'RETIRED') and ($row['CalDate'] == '')){
      $row_class='active';
      } elseif (($row['ServiceStatus'] != 'RETIRED') and (days_since_date($row['CalDate']) > 1095)) {
      $row_class='info';
      } else {
      $row_class='';
      }    

      if (($row['ServiceStatus'] != 'RETIRED') and ($row['deployed'] == 'y') and ($row['recovered'] == '')) {
        $row_class='warning';
      }
            

      echo '<tr class='.$row_class.'>
          <td><a href="instrument_report.php?InstID='.$row['InstID'].'">'.$row['InstID'].'</td>
          <td><a href="mooring_record_view.php?mooringview_id='.$row['MooringID'].'">'.$row['MooringID'].'</td>
          <td><a href="calibration_report.php?InstID='.$row['InstID'].'&Caltable=cal_ecofluor">'.$row['CalDate'].'</td>
          <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['PostDeploymentNotes'].'</td>        
          <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['ChannelNumber'].'</td>        
          <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['channel_1'].'</td>        
          <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['channel_2'].'</td>        
          <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['channel_3'].'</td>        
          <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['Comments'].'</td></tr>'.PHP_EOL;        
    
  
  }    
  echo '</tbody></table></div>'.PHP_EOL;

  closeID($con); 
}
    
//list details of Oxygens
function view_optode_details() {


  $con = dbConnection('../db_configs/db_config_inst.php');
  
  $query = "SELECT * FROM (SELECT f.MooringID, f.PostDeploymentNotes, f.deployed, f.recovered, f.InstID, f.Comments, f.ServiceStatus, f.ResponseFoil, d.CalDate, d.InstID as ID FROM (
              SELECT a.MooringID, a.PostDeploymentNotes, a.deployed, a.recovered, c.InstID, c.Comments, c.ServiceStatus, c.ResponseFoil 
                  FROM `ecofoci`.`mooringdeployedinstruments` a
                  RIGHT JOIN `ecofoci_instruments`.`inst_rcm_ancillary` c ON
                  c.InstID = a.InstID WHERE `MooringID` NOT LIKE '9%' AND `MooringID` NOT LIKE 'F-' OR `MooringID` is NULL ORDER BY InstID, MooringID DESC limit 100000) AS f 
              left JOIN `ecofoci_instruments`.`cal_rcm_ancillary` d ON
              f.InstID = d.InstID ORDER BY d.InstID, d.CalDate DESC limit 100000) as g group by InstID"   ;  

  $result = $con->query($query) or die($con->error.__LINE__);

  
  echo '<div class="table-responsive" ><table class="table table-condensed table-hover table-bordered ">
  <thead>
    <strong>Needed Database Updates</strong>
    <p>- update SN on converted fast response units
      - update all existing cal records and puchase records
      - verify window color on Fast-Response units
    </p>
    <tr>
      <th>ID and Serial Number</th>
      <th>Last Deployment </th>
      <th>Last Cal Date</th>
      <th>Last Deployment Notes</th>
      <th>General Notes</th>
      <th>Foil Type</th>
    </tr>
  </thead>
  <tbody>'.PHP_EOL;
  
  while($row = $result->fetch_array(MYSQLI_ASSOC)) {

    if ($row['ServiceStatus'] == 'RETIRED'){
      $row_class='danger';
      } elseif ($row['ServiceStatus'] == 'OTHER'){
      $row_class='danger';        
      } elseif ($row['ServiceStatus'] == 'RETIRED'){
      continue;
      } elseif (($row['ServiceStatus'] != 'RETIRED') and ($row['CalDate'] == '')){
      $row_class='active';
      } elseif (($row['ServiceStatus'] != 'RETIRED') and (days_since_date($row['CalDate']) > 1095)) {
      $row_class='info';
      } else {
      $row_class='';
      }    

    if (($row['ServiceStatus'] != 'RETIRED') and ($row['deployed'] == 'y') and ($row['recovered'] == '')) {
      $row_class='warning';
    }

      echo '<tr class='.$row_class.'>
            <td><a href="instrument_report.php?InstID='.$row['InstID'].'">'.$row['InstID'].'</td>
            <td><a href="mooring_record_view.php?mooringview_id='.$row['MooringID'].'">'.$row['MooringID'].'</td>
            <td><a href="calibration_report.php?InstID='.$row['InstID'].'&Caltable=cal_rcm_ancillary">'.$row['CalDate'].'</td>
            <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['PostDeploymentNotes'].'</td>        
            <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['Comments'].'</td>     
            <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;white-space:normal">'.$row['ResponseFoil'].'</td></tr>'.PHP_EOL;        
      
  
  }

  echo '</tbody></table></div>'.PHP_EOL;


  closeID($con); 
}

?>