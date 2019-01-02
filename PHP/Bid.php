<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "SELECT * FROM bid WHERE passenger = '$_POST[email]' AND trip_date = '$_POST[date]' AND trip_time ='$_POST[time]' AND trip_driver = '$_POST[driver_email]' AND status='t'");

if (pg_num_rows($result) > 0) {
    $errno = 2;
}
else {
    $result = pg_query($db, "INSERT INTO bid VALUES ('$_POST[email]','$_POST[date]','$_POST[time]','$_POST[driver_email]',$_POST[bid_price],$_POST[people])");

    if ($result) {
        $errno = 0;
    } else {
        $result = pg_query($db, "UPDATE bid SET status='TRUE',bid_price='$_POST[bid_price]',people='$_POST[people]' WHERE passenger='$_POST[email]' AND trip_date='$_POST[date]' AND trip_time='$_POST[time]' AND trip_driver='$_POST[driver_email]'");
        if ($result) {
            $errno = 0;
        } else $errno = 1;
    }
}

$array = array('errno' => $errno);

echo json_encode($array);

?>