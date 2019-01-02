<?php
#status not finished
header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "SELECT * FROM bid");

$total = pg_num_rows($result);

for($i = 0; $i < $total; $i ++)
{

	$row = pg_fetch_assoc($result);
	$obj[$i] -> passenger = $row[passenger];
	$obj[$i] -> date = $row[trip_date];
	$obj[$i] -> time = $row[trip_time];
	$obj[$i] -> driver = $row[trip_driver];
	$obj[$i] -> price = $row[bid_price];
	$obj[$i] -> people = $row[people];

	if ($row[win_bid] == 'f')
		$obj[$i] -> win = "NOT WIN";
	else $obj[$i] -> win = "WIN";

    if ($row[status] == 't')
        $obj[$i] -> status = "NORMAL";
    else
        $obj[$i] -> status = "DELETED";

}

$array = array('total' => $total, 'result' => $obj);
echo json_encode($array);

?>


