<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$route = pg_query($db, "SELECT r.origin,r.destination,r.date,r.time,r.price,r.driver,c.size  
                        FROM (route r INNER JOIN car c ON r.driver=c.owner AND r.car=c.number)
                        WHERE r.origin LIKE '%$_POST[origin]%'
                        AND r.destination LIKE '%$_POST[destination]%'
                        AND r.status = 't' 
                        AND r.driver <> '$_POST[email]'
                        AND NOT EXISTS (
                        SELECT * FROM bid b
      		                   WHERE b.trip_driver = r.driver
      		                   AND b.trip_date = r.date
    		                   AND b.trip_time = r.time
    		                   AND b.win_bid = 't')
                        ORDER BY date ASC, time ASC");


$i = 0;
$cur_time = date("Y-m-d H:i:s");

while($row=pg_fetch_assoc($route)) 
{
    $trip_time = $row[date]." ".$row[time];
    if(strtotime($trip_time) > strtotime($cur_time)){
        $arr[$i] -> origin = $row['origin'];
        $arr[$i] -> destination = $row['destination'];
        $arr[$i] -> date = $row['date'];
        $arr[$i] -> time = $row['time'];
        $arr[$i] -> price = $row['price'];
        $arr[$i] -> driver = $row['driver'];
        $arr[$i] -> car_size = $row['size'];
        $i++;
    }
}

$result -> total = $i;
$result -> result = $arr;

echo json_encode($result);
?>