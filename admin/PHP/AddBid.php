<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$route = pg_query($db, "SELECT * FROM route r WHERE r.driver = '$_POST[driver]' AND r.date = '$_POST[date]' AND r.time = '$_POST[time]' AND r.status = 't'");//have this route

if(pg_num_rows($route)==0) {
	$errno = 2;
} else {
	$passanger = pg_query($db, "SELECT * FROM userinfo u WHERE u.email = '$_POST[passenger]'");
	if(pg_num_rows($passanger)==0) {
		$errno = 4;
	} else {
		$bid = pg_query($db, "SELECT * FROM bid b WHERE b.trip_driver = '$_POST[driver]' AND b.trip_date = '$_POST[date]' 
			AND b.trip_time = '$_POST[time]' AND b.win_bid = 't'");//already have successful bid
		if(pg_num_rows($bid)>0 && $_POST[win] == '1') {//CHECK THE SYNTAX true?
			$errno = 3;
		} else {
            $result = pg_query($db, "INSERT INTO bid VALUES ('$_POST[passenger]','$_POST[date]','$_POST[time]','$_POST[driver]',
					$_POST[price],$_POST[people],'$_POST[win]')");
            if ($result) {
                $errno = 0;
            } else {
                $result = pg_query($db, "UPDATE bid SET bid_price=$_POST[price],people=$_POST[people],win_bid='$_POST[win]',status='TRUE'
                        WHERE passenger='$_POST[passenger]' AND trip_date='$_POST[date]' AND trip_time='$_POST[time]' AND trip_driver='$_POST[driver]' AND status='f'");
                if ($result) {
                    $errno = 0;
                } else $errno = 1;
            }
		}
	}
}

$array = array('errno' => $errno);

echo json_encode($array);

?>