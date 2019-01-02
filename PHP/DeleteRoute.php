<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "UPDATE route SET status = 'FALSE' 
                                 WHERE driver = '$_POST[email]' 
                                 AND date = '$_POST[date]' 
                                 AND time = '$_POST[time]'");
if ($result) {
    $errno = 0;
} else {
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);

?>