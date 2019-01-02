<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$route = pg_query($db, "SELECT * FROM route WHERE driver = '$_POST[email]' AND status = 't' ORDER BY date DESC, time DESC");

$i = 0;
$cur_time = date("Y-m-d H:i:s");
$type = $_POST[type];

while($row=pg_fetch_assoc($route)) 
{
    $bid = pg_query($db,"SELECT * FROM bid b
      		                   WHERE b.trip_driver = '$row[driver]'
      		                   AND b.trip_date = '$row[date]'
    		                   AND b.trip_time = '$row[time]'
    		                   AND b.win_bid = 't'");

    $trip_time = $row[date]." ".$row[time];
    if(pg_num_rows($bid) == 0)
    {
        if(strtotime($trip_time) > strtotime($cur_time))
            $status = "bidding";
        else
            $status = "failed";
    }
    else
    {
        if(strtotime($trip_time) > strtotime($cur_time))
            $status = "successful";
        else
            $status = "finished";
    }
    if ($type == 1 && $status != "successful") continue;
    if ($type == 2 && $status != "bidding") continue;
    if ($type == 3 && $status != "failed") continue;
    if ($type == 4 && $status != "finished") continue;

    $arr[$i] -> origin = $row[origin];
    $arr[$i] -> destination = $row[destination];
    $arr[$i] -> date = $row[date];
    $arr[$i] -> time = $row[time];
    $arr[$i] -> price = $row[price];
    $arr[$i] -> status = $status;

    $i++;
}

$result -> total = $i;
$result -> result = $arr;

echo json_encode($result);

?>