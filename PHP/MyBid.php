<?php
header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "SELECT origin, destination, date, time, driver, bid_price, r.status, win_bid FROM bid b, route r 
		WHERE b.passenger = '$_POST[email]' AND b.trip_date = r.date 
		AND b.trip_time = r.time AND b.trip_driver = r.driver AND b.status='t' ORDER BY date DESC, time DESC");
$total = pg_num_rows($result);

$cur_time = date("Y-m-d H:i:s");
$type = $_POST[type];

#origin,destination,date,time,price,status(successful/fail/pending/finish),driver

$sum = 0;
for($i = 0; $i < $total; $i++)
{
	$row=pg_fetch_assoc($result);
	$trip_time = $row[date]." ".$row[time];
	if($row[status] == 'f')#route has been deleted
	{
		$status = "failed";
	}
	else if(strtotime($trip_time)<strtotime($cur_time) && $row[win_bid] == 't')
	{
		$status = "finished";
	}
	else if (strtotime($trip_time)>strtotime($cur_time) && $row[win_bid] == 't') { #CHECK THIS COMMAND
		$status = "successful";
	}
	else if (strtotime($trip_time)<strtotime($cur_time)) {
        $status = "failed";
    }
	else{
		$sameRouteResult = pg_query($db, "SELECT * FROM bid b WHERE b.trip_date = $row[date]
		AND b.trip_time = $row[time] AND b.trip_driver = $row[driver] AND b.win_bid = 't'");
		if(pg_num_rows($sameRouteResult) == 0)
		{
			$status = "pending";
		}
		else
		{
			$status = "failed";
		}
	}
	if ($type == 1 && $status != "successful") continue;
    if ($type == 2 && $status != "pending") continue;
    if ($type == 3 && $status != "failed") continue;
    if ($type == 4 && $status != "finished") continue;
	$obj[$sum] -> origin = $row[origin];
	$obj[$sum] -> destination = $row[destination];
	$obj[$sum] -> date = $row[date];
	$obj[$sum] -> time = $row[time];
	$obj[$sum] -> price = $row[bid_price];
	$obj[$sum] -> status = $status;
	$obj[$sum] -> driver = $row[driver];
	$sum++;
}

$array = array('total' => $sum, 'result' => $obj);
echo json_encode($array);

?>