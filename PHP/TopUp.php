<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "UPDATE userinfo SET balance = balance + $_POST[money] WHERE email = '$_POST[email]'");

if ($result) {
    $errno = 0;
} else {
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);

?>