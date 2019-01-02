<?php

header("Content-type: text/html; charset=UTF-8");
session_start();
include 'connect.php';

$result = pg_query($db, "UPDATE bid SET status = 'FALSE' WHERE win_bid = 'f' AND passenger = '$_POST[passenger_email]' AND trip_date = '$_POST[date]' 
	AND trip_time = '$_POST[time]' AND trip_driver = '$_POST[driver_email]'");

if ($result) {
    $errno = 0;
} else {
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);

?>