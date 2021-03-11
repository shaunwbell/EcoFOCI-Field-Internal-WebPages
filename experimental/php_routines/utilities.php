<?php

function echo_time() {
    // set the default timezone to use. Available since PHP 5.1
    date_default_timezone_set('UTC');
    
    echo '___'.date('Y-m-d G:i:s T').'___   '.PHP_EOL;
    echo ''.PHP_EOL;
    
}

function days_since_date($old_date) {

     date_default_timezone_set('UTC');
     $now = time(); // or your date as well
     $your_date = strtotime($old_date);
     $datediff = $now - $your_date;
     
     return (floor($datediff/(60*60*24)));

}


?>
