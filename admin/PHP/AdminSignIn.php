<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "SELECT * FROM admin u WHERE u.username = '$_POST[email]' AND u.password = '$_POST[password]'");

if (pg_num_rows($result) > 0) {
    $errno = 0;
} else {
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);

?>