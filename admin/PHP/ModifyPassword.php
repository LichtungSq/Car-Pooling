<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "SELECT * FROM admin u WHERE u.username = '$_POST[username]' AND u.password = '$_POST[oldpassword]'");

if (pg_num_rows($result) > 0) {

    $result = pg_query($db, "UPDATE admin SET password = '$_POST[newpassword]' WHERE username = '$_POST[username]'");

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