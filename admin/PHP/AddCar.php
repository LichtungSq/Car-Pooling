<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$passanger = pg_query($db, "SELECT * FROM userinfo u WHERE u.email = '$_POST[email]'");

if(pg_num_rows($passanger) == 0) $errno = 2;
else {
    $result1 = pg_query($db, "SELECT * FROM car WHERE number='$_POST[car_number]' AND status='t'");
    if (pg_num_rows($result1) > 0) $errno = 1;
    else {
        $result = pg_query($db, "INSERT INTO car VALUES ('$_POST[car_number]','$_POST[color]','$_POST[type]','$_POST[size]','$_POST[email]')");
        if ($result) $errno = 0;
        else {
            $result1 = pg_query($db, "UPDATE car SET color='$_POST[color]',type='$_POST[type]',size ='$_POST[size]',status='TRUE' WHERE number='$_POST[car_number]' AND status='f' AND owner='$_POST[email]'");
            if ($result1) $errno = 0;
            else $errno = 3;
        }
    }
}


$array = array('errno' => $errno);

echo json_encode($array);
?>