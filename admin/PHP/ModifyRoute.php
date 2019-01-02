<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "UPDATE route 
                         SET origin='$_POST[origin]',destination='$_POST[destination]',car='$_POST[car]',price='$_POST[price]'
                         WHERE driver='$_POST[driver]' AND date='$_POST[date]' AND time='$_POST[time]'");

if ($result) $errno = 0;
else{
	$result_1 = pg_query($db,"SELECT * FROM car WHERE owner='$_POST[driver]' AND number='$_POST[car]' AND status='t'");
	if(pg_num_rows($result_1) == 0) $errno = 2;
    else $errno = 1;
}

$array = array('errno' => $errno);

echo json_encode($array);
?>