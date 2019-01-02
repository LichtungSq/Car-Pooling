<?php

header("Content-type: text/html; charset=UTF-8");
include 'connect.php';

$result_1 = pg_query($db,"SELECT * FROM userinfo WHERE email='$_POST[email]' AND password='$_POST[password]'");
if(pg_num_rows($result_1) > 0)
{
    $errno = 0;
}
else{
    $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);

?>