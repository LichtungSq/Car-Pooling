<?php

header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$route = pg_query($db, "SELECT * FROM route");

$sum = pg_num_rows($route);

$i = 0;

while($row=pg_fetch_assoc($route)) 
{
    $arr[$i] -> origin = $row[origin];
    $arr[$i] -> destination = $row[destination];
    $arr[$i] -> date = $row[date];
    $arr[$i] -> time = $row[time];
    $arr[$i] -> driver = $row[driver];
    $arr[$i] -> car = $row[car];
    $arr[$i] -> price = $row[price];
    if ($row[status] == 't')
        $arr[$i] -> status = "NORMAL";
    else
        $arr[$i] -> status = "DELETED";
    $i = $i + 1;
}

$result -> total = $sum;
$result -> result = $arr;

echo json_encode($result);
?>