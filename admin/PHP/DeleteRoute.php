<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "DELETE FROM route WHERE date = '$_POST[date]' AND time = '$_POST[time]' 
	AND driver = '$_POST[driver]'");

if ($result) {
    $errno = 0;
} else {
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);

?>