<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$time = date("H:i:s",time());
$date = date("Y-m-d",time());

if (($_POST[date] == $date && $_POST[time] <= $time) || $_POST[date] < $date) $errno = 3;
else {
    $result1 = pg_query($db, "SELECT * FROM route WHERE date='$_POST[date]' AND time='$_POST[time]' AND driver='$_POST[driver]' AND status='t'");
    if (pg_num_rows($result1) > 0) $errno = 1;
    else {
        $result = pg_query($db, "INSERT INTO route VALUES ('$_POST[origin]','$_POST[destination]','$_POST[date]','$_POST[time]','$_POST[driver]','$_POST[car]','$_POST[price]')");
        if ($result) {
            $errno = 0;
        } else {
            $result = pg_query($db, "UPDATE route SET origin='$_POST[origin]',destination='$_POST[destination]',car='$_POST[car]',price='$_POST[price]',status='TRUE' WHERE date='$_POST[date]' AND time='$_POST[time]' AND driver='$_POST[driver]' AND status='f'");
            if ($result) {
                $errno = 0;
            } else {
                $errno = 2;
            }
        }
    }
}

$array = array('errno' => $errno);

echo json_encode($array);
?>