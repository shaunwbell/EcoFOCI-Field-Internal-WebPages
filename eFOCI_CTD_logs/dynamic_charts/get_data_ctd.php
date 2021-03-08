<?php
function ctd_data($CruiseID, $ConsecutiveCastNo, $PlotParam, $DepthData) {
    $host = "localhost";
    $user = "pythonuser";
    $password = "e43mqS4fusEaGJLE";
    $db = "EcoFOCI_CTD_Data";

    $con = new mysqli($host,$user,$password, $db);

    if (mysqli_connect_errno()) {
        echo "Database connection failed ";
        exit();
    } 


    $query = "SELECT * from `".$CruiseID."` WHERE `ConsecutiveCastNo` = '".$ConsecutiveCastNo."';"; 
        
    $result = $con->query($query) or die($con->error.__LINE__);

    //echo 'Content-type: text/html; Charset=utf-8'.PHP_EOL;

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tempdata = explode(',',$row[$PlotParam]);
        $DepthData = explode(',',$row['DepthData']);
		if ($tempdata[0] === '' ) { $tempdata = $DepthData; }
    }
    foreach($DepthData as $key=>$value) {
        if ($tempdata[$key] >= 1e+35 ) { $tempdata[$key] = null; }

        //echo $tempdata2[$key].','.$tempdata[$key].','.$DepthData[$key].PHP_EOL;
        $data_plot[] = '['.number_format($tempdata[$key],5, '.', '').','.$DepthData[$key].'],'.PHP_EOL;

    }
    echo "</pre>".PHP_EOL;

    echo '<pre id="Title" style="display: none">'.$CruiseID.' '.$ConsecutiveCastNo.'</pre>'.PHP_EOL;

return $data_plot;
}
?>


