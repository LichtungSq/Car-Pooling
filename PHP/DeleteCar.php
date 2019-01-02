<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$time = date("H:i:s",time());
$date = date("Y-m-d",time());

$result = pg_query($db, "SELECT * FROM route r,bid b WHERE r.date=b.trip_date AND r.time=b.trip_time AND r.driver=b.trip_driver AND r.status='t' AND b.win_bid='t' AND r.car='$_POST[car_number]' AND (r.date > '$date' OR (r.date = '$date' AND r.time > '$time'))");
if (pg_num_rows($result) > 0) {
    $errno = 1;
} else {
    $result = pg_query($db, "UPDATE car SET status = 'f' WHERE owner='$_POST[email]' AND number='$_POST[car_number]'");
    if ($result) {
        $errno = 0;
    } else {
        $errno = 1;
    }
}

$array = array('errno' => $errno);

echo json_encode($array);
?>