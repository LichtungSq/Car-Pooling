<?php
#status not finished
header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "SELECT * FROM userinfo");

$total = pg_num_rows($result);

for($i = 0; $i < $total; $i ++)
{
	$row = pg_fetch_assoc($result);
	$obj[$i] -> first_name = $row[first_name];
	$obj[$i] -> last_name = $row[last_name];
	$obj[$i] -> phone = $row[phone_number];
	$obj[$i] -> email = $row[email];
	$obj[$i] -> balance = $row[balance];

}
$array = array('total' => $total, 'result' => $obj);
echo json_encode($array);

?>
