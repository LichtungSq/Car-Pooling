<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "INSERT INTO userinfo VALUES ('$_POST[email]','$_POST[first_name]','$_POST[last_name]','$_POST[phone]','$_POST[password]',$_POST[balance])");

if ($result) {
    $errno = 0;
} else {
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);

?>