<?php

header("Content-type: text/html; charset=UTF-8");
session_start();
include 'connect.php';

$result = pg_query($db, "UPDATE userinfo SET first_name = '$_POST[first_name]', last_name = '$_POST[last_name]', 
	phone_number = '$_POST[phone]', balance = '$_POST[balance]' WHERE email = '$_POST[email]'");

if ($result) {
    $errno = 0;
} else {
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);

?>