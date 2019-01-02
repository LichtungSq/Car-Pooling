<?php

header("Content-type: text/html; charset=UTF-8");
session_start();
include 'connect.php';

$result = pg_query($db, "UPDATE userinfo SET phone_number = '$_POST[phone_number]' WHERE email = '$_POST[email]'");

if ($result) {
    $errno = 0;
} else {
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);

?>