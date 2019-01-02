<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "DELETE FROM bid WHERE passenger = '$_POST[passenger_email]' AND trip_date = '$_POST[date]' 
	AND trip_time = '$_POST[time]' AND trip_driver = '$_POST[driver_email]'");

if ($result) {
    $errno = 0;
} else {
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);

?>