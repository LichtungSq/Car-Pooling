<?php
header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$car = pg_query($db, "SELECT * FROM car");

$sum = pg_num_rows($result);

$i = 0;

while($row=pg_fetch_assoc($car)) 
{
    $arr[$i] -> number = $row[number];
    $arr[$i] -> size = $row[size];
    $arr[$i] -> color = $row[color];
    $arr[$i] -> type = $row[type];
    $arr[$i] -> owner = $row[owner];
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