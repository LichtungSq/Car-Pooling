<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "DELETE FROM car WHERE number='$_POST[car_number]'");

if ($result) {
    $errno = 0;
} else {
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);
?>