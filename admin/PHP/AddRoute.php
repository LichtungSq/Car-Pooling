<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "INSERT INTO route VALUES ('$_POST[origin]','$_POST[destination]','$_POST[date]','$_POST[time]','$_POST[driver]','$_POST[car]','$_POST[price]')");

if ($result) $errno = 0;
else {
	$result_1 = pg_query($db,"SELECT * FROM userinfo WHERE email='$_POST[driver]'");
	if(pg_num_rows($result_1) == 0) $errno = 2;
	else {
	    $result_2 = pg_query($db,"SELECT * FROM car WHERE owner='$_POST[driver]' AND number='$_POST[car]' AND status='t'");
	    if(pg_num_rows($result_2) == 0) $errno = 3;
	    else {
            $result3 = pg_query($db, "UPDATE route SET origin='$_POST[origin]',destination='$_POST[destination]',car='$_POST[car]',price='$_POST[price]',status='TRUE' WHERE date='$_POST[date]' AND time='$_POST[time]' AND driver='$_POST[driver]' AND status='f'");
            if ($result3) $errno = 0;
            else {
                $result3 = pg_query($db, "SELECT * FROM route WHERE date='$_POST[date]' AND time='$_POST[time]' AND driver='$_POST[driver]' AND status='t'");
                if (pg_num_rows($result3) > 0) $errno = 1;
                else $errno = 4;
            }
	    }
	}
}

$array = array('errno' => $errno);

echo json_encode($array);
?>