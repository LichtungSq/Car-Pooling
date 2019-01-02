<?php
#status not finished
header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "SELECT * FROM bid b, route r, userinfo u, car c
		WHERE b.trip_date = r.date AND b.trip_time = r.time AND b.trip_driver = r.driver 
		AND b.passenger = u.email
		AND r.driver = c.owner AND r.car = c.number
		AND b.passenger = '$_POST[email]' AND b.trip_driver = '$_POST[driver_email]' AND b.trip_date = '$_POST[date]' AND b.trip_time = '$_POST[time]'");

$total = pg_num_rows($result);

if($total == 1)
{
	#origin,destination,date,time,first_name,last_name,phone_number,car_number,car_color,car_type,car_size,people,price,driver_price
	$row=pg_fetch_assoc($result);
	$obj -> origin = $row[origin];
	$obj -> destination = $row[destination];
	$obj -> date = $row[date];
    $obj -> time = $row[time];
	$obj -> first_name = $row[first_name];
	$obj -> last_name = $row[last_name];
	$obj -> phone_number = $row[phone_number];
	$obj -> car_number = $row[number];
	$obj -> car_color = $row[color];
	$obj -> car_type = $row[type];
	$obj -> car_size = $row[size];
	$obj -> people = $row[people];
	$obj -> price = $row[bid_price];
	$obj -> driver_price = $row[price];
}

$array = array('total' => $total, 'result' => $obj);
echo json_encode($array);

?>

