<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "SELECT * FROM userinfo u WHERE u.email = '$_POST[email]' AND u.password = '$_POST[oldpassword]'");

if (pg_num_rows($result) > 0) {

    $result = pg_query($db, "UPDATE userinfo SET password = '$_POST[newpassword]' WHERE email = '$_POST[email]'");

    if ($result) {
        $errno = 0;
    } else {
        $errno = 2;
    }

} else {
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);

?>