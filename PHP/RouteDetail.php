<?php

header("Content-type: text/html; charset=UTF-8");
include 'connect.php';

$result = pg_query($db, "SELECT r.origin,r.destination,r.date,r.time,c.number,c.color,c.size,c.type,r.price  
                         FROM (route r INNER JOIN car c ON r.driver=c.owner AND r.car=c.number)
                         WHERE r.driver = '$_POST[email]'
                         AND r.date = '$_POST[date]'
                         AND r.time = '$_POST[time]'");

$total = pg_num_rows($result);

if($total == 1){

    $row=pg_fetch_assoc($result);

    $obj -> destination = $row[destination];
    $obj -> date = $row[date];
    $obj -> time = $row[time];
    $obj -> number = $row[number];
    $obj -> color = $row[color];
    $obj -> size = $row[size];
    $obj -> type = $row[type];
    $obj -> price = $row[price];
    $obj -> origin = $row[origin];
}

$array = array('total' => $total, 'result' => $obj);
echo json_encode($array);

?>