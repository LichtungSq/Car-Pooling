<?php

header("Content-type: text/html; charset=UTF-8");
include 'connect.php';

$bid = pg_query($db, "SELECT * FROM bid b WHERE b.trip_driver = '$_POST[driver]' AND b.trip_date = '$_POST[date]' 
			AND b.trip_time = '$_POST[time]' AND b.win_bid = 't' AND b.passenger <> ''$_POST[passenger]'");//already have successful bid
if(pg_num_rows($bid)>0 && $_POST[win] == '1') {//CHECK THE SYNTAX true?
    $errno = 1;
} else {
    $result = pg_query($db, "UPDATE bid SET bid_price = $_POST[price], people = $_POST[people], win_bid = '$_POST[win]' WHERE passenger = '$_POST[passenger]' AND trip_date = '$_POST[date]' AND trip_time = '$_POST[time]' AND trip_driver = '$_POST[driver]'");
    if ($result) {
        $errno = 0;
    }
    else {
        $errno = 2;
    }
}

$array = array('errno' => $errno);

echo json_encode($array);

?>