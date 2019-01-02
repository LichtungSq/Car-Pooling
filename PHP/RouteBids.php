<?php
header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "SELECT * FROM bid b, userinfo u
		WHERE b.passenger = u.email AND b.trip_date = '$_GET[date]'
		AND b.trip_time = '$_GET[time]' AND b.trip_driver = '$_GET[email]'");
$total = pg_num_rows($result);

#origin,destination,date,time,price,status(successful/fail/pending/finish),driver
$successful = 0;
for($i = 0; $i < $total; $i ++)
{
	$row=pg_fetch_assoc($result);
	if ($row[win_bid] == 't') {
		$status = "successful";
        $successful = 1;
        $arr[0] -> first_name = $row[first_name];
        $arr[0] -> last_name = $row[last_name];
        $arr[0] -> price = $row[bid_price];
        $arr[0] -> phone_number = $row[phone_number];
        $arr[0] -> people = $row[people];
        $arr[0] -> status = $status;
        $arr[0] -> passenger = $row[passenger];
	}
	else {
        $status = "";
	}
	$obj[$i] -> first_name = $row[first_name];
	$obj[$i] -> last_name = $row[last_name];
	$obj[$i] -> price = $row[bid_price];
	$obj[$i] -> phone_number = $row[phone_number];
	$obj[$i] -> people = $row[people];
	$obj[$i] -> status = $status;
    $obj[$i] -> passenger = $row[passenger];
}

$array = array('total' => $total, 'result' => $obj, 'successful' => $successful, 'passenger' => $arr);
echo json_encode($array);

?>