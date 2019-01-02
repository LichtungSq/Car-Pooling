<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "UPDATE car SET color='$_POST[color]',type='$_POST[type]',size='$_POST[size]' WHERE owner='$_POST[email]' AND number='$_POST[car_number]'");

if ($result) {
    $errno = 0;
} else {
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);
?>